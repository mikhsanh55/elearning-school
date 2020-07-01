<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rekaptulasi extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_kelas');
		$this->load->model('m_ujian');
		$this->load->model('m_tugas');
		
		
	}

	public function index()
	{	
        $this->page_title = 'Nilai Siswa';
		$data = array(
			'searchFilter' => array('nama')
		);

		$this->render('rekaptulasi/list',$data);
	}

	public function page_load($pg = 1){
		$post = $this->input->post();
		$limit = $post['limit'];
		$where = [];
		
		if($this->log_lvl == 'siswa') {
		    $where['sis.id'] = $this->log_id; // id di m_siswa
		}
		else if($this->log_lvl == 'guru') {
		    $where['kls.id_trainer'] = $this->log_id;
		}
		
		
		if (!empty($post['search'])) {
			switch ($post['filter']) {
				case 0:
					$where["(lower(sis.nama) like '%".strtolower($post['search'])."%' )"] = null;
					break;
				default:
					# code...
					break;
			}
		}
		$paginate = $this->m_kelas->paginate_rekap($pg,$where,$limit);
		
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