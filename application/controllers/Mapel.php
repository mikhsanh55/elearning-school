<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mapel extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->db->query("SET time_zone='+7:00'");
        $waktu_sql = $this->db->query("SELECT NOW() AS waktu")->row_array();
        $this->waktu_sql = $waktu_sql['waktu'];
        $this->opsi = array("a","b","c","d","e");
        $this->load->model('m_kelas');
        $this->load->model('m_mapel');
        $this->load->model('m_admin');
        $this->load->model('m_mapel_cs');
        $this->load->model('m_instansi');
        $this->load->model('m_materi');
        $this->load->model('m_detail_mapel');
        $this->page_title = 'Modul Pelatihan';
	}
	

	public function index() {

		$data = [
			'searchFilter' => ['Nama Modul'],
			'instansi' => ($this->log_lvl == 'admin') ? $this->m_instansi->get_all() : $this->m_instansi->get_many_by(['id'=>$this->akun->instansi]) 
		];

		$this->render_siswa('mapel/daftar', $data);
	}


	public function page_load($pg = 1) {
		$this->load->model('m_mapel_cs');
		$post = $this->input->post();
		$limit = 6;
		$where = [];

		if (!empty($post['search'])) {
			switch ($post['filter']) {
				case 0:
				$where["(lower(mp.nama) like '%".strtolower($post['search'])."%' )"] = null;
				break;
						# code...
				break;
			}
		}

		$where['kls.id_peserta'] = $this->akun->id;
		$where['kls.id_instansi'] = $this->akun->instansi;

		$paginate = $this->m_mapel_cs->paginate_siswa($pg, $where, $limit, $post);
		$data['paginate'] = $paginate;
		$data['paginate']['url']	= 'mapel/page_load';
		$data['paginate']['search'] = 'lookup_key';
		$data['page_start'] = $paginate['counts']['from_num'];

		$data['paging'] = $this->gen_paging($data['paginate']);


		$this->load->view('mapel/data', $data);

		
	}


	public function materi($id=null) {
		$data = array('id' => decrypt_url($id), );
		$this->render_siswa('mapel/daftar_materi',$data);
	}


	public function page_load_materi($pg = 1) {
		$this->load->model('m_mapel_cs');
		$post = $this->input->post();
		$limit = $post['limit'];
		$where = [];

		$where['id_mapel'] = $post['id_mapel'];
		$where['is_verify'] = 1;
		if (!empty($post['search'])) {
			switch ($post['filter']) {
				case 0:
				$where["(lower(mp.nama) like '%".strtolower($post['search'])."%' )"] = null;
				break;
						# code...
				break;
			}
		}

		$paginate = $this->m_materi->paginate($pg, $where, $limit, $post);
		$data['paginate'] = $paginate;
		$data['paginate']['url']	= 'mapel/page_load_materi';
		$data['paginate']['search'] = 'lookup_key';
		$data['page_start'] = $paginate['counts']['from_num'];

		$data['paging'] = $this->gen_paging($data['paginate']);


		$this->load->view('mapel/data_materi', $data);

		
	}

	public function update_guru_mapel() {
		
		$post = $this->input->post(null, true);

  		$data = [
  			'id_mapel' => $post['id_mapel'],
  			'id_guru'  => $post['id_guru'],
  		];

  		if($post['aktif'] == 1) {
  			$this->m_detail_mapel->insert($data);
  		}
  		else {
  			$this->m_detail_mapel->delete($data);	
  		}

  		$this->sendAjaxResponse($data, 200);
	}
	public function page_load_mapel_guru($pg = 1) {
		$post = $this->input->post();
		$limit = $post['limit'];
		$where = [];
		// $where['id_mapel'] = $post['id_mapel'];
		// $where['is_verify'] = 1;
		$where['id_instansi'] = $this->akun->instansi;
		if (!empty($post['search'])) {
			switch ($post['filter']) {
				case 0:
				$where["(lower(mapel.nama) like '%".strtolower($post['search'])."%' )"] = null;
				break;
						# code...
				break;
			}
		}
		$paginate = $this->m_mapel->paginate($pg, $where, $limit);
		foreach($paginate['data'] as $d) {
			$d->id_guru = $post['id'];
		}

		$data['paginate'] = $paginate;
		$data['paginate']['url']	= 'mapel/page_load_mapel_guru';
		$data['paginate']['search'] = 'lookup_key';
		$data['page_start'] = $paginate['counts']['from_num'];
	
		$this->load->view('modul_pelatihan/table_murid', $data);		
		$this->generate_page($data);
	}

	public function daftar_mapel($pg = 1) {
		$post = $this->input->post();
		// print_r($paginate);exit;
		$data = [
			'searchFilter' => ['Nama'],
			'id_mapel' => $post['id_mapel']
		];
		
		// print_r($data['paginate']);exit;

		$this->load->view('modul_pelatihan/daftar_murid', $data);
		
	}

	public function get_mapel() {
		$this->load->model('m_detail_kelas_mapel');
		$post = $this->input->post();
		$id_kelas = $post['id_kelas'];
		$html = '';
		$res = $this->m_detail_kelas_mapel->get_many_by(['id_kelas' => $id_kelas]);

		if(count($res) > 0) {
			$html = '<option disabled="disabled" value="null" selected="selected">Pilih</option>';

			foreach($res as $row) {
				$mapel = $this->m_mapel->get_by(['id' => $row->id_mapel]);
				$nama_mapel = !empty($mapel->nama) ? $mapel->nama : '';
				$html .= '<option value="'. $row->id_mapel .'" >'.$nama_mapel.'</option>';
			}

		}

		echo $html;
	}
}
