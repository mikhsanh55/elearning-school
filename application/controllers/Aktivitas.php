<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Aktivitas extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->db->query("SET time_zone='+7:00'");
        $waktu_sql = $this->db->query("SELECT NOW() AS waktu")->row_array();
        $this->waktu_sql = $waktu_sql['waktu'];
		$this->opsi = array("a","b","c","d","e");
    	$this->load->model('m_kelas');
		$this->load->model('m_admin');
        $this->load->model('m_mapel');
        $this->load->model('m_detail_kelas');
        $this->load->model('m_detail_kelas_mapel');
		$this->load->model('m_siswa');
		$this->load->model('m_admin_detail');
        $this->load->model('m_keaktifan_siswa');
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

		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');
		$a['menu'] = $this->menu;

		$where = [];
		
		// Get Semua kelas yang diajar oleh guru ybs
		if($this->log_lvl == 'guru') {
			$where['dmapel.id_guru'] = $this->log_id;
		}
		else if($this->log_lvl != 'guru' && $this->log_lvl != 'siswa'){
			$where = [];
		}
		$a['kelas'] = $this->m_kelas->get_guru_all($where);

		$this->load->view('dashboard/template/header', $a);

		$this->load->view('dashboard/template/navbar', $a);

		$this->load->view('aktivitas/list', $a);

		$this->load->view('dashboard/template/footer', $a);

    }

    public function data_guru() {
    	$start = $this->input->post('start');
        $length = $this->input->post('length');
        $draw = $this->input->post('draw');
        $search = $this->input->post('search');
        if($this->log_lvl == 'instansi') {
        	$where = [
        		'guru.instansi' => $this->akun->instansi,
        		"guru.nama LIKE '%" . $search['value'] . "%'" => NULL,
        		'guru.instansi' => $this->akun->instansi
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

            $data_ok = array();

            $data_ok[] = $no++;
            $data_ok[] = $d['nama'];
            $data_ok[] = $d['username'];
            $data_ok[] = $d['nidn'];

            $data_ok[] = '<div class="d-flex justify-content-center"><button type="button" class="btn btn-sm btn-primary ">' . $d['active_num'] . '</button></div>';
            $data_ok[] = '<div class="d-flex justify-content-center"><button type="button" class="btn btn-sm btn-success ">' . $d['sum_upload_ujian'] . '</button></div>';
            $data_ok[] = '<div class="d-flex justify-content-center"><button type="button" class="btn btn-sm btn-success ">' . $d['sum_upload_materi'] . '</button></div>';
            $data_ok[] = '<div class="d-flex justify-content-center"><button type="button" class="btn btn-sm btn-success ">' . $d['sum_diskusi'] . '</button></div>';

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
            $this->load->model('m_keaktifan_siswa');
            $this->load->model('m_detail_kelas_mapel');
    		$start = $this->input->post('start');

	        $length = $this->input->post('length');

	        $draw = $this->input->post('draw');

			$search = $this->input->post('search');

			$prop = $this->input->post('prop');
			$where = [];
			
	        if ($this->log_lvl != 'siswa') {

				if($this->log_lvl == 'guru') {
					$where = array(
						'dkls.id_guru' => $this->log_id,
					);
				}
				
				if($search['value'] != '' && !is_null($search['value'])) {
					$where["sis.nama LIKE '%".$search['value']."%'"] = NULL;
				}

				if(isset($prop['kelas']) && $prop['kelas'] != 0) {
					$where['dkls.id_kelas'] = $prop['kelas'];
				}

				$where['sis.instansi'] = $this->akun->instansi;

	        	$q_datanya = $this->db->select('sis.*, dkls.id_kelas')

	        						  ->from('m_siswa sis')

									  ->join('tb_detail_kelas dekls','dekls.id_peserta = sis.id','left')

									  ->join('tb_detail_kelas_mapel dkls','dkls.id_kelas = dekls.id_kelas','left')

	        						  ->order_by(NULL,'sis.active_video + sis.active_read DESC')

	        						  ->limit($length,$start)

	        						  ->where($where)

	        						  ->get()

									  ->result_array();

				// Set for pagination server side DataTable
				$total_data =  $this->db->select('sis.*, dkls.id_kelas')

	        						  ->from('m_siswa sis')

									  ->join('tb_detail_kelas dekls','dekls.id_peserta = sis.id','inner')

									  ->join('tb_detail_kelas_mapel dkls','dkls.id_kelas = dekls.id_kelas','inner')

	        						  ->order_by(NULL,'sis.active_video + sis.active_read DESC')

	        						  ->where($where)

	        						  ->get()

	        						  ->result_array();
				
	        	$d_total_row = count($total_data);



	        }else {

	        	$d_total_row = $this->db->query("SELECT id FROM m_siswa a WHERE  a.instansi = ".$this->akun->instansi." AND a.nama LIKE '%".$search['value']."%'")->num_rows();

				$kelas = '';

	        	$q_datanya = $this->db->query("SELECT a.*,

											(SELECT COUNT(id) FROM m_admin WHERE level = 'siswa' AND kon_id = a.id) AS ada

											FROM m_siswa a

	                                        WHERE a.instansi = ".$this->akun->instansi." AND a.nama LIKE '%".$search['value']."%' ORDER BY a.active_video + a.active_read DESC LIMIT ".$start.", ".$length."")->result_array();

			}
			
	        $data = array();

	        $no = ($start+1);

	        foreach ($q_datanya as $d) {
				if(isset($d['id_kelas'])) {
					$kelas = $this->m_kelas->get_by(['kls.id' => $d['id_kelas']]);
					$nama_kelas = !empty($kelas) ? $kelas->nama : 'Kosong';
				}
				else {
					$nama_kelas = 'Kosong';
				}

                if($this->log_lvl === 'guru') {
                    $id_mapel = $this->m_detail_kelas_mapel->get_by(['id_guru' => $this->akun->id]);
                    $id_mapel = $id_mapel->id_mapel;
                }
                else {
                    $id_mapel = NULL;
                }

                $sumLogin = $this->m_keaktifan_siswa->getSumKeaktifan([
                    'id_siswa' => $d['id'],
                    'type' => 'login'
                ]);
                
                $sumVideos = $this->m_keaktifan_siswa->getSumKeaktifan([
                    'id_siswa' => $d['id'],
                    'id_mapel' => $id_mapel,
                    'type' => 'video'
                ]);

                $sumRead = $this->m_keaktifan_siswa->getSumKeaktifan([
                    'id_siswa' => $d['id'],
                    'id_mapel' => $id_mapel,
                    'type' => 'read'
                ]);                

                $sumDiskusi = $this->m_keaktifan_siswa->getSumKeaktifan([
                    'id_siswa' => $d['id'],
                    'id_mapel' => $id_mapel,
                    'type' => 'diskusi'
                ]);

                $sumTugas = $this->m_keaktifan_siswa->getSumKeaktifan([
                    'id_siswa' => $d['id'],
                    'id_mapel' => $id_mapel,
                    'type' => 'tugas'
                ]);
				
	            $data_ok = array();

	            $data_ok[] = $no++;

	            $data_ok[] = $d['nama'];

	            $data_ok[] = $d['nrp'];

	            $data_ok[] = $nama_kelas;

	            $data_ok[] = '<div class="d-flex justify-content-center"><button type="button" class="btn btn-sm btn-success ">' . $sumLogin->sum . '</button></div>';

	            $total = $sumVideos->sum + $sumRead->sum;
	            $sumAll = $sumLogin->sum + $sumVideos->sum + $sumRead->sum + $sumDiskusi->sum + $sumDiskusi->sum;

	            $data_ok[] = '<div class="d-flex justify-content-center"><button type="button" class="btn btn-success btn-sm">'.$total.'</button></div>';

	            $data_ok[] = '<div class="d-flex justify-content-center"><button type="button" class="btn btn-success btn-sm">'.$sumDiskusi->sum.'</button></div>';

	            $data_ok[] = '<div class="d-flex justify-content-center"><button type="button" class="btn btn-success btn-sm">'.$sumTugas->sum.'</button></div>';

	            $data_ok[] = '<div class="d-flex justify-content-center"><button type="button" class="btn btn-primary btn-sm">'.$sumAll.'</button></div>';

            	// Detail AKtivitas siswa :
            	// $data_ok[] = '<div class="d-flex justify-content-center"><a href="'.base_url('aktivitas/detail-siswa/') . $this->encryption->encrypt($d['id']).'" class="btn btn-sm btn-primary ">Lihat Aktivitas</a></div>';

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

    /*
    * Untuk melihat aktivitas siswa ( kapan dia login dan logout )
    */
    public function detail_siswa($encrypt_id) {
    	$id = $this->encryption->decrypt($encrypt_id);
    	$data_user = $this->m_admin->get_by(['kon_id' => $id]);
    	$data_siswa = $this->m_siswa->get_by(['id' => $id]);

    	$activity = $this->m_admin_detail->get_many_by(['id_user' => $data_user->id]);
    	$data = [
    		'data_user' => $data_user,
    		'datas' => $activity,
    		'data_siswa' => $data_siswa
    	];

    	$this->render('aktivitas/detail_aktivitas', $data);
    }

    public function filter_aktivitas() {
    	$post = $this->input->post();
    	$html = '';
    	$where = [];
    	// From Date
    	if(($post['date1']) !== '' && $post['date2'] === '') {
    		$where["datetime > '" . $post['date1'] . "'"] = NULL;
    	}

    	if(($post['date1']) === '' && $post['date2'] !== '') {
    		$where["datetime < '" . $post['date2'] . "'"] = NULL;
    	}

    	if($post['date1'] !== '' && $post['date2'] !== '') {
    		$where["datetime BETWEEN '" . $post['date1'] . "' AND '" .$post['date2'] ."'"] = NULL;
    	}

    	$res = $this->m_admin_detail->get_many_by($where);
    	if( count($res) > 0) {
    		foreach($res as $data) {
    			$type = $data->type === 'login' ? 'text-primary' : ($data->type === 'logout' ? 'text-danger' : '');
    			$html .= '<tr> <td style="width: 3%;"> <i class="fas fa-circle '. $type .'"></i> </td> <td> '.ucfirst($data->type).' pada '. date_format(date_create($data->datetime), "d-m-Y") .' jam '. date_format(date_create($data->datetime), "H:i:s") .'</td> </tr>';
    		}
    	}
    	else {
    		$html .= '<tr> <td colspan="2" class="text-center">Tidak ada aktivitas</td> </tr>';
    	}

    	$this->sendAjaxResponse([
    		'status' => TRUE,
    		'data' => $html
    	], 200);
    }

    public function reset() {
    	$this->load->model('m_guru');
    	$this->load->model('m_siswa');
    	$post = $this->input->post();
    	$noValue = 0;
    	$update;

    	$this->db->trans_begin();
    	if($post['type'] === 'siswa') {
    		$data = [
    			'active_num' => $noValue,
    			'active_video' => $noValue,
    			'active_read' => $noValue,
    			'active_diskusi' => $noValue,
    			'active_tugas' => $noValue
    		];
    		$update = $this->m_siswa->update($data, ['instansi' => $this->akun->instansi]);
    	}
    	else if($post['type'] === 'guru') {
    		$data = [
    			'active_num' => $noValue,
    			'sum_upload_materi' => $noValue,
    			'sum_upload_ujian' => $noValue,
    			'sum_diskusi' => $noValue,
    		];

    		$update = $this->m_guru->update($data, ['instansi' => $this->akun->instansi]);
    	}
    	// print_r($this->db->last_query());exit;
    	
    	if($this->db->trans_status() === FALSE) {
    		$this->db->trans_rollback();
    	}
    	else {
    		$this->db->trans_commit();
    	}

    	if($update) {
    		$this->sendAjaxResponse([
    			'status' => TRUE,
    			'msg' => 'Data aktivitas ' . $post['type'] . 'berhasil direset'
    		], 200);
    	}
    	else {
    		$this->sendAjaxResponse([
    			'status' => FALSE,
    			'msg' => 'Data aktivitas ' . $post['type'] . 'gagal direset'
    		], 500);
    	}
    }

    /*
    * Function untuk mengambil data keaktifan siswa per mapel
    * return @json
    */
    public function detail_keaktifan_siswa()
    {
        $post = $this->input->post();
        $dataSiswa = $this->m_siswa->get_by(['id' => $post['siswa']]);
        $dataKelas = $this->m_detail_kelas->get_by(['id_peserta' => $post['siswa']]);
        $dataKelas = $this->m_kelas->get_by(['kls.id' => $dataKelas->id_kelas]);
        $dataMapel = $this->m_mapel->get_by(['id' => $post['mapel']]);
        // print_r($dataKelas);exit;

        $html = '<div class="container">
                    <header>
                        <h4>Nama Siswa : '.$dataSiswa->nama.'</h4>
                        <h4>Kelas : '.$dataKelas->nama.'</h4>
                        <h4>Mata Pelajaran : '.$dataMapel->nama.'</h4>
                    </header>    
                ';
        $sumLogin = $this->m_keaktifan_siswa->getSumKeaktifan([
            'id_siswa' => $post['siswa'],
            'type' => 'login'
        ]);

        $sumRead = $this->m_keaktifan_siswa->getSumKeaktifan([
            'id_siswa' => $post['siswa'],
            'id_mapel' => $post['mapel'],
            'type' => 'read'
        ]);

        $sumVideos = $this->m_keaktifan_siswa->getSumKeaktifan([
            'id_siswa' => $post['siswa'],
            'id_mapel' => $post['mapel'],
            'type' => 'video'
        ]);

        $sumDiskusi = $this->m_keaktifan_siswa->getSumKeaktifan([
            'id_siswa' => $post['siswa'],
            'id_mapel' => $post['mapel'],
            'type' => 'diskusi'
        ]);

        $sumTugas = $this->m_keaktifan_siswa->getSumKeaktifan([
            'id_siswa' => $post['siswa'],
            'id_mapel' => $post['mapel'],
            'type' => 'tugas'
        ]);

        $html .= '<table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">Jumlah Login</th>
                            <th class="text-center">Jumlah Download Materi</th>
                            <th class="text-center">Jumlah Tonton Video</th>
                            <th class="text-center">Keaktifan Diskusi</th>
                            <th class="text-center">Keaktifan Pengumpulan Tugas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">'. $sumLogin->sum .'</td>
                            <td class="text-center">'. $sumRead->sum .'</td>
                            <td class="text-center">'. $sumVideos->sum .'</td>
                            <td class="text-center">'. $sumDiskusi->sum .'</td>
                            <td class="text-center">'. $sumTugas->sum .'</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        ';

        $this->sendAjaxResponse([
            'status' => TRUE,
            'data' => $html
        ], 200);
    }
}

