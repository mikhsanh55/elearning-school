<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting_client extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_setting_instansi');
		$this->load->model('m_slide');
		
	}

	public function index()
	{
		$data = array(
			'setting' => $this->m_setting_instansi->get_by(array('id_instansi'=>$this->akun->instansi))
		);
		$this->render('setting_client/set',$data);	
	}

	public function update(){
		$post = $this->input->post();

		$instansi = str_replace('','_',$this->akun->ins);
		$errors = false;
		if (!empty($_FILES["logo"]['name'])) {

			$file = $_FILES["logo"]['name'];
			$ifile = str_replace(" ", "_", $file);
			$new_name = time()."_logo".'_'.$instansi.date('YmdHis');
			
			$config['upload_path'] = 'assets/logo/';
			$config['allowed_types'] = 'jpeg|jpg|png';
			$config['max-size'] =  2048;
			$config['file_name'] = $new_name;

			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			

			if($this->upload->do_upload("logo")){
				$info = $this->upload->data();

				$data['logo'] = $info['raw_name'].$info['file_ext'];
	
			}else{

				$pesan = $this->upload->display_errors();

				$errors = true;

			}
			

		}else{
			$pesan	= 'File Belum di pilih!';
			$errors = false;
		}
		
		if (!empty($_FILES["video"]['name'])) {

			$file = $_FILES["video"]['name'];
			$ifile = str_replace(" ", "_", $file);
			$new_name = time()."_video".'_'.$instansi.date('YmdHis');
			
			$config['upload_path'] = 'upload/video_beranda/';
			$config['allowed_types'] = 'mp4|mkv|png';
			$config['max-size'] =  2048;
			$config['file_name'] = $new_name;

			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			

			if($this->upload->do_upload("video")){
				$info = $this->upload->data();

				$data['video'] = $info['raw_name'].$info['file_ext'];
	
			}else{

				$pesan = $this->upload->display_errors();

				$errors = true;

			}
			

		}else{
			$pesan	= 'File Belum di pilih!';
			$errors = false;
		}


		if ($errors == true) {
			$results = array(
				'show'  => 1,
				'pesan' => $pesan,
				'hasil' => 0
			);
			$this->session->set_userdata($results);
			redirect(base_url('beranda'),'refresh');
		}



		$data['judul'] = $post['judul'];
		$data['footer'] = $post['footer'];
		$data['jumlah_testing'] = $post['jumlah_testing'];
		$data['id_instansi'] = $this->akun->instansi;
			$data['bobot'] = $post['bobot'];	
		
		if (empty($post['id'])) {
			$kirim = $this->m_setting_instansi->insert($data);
			$sts = 1;
		}else{
			$kirim = $this->m_setting_instansi->update($data,array('id'=>$post['id']));
			$sts = 2;
		}


		if ($kirim) {
			if ($sts == 2) {
				if (!empty($data['logo'])) {

					if (is_file('./assets/logo/'.$post['logo_before'])) {
						unlink('./assets/logo/'.$post['logo_before']);
					}

				}
				
				if (!empty($data['video'])) {

					if (is_file('./upload/video_beranda/'.$post['video_before'])) {
						unlink('./upload/video_beranda/'.$post['video_before']);
					}

				}
			}

			$pesan = 'Update berhasil';
			$hasil = 1;
			
		}else{
			$pesan = 'Update Gagal';
			$hasil = 0;
		}

		$results = array(
			'show'  => 1,
			'pesan' => $pesan,
			'hasil' => $hasil
		);
		$this->session->set_userdata($results);
		
		redirect(base_url('beranda'),'refresh');
	}


	public function update_slide(){
		$post = $this->input->post();
		$files = $_FILES;
		$qty_attach = $_FILES['slide']['name'];

		if(!empty($qty_attach[0])) {


			for($i=0; $i < count($qty_attach); $i++)
			{           

				$namafile = 'slide-'.DATE('d-m-Y')."-".time().'-'.$i;

				$config['upload_path']   = 'upload/slide/';
				$config['allowed_types'] = 'jpeg|jpg|png';
				$config['max_size']      = 222220480;
				$config['file_name']     = $namafile;

				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				

				$_FILES['slide']['name'] 		= $files['slide']['name'][$i];
				$_FILES['slide']['type']  		= $files['slide']['type'][$i];
				$_FILES['slide']['tmp_name']	= $files['slide']['tmp_name'][$i];
				$_FILES['slide']['error']		= $files['slide']['error'][$i];
				$_FILES['slide']['size']		= $files['slide']['size'][$i];    
				$this->upload->initialize($config);
				if ( ! $this->upload->do_upload('slide') ){
					$json = [
						'status' => 0,
						'msg'    => 'Upload file gagal!',
						'info' => $this->upload->display_errors()
					];
					echo json_encode($json);
					exit;
				}else{
					$upload_data = $this->upload->data();
					$file_name = $upload_data['file_name'];

					$attach[$i] = array(
						'id_instansi' => $this->akun->instansi,
						'file'        => $upload_data['file_name'],
						'format'      => $upload_data['file_ext']
					);
				}
			}

			$this->db->insert_batch('tb_slider',$attach);
		}


		$json = [
			'status' => true,
			'msg'    => 'success',
			'info' => NULL
		];
		echo json_encode($json);
		exit;

	}

	public function slide_delete(){
		$post = $this->input->post();
		
		$kirim = $this->m_slide->delete(array('id'=>$post['id']));
		if ($kirim) {
			$status = 1;
			if (file_exists($post['location'])) {
				unlink($post['location']);
			}
		}else{
			$status = 0;
		}
	}

}

/* End of file setting.php */
/* Location: ./application/controllers/setting.php */