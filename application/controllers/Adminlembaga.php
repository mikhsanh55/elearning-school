<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adminlembaga extends MY_Controller {

	public $validasi;

    function __construct() {
        parent::__construct();
        $this->db->query("SET time_zone='+7:00'");
        $waktu_sql = $this->db->query("SELECT NOW() AS waktu")->row_array();
        $this->waktu_sql = $waktu_sql['waktu'];
        $this->opsi = array("a","b","c","d","e");
        $this->load->model('m_instansi');
        $this->load->model('m_admin');
        $this->load->model('m_siswa');
        $this->load->model('m_guru');
        $this->load->model('m_admin_lembaga');
        $this->load->library('validasi');

        $this->validasi = new Validasi();

        if ($this->log_lvl != 'instansi') {
        	redirect(base_url('adm'));
        }
	}


	public function index(){
		$data = array(
			'instansi' => $this->m_instansi->get_all(), 
			'searchFilter' => array('Nama','Username','Email','Lembaga')
		);
		$this->render('admin_lembaga/list',$data);
	}


	public function add(){
		$this->render('admin_lembaga/add');
	}


	public function insert(){
		$post = $this->input->post();

		$errors_txt = [];
		$errors = 0;
		
		$cek_username = $this->validasi->check_username($post['username'],'insert');
		$cek_email 	  = $this->validasi->check_email($post['email'],'insert');

		if ($cek_username > 0) {
			$errors_txt['username'] = 'Username sudah terpakai ! Coba username yang lain';
			$errors++;
		}

		if ($cek_email > 0) {
			$errors_txt['email'] = 'Email sudah terpakai ! Coba email yang lain ';
			$errors++;
		}

		
		$post['tgl_lahir'] = (!empty($post['tgl_lahir'])) ? date_default($post['tgl_lahir']) : NULL;

		if ($errors == 0) {
			
			$data = array(
				'nama' 			=> $post['nama'],
				'username' 		=> $post['username'],
				'tempat_lahir' 	=> $post['tempat_lahir'],
				'tanggal_lahir' => $post['tgl_lahir'],
				'email' 		=> $post['email'],
				'instansi' 		=> $post['lembaga'],
				'pembuatan_akun' => time(),
				'verifikasi' 	 => md5(time()) 
			);

			$kirim = $this->m_admin_lembaga->insert($data);
			if ($kirim) {
				$status = 1;
				$errors_txt['info'] = 'Berhasil Menyimpan Data';
			}else{
				$status = 0;
				$errors_txt['info'] = 'Gagal Menyimpan ! Hubungi Admin atau Tim Support';
				$errors++;
			}

			$json = array(
				'status'  => $status,
				'message' => $errors_txt,
				'qtyErrors' => $errors   
			);

			echo json_encode($json);

		}else{
			$errors_txt['info'] = 'Silahkan cek kembali form';
			$json = array(
				'status'  => 0,
				'message' => $errors_txt,
				'qtyErrors' => $errors   
			);

			echo json_encode($json);
		}

	}


	public function edit($id=0){
		$data = array(
			'instansi' => $this->m_instansi->get_all(),
			'edit' => $this->m_admin_lembaga->get_by(array('sha1(id)'=>$id))
		);
		$this->render('admin_lembaga/edit',$data);
	}

	public function update(){
		$post = $this->input->post();

		$errors_txt = [];
		$errors = 0;
		
		$cek_username = $this->validasi->check_username($post['username'],'update','admin_lembaga',$post['id']);
		$cek_email 	  = $this->validasi->check_email($post['email'],'update','admin_lembaga',$post['id']);

		if ($cek_username > 0){
			$errors_txt['username'] = 'Username sudah terpakai ! Coba username yang lain';
			$errors++;
		}

		 if ($cek_email > 0){
			$errors_txt['email'] = 'Email sudah terpakai ! Coba email yang lain ';
			$errors++;
		}
		
		$post['tgl_lahir'] = (!empty($post['tgl_lahir'])) ? date_default($post['tgl_lahir']) : NULL;

		if ($errors == 0) {
			
			$data = array(
				'nama' 			=> $post['nama'],
				'username' 		=> $post['username'],
				'tempat_lahir' 	=> $post['tempat_lahir'],
				'tanggal_lahir' => $post['tgl_lahir'],
				'email' 		=> $post['email'],
				'instansi' 		=> $post['lembaga'],
				'pembuatan_akun' => time(),
				'verifikasi' 	 => md5(time()) 
			);

			$kirim = $this->m_admin_lembaga->update($data,array('id'=>$post['id']));
			$cek_adm = $this->db->where(array('level' => 'admin_instansi', 'kon_id' => $post['id']))->get('m_admin')->result();
			if (count($cek_adm) > 0) {
				$data_adm = array(
					'user_id'  => $post['username'],
					'username' => $post['email']
				);
				$this->m_admin->update($data_adm, array('kon_id' => $post['id'], 'level' => 'admin_instansi'));
			}
			if ($kirim) {
				$status = 1;
				$errors_txt['info'] = 'Berhasil Menyimpan Data';
			}else{
				$status = 0;
				$errors_txt['info'] = 'Gagal Menyimpan ! Hubungi Admin atau Tim Support';
				$errors++;
			}

			$json = array(
				'status'  => $status,
				'message' => $errors_txt,
				'qtyErrors' => $errors   
			);

			echo json_encode($json);

		}else{
			$errors_txt['info'] = 'Silahkan cek kembali form';
			$json = array(
				'status'  => 0,
				'message' => $errors_txt,
				'qtyErrors' => $errors   
			);

			echo json_encode($json);
		}

	}

	public function buatkan_password(){
		$post = $this->input->post();

		$akun = $this->m_admin_lembaga->get_by(array('id'=>$post['id']));

		$data = array(
			'user_id'  => $akun->username,
			'username' => $akun->email, 
			'password' => $this->encryption->encrypt($akun->username), 
			'level'    => 'admin_instansi', 
			'kon_id'   => $akun->id, 
			'status'   => 0, 
		);

		$kirim = $this->m_admin->insert($data);

		if ($kirim) {
			$status = 1;
			$message = 'Berhasil membuat password untuk '.$akun->nama;
		}else{
			$status = 0;
			$message = 'Gagal Membuat password';
		}

		$json = array('status' => $status, 'message'=>$message);
		echo json_encode($json);

	}

	public function reset_password(){
		$post = $this->input->post();

		$akun = $this->m_admin_lembaga->get_by(array('id'=>$post['id']));

		$datas = array(
			'password' => $this->encryption->encrypt($akun->username), 
		);

		$where = array(
			'level' => 'admin_instansi', 
			'kon_id' => $akun->id
		);

		$kirim = $this->m_admin->update($datas,$where);

		if ($kirim) {
			$status = 1;
			$message = 'Berhasil mereset password untuk '.$akun->nama.' password sementara sama dengan username ';
		}else{
			$status = 0;
			$message = 'Gagal mereset password';
		}

		$json = array('status' => $status, 'message'=>$message);
		echo json_encode($json);

	}


	public function aktif_non_akun(){
		$post = $this->input->post();

		$akun = $this->m_admin_lembaga->get_by(array('id'=>$post['id']));

		$datas['deleted'] = ($post['status'] == 1) ? 0 : 1;
		$text = ($post['status'] == 1) ? 'Mengaktifkan' : 'MengnonAktifkan';

		$where = array(
			'id' => $post['id'], 
			'deleted' => $post['status']
		);

		$kirim = $this->m_admin_lembaga->update($datas,$where);

		if ($kirim) {
			$status = 1;
			$message = 'Berhasil '.$text.' akun '.$akun->nama.' ';
		}else{
			$status = 0;
			$message = 'Gagal '.$text.' akun '.$akun->nama.' ';
		}

		$json = array('status' => $status, 'message'=>$message);
		echo json_encode($json);

	}

	public function page_load($pg = 1){
		$post = $this->input->post();
		$limit = $post['limit'];
		$where = [];
		if (!empty($post['search'])) {
			switch ($post['filter']) {
				case 0:
					$where["(lower(nama) like '%".strtolower($post['search'])."%' )"] = null;
					break;
				case 1:
					$where["(lower(username) like '%".strtolower($post['search'])."%' )"] = null;
					break;
				case 2:
					$where["(lower(email) like '%".strtolower($post['search'])."%' )"] = null;
					break;
				case 3:
					$where["(lower(in.instansi) like '%".strtolower($post['search'])."%' )"] = null;
					break;
				default:
					# code...
					break;
			}
		}
		if($this->log_lvl != 'admin'){
			$where['in.id'] = $this->akun->instansi;
		}

		$paginate = $this->m_admin_lembaga->paginate($pg,$where,$limit);
		$data['paginate'] = $paginate;
		$data['paginate']['url']	= 'adminlembaga/page_load';
		$data['paginate']['search'] = 'lookup_key';
		$data['page_start'] = $paginate['counts']['from_num'];

		$this->load->view('admin_lembaga/table',$data);
		$this->generate_page($data);
	}

	public function multi_delete(){
		$post = $this->input->post();

		foreach ($post['id'] as $val) {
			$where[] = $val;
		}

		$this->db->trans_begin();

		$kirim = $this->db->where_in('id',$where)->delete('tb_admin_lembaga');

		$kirim = $this->db->where_in('kon_id',$where)->where_in('level','admin_instansi')->delete('m_admin');

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
		}
		else
		{
			$this->db->trans_commit();
		}

		if ($kirim) {
			$result = true;
		}else{
			$result = false;
		}

		echo json_encode(array('result'=>$result));
	}
}
