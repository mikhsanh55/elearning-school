<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Aktivitas extends MY_Controller {



    function __construct() {

        parent::__construct();

        $this->db->query("SET time_zone='+7:00'");

        $waktu_sql = $this->db->query("SELECT NOW() AS waktu")->row_array();

        $this->waktu_sql = $waktu_sql['waktu'];

        $this->opsi = array("a","b","c","d","e");

	}

	



	public function cek_aktif() {

		if ($this->session->userdata('admin_valid') == false && $this->session->userdata('admin_id') == "") {

			redirect('login');

		} 

	}

	public function guru() {
		//var def uri segment

		$uri1 = $this->uri->segment(1);

		$uri2 = $this->uri->segment(2);

		$uri3 = $this->uri->segment(3);

		$uri4 = $this->uri->segment(4);





		//var def session

		$a['sess_level'] = $this->session->userdata('admin_level');

		$a['sess_user'] = $this->session->userdata('admin_user');

		$a['sess_konid'] = $this->session->userdata('admin_konid');

		$a['menu'] = $this->db->query("SELECT `nama_menu`, `link`, `icon` FROM rule_users JOIN menu ON rule_users.id_menu = menu.id JOIN level ON rule_users.id_level = level.id WHERE level = '".$a['sess_level']."' ")->result_array();

		$a['link'] = $this->db->query("SELECT link FROM rule_users JOIN menu ON rule_users.id_menu = menu.id JOIN level ON rule_users.id_level = level.id WHERE link = '".$uri1."/".$uri2."' AND level = '".$a['sess_level']."' ")->result_array();

		



		$this->load->view('dashboard/template/header', $a);

		$this->load->view('dashboard/template/navbar', $a);

		$this->load->view('aktivitas/list_guru', $a);

		$this->load->view('dashboard/template/footer', $a);
	}
    
	public function index() {
		redirect('aktivitas/siswa');
    }

    public function siswa() {
    	//var def uri segment

		$uri1 = $this->uri->segment(1);

		$uri2 = $this->uri->segment(2);

		$uri3 = $this->uri->segment(3);

		$uri4 = $this->uri->segment(4);





		//var def session

		$a['sess_level'] = $this->session->userdata('admin_level');

		$a['sess_user'] = $this->session->userdata('admin_user');

		$a['sess_konid'] = $this->session->userdata('admin_konid');

		$a['menu'] = $this->menu;

		// $a['link'] = $this->db->query("SELECT link FROM rule_users JOIN menu ON rule_users.id_menu = menu.id JOIN level ON rule_users.id_level = level.id WHERE link = '".$uri1."/".$uri2."' AND level = '".$a['sess_level']."' ")->result_array();

		



		$this->load->view('dashboard/template/header', $a);

		$this->load->view('dashboard/template/navbar', $a);

		$this->load->view('aktivitas/list', $a);

		$this->load->view('dashboard/template/footer', $a);

    }

    public function data_guru() {

    	$this->load->model('m_komen_materi');

    	$start = $this->input->post('start');
        $length = $this->input->post('length');
        $draw = $this->input->post('draw');
        $search = $this->input->post('search');

        if($this->log_lvl == 'instansi') {
        	$where = [

        		'guru.instansi' => 4,
        		"guru.nama LIKE '%" . $search['value'] . "%'" => NULL
        	];


        	$result = $this->db->select('guru.*, ins.instansi AS nama_instansi')
        						->from('m_guru guru')
        						->join('tb_instansi ins', 'guru.instansi = ins.id', 'left')
        						->order_by('guru.active_num', 'desc')
        						->limit($length, $start)
        						->where($where)
        						->get()
        						->result_array();
        	$num_rows = count($result);
        						
        }

        $data = [];
        $no = ($start+1);
        foreach ($result as $d) {

        	$this->db->where(['id_trainer' => $d['id']]);
        	$sum_komen = $this->db->get('tb_komen_materi')->num_rows();

            $data_ok = array();

            $data_ok[] = $no++;
            $data_ok[] = $d['nama'];
            $data_ok[] = $d['username'];
            $data_ok[] = $d['nidn'];
            $data_ok[] = $d['nrp'];
            $data_ok[] = $d['nama_instansi'];
            $data_ok[] = $d['semester'];


            $data_ok[] = '<div class="d-flex justify-content-center"><button type="button" class="btn btn-sm btn-primary ">' . $d['active_num'] . '</button></div>';
            $data_ok[] = '<div class="d-flex justify-content-center"><button type="button" class="btn btn-sm btn-primary ">' . $d['sum_upload_materi'] . '</button></div>';
            $data_ok[] = '<div class="d-flex justify-content-center"><button type="button" class="btn btn-sm btn-primary ">' . $d['sum_diskusi'] . '</button></div>';


            $data[] = $data_ok;
        }
        $json_data = array(

                    "draw" => $draw,

                    "iTotalRecords" => $num_rows,

                    "iTotalDisplayRecords" => $num_rows,

                    "data" => $data

                );

        j($json_data);

        exit;
    }

    public function data(){

    		$start = $this->input->post('start');

	        $length = $this->input->post('length');

	        $draw = $this->input->post('draw');

	        $search = $this->input->post('search');



	        if ($this->log_lvl == 'guru') {



	        	$where = array(

	        		'kls.id_trainer' => $this->log_id,

	        		"sis.nama LIKE '%".$search['value']."%'" => null

	        	);

	        	

	        	$q_datanya = $this->db->select(

	        							'sis.*'

	        							)

	        						  ->from('m_siswa sis')

									  ->join('tb_detail_kelas dekls','dekls.id_peserta = sis.id','left')

									  ->join('tb_kelas kls','kls.id = dekls.id_kelas','left')

	        						  ->group_by('sis.id','kls.id_trainer')

	        						  ->order_by(NULL,'sis.active_video + sis.active_read DESC')

	        						  ->limit($length,$start)

	        						  ->where($where)

	        						  ->get()

	        						  ->result_array();



	        	$d_total_row = count($q_datanya);



	        }else if($this->log_lvl != 'admin'){



	        	$d_total_row = $this->db->query("SELECT id FROM m_siswa a WHERE  a.instansi = ".$this->akun->instansi." AND a.nama LIKE '%".$search['value']."%'")->num_rows();

	    

	        	$q_datanya = $this->db->query("SELECT a.*,

											(SELECT COUNT(id) FROM m_admin WHERE level = 'siswa' AND kon_id = a.id) AS ada

											FROM m_siswa a

	                                        WHERE a.instansi = ".$this->akun->instansi." AND a.nama LIKE '%".$search['value']."%' ORDER BY a.active_video + a.active_read DESC LIMIT ".$start.", ".$length."")->result_array();

	        }else{

	        	$d_total_row = $this->db->query("SELECT id FROM m_siswa a WHERE a.nama LIKE '%".$search['value']."%'")->num_rows();

	    

	        	$q_datanya = $this->db->query("SELECT a.*,

											(SELECT COUNT(id) FROM m_admin WHERE level = 'siswa' AND kon_id = a.id) AS ada

											FROM m_siswa a

	                                        WHERE a.nama LIKE '%".$search['value']."%' ORDER BY a.active_video + a.active_read DESC LIMIT ".$start.", ".$length."")->result_array();

	        }



	        

	       

	        $data = array();

	        $no = ($start+1);



	        foreach ($q_datanya as $d) {

	            $data_ok = array();

	            $data_ok[] = $no++;

	            $data_ok[] = $d['nama'];

	            $data_ok[] = $d['nrp'];

	            $data_ok[] = $d['kelompok'];

	            $data_ok[] = '<div class="d-flex justify-content-center"><button type="button" class="btn btn-sm btn-primary ">' . $d['active_num'] . '</button></div>';

	            $total = $d['active_video'] + $d['active_read'];

	            $data_ok[] = '<div class="d-flex justify-content-center"><button type="button" class="btn btn-success btn-sm">'.$total.'</button></div>';



	            $data[] = $data_ok;

	        }



	        $json_data = array(

	                    "draw" => $draw,

	                    "iTotalRecords" => $d_total_row,

	                    "iTotalDisplayRecords" => $d_total_row,

	                    "data" => $data

	                );

	        j($json_data);

	        exit;

    }

    

    

}

