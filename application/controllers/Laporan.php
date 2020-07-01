<?php 
defined('BASEPATH') or die('No script access allowed!');

class Laporan extends MY_Controller {
	public function __construct() {
		parent::__construct();
		if($this->session->userdata('admin_level') == NULL) {
		    redirect('login');
		}
	}

	public function index() {
		$uri1 = $this->uri->segment(1);
        $uri2 = $this->uri->segment(2);
        

        $a['sess_level'] = $this->session->userdata('admin_level');
        $a['menu'] = $this->db->query("SELECT `nama_menu`, `link`, `icon` FROM rule_users JOIN menu ON rule_users.id_menu = menu.id JOIN level ON rule_users.id_level = level.id WHERE level = '".$a['sess_level']."' ")->result_array();

        $a['link'] = $this->db->query("SELECT link FROM rule_users JOIN menu ON rule_users.id_menu = menu.id JOIN level ON rule_users.id_level = level.id WHERE link = '".$uri1."/".$uri2."' AND level = '".$a['sess_level']."' ")->result_array();

		$this->load->view('dashboard/template/header', $a);
		$this->load->view('dashboard/template/navbar', $a);
		$this->load->view('laporan/index', $a);
		$this->load->view('dashboard/template/footer');
	}

	public function modul() {
			$uri1 = $this->uri->segment(1);

        $uri2 = $this->uri->segment(2);

        $a['sess_level'] = $this->session->userdata('admin_level');
        $a['menu'] = $this->db->query("SELECT `nama_menu`, `link`, `icon` FROM rule_users JOIN menu ON rule_users.id_menu = menu.id JOIN level ON rule_users.id_level = level.id WHERE level = '".$a['sess_level']."' ")->result_array();

        $a['link'] = $this->db->query("SELECT link FROM rule_users JOIN menu ON rule_users.id_menu = menu.id JOIN level ON rule_users.id_level = level.id WHERE link2 = '".$uri1."/".$uri2."' AND level = '".$a['sess_level']."' ")->result_array();
        

		$this->load->view('dashboard/template/header', $a);
		$this->load->view('dashboard/template/navbar', $a);
		$this->load->view('laporan/modul', $a);
		$this->load->view('dashboard/template/footer');
	}

	public function ujian() {
		$uri1 = $this->uri->segment(1);

        $uri2 = $this->uri->segment(2);

        $a['sess_level'] = $this->session->userdata('admin_level');
        $a['menu'] = $this->db->query("SELECT `nama_menu`, `link`, `icon` FROM rule_users JOIN menu ON rule_users.id_menu = menu.id JOIN level ON rule_users.id_level = level.id WHERE level = '".$a['sess_level']."' ")->result_array();

        $a['link'] = $this->db->query("SELECT link FROM rule_users JOIN menu ON rule_users.id_menu = menu.id JOIN level ON rule_users.id_level = level.id WHERE link3 = '".$uri1."/".$uri2."' AND level = '".$a['sess_level']."' ")->result_array();


		$this->load->view('dashboard/template/header', $a);
		$this->load->view('dashboard/template/navbar', $a);
		$this->load->view('laporan/ujian', $a);
		$this->load->view('dashboard/template/footer');	
	}

	public function get_data() {
		$date1 = $this->input->get('date1');
		$date2 = $this->input->get('date2');
		$mapel = $this->db->get('m_mapel');

		$data = [];

		if($date1 != '' && $date2 == '') {
			foreach($mapel->result() as $m) {
				$data[] = $this->db->query("SELECT modul.nama, modul.id as map, laporan.*, SUM(pengunjung) as jp, SUM(hit) as jh FROM m_laporan laporan JOIN m_mapel modul ON modul.id = laporan.id_mapel WHERE laporan.id_mapel = $m->id and updated_at >= '$date1'")->row();
			}
		}
		else if($date2 != '' && $date1 == '') {
			foreach($mapel->result() as $m) {
				$data[] = $this->db->query("SELECT modul.nama,modul.id as map, laporan.*, SUM(pengunjung) as jp, SUM(hit) as jh FROM m_laporan laporan JOIN m_mapel modul ON modul.id = laporan.id_mapel WHERE laporan.id_mapel = $m->id and updated_at <= '$date2'")->row();
			}	
		}
		else if($date1 != '' && $date2 != '') {
			foreach($mapel->result() as $m) {
				$data[] = $this->db->query("SELECT modul.nama,modul.id as map, laporan.*, SUM(pengunjung) as jp, SUM(hit) as jh FROM m_laporan laporan JOIN m_mapel modul ON modul.id = laporan.id_mapel WHERE laporan.id_mapel = $m->id and updated_at BETWEEN '$date1' and '$date2'")->row();
			}		
		}
		else {
			foreach($mapel->result() as $m) {
				$data[] = $this->db->query("SELECT modul.nama,modul.id as map, laporan.*, SUM(pengunjung) as jp, SUM(hit) as jh FROM m_laporan laporan JOIN m_mapel modul ON modul.id = laporan.id_mapel WHERE laporan.id_mapel = $m->id")->row();
			}			
		}

		echo json_encode($data);
	}

	public function push_data() {
		$id_mapel = $this->input->post('mapel');
		$id_user = $this->session->userdata('admin_konid');

		// $this->db->where('id_mapel', $id_mapel);
		// $this->db->where('id_user', $id_user);
		$is_hit = $this->db->query("SELECT * FROM m_laporan WHERE id_mapel = $id_mapel AND id_user = $id_user");
		if($is_hit->num_rows() > 0) {
			$data = [
				'id_mapel' => $id_mapel,
				'id_user'  => $id_user,
				'pengunjung' => 0,
				'hit' => 1,
				'updated_at' => date('Y-m-d')
			];
		}
		else {
			$data = [
				'id_mapel' => $id_mapel,
				'id_user'  => $id_user,
				'pengunjung' => 1,
				'hit' => 0,
				'updated_at' => date('Y-m-d')
			];
		}

		$insert = $this->db->insert('m_laporan', $data);
		if($insert) {
			echo json_encode(['status' => TRUE, 'data' => $data]);
		}
		else {
			echo json_encode(['status' => FALSE, 'data' => $data]);	
		}
	}

	// API Get Data untuk ujian
	public function get_data_ujian() {
		$date1 = $this->input->get('date1');
		$date2 = $this->input->get('date2');
		if($date1 != '') {
			$date1 = strtotime($date1);
			$date1 = date('Y-m-d H:i:s', $date1);
		}

		if($date2 != '') {
			$date2 = strtotime($date2);
			$date2 = date('Y-m-d H:i:s', $date2);
		}

		if($date1 != '' && $date2 == '') {
			$raw_data = $this->db->query("SELECT tes.nama_ujian, mapel.nama as modul, mapel.id as id_modul, MAX(nilai) as tertinggi, MIN(nilai) as terendah, AVG(nilai) as rata_rata, COUNT(id_user) as peserta
			FROM tr_ikut_ujian_pertama p
			JOIN tr_guru_tes tes ON p.id_tes = tes.id
			JOIN m_mapel mapel ON tes.id_mapel = mapel.id
			WHERE p.tgl_mulai >= '$date1'
			group by id_tes");	
		}
		else if($date2 != '' && $date1 == '') {
			$raw_data = $this->db->query("SELECT tes.nama_ujian, mapel.nama as modul, mapel.id as id_modul, MAX(nilai) as tertinggi, MIN(nilai) as terendah, AVG(nilai) as rata_rata, COUNT(id_user) as peserta
			FROM tr_ikut_ujian_pertama p
			JOIN tr_guru_tes tes ON p.id_tes = tes.id
			JOIN m_mapel mapel ON tes.id_mapel = mapel.id
			WHERE p.tgl_mulai <= '$date2'
			group by id_tes");
		}
		else if($date1 != '' && $date2 != '') {
			$raw_data = $this->db->query("SELECT tes.nama_ujian, mapel.nama as modul, mapel.id as id_modul, MAX(nilai) as tertinggi, MIN(nilai) as terendah, AVG(nilai) as rata_rata, COUNT(id_user) as peserta
			FROM tr_ikut_ujian_pertama p
			JOIN tr_guru_tes tes ON p.id_tes = tes.id
			JOIN m_mapel mapel ON tes.id_mapel = mapel.id
			WHERE p.tgl_mulai BETWEEN '$date1' AND '$date2'
			group by id_tes");
		}
		else {
			$raw_data = $this->db->query("SELECT tes.nama_ujian, mapel.nama as modul, mapel.id as id_modul, MAX(nilai) as tertinggi, MIN(nilai) as terendah, AVG(nilai) as rata_rata, COUNT(id_user) as peserta
			FROM tr_ikut_ujian_pertama p
			JOIN tr_guru_tes tes ON p.id_tes = tes.id
			JOIN m_mapel mapel ON tes.id_mapel = mapel.id
			group by id_tes");
		}
		
		$data = [
			'status' => TRUE,
			'jumlah_data' => $raw_data->num_rows(),
			'data'	 => $raw_data->result(),
			'date1' => $date1,
			'date2' => $date2
		];

		echo json_encode($data);
		http_response_code(200);
	}
}