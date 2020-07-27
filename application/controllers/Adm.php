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
	// public function res_pwd() {
	// 	// Cek Is Login
	// 	$this->cek_aktif();

	// 	$post = $this->input->post();

	// 	$id_admin = $this->session->userdata('admin_id');

	// 	// Cek Ketersediaan password
	// 	$data = $this->m_admin->get_by(['id' => $id_admin]);
	// 	$returned_data = [
	// 		'status' => FALSE,
	// 		'msg'	 => 'Password gagal diubah',
	// 		'data'	 => []
	// 	];
	// 	$response_code = 500;

	// 	if(!empty($data)) {
	// 		$pwd = $this->encryption->decrypt($data->password);

	// 		// Cek password lama
	// 		if( $pwd !== $post['old_pwd'] ) {
	// 			$returned_data = [
	// 				'status' => FALSE,
	// 				'data'   => [],
	// 				'msg'	 => 'Password lama salah'
	// 			];
	// 			$response_code = 400;
	// 		}
	// 		else if( $post['new_pwd'] !== $post['confirm_new_pwd'] ) { // Cek kesamaan password
	// 			$returned_data = [
	// 				'status' => FALSE,
	// 				'data'   => [],
	// 				'msg'	 => 'Konfirmasi Password baru tidak sama'
	// 			];
	// 			$response_code = 400;	
	// 		}
	// 		else if( strlen($post['new_pwd']) < 8 ) {
	// 			$returned_data = [
	// 				'status' => FALSE,
	// 				'data'   => [],
	// 				'msg'	 => 'Password baru minimal 8 karakter'
	// 			];
	// 			$response_code = 400;		
	// 		}
	// 		else {
	// 			$new_pwd = $this->encryption->encrypt($post['new_pwd']);
	// 			$update = $this->m_admin->update([
	// 				'password' => $new_pwd
	// 			], ['id' => $id_admin]);

			

	// 			if($update) {

	// 				$data = [
	// 					'id_user' => $id_admin,
	// 					'level'   => $this->session->userdata('admin_level'),
	// 					'pass'   => $post['new_pwd']
	// 				];
	// 				$this->db->insert('tb_log_password', $data);
	// 				$returned_data = [
	// 					'status' => TRUE,
	// 					'data'   => $data,
	// 					'msg'	 => 'Password berhasil diubah'
	// 				];
	// 				$response_code = 200;	
	// 			}
	// 			else {
	// 				$returned_data = [
	// 					'status' => TRUE,
	// 					'data'	 => [],
	// 					'msg'	 => 'Password Gagal diubah'
	// 				];
	// 				$response_code = 500;
	// 			}
	// 		}
	// 	}
	// 	// Send response
	// 	$this->sendAjaxResponse($returned_data, $response_code);
	// }

	public function rubah_password() {
		$this->cek_aktif();
		
		//var def session
		$a['sess_admin_id'] = $this->session->userdata('admin_id');
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');

		//var def uri segment
		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		//var post from json
		$p = json_decode(file_get_contents('php://input'));
		$ret = array();
		if ($uri3 == "simpan") {
			$p1_md5 = $p->p1;
			$p2_md5 = $p->p2;
			$p3_md5 = $p->p3;
			$cek_pass_lama = $this->m_admin->get_by(array('id'=>$a['sess_admin_id']));
			if (empty($p1_md5)) {
				$ret['status'] = "error";
				$ret['msg'] = "Password sama harus di isi...";
			} else if (!password_verify($p1_md5, $cek_pass_lama->password)) {
				$ret['status'] = "error";
				$ret['msg'] = "Password lama tidak sama...";
			} else if ($p2_md5 != $p3_md5) {
				$ret['status'] = "error";
				$ret['msg'] = "Password baru konfirmasinya tidak sama...";
			} else if (strlen($p->p2) < 8) {
				$ret['status'] = "error";
				$ret['msg'] = "Password baru minimal terdiri dari 8 huruf..";
 			} else {
				$new_pass = password_hash($p3_md5, PASSWORD_BCRYPT);
				$kirim = $this->m_admin->update(array('password'=>$new_pass),array('id'=>$a['sess_admin_id']));
				if($kirim){
					$data = [
					 		'id_user' => $a['sess_admin_id'],
					 		'level'   => $this->session->userdata('admin_level'),
					 		'pass'   => $p3_md5
					 	];
					 	$this->db->insert('tb_log_password', $data);
				}
				$ret['status'] = "ok";
				$ret['msg'] = "Password berhasil diubah...";
			}
			j($ret);
			exit;
		} else {
			$data = $this->m_admin->get_by(array('id'=>$a['sess_admin_id']));
			j($data);
			exit;
		}
    }
	
	public function reset(){
		exit;
		$where = [
			'sis.instansi' => 11,
			'adm.level' => 'siswa'
		];
		$get = $this->db->select('adm.*')
					->from('m_admin adm')
					->join('m_siswa sis','sis.id=adm.kon_id','inner')
					->where($where)
					->get()
					->result();
					echo '<pre>';		
					echo '<br>';
					echo $this->db->last_query();

		foreach($get as $rows){
			$pass = $this->encryption->encrypt($rows->user_id);
			$this->db->update('m_admin',['password'=>$pass],['id'=>$rows->id]);
		}
		
		echo count($get).'<br>';

		print_r($get);
	}
	
	public function reset_email(){
		exit;
		$where = [
			'sis.instansi' => 11,
			'pas.id' => null
		];
		$get = $this->db->select('adm.*')
					->from('m_admin adm')
					->join('tb_log_password pas','pas.id_user=adm.id','left')
					->join('m_siswa sis','sis.id=adm.kon_id','inner')
					->where($where)
					->get()
					->result();
					echo '<pre>';		
					echo '<br>';
					echo $this->db->last_query();

		foreach($get as $rows){
			$pass = $this->encryption->encrypt($rows->user_id);
			$this->db->update('m_admin',['password'=>$pass],['id'=>$rows->id]);
		}
		
		echo count($get).'<br>';

		print_r($get);
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
