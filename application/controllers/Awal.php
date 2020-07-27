<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class Awal extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper('url');
		$this->db->query("SET time_zone='+7:00'");
		$waktu_sql = $this->db->query("SELECT NOW() AS waktu")->row_array();
		$this->waktu_sql = $waktu_sql['waktu'];
		$this->opsi = array("a", "b", "c", "d", "e");
// 		$this->model->load('m_awal');
		
	}

	public function index()
	{
        
		$this->load->view('index/header');
		$this->load->view('index/index');
		$this->load->view('index/footer');
	}

	function test(){
		exit;
		$get = $this->db->select('*')->get('m_admin')->result();
		foreach($get as $rows){
			$pass = password_hash($rows->user_id, PASSWORD_BCRYPT);
			$this->db->update('m_admin',['password'=>$pass],['id'=>$rows->id]);
		}
		$password = 'adminsman21bdg';
		echo $encryt =  password_hash($password, PASSWORD_BCRYPT),'<br>';
		
		if (password_verify('12345678', $encryt)) {
			echo 'Password is valid!';
		} else {
			echo 'Invalid password.';
		}
	}
}
