<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class Login extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->db->query("SET time_zone='+7:00'");
		$waktu_sql = $this->db->query("SELECT NOW() AS waktu")->row_array();
		$this->waktu_sql = $waktu_sql['waktu'];
		$this->opsi = array("a", "b", "c", "d", "e");
		$this->load->model('m_instansi');
		$this->load->model('m_admin');
		$this->load->model('m_siswa');
        $this->load->model('m_akun_lembaga');
        $this->load->model('m_admin_lembaga');
		$this->load->model('m_guru');
		ob_start();
	}

	public function get_servertime()
	{
		$now = new DateTime();
		$dt = $now->format("M j, Y H:i:s O");

		j($dt);
	}

	public function cek_aktif()
	{
		if ($this->session->userdata('admin_valid') == false && $this->session->userdata('admin_id') == "") {
			redirect('login');
		}
	}
	
	public function check_sess()
	{
		if ($this->session->userdata('admin_valid') == false && $this->session->userdata('admin_id') == "") {
		    $d = 0;
		}else{
		    $d = 1;
		}
		
		echo json_encode(array('d'=>$d));
	}

	public function index()
	{
	    if($this->session->userdata('admin_konid') != NULL || $this->session->userdata('admin_konid') != '' ) {
            redirect('adm');
        }
		$this->load->view('login/header');
		$this->load->view('login/index');
		$this->load->view('login/footer');
	}

	public function act_login()
	{

		$username	= $this->input->post('username',true);
		$password	= $this->input->post('password',true);
        
        if(empty($username) || empty($password)){

        	$status = 0;
        	$keterangan = 'Maaf, username atau password tidak boleh kosong';
        	$detil_admin = NULL;

        }else{

        	$get_user = $this->m_admin->get_by(array('user_id'=>$username));

        	if (empty($get_user)) {
        		$get_user = $this->m_admin->get_by(array('username'=>$username));
        	}

         

        	if (!empty($get_user)) {

        		$decrypt_pass = $this->encryption->decrypt($get_user->password);
        		if ($decrypt_pass == $password) {


        			if ($get_user->level == "siswa") {
        				$siswa = $this->m_siswa->get_by(array('id'=>$get_user->kon_id));
        				$instansi = $this->m_instansi->get_by(array('id'=>$siswa->instansi));
        				if (empty($instansi)) {
        					$_log['log']['status']			= "0";
        					$_log['log']['keterangan']		= "Maaf, akun anda tidak terdaftar pada instansi mana pun, silahkan hubungi admin";
        					$_log['log']['detil_admin']		= null;
        					j($_log);exit;
        				}else if ($instansi->deleted == 1) {
        					$_log['log']['status']			= "0";
        					$_log['log']['keterangan']		= "Maaf, instansi anda di nonakifkan silahkan hubungi admin";
        					$_log['log']['detil_admin']		= null;
        					j($_log);exit;
        				}else if($siswa->deleted == 1){
        					$_log['log']['status']			= "0";
        					$_log['log']['keterangan']		= "Maaf, akun anda di nonakifkan, silahkan hubungi admin";
        					$_log['log']['detil_admin']		= null;
        					j($_log);exit;
        				}else{

        					$data = array(
        						'active_num' => $siswa->active_num + 1, 
        					);

        					$this->m_siswa->update($data,array('id'=>$siswa->id));

        					if (!empty($siswa)) {
        						$sess_nama_user = $siswa->nama;
        					}
        				}

        			}else if ($get_user->level == "instansi") {
                        $lembaga = $this->m_akun_lembaga->get_by(array('id'=>$get_user->kon_id));
                        $instansi = $this->m_instansi->get_by(array('id'=>$lembaga->instansi));
                        if (empty($instansi)) {
                            $_log['log']['status']          = "0";
                            $_log['log']['keterangan']      = "Maaf, akun anda tidak terdaftar pada instansi mana pun, silahkan hubungi admin";
                            $_log['log']['detil_admin']     = null;
                            j($_log);exit;
                        }else if ($instansi->deleted == 1) {
                            $_log['log']['status']          = "0";
                            $_log['log']['keterangan']      = "Maaf, instansi anda di nonakifkan silahkan hubungi admin";
                            $_log['log']['detil_admin']     = null;
                            j($_log);exit;
                        }else if($lembaga->deleted == 1){
                            $_log['log']['status']          = "0";
                            $_log['log']['keterangan']      = "Maaf, akun anda di nonakifkan, silahkan hubungi admin";
                            $_log['log']['detil_admin']     = null;
                            j($_log);exit;
                        }else{

                            if (!empty($lembaga)) {
                                $sess_nama_user = $lembaga->nama;
                            }
                        }

                    }else if ($get_user->level == "admin_instansi") {
                        $lembaga = $this->m_admin_lembaga->get_by(array('id'=>$get_user->kon_id));
                        $instansi = $this->m_instansi->get_by(array('id'=>$lembaga->instansi));
                        if (empty($instansi)) {
                            $_log['log']['status']          = "0";
                            $_log['log']['keterangan']      = "Maaf, akun anda tidak terdaftar pada instansi mana pun, silahkan hubungi admin";
                            $_log['log']['detil_admin']     = null;
                            j($_log);exit;
                        }else if ($instansi->deleted == 1) {
                            $_log['log']['status']          = "0";
                            $_log['log']['keterangan']      = "Maaf, instansi anda di nonakifkan silahkan hubungi admin";
                            $_log['log']['detil_admin']     = null;
                            j($_log);exit;
                        }else if($lembaga->deleted == 1){
                            $_log['log']['status']          = "0";
                            $_log['log']['keterangan']      = "Maaf, akun anda di nonakifkan, silahkan hubungi admin";
                            $_log['log']['detil_admin']     = null;
                            j($_log);exit;
                        }else{

                            if (!empty($lembaga)) {
                                $sess_nama_user = $lembaga->nama;
                            }
                        }

                    } else if ($get_user->level == "guru") {
        				$det_user = $this->m_guru->get_by(array('id'=>$get_user->kon_id));
        				if (!empty($det_user)) {
        					$sess_nama_user = $det_user->nama;
        				}
        			} else {
        				$sess_nama_user = "Administrator";
        			}


        			$data = array(
        				'admin_id' => $get_user->id,
        				'admin_user' => $get_user->username,
        				'admin_level' => $get_user->level,
        				'admin_konid' => $get_user->kon_id,
        				'admin_nama' => $sess_nama_user,
        				'admin_valid' => true
        			);

        			$this->session->set_userdata($data);

                    // Update sum login
                    date_default_timezone_set('Asia/Jakarta');
                    $this->db->where(['id' => $get_user->id]);
                    $this->db->update('m_admin', [
                        'sum_login' => $get_user->sum_login + 1,
                        'login_at'  => date('Y-m-d H:i:s')
                    ]);


        			$this->session->set_userdata($data);

        			$status = 1;
        			$keterangan = 'Login berhasil';
        			$detil_admin = $this->session->userdata;
        			
        		}else{
        			$status = 0;
	        		$keterangan = 'Maaf, Password salah!';
	        		$detil_admin = NULL;
        		}

        	}else{
        		$status = 0;
        		$keterangan = 'Maaf, username tidak ditemukan';
        		$detil_admin = NULL;
        	}
        }

        $_log['log']['status']			= $status;
        $_log['log']['keterangan']		= $keterangan;
        $_log['log']['detil_admin']		= $detil_admin;
        j($_log);exit;
		
	}

	public function logout()
	{	
		$id = $this->session->userdata('admin_konid');
		$this->db->update('m_admin',array('status'=>0),array('kon_id'=>$id));

		$this->session->unset_userdata('admin_konid');

		$this->load->driver('cache');
		$this->session->sess_destroy();
		$this->cache->clean();
		ob_clean();
		
		redirect(base_url('login'));
	}
	//fungsi tambahan

}
