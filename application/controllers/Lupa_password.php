<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class Lupa_password extends MY_Controller
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
	}

	public function index()
	{

		$this->load->view('index/header');
		$this->load->view('lupa/index');
	}


	public function resetlink()
	{
		$email = $this->input->post('email');
		$result = $this->db->query("select * from m_admin where username='".$email."'")->result_array();
		if (count($result) > 0) {
			$config = array(
				'protocol' => 'smtp',
				'smtp_host' => 'ssl://smtp.googlemail.com',
				'smtp_port' => 465,
				'smtp_user' => 'testing.icommits@gmail.com',
				'smtp_pass' => 'weknowit13111025',
				'mailtype' => 'html',
				'charset' => 'iso-8859-1'
			);

			$this->load->library('email', $config);
			$this->email->set_mailtype("html");
            $this->email->set_newline("\r\n");
			$this->email->from('testing.icommits@gmail.com', 'Admin Elearning');
			$this->email->to($email);
			$this->email->subject('Reset Password');

			$token = rand(100000, 999999);
			$this->db->query("update m_admin set password='".$this->encryption->encrypt($token)."'where username='".$email."'");
			$message = "<b><h3>Reset Password</h3></b><br>
			Password Baru Anda Telah Dibuat:<br>
			Email Anda : $email <br>
			Password Anda : $token";
			$this->email->message($message);
            $sending_email = $this->email->send();
			if (!$sending_email) {
				show_error($this->email->print_debugger());
			} else {
				echo 'Success to send email '.$message;
			}
			$this->session->set_flashdata('pesan', '<div class="pesan alert alert-success text-center" role="alert">Password Baru Anda Telah Dikirimkan Ke Email Anda !! </div>');
			redirect('lupa_password');
		} else {
			$this->session->set_flashdata('pesan', '<div class="pesan alert alert-danger text-center" role="alert">Email Tidak Terdaftar</div>');
			redirect('lupa_password');
		}
	}
}
