<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sanksi extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{

		//var def uri segment
		$uri1 = $this->uri->segment(1);
		$uri2 = $this->uri->segment(2);
		
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');
		$a['menu'] = $this->db->query("SELECT `nama_menu`, `link`, `icon` FROM rule_users JOIN menu ON rule_users.id_menu = menu.id JOIN level ON rule_users.id_level = level.id WHERE level = '".$a['sess_level']."' ")->result_array();
		$a['link'] = $this->db->query("SELECT link FROM rule_users JOIN menu ON rule_users.id_menu = menu.id JOIN level ON rule_users.id_level = level.id WHERE link = '".$uri1."/".$uri2."' AND level = '".$a['sess_level']."' ")->result_array();

		$a['opening'] = 'https://rds.pengusahacerdas.com/assets/materi/video/openingrds1001.mp4';
		$a['p']			= "v_main";

		if($a['sess_level'] == 'admin'){
			/*cek_hakakses(array("admin"), $this->session->userdata('admin_level'));
			$this->load->view('dashboard/template/header', $a);
			$this->load->view('dashboard/template/navbar', $a);
			$this->load->view('dashboard/admin/index', $a);
			$this->load->view('dashboard/template/footer', $a);*/
		}else if($a['sess_level'] == 'guru'){
		/*	cek_hakakses(array("guru"), $this->session->userdata('admin_level'));
			$this->load->view('dashboard/template/header', $a);
			$this->load->view('dashboard/template/navbar', $a);
			$this->load->view('dashboard/trainer/index', $a);
			$this->load->view('dashboard/template/footer', $a);*/
		}else{
			cek_hakakses(array("siswa"), $this->session->userdata('admin_level'));
			$this->load->view('dashboard/template/header', $a);
			$this->load->view('dashboard/template/navbar', $a);
			$this->load->view('sanksi/index', $a);
			$this->load->view('dashboard/template/footer', $a);
		}	
	}

}

/* End of file sanksi.php */
/* Location: ./application/controllers/sanksi.php */