<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class Register extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->db->query("SET time_zone='+7:00'");
		$waktu_sql = $this->db->query("SELECT NOW() AS waktu")->row_array();
		$this->waktu_sql = $waktu_sql['waktu'];
		$this->load->library('form_validation');
		$this->load->library('email');
	}

	public function get_servertime()
	{
		$now = new DateTime();
		$dt = $now->format("M j, Y H:i:s O");

		j($dt);
	}
	
	private function get_provinsi() 
	{
	    $this->db->select('*')
                 ->from('inf_lokasi')
                 ->where('lokasi_kabupatenkota', 0)
                 ->where('lokasi_kecamatan', 0)
                 ->where('lokasi_kelurahan', 0)
                 ->order_by('lokasi_nama', 'asc');
        $result = $this->db->get()->result();
        return $result;
	}
	
	public function get_kecamatan()
	{
	    if(empty($this->input->post('id_kota')) || !$this->input->post('id_provinsi')) {
	       $data = [
	         'status' => FALSE,
	         'msg'    => 'Parameter not found'
	       ];
	       
	       echo json_encode($data);
	       http_response_code(400); 
	    }
	    else {
	       $this->db->select('*')
	                ->from('inf_lokasi')
	                ->where('lokasi_propinsi', $this->input->post('id_provinsi'))
	                ->where('lokasi_kecamatan !=', 0)
	                ->where('lokasi_kelurahan', 0)
	                ->where('lokasi_kabupatenkota', $this->input->post('id_kota'))
	                ->order_by('lokasi_nama', 'asc');
	       $res = $this->db->get()->result();
	       
	       $data = [
	         'status' => TRUE,
	         'msg'    => 'There',
	         'res'    => $res
	       ];
	       
	       echo json_encode($data);
	       http_response_code(200); 
	    }
	}
	
	public function get_kota()
	{
	   if(empty($this->input->post('id_provinsi')) || !$this->input->post('id_provinsi')) {
	       $data = [
	         'status' => FALSE,
	         'msg'    => 'Parameter not found'
	       ];
	       
	       echo json_encode($data);
	       http_response_code(400);
	   }
	   else {
	       $this->db->select('*')
	                ->from('inf_lokasi')
	                ->where('lokasi_propinsi', $this->input->post('id_provinsi'))
	                ->where('lokasi_kecamatan', 0)
	                ->where('lokasi_kelurahan', 0)
	                ->where('lokasi_kabupatenkota !=', 0)
	                ->order_by('lokasi_nama', 'asc');
	       $res = $this->db->get()->result();
	       
	       $data = [
	         'status' => TRUE,
	         'msg'    => 'There',
	         'res'    => $res
	       ];
	       
	       echo json_encode($data);
	       http_response_code(200);
	   }
	}

	public function get_ju() {
		return $this->db->get('jenis_usaha');
	}

	public function index()
	{

        if($this->session->userdata('admin_konid') != NULL || $this->session->userdata('admin_konid') != '' ) {
            redirect('adm');
        }
		$data['jenis'] = $this->db->get('kelamin')->result_array();
	    $data['provinsi'] = $this->get_provinsi();	
	    $data['jenis_usaha'] = $this->get_ju();
		$this->load->view('register/header');
		$this->load->view('register/index', $data);
		$this->load->view('register/footer');
			
	}
	
	private function is_not_duplicate($email) {
	    $this->db->where('nim', $email);
	    $result = $this->db->get('m_siswa');
	    return $result->num_rows();
	}
	
	private function omset($id) {
	    
	}
	public function tambah()
	{
		$nama =	htmlspecialchars($this->input->post('nama'));	
		$email = htmlspecialchars($this->input->post('email'));
		$token = rand(100000, 999999);
        
        // check duplicate email
        $is_not_duplicate = $this->is_not_duplicate($email);
        if($is_not_duplicate > 0) {
            $this->session->set_flashdata('pesan', '<p class="alert alert-danger">Email sudah terdaftar</p>');
            redirect('register');
            exit;
        }
	    $data = [
			'nama' => $nama,
			'jenis_kelamin' => htmlspecialchars($this->input->post('kelamin')),
			'tanggal_lahir' => htmlspecialchars($this->input->post('tanggal')),
			'alamat' => htmlspecialchars($this->input->post('alamat')),
			'id_provinsi' => htmlspecialchars($this->input->post('provinsi')),
			'id_kota' => htmlspecialchars($this->input->post('kota_kab')),
			'id_kecamatan' => htmlspecialchars($this->input->post('kecamatan')),
			'nim' => $email,
			'no_telpon' => htmlspecialchars($this->input->post('telp')),
			'jurusan' => htmlspecialchars($this->input->post('ukm')),
			'alamat_ukm' => htmlspecialchars($this->input->post('alamat_usaha')),
			'id_provinsi_ukm' => htmlspecialchars($this->input->post('provinsi_usaha')),
			'id_kota_ukm' => htmlspecialchars($this->input->post('kota_kab_usaha')),
			'id_kecamatan_ukm' => htmlspecialchars($this->input->post('kecamatan_usaha')),
			'jenis_usaha' =>  $this->input->post('jenis_usaha') ,
			'omset_penjualan' => htmlspecialchars($this->input->post('omset')),
			'tanggal_berdiri' => htmlspecialchars($this->input->post('berdiri')),
			'pembuatan_akun' => time(),
			'verifikasi' => md5($token)
		];

		$config = array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_port' => '465',
			'smtp_timeout' => '7',
			'smtp_user' => 'skripsi.information@gmail.com',
			'smtp_pass' => '1010592admin',
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'newline' => "\r\n",
			'validation' => TRUE
		);

		$this->load->library('email');
		$this->email->initialize($config);
// 		$this->email->set_newline("\r\n");
		$this->email->from('skripsi.information@gmail.com', 'Admin Elearning');
		$this->email->to($this->input->post('email'));
		$this->email->subject('Verifikasi Akun');
		
		

		$message = "<center><b>SELAMAT ANDA TELAH TERDAFTAR</b><br></center>
		Nama Anda : $nama
		<br>
		Email Anda : $email
		<br>
		Password Anda : $token
		<br>
		Silahkan Klik Link Dibawah Ini Untuk Mengaktifkan Akun 
		<br>
		<center>
		 <a href='".base_url('register/aktif?token=').md5($token)."'>Aktifkan Akun</a>
		 </center>";
		 
		$this->email->message($message);

		if (!$this->email->send()) {
			 die($this->email->print_debugger());
			 exit;
		} else {
			echo 'Success to send email'.$message;
			$insert = $this->db->insert('m_siswa', $data);
			if($insert) {
        		$this->session->set_flashdata('pesan', '<div class="pesan alert alert-success" role="alert">Akun Telah Dibuat Silahkan Cek Email Anda Untuk Mengaktifkan..!!</div>');
        		redirect('register');
			}
		}
	}

	
	public function aktif(){
		$data['token'] = $this->input->get('token');
		$_SESSION['token'] = $data['token'];
		// var_dump($_SESSION['token']);
		// die;
		$user = $this->db->get_where('m_siswa', ['verifikasi' => $_SESSION['token']])->row_array();
		// $no['id'] = $this->db->query("SELECT `id` FROM `m_siswa` WHERE verifikasi = '".$_SESSION['token']."' ")->result_array();
// 		var_dump($user);
// 		die;
		$insert = $this->db->query("INSERT INTO m_admin VALUES (null, '".$user['nim']."', '".$user['verifikasi']."', 'siswa', '".$user['id']."')");
		if($insert)
		    redirect('login');
	}


}
