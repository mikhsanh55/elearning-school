<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Beranda extends MY_Controller {



	public function __construct()

	{

		parent::__construct();

		$this->load->model('m_setting_instansi');

		$this->load->model('m_slide');

	}



	public function index()

	{

		switch ($this->log_lvl) {

			case 'instansi':

					$this->view_instansi();

				break;
				
			case 'admin_instansi':

					$this->view_instansi();

				break;



			case 'siswa':

					$this->view_siswa();

				break;

			

			case 'guru':

					$this->view_guru();

				break;

			

			case 'admin':

					$this->view_admin();

				break;



				

			default:

				# code...

				break;

		}

	}



	public function view_instansi()

	{

		$data = array(

			'setting' => $this->m_setting_instansi->get_by(array('id_instansi'=>$this->akun->instansi)),
			'slide' => $this->m_slide->get_many_by(['id_instansi'=>$this->akun->instansi]),

			'patch'  => base_url('upload/slide/'),

		);

		$this->render('beranda/set',$data);	

	}



	public function view_siswa()

	{

		$data = [

			'slide' => $this->m_slide->get_many_by(['id_instansi'=>$this->akun->instansi]),

			'patch'  => base_url('upload/slide/'),

		];

		$this->render('beranda/profil',$data);	

	}



	public function view_guru()

	{
		$data = [

			'slide' => $this->m_slide->get_many_by(['id_instansi'=>$this->akun->instansi]),

			'patch'  => base_url('upload/slide/'),

		];
		$this->render('beranda/profil_guru', $data);	

	}



	public function view_admin()

	{
		$this->load->model('m_instansi');
		$data = array(

			'setting' => $this->m_setting->get_by(array('id'=>1)),
			'slide' => $this->m_slide->get_many_by(['id_instansi'=>$this->akun->instansi]),
			'lembaga' => $this->m_instansi->get_all(),
			'selected_lembaga'  => $this->m_instansi->get_by(['selected' => 1]),
			'patch'  => base_url('upload/slide/'),

		);
		// print_r($data);exit;

		$this->render('setting/set',$data);	

	}



	public function slide()

	{

		

		

		$data = array(

			'slide' => $this->m_slide->get_many_by(array('id_instansi'=>$this->akun->instansi))

		);

		$this->load->view('beranda/slide',$data);	

	}



}



/* End of file setting.php */

/* Location: ./application/controllers/setting.php */