<?php

 defined('BASEPATH') OR exit('No direct script access allowed');



class Ujian_essay extends MY_Controller {

	public $_fileSoalPath = 'upload/file_ujian_soal_essay/';
	public $_fileJawabanPath = 'upload/file_jawaban_essay/';

    public function __construct() {

        parent::__construct();

        $this->load->model('m_ujian');

        $this->load->model('m_instansi');

        $this->load->model('m_mapel_cs');

        $this->load->model('m_guru');

        $this->load->model('m_soal_ujian_essay');

		$this->load->model('m_ikut_ujian');
		$this->load->model('m_ikut_ujian_essay');
		$this->load->model('m_jawaban_essay');

		$this->load->model('m_kelas');

		

        $this->opsi = array("a","b","c","d","e");

	}



	public function index(){

	}



	public function data_soal($id_ujian=null){

		$this->page_title = 'Soal Essay';

		$url = base_url('ujian_essay/form_soal/'.$id_ujian);



		$data = array(

			'searchFilter' => array('Modul Pelatihan','Trainer'),

			'tipe_ujian'   => $tipe_ujian = array(''=>'Semua','uts'=>'UTS','uas'=>'UAS'),

			'url_form' => $url,

			'url_import' => base_url('ujian_essay/form_import/'.$id_ujian),

			'ujian' => $this->m_ujian->get_by(['uji.id'=>decrypt_url($id_ujian)])

		);

		$this->render('ujian_essay/list_soal',$data);

	}



	public function add(){



		$tipe_ujian = array('uts'=>'UTS','uas'=>'UAS');

		

		if ($this->log_lvl == 'guru') {

			$kelas = $this->m_kelas->get_many_by(['id_trainer'=>$this->akun->id,'kls.id_instansi'=>$this->akun->instansi]);

		} else if ($this->log_lvl == 'instansi' || $this->log_lvl == 'admin_instansi'){

			$kelas = $this->m_kelas->get_many_by(['kls.id_instansi'=>$this->akun->instansi]);

		} else {

			$kelas = $this->m_kelas->get_all(['kls.id_instansi' => $this->akun->instansi]);

		}

		$this->load->model('m_setting_instansi');
		$bobot = $this->m_setting_instansi->get_by(['id_instansi' => $this->akun->instansi]);

		$data = array(

			'tipe_ujian' => $tipe_ujian, 

			'kelas' => $kelas,
			'bobot' => $bobot

		);



		$this->render('ujian_essay/add',$data);

	}



	public function edit($id=0){



		$tipe_ujian = array('uts'=>'UTS','uas'=>'UAS');



		if ($this->log_lvl == 'guru') {

			$kelas = $this->m_kelas->get_many_by(['id_trainer'=>$this->akun->id,'kls.id_instansi'=>$this->akun->instansi]);

		} else if ($this->log_lvl == 'instansi' || $this->log_lvl == 'admin_instansi'){

			$kelas = $this->m_kelas->get_many_by(['kls.id_instansi'=>$this->akun->instansi]);

		} else {

			$kelas = $this->m_kelas->get_all();

		}



		$id = decrypt_url($id);

		$data = array(

			'tipe_ujian' => $tipe_ujian, 

			'kelas' => $kelas,

			'edit' => $this->m_ujian->get_by(['uji.id'=>$id])

		);

		$this->render('ujian_essay/edit',$data);

	}



	public function form_import($id_ujian){



		$data = array(

			'back_url' => base_url('ujian_essay/data_soal/'.$id_ujian.''),

			'url_import' => base_url('import/ujian/'.$id_ujian.''),

		);



		$this->render('ujian_essay/form_import',$data);

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



		if ($this->log_lvl == 'guru') {

			$post['trainer'] = $this->akun->id;

		}



		$data = [

			'id_kelas'		=> $post['id_kelas'],

			'type_ujian'  	=> $post['type_ujian'],

			'nama_ujian'  	=> $post['nama_ujian'],

			'jumlah_soal'  	=> 0,

			'waktu'  		=> $post['waktu_ujian'],

			'nama_ujian'  	=> $post['nama_ujian'],

			'jenis'  		=> 'set',

			'tgl_mulai'		=> date_default($post['tgl_mulai']).' '.$post['waktu_mulai'],

			'terlambat'		=> date_default($post['tgl_selesai']).' '.$post['waktu_selesai'],

			'min_nilai'		=> $post['min_nilai']

		];



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



		$data = [

			'id_kelas'		=> $post['id_kelas'],

			'type_ujian'  	=> $post['type_ujian'],

			'nama_ujian'  	=> $post['nama_ujian'],

			'jumlah_soal'  	=> 0,

			'waktu'  		=> $post['waktu_ujian'],

			'nama_ujian'  	=> $post['nama_ujian'],

			'jenis'  		=> 'set',

			'tgl_mulai'		=> date_default($post['tgl_mulai']).' '.$post['waktu_mulai'],

			'terlambat'		=> date_default($post['tgl_selesai']).' '.$post['waktu_selesai'],

			'min_nilai'		=> $post['min_nilai']

		];



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



	



		$where['kls.id_instansi'] = $this->akun->instansi;



		// if ($this->log_lvl == 'guru') {

		// 	$where['kls.id_trainer'] = $this->akun->id;

		// }

		

		if ($this->log_lvl == 'siswa') {

			$where['dekls.id_peserta'] = $this->akun->id;

			$paginate = $this->m_ujian->paginate_siswa($pg,$where,$limit);

		}else{

		    $paginate = $this->m_ujian->paginate($pg,$where,$limit);

		}



	

		$data['paginate'] = $paginate;

		$data['paginate']['url']	= 'ujian_essay/page_load';

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



		$paginate = $this->m_soal_ujian_essay->paginate($pg,$where,$limit);

		$data['paginate'] = $paginate;

		$data['paginate']['url']	= 'ujian_essay/page_load_soal';

		$data['paginate']['search'] = 'lookup_key';

		$data['page_start'] = $paginate['counts']['from_num'];



		$this->load->view('ujian_essay/table_soal',$data);

		$this->generate_page($data);

	}



	public function page_load_result($pg = 1){

		$post = $this->input->post();

		$limit = $post['limit'];

		$where = [];

		if (!empty($post['search'])) {

			switch ($post['filter']) {

				case 0:

					$where["(lower(siswa.nama) like '%".strtolower($post['search'])."%' )"] = null;

					break;

				case 1:

					$where["(lower(kls.nama) like '%".strtolower($post['search'])."%' )"] = null;

					break;

				default:

					# code...

					break;

			}

		}

		$where['id_ujian'] = $post['id_ujian'];

		// $where['status'] = 'N';

		$paginate = $this->m_ikut_ujian_essay->paginate($pg,$where,$limit);

		$data['paginate'] = $paginate;

		$data['paginate']['url']	= 'ujian_essay/page_load_result';

		$data['paginate']['search'] = 'lookup_key';

		$data['page_start'] = $paginate['counts']['from_num'];

		$data['id_ujian'] = $post['id_ujian'];



		$this->load->view('ujian_essay/table_hasil',$data);

		$this->generate_page($data);

	}



	public function form_soal($id_ujian,$id_soal=0) {



		cek_hakakses(array("admin", "guru",'instansi'), $this->session->userdata('admin_level'));


		$id_guru = $this->log_lvl == "guru" ? "WHERE a.id_guru = '".$this->log_id."'" : "";



		if ($id_soal == 0) {

			$a['d'] = array("mode"=>"add","id"=>"0","id_guru"=>$id_guru,"id_mapel"=>"","bobot"=>"1","file"=>"","soal"=>"","tgl_input"=>"");

		}else {

			$a['d'] = $this->db->select("ujian.*, 'edit' AS mode")->where('id',$id_soal)->get('m_soal_ujian_essay ujian')->row_array();

		}

		$data = array();
		

		$a['id_ujian'] = decrypt_url($id_ujian);


		$a['data_pc'] = $data;


		$this->render('ujian_essay/add_soal',$a);

	}



	public function simpan_soal(){
		$p = $this->input->post();
		$pembuat_soal = ($this->log_lvl == "admin") ? $p['id_guru'] : $this->log_id;
		$pembuat_soal_u = ($this->log_lvl == "admin") ? ", id_guru = '".$p['id_guru']."'" : "";
		$buat_folder_gb_soal = !is_dir($this->_fileSoalPath) ? @mkdir("./upload/file_ujian_soal_essay/") : false;
		$allowed_type = array(
			"image/jpeg",
			"image/png",
			"image/gif",
			"audio/mpeg",
			"audio/mpg",
			"audio/mpeg3", 
			"audio/mp3", 
			"audio/x-wav", 
			"audio/wave", 
			"audio/wav",
			"video/mp4", 
			"application/octet-stream"
		);
		$maxSize = 10145728; // 10MB
		$gagal 		= array();
		$nama_file 	= array();
		$tipe_file 	= array();

		//get mode ( Insert or Update)
		$__mode = $p['mode'];
		$__id_soal = 0;

		//ambil data post sementara
		$pdata = array(
			"bobot"=>$p['bobot'],
			"soal"=>$p['soal'],
			'id_ujian' => $p['id_ujian']
		);

		if($p['bobot'] != NULL) {
			$pdata['bobot'] = $p['bobot'];
		}

		if ($__mode == "edit") {
			$this->db->where("id", $p['id']);
			$this->db->update("m_soal_ujian_essay", $pdata);
			$__id_soal = $p['id'];
		} else {
			$insert = $this->db->insert("m_soal_ujian_essay", $pdata);
			$__id_soal = $this->db->insert_id();
		}

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
			$kode_file_error = array(
				"File berhasil diupload",
				"Ukuran file terlalu besar",
				"Ukuran file terlalu besar",
				"File upload error",
				"Tidak ada file yang diupload",
				"File upload error"
			);
		
			if ($file_error != 0) {
				$gagal[$k] = $kode_file_error[$file_error];
				$nama_file[$k]	= "";
				$tipe_file[$k]	= "";
			} else if (!in_array($file_type, $allowed_type)) {
				$gagal[$k] = "Tipe file ini tidak diperbolehkan..";
				$nama_file[$k]	= "";
				$tipe_file[$k]	= "";
				$this->session->set_flashdata("msg", "<p class='alert alert-danger'>File yang anda upload tidak diperbolehkan, yang dibolehkan : ". join($allowed_type, ', ') ."</p>");
				redirect('ujian_essay/form_soal/' . encrypt_url($p['id_ujian']));
				exit;
			} 
			else if($file_size > $maxSize) {
				$this->session->set_flashdata("msg", "<p class='alert alert-danger'>File terlalu besar, maksimal 10 MB</p>");
				redirect('ujian_essay/form_soal/' . encrypt_url($p['id_ujian']));
				exit;
			}
			else if ($file_name == "") {
				$gagal[$k] = "Tidak ada file yang diupload";
				$nama_file[$k]	= "";
				$tipe_file[$k]	= "";					
			} else {
				$ekstensi = explode(".", $file_name);
				$file_name = $k."_".$__id_soal.".". end($ekstensi);
				@move_uploaded_file($file_tmp, $this->_fileSoalPath.$file_name);
				if($__mode == 'edit') {
					$fileSoal = $this->m_soal_ujian_essay->get_by([
						'id' => $p['id'],
						'id_ujian' => $p['id_ujian']
					]);
					if(file_exists($this->_fileSoalPath . $fileSoal->file)) {
						unlink($this->_fileSoalPath . $fileSoal->file);
					}
				}

				$gagal[$k]	 	= $kode_file_error[$file_error]; //kode kegagalan upload file
				$nama_file[$k]	= $file_name; //ambil nama file
				$tipe_file[$k]	= $file_type; //ambil tipe file
			}
		}

		$data_simpan = array();
		if (!empty($nama_file['file_ujian_soal_essay'])) {
			$data_simpan = array(
				"file"=>$nama_file['file_ujian_soal_essay'],
				"tipe_file"=>$tipe_file['file_ujian_soal_essay'],
			);
			$this->db->update("m_soal_ujian_essay", $data_simpan,['id'=>$__id_soal]);
		}

		$teks_gagal = "";
		foreach ($gagal as $k => $v) {
			$arr_nama_file_upload = array("file_ujian_soal_essay"=>"File Soal ");
			$teks_gagal .= $arr_nama_file_upload[$k].': '.$v.'<br>';
		}

		$this->session->set_flashdata('k', '<div class="alert alert-info">'.$teks_gagal.'</div>');
		redirect(base_url('ujian_essay/data_soal/'.encrypt_url($p['id_ujian']).'/'.encrypt_url($p['id_instansi']).'/'.encrypt_url($p['id_mapel']).'/'.encrypt_url($p['id_guru']).''));				
	}

	public function file_hapus_ujian($id=0,$no){
		$nama_gambar = $this->m_soal_ujian_essay->get_by(array('id'=>$id));
		$num = $nama_gambar->id + $no;
		$link1 =1 + $nama_gambar->id;
		if($link1 == $num){
			unlink("./upload/file_ujian_soal_essay/".$nama_gambar->file);
			$update['file'] = NULL;
			$update['type_file'] = NULL;
		}

		$this->m_soal_ujian_essay->update($update,['id'=>$id]);
		exit;
	}

	public function hapus_soal(){
		$post = $this->input->post();

		foreach ($post['id'] as $key => $id) {
			$nama_gambar = $this->m_soal_ujian_essay->get_by(array('id'=>$id));
			$kirim = $this->m_soal_ujian_essay->delete(array('id'=>$id));
			if($kirim){
				@unlink("./upload/file_ujian_soal_essay/".$nama_gambar->file);
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

										a.id, a.tgl_mulai, a.terlambat,a.izin, 

										a.token, a.nama_ujian, a.jumlah_soal, a.waktu,

										a.status_token, c.nama nmmapel,

										(case

										when (now() < a.tgl_mulai) then 0

										when (now() >= a.tgl_mulai and now() <= a.terlambat) then 1

										else 2

										end) statuse

										")

								->from('tb_ujian a')
								->join(' m_mapel c','a.id_mapel = c.id', 'left')
								->where('a.id',decrypt_url($id_ujian))
								->get()
								->row_array();





			$a['dp'] = $this->m_siswa->get_by(['id' =>$this->log_id]);
			$a['jumlah_soal'] = $this->m_soal_ujian_essay->count_by(['id_ujian' =>decrypt_url($id_ujian)]);
		
			//$q_status = $this->db->query();



			if (!empty($a['du']) || !empty($a['dp'])) {

				$tgl_selesai = $a['du']['tgl_mulai'];

			    //$tgl_selesai2 = strtotime($tgl_selesai);

			    //$tgl_baru = date('F j, Y H:i:s', $tgl_selesai);



			    //$tgl_terlambat = strtotime("+".$a['du']['terlambat']." minutes", $tgl_selesai2);	

				$tgl_terlambat_baru = $a['du']['terlambat'];



				$a['tgl_mulai'] = $tgl_selesai;

				$a['terlambat'] = $tgl_terlambat_baru;

					$where = [
						'ujian.id_ujian' => decrypt_url($id_ujian),
						'id_user'  => $this->log_id,
						'status'   => 'N'
					];

					$cek = $this->db->select('count(ujian.id) as jmlh,tes.*')->from('tb_ikut_ujian_essay ujian')->join('tb_ujian tes','tes.id = ujian.id_ujian','inner')->where($where)->get()->row();

				

				if ($this->total_ujian <= $cek->jmlh) {

					redirect('ujian_real/');

					exit;

				}



				$this->session->set_userdata(array('selesai_ujian'=>0));

				$this->render('ujian_essay/ikuti_ujian', $a);



			} else {

				redirect('ujian_essay/result');

			}

		}



	public function ikut_ujian($id_ujian){
		$id_ujian = decrypt_url($id_ujian);

		if($this->log_lvl != 'siswa') {
			redirect('ujian_real');
		}
		
		$jwb = [];
		if ($this->session->userdata('selesai_ujian') == 1) {
			redirect(base_url('ujian_real/'));
			exit;
		}

		// Check apakah siswa udah ujian essay
		$checkSudahEssay = $this->sudahUjian('essay', $id_ujian);
		if($checkSudahEssay == TRUE || $checkSudahEssay == 1) {
			redirect('ujian_real');
		}

		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");

		$cek_sdh_selesai = $this->m_ikut_ujian_essay->count_by(['id_ujian'=>$id_ujian,'id_user'=>$this->akun->id,'status'=>'N']);

		//sekalian validasi waktu sudah berlalu...
		if ($cek_sdh_selesai <= $this->total_ujian) {
			$cek_detil_tes = $this->m_ujian->get_by(['uji.id'=>$id_ujian]);
			$ikut_ujian = $this->m_ikut_ujian_essay->get_by(['id_ujian'=>$id_ujian,'id_user'=>$this->akun->id]);
			
			$cek_sdh_ujian	= $this->m_ikut_ujian_essay->count_by(['id_ujian'=>$id_ujian,'id_user'=>$this->akun->id]);
			$acakan = $cek_detil_tes->jenis == "ORDER BY id ASC";
			if ($cek_sdh_ujian <= $this->total_ujian)	{		
				$soal_urut_ok = array();
				$a_soal	= $this->db->query("SELECT id, file, tipe_file, soal FROM m_soal_ujian_essay WHERE id_ujian = '".$cek_detil_tes->id."' ".$acakan)->result();
			
				$q_soal	= $this->db->query("SELECT id, file, tipe_file, soal, '' AS jawaban  FROM m_soal_ujian_essay WHERE id_ujian = '".$cek_detil_tes->id."' ".$acakan)->result();
			
				$i = 0;
				foreach ($q_soal as $s) {
					$soal_per = new stdClass();
					$soal_per->id = $s->id;
					$soal_per->soal = $s->soal;
					$soal_per->file = $s->file;
					$soal_per->tipe_file = $s->tipe_file;
					$soal_urut_ok[$i] = $soal_per;
					$i++;
				}

				$soal_urut_ok = $soal_urut_ok;
				$list_id_soal	= "";
				$list_jw_soal 	= "";
				$list_jw_benar  = "";
				if (!empty($q_soal)) {
					$x= 0;
					foreach ($q_soal as $d) {
						$list_id_soal .= $d->id.",";
						$x++;
					}
				}
	
				$list_id_soal = substr($list_id_soal, 0, -1);
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
						'jml_benar' 	=> 0 , 
						'nilai' 		=> 0, 
						'nilai_bobot' 	=> 0, 
						'tgl_mulai'	 	=> $time_mulai, 
						'tgl_selesai' 	=> $tgl_selesai, 
						'status' 		=> 'Y', 
						'banyak'	 	=> 1, 
					);

					$this->m_ikut_ujian_essay->insert($insert_data);
					if (!empty($q_soal)) {
						$x= 0;
						foreach ($q_soal as $d) {
							$jwb[$x] = [
								'id_ujian' => $id_ujian,
								'id_user' => $this->akun->id,
								'id_ikut_essay' => $this->db->insert_id(),
								'id_soal'  => $d->id,
								'jawaban'  => '',
								'ragu'     => 'N'
							];
							$x++;
						}
					}

					$this->db->insert_batch('tb_jawaban_essay',$jwb);
				}

				$cek_ujian_pertama = $this->db->select("count(*) as total")
											->from('tb_ikut_ujian_essay_pertama')
											->where(['id_ujian'=>$id_ujian,'id_user'=>$this->akun->id])
											->get()	  
											->row();
				if($cek_ujian_pertama->total < 1) {
					$this->db->query("INSERT INTO tb_ikut_ujian_essay_pertama VALUES (null, '$id_ujian', NULL, '".$this->akun->id."', '$list_id_soal', 0, 0, 0, '$time_mulai', ADDTIME('$time_mulai', '$waktu_selesai'), 'N', '$list_jw_benar', 1)");
				}

					$ikut = $this->m_ikut_ujian_essay->get_by(['status' => 'Y','id_ujian'=>$id_ujian,'id_user'=>$this->akun->id]);
					$jwb_essay = $this->m_jawaban_essay->get_many_by(['id_ikut_essay'=>$ikut->id]);
					$soal_urut_ok= $soal_urut_ok;
				} else {
					$q_ambil_soal = $this->m_ikut_ujian_essay->get_by(['id_ujian'=>$id_ujian,'id_user'=>$this->akun->id]);
					$ikut = $this->m_ikut_ujian_essay->get_by(['status' => 'Y','id_ujian'=>$id_ujian,'id_user'=>$this->akun->id]);

					$jwb_essay = $this->m_jawaban_essay->get_many_by(['id_ikut_essay'=>$q_ambil_soal->id]);
					$soal_urut_ok = $this->m_soal_ujian_essay->get_many_by([
						'id_ujian' => $id_ujian
					]);

				}

				$html = ''; // untuk input dan soal
				$navigasiSoal = '<div id="yes"></div>'; // untuk navigasi soal
				$no = 1;
				$arr_jawab = array();
				$jumlahSoal = $this->m_soal_ujian_essay->get_many_by([
					'id_ujian' => $id_ujian
				]);

				foreach ($jwb_essay as $rows) {

				  $idx = $rows->id_soal;

				  $val = $rows->jawaban;

				  $rg = $rows->ragu;

				  $arr_jawab[$idx] = array("j"=>$val,"r"=>$rg);

				}
				
				$imageExtensions = ['image/png', 'image/jpeg', 'image/gif'];
				if (!empty($jumlahSoal)) {

					$file = NULL;

				    foreach ($jumlahSoal as $d) { 
				    	$checkJawaban = $this->m_jawaban_essay->get_by([
				    		'id_soal' => $d->id,
				    		'id_ujian' => $d->id_ujian
				    	]);
				    	$idJawaban = !empty($checkJawaban) ? $checkJawaban->id : 0;
				    	// Menentukan nama kelas yang nantinya akan dijadikan event JS ketika klik gambar
				    	if(in_array($d->tipe_file, $imageExtensions)) {
				    		$classFile = 'img-ujian';
				    	}
				    	else {
				    		$classFile = '';
				    	}
				    	if(file_exists($this->_fileSoalPath . $d->file)) {
				    		$tampil_media = getMediaSoalFile($d->file, $this->_fileSoalPath, $d->tipe_file, $classFile, 150, 300);
				    	}
				    	else {
				    		$tampil_media = '';
				    	}
				        // $tampil_media = tampil_media("upload/file_ujian_soal_essay/".$d->file, '250px','auto');

						// $vrg = $arr_jawab[$d->id]["r"] == "" ? "N" : $arr_jawab[$d->id]["r"];
						$vrg = 'N';
						$val = '';
						// $val = $arr_jawab[$d->id]["j"];
						$html .= '  
							<div class="step" id="widget_'.$no.'">
								<input type="hidden" name="id_soal_'.$no.'" value="'.$d->id.'" id="id_soal_'.$no.'">
								<input type="hidden" name="rg_'.$no.'" id="rg_'.$no.'" value="'.$vrg.'" data-no="'.$no.'">
								'.$d->soal.'<br>'.$tampil_media.'
								<div class="funkyradio">
									<div id="img-place-'.$no.'"></div>
									<input type="file" id="file_essay_'.$no.'" class="file_essay" name="file_'.$no.'" class="form-control" /><br>
									<input type="hidden" id="id-jawaban-'.$no.'" value="'.$idJawaban.'" />
									<textarea class="form-control" name="isi_'.$no.'">'.$val.'</textarea><br>
								</div>
							</div>';

						$navigasiSoal .= '
							<a class="btn btn-default btn-sm m-2 link-navigasi-soal" href="#" data-soal="'.$d->id.'" data-no="'.$no.'">'.$no.'. </a>
						';
				        $no++;
				    }
				}

				$a['jam_mulai'] = $ikut->tgl_mulai;
				$a['jam_selesai'] = $ikut->tgl_selesai;
				$a['id_tes'] = $cek_detil_tes->id;
				$a['no'] = $no;
				$a['htmls'] = $html;
				$a['jumlahSoal'] = $this->m_soal_ujian_essay->count_by([
					'id_ujian' => $id_ujian
				]);
				$a['soalUjian'] = $jumlahSoal;
				$a['idUjian'] = $id_ujian;
				$a['navigasiSoal'] = $navigasiSoal;
				// print_r($a);exit;				
			
				$this->load->view('ujian_essay/v_ujian', $a);
			} else {
				//redirect('ujian/sudah_selesai_ujian/'.$id_ujian);
		}
	}

	public function checkJawabanSoal()
	{
		$post = $this->input->post();
		$idSoal = $post['idSoal'];

		// Get
		$result = $this->m_jawaban_essay->get_by([
			'id_soal' => $post['idSoal'],
			'id_ujian' => $post['idUjian']
		]);

		$file = NULL;
		if(!empty($result)) {
			if(!is_null($result->file)) {
				$file = getMediaOpsiFile($result->file, $this->_fileJawabanPath);
			}

			$this->sendAjaxResponse([
				'status' => TRUE,
				'data' => [
					'jawaban' => $result->jawaban,
					'file' => $file
				]
			], 200);
		}
		else {
			$this->sendAjaxResponse([
				'status' => TRUE,
				'data' => [
					'jawaban' => NULL,
					'file' => $file
				]
			], 200);	
		}
	}

	/*
	* Method for use update one data when student click next on essay exercise
	* @return json
	*/
	public function updateJawaban()
	{
		$post = $this->input->post();
		
		// Get id ujian
		$soalEssay = $this->m_soal_ujian_essay->get_by(['id' => $post['idSoal']]);

		// Get id soal => 1,2,34,2
		$soals = $this->m_soal_ujian_essay->get_many_by(['id_ujian' => $soalEssay->id_ujian]);
		$listSoal = [];
		foreach($soals as $soal) {
			array_push($listSoal, $soal->id);
		}

		// Get data detail ujian
		$detailUjian = $this->m_ujian->get_by(['uji.id' => $soalEssay->id_ujian]);

		// Update to table tb_jawaban_essay
		$dataJawaban = [
			'id_ujian' 	    => $soalEssay->id_ujian,
			'id_user' 	    => $this->akun->id,
			'id_soal'		=> $post['idSoal'],
			'ragu'			=> $post['ragu'] == 'Y' ? 'Y' : 'N'
		];

		// Check jika siswa mengisi jawaban
		if(!is_null($post['jawaban'])) {
			$dataJawaban['jawaban'] = trim($post['jawaban']);
		}

		// Check jika siswa upload file untuk jawabannya
		if(isset($_FILES['file'])) {
			// Set Config
			$fileName = uniqid() . $_FILES['file']['name'];
			$config['upload_path']   = $this->_fileJawabanPath;
            $config['allowed_types'] = 'pdf|pdfx|doc|docx|xlsx|xls|jpg|jpeg|png';
            $config['max_size']      = 10240; // 10 MB
            $config['file_name']     = $fileName;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if(!$this->upload->do_upload('file')) {
            	$this->sendAjaxResponse([
            		'status' => FALSE,
            		'msg' => $this->upload->display_errors()
            	], 500);
            	exit;
            }
            else {
            	$dataJawaban['file'] = $fileName;
            	$dataJawaban['file_type'] = $_FILES['file']['type'];

            	// Hapus file sebelumnya
            	$getData = $this->m_jawaban_essay->get_by(['id' => $post['id']]);
            	if(file_exists( base_url($this->_fileJawabanPath . $getData->file) )) {
            		unlink($this->_fileJawabanPath . $getData->file);
            	}
            }
		}

		$update = $this->m_jawaban_essay->update($dataJawaban, ['id' => $post['id']]);
		if(!$update) {
			$this->sendAjaxResponse([
        		'status' => FALSE,
        		'msg' => 'Gagal mengupdate data jawaban'
        	], 500);
        	exit;	
		}
		else {
			$this->sendAjaxResponse([
				'status' => TRUE,
				'msg' => 'Jawaban berhasil di update' 
			], 200);
		}
	}

	/*
	* Method for use insert one data when student click next on essay exercise
	* @return json
	*/
	public function insertJawaban()
	{
		$post = $this->input->post();

		// Get id ujian
		$soalEssay = $this->m_soal_ujian_essay->get_by(['id' => $post['idSoal']]);

		// Get id soal => 1,2,34,2
		$soals = $this->m_soal_ujian_essay->get_many_by(['id_ujian' => $soalEssay->id_ujian]);
		$listSoal = [];
		foreach($soals as $soal) {
			array_push($listSoal, $soal->id);
		}

		// Get data detail ujian
		$detailUjian = $this->m_ujian->get_by(['uji.id' => $soalEssay->id_ujian]);
		
		// Insert to table m_ikut_ujian_essay
		$data = [
			'id_ujian' 	  => $soalEssay->id_ujian,
			'id_user' 	  => $this->akun->id,
			'list_soal'   => join($listSoal, ','),
			'tgl_mulai'   => $detailUjian->tgl_mulai,
			'tgl_selesai' => $detailUjian->terlambat,
			'status' 	  => 'Y',
			'banyak'	  => 1
		];
		$this->m_ikut_ujian_essay->insert($data);
		$idJawabanEssay = $this->db->insert_id();

		// Insert to table tb_jawaban_essay
		$dataJawaban = [
			'id_ujian' 	    => $soalEssay->id_ujian,
			'id_user' 	    => $this->akun->id,
			'id_ikut_essay' => $idJawabanEssay,
			'id_soal'		=> $post['idSoal'],
			'ragu'			=> $post['ragu'] == 'Y' ? 'Y' : 'N'
		];

		// Check jika siswa mengisi jawaban
		if(!is_null($post['jawaban'])) {
			$dataJawaban['jawaban'] = trim($post['jawaban']);
		}
		
		// Check jika siswa upload file untuk jawabannya
		if(isset($_FILES['file'])) {
			// Set Config
			$fileName = uniqid() . $_FILES['file']['name'];
			$config['upload_path']   = $this->_fileJawabanPath;
            $config['allowed_types'] = 'pdf|pdfx|doc|docx|xlsx|xls|jpg|jpeg|png';
            $config['max_size']      = 10240; // 10 MB
            $config['file_name']     = $fileName;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if(!$this->upload->do_upload('file')) {
            	$this->sendAjaxResponse([
            		'status' => FALSE,
            		'msg' => 'Upload file gagal',
            		'info' => $this->upload->display_errors()
            	], 500);
            	exit;
            }
            else {
            	$dataJawaban['file'] = $fileName;
            	$dataJawaban['file_type'] = $_FILES['file']['type'];
            }
		}

		$insert = $this->m_jawaban_essay->insert($dataJawaban);
		if(!$insert) {
			$this->sendAjaxResponse([
        		'status' => FALSE,
        		'msg' => 'Gagal memasukan data jawaban'
        	], 500);
        	exit;	
		}
		else {
			$this->sendAjaxResponse([
				'status' => TRUE,
				'msg' => 'Jawaban berhasil di masukkan' 
			], 200);
		}
	}

	/*
	* Jika sudah klik tombol selesai ujian atau ujian habis
	*/
	public function saveEndUjian()
	{
		$post = $this->input->post();

		$this->m_ikut_ujian_essay->update([
			'status' => 'N',
			'tgl_selesai' => date('Y-m-d H:i:s'),
			'status_ujian' => 1
		], ['status' => 'Y', 'id_ujian' => $post['idUjian'], 'id_user' => $this->akun->id ]);

		$this->sendAjaxResponse([
			'status' => TRUE,
			'msg' => 'Selamat anda telah menyelesaikan ujian ini, semoga mendapat hasil yang memuaskan :)'
		], 200);
	}

	public function simpan_satu_ujian($id_ujian,$id_pengguna=NULL)
	{
			// $p			= json_decode(file_get_contents('php://input'));
			$post = $this->input->post();
			// print_r($_FILES);
			// print_r($post);exit;
			$update_ 	= "";
			for ($i = 1; $i < $post['jml_soal']; $i++) {
				$_tjawab 	= "opsi_".$i;
				$_tidsoal 	= "id_soal_".$i;
				$_ragu 		= "rg_".$i;
				$isi        = 'isi_'.$i;
				$jawaban_ 	= empty($post[$isi]) ? "" : $post[$isi];
				$update_	.= "".$post[$_tidsoal].":".$jawaban_.":".$post[$_ragu].",";

				$datas = [
					'id_soal'  =>$post[$_tidsoal],
					'jawaban'  => $jawaban_,
					'ragu'     => $post[$_ragu]
				];
				if(isset($_FILES['file_' . $i])) {
					$fileName = uniqid() . $_FILES['file']['name'];
					$config['upload_path']   = $this->_fileJawabanPath;
	                $config['allowed_types'] = 'pdf|pdfx|doc|docx|xlsx|xls|jpg|jpeg|png';
	                $config['max_size']      = 10240; // 10 MB
	                $config['file_name']     = $fileName;
	                $this->load->library('upload', $config);
	                $this->upload->initialize($config);
	                if (!$this->upload->do_upload('file_' . $i)) {
	                	$this->sendAjaxResponse([
	                		'status' => FALSE,
	                		'msg' => 'Upload error, ' . $this->upload->display_errors(),
	                		'info' => $this->upload->display_errors()
	                	], 500);
	                	exit;
	                }
	                else {
	                	$uploadedData = $this->upload->data();
	                	$datas['file'] = $this->_fileJawabanPath . $fileName;
	                	$datas['file_type'] = $_FILES['file']['type'];
	                }
				}
				
				$this->m_jawaban_essay->update($datas,['id_soal'=>$post[$_tidsoal],'id_ujian'=>$id_ujian,'id_user'=>$this->akun->id]);
			}

			$update_		= substr($update_, 0, -1);
			$q_ret_urn 	= $this->m_jawaban_essay->get_many_by(['id_ujian'=>$id_ujian,'id_user'=>$this->akun->id]);

			foreach ($q_ret_urn as $key => $value) {
				$idx 		= $value->id_soal;
				$val 		= $value->jawaban.'_'.$value->ragu;
				$hasil[]= $val;
			}
			$d['data'] = $hasil;
			$d['status'] = "ok";
			j($d);
			exit;	
		}



		public function simpan_akhir_ujian($id_ujian){



			$this->db->query("UPDATE tb_ikut_ujian_essay SET  status = 'N',tgl_selesai= '".date('Y-m-d H:i:s')."' WHERE status = 'Y' AND id_ujian = '$id_ujian' AND id_user = '".$this->akun->id."'");

			

			$cek = $this->db->query("SELECT * from tb_ikut_ujian_essay where id_ujian = " . $id_ujian . " and id_user = " . $this->akun->id . "");

			$cek_ujian_pertama = $this->db->query("SELECT * from tb_ikut_ujian_essay_pertama where id_ujian = " . $id_ujian . " and id_user = " . $this->akun->id . "");



			if($cek_ujian_pertama->num_rows() == 1 ) {

				if($cek->num_rows() > 0) {

					$this->db->query("UPDATE tb_ikut_ujian_essay_pertama SET  status = 'N' WHERE status = 'Y' AND id_ujian = '$id_ujian' AND id_user = '".$this->akun->id."'");

				}



				$this->session->set_userdata(array('selesai_ujian'=>1));





			}

			$a['status'] = "ok";

			j($a);

			exit;

		}



		public function result($id,$mapel=null) {

			$this->page_title = 'Ujian Essay';

			$data = array(

				'id_ujian' => decrypt_url($id),
				'searchFilter' => ['Nama Siswa', 'Kelas']

			);



			$this->render('ujian_essay/list_hasil', $data);



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

			$q_cek_sdh_ujian= $this->db->query("SELECT id FROM tb_ikut_ujian_essay WHERE id = '$id' AND id_ujian = '$id_ujian' AND id_user = '".$this->akun->id."'");

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


	public function ikut_ujian_hasil($id_ujian = 0,$id_user=0) {
		$id_ujian = decrypt_url($id_ujian);
		$id_user = decrypt_url($id_user);;

		$this->cek_aktif();		

		$essay = $this->m_ikut_ujian_essay->get_by(['id_ujian'=>$id_ujian,'id_user'=>$id_user,'status'=>'N']);
		$jwb_essay = $this->m_jawaban_essay->get_many_by(['id_ujian' => $id_ujian]);

			$arr_jawab = array();

				foreach ($jwb_essay as $rows) {

				  $idx = $rows->id_soal;

				  $val = $rows->jawaban;

				  $rg = $rows->ragu;

				  $arr_jawab[$idx] = array("j"=>$val,"r"=>$rg);

				}

			$no =1;

			// print_r($jwb_essay);exit;
			$html = '';
			if (!empty($jwb_essay)) {

				foreach ($jwb_essay as $rows) { 



					$idx = $rows->id_soal;
	  
					$val = $rows->jawaban;
	  
					$rg = $rows->ragu;
	  
					$arr_jawab[$idx] = array("j"=>$val,"r"=>$rg);
	  
					  
					
					$rows->id;

					$soal = $this->m_soal_ujian_essay->get_by(['id'=>$rows->id_soal]);

					$soal_ = str_replace('<p>','', $soal->soal);
					
					if(empty($soal->file)){
						$tampil_media = NULL;
					}else{
						$tampil_media = tampil_media("./upload/file_ujian_soal/".$soal->file, '250px','auto');
					}
					

					$vrg = $rg == "" ? "N" : $rg;

				
					$html .= '<input type="hidden" name="id_soal_'.$no.'" value="'.$rows->id.'">';

					$html .= '<input type="hidden" name="rg_'.$no.'" id="rg_'.$no.'" value="'.$vrg.'">';

					$html .= '<div class="form-group" style="border:1px #000 solid; padding:10px;">';
					$html .= '  <label>'.$no.'.'.$soal_.''.$tampil_media.' </label>';
					$html .= !is_null($rows->file) ? '<br>'.getMediaOpsiFile($rows->file, $this->_fileJawabanPath) . '<br><br>' : '';
					$html .= '<textarea class="form-control nilai" readonly>Jawaban : '.$val.'</textarea>';
					$html .= '<div style=" padding:10px 0px;"><label>Nilai</label> <input type="text" value="'.$rows->nilai.'" data-soal ="'.$rows->id_soal.'"  data-ujian ="'.$rows->id_ujian.'"  data-user ="'.$rows->id_user.'" data-bobot ="'.$soal->bobot.'" maxlength="3" class="only-number nilai"> <button type="button" data-soal="'.$rows->id_soal.'" data-nilai="'.$rows->nilai.'" data-ujian="'.$rows->id_ujian.'" data-user="'.$rows->id_user.'" data-bobot="'.$soal->bobot.'" class="beri-nilai btn btn-primary">Update Nilai</button> </div>';
					$html .= '</div>';

					$no++;

				}

			}

			
			$a['jam_mulai'] = $essay->tgl_mulai;
			$a['jam_selesai'] = $essay->tgl_selesai;
			$a['id_ujian'] = $essay->id_ujian;
			$a['no'] = $no;
			$a['html'] = $html;
			$this->load->view('ujian_essay/hasil_essay', $a);
	}

	public function beri_nilai()
	{

		$post = $this->input->post();
		$datas = [
			'nilai'  =>$post['nilai'],
		];

		$kirim = $this->m_jawaban_essay->update($datas,['id_soal'=>$post['id_soal'],'id_ujian'=>$post['id_ujian'],'id_user'=>$post['id_user']]);

		echo json_encode(['send'=>$kirim]);

	}

	public function update_status_siswa() {
		$post = $this->input->post();
		$status = $post['status'];
		$id = $post['id'];
		$update = $this->m_ikut_ujian_essay->update([
			'status_siswa' => $status
		], ['id' => $id]);

		if($update) {
			$this->sendAjaxResponse([
				'status' => TRUE,
				'msg'	 => 'Data berhasil diperbaharui'
			], 200);
		}
		else {
			$this->sendAjaxResponse([
				'status' => FALSE,
				'msg'	 => 'Data gagal diperbaharui'
			], 500);	
		}
	}

	public function import_soal($id_ujian) {
		$data = [ 'id_ujian' => $id_ujian, 'back_url' => base_url('ujian_essay/data_soal/') . $id_ujian];

		$this->render('ujian_essay/import_soal', $data);
	}


	/*
	* return @json
	* Hapus Hasil ujian siswa
	*/
	public function delete_hasil_ujian() {
		$post = $this->input->post();

		foreach ($post['id'] as $val) {
			$where[] = $val;
		}

		$this->db->trans_begin();

		$delete = $this->m_ikut_ujian_essay->delete_wherein('id', $where);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		}
		else {
			$this->db->trans_commit();
		}

		if($delete) {
			$this->sendAjaxResponse([
				'status' => TRUE,
				'msg' => 'Berhasil menghapus data'
			], 200);
		}
		else {
			$this->sendAjaxResponse([
				'status' => FALSE,
				'msg' => 'Gagal menghapus data'
			], 500);
		}
	}
}