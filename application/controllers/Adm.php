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
		$post = $this->input->post();
		$ret = array();
		if ($uri3 == "simpan") {
			$p1_md5 = $p->p1;
			$p2_md5 = $p->p2;
			$p3_md5 = $p->p3;
			$cek_pass_lama = $this->m_admin->get_by(array('id'=>$this->session->userdata('admin_id')));
			if ($this->encryption->decrypt($cek_pass_lama->password) != $p1_md5) {
				$ret['status'] = "error";
				$ret['msg'] = "Password lama tidak sama...";
			} else if ($p2_md5 != $p3_md5) {
				$ret['status'] = "error";
				$ret['msg'] = "Password baru konfirmasinya tidak sama...";
			} else if (strlen($p->p2) < 5) {
				$ret['status'] = "error";
				$ret['msg'] = "Password baru minimal terdiri dari 5 huruf..";
 			} else {
				if(!is_null($p->id) && $p->id != FALSE) {
					$update = $this->m_admin->update(
						array('password'=>$this->encryption->encrypt($p3_md5)),
						['id'=> (int)$p->id]
					);
					if($update) {
						$ret['status'] = "ok";
						$ret['msg'] = "Password berhasil diubah...";
					}
					else {
						$ret['status'] = "error";
						$ret['msg'] = "Gagal mengubah password - 500";
					}
					
				} 
				else {
					$ret['status'] = "error";
					$ret['msg'] = "Data User tidak ada";
				}
				
			}
			j($ret);
			exit;
		} else {
			$data['data'] = $this->m_admin->get_data_by(array('admin.id'=>$this->session->userdata('admin_id')));
			$data['csrf'] = '<input type="hidden" name="'. $this->security->get_csrf_token_name(). '" value="'.$this->security->get_csrf_hash(). '">';
			j($data);
			exit;
		}
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
