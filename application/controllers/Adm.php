<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class Adm extends MY_Controller {
	function __construct() {
        parent::__construct();
        $this->load->model('m_admin');
        $this->db->query("SET time_zone='+7:00'");
        $waktu_sql = $this->db->query("SELECT NOW() AS waktu")->row_array();
        $this->waktu_sql = $waktu_sql['waktu'];
        $this->opsi = array("a","b","c","d","e");
        // print_r($this->menu);exit;	
	}
	
	public function get_servertime() {
		$now = new DateTime(); 
        $dt = $now->format("M j, Y H:i:s O"); 

        j($dt);
	}

	public function cek_aktif() {
		if ($this->session->userdata('admin_valid') == false && $this->session->userdata('admin_id') == "") {
			redirect('login');
		} 
	}
	
	public function index() {
		redirect('/beranda');
		
	}

	/*
	*	Get User Info for reset password user
	*/ 
	public function get_user_info() {
		// Cek Is Login
		$this->cek_aktif();

		$data = $this->m_admin->get_by(['id' => $this->session->userdata['admin_id']]);
		if(!empty($data)) {
			$this->sendAjaxResponse([
				'status' => TRUE,
				'data' => $data,
				'msg'  => 'Data User ditemukan.'
			], 200);
		}
		else {
			$this->sendAjaxResponse([
				'status' => FALSE,
				'data'   => [],
				'msg'	 => 'Data User tidak ditemukan.'
			] ,500);
		}
	}

	/*
	*	Reset Password User
	*/
	public function res_pwd() {
		// Cek Is Login
		$this->cek_aktif();

		$post = $this->input->post();

		// Cek Ketersediaan password
		$data = $this->m_admin->get_by(['id' => $post['id']]);
		$returned_data = [
			'status' => FALSE,
			'msg'	 => 'Password gagal diubah',
			'data'	 => []
		];
		$response_code = 500;

		if(!empty($data)) {
			$pwd = $this->encryption->decrypt($data->password);

			// Cek password lama
			if( $pwd !== $post['old_pwd'] ) {
				$returned_data = [
					'status' => FALSE,
					'data'   => [],
					'msg'	 => 'Password lama salah'
				];
				$response_code = 400;
			}
			else if( $post['new_pwd'] !== $post['confirm_new_pwd'] ) { // Cek kesamaan password
				$returned_data = [
					'status' => FALSE,
					'data'   => [],
					'msg'	 => 'Konfirmasi Password baru tidak sama'
				];
				$response_code = 400;	
			}
			else if( strlen($post['new_pwd']) < 8 ) {
				$returned_data = [
					'status' => FALSE,
					'data'   => [],
					'msg'	 => 'Password baru minimal 8 karakter'
				];
				$response_code = 400;		
			}
			else {
				$new_pwd = $this->encryption->encrypt($post['new_pwd']);
				$update = $this->m_admin->update([
					'password' => $new_pwd
				], ['id' => $post['id']]);

				if($update) {

					$data = [
						'id_user' => $post['id'],
						'level'   => $this->session->userdata('admin_level')
					];
					$this->db->insert('tb_log_password', $data);
					$returned_data = [
						'status' => TRUE,
						'data'   => $data,
						'msg'	 => 'Password berhasil diubah'
					];
					$response_code = 200;	
				}
				else {
					$returned_data = [
						'status' => TRUE,
						'data'	 => [],
						'msg'	 => 'Password Gagal diubah'
					];
					$response_code = 500;
				}
			}
		}

		// Send response
		$this->sendAjaxResponse($returned_data, $response_code);
	}	
	
	//fungsi tambahan
	public function get_akhir($tabel, $field, $kode_awal, $pad) {
		$get_akhir	= $this->db->query("SELECT MAX($field) AS max FROM $tabel LIMIT 1")->row();
		$data		= (intval($get_akhir->max)) + 1;
		$last		= $kode_awal.str_pad($data, $pad, '0', STR_PAD_LEFT);
	
		return $last;
	}
	
	
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
