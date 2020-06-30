<<<<<<< HEAD
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tugas_siswa extends MY_Controller {

	protected $type;
	protected $color;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_mapel_cs');
		$this->load->model('m_tugas');
		$this->load->model('m_tugas_attach');
		$this->load->model('m_tugas_attach_siswa');
		$this->load->model('m_siswa');
		$this->load->helper('security');

		$this->page_title = 'Tugas';

		$this->type = array(
			'.pdf' => 'fa fa-file-pdf-o', 
			'.png' => 'fa fa-file-image-o', 
			'.jpg' => '	fa fa-file-image-o', 
			'.jpeg' => 'fa fa-file-image-o', 
			'.zip' => 'fa fa-file-archive-o',
			'.rar' => 'fa fa-file-archive-o',
			'.doc' => 'fa fa-file-word-o',
			'.docx' => 'fa fa-file-word-o',
			'.ppt' => 'fa fa-file-powerpoint-o',
			'.pptx' => 'fa fa-file-powerpoint-o',
			'.xls' => 'fa fa-file-excel-o',
			'.xlsx' => 'fa fa-file-excel-o'
		);

		$this->color = array(
			'.pdf' => 'red', 
			'.png' => '#bf4d4d', 
			'.jpg' => '#bf4d4d', 
			'.jpeg' => '#bf4d4d',
			'.zip' => '#ff8f19',
			'.rar' => '#ff8f19',
			'.doc' => 'blue',
			'.docx' => 'blue',
			'.ppt' => 'red',
			'.pptx' => 'red',
			'.xls' => 'green',
			'.xlsx' => 'green'
		);
	}

	public function index()
	{	

		$data = array(
			'searchFilter' => array('Modul Pelatihan','Keterangan')
		);
		$this->render_siswa('tugas/daftar',$data);
	}


	
	public function page_load($pg = 1){
		$post = $this->input->post();
		$limit = 6;
		$where = [];
		if (!empty($post['search'])) {
			switch ($post['filter']) {
				case 0:
					$where["(lower(mpl.nama) like '%".strtolower($post['search'])."%' )"] = null;
					break;
				case 1:
					$where["(lower(tgs.keterangan) like '%".strtolower($post['search'])."%' )"] = null;
					break;
				
				default:
					# code...
					break;
			}
		}

		if ($this->log_lvl != 'admin') {
			$where['tgs.id_instansi'] = $this->akun->instansi;

		}

		$paginate = $this->m_tugas->paginate($pg,$where,$limit);

		$data['paginate'] = $paginate;
		$data['paginate']['url']	= 'tugas_siswa/page_load';
		$data['paginate']['search'] = 'lookup_key';
		$data['page_start'] = $paginate['counts']['from_num'];

		$data['paging'] = $this->gen_paging($data['paginate']);

		$this->load->view('tugas/data',$data);
	}

	public function detail()
	{
		$this->render_siswa('tugas/detail_tugas');
	}

	

}

/* End of file Tugas.php */
=======
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tugas_siswa extends MY_Controller {

	protected $type;
	protected $color;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_mapel_cs');
		$this->load->model('m_tugas');
		$this->load->model('m_tugas_attach');
		$this->load->model('m_tugas_attach_siswa');
		$this->load->model('m_siswa');
		$this->load->helper('security');

		$this->page_title = 'Tugas';

		$this->type = array(
			'.pdf' => 'fa fa-file-pdf-o', 
			'.png' => 'fa fa-file-image-o', 
			'.jpg' => '	fa fa-file-image-o', 
			'.jpeg' => 'fa fa-file-image-o', 
			'.zip' => 'fa fa-file-archive-o',
			'.rar' => 'fa fa-file-archive-o',
			'.doc' => 'fa fa-file-word-o',
			'.docx' => 'fa fa-file-word-o',
			'.ppt' => 'fa fa-file-powerpoint-o',
			'.pptx' => 'fa fa-file-powerpoint-o',
			'.xls' => 'fa fa-file-excel-o',
			'.xlsx' => 'fa fa-file-excel-o'
		);

		$this->color = array(
			'.pdf' => 'red', 
			'.png' => '#bf4d4d', 
			'.jpg' => '#bf4d4d', 
			'.jpeg' => '#bf4d4d',
			'.zip' => '#ff8f19',
			'.rar' => '#ff8f19',
			'.doc' => 'blue',
			'.docx' => 'blue',
			'.ppt' => 'red',
			'.pptx' => 'red',
			'.xls' => 'green',
			'.xlsx' => 'green'
		);
	}

	public function index()
	{	

		$data = array(
			'searchFilter' => array('Modul Pelatihan','Keterangan')
		);
		$this->render_siswa('tugas/daftar',$data);
	}


	
	public function page_load($pg = 1){
		$post = $this->input->post();
		$limit = 6;
		$where = [];
		if (!empty($post['search'])) {
			switch ($post['filter']) {
				case 0:
					$where["(lower(mpl.nama) like '%".strtolower($post['search'])."%' )"] = null;
					break;
				case 1:
					$where["(lower(tgs.keterangan) like '%".strtolower($post['search'])."%' )"] = null;
					break;
				
				default:
					# code...
					break;
			}
		}

		if ($this->log_lvl != 'admin') {
			$where['tgs.id_instansi'] = $this->akun->instansi;

		}

		$paginate = $this->m_tugas->paginate($pg,$where,$limit);

		$data['paginate'] = $paginate;
		$data['paginate']['url']	= 'tugas_siswa/page_load';
		$data['paginate']['search'] = 'lookup_key';
		$data['page_start'] = $paginate['counts']['from_num'];

		$data['paging'] = $this->gen_paging($data['paginate']);

		$this->load->view('tugas/data',$data);
	}

	public function detail()
	{
		$this->render_siswa('tugas/detail_tugas');
	}

	

}

/* End of file Tugas.php */
>>>>>>> first push
/* Location: ./application/controllers/Tugas.php */