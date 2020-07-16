<?php

 defined('BASEPATH') OR exit('No direct script access allowed');



class Ujian_real extends MY_Controller {



    function __construct() {

        parent::__construct();

        $this->load->model('m_ujian');

        $this->load->model('m_instansi');

        $this->load->model('m_mapel_cs');

        $this->load->model('m_guru');

        $this->load->model('m_soal_ujian');
        $this->load->model('m_soal_ujian_essay');

		$this->load->model('m_ikut_ujian');
		$this->load->model('m_ikut_ujian_essay');
		$this->load->model('m_jurusan');
		

		$this->load->model('m_kelas');

		

        $this->opsi = array("a","b","c","d","e");

	}



	public function index(){

		$data = array(

			'searchFilter' => array('Kelas', 'Nama Ujian'),

			'tipe_ujian'   => $tipe_ujian = array(''=>'Semua','uts'=>'UTS','uas'=>'UAS', 'harian' => 'Ulangan Harian')

		);

		$this->render('ujian/list',$data);

	}
	public function data_soal($id_ujian=null){



		$url = base_url('ujian_real/form_soal/'.$id_ujian);



		$data = array(

			'searchFilter' => array('Mata Pelajaran','Guru'),

			'tipe_ujian'   => $tipe_ujian = array(''=>'Semua','uts'=>'UTS','uas'=>'UAS', 'harian' => 'Ulangan Harian'),

			'url_form' => $url,

			'url_import' => base_url('ujian_real/form_import/'.$id_ujian),

			'ujian' => $this->m_ujian->get_by(['uji.id'=>decrypt_url($id_ujian)])

		);
		// print_r($this->m_ujian->get_by(['uji.id'=>decrypt_url($id_ujian)]));exit;

		$this->render('ujian/list_soal',$data);

	}



	public function add(){



		$tipe_ujian = array('uts'=>'UTS','uas'=>'UAS', 'harian' => 'Ulangan Harian');

		if($this->log_lvl == 'admin' || $this->log_lvl == 'instansi' || $this->log_lvl == 'admin_instansi') {
			$kelas = $this->m_kelas->get_many_by(['kls.id_instansi'=>$this->akun->instansi]);
		}
		else if($this->log_lvl == 'guru') {
			$kelas = $this->m_kelas->get_many_by(['kls.id_instansi'=>$this->akun->instansi]);
		}
		
		
		// print_r($kelas);exit;

		$data = array(

			'tipe_ujian' => $tipe_ujian, 

			'kelas' => $kelas

		);



		$this->render('ujian/add',$data);

	}



	public function edit($id=0){



		$tipe_ujian = array('uts'=>'UTS','uas'=>'UAS', 'harian' => 'Ulangan Harian');



		// if ($this->log_lvl == 'guru') {

		// 	$kelas = $this->m_kelas->get_many_by(['id_trainer'=>$this->akun->id,'kls.id_instansi'=>$this->akun->instansi]);

		// } else if ($this->log_lvl == 'instansi' || $this->log_lvl == 'admin_instansi'){

		// 	$kelas = $this->m_kelas->get_many_by(['kls.id_instansi'=>$this->akun->instansi]);

		// } else {

		// 	$kelas = $this->m_kelas->get_all();

		// }
		if($this->log_lvl == 'admin' || $this->log_lvl == 'instansi' || $this->log_lvl == 'admin_instansi') {
			$kelas = $this->m_kelas->get_all(['kls.id_instansi' => $this->akun->instansi]);
		}
		else if($this->log_lvl == 'guru') {
			$kelas = $this->m_kelas->get_data_mapel(['kls.id_instansi' => $this->akun->instansi, 'dkmapel.id_guru' => $this->akun->id]);

		}
		// print_r($mapel);exit;

		$id = decrypt_url($id);

		$data = array(

			'tipe_ujian' => $tipe_ujian, 

			'kelas' => $kelas,

			'edit' => $this->m_ujian->get_by(['uji.id'=>$id])

		);
		

		$this->render('ujian/edit',$data);

	}



	public function form_import($id_ujian){



		$data = array(

			'back_url' => base_url('ujian_real/data_soal/'.$id_ujian.''),

			'url_import' => base_url('import/ujian/'.$id_ujian.''),

		);



		$this->render('ujian/form_import',$data);

	}



	public function get_mp(){

		$post = $this->input->post();



		$select = '<option disabled="disabled" selected="selected">Pilih</option>';

		$mp = $this->m_mapel->get_many_by(array('id_instansi'=>$post['id_instansi']));

		$post['id_mp'] = empty($post['id_mp']) ? NULL : $post['id_mp'];



		foreach ($mp as $key => $rows) {

			if ($post['id_mp'] == $rows->id) {

				$select .= '<option value="'.$rows->id.'" selected="selected">'.$rows->nama.'</option>';

			}else{

				$select .= '<option value="'.$rows->id.'">'.$rows->nama.'</option>';

			}

		}



		echo json_encode(['data'=>$select]);

	}



	public function get_trainer(){

		$post = $this->input->post();



		$select = '<option disabled="disabled" selected="selected">Pilih</option>';

		$trainer = $this->m_mapel_cs->get_many_by(array('mp.id'=>$post['id_mp']));

		$post['id_trainer'] = empty($post['id_trainer']) ? NULL : $post['id_trainer'];



		foreach ($trainer as $key => $rows) {

			if ($post['id_trainer'] == $rows->id) {

				$select .= '<option value="'.$rows->guru_id.'" selected="selected">'.$rows->nama_guru.'</option>';

			}else{

				$select .= '<option value="'.$rows->guru_id.'">'.$rows->nama_guru.'</option>';

			}

		}



		echo json_encode(['data'=>$select]);

	}



	public function insert(){

		$post = $this->input->post();
		$mapel = explode('-',$post['id_mapel']);
		$data = [

			'id_kelas'		=> $post['id_kelas'],
			'id_guru'		=> $mapel[1],
			'id_mapel'		=> $mapel[0],
			'type_ujian'  	=> $post['type_ujian'],
			'nama_ujian'  	=> $post['nama_ujian'],
			'jumlah_soal'  	=> 0,
			'waktu'  		=> $post['waktu_ujian'],
			'nama_ujian'  	=> $post['nama_ujian'],
			'jenis'  		=> 'set',
			'tgl_mulai'		=> date_default($post['tgl_mulai']).' '.$post['waktu_mulai'],
			'terlambat'		=> date_default($post['tgl_selesai']).' '.$post['waktu_selesai'],
			'min_nilai'		=> $post['min_nilai'],
			'izin'			=> 1

		];
		$data['id_instansi'] = $this->akun->instansi;
		if($post['type_ujian'] == 'uts') {
			$data['izin'] = 1;
		}
		if ($this->log_lvl == 'guru') {

			$data['id_guru'] = $this->akun->id;

		}



		$kirim = $this->m_ujian->insert($data);

		if ($kirim) {

			$json['status']  = 1;

			$json['message'] = 'Tambah ujian berhasil';

		}else{

			$json['status']  = 1;

			$json['message'] = 'Tambah ujian gagal';

		}



		echo json_encode($json);

	}



	public function update(){

		$post = $this->input->post();


		$mapel = explode('-',$post['id_mapel']);
		$data = [

			'id_kelas'		=> $post['id_kelas'],

			'id_guru'		=> $mapel[1],
			'id_mapel'		=> $mapel[0],

			'type_ujian'  	=> $post['type_ujian'],

			'nama_ujian'  	=> $post['nama_ujian'],

			'jumlah_soal'  	=> 0,

			'waktu'  		=> $post['waktu_ujian'],

			'nama_ujian'  	=> $post['nama_ujian'],

			'jenis'  		=> 'set',

			'tgl_mulai'		=> date_default($post['tgl_mulai']).' '.$post['waktu_mulai'],

			'terlambat'		=> date_default($post['tgl_selesai']).' '.$post['waktu_selesai'],

			'min_nilai'		=> $post['min_nilai'],

			'izin'			=> 1

		];

		if($post['type_ujian'] == 'uts') {
			$data['izin'] = 1;
		}

		if ($this->log_lvl == 'guru') {

			$data['id_guru'] = $this->akun->id;

		}



		$kirim = $this->m_ujian->update($data,array('id'=>$post['id']));

		if ($kirim) {

			$json['status']  = 1;

			$json['message'] = 'Edit ujian berhasil';

		}else{

			$json['status']  = 1;

			$json['message'] = 'Edit ujian gagal';

		}



		echo json_encode($json);

	}



	public function page_load($pg = 1){

		$post = $this->input->post();

		$limit = $post['limit'];

		$where = [];

		if (!empty($post['search'])) {

			switch ($post['filter']) {

				case 0:

					$where["(lower(kls.nama) like '%".strtolower($post['search'])."%' )"] = null;

					break;

				case 1:

					$where["(lower(uji.nama_ujian) like '%".strtolower($post['search'])."%' )"] = null;

					break;

				default:

					# code...

					break;

			}

		}



		if (!empty($post['tipe_ujian'])) {

			$where['uji.type_ujian'] = $post['tipe_ujian_real'];

		}


		$where['uji.id_instansi'] = $this->akun->instansi;



		if ($this->log_lvl == 'guru') {

			$where['uji.id_guru'] = $this->akun->id;

		}

		

		if ($this->log_lvl == 'siswa') {

			$where['sis.id'] = $this->session->admin_konid;	

			$paginate = $this->m_ujian->paginate_siswa($pg,$where,$limit);

		}else{

		    $paginate = $this->m_ujian->paginate($pg,$where,$limit);

		}


		// print_r($paginate);exit;
	

		$data['paginate'] = $paginate;

		$data['paginate']['url']	= 'ujian_real/page_load';

		$data['paginate']['search'] = 'lookup_key';

		$data['page_start'] = $paginate['counts']['from_num'];



		$this->load->view('ujian/table',$data);

		$this->generate_page($data);

	}



	public function page_load_soal($pg = 1){

		$post = $this->input->post();

		$limit = $post['limit'];

		$where = [];

		if (!empty($post['search'])) {

			switch ($post['filter']) {

				case 0:

					$where["(lower(mp.nama) like '%".strtolower($post['search'])."%' )"] = null;

					break;

				case 1:

					$where["(lower(gr.nama) like '%".strtolower($post['search'])."%' )"] = null;

					break;

				default:

					# code...

					break;

			}

		}



		if (!empty($post['tipe_ujian'])) {

			$where['type_ujian'] = $post['tipe_ujian'];

		}



		$where['id_ujian'] = $post['id_ujian'];



		$paginate = $this->m_soal_ujian->paginate($pg,$where,$limit);

		$data['paginate'] = $paginate;

		$data['paginate']['url']	= 'ujian_real/page_load_soal';

		$data['paginate']['search'] = 'lookup_key';

		$data['page_start'] = $paginate['counts']['from_num'];



		$this->load->view('ujian/table_soal',$data);

		$this->generate_page($data);

	}



	public function page_load_result($pg = 1){

		$post = $this->input->post();

		$limit = $post['limit'];

		$where = [];

		if (!empty($post['search'])) {

			switch ($post['filter']) {

				case 0:

					$where["(lower(mp.nama) like '%".strtolower($post['search'])."%' )"] = null;

					break;

				case 1:

					$where["(lower(gr.nama) like '%".strtolower($post['search'])."%' )"] = null;

					break;

				default:

					# code...

					break;

			}

		}



		

		$where['id_ujian'] = $post['id_ujian'];

		$where['status'] = 'N';

		$paginate = $this->m_ikut_ujian->paginate($pg,$where,$limit);

		$data['paginate'] = $paginate;

		$data['paginate']['url']	= 'ujian_real/page_load_result';

		$data['paginate']['search'] = 'lookup_key';

		$data['page_start'] = $paginate['counts']['from_num'];

		$data['id_ujian'] = $post['id_ujian'];



		$this->load->view('ujian/table_hasil',$data);

		$this->generate_page($data);

	}



	public function form_soal($id_ujian,$id_soal=0) {



		cek_hakakses(array("admin", "guru",'instansi'), $this->session->userdata('admin_level'));

		

		$a['huruf_opsi'] = array("a","b","c","d","e");

		$a['jml_opsi'] = $this->config->item('jml_opsi');
		// print_r($this->config);exit;


		$a['opsij'] = array(""=>"Jawaban","A"=>"A","B"=>"B","C"=>"C","D"=>"D","E"=>"E");



		$id_guru = $this->log_lvl == "guru" ? "WHERE a.id_guru = '".$this->log_id."'" : "";



		if ($id_soal == 0) {

			$a['d'] = array("mode"=>"add","id"=>"0","id_guru"=>$id_guru,"id_mapel"=>"","bobot"=>"1","file"=>"","soal"=>"","opsi_a"=>"#####","opsi_b"=>"#####","opsi_c"=>"#####","opsi_d"=>"#####","opsi_e"=>"#####","jawaban"=>"","tgl_input"=>"");

		}else {

			$a['d'] = $this->db->select("ujian.*, 'edit' AS mode")->where('id',$id_soal)->get('m_soal_ujian ujian')->row_array();

		}



		



		$data = array();



		for ($e = 0; $e < $a['jml_opsi']; $e++) {

			$iidata = array();

			$idx = "opsi_".$a['huruf_opsi'][$e];

			$idx2 = $a['huruf_opsi'][$e];



			$pc_opsi_edit = explode("#####", $a['d'][$idx]);

			$iidata['opsi'] = $pc_opsi_edit[1];

			$iidata['gambar'] = $pc_opsi_edit[0];

			$data[$idx2] = $iidata;

		}

		

		$a['id_ujian'] = decrypt_url($id_ujian);
		$a['data_pc'] = $data;

		// Check Bobot Soal
		$this->load->model('m_setting_instansi');
		$a['bobot'] = $this->m_setting_instansi->get_by(['id_instansi' => $this->akun->instansi]);
		// print_r($a['bobot']);exit;


		$this->render('ujian/add_soal',$a);

	}

	// Method untuk menyimpan soal di add soal dan edit soal
	function simpan_soal(){



			$p = $this->input->post();

			$pembuat_soal = ($this->log_lvl == "admin") ? $p['id_guru'] : $this->log_id;

			$pembuat_soal_u = ($this->log_lvl == "admin") ? ", id_guru = '".$p['id_guru']."'" : "";

			//etok2nya config

			$folder_gb_soal = "./upload/file_ujian_soal/";

			$folder_gb_opsi = "./upload/file_ujian_opsi/";



			$buat_folder_gb_soal = !is_dir($folder_gb_soal) ? @mkdir("./upload/file_ujian_soal/") : false;

			$buat_folder_gb_opsi = !is_dir($folder_gb_opsi) ? @mkdir("./upload/file_ujian_opsi/") : false;



			$allowed_type 	= array("image/jpeg", "image/png", "image/gif", 

			"audio/mpeg", "audio/mpg", "audio/mpeg3", "audio/mp3", "audio/x-wav", "audio/wave", "audio/wav",

			"video/mp4", "application/octet-stream");



			$gagal 		= array();

			$nama_file 	= array();

			$tipe_file 	= array();



			//get mode

			$__mode = $p['mode'];

			$__id_soal = 0;

			//ambil data post sementara


			// Insert Data Soal : Bobot, Soalnya, Jawaban, sama Id Ujian
			$pdata = array(


				"soal"=>$p['soal'],

				"jawaban"=>$p['jawaban'],

				'id_ujian' => $p['id_ujian']

			);

			if($p['bobot'] != NULL) {
				$pdata['bobot'] = $p['bobot'];
			}



			if ($__mode == "edit") {

				$this->db->where("id", $p['id']);

				$this->db->update("m_soal_ujian", $pdata);

				$__id_soal = $p['id'];

			} else {

				$this->db->insert("m_soal_ujian", $pdata);

				$get_id_akhir = $this->db->query("SELECT MAX(id) maks FROM m_soal_ujian LIMIT 1")->row_array();

				$__id_soal = $get_id_akhir['maks'];

			}

			



			//mulai dari sini id soal diambil dari variabel $__id



			//lakukan perulangan sejumlah file upload yang terdeteksi

			foreach ($_FILES as $k => $v) {

				//var file upload

				//$k = nama field di form

				$file_name 		= $_FILES[$k]['name'];

				$file_type		= $_FILES[$k]['type'];

				$file_tmp		= $_FILES[$k]['tmp_name'];

				$file_error		= $_FILES[$k]['error'];

				$file_size		= $_FILES[$k]['size'];

				//kode ref file upload jika error

				$kode_file_error = array("File berhasil diupload", "Ukuran file terlalu besar", "Ukuran file terlalu besar", "File upload error", "Tidak ada file yang diupload", "File upload error");

				

				//jika file error = 0 / tidak ada, tipe file ada di file yang diperbolehkan, dan nama file != kosong

				//echo $file_error."<br>".$file_type;

				//exit;

				//echo var_dump($file_error == 0 || in_array($file_type, $allowed_type) || $file_name != "");

				//exit;

				if ($file_error != 0) {

					$gagal[$k] = $kode_file_error[$file_error];

					$nama_file[$k]	= "";

					$tipe_file[$k]	= "";

				} else if (!in_array($file_type, $allowed_type)) {

					$gagal[$k] = "Tipe file ini tidak diperbolehkan..";

					$nama_file[$k]	= "";

					$tipe_file[$k]	= "";

				} else if ($file_name == "") {

					$gagal[$k] = "Tidak ada file yang diupload";

					$nama_file[$k]	= "";

					$tipe_file[$k]	= "";					

				} else {

					$ekstensi = explode(".", $file_name);



					$file_name = $k."_".$__id_soal.".".$ekstensi[1];



					if ($k == "file_ujian_soal") {

						@move_uploaded_file($file_tmp, $folder_gb_soal.$file_name);

					} else {

						@move_uploaded_file($file_tmp, $folder_gb_opsi.$file_name);

					}



					$gagal[$k]	 	= $kode_file_error[$file_error]; //kode kegagalan upload file

					$nama_file[$k]	= $file_name; //ambil nama file

					$tipe_file[$k]	= $file_type; //ambil tipe file

				}

			}





			//ambil data awal

			$get_opsi_awal = $this->db->query("SELECT opsi_a, opsi_b, opsi_c, opsi_d, opsi_e FROM m_soal_ujian WHERE id = '".$__id_soal."'")->row_array();



			$data_simpan = array();



			if (!empty($nama_file['file_ujian_soal'])) {

				$data_simpan = array(

								"file"=>$nama_file['file_ujian_soal'],

								"tipe_file"=>$tipe_file['file_ujian_soal'],

								);

			}



			
			// Masukan data opsinya a, b, ... e ke data soal yang tadi sudah di insert
			$a['huruf_opsi'] = array("a","b","c","d","e");

			$a['jml_opsi'] = $this->config->item('jml_opsi');

			for ($t = 0; $t < $a['jml_opsi']; $t++) {
				$idx 	= "opsi_".$a['huruf_opsi'][$t];

				$idx2 	= "gj".$a['huruf_opsi'][$t];
				$pc_opsi_awal = explode("#####", $get_opsi_awal[$idx]);

				$nama_file_opsi = empty($nama_file[$idx2]) ? $pc_opsi_awal[0] : $nama_file[$idx2];
				$data_simpan[$idx] = $nama_file_opsi."#####".$p[$idx];
			}


			$this->db->where("id", $__id_soal);
			$this->db->update("m_soal_ujian", $data_simpan);

			// Update jumlah soal di tb_ujian
			$data_ujian = $this->m_ujian->get_by(['uji.id' => $p['id_ujian']]);
			$jumlah_soal = count( $this->m_soal_ujian->get_many_by(['id_ujian' => $p['id_ujian']]) );

			$this->m_ujian->update([
				'jumlah_soal' => $data_ujian->jumlah_soal + $jumlah_soal
			], ['id' => $p['id_ujian']]);

			$teks_gagal = "";

			foreach ($gagal as $k => $v) {

				$arr_nama_file_upload = array("file_ujian_soal"=>"File Soal ", "gja"=>"File opsi A ", "gjb"=>"File opsi B ", "gjc"=>"File opsi C ", "gjd"=>"File opsi D ", "gje"=>"File opsi E ");

				$teks_gagal .= $arr_nama_file_upload[$k].': '.$v.'<br>';

			}



			$this->session->set_flashdata('k', '<div class="alert alert-info">'.$teks_gagal.'</div>');

			redirect(base_url('ujian_real/data_soal/'.encrypt_url($p['id_ujian']).'/'.encrypt_url($p['id_instansi']).'/'.encrypt_url($p['id_mapel']).'/'.encrypt_url($p['id_guru']).''));

				

		}





		public function file_hapus_ujian($id=0,$no){



			$nama_gambar = $this->m_soal_ujian->get_by(array('id'=>$id));



			$pc_opsi_a = explode("#####", $nama_gambar->opsi_a);

			$pc_opsi_b = explode("#####", $nama_gambar->opsi_b);

			$pc_opsi_c = explode("#####", $nama_gambar->opsi_c);

			$pc_opsi_d = explode("#####", $nama_gambar->opsi_d);

			$pc_opsi_e = explode("#####", $nama_gambar->opsi_e);



			$num = $nama_gambar->id + $no;



			$link1 =1 + $nama_gambar->id;

			$link2 =2 + $nama_gambar->id;

			$link3 =3 + $nama_gambar->id;

			$link4 =4 + $nama_gambar->id;

			$link5 =5 + $nama_gambar->id;

			$link6 =6 + $nama_gambar->id;



			if($link1 == $num){

				unlink("./upload/file_ujian_soal/".$nama_gambar->file);

				$update['file'] = NULL;

				$update['type_file'] = NULL;

			}else if($link2 == $num){

				$pc_opsi_a = explode("#####", $nama_gambar->opsi_a);

				unlink("./upload/file_ujian_opsi/".$pc_opsi_a[0]);

				$update['opsi_a'] = "#####".$pc_opsi_a[1];

			}else if($link3 == $num){

				$pc_opsi_b = explode("#####", $nama_gambar->opsi_b);

				unlink("./upload/file_ujian_opsi/".$pc_opsi_b[0]);

				$update['opsi_b'] = "#####".$pc_opsi_b[1];

			}else if($link4 == $num){

				$pc_opsi_c = explode("#####", $nama_gambar->opsi_c);

				unlink("./upload/file_ujian_opsi/".$pc_opsi_c[0]);

				$update['opsi_c'] = "#####".$pc_opsi_c[1];

			}else if($link5 == $num){

				$pc_opsi_d = explode("#####", $nama_gambar->opsi_d);

				unlink("./upload/file_ujian_opsi/".$pc_opsi_d[0]);

				$update['opsi_d'] = "#####".$pc_opsi_d[1];

			}else if($link6 == $num){

				$pc_opsi_e = explode("#####", $nama_gambar->opsi_e);

				unlink("./upload/file_ujian_opsi/".$pc_opsi_e[0]);

				$update['opsi_e'] = "#####".$pc_opsi_e[1];

			}



			$this->m_soal_ujian->update($update,['id'=>$id]);



			exit;

		}



		public function hapus_soal(){

			$post = $this->input->post();



			foreach ($post['id'] as $key => $id) {



				$nama_gambar = $this->m_soal_ujian->get_by(array('id'=>$id));

				$data_yang_dihapus = $this->m_soal_ujian->get_by(['id' => $id]);

				$pc_opsi_a = explode("#####", $nama_gambar->opsi_a);

				$pc_opsi_b = explode("#####", $nama_gambar->opsi_b);

				$pc_opsi_c = explode("#####", $nama_gambar->opsi_c);

				$pc_opsi_d = explode("#####", $nama_gambar->opsi_d);

				$pc_opsi_e = explode("#####", $nama_gambar->opsi_e);



				$kirim = $this->m_soal_ujian->delete(array('id'=>$id));
				
				// Update Jumlah Soal

				$data_ujian = $this->m_ujian->get_by(['uji.id' => $data_yang_dihapus->id_ujian] );
	            
	            $this->m_ujian->update([
	                'jumlah_soal' => $data_ujian->jumlah_soal - 1
	            ], ['id' =>$data_yang_dihapus->id_ujian]);

				if($kirim){

					@unlink("./upload/file_ujian_soal/".$nama_gambar->file);

					@unlink("./upload/file_ujian_opsi/".$pc_opsi_a[0]);

					@unlink("./upload/file_ujian_opsi/".$pc_opsi_b[0]);

					@unlink("./upload/file_ujian_opsi/".$pc_opsi_c[0]);

					@unlink("./upload/file_ujian_opsi/".$pc_opsi_d[0]);

					@unlink("./upload/file_ujian_opsi/".$pc_opsi_e[0]);

				}

			}



			echo json_encode(['result'=>true]);

		}



		public function izinkan(){

			$post = $this->input->post();



			if ($post['izin'] == 0) {



				$data = [

					'jumlah_soal' => $post['soal'],

					'izin'		  => 1,

				];



				$title = 'Mengizinkan';



			}else{



				$data = [

					'jumlah_soal' => $post['soal'],

					'izin'		  => 0,

				];



				$title = 'Membatalkan';

			}

		

			$kirim = $this->m_ujian->update($data,['id'=>$post['id']]);

			if ($kirim) {

				$status = 1;

				$message = 'Berhasil '.$title;

			}else{

				$status = 0;

				$message = 'Gagal '.$title;

			}



			echo json_encode(['status'=>$status,'message'=>$message]);

		}



		public function ikuti_ujian($id_ujian){



			header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");

			header("Cache-Control: post-check=0, pre-check=0", false);

			header("Pragma: no-cache");



			//$id_tes = abs($id_ujian);

			/*$a['du'] = $this->db->query("SELECT a.id, a.penggunaan, a.tgl_mulai, a.terlambat, 

				a.token, a.nama_ujian, a.jumlah_soal, a.waktu,

				a.status_token, b.nama nmguru, c.nama nmmapel,

				(case

				when (now() < a.tgl_mulai) then 0

				when (now() >= a.tgl_mulai and now() <= a.terlambat) then 1

				else 2

				end) statuse

				FROM tb_ujian a 

				INNER JOIN m_guru b ON a.id_guru = b.id

				INNER JOIN m_mapel c ON a.id_mapel = c.id 

				WHERE a.id = '$id_ujian'")->row_array();*/



			$a['du'] = $this->db->select("	

										a.id, a.tgl_mulai, a.terlambat,a.izin, a.id_mapel,

										a.token, a.nama_ujian, a.jumlah_soal, a.waktu,

										a.status_token, c.nama nmmapel,

										(case

										when (now() < a.tgl_mulai) then 0

										when (now() >= a.tgl_mulai and now() <= a.terlambat) then 1

										else 2

										end) statuse

										")

								->from('tb_ujian a')

								->join('tb_kelas kls', 'kls.id = a.id_kelas', 'left')

								->join(' m_mapel c','a.id_mapel = c.id', 'left')

								->where('a.id',decrypt_url($id_ujian))

								->get()

								->row_array();
			// print_r($a['du']);exit;
			// print_r($this->m_ujian->get_by(['uji.id' => decrypt_url($id_ujian)]));exit;

			$a['dp'] = $this->m_siswa->get_by(['id' =>$this->log_id]);

			//$q_status = $this->db->query();



			if (!empty($a['du']) || !empty($a['dp'])) {


				$tgl_selesai = $a['du']['tgl_mulai'];

			    //$tgl_selesai2 = strtotime($tgl_selesai);

			    //$tgl_baru = date('F j, Y H:i:s', $tgl_selesai);



			    //$tgl_terlambat = strtotime("+".$a['du']['terlambat']." minutes", $tgl_selesai2);	

				$tgl_terlambat_baru = $a['du']['terlambat'];



				$a['tgl_mulai'] = $tgl_selesai;

				$a['terlambat'] = $tgl_terlambat_baru;



				$cek = $this->db->query("

					SELECT

					count(ujian.id) as jmlh,

					tes.*

					FROM

					tb_ikut_ujian ujian

					INNER JOIN tb_ujian tes ON tes.id = ujian.id_ujian 

					WHERE id_ujian = '".decrypt_url($id_ujian)."' AND id_user = '".$this->log_id."' AND status = 'N'

					")->row();

				
				if ($this->total_ujian <= $cek->jmlh) {

					redirect('ujian_real/');

					exit;

				}



				$this->session->set_userdata(array('selesai_ujian'=>0));

				$this->render('ujian/ikuti_ujian', $a);



			} else {

				redirect('ujian_real/result');

			}

		}



		public function ikut_ujian($id_ujian){



			$id_ujian = decrypt_url($id_ujian);



			if ($this->session->userdata('selesai_ujian') == 1) {

				$cek = $this->db->query("

					SELECT

					count(ujian.id) as jmlh,

					tes.id_mapel

					FROM

					tb_ikut_ujian ujian

					INNER JOIN tb_ujian tes ON tes.id = ujian.id_ujian 

					WHERE id_ujian = '$id_ujian' AND id_user = '".$this->akun->id."'

					")->row();



				redirect('ujian_real/ikuti_ujian/'.md5($cek->id_mapel));

				exit;

			}

			

			header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");

			header("Cache-Control: post-check=0, pre-check=0", false);

			header("Pragma: no-cache");

			

	

			$cek_sdh_selesai = $this->m_ikut_ujian->count_by(['id_ujian'=>$id_ujian,'id_user'=>$this->akun->id,'status'=>'N']);



			// print_r($this->total_ujian);exit;

			// Jika Belum ujian

			if ($cek_sdh_selesai <= $this->total_ujian) {

				//ini jika ujian belum tercatat, belum ikut

				$cek_detil_tes = $this->m_ujian->get_by(['uji.id'=>$id_ujian]);
				$ikut_ujian = $this->m_ikut_ujian->get_by(['id_ujian'=>$id_ujian,'id_user'=>$this->akun->id]);
				// print_r($id_ujian);exit;
				$cek_sdh_ujian	= $this->m_ikut_ujian->count_by(['id_ujian'=>$id_ujian,'id_user'=>$this->akun->id]);
				$acakan = $cek_detil_tes->jenis == "ORDER BY id ASC";

				$offset = 0;

				$to = $cek_detil_tes->jumlah_soal;

				
				// print_r($cek_detil_tes);
				// exit;

				if ($cek_sdh_ujian <= $this->total_ujian)	{		

					$soal_urut_ok = array();

					// Ambil soal berdasarkan Ujiannya masing-masing
					$a_soal			= $this->db->query("SELECT id, file, jawaban, tipe_file, soal, opsi_a, opsi_b, opsi_c, opsi_d, opsi_e FROM m_soal_ujian WHERE id_ujian = '".$cek_detil_tes->id."' ".$acakan." LIMIT ".$offset.", ".$to)->result();

				
					$q_soal = $this->db->select("*")
										->from('m_soal_ujian')
										->where(['id_ujian' => $cek_detil_tes->id])
										->limit($to, $offset)
										->get()
										->result();
					// print_r($a_soal);
					// print_r($q_soal);
					// exit;
					// $q_soal	= $this->db->query("SELECT id, file, jawaban, tipe_file, soal, opsi_a, opsi_b, opsi_c, opsi_d, opsi_e, '' AS jawaban FROM m_soal_ujian WHERE id_ujian = '".$cek_detil_tes->id."' ".$acakan." LIMIT ".$offset.", ".$to)->result();


					// print_r($cek_detil_tes);exit;


					

					$i = 0;

					foreach ($q_soal as $s) {

						$soal_per = new stdClass();

						$soal_per->id = $s->id;

						$soal_per->soal = $s->soal;

						$soal_per->file = $s->file;

						$soal_per->tipe_file = $s->tipe_file;

						$soal_per->opsi_a = $s->opsi_a;

						$soal_per->opsi_b = $s->opsi_b;

						$soal_per->opsi_c = $s->opsi_c;

						$soal_per->opsi_d = $s->opsi_d;

						$soal_per->opsi_e = $s->opsi_e;

						$soal_per->jawaban = $s->jawaban;

						$soal_urut_ok[$i] = $soal_per;

						$i++;

					}



					$soal_urut_ok = $soal_urut_ok;

					

					$list_id_soal	= "";

					$list_jw_soal 	= "";

					$list_jw_benar  = "";

					if (!empty($q_soal)) {

						foreach ($q_soal as $d) {

							$list_id_soal .= $d->id.",";

							$list_jw_soal .= $d->id."::N,";

							

						}

						foreach ($a_soal as $d) {

							$list_jw_benar .= $d->id.":".$d->jawaban.":N,";

						}

					}

					$list_id_soal = substr($list_id_soal, 0, -1);

					$list_jw_soal = substr($list_jw_soal, 0, -1);

					$list_jw_benar = substr($list_jw_benar, 0, -1);

					$waktu_selesai = tambah_jam_sql($cek_detil_tes->waktu);

					$time_mulai		= date('Y-m-d H:i:s');



					$time = new DateTime($time_mulai);

					$time->add(new DateInterval('PT' . $cek_detil_tes->waktu . 'M'));

					$tgl_selesai = $time->format('Y-m-d H:i');

					

					

					if (empty($ikut_ujian->status)) {

						$status_ = 'N';

					}else{

						$status_ = $ikut_ujian->status;

					}





					if ($status_ != 'Y') {



						$insert_data = array(

							'id_ujian' 		=> $id_ujian,

							'id_user' 		=> $this->akun->id, 

							'list_soal' 	=> $list_id_soal, 

							'list_jawaban' 	=> $list_jw_soal, 

							'jml_benar' 	=> 0 , 

							'nilai' 		=> 0, 

							'nilai_bobot' 	=> 0, 

							'tgl_mulai'	 	=> $time_mulai, 

							'tgl_selesai' 	=> $tgl_selesai, 

							'status' 		=> 'Y', 

							'jawaban_benar' => $list_jw_benar, 

							'banyak'	 	=> 1, 

						);


						// print_r($insert_data);exit;
						$this->m_ikut_ujian->insert($insert_data);

						

						

					}





					

					$cek_ujian_pertama = $this->db->select("count(*) as total")

												  ->from('tb_ikut_ujian_pertama')

												  ->where(['id_ujian'=>$id_ujian,'id_user'=>$this->akun->id])

												  ->get()

												  ->row();
					// print_r($list_id_soal);exit;	



					if($cek_ujian_pertama->total < 1) {
						$data = [
							'id_ujian' => $id_ujian,
							'id_user' => $this->akun->id,
							'list_soal' => $list_id_soal
						];
						$this->db->query("INSERT INTO tb_ikut_ujian_pertama VALUES (null, '$id_ujian', NULL, '".$this->akun->id."', '$list_id_soal', '$list_jw_soal', 0, 0, 0, '$time_mulai', ADDTIME('$time_mulai', '$waktu_selesai'), 'N', '$list_jw_benar', 1)");

					}

					$detil_tes = $this->db->query("SELECT * FROM tb_ikut_ujian WHERE status = 'Y' AND id_ujian = '$id_ujian' AND id_user = '".$this->akun->id."'")->row();
					// print_r($detil_tes->list_jawaban);exit;	
	

	

					//echo $this->db->last_query();exit;



					$soal_urut_ok= $soal_urut_ok;

				} else {



					$q_ambil_soal = $this->m_ikut_ujian->get_by(['id_ujian'=>$id_ujian,'id_user'=>$this->akun->id]);




					$urut_soal 		= explode(",", $q_ambil_soal->list_jawaban);

					

					$soal_urut_ok	= array();

					for ($i = 0; $i < sizeof($urut_soal); $i++) {

						$pc_urut_soal = explode(":",$urut_soal[$i]);

						$pc_urut_soal1 = empty($pc_urut_soal[1]) ? "''" : "'".$pc_urut_soal[1]."'";

						$ambil_soal = $this->db->query("SELECT *, $pc_urut_soal1 AS jawaban FROM m_soal_ujian WHERE id = '".$pc_urut_soal[0]."'")->row();



						$soal_urut_ok[] = $ambil_soal; 

					}

					

					$detil_tes = $q_ambil_soal;

					$soal_urut_ok = $soal_urut_ok;

				}
				$pc_list_jawaban = explode(",", $detil_tes->list_jawaban);

				$arr_jawab = array();
				// PENYEBAB UTAMA ERROR
				foreach ($pc_list_jawaban as $v) {

				  $pc_v = explode(":", $v);

				  $idx = $pc_v[0];

				  $val = $pc_v[1];

				  $rg = $pc_v[2];

				  $arr_jawab[$idx] = array("j"=>$val,"r"=>$rg);

				}



		



				$html = '';

				$no = 1;

			

				if (!empty($soal_urut_ok)) {

					

				    foreach ($soal_urut_ok as $d) { 

				    	echo $d->id;

				        $tampil_media = tampil_media("./upload/file_ujian_soal/".$d->file, '250px','auto');

				        $vrg = $arr_jawab[$d->id]["r"] == "" ? "N" : $arr_jawab[$d->id]["r"];



				        $html .= '<input type="hidden" name="id_soal_'.$no.'" value="'.$d->id.'">';

				        $html .= '<input type="hidden" name="rg_'.$no.'" id="rg_'.$no.'" value="'.$vrg.'">';

				        $html .= '<div class="step" id="widget_'.$no.'">';

				        $html .= $d->soal.'<br>'.$tampil_media.'<div class="funkyradio">';



				        for ($j = 0; $j < $this->config->item('jml_opsi'); $j++) {

				            $opsi = "opsi_".$this->opsi[$j];

				            $checked = $arr_jawab[$d->id]["j"] == strtoupper($this->opsi[$j]) ? "checked" : "";

				            $pc_pilihan_opsi = explode("#####", $d->$opsi);

				            $tampil_media_opsi = (is_file('./upload/file_ujian_soal/'.$pc_pilihan_opsi[0]) || $pc_pilihan_opsi[0] != "") ? tampil_media('./upload/file_ujian_soal/'.$pc_pilihan_opsi[0],'250px','auto') : '';

					    	$pilihan_opsi = empty($pc_pilihan_opsi[1]) ? "-" : $pc_pilihan_opsi[1];
				            $html .= '<div class="funkyradio-success" onclick="return simpan_sementara_ujian();">

				                <input type="radio" id="opsi_'.strtoupper($this->opsi[$j]).'_'.$d->id.'" name="opsi_'.$no.'" value="'.strtoupper($this->opsi[$j]).'" '.$checked.'> <label for="opsi_'.strtoupper($this->opsi[$j]).'_'.$d->id.'"><div class="huruf_opsi">'.$this->opsi[$j].'</div> <p>'.$pilihan_opsi.'</p><p>'.$tampil_media_opsi.'</p></label></div>';

				        }

				        $html .= '</div></div>';

				        $no++;

				    }

				}



				$a['jam_mulai'] = $detil_tes->tgl_mulai;

				$a['jam_selesai'] = $detil_tes->tgl_selesai;

				$a['id_tes'] = $cek_detil_tes->id;

				$a['no'] = $no;

				$a['html'] = $html;



				

				$this->load->view('ujian/v_ujian', $a);

			} else {

				//redirect('ujian/sudah_selesai_ujian/'.$id_ujian);

			}



		}



		public function simpan_satu_ujian($id_ujian,$id_pengguna=NULL){

			$p			= json_decode(file_get_contents('php://input'));

			$update_ 	= "";

			for ($i = 1; $i < $p->jml_soal; $i++) {

				$_tjawab 	= "opsi_".$i;

				$_tidsoal 	= "id_soal_".$i;

				$_ragu 		= "rg_".$i;

				$jawaban_ 	= empty($p->$_tjawab) ? "" : $p->$_tjawab;

				$update_	.= "".$p->$_tidsoal.":".$jawaban_.":".$p->$_ragu.",";

			}

			$update_		= substr($update_, 0, -1);

			$this->db->query("UPDATE tb_ikut_ujian SET list_jawaban = '".$update_."' WHERE id_ujian = '$id_ujian' AND id_user = '".$this->akun->id."'");

			$cek = $this->db->query("SELECT * from tb_ikut_ujian where id_ujian = " . $id_ujian . " and id_user = " . $this->akun->id . "");

			$cek_ujian_pertama = $this->db->query("SELECT * from tb_ikut_ujian_pertama where id_ujian = " . $id_ujian . " and id_user = " . $this->akun->id . "");

			if($cek_ujian_pertama->num_rows() == 1 ) {

				if($cek->num_rows() == 1) {

					$this->db->query("UPDATE tb_ikut_ujian_pertama SET list_jawaban = '".$update_."' WHERE id_ujian = '$id_ujian' AND id_user = '".$this->akun->id."'");

				}

				

			}

			//echo $this->db->last_query();



			$q_ret_urn 	= $this->db->query("SELECT list_jawaban FROM tb_ikut_ujian WHERE status = 'Y' AND id_ujian = '$id_ujian' AND id_user = '".$this->akun->id."'");

			$d_ret_urn 	= $q_ret_urn->row_array();

			$ret_urn 	= explode(",", $d_ret_urn['list_jawaban']);

			$hasil 		= array();

			foreach ($ret_urn as $key => $value) {

				$pc_ret_urn = explode(":", $value);

				$idx 		= $pc_ret_urn[0];

				$val 		= $pc_ret_urn[1].'_'.$pc_ret_urn[2];

				$hasil[]= $val;

			}



			$d['data'] = $hasil;

			$d['status'] = "ok";

			j($d);

			exit;	

		}



		public function simpan_akhir_ujian($id_ujian){



			$get_jawaban = $this->db->query("SELECT list_jawaban FROM tb_ikut_ujian WHERE status = 'Y' AND id_ujian = '$id_ujian' AND id_user = '".$this->akun->id."'")->row_array();

			$pc_jawaban = explode(",", $get_jawaban['list_jawaban']);

			$jumlah_benar 	= 0;

			$jumlah_salah 	= 0;

			$jumlah_ragu  	= 0;

			$nilai_bobot 	= 0;

			$total_bobot	= 0;

			$jumlah_soal	= sizeof($pc_jawaban);



			for ($x = 0; $x < $jumlah_soal; $x++) {

				$pc_dt = explode(":", $pc_jawaban[$x]);

				$id_soal 	= $pc_dt[0];

				$jawaban 	= $pc_dt[1];

				$ragu 		= $pc_dt[2];

				$cek_jwb 	= $this->db->query("SELECT bobot, jawaban FROM m_soal_ujian WHERE id = '".$id_soal."'")->row();

				$total_bobot = $total_bobot + $cek_jwb->bobot;

				

				if (($cek_jwb->jawaban == $jawaban)) {

					//jika jawaban benar 

					$jumlah_benar++;

					$nilai_bobot = $nilai_bobot + $cek_jwb->bobot;

					$q_update_jwb = "UPDATE m_soal_ujian SET jml_benar = jml_benar + 1 WHERE id = '".$id_soal."'";

				} else {

					//jika jawaban salah

					$jumlah_salah++;

					$q_update_jwb = "UPDATE m_soal_ujian SET jml_salah = jml_salah + 1 WHERE id = '".$id_soal."'";

				}

				$this->db->query($q_update_jwb);

			}



			$nilai = ($jumlah_benar / $jumlah_soal)  * 100;

			if($total_bobot > 0) {
				$nilai_bobot = ($nilai_bobot / $total_bobot)  * 100;	
			}
			else {
				$nilai_bobot = ($nilai_bobot)  * 100;
			}

			

			
			// Update status siswa jika nilainya lulus
			$is_graduted = $this->m_ujian->get_by(['uji.id' => $id_ujian]);
			if(!is_null($is_graduted)) {
				if($nilai >= $is_graduted->min_nilai) {
					$this->db->update('m_siswa', ['is_graduated' => 1],['id' => $this->akun->id]);
				}
			}


			//$a_banyak		= $this->db->query("SELECT SUM(banyak) AS jumlah FROM tb_ikut_ujian")->row();

			//$this->db->query("UPDATE tb_ujian SET penggunaan = '$a_banyak->jumlah' WHERE id = '$id_ujian' ");



			$this->db->query("UPDATE tb_ikut_ujian SET jml_benar = '$jumlah_benar', nilai = '$nilai', nilai_bobot = '$nilai_bobot', status = 'N',tgl_selesai= '".date('Y-m-d H:i:s')."' WHERE status = 'Y' AND id_ujian = '$id_ujian' AND id_user = '".$this->akun->id."'");

			

			$cek = $this->db->query("SELECT * from tb_ikut_ujian where id_ujian = " . $id_ujian . " and id_user = " . $this->akun->id . "");

			$cek_ujian_pertama = $this->db->query("SELECT * from tb_ikut_ujian_pertama where id_ujian = " . $id_ujian . " and id_user = " . $this->akun->id . "");



			if($cek_ujian_pertama->num_rows() == 1 ) {

				if($cek->num_rows() > 0) {

					$this->db->query("UPDATE tb_ikut_ujian_pertama SET jml_benar = '.$jumlah_benar.', nilai = '.$nilai.', nilai_bobot = '.$nilai_bobot.', status = 'N' WHERE status = 'Y' AND id_ujian = '$id_ujian' AND id_user = '".$this->akun->id."'");

				}



				$this->session->set_userdata(array('selesai_ujian'=>1));





			}

			$a['status'] = "ok";

			j($a);

			exit;

		}



		public function result($id,$mapel=null) {

	

			$data = array(

				'id_ujian' => decrypt_url($id)

			);



			$this->render('ujian/list_hasil', $data);



		}



		public function riwayat($id,$id_ujian=0) {



			cek_hakakses(array("siswa"), $this->session->userdata('admin_level'));

			$id = decrypt_url($id);

			$id_ujian = decrypt_url($id_ujian);

	//var post from json

			$p = json_decode(file_get_contents('php://input'));

			$a['detil_user'] = $this->db->query("SELECT * FROM m_siswa WHERE id = '".$this->akun->id."'")->row();





			header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");

			header("Cache-Control: post-check=0, pre-check=0", false);

			header("Pragma: no-cache");





		//hasil Jawaban

			$cek_detil_tes = $this->db->query("SELECT * FROM tb_ujian WHERE id = '$id_ujian'")->row();

			$q_cek_sdh_ujian= $this->db->query("SELECT id FROM tb_ikut_ujian WHERE id = '$id' AND id_ujian = '$id_ujian' AND id_user = '".$this->akun->id."'");

			$d_cek_sdh_ujian= $q_cek_sdh_ujian->row();

			$cek_sdh_ujian	= $q_cek_sdh_ujian->num_rows();

			$acakan = $cek_detil_tes->jenis == "acak" ? "ORDER BY RAND()" : "ORDER BY id ASC";

			$q_ambil_soal 	= $this->db->query("SELECT * FROM tb_ikut_ujian WHERE id = '$id' AND id_ujian = '$id_ujian' AND id_user = '".$this->akun->id."'")->row();

			$urut_soal 		= explode(",", $q_ambil_soal->list_jawaban);

			$soal_urut_ok	= array();

			for ($i = 0; $i < sizeof($urut_soal); $i++) {

				$pc_urut_soal = explode(":",$urut_soal[$i]);

				$pc_urut_soal1 = empty($pc_urut_soal[1]) ? "''" : "'".$pc_urut_soal[1]."'";

				$ambil_soal = $this->db->query("SELECT *, $pc_urut_soal1 AS jawaban FROM m_soal_ujian WHERE id = '".$pc_urut_soal[0]."'")->row();

				$soal_urut_ok[] = $ambil_soal; 

			}

			$detil_tes = $q_ambil_soal;

			$soal_urut_ok = $soal_urut_ok;



			$pc_list_jawaban = explode(",", $detil_tes->list_jawaban);

			$arr_jawab = array();

			foreach ($pc_list_jawaban as $v) {

				$pc_v = explode(":", $v);

				$idx = $pc_v[0];

				$val = $pc_v[1];

				$rg = $pc_v[2];

				$arr_jawab[$idx] = array("j"=>$val,"r"=>$rg);

			}

			$html = '';

			$no = 1;





		//Jawaban Benar

			$cek_detil_tes1 = $this->db->query("SELECT * FROM tb_ujian WHERE id = '$id_ujian'")->row();

			$acakan1 = $cek_detil_tes1->jenis == "acak" ? "ORDER BY RAND()" : "ORDER BY id ASC";

			$q_ambil_soal1 	= $this->db->query("SELECT * FROM tb_ikut_ujian WHERE id = '$id' AND id_ujian = '$id_ujian' AND id_user = '".$this->akun->id."'")->row();

			$urut_soal1 	= explode(",", $q_ambil_soal1->jawaban_benar);

			$soal_urut_ok1	= array();

			for ($i = 0; $i < sizeof($urut_soal1); $i++) {

				$pc_urut_soal1 = explode(":",$urut_soal1[$i]);

				$pc_urut_soal1 = empty($pc_urut_soal1[1]) ? "''" : "'".$pc_urut_soal1[1]."'";

				$ambil_soal1 = $this->db->query("SELECT *, $pc_urut_soal1 AS jawaban FROM m_soal_ujian WHERE id = '".$pc_urut_soal[0]."'")->row();

				$soal_urut_ok1[] = $ambil_soal1; 

			}



			$detil_tes1 = $q_ambil_soal1;

			$soal_urut_ok1 = $soal_urut_ok1;

			$pc_list_jawaban1 = explode(",", $detil_tes1->jawaban_benar);

			$arr_jawab1 = array();

			foreach ($pc_list_jawaban1 as $v) {

				$pc_v = explode(":", $v);

				$idx = $pc_v[0];

				$val = $pc_v[1];

				$rg = $pc_v[2];

				$arr_jawab1[$idx] = array("j"=>$val,"r"=>$rg);

			}

			$html = '';

			$no = 1;











			if (!empty($soal_urut_ok)) {

				foreach ($soal_urut_ok as $d) { 

					$soal = str_replace('<p>','', $d->soal);

					$tampil_media = tampil_media("./upload/gambar_soal/".$d->file, '250px','auto');

					$vrg = $arr_jawab[$d->id]["r"] == "" ? "N" : $arr_jawab[$d->id]["r"];

					$vrg1 = $arr_jawab1[$d->id]["r"] == "" ? "N" : $arr_jawab1[$d->id]["r"];



					$html .= '<input type="hidden" name="id_soal_'.$no.'" value="'.$d->id.'"  disabled>';

					$html .= '<input type="hidden" name="rg_'.$no.'" id="rg_'.$no.'" value="'.$vrg.'" disabled>';

					$html .= '<div class="step" id="widget_'.$no.'"  disabled><hr>';

					$html .= '<p>'.$no.'.'.$soal.'<br>'.$tampil_media.'<div class="funkyradio1">';



					for ($j = 0; $j < $this->config->item('jml_opsi'); $j++) {

						$opsi = "opsi_".$this->opsi[$j];

						$opsi = "opsi_".$this->opsi[$j];

						$checked = $arr_jawab[$d->id]["j"] == strtoupper($this->opsi[$j]) ? "checked" : "";

						$checked1 = $arr_jawab1[$d->id]["j"] == strtoupper($this->opsi[$j]) ? "checked" : "";

						$pc_pilihan_opsi = explode("#####", $d->$opsi);

						$tampil_media_opsi = (is_file('./upload/gambar_soal/'.$pc_pilihan_opsi[0]) || $pc_pilihan_opsi[0] != "") ? tampil_media('./upload/gambar_opsi/'.$pc_pilihan_opsi[0],'250px','auto') : '';



						$pilihan_opsi = empty($pc_pilihan_opsi[1]) ? "-" : $pc_pilihan_opsi[1];



						if(strtoupper($this->opsi[$j]) == $arr_jawab1[$d->id]["j"]){

							$html .= '<div class="" onclick="return simpan_sementara();">

							<input type="radio" id="opsi_'.strtoupper($this->opsi[$j]).'_'.$d->id.'" name="opsi_'.$no.'" value="'.strtoupper($this->opsi[$j]).'"  '.$checked.' disabled> <label style="background:#86c186;" for="opsi_'.strtoupper($this->opsi[$j]).'_'.$d->id.'"><div class="huruf_opsi">'.$this->opsi[$j].'</div> <p>'.$pilihan_opsi.'</p><p>'.$tampil_media_opsi.'</p></label></div>';

						}else{

							$html .= '<div class="" onclick="return simpan_sementara();">

							<input type="radio" id="opsi_'.strtoupper($this->opsi[$j]).'_'.$d->id.'" name="opsi_'.$no.'" value="'.strtoupper($this->opsi[$j]).'"  '.$checked.' disabled> <label for="opsi_'.strtoupper($this->opsi[$j]).'_'.$d->id.'"><div class="huruf_opsi">'.$this->opsi[$j].'</div> <p>'.$pilihan_opsi.'</p><p>'.$tampil_media_opsi.'</p></label></div>';

						}









					}

					$html .= '</div></div>';

					$no++;

				}

			}



			$a['jam_mulai'] = $detil_tes->tgl_mulai;

			$a['jam_selesai'] = $detil_tes->tgl_selesai;

			$a['id_tes'] = $cek_detil_tes->id;

			$a['no'] = $no;

			$a['html'] = $html;

			$this->load->view('ujian/v_riwayat', $a);

		}

		

	public function multi_delete(){

		$post = $this->input->post();



		foreach ($post['id'] as $val) {

			$where[] = $val;

		}



		$this->db->trans_begin();



		$kirim = $this->db->where_in('id',$where)->delete('tb_ujian');

	

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

	function get_mapel_kelas(){
		$post = $this->input->post();
		$where = ['mp.id_instansi' => $this->akun->instansi,'klsmp.id_kelas'=>$post['id_kelas']];
		if($this->log_lvl == 'guru'){
			$where['klsmp.id_guru'] = $this->akun->id;
		}
		$post['id_mapel'] = (empty($post['id_mapel'])) ? 0 : $post['id_mapel'];
		$mapel = $this->m_mapel->join_kls_mpl($where);

		$select = '<option value="">Pilih</option>';

		foreach ($mapel as $key => $rows) {
			if($rows->id == $post['id_mapel']){
				$select .= '<option value="'.$rows->id."-".$rows->id_guru.'" selected>'.$rows->mapel.'</option>';
			}else{
				$select .= '<option value="'.$rows->id."-".$rows->id_guru.'">'.$rows->mapel.'</option>';
			}
			
		}

		$json = ['select'=>$select];

		echo json_encode($json);


		
	}





}