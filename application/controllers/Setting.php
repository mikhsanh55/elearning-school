<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_setting');
	}

	public function index()
	{
		$data = array(
			'setting' => $this->m_setting->get_by(array('id'=>1))
		);
		$this->render('setting/set',$data);	
	}

	public function update(){
		$post = $this->input->post();

		if (empty($post['id'])) {
			redirect(base_url('beranda'),'refresh');
		}

		if (!empty($_FILES["logo"]['name'])) {

			$file = $_FILES["logo"]['name'];
			$ifile = str_replace(" ", "_", $file);
			$new_name = time()."_logo".'_'.date('YmdHis');
			
			$config['upload_path'] = 'assets/img/';
			$config['allowed_types'] = 'jpeg|jpg|png';
			$config['max-size'] =  2048;
			$config['file_name'] = $new_name;

			$this->load->library('upload', $config);
			$this->upload->initialize($config);


			if($this->upload->do_upload("logo")){
				$info = $this->upload->data();

				$data['logo'] = $info['raw_name'].$info['file_ext'];
	
			}else{

				$error= $this->upload->display_errors();

				echo $error;



				exit;

			}
			

		}else{
			$ret_arr['status'] 	= 0;
			$ret_arr['message']	= 'File Belum di pilih!';
		}
		
		if(empty($post['status_logo'])){
			$post['status_logo'] = 0;
		}
		// (empty($post['status_login'])) ? 1 : 0; 

		$data['judul'] = $post['judul'];
		$data['footer'] = $post['footer'];
		$data['logo_login'] = $post['status_logo'];
	
		$kirim = $this->m_setting->update($data,array('id'=>$post['id']));
		

		if ($kirim) {
			$pesan = 'Update berhasil';
			$hasil = 1;
			if (!empty($data['logo'])) {

				if (is_file('./assets/img/'.$post['logo_before'])) {
					unlink('./assets/img/'.$post['logo_before']);
				}

			}
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

}

/* End of file setting.php */
/* Location: ./application/controllers/setting.php */