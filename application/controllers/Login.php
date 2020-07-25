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

    // Untuk check domain
    public function checkDomain() {
        
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
        $url = "http" . (($_SERVER['SERVER_PORT'] == 443) ? "s" : "") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        $check_domain = $this->m_instansi->get_by(['domain' => $url]);

        if(empty($check_domain)) {
            $this->logo = base_url('assets/logo/') . '1587386003_logo_Sekolah20200420193323.png';
            $this->title = 'E-Learning Sekolah';
        }
        else {
            $data = $this->m_setting_instansi->get_by(['id_instansi' => $check_domain->id]);
            $this->logo = base_url('assets/logo/') . $data->logo;
            $this->title = $data->judul;
        }

        $datas['csrf'] = $this->generateCSRFToken();
        // print_r($datas);exit;

		$this->load->view('login/header');
		$this->load->view('login/index', $datas);
		$this->load->view('login/footer');
	}

    // Update status login apakah online atau offline
    public function setStatusActive($status = 0, $where = []) {
        $update = $this->m_admin->update(['status' => $status], $where);
        if(!$update) {
            return FALSE;
        }

        return TRUE;
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
                        $cek_kelas = $this->m_detail_kelas->get_by(['id_peserta' => $get_user->kon_id]);
                        // print_r($cek_kelas);exit;
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
        				}else
                        // Jika Siswa belum punya kelas
                        if(empty($cek_kelas)) {
                            $_log['log']['status']          = "0";
                            $_log['log']['keterangan']      = "Anda belum memiliki kelas, harap hubungi Admin";
                            $_log['log']['detil_admin']     = null;
                            j($_log);exit;
                        }
                        else if($siswa->deleted == 1){
        					$_log['log']['status']			= "0";
        					$_log['log']['keterangan']		= "Maaf, akun anda di nonakifkan, silahkan hubungi admin";
        					$_log['log']['detil_admin']		= null;
        					j($_log);exit;
        				}else{

        					$data = array(
        						'active_num' => $siswa->active_num + 1, 
        					);

        					$this->m_siswa->update($data,array('id'=>$siswa->id));

                            // Set as Online
                            $this->setStatusActive(1, ['id' => $get_user->id]);

        					if (!empty($siswa)) {
        						$sess_nama_user = $siswa->nama;
        					}
                            else {
                                $sess_nama_user = 'Siswa';
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
                            $this->setStatusActive(1, ['id' => $get_user->id]);
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
                            $this->setStatusActive(1, ['id' => $get_user->id]);
                            if (!empty($lembaga)) {
                                $sess_nama_user = $lembaga->nama;
                            }
                        }

                    } else if ($get_user->level == "guru") {
        				$det_user = $this->m_guru->get_by(array('id'=>$get_user->kon_id));
        				if (!empty($det_user)) {
        					$sess_nama_user = $det_user->nama;

                            // Update Num Active
                            $data_update = [
                                'active_num' => $det_user->active_num + 1
                            ];
                            $this->db->where('id', $get_user->kon_id);
                            $this->db->update('m_guru', $data_update);

                            // Set as Online
                            $this->setStatusActive(1, ['id' => $get_user->id]);

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
		$id = $this->session->userdata('admin_id');
        $this->setStatusActive(0, ['id' => $id]);
		$this->session->unset_userdata('admin_konid');

		$this->load->driver('cache');
		$this->session->sess_destroy();
		$this->cache->clean();
		ob_clean();
		
		redirect(base_url('login'));
	}
	//fungsi tambahan

}
