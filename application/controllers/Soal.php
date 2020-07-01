<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Soal extends MY_Controller {
	function __construct() {
        parent::__construct();
        $this->db->query("SET time_zone='+7:00'");
        $waktu_sql = $this->db->query("SELECT NOW() AS waktu")->row_array();
        $this->waktu_sql = $waktu_sql['waktu'];
        $this->opsi = array("a","b","c","d","e");
        $this->load->model('m_mapel');
        $this->load->model('m_admin');
	}

	public function data() {
		$data = array(
			'searchFilter' => ['Nama', 'Nama Modul', 'Opsi']
		);
		$this->render('tes_kemampuan/list', $data);
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

	public function m_test() {
		$this->cek_aktif();
		// cek_hakakses(array("admin"), $this->session->userdata('admin_level'));
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
		$p = json_decode(file_get_contents('php://input'));
		//return as json
		$jeson = array();
		$a['data'] = $this->db->query("SELECT m_mapel.* FROM m_mapel")->result();
		if ($uri3 == "det") {
			$a = $this->db->query("SELECT * FROM m_mapel WHERE id = '$uri4'")->row();
			j($a);
			exit();
		} else if ($uri3 == "simpan") {
			$ket 	= "";
			if ($p->id != 0) {
				$this->db->query("UPDATE m_mapel SET nama = '".bersih($p,"nama")."'
								WHERE id = '".bersih($p,"id")."'");
				$ket = "edit";
			} else {
				$ket = "tambah";
				$this->db->query("INSERT INTO m_mapel VALUES (null, '".bersih($p,"nama")."')");
			}
			
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $ket." sukses";
			j($ret_arr);
			exit();
		}  else if ($uri3 == "data") {
			$start = $this->input->post('start');
			$length = $this->input->post('length');
			$draw = $this->input->post('draw');
			$search = $this->input->post('search');

			if ($this->log_lvl == 'guru') {
				$q_datanya = $this->db->query("SELECT mp.* FROM m_mapel mp LEFT JOIN tr_guru_mapel grm ON grm.id_mapel = mp.id WHERE grm.id_guru = ".$this->akun->id." AND mp.nama LIKE '%".$search['value']."%'  ORDER BY mp.id ASC LIMIT ".$start.", ".$length."")->result_array();
			}else{
				$q_datanya = $this->db->query("SELECT a.*
					FROM m_mapel a
					WHERE a.nama LIKE '%".$search['value']."%' ORDER BY a.id ASC LIMIT ".$start.", ".$length."")->result_array();
			}
			$d_total_row = count($q_datanya);
	    
	        $data = array();
	       
	        
	        $no = ($start+1);

	        foreach ($q_datanya as $d) {
	            $data_ok = array();
	            $data_ok[0] = $no++;
	            $data_ok[1] =  $d['nama'];
	            if($this->session->userdata('admin_level') == 'admin' || 'guru') {
	            	$link = base_url('soal/m_soal/edit/0').'/'.md5($d['id']).'/'.$d['id'].'/'.md5($d['id']).'/'.$a['sess_konid'];
	 
		            $data_ok[2] = '<div class="btn-group">
                            <a class="btn btn-primary btn-xs" href="'.base_url('soal/m_soal/edit/0').'/'.md5($d['id']).'/'.$d['id'].'/'.md5($d['id']).'/'.$a['sess_konid'].'?id='.$d['id'].'&sess='.$a['sess_konid'].'"><i class="glyphicon glyphicon-eye" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Lihat Soal</a>
                            <a class="btn btn-danger btn-xs" href="'.base_url('soal/m_ujian/').md5($d['id']).'/'.$d['id'].'"><i class="glyphicon glyphicon-eye" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Lihat Tes</a>
	                         ';
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
		} else {
			$a['p']	= "m_tes";

		}
		if($a['sess_level'] == 'admin'){
			cek_hakakses(array("admin"), $this->session->userdata('admin_level'));
			$this->load->view('dashboard/template/header', $a);
		$this->load->view('dashboard/template/navbar', $a);
		$this->load->view('dashboard/admin/datamateri', $a);
		$this->load->view('dashboard/template/footer', $a);
		}else if($a['sess_level'] == 'guru'){
			cek_hakakses(array("guru"), $this->session->userdata('admin_level'));
			$this->load->view('dashboard/template/header', $a);
			$this->load->view('dashboard/template/navbar', $a);
		$this->load->view('dashboard/trainer/inputmateri', $a);
		$this->load->view('dashboard/template/footer', $a);
		}
	
    }    	
	public function m_soal() {
		$this->cek_aktif();
		cek_hakakses(array("admin", "guru"), $this->session->userdata('admin_level'));
		
		//var def uri segment
			$uri1 = $this->uri->segment(1);
			$uri2 = $this->uri->segment(2);
			$uri3 = $this->uri->segment(3);
			$uri4 = $this->uri->segment(4);
			$uri5 = $this->uri->segment(5);
			$uri6 = $this->uri->segment(6);

			$uri7 = $this->uri->segment(7);
			$uri8 = $this->uri->segment(8);

		

		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');
		$a['menu'] = $this->db->query("SELECT `nama_menu`, `link`, `link2`, `icon` FROM rule_users JOIN menu ON rule_users.id_menu = menu.id JOIN level ON rule_users.id_level = level.id WHERE level = '".$a['sess_level']."' ")->result_array();
		$a['link'] = $this->db->query("SELECT link2 FROM rule_users JOIN menu ON rule_users.id_menu = menu.id JOIN level ON rule_users.id_level = level.id WHERE link2 = '".$uri1."/".$uri2."' AND level = '".$a['sess_level']."' ")->result_array();

		

		$a['huruf_opsi'] = array("a","b","c","d","e");
		$a['jml_opsi'] = $this->config->item('jml_opsi');

		//var post from json
		$p = json_decode(file_get_contents('php://input'));
		//return as json
		$jeson = array();

		if ($a['sess_level'] == "guru") {
			
			$a['p_guru'] = obj_to_array($this->db->query("SELECT * FROM m_guru WHERE id = '".$a['sess_konid']."'")->result(), "id,nama");
			$a['p_mapel'] = obj_to_array($this->db->query("SELECT 
											b.id, b.nama
											FROM tr_guru_mapel a
											INNER JOIN m_mapel b ON a.id_mapel = b.id
											WHERE a.id_guru = '".$a['sess_konid']."'")->result(), "id,nama");
											
		} else  if ($a['sess_level'] == "admin"){
			$a['p_guru'] = obj_to_array($this->db->query("SELECT * FROM m_admin WHERE kon_id = '".$a['sess_konid']."'")->result(), "id,level");
			$a['p_mapel'] = obj_to_array($this->db->query("SELECT b.id, b.nama
											FROM tr_guru_mapel a
											INNER JOIN m_mapel b ON a.id_mapel = b.id")->result(), "id,nama");
		}

		if ($uri3 == "det") {
			// $a = $this->db->query("SELECT * FROM m_soal WHERE id = '26' ORDER BY id DESC")->row();
			$a = $this->db->query("SELECT nama FROM m_mapel WHERE id = '".$uri4."' ")->row();
		j($a);
			exit();
		}else if ($uri3 == "det1") {
			
			
		if ($a['sess_level'] == "guru") {
			$a = $this->db->query("SELECT m_mapel.id, m_admin.kon_id FROM `m_admin` JOIN `m_mapel` WHERE m_admin.kon_id = '".$a['sess_konid']."' AND m_mapel.id = '$uri4'")->row();
		} else  if ($a['sess_level'] == "admin"){
			
		}
			if (!empty($a)) {
				$are['id_guru'] = $a->kon_id;
				$are['id_mapel'] = $a->id;
			
			} else {
				$are['id_guru'] = "";
				$are['id_mapel'] = "";
			}
		

			j($are);
			exit();
		}else if ($uri3 == "det2") {
		
			$a = $this->db->query("SELECT m_soal.*, 'edit' AS mode FROM m_soal WHERE id = '$uri4'")->row();
		
			if (!empty($a)) {
				$are['id'] = $a->id;
				$are['id_guru'] = $a->id_guru;
				$are['id_mapel'] = $a->id_mapel;
			    $are['bobot'] = $a->bobot;
			    $are['file'] = $a->file;
			    $are['tipe_file'] = $a->tipe_file;
			    $are['soal'] = $a->soal;
			    $are['opsi_a'] = $a->opsi_a;
			    $are['opsi_b'] = $a->opsi_b;
			    $are['opsi_c'] = $a->opsi_c;
			    $are['opsi_d'] = $a->opsi_d;
			    $are['opsi_e'] = $a->opsi_e;
			    $are['jawaban'] = $a->jawaban;
			    $are['tgl_input'] = $a->tgl_input;
			    $are['jml_benar'] = $a->jml_benar;
			    $are['jml_salah'] = $a->jml_salah;
			    $are['mode'] = $a->mode;
			} else {
				$are['id'] = "";
				$are['id_guru'] = "";
				$are['id_mapel'] = "";
			    $are['bobot'] = "";
			    $are['file'] = "";
			    $are['tipe_file'] = "";
			    $are['soal'] = "";
			    $are['opsi_a'] = "";
			    $are['opsi_b'] = "";
			    $are['opsi_c'] = "";
			    $are['opsi_d'] = "";
			    $are['opsi_e'] = "";
			    $are['jawaban'] = "";
			    $are['tgl_input'] = "";
			    $are['jml_benar'] = "";
			    $are['jml_salah'] = "";
			    $are['mode'] = "";
			}
			

			j($a);
			exit();
		} else if ($uri3 == "import") {
			$a['p']	= "f_soal_import";
		} else if ($uri3 == "hapus_gambar") {
			$nama_gambar = $this->db->query("SELECT file FROM m_soal WHERE id = '".$uri5."'")->row();
			$this->db->query("UPDATE m_soal SET file = '', tipe_file = '' WHERE id = '".$uri5."'");
			@unlink("./upload/gambar_soal/".$nama_gambar->file);
				redirect('soal/m_soal/edit/0/'.md5($uri4).'/'.$uri4.'/'.md5($uri4).'/'.$a['sess_konid']);
		} else if ($uri3 == "pilih_mapel") {
			if ($a['sess_level'] == "guru") {
				$a['data'] = $this->db->query("SELECT m_soal.*, m_guru.nama AS nama_guru FROM m_soal INNER JOIN m_guru ON m_soal.id_guru = m_guru.id WHERE m_soal.id_guru = '".$a['sess_konid']."' AND m_soal.id_mapel = '$uri4' ORDER BY id DESC")->result();
			} else {
				$a['data'] = $this->db->query("SELECT m_soal.*, m_guru.nama AS nama_guru FROM m_soal INNER JOIN m_guru ON m_soal.id_guru = m_guru.id WHERE m_soal.id_mapel = '$uri4' ORDER BY id DESC")->result();
			}
			//echo $this->db->last_query();
			$a['p']	= "m_soal";
		}else if ($uri3 == "simpan") {
			$p = $this->input->post();
			$pembuat_soal = ($a['sess_level'] == "admin") ? $p['id_guru'] : $a['sess_konid'];
			$pembuat_soal_u = ($a['sess_level'] == "admin") ? ", id_guru = '".$p['id_guru']."'" : "";
			//etok2nya config
			$folder_gb_soal = "./upload/gambar_soal/";
			$folder_gb_opsi = "./upload/gambar_opsi/";

			$buat_folder_gb_soal = !is_dir($folder_gb_soal) ? @mkdir("./upload/gambar_soal/") : false;
			$buat_folder_gb_opsi = !is_dir($folder_gb_opsi) ? @mkdir("./upload/gambar_opsi/") : false;

			$allowed_type 	= array("image/jpeg", "image/png", "image/gif", 
			"audio/mpeg", "audio/mpg", "audio/mpeg3", "audio/mp3", "audio/x-wav", "audio/wave", "audio/wav",
			"video/mp4", "application/octet-stream");

			$gagal 		= array();
			$nama_file 	= array();
			$tipe_file 	= array();

			//get mode
			$__mode = $p['mode'];
			$__id_soal = 0;
			//ambil data post sementara
			$pdata = array(
				"id_guru"=>$p['id_guru'],
				"id_mapel"=>$p['id_mapel'],
				"bobot"=>$p['bobot'],
				"soal"=>$p['soal'],
				"jawaban"=>$p['jawaban'],
			);

			if ($__mode == "edit") {
				$this->db->where("id", $p['id']);
				$this->db->update("m_soal", $pdata);
				$__id_soal = $p['id'];
			} else {
				$this->db->insert("m_soal", $pdata);
				$get_id_akhir = $this->db->query("SELECT MAX(id) maks FROM m_soal LIMIT 1")->row_array();
				$__id_soal = $get_id_akhir['maks'];
			}
			

			//mulai dari sini id soal diambil dari variabel $__id

			//lakukan perulangan sejumlah file upload yang terdeteksi
			foreach ($_FILES as $k => $v) {
				//var file upload
				//$k = nama field di form
				$file_name 		= $_FILES[$k]['name'];
				$file_type		= $_FILES[$k]['type'];
				$file_tmp		= $_FILES[$k]['tmp_name'];
				$file_error		= $_FILES[$k]['error'];
				$file_size		= $_FILES[$k]['size'];
				//kode ref file upload jika error
				$kode_file_error = array("File berhasil diupload", "Ukuran file terlalu besar", "Ukuran file terlalu besar", "File upload error", "Tidak ada file yang diupload", "File upload error");
				
				//jika file error = 0 / tidak ada, tipe file ada di file yang diperbolehkan, dan nama file != kosong
				//echo $file_error."<br>".$file_type;
				//exit;
				//echo var_dump($file_error == 0 || in_array($file_type, $allowed_type) || $file_name != "");
				//exit;
				if ($file_error != 0) {
					$gagal[$k] = $kode_file_error[$file_error];
					$nama_file[$k]	= "";
					$tipe_file[$k]	= "";
				} else if (!in_array($file_type, $allowed_type)) {
					$gagal[$k] = "Tipe file ini tidak diperbolehkan..";
					$nama_file[$k]	= "";
					$tipe_file[$k]	= "";
				} else if ($file_name == "") {
					$gagal[$k] = "Tidak ada file yang diupload";
					$nama_file[$k]	= "";
					$tipe_file[$k]	= "";					
				} else {
					$ekstensi = explode(".", $file_name);

					$file_name = $k."_".$__id_soal.".".$ekstensi[1];

					if ($k == "gambar_soal") {
						@move_uploaded_file($file_tmp, $folder_gb_soal.$file_name);
					} else {
						@move_uploaded_file($file_tmp, $folder_gb_opsi.$file_name);
					}

					$gagal[$k]	 	= $kode_file_error[$file_error]; //kode kegagalan upload file
					$nama_file[$k]	= $file_name; //ambil nama file
					$tipe_file[$k]	= $file_type; //ambil tipe file
				}
			}


			//ambil data awal
			$get_opsi_awal = $this->db->query("SELECT opsi_a, opsi_b, opsi_c, opsi_d, opsi_e FROM m_soal WHERE id = '".$__id_soal."'")->row_array();

			$data_simpan = array();

			if (!empty($nama_file['gambar_soal'])) {
				$data_simpan = array(
								"file"=>$nama_file['gambar_soal'],
								"tipe_file"=>$tipe_file['gambar_soal'],
								);
			}

			for ($t = 0; $t < $a['jml_opsi']; $t++) {
				$idx 	= "opsi_".$a['huruf_opsi'][$t];
				$idx2 	= "gj".$a['huruf_opsi'][$t];


				//jika file kosong
				$pc_opsi_awal = explode("#####", $get_opsi_awal[$idx]);
				$nama_file_opsi = empty($nama_file[$idx2]) ? $pc_opsi_awal[0] : $nama_file[$idx2];

				$data_simpan[$idx] = $nama_file_opsi."#####".$p[$idx];
			}

			$this->db->where("id", $__id_soal);
			$this->db->update("m_soal", $data_simpan);

			$teks_gagal = "";
			foreach ($gagal as $k => $v) {
				$arr_nama_file_upload = array("gambar_soal"=>"File Soal ", "gja"=>"File opsi A ", "gjb"=>"File opsi B ", "gjc"=>"File opsi C ", "gjd"=>"File opsi D ", "gje"=>"File opsi E ");
				$teks_gagal .= $arr_nama_file_upload[$k].': '.$v.'<br>';
			}
			$this->session->set_flashdata('k', '<div class="alert alert-info">'.$teks_gagal.'</div>');
				redirect(base_url('soal/m_soal/edit/0/'.md5($p['id_mapel']).'/'.$p['id_mapel'].'/'.md5($p['id_mapel']).'/'.$a['sess_konid'].'?id='.$p['id_mapel'].'&sess='.$a['sess_konid'].''));
				
		}  else if ($uri3 == "hapus") {
			$nama_gambar = $this->db->query("SELECT id_mapel, file, opsi_a, opsi_b, opsi_c, opsi_d, opsi_e FROM m_soal WHERE id = '".$uri4."'")->row();
			$pc_opsi_a = explode("#####", $nama_gambar->opsi_a);
			$pc_opsi_b = explode("#####", $nama_gambar->opsi_b);
			$pc_opsi_c = explode("#####", $nama_gambar->opsi_c);
			$pc_opsi_d = explode("#####", $nama_gambar->opsi_d);
			$pc_opsi_e = explode("#####", $nama_gambar->opsi_e);
			$this->db->query("DELETE FROM m_soal WHERE id = '".$uri4."'");
			@unlink("./upload/gambar_soal/".$nama_gambar->file);
			@unlink("./upload/gambar_soal/".$pc_opsi_a[0]);
			@unlink("./upload/gambar_soal/".$pc_opsi_b[0]);
			@unlink("./upload/gambar_soal/".$pc_opsi_c[0]);
			@unlink("./upload/gambar_soal/".$pc_opsi_d[0]);
			@unlink("./upload/gambar_soal/".$pc_opsi_e[0]);
			
			redirect('soal/m_soal/edit/0/'.md5($nama_gambar->id_mapel).'/'.$nama_gambar->id_mapel.'/'.md5($nama_gambar->id_mapel).'/'.$a['sess_konid']);

		}else if ($uri3 == "file_hapus"){
		
			$nama_gambar = $this->db->query("SELECT id, id_mapel, file, opsi_a, opsi_b, opsi_c, opsi_d, opsi_e FROM m_soal WHERE id = '".$uri4."'")->row();
			$num = $nama_gambar->id + $uri5;
			$link1 =1 + $nama_gambar->id;
			$link2 =2 + $nama_gambar->id;
			$link3 =3 + $nama_gambar->id;
			$link4 =4 + $nama_gambar->id;
			$link5 =5 + $nama_gambar->id;
			$link6 =6 + $nama_gambar->id;
			if($link1 == $num){
			unlink("./upload/gambar_soal/".$nama_gambar->file);
			}else if($link2 == $num){
			$pc_opsi_a = explode("#####", $nama_gambar->opsi_a);
			unlink("./upload/gambar_opsi/".$pc_opsi_a[0]);
			}else if($link3 == $num){
			$pc_opsi_b = explode("#####", $nama_gambar->opsi_b);
			unlink("./upload/gambar_opsi/".$pc_opsi_b[0]);
			}else if($link4 == $num){
			$pc_opsi_c = explode("#####", $nama_gambar->opsi_c);
			unlink("./upload/gambar_opsi/".$pc_opsi_c[0]);
			}else if($link5 == $num){
			$pc_opsi_d = explode("#####", $nama_gambar->opsi_d);
			unlink("./upload/gambar_opsi/".$pc_opsi_d[0]);
			}else if($link6 == $num){
			$pc_opsi_e = explode("#####", $nama_gambar->opsi_e);
			unlink("./upload/gambar_opsi/".$pc_opsi_e[0]);
			}
		
			exit;
		} else if ($uri3 == "cetak") {
			$html = "<link href='".base_url()."___/css/style_print.css' rel='stylesheet' media='' type='text/css'/>";
			if ($a['sess_level'] == "admin") {
				$data = $this->db->query("SELECT * FROM m_soal")->result();
			} else {
				$data = $this->db->query("SELECT * FROM m_soal WHERE id_guru = '".$a['sess_konid']."'")->result();
			}

			$mapel = $this->db->query("SELECT nama FROM m_mapel WHERE id = '".$uri4."'")->row();
			if (!empty($data)) {
				
				$no = 1;
				$jawaban = array("A","B","C","D","E");
				foreach ($data as $d) {
					
		            $arr_tipe_media = array(""=>"none","image/jpeg"=>"gambar","image/png"=>"gambar","image/gif"=>"gambar",
					"audio/mpeg"=>"audio","audio/mpg"=>"audio","audio/mpeg3"=>"audio","audio/mp3"=>"audio","audio/x-wav"=>"audio","audio/wave"=>"audio","audio/wav"=>"audio",
					"video/mp4"=>"video", "application/octet-stream"=>"video");
		            $tipe_media = $arr_tipe_media[$d->tipe_file];
		            $file_ada = file_exists("./upload/gambar_soal/".$d->file) ? "ada" : "tidak_ada";
		            $tampil_media = "";
		            if ($file_ada == "ada" && $tipe_media == "audio") {
		              $tampil_media = '<<< Ada media Audionya >>>';
		            } else if ($file_ada == "ada" && $tipe_media == "video") {
		              $tampil_media = '<<< Ada media Videonya >>>';
		            } else if ($file_ada == "ada" && $tipe_media == "gambar") {
		              $tampil_media = '<p><img src="'.base_url().'upload/gambar_soal/'.$d->file.'" class="thumbnail" style="width: 300px; height: 280px; display: inline; float: left"></p>';
		            } else {
		              $tampil_media = '';
		            }
	                $html .= '<table>
	                <tr><td>'.$no.'.</td><td colspan="2">'.$d->soal.'<br>'.$tampil_media.'</td></tr>';
	                for ($j=0; $j<($this->config->item('jml_opsi'));$j++) {
	                  	$opsi = "opsi_".strtolower($jawaban[$j]);
	                    $pc_pilihan_opsi = explode("#####", $d->$opsi);
	                    $tampil_media_opsi = (file_exists('./upload/gambar_soal/'.$pc_pilihan_opsi[0]) AND $pc_pilihan_opsi[0] != "") ? '<img src="'.base_url().'upload/gambar_soal/'.$pc_pilihan_opsi[0].'" style="width: 100px; height: 100px; margin-right: 20px">' : '';
	                  if ($jawaban[$j] == $d->jawaban) {
	                    $html .= '<tr><td width="2%" style="font-weight: bold">'.$jawaban[$j].'</td><td style="font-weight: bold">'.$tampil_media_opsi.$pc_pilihan_opsi[1].'</td></label></tr>';
	                  } else {
	                    $html .= '<tr><td width="2%">'.$jawaban[$j].'</td><td>'.$tampil_media_opsi.$pc_pilihan_opsi[1].'</td></label></tr>';
	                  }
	                }
	                $html .= '</table></div>';
		            $no++;
				}
				}

				echo $html;
				exit;
			}else if ($uri3 == "edit") {
			$a['opsij'] = array(""=>"Jawaban","A"=>"A","B"=>"B","C"=>"C","D"=>"D","E"=>"E");
			
			$id_guru = $this->session->userdata('admin_level') == "guru" ? "WHERE a.id_guru = '".$a['sess_konid']."'" : "";

			$a['p_mapel'] = obj_to_array($this->db->query("SELECT b.id, b.nama FROM tr_guru_mapel a INNER JOIN m_mapel b ON a.id_mapel = b.id $id_guru")->result(),"id,nama");

			if ($uri4 == 0) {
				$a['d'] = array("mode"=>"add","id"=>"0","id_guru"=>$id_guru,"id_mapel"=>"","bobot"=>"1","file"=>"","soal"=>"","opsi_a"=>"#####","opsi_b"=>"#####","opsi_c"=>"#####","opsi_d"=>"#####","opsi_e"=>"#####","jawaban"=>"","tgl_input"=>"");
			} else {
				$a['d'] = $this->db->query("SELECT m_soal.*, 'edit' AS mode FROM m_soal WHERE id = '$uri4'")->row_array();

			}

			$data = array();

			for ($e = 0; $e < $a['jml_opsi']; $e++) {
				$iidata = array();
				$idx = "opsi_".$a['huruf_opsi'][$e];
				$idx2 = $a['huruf_opsi'][$e];

				$pc_opsi_edit = explode("#####", $a['d'][$idx]);
				$iidata['opsi'] = $pc_opsi_edit[1];
				$iidata['gambar'] = $pc_opsi_edit[0];
				$data[$idx2] = $iidata;
			}


			$a['data_pc'] = $data;
				if ($uri4 == 0) {
			   		$a['p'] = "m_soal";
				}else{
				    $a['p'] = "f_soal";
				}
		}else if ($uri3 == "data") {

				$start = $this->input->post('start');
		        $length = $this->input->post('length');
		        $draw = $this->input->post('draw');
		        $search = $this->input->post('search');

		        $wh = '';

		        if ($a['sess_level'] == "guru") {
					$wh = "a.id_mapel = '".$uri4."' AND a.id_guru = '".$a['sess_konid']."' AND ";
					//a.id_guru = '".$a['sess_konid'].
				} else if ($a['sess_level'] == "admin") {
					$wh = "a.id_mapel = '".$uri4."' AND";
				}


		        $d_total_row = $this->db->query("SELECT a.*
												FROM m_soal a
												INNER JOIN m_guru b ON a.id_guru = b.id
												INNER JOIN m_mapel c ON a.id_mapel = c.id
		                                        WHERE ".$wh." (a.soal LIKE '%".$search['value']."%' 
												OR b.nama LIKE '%".$search['value']."%' 
												OR c.nama LIKE '%".$search['value']."%')")->num_rows();

		        $q_datanya = $this->db->query("SELECT a.*, b.nama nmguru, c.nama nmmapel
												FROM m_soal a
												INNER JOIN m_guru b ON a.id_guru = b.id
												INNER JOIN m_mapel c ON a.id_mapel = c.id
		                                        WHERE ".$wh." (a.soal LIKE '%".$search['value']."%' 
												OR b.nama LIKE '%".$search['value']."%' 
												OR c.nama LIKE '%".$search['value']."%')
		                                        ORDER BY a.id ASC LIMIT ".$start.", ".$length."")->result_array();
		        //echo $this->db->last_query();
		    
		        $data = array();
		        $no = ($start+1);

		        foreach ($q_datanya as $d) {
		            	$jml_benar = empty($d['jml_benar']) ? 0 : intval($d['jml_benar']);
		        	$jml_salah = empty($d['jml_salah']) ? 0 : intval($d['jml_salah']);
		        	$total = ($jml_benar + $jml_salah);
		        	$persen_benar = $total > 0 ? (($jml_benar / $total) * 100) : 0; 

				$data_ok = array();
				$data_ok[0] = $no++;
				$data_ok[1] = substr($d['soal'], 0, 300);
				$data_ok[2] = $d['nmmapel'].'<br>'.$d['nmguru'];
				$data_ok[3] = "Jml dipakai : ".($total)."<br>Benar: ".$jml_salah.", Salah: ".$jml_salah."<br>Persentase benar : ".number_format($persen_benar)." %";
				$data_ok[4] = '<div class="btn-group">
				<a href="'.base_url().'soal/m_soal/edit/'.$d['id'].'"  class="btn btn-info btn-xs"><i class="glyphicon glyphicon-pencil" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Edit</a>
				<a href="'.base_url().'soal/m_soal/hapus/'.$d['id'].'" class="btn btn-danger btn-xs" onclick="return confirm(\'Anda yakin...?\');"><i class="glyphicon glyphicon-remove" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Hapus</a>
				 ';

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
		        
		        
		        
		} else {
			$a['p']	= "m_soal";
		}
	
		if ($a['sess_level'] == 'admin') {
			cek_hakakses(array("admin"), $this->session->userdata('admin_level'));
		$this->load->view('dashboard/template/header', $a);
		$this->load->view('dashboard/template/navbar2', $a);
		$this->load->view('dashboard/admin/datasoal', $a);
		$this->load->view('dashboard/template/footer', $a);
		}else if ($a['sess_level'] == 'guru'){
			cek_hakakses(array("guru"), $this->session->userdata('admin_level'));
			$this->load->view('dashboard/template/header', $a);
			$this->load->view('dashboard/template/navbar2', $a);
			$this->load->view('dashboard/trainer/inputsoal', $a);
			$this->load->view('dashboard/template/footer', $a);
		}
    }





public function m_ujian() {
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
		$a['menu'] = $this->db->query("SELECT `nama_menu`, `link`, `link3`, `icon` FROM rule_users JOIN menu ON rule_users.id_menu = menu.id JOIN level ON rule_users.id_level = level.id WHERE level = '".$a['sess_level']."' ")->result_array();
		$a['link'] = $this->db->query("SELECT link3 FROM rule_users JOIN menu ON rule_users.id_menu = menu.id JOIN level ON rule_users.id_level = level.id WHERE link3 = '".$uri1."/".$uri2."' AND level = '".$a['sess_level']."' ")->result_array();		
		$a['nama'] = $this->db->query("SELECT nama FROM m_mapel WHERE id = '".$uri4."' ")->result_array();

		
		//var post from json
		$p = json_decode(file_get_contents('php://input'));
		//return as json
		$jeson = array();
		
		//$a['data'] = $this->db->query("SELECT tr_guru_tes.*, m_mapel.nama AS mapel FROM tr_guru_tes INNER JOIN m_mapel ON tr_guru_tes.id_mapel = m_mapel.id WHERE tr_guru_tes.id_guru = '".$a['sess_konid']."'")->result();
		 
		// $a['token'] = obj_to_array($this->db->query("SELECT * FROM akses_token")->result(), "id,status_token");

		$a['token'] =	array(""=>"__Pilih Pemakaian Token Ujian__", 0=>"Non Aktif", 1=>"Aktif");
		$a['pola_tes'] = array(""=>"__Pilih Pengacakan Soal__", "acak"=>"Soal Diacak", "set"=>"Soal Diurutkan");
		$a['p_mapel'] = obj_to_array($this->db->query("SELECT * FROM m_mapel WHERE id IN (SELECT id_mapel FROM tr_guru_mapel WHERE id_guru = '".$a['sess_konid']."')")->result(), "id,nama");
		
		if ($uri3 == "det") {
		
			$a = $this->db->query("SELECT * FROM tr_guru_tes WHERE id = '$uri4'")->row();
			
			
			if (!empty($a)) {
				$pc_waktu = explode(" ", $a->tgl_mulai);
				$pc_tgl = explode("-", $pc_waktu[0]);

				$pc_terlambat = explode(" ", $a->terlambat);

				$are['id'] = $a->id;
				$are['id_guru'] = $a->id_guru;
				$are['id_mapel'] = $a->id_mapel;
				$are['nama_ujian'] = $a->nama_ujian;
				$are['jumlah_soal'] = $a->jumlah_soal;
				$are['waktu'] = $a->waktu;
				$are['terlambat'] = $pc_terlambat[0];
				$are['terlambat2'] = substr($pc_terlambat[1],0,5);
				$are['jenis'] = $a->jenis;
				$are['detil_jenis'] = $a->detil_jenis;
				$are['tgl_mulai'] = $pc_waktu[0];
				$are['wkt_mulai'] = substr($pc_waktu[1],0,5);
				$are['status_token'] = $a->status_token;
				$are['token'] = $a->token;
			} else {
				$are['id'] = "";
				$are['id_guru'] = "";
				$are['id_mapel'] = "";
				$are['nama_ujian'] = "";
				$are['jumlah_soal'] = "";
				$are['waktu'] = "";
				$are['terlambat'] = "";
				$are['terlambat2'] = "";
				$are['jenis'] = "";
				$are['detil_jenis'] = "";
				$are['tgl_mulai'] = "";
				$are['wkt_mulai'] = "";
				$are['status_token'] = "";
				$are['token'] = "";
			}

			j($are);
			exit();
		}	
		else if ($uri3 == "det1") {
		
			$a = $this->db->query("SELECT * FROM m_mapel WHERE id = '$uri4'")->row();
			
			
			if (!empty($a)) {
			    
			    
			    $are['id'] = $a->id;
				$are['id_guru'] = "";
				$are['id_mapel'] = $a->id;
				$are['nama_ujian'] = "";
				$are['jumlah_soal'] = "";
				$are['waktu'] = "";
				$are['terlambat'] = "";
				$are['terlambat2'] = '23:59';
				$are['jenis'] = "";
				$are['detil_jenis'] = "";
				$are['tgl_mulai'] = "";
				$are['wkt_mulai'] = '00:00';
				$are['status_token'] = "";
				$are['token'] = "";
			
			
			} else {
				$are['id'] = "";
				$are['id_guru'] = "";
				$are['id_mapel'] = "";
				$are['nama_ujian'] = "";
				$are['jumlah_soal'] = "";
				$are['waktu'] = "";
				$are['terlambat'] = "";
				$are['terlambat2'] = "";
				$are['jenis'] = "";
				$are['detil_jenis'] = "";
				$are['tgl_mulai'] = "";
				$are['wkt_mulai'] = "";
				$are['status_token'] = "";
				$are['token'] = "";
			}

			j($are);
			exit();
		}else if($uri3 == "verifikasi"){
			$verifikasi = $this->db->query("UPDATE tr_guru_tes SET verifikasi = 1 where id = '$uri4'");
			j($verifikasi);
			exit();
		}
		else if ($uri3 == "simpan") {
			$ket 	= "";

			$ambil_data = $this->db->query("SELECT id FROM m_soal WHERE id_mapel = '".bersih($p, "mapel")."' AND id_guru = '".$a['sess_konid']."'")->num_rows();


			$jml_soal_diminta = intval(bersih($p, "jumlah_soal"));
			
			if ($ambil_data < $jml_soal_diminta) {
				$ret_arr['status'] 	= "gagal";
				$ret_arr['caption']	= "Jumlah soal diinput, melebihi jumlah soal yang ada: ".$ambil_data;
			} else {
				if ($p->id != 0) {

				/*	$this->db->query("UPDATE tr_guru_tes SET 
						id_mapel = '".bersih($p,"mapel")."', 
						nama_ujian = '".bersih($p,"nama_ujian")."', 
						jumlah_soal = '".bersih($p,"jumlah_soal")."', 
						waktu = '".bersih($p,"waktu")."', 
						terlambat = '".bersih($p,"terlambat")." ".bersih($p,"terlambat2")."', 
						tgl_mulai = '".bersih($p,"tgl_mulai")." ".bersih($p,"wkt_mulai")."', 
						jenis = '".bersih($p,"acak")."', status_token = '".bersih($p,"token")."'
						WHERE id = '".bersih($p,"id")."'");*/
					$data = array(
						'id_mapel' => bersih($p,"mapel"), 
						'nama_ujian' => bersih($p,"nama_ujian"), 
						'jumlah_soal' => bersih($p,"jumlah_soal"), 
						'waktu' => bersih($p,"waktu"), 
						'terlambat' => bersih($p,"terlambat").' '.bersih($p,"terlambat2"), 
						'tgl_mulai' => bersih($p,"tgl_mulai")." ".bersih($p,"wkt_mulai"), 
						'jenis' => bersih($p,"acak"), 
						'status_token' => bersih($p,"token"),

					);
					$this->db->update('tr_guru_tes',$data,array('id'=>bersih($p,'id')));
					$ket = "edit";
				} else {
					$ket = "tambah";
					$token = strtoupper(random_string('alpha', 5));

				/*	$this->db->query("INSERT INTO tr_guru_tes VALUES (
						null, 
						'".$a['sess_konid']."', 
						'".bersih($p,"mapel")."',
						'".bersih($p,"nama_ujian")."', 
						'".bersih($p,"jumlah_soal")."', 
						'".bersih($p,"waktu")."', 
						'".bersih($p,"acak")."', 
						'', 
						'".bersih($p,"tgl_mulai")." ".bersih($p,"wkt_mulai")."', 
						'".bersih($p,"terlambat")." ".bersih($p,"terlambat2")."',
						'".bersih($p,"token")."', '0', '0', '$token' )");*/

					$data = array(
						'id_guru' => $this->log_id,
						'id_mapel' => bersih($p,"mapel"), 
						'nama_ujian' => bersih($p,"nama_ujian"), 
						'jumlah_soal' => bersih($p,"jumlah_soal"), 
						'waktu' => bersih($p,"waktu"), 
						'terlambat' => bersih($p,"terlambat").' '.bersih($p,"terlambat2"), 
						'tgl_mulai' => bersih($p,"tgl_mulai")." ".bersih($p,"wkt_mulai"), 
						'jenis' => bersih($p,"acak"), 
						'status_token' => $token,
						'verifikasi' => 1

					);

					$this->db->insert('tr_guru_tes',$data);
				}


				$ret_arr['status'] 	= "ok";
				$ret_arr['caption']	= $ket." sukses";
			}
			j($ret_arr);
			exit();
		} else if ($uri3 == "hapus") {
			$this->db->query("DELETE FROM tr_guru_tes WHERE id = '".$uri4."'");
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "hapus sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "data") {
				$start = $this->input->post('start');
		        $length = $this->input->post('length');
		        $draw = $this->input->post('draw');
		        $search = $this->input->post('search');
		
		
		 $wh = '';

		        if ($a['sess_level'] == "guru") {
					$wh = "a.id_mapel = '".$uri4."' AND a.id_guru = '".$a['sess_konid']."' AND ";
					//a.id_guru = '".$a['sess_konid'].
				} else if ($a['sess_level'] == "admin") {
					$wh = "a.id_mapel = '".$uri4."' AND";
				}

		        $d_total_row = $this->db->query("SELECT a.id
                                		        	FROM tr_guru_tes a
                                		        	INNER JOIN m_mapel b ON a.id_mapel = b.id 
                                		        	WHERE ".$wh." (a.nama_ujian LIKE '%".$search['value']."%' 
                                					OR b.nama LIKE '%".$search['value']."%')")->num_rows();
		    	
		    	//echo $this->db->last_query();

		        $q_datanya = $this->db->query("SELECT a.*, b.nama AS mapel
												FROM tr_guru_tes a
									        	INNER JOIN m_mapel b ON a.id_mapel = b.id 
									        	WHERE ".$wh." (a.nama_ujian LIKE '%".$search['value']."%'
												OR b.nama LIKE '%".$search['value']."%') 
		                                        ORDER BY a.id DESC LIMIT ".$start.", ".$length."")->result_array();
		        $data = array();
		        $no = ($start+1);

		        foreach ($q_datanya as $d) {
		        	$jenis_soal = $d['jenis'] == "acak" ? "Soal diacak" : "Soal urut";
                
		            $data_ok = array();
		            $data_ok[0] = $no++;
		            $data_ok[1] = $d['nama_ujian']."<br>Token : <b>".$d['token']."</b> &nbsp;&nbsp; <a href='#' onclick='return refresh_token(".$d['id'].")' title='Perbarui Token'><i class='fa fa-refresh'></i></a>";
		            $data_ok[2] = $d['mapel'];
		            $data_ok[3] = $d['jumlah_soal'];
		            $data_ok[4] = tjs($d['tgl_mulai'],"s")."<br>(".$d['waktu']." menit)";
					$data_ok[5] = $jenis_soal;
					$data_ok[6] = $d['verifikasi'] ? "Sudah Diverifikasi" : "Belum Diverifikasi" ;
					if($a['sess_level'] == "admin"){
					if($d['verifikasi'] == 0){
					$data_ok[7] = '<div class="btn-group">
                         		
									<a href="#" onclick="return m_ujian_v('.$d['id'].');" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-remove" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Verifikasi</a>
									<a href="#" onclick="return m_ujian_h('.$d['id'].');" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Hapus</a>
								   </div>';
					}else{
					$data_ok[7] = '<div class="btn-group">
				 				  
								   <a href="#" onclick="return m_ujian_h('.$d['id'].');" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Hapus</a>
						  		   </div>';
					}	}else if ($a['sess_level'] == "guru"){;
						$data_ok[7] = '<div class="btn-group">
						<a href="#" onclick="return m_ujian_e('.$d['id'].');" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-pencil" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Edit</a>
					   <a href="#" onclick="return m_ujian_h('.$d['id'].');" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Hapus</a>
						 </div>';
						};
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
		} else if ($uri3 == "refresh_token") {
			$token = strtoupper(random_string('alpha', 5));

			$this->db->query("UPDATE tr_guru_tes SET token = '$token' WHERE id = '$uri4'");

			$ret_arr['status'] = "ok";
			j($ret_arr);
			exit();
		} else {
			$a['p']	= "m_guru_tes";
		}
		if($a['sess_level'] == "admin"){
		cek_hakakses(array("admin"), $this->session->userdata('admin_level'));
		$this->load->view('dashboard/template/header', $a);
		$this->load->view('dashboard/template/navbar3', $a);
		$this->load->view('dashboard/admin/verifikasisoal', $a);
		$this->load->view('dashboard/template/footer', $a);
		}else if ($a['sess_level'] == "guru"){
			cek_hakakses(array("guru"), $this->session->userdata('admin_level'));
			$this->load->view('dashboard/template/header', $a);
			$this->load->view('dashboard/template/navbar3', $a);
			$this->load->view('dashboard/trainer/tambah_ujian', $a);
			$this->load->view('dashboard/template/footer', $a);
		}
	}

    public function get_akhir($tabel, $field, $kode_awal, $pad) {
		$get_akhir	= $this->db->query("SELECT MAX($field) AS max FROM $tabel LIMIT 1")->row();
		$data		= (intval($get_akhir->max)) + 1;
		$last		= $kode_awal.str_pad($data, $pad, '0', STR_PAD_LEFT);
	
		return $last;
	}

	public function import_soal(){
		$post = $this->input->post();

		$this->load->library('PDF2Text');

		if (!empty($_FILES["file_import"]['name'])) {

			$file = $_FILES["file_import"]['name'];
			$ifile = str_replace(" ", "_", $file);
			/*$new_name = time()."_trainer".'_'.date('YmdHis');*/
			$new_name = 'a';
			$config['upload_path'] = 'assets/materi/pdf/';
			$config['allowed_types'] = 'pdf';
			$config['max-size'] =  2048;
			$config['file_name'] = $new_name;

			$this->load->library('upload', $config);
			$this->upload->initialize($config);


			if($this->upload->do_upload("file_import")){
				$info = $this->upload->data();

				//$photo = $info['raw_name'].$info['file_ext'];
	
				$full_path = $info['full_path'];
				$data = $this->file_reads($full_path);

				foreach ($data as $key => $value) {
					$datas[$key]['soal'] = $value['soal'];
					$datas[$key]['opsi_a'] = '#####'.$value['opsi_a'];
					$datas[$key]['opsi_b'] = '#####'.$value['opsi_b'];
					$datas[$key]['opsi_c'] = '#####'.$value['opsi_c'];
					$datas[$key]['opsi_d'] = '#####'.$value['opsi_d'];
					$datas[$key]['jawaban'] = $value['jawaban'];
					$datas[$key]['bobot'] = $value['bobot'];
					$datas[$key]['id_guru'] = $post['id_guru'];
					$datas[$key]['id_mapel'] = $post['id_mapel'];
				}


				$kirim = $this->db->insert_batch('m_soal',$datas);
				if ($kirim) {
					$ret_arr['status'] 	= 1;
					$ret_arr['message']	= 'berhasil';
					unlink($full_path);
				}else{
					$ret_arr['status'] 	= 0;
					$ret_arr['message']	= 'terjadi kesalahan';
				}
		
				
			}else{

				$error= $this->upload->display_errors();

				$ret_arr['status'] 	= 0;
				$ret_arr['message']	= $error;

			}
			

		}else{
			$ret_arr['status'] 	= 0;
			$ret_arr['message']	= 'File Belum di pilih!';
		}

		j($ret_arr);
		exit();
	} 

	public function file_reads($file)
	{	

		$a = new PDF2Text();
		$a->setFilename($file);
		$a->decodePDF();

		$data = explode('**',$a->output());
		$x=0;
		foreach ($data as $rows) {
			if(isset($rows) && !empty($rows)){
				$soal = trim(preg_replace('/\s\s+/', ' ', $rows));
				$jwb = explode('/',$soal);

				for ($i=1; $i < 6 ; $i++) { 
					if ($i < 5) {
						$jwbs  = trim(preg_replace('/\s\s+/', ' ', $jwb[$i]));
						$jawaban[$x][] = substr($jwbs, strpos($jwbs, ".") + 1);
					}else{
						 $kunci = trim(preg_replace('/\s\s+/', ' ', $jwb[$i]));
						 $kun   = explode('-',$kunci);
						 $kunciJawaban = trim(preg_replace('/\s\s+/', ' ', $kun[0]));
						 $bobotJawaban = trim(preg_replace('/\s\s+/', ' ', $kun[1]));
					}

					
					
				}
				

				$datas[$x]['soal']    = $jwb[0];
				
				$a='a';
				foreach ($jawaban[$x] as $ket => $value) {
					$datas[$x]['opsi_'.$a] = $value;
					$a++;
				}
				
				$datas[$x]['jawaban']   = $kunciJawaban;
				$datas[$x]['bobot']   = $bobotJawaban;

			}else{
				
			}
			$x++;
		}

		return $datas;

		/*$pdata = array(
				"id_guru"=>$p['id_guru'],
				"id_mapel"=>$p['id_mapel'],
				"bobot"=>$p['bobot'],
				"soal"=>$p['soal'],
				"jawaban"=>$p['jawaban'],
			);
*/

	}

	public function page_load($pg = 1) {
		$this->load->model('m_mapel_cs');
		$post = $this->input->post();
		$limit = $post['limit'];
		$where = [];

		if($this->log_lvl == 'guru'){
			$where['gr.id'] = $this->log_id;
		}

		if(!empty($post['search'])) {
			$where["(lower(mp.nama) like '%".strtolower($post['search'])."%' )"] = null;
		}

		$paginate = $this->m_mapel_cs->paginate($pg,$where,$limit);
		$data['paginate'] = $paginate;
		$data['paginate']['url']	= 'soal/page_load';
		$data['paginate']['search'] = 'lookup_key';
		$data['page_start'] = $paginate['counts']['from_num'];

		$this->load->view('tes_kemampuan/table', $data);
		$this->generate_page($data);
	}	
}
