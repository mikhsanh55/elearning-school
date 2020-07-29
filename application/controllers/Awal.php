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
		$get = $this->db->select('*')->where(['level'=>'siswa','user_id'=>181910103])->get('m_admin')->result();
		echo '<br>';
		echo count($get);
		echo '<br>';
	

		foreach($get as $rows){
			$data = [
				'username' => 'smanbdg_'.$rows->user_id.'@gmail.com',
				'password' => password_hash($rows->user_id, PASSWORD_BCRYPT)
			];
		
			$pass = password_hash($rows->user_id, PASSWORD_BCRYPT);
			$this->db->update('m_admin',$data,['id'=>$rows->id]);
		}

		echo 'selesai . <br>';

		
	}
}
