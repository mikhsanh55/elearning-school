<?php
 defined('BASEPATH') OR exit('No direct script access allowed');

class Ujian extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->db->query("SET time_zone='+7:00'");
        $waktu_sql = $this->db->query("SELECT NOW() AS waktu")->row_array();
        $this->waktu_sql = $waktu_sql['waktu'];
        $this->opsi = array("a","b","c","d","e");
        $this->load->model('M_guru_tes');
        $this->load->library('dpdf');
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

    public function sanitize_data($data) {
    	$data = trim($data);
    	$data = htmlspecialchars($data);
    	$data = stripcslashes($data);
    	$data = filter_var($data, FILTER_SANITIZE_STRING);
    	if(gettype($data) == 'string') {
    		$data = strval($data);
    	}

    	if(gettype($data) == 'integer' || gettype($data) == 'double' ) {
    		$data = intval($data);
    	}
    	return $data;
    }

    public function get_soal() {

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
    }

    public function lihat_soal() {
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
    	$a['p'] = 'lihat_soal_ujian';

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

    public function update_uts() {
    	if(!$_POST) {
    		echo json_encode(['status' => false, 'msg' => 'Unauthorized user']);
    	}

    	$data = [
    		'id_guru' => $this->session->userdata('admin_konid'),
    		'id_mapel' => $this->sanitize_data($_POST['mapel']),
    		'nama_ujian' => $this->sanitize_data($_POST['nama_ujian']),
    		'jumlah_soal' => $this->sanitize_data($_POST['jumlah_soal']),
    		'tgl_mulai' => $this->sanitize_data($_POST['tgl_mulai']),
    		'tgl_selesai' => $this->sanitize_data($_POST['terlambat']),
    		'waktu' => $this->sanitize_data($_POST['waktu']),
    	];

    	// Cek ketersediaan soal
    	$data_soal = $this->db->query("SELECT id FROM m_soal WHERE id_mapel = '".$data['id_mapel']."' AND id_guru = '".$data['id_guru']."'")->num_rows();

		if ($data_soal < $data['jumlah_soal']) {
			echo json_encode(['status' => false, 'errcode' => 400, 'msg' => 'Jumlah soal kurang dari permintaan!']);
			http_response_code(400);
			return false;
		}

		$data['verifikasi'] = 1;
		$data['token'] = strtoupper(random_string('alpha', 5));
		$data['status_token'] = 1;
    	$this->db->where('id', $_POST['id']);
		$update_data = $this->db->update('tb_uts_uas', $data);
		if($update_data) {
			echo json_encode([
				'status' => TRUE,
				'msg' => 'Ujian berhasil diupdate'
			]);
			http_response_code(200);
		}
		else {
			echo json_encode([
				'status' => FALSE,
				'msg' => 'Something wrong'
			]);

			http_response_code(500);
		}
    }
    /*
	* Edit By ikhsan
	* @Kamis, 2 April 2020 10:05 WIB
	* 
    */ 
    public function tambah_uts() {
    	if(!$_POST) {
    		echo json_encode(['status' => false, 'msg' => 'Unauthorized user']);
    	}

    	$data = [
    		'id_guru' => $this->session->userdata('admin_konid'),
    		'id_mapel' => $this->sanitize_data($_POST['mapel']),
    		'nama_ujian' => $this->sanitize_data($_POST['nama_ujian']),
    		'jumlah_soal' => $this->sanitize_data($_POST['jumlah_soal']),
    		'tgl_mulai' => $this->sanitize_data($_POST['tgl_mulai']),
    		'tgl_selesai' => $this->sanitize_data($_POST['terlambat']),
    		'waktu' => $this->sanitize_data($_POST['waktu']),
    	];

    	// Cek ketersediaan soal
    	$data_soal = $this->db->query("SELECT id FROM m_soal WHERE id_mapel = '".$data['id_mapel']."' AND id_guru = '".$data['id_guru']."'")->num_rows();

		if ($data_soal < $data['jumlah_soal']) {
			echo json_encode(['status' => false, 'errcode' => 400, 'msg' => 'Jumlah soal kurang dari permintaan!']);
			http_response_code(400);
			return false;
		}

		$data['verifikasi'] = 1;
		$data['token'] = strtoupper(random_string('alpha', 5));
		$data['status_token'] = 1;
    	
		$insert_data = $this->db->insert('tb_uts_uas', $data);
		if($insert_data) {
			echo json_encode([
				'status' => TRUE,
				'msg' => 'Ujian berhasil dibuat'
			]);
			http_response_code(200);
		}
		else {
			echo json_encode([
				'status' => FALSE,
				'msg' => 'Something wrong'
			]);

			http_response_code(500);
		}
    }

    /*
	* Edit By ikhsan
	* @Kamis, 2 April 2020 10:05 WIB
	* 
    */ 
    public function uts($id_mapel = NULL) {
    	$this->cek_aktif();
    	cek_hakakses(array("siswa", "guru"), $this->session->userdata('admin_level'));
    	//var def uri segment
        $uri1 = $this->uri->segment(1);
		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
        $uri4 = $this->uri->segment(4);

        // For Menu
    	$data['sess_level'] = $this->session->userdata('admin_level');
		$data['sess_user'] = $this->session->userdata('admin_user');
		$data['sess_konid'] = $this->session->userdata('admin_konid');
		$data['menu'] = $this->db->query("SELECT `nama_menu`, `link`, `link3`, `icon` FROM rule_users JOIN menu ON rule_users.id_menu = menu.id JOIN level ON rule_users.id_level = level.id WHERE level = '".$data['sess_level']."' ")->result_array();
		$data['link'] = $this->db->query("SELECT link3 FROM rule_users JOIN menu ON rule_users.id_menu = menu.id JOIN level ON rule_users.id_level = level.id WHERE link3 = '".$uri1."' AND level = '".$data['sess_level']."' ")->result_array();

		if($id_mapel == NULL) {
			if($data['sess_level'] == 'siswa') {
				$data['data_ujian'] = $this->db->query("SELECT 
									tes.id, tes.*, tes.jumlah_soal, tes.waktu,
									tes.status_token, mapel.nama nama_mapel,
									guru.nama nama_guru
									FROM tb_uts_uas tes
									INNER JOIN m_mapel mapel ON tes.id_mapel = mapel.id
									INNER JOIN m_guru guru ON tes.id_guru = guru.id 
									WHERE tes.verifikasi = 1
									ORDER BY tes.id DESC")->result();
			}
			else {
				$data['data_ujian'] = $this->db->query("SELECT 
									tes.id, tes.*, tes.jumlah_soal, tes.waktu,
									tes.status_token, mapel.nama nama_mapel,
									guru.nama nama_guru
									FROM tb_uts_uas tes
									INNER JOIN m_mapel mapel ON tes.id_mapel = mapel.id
									INNER JOIN m_guru guru ON tes.id_guru = guru.id 
									ORDER BY tes.id DESC")->result();
			}
		}
		else {
			if($data['sess_level'] == 'siswa') {
				$data['data_ujian'] = $this->db->query("SELECT 
									tes.id, tes.*, tes.jumlah_soal, tes.waktu,
									tes.status_token, mapel.nama nama_mapel,
									guru.nama nama_guru
									FROM tb_uts_uas tes
									INNER JOIN m_mapel mapel ON tes.id_mapel = mapel.id
									INNER JOIN m_guru guru ON tes.id_guru = guru.id 
									WHERE tes.verifikasi = 1 AND tes.id = $id_mapel
									ORDER BY tes.id DESC")->row();
			}
			else {
				$data['data_ujian'] = $this->db->query("SELECT 
									tes.id, tes.*, tes.jumlah_soal, tes.waktu,
									tes.status_token, mapel.nama nama_mapel,
									guru.nama nama_guru
									FROM tb_uts_uas tes
									INNER JOIN m_mapel mapel ON tes.id_mapel = mapel.id
									INNER JOIN m_guru guru ON tes.id_guru = guru.id 
									WHERE tes.id = $id_mapel
									ORDER BY tes.id DESC")->row();
			}

			$data['mapel'] = $this->db->query("SELECT * FROM m_mapel")->result();
			echo json_encode(['status' => true, 'data' => $data['data_ujian'], 'mapel' => $data['mapel']]);
			http_response_code(200);
			return true;
		}

		$data['mapel'] = $this->db->query("SELECT * FROM m_mapel");
		// Pres P or page
		$data['p'] = 'ujian_uts_uas';
		$this->load->view('dashboard/template/header', $data);
		$this->load->view('dashboard/template/navbar3', $data);
		$this->load->view('ujian/ujian_uts_uas', $data);
		$this->load->view('dashboard/template/footer', $data);
    }
    
    public function ikuti_ujian($id_mapel) {
		$this->cek_aktif();
		cek_hakakses(array("siswa"), $this->session->userdata('admin_level'));
        
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
		$a['link'] = $this->db->query("SELECT link3 FROM rule_users JOIN menu ON rule_users.id_menu = menu.id JOIN level ON rule_users.id_level = level.id WHERE link3 = '".$uri1."' AND level = '".$a['sess_level']."' ")->result_array();
		
		// var_dump($a['']);
		// die;
		//var post from json
		$p = json_decode(file_get_contents('php://input'));
		//return as json
		$jeson = array();
		//$a['sess_konid']
		if ($a['sess_level'] == 'siswa') {
				$a['data'] = $this->db->query("SELECT 
									a.id, a.*, a.jumlah_soal, a.waktu,
									a.status_token, b.nama nmmapel,
									c.nama nmguru,
									(SELECT max(nilai) FROM tr_ikut_ujian WHERE id_tes = a.id AND id_user = ".$a['sess_konid']." ) as hasil
									FROM tr_guru_tes a
									INNER JOIN m_mapel b ON a.id_mapel = b.id
									INNER JOIN m_guru c ON a.id_guru = c.id 
									WHERE a.verifikasi = 1 AND md5(b.id) = '".$id_mapel."'
									ORDER BY a.id ASC")->result();
				
		}else{
				$a['data'] = $this->db->query("SELECT 
									a.id, a.*, a.jumlah_soal, a.waktu,
									a.status_token, b.nama nmmapel,
									c.nama nmguru
									FROM tr_guru_tes a
									INNER JOIN m_mapel b ON a.id_mapel = b.id
									INNER JOIN m_guru c ON a.id_guru = c.id 
									WHERE a.verifikasi = 1 AND md5(b.id) = '".$id_mapel."'
									ORDER BY a.id ASC")->result();
		}


	
		// $a['hasil'] = $this->db->query("SELECT 
		// 								IF((tr_ikut_ujian.status='Y' AND NOW() BETWEEN tr_ikut_ujian.tgl_mulai AND tr_ikut_ujian.tgl_selesai),'Sedang Tes',
		// 								IF(tr_ikut_ujian.status='Y' AND NOW() NOT BETWEEN tr_ikut_ujian.tgl_mulai AND tr_ikut_ujian.tgl_selesai,'Waktu Habis',
		// 								IF(tr_ikut_ujian.status='N','Selesai','Belum Ikut'))) status 	
		// 								FROM tr_ikut_ujian JOIN tr_guru_tes WHERE id_user = '".$a['sess_konid']."' AND  tr_ikut_ujian.id_tes = tr_guru_tes.id ")->result();
		
		$a['p']	= "m_list_ujian_siswa";
		$a['id_mapel'] = $id_mapel;
		$this->load->view('dashboard/template/header', $a);
		$this->load->view('dashboard/template/navbar3', $a);
		$this->load->view('dashboard/user/asesment', $a);
		$this->load->view('dashboard/template/footer', $a);
	}
	


    public function ikut_ujian() {

		$this->cek_aktif();
		cek_hakakses(array("siswa"), $this->session->userdata('admin_level'));
        
        //var def uri segment
        $uri1 = $this->uri->segment(1);
		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		$uri5 = $this->uri->segment(5);
		$id_tes = abs($uri4);

		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');
		
		$a['menu'] = $this->db->query("SELECT `nama_menu`, `link`, `link3`, `icon` FROM rule_users JOIN menu ON rule_users.id_menu = menu.id JOIN level ON rule_users.id_level = level.id WHERE level = '".$a['sess_level']."' ")->result_array();
		$a['link'] = $this->db->query("SELECT link3 FROM rule_users JOIN menu ON rule_users.id_menu = menu.id JOIN level ON rule_users.id_level = level.id WHERE link3 = '".$uri1."' AND level = '".$a['sess_level']."' ")->result_array();
		
		// var_dump($a['menu']);
		// die;
		//var post from json
		$p = json_decode(file_get_contents('php://input'));
		$a['detil_user'] = $this->db->query("SELECT * FROM m_siswa WHERE id = '".$a['sess_konid']."'")->row();
		if ($uri3 == "simpan_satu") {
			$p			= json_decode(file_get_contents('php://input'));
			$update_ 	= "";
			for ($i = 1; $i < $p->jml_soal; $i++) {
				$_tjawab 	= "opsi_".$i;
				$_tidsoal 	= "id_soal_".$i;
				$_ragu 		= "rg_".$i;
				$jawaban_ 	= empty($p->$_tjawab) ? "" : $p->$_tjawab;
				$update_	.= "".$p->$_tidsoal.":".$jawaban_.":".$p->$_ragu.",";
			}
			$update_		= substr($update_, 0, -1);
			$this->db->query("UPDATE tr_ikut_ujian SET list_jawaban = '".$update_."' WHERE id_penggunaan = '$uri5' AND id_tes = '$id_tes' AND id_user = '".$a['sess_konid']."'");
			$cek = $this->db->query("SELECT * from tr_ikut_ujian where id_tes = " . $uri4 . " and id_user = " . $a['sess_konid'] . "");
			$cek_ujian_pertama = $this->db->query("SELECT * from tr_ikut_ujian_pertama where id_tes = " . $uri4 . " and id_user = " . $a['sess_konid'] . "");
			if($cek_ujian_pertama->num_rows() == 1 ) {
				if($cek->num_rows() == 1) {
					$this->db->query("UPDATE tr_ikut_ujian_pertama SET list_jawaban = '".$update_."' WHERE id_penggunaan = '$uri5' AND id_tes = '$id_tes' AND id_user = '".$a['sess_konid']."'");
				}
				
			}
			//echo $this->db->last_query();

			$q_ret_urn 	= $this->db->query("SELECT list_jawaban FROM tr_ikut_ujian WHERE status = 'Y' AND id_tes = '$uri4' AND id_user = '".$a['sess_konid']."'");
			$d_ret_urn 	= $q_ret_urn->row_array();
			$ret_urn 	= explode(",", $d_ret_urn['list_jawaban']);
			$hasil 		= array();
			foreach ($ret_urn as $key => $value) {
				$pc_ret_urn = explode(":", $value);
				$idx 		= $pc_ret_urn[0];
				$val 		= $pc_ret_urn[1].'_'.$pc_ret_urn[2];
				$hasil[]= $val;
			}

			$d['data'] = $hasil;
			$d['status'] = "ok";
			j($d);
			exit;		

		} else if ($uri3 == "simpan_akhir") {
			
			$id_tes = abs($uri4);
			$get_jawaban = $this->db->query("SELECT list_jawaban FROM tr_ikut_ujian WHERE status = 'Y' AND id_tes = '$uri4' AND id_user = '".$a['sess_konid']."'")->row_array();
			$pc_jawaban = explode(",", $get_jawaban['list_jawaban']);
			$jumlah_benar 	= 0;
			$jumlah_salah 	= 0;
			$jumlah_ragu  	= 0;
			$nilai_bobot 	= 0;
			$total_bobot	= 0;
			$jumlah_soal	= sizeof($pc_jawaban);

			for ($x = 0; $x < $jumlah_soal; $x++) {
				$pc_dt = explode(":", $pc_jawaban[$x]);
				$id_soal 	= $pc_dt[0];
				$jawaban 	= $pc_dt[1];
				$ragu 		= $pc_dt[2];
				$cek_jwb 	= $this->db->query("SELECT bobot, jawaban FROM m_soal WHERE id = '".$id_soal."'")->row();
				$total_bobot = $total_bobot + $cek_jwb->bobot;
				
				if (($cek_jwb->jawaban == $jawaban)) {
					//jika jawaban benar 
					$jumlah_benar++;
					$nilai_bobot = $nilai_bobot + $cek_jwb->bobot;
					$q_update_jwb = "UPDATE m_soal SET jml_benar = jml_benar + 1 WHERE id = '".$id_soal."'";
				} else {
					//jika jawaban salah
					$jumlah_salah++;
					$q_update_jwb = "UPDATE m_soal SET jml_salah = jml_salah + 1 WHERE id = '".$id_soal."'";
				}
				$this->db->query($q_update_jwb);
			}

			$nilai = ($jumlah_benar / $jumlah_soal)  * 100;
			$nilai_bobot = ($nilai_bobot / $total_bobot)  * 100;
			

			$a_banyak		= $this->db->query("SELECT SUM(banyak) AS jumlah FROM tr_ikut_ujian")->row();
			$this->db->query("UPDATE tr_guru_tes SET penggunaan = '$a_banyak->jumlah' WHERE id = '$id_tes' ");

			$this->db->query("UPDATE tr_ikut_ujian SET jml_benar = '$jumlah_benar', nilai = '$nilai', nilai_bobot = '$nilai_bobot', status = 'N',tgl_selesai= '".date('Y-m-d H:i:s')."' WHERE status = 'Y' AND id_tes = '$id_tes' AND id_user = '".$a['sess_konid']."'");
			
			$cek = $this->db->query("SELECT * from tr_ikut_ujian where id_tes = " . $uri4 . " and id_user = " . $a['sess_konid'] . "");
			$cek_ujian_pertama = $this->db->query("SELECT * from tr_ikut_ujian_pertama where id_tes = " . $uri4 . " and id_user = " . $a['sess_konid'] . "");

			if($cek_ujian_pertama->num_rows() == 1 ) {
				if($cek->num_rows() > 0) {
					$this->db->query("UPDATE tr_ikut_ujian_pertama SET jml_benar = '.$jumlah_benar.', nilai = '.$nilai.', nilai_bobot = '.$nilai_bobot.', status = 'N' WHERE status = 'Y' AND id_tes = '$id_tes' AND id_user = '".$a['sess_konid']."'");
					
				}

				$this->session->set_userdata(array('selesai_ujian'=>1));

			
			}
			$a['status'] = "ok";
			j($a);
			exit;		
		} else if ($uri3 == "token") {
			header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			$id_tes = abs($uri4);
			$a['du'] = $this->db->query("SELECT a.id, a.penggunaan, a.tgl_mulai, a.terlambat, 
										a.token, a.nama_ujian, a.jumlah_soal, a.waktu,
										a.status_token, b.nama nmguru, c.nama nmmapel,
										(case
											when (now() < a.tgl_mulai) then 0
											when (now() >= a.tgl_mulai and now() <= a.terlambat) then 1
											else 2
										end) statuse
										FROM tr_guru_tes a 
										INNER JOIN m_guru b ON a.id_guru = b.id
										INNER JOIN m_mapel c ON a.id_mapel = c.id 
										WHERE a.id = '$uri4'")->row_array();

		
			$a['dp'] = $this->db->query("SELECT * FROM m_siswa WHERE id = '".$a['sess_konid']."'")->row_array();
			//$q_status = $this->db->query();

			if (!empty($a['du']) || !empty($a['dp'])) {
				$tgl_selesai = $a['du']['tgl_mulai'];
			    //$tgl_selesai2 = strtotime($tgl_selesai);
			    //$tgl_baru = date('F j, Y H:i:s', $tgl_selesai);

			    //$tgl_terlambat = strtotime("+".$a['du']['terlambat']." minutes", $tgl_selesai2);	
				$tgl_terlambat_baru = $a['du']['terlambat'];

				$a['tgl_mulai'] = $tgl_selesai;
				$a['terlambat'] = $tgl_terlambat_baru;

				$a['p']	= "m_token";

		$cek = $this->db->query("
							SELECT
								count(ujian.id) as jmlh,
								tes.id_mapel
							FROM
								tr_ikut_ujian ujian
								INNER JOIN tr_guru_tes tes ON tes.id = ujian.id_tes 
							WHERE id_tes = '$uri4' AND id_user = '".$a['sess_konid']."' AND status = 'N'
				")->row();

		if ($cek->jmlh > $this->jumlah_pengecekan_ujian_selesai) {
			redirect('ujian/ikuti_ujian/'.md5($cek->id_mapel));
			exit;
		}

		$this->session->set_userdata(array('selesai_ujian'=>0));

		$this->load->view('dashboard/template/header', $a);
		$this->load->view('dashboard/template/navbar3', $a);
		$this->load->view('dashboard/user/token', $a);
		$this->load->view('dashboard/template/footer', $a);
			} else {
				redirect('ujian/ikuti_ujian');
			}
		} else {

			if ($this->session->userdata('selesai_ujian') == 1) {
				$cek = $this->db->query("
					SELECT
					count(ujian.id) as jmlh,
					tes.id_mapel
					FROM
					tr_ikut_ujian ujian
					INNER JOIN tr_guru_tes tes ON tes.id = ujian.id_tes 
					WHERE id_tes = '$uri4' AND id_user = '".$a['sess_konid']."'
					")->row();

				redirect('ujian/ikuti_ujian/'.md5($cek->id_mapel));
				exit;
			}
			
			header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			
			$cek_sdh_selesai= $this->db->query("SELECT id FROM tr_ikut_ujian WHERE id_tes = '$uri4' AND id_user = '".$a['sess_konid']."' AND status = 'N'")->num_rows();

		
			//sekalian validasi waktu sudah berlalu...
			if ($cek_sdh_selesai <= $this->jumlah_pengecekan_ujian_selesai) {
				//ini jika ujian belum tercatat, belum ikut
				//ambil detil soal

		
				$cek_detil_tes = $this->db->query("SELECT * FROM tr_guru_tes WHERE id = '$uri4'")->row();
				$q_cek_sdh_ujian= $this->db->query("SELECT id FROM tr_ikut_ujian WHERE id_penggunaan = '$uri5' AND id_tes = '$uri4' AND id_user = '".$a['sess_konid']."'");
				$d_cek_sdh_ujian= $q_cek_sdh_ujian->row();
				$cek_sdh_ujian	= $q_cek_sdh_ujian->num_rows();
				
				$acakan = $cek_detil_tes->jenis == "ORDER BY id ASC";

				$total_session = $this->db->where(array('id_guru'=>$cek_detil_tes->id_guru,'id_mapel'=>$cek_detil_tes->id_mapel))->get('tr_guru_tes')->result();
				$offset = 0;
				if (count($total_session) > 0) {
					foreach ($total_session as $row) {
						$offset += $row->jumlah_soal;
					}
				}

				

				$to = $cek_detil_tes->jumlah_soal;
				
				if ($cek_sdh_ujian <= $this->jumlah_pengecekan_ujian_selesai)	{		
					$soal_urut_ok = array();
					$a_soal			= $this->db->query("SELECT id, file, jawaban, tipe_file, soal, opsi_a, opsi_b, opsi_c, opsi_d, opsi_e FROM m_soal WHERE id_mapel = '".$cek_detil_tes->id_mapel."' AND id_guru = '".$cek_detil_tes->id_guru."' ".$acakan." LIMIT ".$offset.", ".$to)->result();
					
					$q_soal			= $this->db->query("SELECT id, file, jawaban, tipe_file, soal, opsi_a, opsi_b, opsi_c, opsi_d, opsi_e, '' AS jawaban FROM m_soal WHERE id_mapel = '".$cek_detil_tes->id_mapel."' AND id_guru = '".$cek_detil_tes->id_guru."' ".$acakan." LIMIT ".$offset.", ".$to)->result();
					
					$i = 0;
					foreach ($q_soal as $s) {
						$soal_per = new stdClass();
						$soal_per->id = $s->id;
						$soal_per->soal = $s->soal;
						$soal_per->file = $s->file;
						$soal_per->tipe_file = $s->tipe_file;
						$soal_per->opsi_a = $s->opsi_a;
						$soal_per->opsi_b = $s->opsi_b;
						$soal_per->opsi_c = $s->opsi_c;
						$soal_per->opsi_d = $s->opsi_d;
						$soal_per->opsi_e = $s->opsi_e;
						$soal_per->jawaban = $s->jawaban;
						$soal_urut_ok[$i] = $soal_per;
						$i++;
					}
					$soal_urut_ok = $soal_urut_ok;
					
					$list_id_soal	= "";
					$list_jw_soal 	= "";
					$list_jw_benar  = "";
					if (!empty($q_soal)) {
						foreach ($q_soal as $d) {
							$list_id_soal .= $d->id.",";
							$list_jw_soal .= $d->id."::N,";
							
						}
						foreach ($a_soal as $d) {
							$list_jw_benar .= $d->id.":".$d->jawaban.":N,";
						}
					}
					$list_id_soal = substr($list_id_soal, 0, -1);
					$list_jw_soal = substr($list_jw_soal, 0, -1);
					$list_jw_benar = substr($list_jw_benar, 0, -1);
					$waktu_selesai = tambah_jam_sql($cek_detil_tes->waktu);
					$time_mulai		= date('Y-m-d H:i:s');
					
					$cek_sts = $this->db->query("SELECT id,status from tr_ikut_ujian where id_tes = " . $uri4 . " and id_user = " . $a['sess_konid'] . " ORDER BY id DESC")->row();
					
					if (empty($cek_sts->status)) {
						$status_ = 'N';
					}else{
						$status_ = $cek_sts->status;
					}


					if ($status_ != 'Y') {
						
						$this->db->query("INSERT INTO tr_ikut_ujian VALUES (null, '$uri4', '$uri5', '".$a['sess_konid']."', '$list_id_soal', '$list_jw_soal', 0, 0, 0, '$time_mulai', ADDTIME('$time_mulai', '$waktu_selesai'), 'Y', '$list_jw_benar', 1)");
					}


					
					$cek_ujian_pertama = $this->db->query("SELECT count(*) as total from tr_ikut_ujian_pertama where id_tes = " . $uri4 . " and id_user = " . $a['sess_konid'] . "")->row();
					

					if($cek_ujian_pertama->total < 1) {
						$this->db->query("INSERT INTO tr_ikut_ujian_pertama VALUES (null, '$uri4', '$uri5', '".$a['sess_konid']."', '$list_id_soal', '$list_jw_soal', 0, 0, 0, '$time_mulai', ADDTIME('$time_mulai', '$waktu_selesai'), 'N', '$list_jw_benar', 1)");
					}
					$detil_tes = $this->db->query("SELECT * FROM tr_ikut_ujian WHERE status = 'Y' AND id_tes = '$uri4' AND id_user = '".$a['sess_konid']."'")->row();

					//echo $this->db->last_query();exit;

					$soal_urut_ok= $soal_urut_ok;
				} else {
					$q_ambil_soal 	= $this->db->query("SELECT * FROM tr_ikut_ujian WHERE id_penggunaan = '$uri5' AND id_tes = '$uri4' AND id_user = '".$a['sess_konid']."'")->row();

					$urut_soal 		= explode(",", $q_ambil_soal->list_jawaban);

					$soal_urut_ok	= array();
					for ($i = 0; $i < sizeof($urut_soal); $i++) {
						$pc_urut_soal = explode(":",$urut_soal[$i]);
						$pc_urut_soal1 = empty($pc_urut_soal[1]) ? "''" : "'".$pc_urut_soal[1]."'";
						$ambil_soal = $this->db->query("SELECT *, $pc_urut_soal1 AS jawaban FROM m_soal WHERE id = '".$pc_urut_soal[0]."'")->row();
						$soal_urut_ok[] = $ambil_soal; 
					}
					
					$detil_tes = $q_ambil_soal;
					$soal_urut_ok = $soal_urut_ok;
				}



				

				$pc_list_jawaban = explode(",", $detil_tes->list_jawaban);

				$arr_jawab = array();
				foreach ($pc_list_jawaban as $v) {
				  $pc_v = explode(":", $v);
				  $idx = $pc_v[0];
				  $val = $pc_v[1];
				  $rg = $pc_v[2];
				  $arr_jawab[$idx] = array("j"=>$val,"r"=>$rg);
				}

				$html = '';
				$no = 1;
				if (!empty($soal_urut_ok)) {
					
				    foreach ($soal_urut_ok as $d) { 
				        $tampil_media = tampil_media("./upload/gambar_soal/".$d->file, '250px','auto');
				        $vrg = $arr_jawab[$d->id]["r"] == "" ? "N" : $arr_jawab[$d->id]["r"];

				        $html .= '<input type="hidden" name="id_soal_'.$no.'" value="'.$d->id.'">';
				        $html .= '<input type="hidden" name="rg_'.$no.'" id="rg_'.$no.'" value="'.$vrg.'">';
				        $html .= '<div class="step" id="widget_'.$no.'">';
				        $html .= $d->soal.'<br>'.$tampil_media.'<div class="funkyradio">';

				        for ($j = 0; $j < $this->config->item('jml_opsi'); $j++) {
				            $opsi = "opsi_".$this->opsi[$j];
				            $checked = $arr_jawab[$d->id]["j"] == strtoupper($this->opsi[$j]) ? "checked" : "";
				            $pc_pilihan_opsi = explode("#####", $d->$opsi);
				            $tampil_media_opsi = (is_file('./upload/gambar_soal/'.$pc_pilihan_opsi[0]) || $pc_pilihan_opsi[0] != "") ? tampil_media('./upload/gambar_opsi/'.$pc_pilihan_opsi[0],'250px','auto') : '';
					    	$pilihan_opsi = empty($pc_pilihan_opsi[1]) ? "-" : $pc_pilihan_opsi[1];
					    
				            $html .= '<div class="funkyradio-success" onclick="return simpan_sementara();">
				                <input type="radio" id="opsi_'.strtoupper($this->opsi[$j]).'_'.$d->id.'" name="opsi_'.$no.'" value="'.strtoupper($this->opsi[$j]).'" '.$checked.'> <label for="opsi_'.strtoupper($this->opsi[$j]).'_'.$d->id.'"><div class="huruf_opsi">'.$this->opsi[$j].'</div> <p>'.$pilihan_opsi.'</p><p>'.$tampil_media_opsi.'</p></label></div>';
				        }
				        $html .= '</div></div>';
				        $no++;
				    }
				}

				$a['jam_mulai'] = $detil_tes->tgl_mulai;
				$a['jam_selesai'] = $detil_tes->tgl_selesai;
				$a['id_tes'] = $cek_detil_tes->id;
				$a['no'] = $no;
				$a['html'] = $html;


				$this->load->view('v_ujian', $a);
			} else {
				//redirect('ujian/sudah_selesai_ujian/'.$uri4);
			}
		}

    }
    



	

	public function jvs() {
		$this->cek_aktif();
		$data_soal 		= $this->db->query("SELECT id, gambar, soal, opsi_a, opsi_b, opsi_c, opsi_d, opsi_e FROM m_soal ORDER BY RAND()")->result();
		j($data_soal);
		exit;
	}

//Table Riwayat Ujian
	public function sudah_selesai_ujian($id,$mapel=null) {
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
		$a['link'] = $this->db->query("SELECT link3 FROM rule_users JOIN menu ON rule_users.id_menu = menu.id JOIN level ON rule_users.id_level = level.id WHERE link3 = '".$uri1."' AND level = '".$a['sess_level']."' ")->result_array();

		$a['data'] = $this->db->query("SELECT id, id_tes, nilai, jml_benar, tgl_mulai, tgl_selesai FROM tr_ikut_ujian WHERE id_tes = $uri3 AND id_user = '".$a['sess_konid']."' AND status = 'N'")->result_array();
		//echo $this->db->last_query();exit();
	
	$a['p'] = "v_selesai_ujian";
	$a['id_'] = $mapel;

		$this->load->view('dashboard/template/header', $a);
		$this->load->view('dashboard/template/navbar3', $a);
		$this->load->view('dashboard/user/selesai', $a);
		$this->load->view('dashboard/template/footer', $a);
	}

	



//Riwayat Ujian 
public function ikut_ujian_hasil() {
	$this->cek_aktif();
	cek_hakakses(array("siswa"), $this->session->userdata('admin_level'));
	
	//var def uri segment
	$uri1 = $this->uri->segment(1);
	$uri2 = $this->uri->segment(2);
	$uri3 = $this->uri->segment(3);
	$uri4 = $this->uri->segment(4);

	//var def session
	$a['sess_level'] = $this->session->userdata('admin_level');
	$a['sess_user'] = $this->session->userdata('admin_user');
	$a['sess_konid'] = $this->session->userdata('admin_konid');
	$a['menu'] = $this->db->query("SELECT `nama_menu`, `link`, `link2`, `icon` FROM rule_users JOIN menu ON rule_users.id_menu = menu.id JOIN level ON rule_users.id_level = level.id WHERE level = '".$a['sess_level']."' ")->result_array();
	$a['link'] = $this->db->query("SELECT link2 FROM rule_users JOIN menu ON rule_users.id_menu = menu.id JOIN level ON rule_users.id_level = level.id WHERE link2 = '".$uri1."/".$uri2."' AND level = '".$a['sess_level']."' ")->result_array();
	// print_r($a['link']);
	// die;

	
	//var post from json
	$p = json_decode(file_get_contents('php://input'));
	$a['detil_user'] = $this->db->query("SELECT * FROM m_siswa WHERE id = '".$a['sess_konid']."'")->row();
		
	
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");


		//hasil Jawaban
		$cek_detil_tes = $this->db->query("SELECT * FROM tr_guru_tes WHERE id = '$uri4'")->row();
		$q_cek_sdh_ujian= $this->db->query("SELECT id FROM tr_ikut_ujian WHERE id = '$uri3' AND id_tes = '$uri4' AND id_user = '".$a['sess_konid']."'");
		$d_cek_sdh_ujian= $q_cek_sdh_ujian->row();
		$cek_sdh_ujian	= $q_cek_sdh_ujian->num_rows();
		$acakan = $cek_detil_tes->jenis == "acak" ? "ORDER BY RAND()" : "ORDER BY id ASC";
			$q_ambil_soal 	= $this->db->query("SELECT * FROM tr_ikut_ujian WHERE id = '$uri3' AND id_tes = '$uri4' AND id_user = '".$a['sess_konid']."'")->row();
			$urut_soal 		= explode(",", $q_ambil_soal->list_jawaban);
			$soal_urut_ok	= array();
			for ($i = 0; $i < sizeof($urut_soal); $i++) {
				$pc_urut_soal = explode(":",$urut_soal[$i]);
				$pc_urut_soal1 = empty($pc_urut_soal[1]) ? "''" : "'".$pc_urut_soal[1]."'";
				$ambil_soal = $this->db->query("SELECT *, $pc_urut_soal1 AS jawaban FROM m_soal WHERE id = '".$pc_urut_soal[0]."'")->row();
				$soal_urut_ok[] = $ambil_soal; 
			}
			$detil_tes = $q_ambil_soal;
			$soal_urut_ok = $soal_urut_ok;

		$pc_list_jawaban = explode(",", $detil_tes->list_jawaban);
		$arr_jawab = array();
		foreach ($pc_list_jawaban as $v) {
		  $pc_v = explode(":", $v);
		  $idx = $pc_v[0];
		  $val = $pc_v[1];
		  $rg = $pc_v[2];
		  $arr_jawab[$idx] = array("j"=>$val,"r"=>$rg);
		}
		$html = '';
		$no = 1;


		//Jawaban Benar
		$cek_detil_tes1 = $this->db->query("SELECT * FROM tr_guru_tes WHERE id = '$uri4'")->row();
		$acakan1 = $cek_detil_tes1->jenis == "acak" ? "ORDER BY RAND()" : "ORDER BY id ASC";
			$q_ambil_soal1 	= $this->db->query("SELECT * FROM tr_ikut_ujian WHERE id = '$uri3' AND id_tes = '$uri4' AND id_user = '".$a['sess_konid']."'")->row();
			$urut_soal1 	= explode(",", $q_ambil_soal1->jawaban_benar);
			$soal_urut_ok1	= array();
			for ($i = 0; $i < sizeof($urut_soal1); $i++) {
				$pc_urut_soal1 = explode(":",$urut_soal1[$i]);
				$pc_urut_soal1 = empty($pc_urut_soal1[1]) ? "''" : "'".$pc_urut_soal1[1]."'";
				$ambil_soal1 = $this->db->query("SELECT *, $pc_urut_soal1 AS jawaban FROM m_soal WHERE id = '".$pc_urut_soal[0]."'")->row();
				$soal_urut_ok1[] = $ambil_soal1; 
			}

		$detil_tes1 = $q_ambil_soal1;
		$soal_urut_ok1 = $soal_urut_ok1;
		$pc_list_jawaban1 = explode(",", $detil_tes1->jawaban_benar);
		$arr_jawab1 = array();
		foreach ($pc_list_jawaban1 as $v) {
		  $pc_v = explode(":", $v);
		  $idx = $pc_v[0];
		  $val = $pc_v[1];
		  $rg = $pc_v[2];
		  $arr_jawab1[$idx] = array("j"=>$val,"r"=>$rg);
		}
		$html = '';
		$no = 1;





		if (!empty($soal_urut_ok)) {
			foreach ($soal_urut_ok as $d) { 
				$soal = str_replace('<p>','', $d->soal);
				$tampil_media = tampil_media("./upload/gambar_soal/".$d->file, '300px','auto');
				$vrg = $arr_jawab[$d->id]["r"] == "" ? "N" : $arr_jawab[$d->id]["r"];
				$vrg1 = $arr_jawab1[$d->id]["r"] == "" ? "N" : $arr_jawab1[$d->id]["r"];
				
				$html .= '<input type="hidden" name="id_soal_'.$no.'" value="'.$d->id.'"  disabled>';
				$html .= '<input type="hidden" name="rg_'.$no.'" id="rg_'.$no.'" value="'.$vrg.'" disabled>';
				$html .= '<div class="step" id="widget_'.$no.'"  disabled><hr>';
				$html .= '<p>'.$no.'.'.$soal.'<br>'.$tampil_media.'<div class="funkyradio1">';

				for ($j = 0; $j < $this->config->item('jml_opsi'); $j++) {
					$opsi = "opsi_".$this->opsi[$j];
					$opsi = "opsi_".$this->opsi[$j];
					$checked = $arr_jawab[$d->id]["j"] == strtoupper($this->opsi[$j]) ? "checked" : "";
					$checked1 = $arr_jawab1[$d->id]["j"] == strtoupper($this->opsi[$j]) ? "checked" : "";
					$pc_pilihan_opsi = explode("#####", $d->$opsi);
					$tampil_media_opsi = (is_file('./upload/gambar_soal/'.$pc_pilihan_opsi[0]) || $pc_pilihan_opsi[0] != "") ? tampil_media('./upload/gambar_opsi/'.$pc_pilihan_opsi[0],'300px','auto') : '';
				
				$pilihan_opsi = empty($pc_pilihan_opsi[1]) ? "-" : $pc_pilihan_opsi[1];
				
				if(strtoupper($this->opsi[$j]) == $arr_jawab1[$d->id]["j"]){
					$html .= '<div class="" onclick="return simpan_sementara();">
						<input type="radio" id="opsi_'.strtoupper($this->opsi[$j]).'_'.$d->id.'" name="opsi_'.$no.'" value="'.strtoupper($this->opsi[$j]).'"  '.$checked.' disabled> <label style="background:#86c186;" for="opsi_'.strtoupper($this->opsi[$j]).'_'.$d->id.'"><div class="huruf_opsi">'.$this->opsi[$j].'</div> <p>'.$pilihan_opsi.'</p><p>'.$tampil_media_opsi.'</p></label></div>';
					}else{
						$html .= '<div class="" onclick="return simpan_sementara();">
						<input type="radio" id="opsi_'.strtoupper($this->opsi[$j]).'_'.$d->id.'" name="opsi_'.$no.'" value="'.strtoupper($this->opsi[$j]).'"  '.$checked.' disabled> <label for="opsi_'.strtoupper($this->opsi[$j]).'_'.$d->id.'"><div class="huruf_opsi">'.$this->opsi[$j].'</div> <p>'.$pilihan_opsi.'</p><p>'.$tampil_media_opsi.'</p></label></div>';
					}


					
					
				}
				$html .= '</div></div>';
				$no++;
			}
		}

		$a['jam_mulai'] = $detil_tes->tgl_mulai;
		$a['jam_selesai'] = $detil_tes->tgl_selesai;
		$a['id_tes'] = $cek_detil_tes->id;
		$a['no'] = $no;
		$a['html'] = $html;
		$this->load->view('v_riwayat', $a);
}



public function export_pdf($mapel_id){

	$get = $this->M_guru_tes->get_relation($mapel_id);
	$detail = $this->M_guru_tes->get_detail($mapel_id);

	$data = array(
        'data' => $get,
        'detail' => $detail,
    );

	$Dpdf = new Dpdf();

    $Dpdf->setPaper('A4', 'potrait');
    $Dpdf->filename = "laporan-".date('Y-m-d H-i-s').".pdf";
    $Dpdf->view('ujian/list_pdf', $data);

}

    
    public function get_akhir($tabel, $field, $kode_awal, $pad) {
		$get_akhir	= $this->db->query("SELECT MAX($field) AS max FROM $tabel LIMIT 1")->row();
		$data		= (intval($get_akhir->max)) + 1;
		$last		= $kode_awal.str_pad($data, $pad, '0', STR_PAD_LEFT);
	
		return $last;
	}

}