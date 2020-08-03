<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Beranda extends MY_Controller {



	public function __construct()

	{
		parent::__construct();
		$this->load->model('m_setting_instansi');
		$this->load->model('m_slide');
		$this->load->model('m_guru');
		$this->load->model('m_detail_mapel');
		$this->load->model('m_siswa');

	}

	public function profile($encrypt_id) {
		if(is_null($encrypt_id)) {
			redirect('beranda');
		}

		$data['data'] = $this->m_guru->get_by(['id' => decrypt_url($encrypt_id)]);
		$data['id'] = decrypt_url($encrypt_id);
		// switch ($this->log_lvl) {
		// 	case 'guru':
		// 		$data['data'] = $this->m_guru->get_by(['id' => decrypt_url($encrypt_id)]);
		// 		break;
		// 	case 'siswa':
		// 		$data['data'] = $this->m_siswa->get_by(['id' => $this->akun->id]);
		// 	default:
		// 	break;
		// }


		

		$this->render('beranda/profile', $data);
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
			'csrf' => $this->generateCSRFToken()

		);

		$this->render('beranda/set',$data);	

	}



	public function view_siswa()

	{

		$data = [

			'slide' => $this->m_slide->get_many_by(['id_instansi'=>$this->akun->instansi]),

			'patch'  => base_url('upload/slide/'),

			'kelas' => $this->m_detail_kelas->get_siswa(['dk.id_peserta' => $this->akun->id]),
			'csrf' => $this->generateCSRFToken(),
			'siswa' => $this->m_siswa->get_by(['id' => $this->session->userdata('admin_konid')])

		];

		$this->render('beranda/profil',$data);	

	}



	public function view_guru()

	{
		$data = [

			'slide' => $this->m_slide->get_many_by(['id_instansi'=>$this->akun->instansi]),

			'patch'  => base_url('upload/slide/'),

			'csrf' => $this->generateCSRFToken(),
			'guru' => $this->m_guru->get_by(['id' => $this->session->userdata('admin_konid')])
		];
		// print_r($data);exit;
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
			'csrf' => $this->generateCSRFToken()

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