<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rekaptulasi extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_kelas');
		$this->load->model('m_ujian');
		$this->load->model('m_guru');
		$this->load->model('m_tugas');
	}

	public function index()
	{	
        $this->page_title = 'Nilai Siswa';
       	if($this->log_lvl == 'siswa') {
       		$filter = ['guru' => 'Nama Guru', 'mapel' => 'Mata Pelajaran'];
       	}
       	else {
       		$filter = ['siswa' => 'Nama Siswa', 'kelas' => 'Kelas', 'mapel' => 'Mata Pelajaran'];
		}
		$data = array(
			'searchFilter' => $filter
		);

		$this->render('rekaptulasi/list',$data);
	}

	public function page_load($pg = 1){
		$post = $this->input->post();
		$limit = $post['limit'];
		$where = [];
		$where['kls.id_instansi'] = $this->akun->instansi;
		$where['sis.is_graduated'] = 0;
		if($this->log_lvl == 'siswa') {
		    $where['sis.id'] = $this->log_id; // id di m_siswa
		}
		else if($this->log_lvl == 'guru') {
		    $where['dmkls.id_guru'] = $this->log_id;
		}
		
		if (!empty($post['search'])) {
			switch ($post['filter']) {
				case 'siswa':
					$where["(lower(sis.nama) like '%".strtolower($post['search'])."%' )"] = null;
					break;
				case 'guru': 
					$where["(lower(guru.nama) like '%".strtolower($post['search'])."%' )"] = null;
					break;
				case 'kelas':
					$where["(lower(kls.nama) like '%".strtolower($post['search'])."%' )"] = null;
					break;
				case 'mapel':
					$where["(lower(mapel.nama) like '%".strtolower($post['search'])."%' )"] = null;
					break;
			}
		}

		switch ($this->log_lvl) {
			case 'siswa':
				$paginate = $this->m_kelas->paginate_rekap_siswa($pg, $where, $limit);
				$view = 'rekaptulasi/table_siswa';
				break;
			
			default:
				$paginate = $this->m_kelas->paginate_rekap($pg,$where,$limit);
				$view = 'rekaptulasi/table';
				break;
		}
		
		// print_r($this->db->last_query());exit;
		
		$data['paginate'] = $paginate;
		$data['paginate']['url']	= 'rekaptulasi/page_load';
		$data['paginate']['search'] = 'lookup_key';
		$data['page_start'] = $paginate['counts']['from_num'];

		$this->load->view($view,$data);
		$this->generate_page($data);
	}

	public function detail_ujian_siswa($type_ujian, $id_mapel, $id_siswa, $id_kelas) {
		$id_mapel = decrypt_url($id_mapel);
		$id_siswa = decrypt_url($id_siswa);
		$id_kelas = decrypt_url($id_kelas);

		$mapel = $this->m_mapel->get_by(['id' => $id_mapel]);
		$kelas = $this->m_kelas->get_by(['kls.id' => $id_kelas]);
		$siswa = $this->m_siswa->get_by(['id' => $id_siswa]);

		switch($type_ujian) {
			case 1:
				$type_ujian = 'harian';
				break;
			case 2: 
				$type_ujian = 'uts';
				break;
			case 3:
				$type_ujian = 'uas';
				break;	
		}
		$data = [
			'id_mapel' => $id_mapel,
			'id_siswa' => $id_siswa,
			'id_kelas' => $id_kelas,
			'nama_siswa' => $siswa->nama,
			'nama_mapel' => $mapel->nama,
			'nama_kelas' => $kelas->nama,
			'type_ujian' => $type_ujian,
			'searchFilter' => ['Nama Ujian']
		];

		$this->render('rekaptulasi/list_detail_ujian', $data);
	}
	public function detail_ujian($type_ujian) {
		$id_mapel = decrypt_url($this->uri->segment(4));
		$detail_kelas = $this->m_detail_kelas->get_by(['id_peserta' => $this->session->userdata('admin_konid')]);
		switch($type_ujian) {
			case 1:
				$type_ujian = 'harian';
				break;
			case 2: 
				$type_ujian = 'uts';
				break;
			case 3:
				$type_ujian = 'uas';
				break;	
		}
		$data = [
			'id_mapel' => $id_mapel,
			'detail_kelas' => $detail_kelas,
			'type_ujian' => $type_ujian,
			'searchFilter' => ['Mata Pelajaran', 'Keterangan']
		];
		// print_r($data);exit;

		$this->render('rekaptulasi/list_detail_ujian', $data);
	}

	public function page_load_detail_ujian($pg = 1) {
		$post = $this->input->post();
		$limit = $post['limit'];
		$where = [];

		// Default Where
		$where['uji.type_ujian'] = $post['type'];
		$where['uji.id_mapel'] = $post['id_mapel'];
		$where['ujikls.id_kelas'] = $post['id_kelas'];
		$where['uji.id_instansi'] = $this->akun->instansi;

		switch($this->log_lvl) {
			case 'siswa':
				$where['pg.id_user'] = $this->session->userdata('admin_konid');
				$where['essay.id_user'] = $this->session->userdata('admin_konid');
			break;
			case 'guru':
				$where['pg.id_user'] = $post['id_siswa'];
				$where['essay.id_user'] = $post['id_siswa'];
			break;
		}
		
		if (!empty($post['search'])) {
			switch ($post['filter']) {
				case 0:
					$where["(lower(uji.nama_ujian) like '%".strtolower($post['search'])."%' )"] = null;
					break;
			}
		}
		$paginate = $this->m_kelas->paginate_detail_ujian($pg, $where, $limit);
		// print_r($this->db->last_query());exit;
		$data['paginate'] = $paginate;
		$data['paginate']['url']	= 'rekaptulasi/page_load_detail_ujian';
		$data['paginate']['search'] = 'lookup_key';
		$data['page_start'] = $paginate['counts']['from_num'];

		$this->load->view('rekaptulasi/table_detail_ujian',$data);
		$this->generate_page($data);
	}
}
/* End of file instantsi.php */
/* Location: ./application/controllers/instantsi.php */