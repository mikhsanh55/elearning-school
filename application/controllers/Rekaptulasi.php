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
		$data = array(
			'searchFilter' => array('Nama siswa', 'Nama Guru', 'Kelas', 'Mata Pelajaran')
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
				case 0:
					$where["(lower(sis.nama) like '%".strtolower($post['search'])."%' )"] = null;
					break;
				case 1: 
					$where["(lower(guru.nama) like '%".strtolower($post['search'])."%' )"] = null;
					break;
				case 2:
					$where["(lower(kls.nama) like '%".strtolower($post['search'])."%' )"] = null;
					break;
				case 3:
					$where["(lower(mpl.nama) like '%".strtolower($post['search'])."%' )"] = null;
					break;
			}
		}
		$paginate = $this->m_kelas->paginate_rekap($pg,$where,$limit);
		// print_r($this->db->last_query());exit;
		
		$data['paginate'] = $paginate;
		$data['paginate']['url']	= 'rekaptulasi/page_load';
		$data['paginate']['search'] = 'lookup_key';
		$data['page_start'] = $paginate['counts']['from_num'];

		$this->load->view('rekaptulasi/table',$data);
		$this->generate_page($data);
	}
}

/* End of file instantsi.php */
/* Location: ./application/controllers/instantsi.php */