<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengusaha extends MY_Controller {

	public $validasi;
	public $nrp = 'NRP';
    function __construct() {
        parent::__construct();
        $this->db->query("SET time_zone='+7:00'");
        $waktu_sql = $this->db->query("SELECT NOW() AS waktu")->row_array();
        $this->waktu_sql = $waktu_sql['waktu'];
        $this->opsi = array("a","b","c","d","e");
        $this->load->model('m_instansi');
        $this->load->model('m_guru');
        $this->load->model('m_siswa');
		$this->load->model('m_admin');
		$this->load->model('m_jurusan');
		$this->load->model('m_kelas');
		$instansi = $this->m_instansi->get_by(['id' => $this->akun->instansi]);
		if($instansi != NULL) {
			if($instansi->instansi === 'SESKOAL' || 'STT AL') {
				$this->nrp = 'NRP';
			}
			else {
				$this->nrp = 'No AK';
			}
		}

        $this->load->library('validasi');

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

	public function reset_password() {
		$id = $this->encryption->decrypt($this->input->post('encrypt_id'));
		$data = [
			'password' => $this->encryption->encrypt($this->input->post('password'))
		];
		// print_r($this->encryption->decrypt($this->input->post('encrypt_id')));exit;
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


    public function get_provinsi() 
	{
	    $this->db->select('*')
                 ->from('inf_lokasi')
                 ->where('lokasi_kabupatenkota', 0)
                 ->where('lokasi_kecamatan', 0)
                 ->where('lokasi_kelurahan', 0)
                 ->order_by('lokasi_nama', 'asc');
        $result = $this->db->get()->result();
        return $result;
	}
	
	public function get_kecamatan()
	{
	    if(empty($this->input->post('id_kota')) || !$this->input->post('id_provinsi')) {
	       $data = [
	         'status' => FALSE,
	         'msg'    => 'Parameter not found'
	       ];
	       
	       echo json_encode($data);
	       http_response_code(400); 
	    }
	    else {
	       $this->db->select('*')
	                ->from('inf_lokasi')
	                ->where('lokasi_propinsi', $this->input->post('id_provinsi'))
	                ->where('lokasi_kecamatan !=', 0)
	                ->where('lokasi_kelurahan', 0)
	                ->where('lokasi_kabupatenkota', $this->input->post('id_kota'))
	                ->order_by('lokasi_nama', 'asc');
	       $res = $this->db->get()->result();
	       
	       $data = [
	         'status' => TRUE,
	         'msg'    => 'There',
	         'res'    => $res
	       ];
	       
	       echo json_encode($data);
	       http_response_code(200); 
	    }
	}
	
	public function get_kota()
	{
	   if(empty($this->input->post('id_provinsi')) || !$this->input->post('id_provinsi')) {
	       $data = [
	         'status' => FALSE,
	         'msg'    => 'Parameter not found'
	       ];
	       
	       echo json_encode($data);
	       http_response_code(400);
	   }
	   else {
	       $this->db->select('*')
	                ->from('inf_lokasi')
	                ->where('lokasi_propinsi', $this->input->post('id_provinsi'))
	                ->where('lokasi_kecamatan', 0)
	                ->where('lokasi_kelurahan', 0)
	                ->where('lokasi_kabupatenkota !=', 0)
	                ->order_by('lokasi_nama', 'asc');
	       $res = $this->db->get()->result();
	       
	       $data = [
	         'status' => TRUE,
	         'msg'    => 'There',
	         'res'    => $res
	       ];
	       
	       echo json_encode($data);
	       http_response_code(200);
	   }
	}


    
	public function m_siswa() {
		$this->cek_aktif();
		cek_hakakses(array("admin",'instansi','admin_instansi'), $this->session->userdata('admin_level'));
		
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

		
		//var post from json
		$p = (object)$this->input->post();
		
		//return as json
		$json = array();
		//$a['data'] = $this->db->query("")->result();
		
		if ($uri3 == "det") {
	
			$siswa = $this->m_siswa->get_by(array('id'=>$uri4));
			j($siswa);
			exit();
			
		} else if ($uri3 == "simpan") {
			$ket 	= "";
			$file_name = NULL;
			if (!empty($_FILES['photo']['name'])) {

				$file     = stripcslashes($_FILES['photo']['name']);
				$namafile = DATE('d-m-Y') . "-" . time() . "-" . str_replace(" ", "_", $file);
	
				$config['upload_path']   = 'upload/siswa_photo/';
				$config['allowed_types'] = 'jpg|jpeg|png';
				$config['max_size']      = 222220480;
				$config['file_name']     = $namafile;
	
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if (!$this->upload->do_upload('photo')) {
					$errors = str_replace('<p>','',$this->upload->display_errors());
					$errors = str_replace('</pre>','',$errors);
					$ret_arr['status'] 	= "gagal";
					$ret_arr['caption']	=  $errors;
					j($ret_arr);
					exit();
				}else{
					$upload_data = $this->upload->data();
					$file_name   = $upload_data['file_name'];
				}
			} 
		
			if ($p->id != 0) {

				$cek_username = $this->validasi->check_username(bersih($p,'username'),'update','siswa',bersih($p,'id'));
				$cek_email 	  = $this->validasi->check_email(bersih($p,'email'),'update','siswa',bersih($p,'id'));

				if ($cek_email > 0) {
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
				}else {
				    $data = [
						'nama'  => bersih($p, "nama"),
						'username'  => bersih($p, "username"),
					    'nrp' => bersih($p, "nrp"), // NIS

						'no_telpon' => bersih($p, "telp"),
					    'nik' => bersih($p, "nik"), // Jenis kelamin
					    'email'  => bersih($p, "email"),
					    'alamat'  => bersih($p, "alamat"),
					    'instansi'  => empty($this->akun->instansi) ? 1 : $this->akun->instansi,
					    'pembuatan_akun' => time(),
					    'verifikasi' => md5(time())
					];

					if(!empty($file_name)){
						$data['photo'] = $file_name;
					}

					$this->db->where('id', bersih($p, "id"));
					$kirim = $this->db->update('m_siswa', $data);

					if($kirim){
						if(!empty($file_name)){
							unlink('upload/siswa_photo/'.$p->photo_before);
						}
					}

					$cek_adm = $this->db->where(array('level'=>'siswa','kon_id'=>bersih($p,"id")))->get('m_admin')->result();
					if (count($cek_adm) > 0) {

						

						$data_adm = array(
							'user_id'  => bersih($p, "username"),
							'username' => bersih($p, "email") 
						);
						$this->db->update('m_admin',$data_adm,array('level'=>'siswa','kon_id'=>bersih($p,"id")));
					}
					
				// $this->db->query("UPDATE m_siswa SET nama = '".bersih($p,"nama")."', nim = '".bersih($p,"nim")."', 
				// 									 jurusan = '".bersih($p,"jenis")."', tanggal_lahir = '".bersih($p,"tanggal")."',
				// 									 jenis_kelamin = '".bersih($p,"kelamin")."', Alamat = '".bersih($p,"alamat")."', 
				// 									 id_provinsi = '".bersih($p,"provinsi")."', id_kota = '".bersih($p,"kota_kab")."',
				// 									 id_kecamatan = '".bersih($p,"kecamatan")."', no_telpon = '".bersih($p,"telp")."',
				// 									 WHERE id = '".bersih($p,"id")."'");
				$ket = "edit";
				}

			} else {
				
				$cek_username = $this->validasi->check_username(bersih($p,"username"),'insert');
				$cek_email 	  = $this->validasi->check_email(bersih($p,"email"),'insert');
				
				if ($cek_email > 0) {
					$ket = "tambah";
					$ret_arr['status'] 	= "gagal";
					$ret_arr['caption']	= "Email Sudah Ada";
					j($ret_arr);
					exit();
				
				}else if($cek_username > 0){
					$ket = "tambah";
					$ret_arr['status'] 	= "gagal";
					$ret_arr['caption']	= "username Sudah Ada";
					j($ret_arr);
					exit();
				}else {
					$ket = "tambah";
					$data = [
						'nama'  => bersih($p, "nama"),
						'username'  => bersih($p, "username"),
					    'nrp' => bersih($p, "nrp"), // NIS

						'no_telpon' => bersih($p, "telp"),
					    'nik' => bersih($p, "nik"), // Jenis kelamin
					    'email'  => bersih($p, "email"),
					    'alamat'  => bersih($p, "alamat"),
					    'instansi'  => empty($this->akun->instansi) ? 1 : $this->akun->instansi,
					    'pembuatan_akun' => time(),
					    'verifikasi' => md5(time())
					];  

					if(!empty($file_name)){
						$data['photo'] = $file_name;
					}
					
					$this->db->insert('m_siswa', $data);
					$inserted_id = $this->db->insert_id();

					// Detail Kelas
					$detail_kelas = [
						'id_peserta' => $inserted_id,
						'id_kelas' => $p->id_kelas
					];
					$this->db->insert('tb_detail_kelas', $detail_kelas);
					$check_login = $this->m_admin->get_many_by(['kon_id' => $inserted_id]);
					$kon_ids = [];
					if(count($check_login) > 0) {
						foreach($check_login as $data) {
							$kon_ids[] = $data->kon_id;
						}
					}

					if(count($kon_ids) > 0) {
						$this->db->where_in('kon_id',$kon_ids)->delete('m_admin');	
					}
                    $data_admin = [
                        'user_id'  => bersih($p, "username"),
                        'username' => bersih($p, "email"),
                        'password'  => $this->encryption->encrypt(bersih($p, "username")),
                        'level'    => 'siswa',
                        'kon_id'   => $inserted_id
                    ];

                    $this->db->insert('m_admin', $data_admin);
				// 	$this->db->query("INSERT INTO m_siswa VALUES (null, '".bersih($p,"nama")."', '".bersih($p,"nim")."', 
				// 														'".bersih($p,"jenis")."',  '".bersih($p,"tanggal")."',
				// 														'".bersih($p,"kelamin")."', '".bersih($p,"alamat")."', 
				// 														'".bersih($p,"provinsi")."', '".bersih($p,"kota_kab")."', 
				// 														'".bersih($p,"kecamatan")."', '".bersih($p,"telp")."', 
				// 														 '".time()."', '".md5(time())."' )");
				}
			}
			
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $ket." sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "hapus") {
			$this->db->query("DELETE FROM m_siswa WHERE id = '".$uri4."'");
			$this->db->query("DELETE FROM m_admin WHERE level = 'siswa' AND kon_id = '".$uri4."'");			
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "hapus sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "user") {
			$det_user = $this->m_siswa->get_by(array('id'=>$uri4));
			if (!empty($det_user)) {
				$q_cek_username = $this->m_admin->count_by(array('username'=>$det_user->username,'level'=>'siswa'));

				if ($q_cek_username < 1) {

					$data_adm = array(
						'user_id' => $det_user->username,
						'username' => $det_user->email, 
						'password' => $this->encryption->encrypt($det_user->username), 
						'level' => 'siswa', 
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
			$det_user = $this->m_siswa->get_by(array('id'=>$uri4));
			$datas = array(
				'password' => $this->encryption->encrypt($det_user->username), 
			);
			$where = array(
				'level' => 'siswa', 
				'kon_id' => $det_user->id
			);
			
			$this->m_admin->update($datas,$where);

			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "Update password sukses";
			j($ret_arr);

			exit();
		} else if ($uri3 == "ambil_matkul") {
			$matkul = $this->db->query("SELECT m_mapel.*,
										(SELECT COUNT(id) FROM tr_siswa_mapel WHERE id_siswa = ".$uri4." AND id_mapel = m_mapel.id) AS ok
										FROM m_mapel
										")->result();
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
						
						$cek_sudah_ada = $this->db->query("SELECT id FROM tr_siswa_mapel WHERE  id_siswa = '".$p->id_mhs."' AND id_mapel = '".$a->id."'")->num_rows();
						
						if ($cek_sudah_ada < 1) {
							$this->db->query("INSERT INTO tr_siswa_mapel VALUES (null, '".$p->id_mhs."', '".$a->id."')");
						} else {
							$this->db->query("UPDATE tr_siswa_mapel SET id_mapel = '".$p->$p_sub."' WHERE id_siswa = '".$p->id_mhs."' AND id_mapel = '".$a->id."'");
						}
					} else {
						//echo "0<br>";
						$this->db->query("DELETE FROM tr_siswa_mapel WHERE id_siswa = '".$p->id_mhs."' AND id_mapel = '".$a->id."'");
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

	        $d_total_row = $this->db->query("SELECT id FROM m_siswa a WHERE a.nama LIKE '%".$search['value']."%'")->num_rows();
	    
	        $q_datanya = $this->db->query("SELECT a.*,
											(SELECT COUNT(id) FROM m_admin WHERE level = 'siswa' AND kon_id = a.id) AS ada
											FROM m_siswa a
	                                        WHERE a.nama LIKE '%".$search['value']."%' ORDER BY a.id DESC LIMIT ".$start.", ".$length."")->result_array();
	        $data = array();
	        $no = ($start+1);

	        foreach ($q_datanya as $d) {
	            $data_ok = array();
	            $data_ok[] = $no++;
	            $data_ok[] = $d['nama'];
	            $data_ok[] = $d['username'];
				$data_ok[] = $d['nrp'];
				$data_ok[] = $d['kelompok'];
	            if ($d['deleted'] == 1) {
                  $data_link ='<a href="#" onclick="return m_siswa_ak('.$d['id'].',1);" class="btn btn-info btn-sm mr-2"><i class="glyphicon glyphicon-user" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Aktifkan</a>';
                } else {
                  $data_link = '<a href="#" onclick="return m_siswa_ak('.$d['id'].',0);" class="btn btn-warning btn-sm mr-2"><i class="glyphicon glyphicon-random" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;NonAktifkan</a>';
                }
	            $data_ok[] = '<div class="btn-group">
                          <a href="#" onclick="return m_siswa_e('.$d['id'].');" class="btn btn-info btn-sm mr-2"><i class="glyphicon glyphicon-pencil" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Edit</a>
                          <a href="#" onclick="return m_siswa_h('.$d['id'].');" class="btn btn-danger btn-sm mr-2"><i class="glyphicon glyphicon-remove" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Hapus</a>
                          '.$data_link.'';
              

                if ($d['ada'] == "0") {
                  $data_ok[5] .= '<a href="#" onclick="return m_siswa_u('.$d['id'].');" class="btn btn-info btn-sm mr-2"><i class="glyphicon glyphicon-user" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Aktifkan User</a>';
                } else {
                  $data_ok[5] .= '<a href="#" onclick="return m_siswa_ur('.$d['id'].');" class="btn btn-warning btn-sm mr-2"><i class="glyphicon glyphicon-random" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Reset Password</a>';
                }
                

	            $data[] = $data_ok;
	        }

	        $json_data = array(
	                    "draw" => $draw,
	                    "iTotalRecords" => $d_total_row,
	                    "iTotalDisplayRecords" => $d_total_row,
	                    "data" => $data,
	                );
	        j($json_data);
	        exit;
		} else if ($uri3 == "import") {
			$a['p']	= "f_siswa_import";
		} else if ($uri3 == "aktifkan_semua") {
			$q_get_user = $this->db->query("select 
								a.id, a.nama, a.nim, ifnull(b.username,'N') usernya
								from m_siswa a 
								left join m_admin b on concat(b.level,b.kon_id) = concat('siswa',a.id)")->result_array();
			$jml_aktif = 0;
			if (!empty($q_get_user)) {
				foreach ($q_get_user as $j) {
					if ($j['usernya'] == "N") {
						$this->db->query("INSERT INTO m_admin VALUES (null, '".$j['nim']."', md5('".$j['nim']."'), 'siswa', '".$j['id']."')");
						$jml_aktif++;
					}
				}
			}

			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $jml_aktif." user diaktifkan";
			j($ret_arr);
			exit();

		} else {
			$a['p']	= "m_siswa";
		}

		$a['instansi'] = $this->m_instansi->get_all();

		$this->load->view('dashboard/template/header', $a);
		$this->load->view('dashboard/template/navbar', $a);
		$this->load->view('dashboard/admin/datapengusaha', $a);
		$this->load->view('dashboard/template/footer', $a);
    }
    
    public function get_akhir($tabel, $field, $kode_awal, $pad) {
		$get_akhir	= $this->db->query("SELECT MAX($field) AS max FROM $tabel LIMIT 1")->row();
		$data		= (intval($get_akhir->max)) + 1;
		$last		= $kode_awal.str_pad($data, $pad, '0', STR_PAD_LEFT);
	
		return $last;
	}

	private function get_jenis_usaha() {
		return $this->db->get('jenis_usaha')->result();	
	}

	public function get_jenis_usaha_ajax() {

		$data = [
			'status' => TRUE,
			'data' => $this->db->get('jenis_usaha')->result()
		];

		echo json_encode($data);
	}

	public function put_jenis_usaha_ajax() {
		$val = explode(' ', $this->input->post('nama'));
		$val = strtolower(join('_', $val));
		$id = $this->input->post('ju');
		$data = [
		  'nama' => $this->input->post('nama'),
		  'value' => $val
		];
		
		$update = $this->db->update('jenis_usaha', $data, array('id' => $id));
        
        if($update) {
		    echo json_encode(['status' => TRUE, 'msg' => 'Data berhasil di update']);
        }
        else {
            echo json_encode(['status' => FALSE, 'msg' => 'Cannot update']);
            http_response_code(500);
        }
	}
	
	public function delete_jenis_usaha_ajax() {
	    $this->db->where('id', $this->input->post('ju'));
	    $del = $this->db->delete('jenis_usaha');
	    if($del) {
	        echo json_encode(['status' => TRUE, 'msg' => 'Data berhasil di hapus']);
	    }
	    else {
	        echo json_encode(['status' => FALSE, 'msg' => 'Penghapusan gagal']);
	        http_response_code(500);
	    }
	}
	public function post_jenis_usaha_ajax() {
		$val = explode(' ', $this->input->post('nama'));
		$val = join('_', $val);
		$data = [
			'nama'  => $this->input->post('nama'),
			'value' => strtolower($val)
		];

		$insert = $this->db->insert('jenis_usaha', $data);
		if($insert) {
			echo json_encode(['status' => TRUE]);
		}
		else {
			echo json_encode(['status' => FALSE, 'msg' => 'An Error occured, contact your developer!']);	
			http_response_code(500);
		}
	}
    
	public function jenis_usaha() {
		$uri1 = $this->uri->segment(1);

        $uri2 = $this->uri->segment(2);

        $a['sess_level'] = $this->session->userdata('admin_level');
        $a['menu'] = $this->db->query("SELECT `nama_menu`, `link`, `icon` FROM rule_users JOIN menu ON rule_users.id_menu = menu.id JOIN level ON rule_users.id_level = level.id WHERE level = '".$a['sess_level']."' ")->result_array();

        $a['link'] = $this->db->query("SELECT link FROM rule_users JOIN menu ON rule_users.id_menu = menu.id JOIN level ON rule_users.id_level = level.id WHERE link = '".$uri1."/".$uri2."' AND level = '".$a['sess_level']."' ")->result_array();

        $this->load->view('dashboard/template/header');
        $this->load->view('dashboard/template/navbar', $a);
        $this->load->view('dashboard/admin/jenis_usaha');
        $this->load->view('dashboard/template/footer');
	}

	public function aktif_non($id,$kondisi){
		$kondisi = ($kondisi == 1) ? 0 : 1 ;
		$kirim = $this->m_siswa->update(array('deleted'=>$kondisi),array('id'=>$id));
		$ret_arr['status'] 	= "ok";
		$ret_arr['caption']	= "proses sukses";
		j($ret_arr);
		exit();
	}

	public function data(){

		$instansi = ($this->log_lvl == 'admin') ? $this->m_instansi->get_all() : $this->m_instansi->get_by(array('id'=>$this->akun->instansi));
		// $jurusan = ($this->log_lvl == 'admin') ? $this->m_jurusan->get_all() : $this->m_jurusan->get_many_by(array('id_instansi'=>$this->akun->instansi));
		$guru = ($this->log_lvl == 'admin') ? $this->m_guru->get_all() : $this->m_guru->get_all(array('guru.instansi'=>$this->akun->instansi));
		$kelas = $this->m_kelas->get_all();
		// print_r($guru);exit;
		$data = array(
			'instansi' => $instansi,
			'kelas' => $kelas, 
			'guru' => $guru,
			'searchFilter' => array('Nama','Username','NIS')
		);
		$this->render('pengusaha/list',$data);
	}

	public function arsip_lulus() {
		$this->render('pengusaha/list_lulus');
	}

	public function page_load($pg = 1){
		$post = $this->input->post();
		$limit = $post['limit'];
		$where = [];

		// if ($this->log_lvl != 'admin') {
		// 	$where["akun.instansi"] = $this->akun->instansi;
		// }
		if(isset($post['graduated'])) {
			$where["akun.is_graduated"] = 1;	
		}
		else {
		    $where["akun.is_graduated"] = 0;	
		}
		
		if (!empty($post['search'])) {
			switch ($post['filter']) {
				case 0:
					$where["(lower(nama) like '%".strtolower($post['search'])."%' )"] = null;
					break;
				case 1:
					$where["(lower(username) like '%".strtolower($post['search'])."%' )"] = null;
					break;
				case 2:
					$where["(lower(nrp) like '%".strtolower($post['search'])."%' )"] = null;
					break;
				default:
					# code...
					break;
			}
		}
		$paginate = $this->m_siswa->paginate($pg,$where,$limit);
		foreach ($paginate['data'] as $key => $value) {
			$value->password = $this->encryption->decrypt($value->password);
		}
		$data['paginate'] = $paginate;
		$data['paginate']['url']	= 'pengusaha/page_load';
		$data['paginate']['search'] = 'lookup_key';
		$data['page_start'] = $paginate['counts']['from_num'];

		if(!isset($post['view'])) {
			$view = 'pengusaha/table';
		}
		else {
			$view = $post['view'];
		}

		$this->load->view($view,$data);
		$this->generate_page($data);
	}
    
    public function multi_riwayat() {
        $post = $this->input->post();

		foreach ($post['id'] as $val) {
			$where[] = $val;
		}
		
		$riwayatkan = $this->db->where_in('id',$where)->update(['is_graduated', 1]);

		$this->db->trans_begin();
		
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
		}
		else
		{
			$this->db->trans_commit();
		}
		
		if($riwayatkan) {
		    $result = TRUE;
		}
		else {
		    $result = FALSE;
		}
		echo json_encode(array('result'=>$result));
    }
    
	public function multi_delete(){
		$post = $this->input->post();

		foreach ($post['id'] as $val) {
			$where[] = $val;
		}

		$this->db->trans_begin();

		$kirim = $this->db->where_in('id',$where)->delete('m_siswa');
		$kirim = $this->db->where_in('kon_id',$where)->where_in('level','siswa')->delete('m_admin');

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
		}
		else
		{
			$this->db->trans_commit();
		}

		if ($kirim) {
			$result = true;
		}else{
			$result = false;
		}

		echo json_encode(array('result'=>$result));
	}

	public function import(){
		$this->render('pengusaha/siswa_import');
	}

	public function detail_siswa($id=0){
		$siswa = $this->m_siswa->get_kelas_by(array('akun.id'=>$id));
		$data = array('data' => $siswa, );
		echo json_encode($data);
		exit;
	}

	public function multi_restore() {
		$post = $this->input->post();
		$post['graduated'] = $post['graduated'] == 1 ? 0 : 1;
		$deleted = $post['deleted'] == 1 ? 0 : 1;
		if($post['id'] == NULL) {
			$this->sendAjaxResponse([
				'status' => FALSE,
				'msg' => 'Tidak ada data yang diubah'
			], 400);
		}
		else {
			foreach ($post['id'] as $val) {
				$where[] = $val;
			}
		}

		$this->db->trans_begin();
        
		$restore = $this->db->where_in('id', $where)->update('m_siswa', ['is_graduated' => $post['graduated'], 'deleted' => $deleted]);

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
		}
		else
		{
			$this->db->trans_commit();
		}

		if ($restore) {
			$this->sendAjaxResponse([
				'status' => TRUE,
				'msg' => 'Data berhasil dikembalikan'
			], 200);
		}
		else {
			$this->sendAjaxResponse([
				'status' => FALSE,
				'msg' => 'Data Gagal dikembalikan',

			], 500);	
		}

	}

	public function restore_kelulusan() {
		$post = $this->input->post();
		$graduated = $post['graduated'] == 1 ? 0 : 1;
		$deleted = $post['deleted'] == 1 ? 0 : 1;
		$updated = $this->m_siswa->update(['is_graduated' => $graduated, 'deleted' => $deleted], ['id' => $post['id']]);
		if($updated) {
			$this->sendAjaxResponse([
				'status' => TRUE,
				'msg' => 'Restore data berhasil'
			], 200);
		}
		else {
			$this->sendAjaxResponse([
				'status' => FALSE,
				'msg' => 'Restore data gagal'
			], 500);
		}
	}
}
