<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Validasi extends CI_Model {
	
	public function check_username($username,$type='insert',$from=NULL,$id=NULL){

		$this->load->model('m_admin_lembaga');
		$this->load->model('m_akun_lembaga');
		$this->load->model('m_siswa');
		$this->load->model('m_guru');

		$cek_username = 0;

		switch ($type) {

			case 'insert':

				$cek_username1 = $this->m_admin_lembaga->count_by(array('akun.username'=>$username));
				$cek_username2 = $this->m_akun_lembaga->count_by(array('akun.username'=>$username));
				$cek_username3 = $this->m_siswa->count_by(array('username'=>$username));
				$cek_username4 = $this->m_guru->count_by(array('guru.username'=>$username));

				$cek_username = $cek_username1 + $cek_username2 + $cek_username3 + $cek_username4; 

				break;

				default:
						# code...
				break;

			case 'update':

			switch ($from) {
				case 'admin_lembaga':

				$cek_username1 = $this->m_admin_lembaga->count_by(array('akun.username'=>$username));
				$cek_username2 = $this->m_akun_lembaga->count_by(array('akun.username'=>$username));
				$cek_username3 = $this->m_siswa->count_by(array('username'=>$username));
				$cek_username4 = $this->m_guru->count_by(array('guru.username'=>$username));
				$data = $this->m_admin_lembaga->get_by(['username' => $username]);

				$cek_username = $cek_username2 + $cek_username3 + $cek_username4;

				if (!empty($cek_username1) && $data->id != $id) {
					$cek_username = 1;
				}else if ($cek_username > 0){
					$cek_username = 1;
				}

				break;


				case 'akun_lembaga':

				$cek_username1 = $this->m_akun_lembaga->get_by(array('username'=>$username));
				$cek_username2 = $this->m_admin_lembaga->count_by(array('akun.username'=>$username));
				$cek_username3 = $this->m_siswa->count_by(array('username'=>$username));
				$cek_username4 = $this->m_guru->count_by(array('guru.username'=>$username));
				$data = $this->m_akun_lembaga->get_by(['username' => $username]);

				$cek_username = $cek_username2 + $cek_username3 + $cek_username4;

				if (!empty($cek_username1) && $data->id != $id) {
					$cek_username = 1;
				}else if ($cek_username > 0){
					$cek_username = 1;
				}

				break;

				case 'siswa':

				$cek_username1 = $this->m_siswa->get_by(array('username'=>$username));
				$cek_username2 = $this->m_akun_lembaga->count_by(array('akun.username'=>$username));
				$cek_username3 = $this->m_admin_lembaga->count_by(array('akun.username'=>$username));
				$cek_username4 = $this->m_guru->count_by(array('guru.username'=>$username));
				$data = $this->m_siswa->get_by(['username' => $username]);

				$cek_username = $cek_username2 + $cek_username3 + $cek_username4;

				if (!empty($cek_username1) && $data->id != $id) {
					$cek_username = 1;
				}else if ($cek_username > 0){
					$cek_username = 1;
				}

				break;

				case 'guru':

				$cek_username1 = $this->m_guru->get_by(array('username'=>$username));
				$cek_username2 = $this->m_akun_lembaga->count_by(array('akun.username'=>$username));
				$cek_username3 = $this->m_admin_lembaga->count_by(array('akun.username'=>$username));
				$cek_username4 = $this->m_siswa->count_by(array('username'=>$username));
				$data = $this->m_guru_lembaga->get_by(['username' => $username]);

				$cek_username = $cek_username2 + $cek_username3 + $cek_username4;

				if (!empty($cek_username1) && $data->id != $id) {
					$cek_username = 1;
				}else if ($cek_username > 0){
					$cek_username = 1;
				}

				break;

			}

			break;


		}
		
		return $cek_username;

	}	


	public function check_email($email,$type='insert',$from=NULL,$id=NULL){

		$this->load->model('m_admin_lembaga');
		$this->load->model('m_akun_lembaga');
		$this->load->model('m_siswa');
		$this->load->model('m_guru');

		$cek_email = 0;
		if($email != '') :

			switch ($type) {

				case 'insert':

					$cek_email1 = $this->m_admin_lembaga->count_by(array('email'=>$email));
					$cek_email2 = $this->m_akun_lembaga->count_by(array('email'=>$email));
					$cek_email3 = $this->m_siswa->count_by(array('email'=>$email));
					$cek_email4 = $this->m_guru->count_by(array('email'=>$email));

					$cek_email = $cek_email1 + $cek_email2 + $cek_email3 + $cek_email4; 

					break;

				break;

				case 'update':

				switch ($from) {
					case 'admin_lembaga':

					$cek_email1 = $this->m_admin_lembaga->get_by(array('email'=>$email));
					$cek_email2 = $this->m_akun_lembaga->count_by(array('email'=>$email));
					$cek_email3 = $this->m_siswa->count_by(array('email'=>$email));
					$cek_email4 = $this->m_guru->count_by(array('email'=>$email));

					$cek_email = $cek_email2 + $cek_email3 + $cek_email4;

					if (!empty($cek_email1) && $cek_email1->id != $id) {
						$cek_email = 1;
					}else if ($cek_email > 0){
						$cek_email = 1;
					}

					break;

					case 'akun_lembaga':

					$cek_email1 = $this->m_akun_lembaga->get_by(array('email'=>$email));
					$cek_email2 = $this->m_admin_lembaga->count_by(array('email'=>$email));
					$cek_email3 = $this->m_siswa->count_by(array('email'=>$email));
					$cek_email4 = $this->m_guru->count_by(array('email'=>$email));

					$cek_email = $cek_email2 + $cek_email3 + $cek_email4;

					if (!empty($cek_email1) && $cek_email1->id != $id) {
						$cek_email = 1;
					}else if ($cek_email > 0){
						$cek_email = 1;
					}

					break;


					case 'siswa':

					$cek_email1 = $this->m_siswa->get_by(array('email'=>$email));
					$cek_email2 = $this->m_akun_lembaga->count_by(array('email'=>$email));
					$cek_email3 = $this->m_admin_lembaga->count_by(array('email'=>$email));
					$cek_email4 = $this->m_guru->count_by(array('email'=>$email));

					$cek_email = $cek_email2 + $cek_email3 + $cek_email4;

					if (!empty($cek_email1) && $cek_email1->id != $id) {
						$cek_email = 1;
					}else if ($cek_email > 0){
						$cek_email = 1;
					}

					break;


					case 'guru':

					$cek_email1 = $this->m_guru->get_by(array('email'=>$email));
					$cek_email2 = $this->m_akun_lembaga->count_by(array('email'=>$email));
					$cek_email3 = $this->m_admin_lembaga->count_by(array('email'=>$email));
					$cek_email4 = $this->m_siswa->count_by(array('email'=>$email));

					$cek_email = $cek_email2 + $cek_email3 + $cek_email4;

					if (!empty($cek_email1) && $cek_email1->id != $id) {
						$cek_email = 1;
					}else if ($cek_email > 0){
						$cek_email = 1;
					}

					break;

				}

				break;



			}
		endif;

		return $cek_email;

	}					


}