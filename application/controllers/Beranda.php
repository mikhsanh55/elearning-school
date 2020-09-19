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

	/*
	* Untuk update data profile guru / siswa
	* @return json
	*/
	public function update()
	{
		$post = $this->input->post();
		$responseCode = 200;
		$returnedData = [];

		if($this->log_lvl == 'siswa') {
			$id = decrypt_url($post['id']);
			$data = [
				'nama' => trim($post['nama']),
				'nim' => trim($post['agama']),
				'email' => trim($post['email']),
				'no_telpon' => trim($post['no_telpon'])
			];

			if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
				$fileName = 'avatar-' . uniqid() . '-' . $_FILES['image']['name'];
				$config['upload_path']          = 'upload/siswa_photo/';
			    $config['allowed_types']        = 'gif|jpg|png|jpeg|svg';
			    $config['file_name']            = $fileName;
			    $config['max_size']             = 3072; // 3MB

			    $this->load->library('upload', $config);
				$this->upload->initialize($config);

				if(!$this->upload->do_upload('image')) {
					$this->session->set_flashdata('msg', '<p class="alert alert-danger"> '.$this->upload->display_errors().' </p>');
					$this->sendAjaxResponse([
						'status' => FALSE,
						'msg' => $this->upload->display_errors(),
						'image' => $_FILES['image']
					], 500);
					exit;
				}
				else {
					$uploaded = $this->upload->data();
					$data['image'] = 'upload/siswa_photo/' . $uploaded['file_name'];
					$oldData = $this->m_siswa->get_by(['id' => $id]);
					if(is_file($oldData->image) && file_exists($oldData->image)) {
						unlink($oldData->image);
					}
				}
			}

			$update = $this->m_siswa->update($data, ['id' => $id]);
			if($update) {
				$returnedData = [
					'status' => 'post',
					'msg' => 'Profile berhasil diupdate'
				];
				$responseCode = 200;
			}
			else {
				$returnedData = [
					'status' => 'post',
					'msg' => 'Profile gagal diupdate'
				];
				$responseCode = 500;
			}
			
			$this->sendAjaxResponse($returnedData, $responseCode);
		}
	}

	public function profileSiswa()
	{
		$data['data'] = $this->m_siswa->get_by(['id' => $this->akun->id]);
		$data['kelas'] = $this->m_detail_kelas->get_siswa(['dk.id_peserta' => $this->akun->id]);
		// print_r($data);exit
		$this->render('beranda/profile_siswa', $data);
	}

	public function profile($encrypt_id) 
	{
		if(is_null($encrypt_id)) {
			redirect('beranda');
		}

		$data['data'] = $this->m_guru->get_by(['id' => decrypt_url($encrypt_id)]);
		$data['id'] = decrypt_url($encrypt_id);

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
		$this->load->model('m_kelas');
		$this->load->model('m_materi');
		$data = [
			'slide' => $this->m_slide->get_many_by(['id_instansi'=>$this->akun->instansi]),
			'patch'  => base_url('upload/slide/'),
			'kelas' => $this->m_detail_kelas->get_siswa(['dk.id_peserta' => $this->akun->id]),
			'csrf' => $this->generateCSRFToken(),
			'siswa' => $this->m_siswa->get_by(['id' => $this->session->userdata('admin_konid')])
		];

		$data['mapels'] = $this->m_kelas->get_data_mapel(['kls.id' => $data['kelas']->id_kelas]);
		// print_r($data);exit;

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