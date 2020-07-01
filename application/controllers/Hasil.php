<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hasil extends MY_Controller {
	function __construct() {
        parent::__construct();
        $this->db->query("SET time_zone='+7:00'");
        $waktu_sql = $this->db->query("SELECT NOW() AS waktu")->row_array();
        $this->waktu_sql = $waktu_sql['waktu'];
        $this->opsi = array("a","b","c","d","e");
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
	public function h_ujian() {
		$this->cek_aktif();
		cek_hakakses(array("guru","admin"), $this->session->userdata('admin_level'));
		
			//var def uri segment
			$uri1 = $this->uri->segment(1);
			$uri2 = $this->uri->segment(2);
			$uri3 = $this->uri->segment(3);
			$uri4 = $this->uri->segment(4);
			$uri5 = $this->uri->segment(5);

		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');
		$a['menu'] = $this->db->query("SELECT `nama_menu`, `link`, `icon` FROM rule_users JOIN menu ON rule_users.id_menu = menu.id JOIN level ON rule_users.id_level = level.id WHERE level = '".$a['sess_level']."' ")->result_array();
		$a['link'] = $this->db->query("SELECT link FROM rule_users JOIN menu ON rule_users.id_menu = menu.id JOIN level ON rule_users.id_level = level.id WHERE link = '".$uri1."/".$uri2."' AND level = '".$a['sess_level']."' ")->result_array();

		//var def uri segment
		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		$uri5 = $this->uri->segment(5);
		//var post from json
		$p = json_decode(file_get_contents('php://input'));
		//return as json
		$jeson = array();

		$wh_1 = $a['sess_level'] == "admin" ? "" : " AND a.id_guru = '".$a['sess_konid']."'";
		//$a['data'] = $this->db->query($wh_1)->result();
		

		$a['p_mapel'] = obj_to_array($this->db->query("SELECT * FROM m_mapel")->result(), "id,nama");
		
		if ($uri3 == "det") {
			$a['detil_tes'] = $this->db->query("SELECT m_mapel.nama AS namaMapel, m_guru.nama AS nama_guru, 
												tr_guru_tes.* 
												FROM tr_guru_tes 
												INNER JOIN m_mapel ON tr_guru_tes.id_mapel = m_mapel.id
												INNER JOIN m_guru ON tr_guru_tes.id_guru = m_guru.id
												WHERE tr_guru_tes.id = '$uri4'")->row();
			$a['statistik'] = $this->db->query("SELECT MAX(nilai) AS max_, MIN(nilai) AS min_, AVG(nilai) AS avg_ 
											FROM tr_ikut_ujian
											WHERE tr_ikut_ujian.id_tes = '$uri4'")->row();

			//$a['hasil'] = $this->db->query("")->result();
			$a['p'] = "m_guru_tes_hasil_detil";
			//echo $this->db->last_query();
		} else if ($uri3 == "data_det") {
			$start = $this->input->post('start');
	        $length = $this->input->post('length');
	        $draw = $this->input->post('draw');
	        $search = $this->input->post('search');

	        $d_total_row = $this->db->query("
	        	SELECT a.id
				FROM tr_ikut_ujian a
				INNER JOIN m_siswa b ON a.id_user = b.id
				WHERE a.id_tes = '$uri4' 
				AND b.nama LIKE '%".$search['value']."%'")->num_rows();

	        $q_datanya = $this->db->query("
	        	SELECT a.id, b.nama, a.nilai, a.jml_benar, a.nilai_bobot
				FROM tr_ikut_ujian a
				INNER JOIN m_siswa b ON a.id_user = b.id
				WHERE a.id_tes = '$uri4' 
				AND b.nama LIKE '%".$search['value']."%' ORDER BY a.id DESC LIMIT ".$start.", ".$length."")->result_array();

	        $data = array();
	        $no = ($start+1);


	        foreach ($q_datanya as $d) {
	            $data_ok = array();
	            $data_ok[0] = $no++;
	            $data_ok[1] = $d['nama'];
	            $data_ok[2] = $d['jml_benar'];
	            $data_ok[3] = $d['nilai'];
	            $data_ok[4] = $d['nilai_bobot'];
	            $data_ok[5] = '<a href="'.base_url().'hasil/h_ujian/batalkan_ujian/'.$d['id'].'/'.$this->uri->segment(4).'" class="btn btn-danger btn-sm mr-2" onclick="return confirm(\'Anda yakin...?\');"><i class="glyphicon glyphicon-remove" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Batalkan Tes</a>';

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
		} else if ($uri3 == "batalkan_ujian") {
			$this->db->query("DELETE FROM tr_ikut_ujian WHERE id = '$uri4'");
			redirect('hasil/h_ujian/det/'.$uri5);
		} else if ($uri3 == "data") {
			$start = $this->input->post('start');
	        $length = $this->input->post('length');
	        $draw = $this->input->post('draw');
	        $search = $this->input->post('search');

	        $d_total_row = $this->db->query("SELECT a.id FROM tr_guru_tes a
	        	INNER JOIN m_mapel b ON a.id_mapel = b.id 
	        	INNER JOIN m_guru c ON a.id_guru = c.id
	            WHERE (a.nama_ujian LIKE '%".$search['value']."%' OR b.nama LIKE '%".$search['value']."%' OR c.nama LIKE '%".$search['value']."%') ".$wh_1."")->num_rows();
	    	//echo $this->db->last_query();

	        $q_datanya = $this->db->query("SELECT a.*, b.nama AS mapel, c.nama AS nama_guru FROM tr_guru_tes a
	        	INNER JOIN m_mapel b ON a.id_mapel = b.id 
	        	INNER JOIN m_guru c ON a.id_guru = c.id
	            WHERE (a.nama_ujian LIKE '%".$search['value']."%' OR b.nama LIKE '%".$search['value']."%' OR c.nama LIKE '%".$search['value']."%') ".$wh_1." ORDER BY a.id DESC LIMIT ".$start.", ".$length."")->result_array();

	        $data = array();
	        $no = ($start+1);


	        foreach ($q_datanya as $d) {
	            $data_ok = array();
	            $data_ok[0] = $no++;
	            $data_ok[1] = $d['nama_ujian'];
	            $data_ok[2] = $d['nama_guru'];
	            $data_ok[3] = $d['mapel'];
	            $data_ok[4] = $d['jumlah_soal'];
	            $data_ok[5] = $d['waktu']." menit";
	            $data_ok[6] = '<a href="'.base_url().'hasil/h_ujian/det/'.$d['id'].'" class="btn btn-info btn-sm mr-2"><i class="glyphicon glyphicon-search" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Lihat Hasil</a>
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
			$a['p']	= "m_guru_tes_hasil";
		}
		if($a['sess_level'] == "admin"){
		cek_hakakses(array("admin"), $this->session->userdata('admin_level'));
		$this->load->view('dashboard/template/header', $a);
		$this->load->view('dashboard/template/navbar', $a);
		$this->load->view('dashboard/admin/hasilujian', $a);
		$this->load->view('dashboard/template/footer', $a);
		}else if ($a['sess_level'] == "guru") {
			cek_hakakses(array("guru"), $this->session->userdata('admin_level'));
			$this->load->view('dashboard/template/header', $a);
			$this->load->view('dashboard/template/navbar', $a);
			$this->load->view('dashboard/trainer/hasil_ujian', $a);
			$this->load->view('dashboard/template/footer', $a);
		}

	}
}
