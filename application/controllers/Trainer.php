<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trainer extends MY_Controller {

	public $validasi;
	public $page_title;

    function __construct() {
		parent::__construct();
		$this->load->model('m_guru');
		$this->load->model('m_siswa');
        $this->db->query("SET time_zone='+7:00'");
        $waktu_sql = $this->db->query("SELECT NOW() AS waktu")->row_array();
        $this->waktu_sql = $waktu_sql['waktu'];
        $this->opsi = array("a","b","c","d","e");
        $this->load->model('m_admin');
        $this->load->model('m_instansi');

        $this->load->library('validasi');

        $this->page_title = $this->transTheme->guru;

        $this->validasi = new Validasi();
	}
	
	public function get_servertime() {
		$now = new DateTime(); 
        $dt = $now->format("M j, Y H:i:s O"); 

        j($dt);
	}

	public function cek_aktif() {
		if ($this->session->userdata('admin_valid') == false && $this->session->userdata('admin_id') == "") {
			redirect('login');
		} 
	}

	public function index()
	{	

		$data = array(
			'searchFilter' => array('Modul Pelatihan','Keterangan')
		);
		$this->render_siswa('pengajar/daftar',$data);
	}

	public function reset_password() {
		$id = $this->encryption->decrypt($this->input->post('encrypt_id'));
		$data = [
			'password' => $this->encryption->encrypt($this->input->post('password'))
		];

		$update = $this->m_admin->update($data, ['id' => $id]);

		if($update) {
			$this->sendAjaxResponse([
				'status' => TRUE,
				'msg' => 'Password berhasil direset!'
			], 200);
		}
		else {
			$this->sendAjaxResponse([
				'status' => FALSE,
				'msg' => 'Gagal Reset Password'
			], 500);
		}
		
	}
    
	public function m_guru() {
		$this->cek_aktif();
			
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
		$post = $this->input->post();

		//var post from json
		$p = json_decode(file_get_contents('php://input'));
		//return as json
		$jeson = array();
		// $photo = $this->input->post('photo');
		/*
		$a['data'] = $this->db->query("SELECT m_guru.*,
									(SELECT COUNT(id) FROM m_admin WHERE level = 'guru' AND kon_id = m_guru.id) AS ada
									FROM m_guru")->result();
		*/

		if ($uri3 == "det") {
			$a = $this->db->query("SELECT * FROM m_guru WHERE id = '$uri4'")->row();
			j($a);
			exit();
		} else if ($uri3 == "simpan") {
			

			if($post['id'] > 0 ){

				$cek_username = $this->validasi->check_username($post['username'],'update','guru',$post['id']);
				$cek_email 	  = $this->validasi->check_email($post['email'],'update','guru',$post['id']);

				if($cek_email >0 ){
					$ket = "edit";
					$ret_arr['status'] 	= "gagal";
					$ret_arr['caption']	= "Email Sudah Ada";
					j($ret_arr);
					exit();
				
				}else if($cek_username > 0){
					$ket = "edit";
					$ret_arr['status'] 	= "gagal";
					$ret_arr['caption']	= "username Sudah Ada";
					j($ret_arr);
					exit();

				}else{
						$data = [
							'nidn'  =>  $post['nidn'],
							'nrp'  => $post['nrp'],
							'id_mapel'	=> $post['mapel'],
							'nama' => $post['nama'],
							'username' => $post['username'],
							'email'  => $post['email'],
							'no_telpon'  => $post['telp'],
							'instansi' => $this->akun->instansi,
						];  				

						$this->db->where('id', $post['id']);
						$this->db->update('m_guru', $data);

						$cek_adm = $this->db->where(array('level'=>'guru','kon_id'=>$post['id']))->get('m_admin')->result();
						if (count($cek_adm) > 0) {
							$data_adm = array(
								'user_id'  => $post['username'],
								'username' => $post['email'] 
							);
							$this->db->update('m_admin',$data_adm,array('level'=>'guru','kon_id'=>$post['id']));
						}

						$ket = "edit";
						$ret_arr['status'] 	= "ok";
						$ret_arr['caption']	= $ket." sukses";
						j($ret_arr);
						exit();
					}

		}else if($post['id'] == 0){


			$cek_username = $this->validasi->check_username($post['username'],'insert');
			$cek_email 	  = $this->validasi->check_email($post['email'],'insert');

				if ($cek_email > 0){
					$ket = "edit";
					$ret_arr['status'] 	= "gagal";
					$ret_arr['caption']	= "Email Sudah Ada";
					j($ret_arr);
					exit();
				
				}else if($cek_username > 0){
					$ket = "edit";
					$ret_arr['status'] 	= "gagal";
					$ret_arr['caption']	= "username Sudah Ada";
					j($ret_arr);
					exit();
				}else{


				$data = [
					'nidn'  =>  $post['nidn'],
					'nrp'  => $post['nrp'],
					'id_mapel'	=> $post['mapel'],
					'nama' => $post['nama'],
					'username' => $post['username'],
					'email'  => $post['email'],
					'no_telpon'  => $post['telp'],
					'instansi' => $this->akun->instansi,
				];  
				$this->db->insert('m_guru', $data);

				$inserted_id = $this->db->insert_id();
				$check_login = $this->m_admin->get_many_by(['kon_id' => $inserted_id]);
				$kon_ids = [];
				if(count($check_login) > 0) {
					foreach($check_login as $data) {
						$kon_ids[] = $data->kon_id;
					}
				}

				$this->db->where_in('kon_id',$kon_ids)->delete('m_admin');

                $data_admin = [
                    'user_id'  => $post['username'],
                    'username' => $post['email'],
                    'password'  => $this->encryption->encrypt($post['username'],),
                    'level'    => 'guru',
                    'kon_id'   => $inserted_id
                ];

                $this->db->insert('m_admin', $data_admin);
				$ket = "tambah";
				$ret_arr['status'] 	= "ok";
				$ret_arr['caption']	= $ket." sukses";
				j($ret_arr);
				exit();

			}


		}



						
				
			

		} else if ($uri3 == "hapus") {
			$this->db->query("DELETE FROM m_guru WHERE id = '".$uri4."'");
			$this->db->query("DELETE FROM m_admin WHERE level = 'guru' AND kon_id = '".$uri4."'");
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "hapus sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "user") {
			$det_user = $this->m_guru->get_by(array('id'=>$uri4));

			if (!empty($det_user)) {

				$q_cek_username = $this->m_admin->count_by(array('username'=>$det_user->username,'level'=>'guru'));

				if ($q_cek_username < 1) {

					$data_adm = array(
						'user_id' => $det_user->username,
						'username' => $det_user->email, 
						'password' => $this->encryption->encrypt($det_user->username), 
						'level' => 'guru', 
						'kon_id' => $det_user->id, 
						'status' => 0, 
					);

					$this->db->insert('m_admin',$data_adm);


					$ret_arr['status'] 	= "ok";
					$ret_arr['caption']	= "tambah user sukses";
					j($ret_arr);
				} else {
					$ret_arr['status'] 	= "gagal";
					$ret_arr['caption']	= "Username telah digunakan";
					j($ret_arr);					
				}
			} else {
				$ret_arr['status'] 	= "gagal";
				$ret_arr['caption']	= "tambah user gagal";
				j($ret_arr);
			}
			exit();
		} else if ($uri3 == "user_reset") {
			$det_user = $this->m_guru->get_by(array('id'=>$uri4));
			$dat_trainer = array('user_id' => $det_user->username,'password'=> $this->encryption->encrypt($det_user->username) );
			$this->m_admin->update($dat_trainer,array('level'=>'guru','kon_id'=>$det_user->id));
	


			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "Update password sukses ";
			j($ret_arr);

			exit();
		} else if ($uri3 == "ambil_matkul") {
			$where = array();
			if ($this->log_lvl 	= 'admin') {
				$where['id_instansi'] = $this->akun->instansi;
			}
			$matkul = $this->db->select("m_mapel.*,
										(SELECT COUNT(id) FROM tr_guru_mapel WHERE id_guru = ".$uri4." AND id_mapel = m_mapel.id) AS ok
								 ")
								->from('m_mapel')
								->where($where)
								->get()
								->result();
			$ret_arr['status'] = "ok";
			$ret_arr['data'] = $matkul;
			j($ret_arr);
			exit;
		} else if ($uri3 == "simpan_matkul") {
			$ket 	= "";
			//echo var_dump($p);
			$ambil_matkul = $this->db->query("SELECT id FROM m_mapel ORDER BY id ASC")->result();
			if (!empty($ambil_matkul)) {
				foreach ($ambil_matkul as $a) {
					$p_sub = "id_mapel_".$a->id;
					if (!empty($p->$p_sub)) {
						
						$cek_sudah_ada = $this->db->query("SELECT id FROM tr_guru_mapel WHERE  id_guru = '".$p->id_mhs."' AND id_mapel = '".$a->id."'")->num_rows();
						
						if ($cek_sudah_ada < 1) {
							$this->db->query("INSERT INTO tr_guru_mapel VALUES (null, '".$p->id_mhs."', '".$a->id."')");
						} else {
							$this->db->query("UPDATE tr_guru_mapel SET id_mapel = '".$p->$p_sub."' WHERE id_guru = '".$p->id_mhs."' AND id_mapel = '".$a->id."'");
						}
					} else {
						//echo "0<br>";
						$this->db->query("DELETE FROM tr_guru_mapel WHERE id_guru = '".$p->id_mhs."' AND id_mapel = '".$a->id."'");
					}
				}
			}
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $ket." sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "data") {
	
			$start = $this->input->post('start');
	        $length = $this->input->post('length');
	        $draw = $this->input->post('draw');
	        $search = $this->input->post('search');

	       
	     if($this->session->userdata('admin_level') == "admin" || $this->session->userdata('admin_level') == "guru"){
	        $q_datanya = $this->db->query("SELECT a.*,
											(
											SELECT COUNT(id) FROM m_admin WHERE level = 'guru' AND kon_id = a.id) AS ada
											FROM m_guru a
	                                        WHERE a.nama LIKE '%".$search['value']."%' ORDER BY a.id DESC LIMIT ".$start.", ".$length."")->result_array();

			}else{
	                            $q_datanya = $this->db->select("
	        							gr.*,
	        							(SELECT COUNT(id) FROM m_admin WHERE level = 'guru' AND kon_id = gr.id) as ada
	        					  ")
	        					  ->from('m_guru gr')
	        					  ->join('tr_guru_mapel grm','grm.id_guru=gr.id','left')
	        					  ->join('tb_materi_instansi ins','ins.id_mapel=grm.id_mapel','left')
	        					  ->where(array("nama LIKE '%".$search['value']."%'"=>null))
	        					  ->where('ins.id_instansi',$this->akun->instansi)
	        					  ->limit($length,$start)
	        					  ->order_by('gr.id','DESC')
	        					  ->group_by('gr.id')
	        					  ->get()
	        					  ->result_array();
	        }
	       
	        $d_total_row = count($q_datanya);
	        					  
	        $data = array();
	        $no = ($start+1);
	        

	        foreach ($q_datanya as $d) {
	            $data_ok = array();
	            $data_ok[0] = $no++;
	            $data_ok[1] = $d['nama'];
	            $data_ok[2] = $d['nidn'];
	            if($this->session->userdata('admin_level') == "admin"){
	       
	            $data_ok[3] = '<div class="btn-group">
                          <a href="#" onclick="return m_guru_e('.$d['id'].');" class="btn btn-info btn-sm mr-2"><i class="glyphicon glyphicon-pencil" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Edit</a>
                          <a href="#" onclick="return m_guru_h('.$d['id'].');" class="btn btn-danger btn-sm mr-2"><i class="glyphicon glyphicon-remove" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Hapus</a>
                          <a href="#" onclick="return m_guru_matkul('.$d['id'].');" class="btn btn-success btn-sm mr-2"><i class="glyphicon glyphicon-th-list" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Modul Dikuasai</a>
                          
                         ';

                    if ($d['ada'] == "0") {
                      $data_ok[3] .= '<a href="#" onclick="return m_guru_u('.$d['id'].');" class="btn btn-info btn-sm mr-2"><i class="glyphicon glyphicon-user" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Aktif User</a>';
                    } else {
                      $data_ok[3] .= '<a href="#" onclick="return m_guru_ur('.$d['id'].');" class="btn btn-warning btn-sm mr-2"><i class="glyphicon glyphicon-random" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Reset Pass</a>';
                    }
	            }else{
	                 $data_ok[3] = '<a href="#" onclick="return m_guru_detail('.$d['id'].');" class="btn btn-primary btn-sm mr-2"><i class="glyphicon glyphicon-th-list" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Lihat Profil</a>';
	            }
	           


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
		} else if ($uri3 == "import") {
			$a['p']	= "f_guru_import";
		} else if ($uri3 == "aktifkan_semua") {
			$q_get_user = $this->db->query("select 
								a.id, a.nama, a.nidn, ifnull(b.username,'N') usernya
								from m_guru a 
								left join m_admin b on concat(b.level,b.kon_id) = concat('guru',a.id)")->result_array();
			$jml_aktif = 0;
			if (!empty($q_get_user)) {
				foreach ($q_get_user as $j) {
					if ($j['usernya'] == "N") {
						$this->db->query("INSERT INTO m_admin VALUES (null, '".$j['nidn']."', md5('".$j['nidn']."'), 'guru', '".$j['id']."')");
						$jml_aktif++;
					}
				}
			}

			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $jml_aktif." user diaktifkan";
			j($ret_arr);
			exit();

		} else {
			$a['p']	= "m_guru";
		}
		$a['jenis'] = $this->db->get('kelamin')->result_array();
		$this->load->view('dashboard/template/header', $a);
		$this->load->view('dashboard/template/navbar', $a);
		$this->load->view('dashboard/admin/datatrainer', $a);
		$this->load->view('dashboard/template/footer', $a);
	}

	public function data(){
		$this->load->model('m_jurusan');
		$this->load->model('m_mapel');
		$instansi = ($this->log_lvl == 'admin') ? $this->m_instansi->get_all() : $this->m_instansi->get_by(array('id'=>$this->akun->instansi));
		$data = array(
			'instansi' => $instansi, 
			'searchFilter' => array('Nama','Username','NUPTK','NIP'),
			'kelas'   => $this->m_jurusan->get_many_by(['id_instansi' => $this->akun->instansi]),
			'mapel'		=> $this->m_mapel->get_many_by(['id_instansi' => $this->akun->instansi])
		);
		$this->render('pengajar/list',$data);
	}

	public function page_load($pg = 1){
		$post = $this->input->post();
		$limit = $post['limit'];
		$where = [];
		if (!empty($post['search'])) {
			switch ($post['filter']) {
				case 0:
					$where["(lower(`guru`.`nama`) like '%".strtolower($post['search'])."%' )"] = null;
					break;
				case 1:
					$where["(lower(username) like '%".strtolower($post['search'])."%' )"] = null;
					break;
				case 2:
					$where["(lower(nidn) like '%".strtolower($post['search'])."%' )"] = null;
					break;
				case 3:
					$where["(lower(nrp) like '%".strtolower($post['search'])."%' )"] = null;
					break;
				default:
					# code...
					break;
			}
		}

		if ($this->log_lvl != 'admin') {
			$where['instansi'] = $this->akun->instansi;
		}

		$paginate = $this->m_guru->paginate($pg,$where,$limit);
		foreach ($paginate['data'] as $key => $value) {
			$value->password = $this->encryption->decrypt($value->password);
		}
		$data['paginate'] = $paginate;
		$data['paginate']['url']	= 'trainer/page_load';
		$data['paginate']['search'] = 'lookup_key';
		$data['page_start'] = $paginate['counts']['from_num'];

		$this->load->view('pengajar/table',$data);
		$this->generate_page($data);
	}


	public function page_load_siswa($pg = 1){
		$post = $this->input->post();
		$limit = 6;
		$where = [];


		$where = [
			'id_peserta'	=> $this->akun->id,
			'kls.id_instansi'	=> $this->akun->instansi
		];

		$paginate = $this->m_siswa->paginate_kelas($pg,$where,$limit);

		$data['paginate'] = $paginate;
		$data['paginate']['url']	= 'tugas_siswa/page_load';
		$data['paginate']['search'] = 'lookup_key';
		$data['page_start'] = $paginate['counts']['from_num'];

		$data['paging'] = $this->gen_paging($data['paginate']);

		$this->load->view('pengajar/data',$data);
	}

	public function multi_delete(){
		$post = $this->input->post();

		foreach ($post['id'] as $val) {
			$where[] = $val;
		}

		$kirim = $this->db->where_in('id',$where)->delete('m_guru');
		$kirim = $this->db->where_in('kon_id',$where)->where_in('level','guru')->delete('m_admin');
        // Hapus rank
        $kirim = $this->db->where_in('id_trainer', $where)->delete('tb_rank');

		if ($kirim) {
			$result = true;
		}else{
			$result = false;
		}

		echo json_encode(array('result'=>$result));
	}

	public function import(){
		$this->render('pengajar/guru_import');
	}

}