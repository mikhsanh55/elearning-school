<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dtest extends MY_Controller {



    function __construct() {

        parent::__construct();

        $this->db->query("SET time_zone='+7:00'");

        $waktu_sql = $this->db->query("SELECT NOW() AS waktu")->row_array();

        $this->waktu_sql = $waktu_sql['waktu'];

        $this->opsi = array("a","b","c","d","e");

        $this->load->model('m_detail_mapel');

        $this->load->model('m_kelas');

        $this->load->model('m_mapel');

        $this->load->model('m_admin');

        $this->load->model('m_mapel_cs');

        $this->load->model('m_instansi');

	}

	

	public function get_servertime() {

		$now = new DateTime(); 

        $dt = $now->format("M j, Y H:i:s O"); 



        j($dt);

	}

	// @here Ikhsan -> 22-03-2020

	public function page_load($pg = 1) {

		$this->load->model('m_mapel_cs');

		$post = $this->input->post();

		$limit = $post['limit'];

		$where = [];

		switch ($this->log_lvl) {

			case 'siswa':

				if (!empty($post['search'])) {

					switch ($post['filter']) {

						case 0:

						$where["(lower(mp.nama) like '%".strtolower($post['search'])."%' )"] = null;

						break;

						# code...

						break;

					}

				}

				

				$where['kls.id_peserta'] = $this->akun->id;

				$where['kls.id_instansi'] = $this->akun->instansi;



				$paginate = $this->m_mapel_cs->paginate_siswa($pg, $where, $limit, $post);

				$data['paginate'] = $paginate;

				$data['paginate']['url']	= 'dtest/page_load';

				$data['paginate']['search'] = 'lookup_key';

				$data['page_start'] = $paginate['counts']['from_num'];



				$this->load->view('modul_pelatihan/table_siswa', $data);

				$this->generate_page($data);

			break;



			case 'guru':

				

				$where['gr.id'] = $this->log_id;

	

				if (!empty($post['search'])) {

					switch ($post['filter']) {

						case 0:

						$where["(lower(mp.nama) like '%".strtolower($post['search'])."%' )"] = null;

						break;

						# code...

						break;

					}

				}



				$where['mp.id_instansi'] = $this->akun->instansi;



				$paginate = $this->m_mapel_cs->paginate($pg, $where, $limit, $post);

				$data['paginate'] = $paginate;

				$data['paginate']['url']	= 'dtest/page_load';

				$data['paginate']['search'] = 'lookup_key';

				$data['page_start'] = $paginate['counts']['from_num'];



				$this->load->view('modul_pelatihan/table_guru', $data);

				$this->generate_page($data);

			break;



			case 'admin':

	

				if (!empty($post['search'])) {

					switch ($post['filter']) {

						case 0:

						$where["(lower(mp.nama) like '%".strtolower($post['search'])."%' )"] = null;

						break;

						# code...

						break;

					}

				}



				$paginate = $this->m_mapel->paginate($pg, $where, $limit, $post);

				$data['paginate'] = $paginate;

				$data['paginate']['url']	= 'dtest/page_load';

				$data['paginate']['search'] = 'lookup_key';

				$data['page_start'] = $paginate['counts']['from_num'];



				$this->load->view('modul_pelatihan/table', $data);

				$this->generate_page($data);

			break;



			case 'instansi':

	

				if (!empty($post['search'])) {

					switch ($post['filter']) {

						case 0:

						$where["(lower(nama) like '%".strtolower($post['search'])."%' )"] = null;

						break;

						# code...

						break;

					}

				}



				$where['id_instansi'] = $this->akun->instansi;





				$paginate = $this->m_mapel->paginate($pg, $where, $limit, $post);

				$data['paginate'] = $paginate;

				$data['paginate']['url']	= 'dtest/page_load';

				$data['paginate']['search'] = 'lookup_key';

				$data['page_start'] = $paginate['counts']['from_num'];



				$this->load->view('modul_pelatihan/table', $data);

				$this->generate_page($data);

			break;
			
			case 'admin_instansi':

	

				if (!empty($post['search'])) {

					switch ($post['filter']) {

						case 0:

						$where["(lower(nama) like '%".strtolower($post['search'])."%' )"] = null;

						break;

						# code...

						break;

					}

				}



				$where['id_instansi'] = $this->akun->instansi;





				$paginate = $this->m_mapel->paginate($pg, $where, $limit, $post);

				$data['paginate'] = $paginate;

				$data['paginate']['url']	= 'dtest/page_load';

				$data['paginate']['search'] = 'lookup_key';

				$data['page_start'] = $paginate['counts']['from_num'];



				$this->load->view('modul_pelatihan/table', $data);

				$this->generate_page($data);

			break;





			

			default:

				

			break;

		}

	}



	// @here Ikhsan -> 22-03-2020 

	public function data_mapel() {

		$this->cek_aktif();

		$data = [

			'searchFilter' => ['Mata Pelajaran'],

			'instansi' => ($this->log_lvl == 'admin') ? $this->m_instansi->get_all() : $this->m_instansi->get_many_by(['id'=>$this->akun->instansi]) 
		];

		$this->render('modul_pelatihan/list', $data);

	}



	public function m_mapel() {

		$this->cek_aktif();

		// cek_hakakses(array("admin"), $this->session->userdata('admin_level'));

		

			//var def uri segment

			$uri1 = $this->uri->segment(1);

			$uri2 = $this->uri->segment(2);

			$uri3 = $this->uri->segment(3);

			$uri4 = $this->uri->segment(4);



		//var def session

		$a['sess_level'] = $this->session->userdata('admin_level');

		$a['sess_user'] = $this->session->userdata('admin_user');

		$a['sess_konid'] = $this->session->userdata('admin_konid');

        $a['menu'] = $this->db->query("SELECT `nama_menu`, `link`, `icon` FROM rule_users JOIN menu ON rule_users.id_menu = menu.id JOIN level ON rule_users.id_level = level.id WHERE level = '".$a['sess_level']."' ")->result_array();

		$a['link'] = $this->db->query("SELECT link FROM rule_users JOIN menu ON rule_users.id_menu = menu.id JOIN level ON rule_users.id_level = level.id WHERE link = '".$uri1."/".$uri2."' AND level = '".$a['sess_level']."' ")->result_array();

		// $check =$this->db->query("SELECT * FROM tr_mapel_notif")->row_array();

		// var_dump($check);

		// die;

		//var post from json

		$p = json_decode(file_get_contents('php://input'));



		//return as json

		$jeson = array();

		$a['data'] = $this->db->query("SELECT m_mapel.* FROM m_mapel")->result();

		if ($uri3 == "det") {

			$a = $this->db->query("SELECT * FROM m_mapel WHERE id = '$uri4'")->row();

			j($a);

			exit();

		} else if ($uri3 == "simpan") {

			$ket 	= "";

			if ($p->id != 0) {



				$data = [

					'kd_mp' => $p->kd_mp,
					'nama' => $p->nama,
				    'id_instansi' => $p->instansi,
				];

				$this->m_mapel->update($data,array('id'=>bersih($p,"id")));

				$ket = "edit";

			} else {

				$ket = "tambah";

				// $this->db->query("INSERT INTO m_mapel VALUES ('".bersih($p,"nama")."'");

				$data = [

					'kd_mp' => $p->kd_mp,
					'nama' => $p->nama,
				    'id_instansi' => $p->instansi,
				];

				

				$this->db->insert('m_mapel', $data);

			}

			

			$ret_arr['status'] 	= "ok";

			$ret_arr['caption']	= $ket." sukses";

			$ret_arr['wdw'] = $p;

			j($ret_arr);

			exit();

		}else if($uri3 == "chats"){

			$chat = $this->db->query("SELECT id, pengirim, level, id_mapel, chat, 

									DATE_FORMAT(waktu, '%d %M %Y - %k:%i') AS wkt

			 						FROM tr_mapel_chat WHERE id_mapel = '".$uri4."' 

									ORDER BY id ASC ")->result();

			$online = $this->db->query("SELECT a.level, b.nama, a.kon_id, a.username as email FROM

										m_admin AS a JOIN m_siswa AS b ON a.kon_id = b.id WHERE 

										status = 1 AND level = 'siswa' UNION 

										SELECT a.level, b.nama, a.kon_id, a.username as email FROM m_admin 

										AS a JOIN m_guru AS b ON a.kon_id = b.id WHERE 

										status = 1 AND level = 'guru'")->result();

			$judul = $this->db->query("SELECT id, nama FROM m_mapel WHERE id = '".$uri4."' ")->result();

			$nama = $this->db->query("SELECT nama FROM m_guru WHERE id = '".$a['sess_konid']."' UNION

									SELECT nama FROM m_siswa WHERE id = '".$a['sess_konid']."' ")->result();

			$scroll = $this->db->query("SELECT pengirim AS scrol FROM tr_mapel_chat WHERE id_mapel = '".$uri4."'

										 ORDER BY id DESC LIMIT 1 ")->result();

			$notif = $this->db->query("SELECT SUM(b.notif) as notif FROM m_mapel a JOIN tr_mapel_notif b ON a.id = b.id_mapel 

										AND b.id_user = '".$a['sess_konid']."'")->result();

			j([	'chat' => $chat,

				'online' => $online,

				'judul' => $judul,

				'nama'	=> $nama,

				'scrol'	=> $scroll,

				'notif' => $notif]);

			exit();

			

		}else if($uri3 == "clear"){

			$check =$this->db->query("SELECT * FROM tr_mapel_notif WHERE id_mapel = '".$uri4."' AND id_user =  '".$a['sess_konid']."' ")->row_array();

			if(!empty($check)){

			$chat = array(

				'notif' => 0

			);

			$this->db->where('id', $check['id']);

			$this->db->UPDATE('tr_mapel_notif', $chat);

		}else{

			$chat = array(

				'id_mapel' => $uri4,

				'id_user' => $this->session->userdata('admin_konid'),

				'notif' => 1

			);

			$this->db->insert('tr_mapel_notif', $chat);

		}



			$ret_arr['status'] 	= "ok";

			$ret_arr['caption']	= " sukses";

			j($ret_arr);

			exit();

		}

		else if($uri3 == "simpan1"){

			

			$check =$this->db->query("SELECT * FROM tr_mapel_notif WHERE id_mapel = $p->id AND id_user =  '".$a['sess_konid']."' ")->row_array();

			if($this->session->userdata('admin_level') == "guru"){

				$data = array(

					'pengirim' => $this->session->userdata('admin_nama'),

					'level' => 'trainer',

					'id_mapel' => $p->id,

					'chat' => $p->message

				);

				$this->db->insert('tr_mapel_chat', $data);







				if($check['id_user'] == $this->session->userdata('admin_konid') && $p->id == $check['id_mapel']){

					$chat = array(

						

						'notif' => $check['notif']+1

					);

					

					$this->db->UPDATE('tr_mapel_notif', $chat);

				}else if(!$check['id_user'] && !$check['id_mapel']){

				$chat = array(

					'id_mapel' => $p->id,

					'id_user' => $this->session->userdata('admin_konid'),

					'notif' => 1

				);

				$this->db->insert('tr_mapel_notif', $chat);

				}









			}else if($this->session->userdata('admin_level') == "siswa"){

				$data = array(

					'pengirim' => $this->session->userdata('admin_nama'),

					'level' => 'peserta',

					'id_mapel' => $p->id,

					'chat' => $p->message

				);

				$this->db->insert('tr_mapel_chat', $data);







				

				if($check['id_user'] == $this->session->userdata('admin_konid') && $p->id == $check['id_mapel']){

					$chat = array(

						

						'notif' => $check['notif']+1

					);

					

					$this->db->UPDATE('tr_mapel_notif', $chat);

				}else if(!$check['id_user'] && !$check['id_mapel']){

				$chat = array(

					'id_mapel' => $p->id,

					'id_user' => $this->session->userdata('admin_konid'),

					'notif' => 1

				);

				$this->db->insert('tr_mapel_notif', $chat);

				}





			}

			

			$ret_arr['status'] 	= "ok";

			$ret_arr['caption']	= " sukses";

			j($ret_arr);

			exit();

			



		} else if ($uri3 == "hapus") {

		  

		  $this->db->where('id', $this->input->post('id'));

		  $modul = $this->db->get('m_mapel')->row();

		  if($modul->silabus == 1) {

		      unlink($modul->path_silabus);

		  }

		    

		  if($this->input->post('modul') != NULL) {

		      $this->db->where('id_mapel', $this->input->post('id'));

		      $update = $this->db->update('m_materi', ['id_mapel' => $this->input->post('modul')]);

		      if($update) {

		        $this->db->query("DELETE FROM m_mapel WHERE id = '".$this->input->post('id')."'");

        	     $ret_arr['status'] 	= "ok";

        	     $ret_arr['caption']	= "hapus sukses";

        		 j($ret_arr);

        		 exit();

		      }

		  }  

		  else {

		      

		      $this->db->where('id_mapel', $this->input->post('id'));

		      $materis = $this->db->get('m_materi');

    		  if($materis->num_rows() > 0) {

    		     foreach($materis as $materi){

    		       if($materi->pdf == 1) {

    		          unlink($materi->content);

    		       }

    		     }

    		  }

    		  $this->db->where('id_mapel', $this->input->post('id'));

    		  $del_submodul = $this->db->delete('m_materi');

    		  if($del_submodul) {

    		     $this->db->query("DELETE FROM m_mapel WHERE id = '".$this->input->post('id')."'");

        	     $ret_arr['status'] 	= "ok";

        	     $ret_arr['caption']	= "hapus sukses";

        		 j($ret_arr);

        		 exit();

    		  }

		  }

		  //  $this->db->where('id_mapel', $uri4);

		  //  $materis = $this->db->get('m_materi');

		  //  if($materis->num_rows() > 0) {

		  //      foreach($materis as $materi){

		  //          if($materi->pdf == 1) {

		  //              unlink($materi->content);

		  //          }

		  //      }

		  //  }

		  //  $this->db->where('id_mapel', $uri4);

		  //  $del_submodul = $this->db->delete('m_materi');

		  //  if($del_submodul) {

			 //   $this->db->query("DELETE FROM m_mapel WHERE id = '".$uri4."'");

    // 			$ret_arr['status'] 	= "ok";

    // 			$ret_arr['caption']	= "hapus sukses";

    // 			j($ret_arr);

    // 			exit();

		  //  }

		} else if ($uri3 == "data") {

			$start = $this->input->post('start');

	        $length = $this->input->post('length');

	        $draw = $this->input->post('draw');

	        $search = $this->input->post('search');

	        

	        if($this->log_lvl == 'siswa'){

	        	if (isset($this->akun->instansi)) {

	  

	        		$where = array(

	        			'kls.id_instansi' => $this->akun->instansi,

	        			'kls.id_peserta' => $this->akun->id,

	        			"mp.nama LIKE '%".$search['value']."%'  " => NULL

	        		);

	        		$q_datanya = $this->db->select('mp.*,kls.id_instansi,gr.nama as nama_guru')

	        							  ->from('m_mapel mp')

	        							  ->join('tb_kelas kls',' kls.id_mapel = mp.id','left')

	        							  ->join('m_guru gr','gr.id = kls.id_trainer','left')

	        							  ->where($where)

	        							  ->get()

	        							  ->result_array();

		

	        		$d_total_row = count($q_datanya);



	        		$q_datanya1 = $this->db->query("SELECT SUM(b.notif) as notif FROM m_mapel a JOIN tr_mapel_notif b ON a.id =  b.id_mapel AND b.id_user = '".$a['sess_konid']."' ")->result_array();

	        	}else{

	        		$q_datanya = array();

	        		$d_total_row = 0;

	        	}



	        }elseif($this->log_lvl == 'guru'){

	        	$q_datanya = $this->db->query("SELECT mp.* FROM m_mapel mp LEFT JOIN tr_guru_mapel grm ON grm.id_mapel = mp.id WHERE grm.id_guru = ".$this->akun->id." AND mp.nama LIKE '%".$search['value']."%'  ")->result_array();

	        	$where = array(

	        			'grm.id_guru' => $this->akun->id,

	        			"mp.nama LIKE '%".$search['value']."%'  " => NULL

	        		);

	        	$q_datanya = $this->db->select('mp.*,

													gr.nama as nama_guru

												')

	        							  ->from('m_mapel mp')

	        							  ->join('tr_guru_mapel grm','grm.id_mapel = mp.id','left')

	        							  ->join('m_guru gr','gr.id = grm.id_guru','left')

	        							  ->where($where)

	        							  ->get()

	        							  ->result_array();





	        	$d_total_row = count($q_datanya);



	        	$q_datanya1 = $this->db->query("SELECT SUM(b.notif) as notif FROM m_mapel a JOIN tr_mapel_notif b ON a.id =  b.id_mapel AND b.id_user = '".$a['sess_konid']."' ")->result_array();	



	        }else{

	        	$where = array(

        			"mp.nama LIKE '%".$search['value']."%'  " => NULL

        		);

	        	$q_datanya = $this->db->select('mp.*, gr.nama as nama_guru')

	        						  ->from('m_mapel mp')

	        						  ->join('tr_guru_mapel grm','grm.id_mapel = mp.id','left')

	        						  ->join('m_guru gr','gr.id = grm.id_guru','left')

	        						  ->where($where)

	        						  ->get()

	        						  ->result_array();

	        	$d_total_row = count($q_datanya);



	        	$q_datanya1 = $this->db->query("SELECT SUM(b.notif) as notif FROM m_mapel a JOIN tr_mapel_notif b ON a.id =  b.id_mapel AND b.id_user = '".$a['sess_konid']."' ")->result_array();	

	        }



	        $data = array();

	        $no = ($start+1);

	        foreach ($q_datanya as $d) {



	        	foreach ($q_datanya1 as $c) {	        			



	       			$data_ok = array();

	    			$data_ok[0] = $no++;

	    			$data_ok[1] =  $d['nama'];

	    			$data_ok[2] =  $d['nama_guru'];



					if($this->session->userdata('admin_level') == 'admin') {

						$data_ok[3] = '<div class="btn-group mx-auto d-flex justify-content-center">

						<a class="btn btn-primary btn-sm mr-2" data-mapel="'.$d['id'].'" href="#" data-href="'.base_url('Materi/lists/').'/'.md5($d['id']).'" onclick="saveSess(this)" ><i class="glyphicon glyphicon-eye" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Lihat</a>

						<a href="#" onclick="return m_mapel_e('.$d['id'].');" class="btn btn-info btn-sm mr-2"><i class="glyphicon glyphicon-pencil" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Edit</a>

						<a href="#" onclick="return m_mapel_h('.$d['id'].');" class="btn btn-danger btn-sm mr-2"><i class="glyphicon glyphicon-remove" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Hapus</a>

						';

					} 

					else if($this->session->userdata('admin_level') == 'guru') {

						$data_ok[3] = '<div class="btn-group d-flex justify-content-center">

						<a class="btn btn-success btn-sm mr-2" href="#" data-href="'.base_url('Materi/lists/').'/'.md5($d['id']).'" onclick="saveSess(this)" href="#" data-href="'.base_url('Materi/lists/').'/'.md5($d['id']).'" data-mapel="'.$d['id'].'"><i class="glyphicon glyphicon-eye" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Materi</a>';

					}

					else if($this->session->userdata('admin_level') == 'siswa') {

						$data_ok[3] = '<div class="btn-group d-flex justify-content-center">

						<a class="btn btn-success btn-sm hit-btn mr-2" href="#" onclick="hit(this)" href="#" data-href="'.base_url('Materi/lists/').'/'.md5($d['id']).'" data-mapel="'.$d['id'].'"><i class="glyphicon glyphicon-eye" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Materi</a>

						<a class="btn btn-danger btn-sm  mr-2" href="#" onclick="hit(this)" href="#" data-href="'.base_url('ujian/ikuti_ujian').'/'.md5($d['id']).'" data-mapel="'.$d['id'].'"><i class="glyphicon glyphicon-eye" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Tes</a>



						';

					}

				

					$data[] = $data_ok;

			}

	}



	        $json_data = array(

	                    "draw" => $draw,

	                    "iTotalRecords" => $d_total_row,

	                    "iTotalDisplayRecords" => $d_total_row,

	                    "data" => $data

	                );

	        j($json_data);

	        exit;

		} else {

			$a['p']	= "m_mapel";

		}

		if($a['sess_level'] == 'admin'){

			cek_hakakses(array("admin"), $this->session->userdata('admin_level'));

			$this->load->view('dashboard/template/header', $a);

			$this->load->view('dashboard/template/navbar', $a);

			$this->load->view('dashboard/admin/datamateri', $a);

			$this->load->view('dashboard/template/footer', $a);

		}else if($a['sess_level'] == 'guru'){

			cek_hakakses(array("guru"), $this->session->userdata('admin_level'));

			$this->load->view('dashboard/template/header', $a);

			$this->load->view('dashboard/template/navbar', $a);

			$this->load->view('dashboard/trainer/inputmateri', $a);

			$this->load->view('dashboard/template/footer', $a);

		}else{

			cek_hakakses(array("siswa"), $this->session->userdata('admin_level'));

			$this->load->view('dashboard/template/header', $a);

			$this->load->view('dashboard/user/kerangka_script', $a);

			$this->load->view('dashboard/template/navbar', $a);

			$this->load->view('dashboard/user/kerangka', $a);

			$this->load->view('dashboard/template/footer', $a);

		}

	

	}



	public function chats(){

		$this->cek_aktif();

		// cek_hakakses(array("admin"), $this->session->userdata('admin_level'));



			//var def uri segment

			$uri1 = $this->uri->segment(1);

			$uri2 = $this->uri->segment(2);

			$uri3 = $this->uri->segment(3);

			$uri4 = $this->uri->segment(4);



		//var def session

		$a['sess_level'] = $this->session->userdata('admin_level');

		$a['sess_user'] = $this->session->userdata('admin_user');

		$a['sess_konid'] = $this->session->userdata('admin_konid');

        $a['menu'] = $this->db->query("SELECT `nama_menu`, `link`, `link4`,`icon` FROM rule_users JOIN menu ON rule_users.id_menu = menu.id JOIN level ON rule_users.id_level = level.id WHERE level = '".$a['sess_level']."' ")->result_array();

		$a['link'] = $this->db->query("SELECT link4 FROM rule_users JOIN menu ON rule_users.id_menu = menu.id JOIN level ON rule_users.id_level = level.id WHERE link4 = '".$uri1."/".$uri2."' AND level = '".$a['sess_level']."' ")->result_array();

		

		$a['p']	= "chats";

		$this->load->view('chat/header', $a);

		$this->load->view('chat/navbar', $a);

		$this->load->view('chat/index', $a);

		$this->load->view('chat/footer', $a);



	}





    

    public function get_akhir($tabel, $field, $kode_awal, $pad) {

		$get_akhir	= $this->db->query("SELECT MAX($field) AS max FROM $tabel LIMIT 1")->row();

		$data		= (intval($get_akhir->max)) + 1;

		$last		= $kode_awal.str_pad($data, $pad, '0', STR_PAD_LEFT);

	

		return $last;

	}



	public function get_trainer_info(){

		$post = $this->input->post();



		$data = array(

			'trainer' => $this->m_detail_mapel->get_all(array('dmapel.id_mapel'=>$post['id'])), 

		);



		echo json_encode($data);

	}

}

