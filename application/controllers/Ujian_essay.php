<?php

 defined('BASEPATH') OR exit('No direct script access allowed');



class Ujian_essay extends MY_Controller {



    function __construct() {

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

			$kelas = $this->m_kelas->get_all();

		}

		

		$data = array(

			'tipe_ujian' => $tipe_ujian, 

			'kelas' => $kelas

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



		if ($this->log_lvl == 'guru') {

			$where['kls.id_trainer'] = $this->akun->id;

		}

		

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



	function simpan_soal(){



			$p = $this->input->post();

			$pembuat_soal = ($this->log_lvl == "admin") ? $p['id_guru'] : $this->log_id;

			$pembuat_soal_u = ($this->log_lvl == "admin") ? ", id_guru = '".$p['id_guru']."'" : "";

			//etok2nya config

			$folder_gb_soal = "./upload/file_ujian_soal_essay/";


			$buat_folder_gb_soal = !is_dir($folder_gb_soal) ? @mkdir("./upload/file_ujian_soal_essay/") : false;



			$allowed_type 	= array(
				
				"image/jpeg",
				"image/png",
				"image/gif",
				"audio/mpeg",
				"audio/mpg",
				"audio/mpeg3", "audio/mp3", "audio/x-wav", "audio/wave", "audio/wav","video/mp4", "application/octet-stream");



			$gagal 		= array();

			$nama_file 	= array();

			$tipe_file 	= array();



			//get mode

			$__mode = $p['mode'];

			$__id_soal = 0;

			//ambil data post sementara

			$pdata = array(

				"bobot"=>$p['bobot'],

				"soal"=>$p['soal'],

				'id_ujian' => $p['id_ujian']

			);



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

				} else if ($file_name == "") {

					$gagal[$k] = "Tidak ada file yang diupload";

					$nama_file[$k]	= "";

					$tipe_file[$k]	= "";					

				} else {

					$ekstensi = explode(".", $file_name);



					$file_name = $k."_".$__id_soal.".".$ekstensi[1];
					
					@move_uploaded_file($file_tmp, $folder_gb_soal.$file_name);

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

										a.status_token, b.nama nmguru, c.nama nmmapel,

										(case

										when (now() < a.tgl_mulai) then 0

										when (now() >= a.tgl_mulai and now() <= a.terlambat) then 1

										else 2

										end) statuse

										")

								->from('tb_ujian a')

								->join('tb_kelas kls','kls.id = a.id_kelas')

								->join('m_guru b','kls.id_trainer = b.id')

								->join(' m_mapel c','kls.id_mapel = c.id')

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
			$jwb = [];


			if ($this->session->userdata('selesai_ujian') == 1) {

				redirect(base_url('ujian_real/'));

				exit;

			}

			

			header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");

			header("Cache-Control: post-check=0, pre-check=0", false);

			header("Pragma: no-cache");

			

	

			$cek_sdh_selesai = $this->m_ikut_ujian_essay->count_by(['id_ujian'=>$id_ujian,'id_user'=>$this->akun->id,'status'=>'N']);



		

			//sekalian validasi waktu sudah berlalu...

			if ($cek_sdh_selesai <= $this->total_ujian) {

				//ini jika ujian belum tercatat, belum ikut

				//ambil detil soal



				$cek_detil_tes = $this->m_ujian->get_by(['uji.id'=>$id_ujian]);





				$ikut_ujian = $this->m_ikut_ujian_essay->get_by(['id_ujian'=>$id_ujian,'id_user'=>$this->akun->id]);
			
				$cek_sdh_ujian	= $this->m_ikut_ujian_essay->count_by(['id_ujian'=>$id_ujian,'id_user'=>$this->akun->id]);

				

				$acakan = $cek_detil_tes->jenis == "ORDER BY id ASC";



				// $total_session = $this->db->where(array('id_guru'=>$cek_detil_tes->id_guru,'id_mapel'=>$cek_detil_tes->id_mapel))->get('tb_ujian')->result();

				// $nox=1;

				/*if (count($total_session) > 1) {

					foreach ($total_session as $row) {

						$datas[$row->id] = $nox;

						$nox++;

					}

					$offset = 0;

					$counts = $this->db->select('jumlah_soal')->limit($datas[$cek_detil_tes->id])->get('tb_ujian')->result();

					print_r($counts);

					foreach ($counts as $rows) {

						$offset += $rows->jumlah_soal;

					}

				

				}else{

					$offset = 0;

				}*/



				

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



					$urut_soal 		= explode(",", $q_ambil_soal->list_jawaban);

					

					$soal_urut_ok	= array();

					for ($i = 0; $i < sizeof($urut_soal); $i++) {

						$pc_urut_soal = explode(":",$urut_soal[$i]);

						$pc_urut_soal1 = empty($pc_urut_soal[1]) ? "''" : "'".$pc_urut_soal[1]."'";

						$ambil_soal = $this->db->query("SELECT *, $pc_urut_soal1 AS jawaban FROM m_soal_ujian WHERE id = '".$pc_urut_soal[0]."'")->row();



						$soal_urut_ok[] = $ambil_soal; 

					}

					

					$jwb_essay = $this->m_jawaban_essay->get_many_by(['id_ikut_essay'=>$q_ambil_soal->id]);

					$soal_urut_ok = $soal_urut_ok;

				}


				$html = '';

				$no = 1;

			

				$arr_jawab = array();

				foreach ($jwb_essay as $rows) {

				  $idx = $rows->id_soal;

				  $val = $rows->jawaban;

				  $rg = $rows->ragu;

				  $arr_jawab[$idx] = array("j"=>$val,"r"=>$rg);

				}


			

				if (!empty($soal_urut_ok)) {

					

				    foreach ($soal_urut_ok as $d) { 

				    	 $d->id;

				        $tampil_media = tampil_media("./upload/file_ujian_soal/".$d->file, '250px','auto');

						$vrg = $arr_jawab[$d->id]["r"] == "" ? "N" : $arr_jawab[$d->id]["r"];
						$val = $arr_jawab[$d->id]["j"];
				

				        $html .= '<input type="hidden" name="id_soal_'.$no.'" value="'.$d->id.'">';

				        $html .= '<input type="hidden" name="rg_'.$no.'" id="rg_'.$no.'" value="'.$vrg.'">';

				        $html .= '<div class="step" id="widget_'.$no.'">';

						$html .= $d->soal.'<br>'.$tampil_media.'<div class="funkyradio">';
						$html .= '<textarea class="form-control" name="isi_'.$no.'">'.$val.'</textarea><br>';
				        $html .= '</div></div>';

				        $no++;

				    }

				}

			



				$a['jam_mulai'] = $ikut->tgl_mulai;

				$a['jam_selesai'] = $ikut->tgl_selesai;

				$a['id_tes'] = $cek_detil_tes->id;

				$a['no'] = $no;

				$a['html'] = $html;



			

				$this->load->view('ujian_essay/v_ujian', $a);

			} else {

				//redirect('ujian/sudah_selesai_ujian/'.$id_ujian);

			}


		}



		public function simpan_satu_ujian($id_ujian,$id_pengguna=NULL){

			$p			= json_decode(file_get_contents('php://input'));

		
			$update_ 	= "";

			for ($i = 1; $i < $p->jml_soal; $i++) {
				$isi = 
				$_tjawab 	= "opsi_".$i;

				$_tidsoal 	= "id_soal_".$i;

				$_ragu 		= "rg_".$i;

				$isi        = 'isi_'.$i;

				$jawaban_ 	= empty($p->$isi) ? "" : $p->$isi;

				$update_	.= "".$p->$_tidsoal.":".$jawaban_.":".$p->$_ragu.",";

				$datas = [
					'id_soal'  =>$p->$_tidsoal,
					'jawaban'  => $jawaban_,
					'ragu'     => $p->$_ragu
				];

				$this->m_jawaban_essay->update($datas,['id_soal'=>$p->$_tidsoal,'id_ujian'=>$id_ujian,'id_user'=>$this->akun->id]);


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



			// $get_jawaban = $this->db->query("SELECT list_jawaban FROM tb_ikut_ujian_essay WHERE status = 'Y' AND id_ujian = '$id_ujian' AND id_user = '".$this->akun->id."'")->row_array();

			// $pc_jawaban = explode(",", $get_jawaban['list_jawaban']);

			// $jumlah_benar 	= 0;

			// $jumlah_salah 	= 0;

			// $jumlah_ragu  	= 0;

			// $nilai_bobot 	= 0;

			// $total_bobot	= 0;

			// $jumlah_soal	= sizeof($pc_jawaban);



			// for ($x = 0; $x < $jumlah_soal; $x++) {

			// 	$pc_dt = explode(":", $pc_jawaban[$x]);

			// 	$id_soal 	= $pc_dt[0];

			// 	$jawaban 	= $pc_dt[1];

			// 	$ragu 		= $pc_dt[2];

			// 	$cek_jwb 	= $this->db->query("SELECT bobot FROM m_soal_ujian_essay WHERE id = '".$id_soal."'")->row();

			// 	$total_bobot = $total_bobot + $cek_jwb->bobot;

				

			// 	if (($cek_jwb->jawaban == $jawaban)) {

			// 		//jika jawaban benar 

			// 		$jumlah_benar++;

			// 		$nilai_bobot = $nilai_bobot + $cek_jwb->bobot;

			// 		$q_update_jwb = "UPDATE m_soal_ujian_essay SET jml_benar = jml_benar + 1 WHERE id = '".$id_soal."'";

			// 	} else {

			// 		//jika jawaban salah

			// 		$jumlah_salah++;

			// 		$q_update_jwb = "UPDATE m_soal_ujian_essay SET jml_salah = jml_salah + 1 WHERE id = '".$id_soal."'";

			// 	}

			// 	$this->db->query($q_update_jwb);

			// }



			// $nilai = ($jumlah_benar / $jumlah_soal)  * 100;

			// $nilai_bobot = ($nilai_bobot / $total_bobot)  * 100;

			
			// Update status siswa jika nilainya lulus
			// $is_graduted = $this->m_ujian->get_by(['uji.id' => $id_ujian]);
			// if(!is_null($is_graduted)) {
			// 	if($nilai >= $is_graduted->min_nilai) {
			// 		$this->db->update('m_siswa', ['is_graduated' => 1],['id' => $this->akun->id]);
			// 	}
			// }


			//$a_banyak		= $this->db->query("SELECT SUM(banyak) AS jumlah FROM tb_ikut_ujian")->row();

			//$this->db->query("UPDATE tb_ujian SET penggunaan = '$a_banyak->jumlah' WHERE id = '$id_ujian' ");



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

	

			$data = array(

				'id_ujian' => decrypt_url($id)

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
		cek_hakakses(array("guru"), $this->session->userdata('admin_level'));
		
		

			$essay = $this->m_ikut_ujian_essay->get_by(['id_ujian'=>$id_ujian,'id_user'=>$id_user,'status'=>'N']);
			$jwb_essay = $this->m_jawaban_essay->get_many_by(['id_ikut_essay'=>$essay->id]);

			$arr_jawab = array();

				foreach ($jwb_essay as $rows) {

				  $idx = $rows->id_soal;

				  $val = $rows->jawaban;

				  $rg = $rows->ragu;

				  $arr_jawab[$idx] = array("j"=>$val,"r"=>$rg);

				}

			$no =1;

		
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
					$html .= '<textarea class="form-control" readonly>Jawaban : '.$val.'</textarea>';
					$html .= '<div style=" padding:10px 0px;"><label>Nilai</label> <input type="text" value="'.$rows->nilai.'" data-soal ="'.$rows->id_soal.'"  data-ujian ="'.$rows->id_ujian.'"  data-user ="'.$rows->id_user.'" data-bobot ="'.$soal->bobot.'" maxlength="3" class="only-number nilai"></div>';
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

}