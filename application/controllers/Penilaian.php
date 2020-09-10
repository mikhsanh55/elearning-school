<?php

 defined('BASEPATH') OR exit('No direct script access allowed');



class Penilaian extends MY_Controller {

	/*
	* path untuk file soal
	*/
	protected $_fileSoalPath = 'upload/file_penilaian_soal/';

	/*
	* path untuk file opsi (a, b, c, d, e)
	*/
	protected $_fileOpsiPath = 'upload/file_penilaian_opsi/';

    function __construct() {

        parent::__construct();

        $this->load->model('m_penilaian');

        $this->load->model('m_instansi');

        $this->load->model('m_mapel_cs');

        $this->load->model('m_guru');

        $this->load->model('m_soal_penilaian');

		$this->load->model('m_ikut_penilaian');

		$this->load->model('m_kelas');

		$this->load->model('m_paket_soal');

		$this->load->model('m_dimensi');		

		$this->opsi = array("a","b","c","d","e");

		$this->jml_opsi = 5;

	}



	public function index(){

		$data = array(

			'searchFilter' => array('Nama Penilaian','Kelas'),

			'tipe_ujian'   => $tipe_ujian = array(''=>'Semua','uts'=>'UTS','uas'=>'UAS')

		);

		$this->render('penilaian/list',$data);

	}



	public function result_chart($id_penilaian=0){

		$id_penilaian = decrypt_url($id_penilaian);

		$penilaian = $this->db->where('id_penilaian',$id_penilaian)->get('tb_ikut_penilaian')->result();

		if(empty($penilaian)){

		    redirect(base_url('penilaian'));

		}

	    

		$pasis = 0;

		$jwb_a = 0;

		$jwb_b = 0;

		$jwb_c = 0;

		$jwb_d = 0;

		$jwb_e = 0;

		foreach($penilaian as $chart){

			$pasis += 1;



				$i=1;

				$x=0;

				$jawaban = explode(',',$chart->list_jawaban);



				foreach($jawaban as $jwb1){

					//substr($list_jw_soal, 0, -1);

					$soal = substr($jwb1,0, 1);

					$jwb = substr($jwb1,-3);

					$jwb = substr($jwb,0,-2);



					$soal_ke = 'Q'.$i;

				  

					if($jwb == 'A'){

						$jwb_a +=1;

					}else if ($jwb == 'B'){

						$jwb_b +=1;

					}else if ($jwb == 'C'){

						$jwb_c +=1;

					}else if ($jwb == 'D'){

						$jwb_d +=1;

					}else if ($jwb == 'E'){

						$jwb_e +=1;

					}



					$jwb_set[$pasis][0][] = $jwb_a;

					$jwb_set[$pasis][1][] = $jwb_b;

					$jwb_set[$pasis][2][] = $jwb_c;

					$jwb_set[$pasis][3][] = $jwb_d;

					$jwb_set[$pasis][4][] = $jwb_e;



					$labels[$x] = $soal_ke;



					$jwb_a = 0;

					$jwb_b = 0;

					$jwb_c = 0;

					$jwb_d = 0;

					$jwb_e = 0;



					$i++;

					$x++;

						

				}

			



		}

		

	

	$A = 0;

	$B = 0;

	$C = 0;

	$D = 0;

	$E = 0;

	

	$ke = count($labels);

	for ($x=0; $x < $ke ; $x++) { 

		for ($i=1; $i <= $pasis; $i++) { 

		

		

				

				$A += $jwb_set[$i][0][$x];

				$B += $jwb_set[$i][1][$x];

				$C += $jwb_set[$i][2][$x];

				$D += $jwb_set[$i][3][$x];

				$E += $jwb_set[$i][4][$x];

				



				



				$set_[0][$x] = $A;

				$set_[1][$x] = $B;

				$set_[2][$x] = $C;

				$set_[3][$x] = $D;

				$set_[4][$x] = $E;

		

		}

		

		$A = 0;

		$B = 0;

		$C = 0;

		$D = 0;

		$E = 0;

		

	}



	



	

	$skor = 0;

	$skor_smt = 0;



	foreach ($set_ as $jwb => $value) {

		foreach ($value as $index => $rws) {

			$skor_smt += $rws;

		}

		

			if($jwb == 0){

				$skor += 5 * $skor_smt ;

			}else if ($jwb == 1){

				$skor += 4 * $skor_smt ;

			}else if ($jwb == 2){

				$skor +=3 * $skor_smt;

			}else if ($jwb == 3){

				$skor +=2 * $skor_smt;

			}else if ($jwb == 4){

				$skor +=1 * $skor_smt;

			}



			$skor_smt = 0;

	}

		

		$warna = ['green','blue','red','orange','yellow'];

		$opsi = ['A','B','C','D','E'];

	

		$pen = $this->m_penilaian->get_by(['pen.id'=>$id_penilaian]);

	

		$data = array(

			'labels' => $labels,

			'jwb_set' => $set_,

			'total' => count($labels),

			'warna' => $warna,

			'opsi' => $opsi,

			'detail' => $pen,

			'skor' => $skor

		);

		$this->render('penilaian/result',$data);

	}



	public function data_soal($id=null){

		$url = base_url('penilaian/form_soal/'.$id);



		$data = array(

			'searchFilter' => array('Modul Pelatihan','Trainer'),

			'url_form' => $url,

			'url_import' => base_url('penilaian/form_import/'.$id),

			'id_paket' => decrypt_url($id)

		);

		$this->render('penilaian/list_soal',$data);

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

		$data = array(

			'tipe_ujian' => $tipe_ujian, 

			'kelas' => $kelas,

			'guru' => $this->m_guru->get_all(['guru.instansi' => $this->akun->instansi]),

			'paket' => $this->m_paket_soal->get_all(['id_instansi' => $this->akun->instansi])

		);

		$this->render('penilaian/add',$data);
	}



	public function edit($id=0){

		

		if ($this->log_lvl == 'instansi' || $this->log_lvl == 'admin_instansi'){

			$kelas = $this->m_kelas->get_many_by(['kls.id_instansi'=>$this->akun->instansi]);

		} else {

			$kelas = $this->m_kelas->get_all(['kls.id_instansi' => $this->akun->instansi]);

		}



		$id = decrypt_url($id);

		$data = array(

			'kelas' => $kelas,

			'guru' => $this->m_guru->get_all(['guru.instansi' => $this->akun->instansi]),

			'edit' => $this->m_penilaian->get_by(['pen.id'=>$id])
		);
		// print_r($data['edit']);exit;

		$this->render('penilaian/edit',$data);
	}

	public function form_import($id_paket_soal){
		$data = array(
			'back_url' => base_url('penilaian/data_soal/'.$id_paket_soal.''),
			'url_import' => base_url('import/soal-penilaian/'.$id_paket_soal.''),
			'id_paket_soal' => decrypt_url($id_paket_soal)
		);

		$this->render('penilaian/form_import',$data);
	}

	public function get_mp(){

		$post = $this->input->post();
		$select = '<option disabled="disabled" selected="selected">Pilih</option>';
		$mp = $this->m_mapel->get_many_by(array('id_instansi'=>$post['id_instansi']));
		$post['id_mp'] = empty($post['id_mp']) ? NULL : $post['id_mp'];
		foreach ($mp as $key => $rows) {
			if ($post['id_mp'] == $rows->id) {
				$select .= '<option value="'.$rows->id.'" selected="selected">'.$rows->nama.'</option>';
			} else {
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

		$data = [
			'id_kelas'		=> $post['id_kelas'],
			'id_guru'		=> $post['id_guru'],
			'id_mapel'		=> $post['id_mapel'],
			'id_paket_soal'		=> $post['id_paket'],
			'nama_ujian'  	=> $post['nama_ujian'],
			'jumlah_soal'  	=> 0,
			'waktu'  		=> $post['waktu_ujian'],
			'nama_ujian'  	=> $post['nama_ujian'],
			'jenis'  		=> 'set',
			'tgl_mulai'		=> date_default($post['tgl_mulai']).' '.$post['waktu_mulai'],
			'terlambat'		=> date_default($post['tgl_selesai']).' '.$post['waktu_selesai']
		];

		$kirim = $this->m_penilaian->insert($data);

		if ($kirim) {
			$json['status']  = TRUE;
			$json['msg'] = 'Edit penilaian berhasil';
			$responseCode = 200;

		}else{
			$json['status']  = FALSE;
			$json['msg'] = 'Edit penilaian gagal';
			$responseCode = 500;
		}

		$this->sendAjaxResponse($json, $responseCode);
	}

	public function update(){

		$post = $this->input->post();

		$data = [
			'id_kelas'		=> $post['id_kelas'],
			'id_guru'		=> $post['id_guru'],
			'id_mapel'		=> $post['id_mapel'],
			'nama_ujian'  	=> $post['nama_ujian'],
			'jumlah_soal'  	=> 0,
			'waktu'  		=> $post['waktu_ujian'],
			'nama_ujian'  	=> $post['nama_ujian'],
			'jenis'  		=> 'set',
			'tgl_mulai'		=> date_default($post['tgl_mulai']).' '.$post['waktu_mulai'],
			'terlambat'		=> date_default($post['tgl_selesai']).' '.$post['waktu_selesai']
		];

		$kirim = $this->m_penilaian->update($data,array('id'=>$post['id']));

		if ($kirim) {
			$json['status']  = TRUE;
			$json['msg'] = 'Edit penilaian berhasil';
			$responseCode = 200;

		}else{
			$json['status']  = FALSE;
			$json['msg'] = 'Edit penilaian gagal';
			$responseCode = 500;
		}

		$this->sendAjaxResponse($json, $responseCode);
	}

	

	public function laporan($output = 1) {

	    $this->cek_aktif(); // check login session

	    if($this->session->userdata('admin_level') == 'siswa' || $this->session->userdata('admin_level') == 'guru') {

	        redirect('penilaian');

	    }

	    

	    // Get Data from Model Penilaian

	    if ($this->log_lvl != 'admin') {

			$where['kls.id_instansi'] = $this->akun->instansi;

		}

		if($output === 1) {

			$data = ['datas' => $this->m_penilaian->out1(1,$where,1000), 'tipe_output' => 1];	

		}

		else if($output == 2) {

			$data = ['datas' => $this->m_penilaian->out2(1, $where, 1000), 'tipe_output' => 2];

		}

		else if($output = 3) {

			$data = ['datas' => $this->m_penilaian->out3(1,$where,1000), 'tipe_output' => 3];

		}

		

	    // $this->load->view('penilaian-laporan/list', $data);

	    return $this->m_penilaian->exportExcel($data, 'penilaian-laporan/list', 'Laporan EDOPM - '. 'Output ' . $data['tipe_output'] . '_' . date('d-m-Y'));

	}



	public function page_load($pg = 1){

		$post = $this->input->post();

		$limit = $post['limit'];

		$where = [];

		if (!empty($post['search'])) {

			switch ($post['filter']) {

				case 0:

					$where["(lower(pen.nama_ujian) like '%".strtolower($post['search'])."%' )"] = null;

					break;

				case 1:

					$where["(lower(kls.nama) like '%".strtolower($post['search'])."%' )"] = null;

					break;

				default:

					# code...

					break;

			}

		}
		$where['kls.id_instansi'] = $this->akun->instansi;
		if ($this->log_lvl == 'guru') {
			$where['kls.id_trainer'] = $this->akun->id;
		}

		if ($this->log_lvl == 'siswa') {
			$where['dekls.id_peserta'] = $this->akun->id;
		}

		$paginate = $this->m_penilaian->paginate($pg,$where,$limit);
		$data['paginate'] = $paginate;
		$data['paginate']['url']	= 'penilaian/page_load';
		$data['paginate']['search'] = 'lookup_key';
		$data['page_start'] = $paginate['counts']['from_num'];

		$this->load->view('penilaian/table',$data);
		$this->generate_page($data);
	}



	public function page_load_soal($pg = 1){

		$post = $this->input->post();

		$limit = $post['limit'];

		$where = [];

		



		$where['id_paket'] = $post['id_paket'];



		$paginate = $this->m_soal_penilaian->paginate($pg,$where,$limit);

		$data['paginate'] = $paginate;

		$data['paginate']['url']	= 'penilaian/page_load_soal';

		$data['paginate']['search'] = 'lookup_key';

		$data['page_start'] = $paginate['counts']['from_num'];



		$this->load->view('penilaian/table_soal',$data);

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
		$where['id_user'] = $this->akun->id;

		$paginate = $this->m_ikut_penilaian->paginate($pg,$where,$limit);

		$data['paginate'] = $paginate;
		$data['paginate']['url']	= 'penilaian/page_load_result';
		$data['paginate']['search'] = 'lookup_key';
		$data['page_start'] = $paginate['counts']['from_num'];
		$data['id_ujian'] = $post['id_ujian'];

		$this->load->view('penilaian/table_hasil',$data);
		$this->generate_page($data);
	}

	public function form_soal($id_paket,$id_soal=0) {



		cek_hakakses(array('instansi'), $this->session->userdata('admin_level'));

		

		$a['huruf_opsi'] = array("a","b","c","d","e");

		$a['jml_opsi'] = $this->jml_opsi;



		$a['opsij'] = array(""=>"Jawaban","A"=>"A","B"=>"B","C"=>"C","D"=>"D","E"=>"E");



		$id_guru = $this->log_lvl == "guru" ? "WHERE a.id_guru = '".$this->log_id."'" : "";


		// Determine mode : Add or Update
		if ($id_soal == 0) {

			$a['d'] = array("mode"=>"add","id"=>"0","id_guru"=>$id_guru,"id_mapel"=>"","bobot"=>"1","file"=>"","soal"=>"","opsi_a"=>"#####","opsi_b"=>"#####","opsi_c"=>"#####","opsi_d"=>"#####","opsi_e"=>"#####","jawaban"=>"","tgl_input"=>"");

		}else {

			$a['d'] = $this->db->select("ujian.*, 'edit' AS mode")->where('id',$id_soal)->get('m_soal_penilaian ujian')->row_array();

		}

		$data = array();

		for ($e = 0; $e < $a['jml_opsi']; $e++) {

			$iidata = array();

			$idx = "opsi_".$a['huruf_opsi'][$e];

			$idx2 = $a['huruf_opsi'][$e];



			$pc_opsi_edit = explode("#####", $a['d'][$idx]);

			$iidata['opsi'] = end($pc_opsi_edit);

			$iidata['gambar'] = $pc_opsi_edit[0];

			$data[$idx2] = $iidata;
			// $data[$idx2] = $a['d'][$idx];

		}

		
		// print_r($data);exit;
		$a['id_paket'] = decrypt_url($id_paket);
		$a['url'] = base_url('penilaian/form_soal/') . $id_paket;
		$a['from_url'] = base_url('penilaian/data_soal/') . $id_paket;
		$a['data_pc'] = $data;
		$a['soalPath'] = $this->_fileSoalPath;
		$a['opsiPath'] = $this->_fileOpsiPath;

		// Determine target url for post data
		if($a['d']['id'] != 0) {
			$a['targetUrl'] = base_url('penilaian/update-soal');
		}
		else {
			$a['targetUrl'] = base_url('penilaian/insert-soal');	
		}
		$this->render('penilaian/add_soal',$a);

	}

	/*
	* Function untuk update soal penilaian
	**/
	public function updateSoal()
	{
		$post = $this->input->post();

		$data = [
			'id_paket' => $post['id_paket'],
			'soal' => $post['soal'],
			'opsi_a' => '#####' . $post['opsi_a'],
			'opsi_b' => '#####' . $post['opsi_b'],
			'opsi_c' => '#####' . $post['opsi_c'],
			'opsi_d' => '#####' . $post['opsi_d'],
			'opsi_e' => '#####' . $post['opsi_e'],
			'bobot' => $post['bobot']
		];
		$dataFile = $this->m_soal_penilaian->get_by_array(['id' => $post['id']]);

		if(isset($_FILES)) {
			foreach($_FILES as $key => $value) :
				$fileName = uniqid() . $_FILES[$key]['name'];
				// Upload file gambar opsi
				if($key !== 'file_ujian_soal' && $_FILES[$key]['error'] !== 4) {
					
					// from #####adawd => file.png#####adawd
					$data[$key] = $fileName . $data[$key];

					$config['upload_path']   = $this->_fileOpsiPath;
	                $config['allowed_types'] = 'png|jpg|jpeg|svg';
	                $config['max_size']      = 5120; // 5 MB
	                $config['file_name']     = $fileName;

	                $this->load->library('upload', $config);
	                $this->upload->initialize($config);

	                if(!$this->upload->do_upload($key)) {
	                	$this->session->set_flashdata('error', 'Gagal mengupload file untuk : ' . $key);
	                	redirect($post['url']);
	                	exit;
	                }
	                else {
	                	$getFileName = explode('#####', $dataFile[$key]);
	                	if(!empty($getFileName[0]) && file_exists($this->_fileOpsiPath . $getFileName[0])) { // Jika nama file ada
	                		unlink($this->_fileOpsiPath . $getFileName[0]);
	                	}
	                }
				}
				else if($key === 'file_ujian_soal' && $_FILES[$key]['error'] !== 4) { // Upload file gambar soal
					$data['file'] = $fileName;
					$data['tipe_file'] = $_FILES[$key]['type'];
					$config['upload_path']   = $this->_fileSoalPath;
	                $config['allowed_types'] = 'png|jpg|jpeg|svg';
	                $config['max_size']      = 5120; // 5 MB
	                $config['file_name']     = $fileName;

	                $this->load->library('upload', $config);
	                $this->upload->initialize($config);

	                if(!$this->upload->do_upload($key)) {
	                	$this->session->set_flashdata('error', 'Error saat mengupload gambar soal : ' . $this->upload->display_errors());
	                	redirect($post['url']);
	                	exit;
	                }
	                else {
	                	if(!empty($dataFile['file']) && file_exists($this->_fileSoalPath . $dataFile['file'])) {
	                		unlink($this->_fileSoalPath . $dataFile['file']);
	                	}
	                }
				}
			endforeach;
		}

		$update = $this->m_soal_penilaian->update($data, ['id' => $post['id']]);

		if($update) {
			$this->session->set_flashdata('success', 'Soal berhasil diupdate!');
        	redirect($post['from_url']);
        	exit;
		}
		else {
			$this->session->set_flashdata('error', 'Error saat mengupdate data!');
        	redirect($post['url']);
        	exit;
		}
	}

	/*
	* Function untuk insert soal penilaian
	*/
	public function insertSoal()
	{
		$post = $this->input->post();
		$data = [
			'id_paket' => $post['id_paket'],
			'soal' => $post['soal'],
			'opsi_a' => '#####' . $post['opsi_a'],
			'opsi_b' => '#####' . $post['opsi_b'],
			'opsi_c' => '#####' . $post['opsi_c'],
			'opsi_d' => '#####' . $post['opsi_d'],
			'opsi_e' => '#####' . $post['opsi_e'],
			'bobot' => $post['bobot']
		];

		if(isset($_FILES)) {
			foreach($_FILES as $key => $value) :
				$fileName = uniqid() . $_FILES[$key]['name'];
				if($key !== 'file_ujian_soal' && $_FILES[$key]['error'] !== 4) {
					
					// from #####adawd => file.png#####adawd
					$data[$key] = $fileName . $data[$key];

					$config['upload_path']   = $this->_fileOpsiPath;
	                $config['allowed_types'] = 'png|jpg|jpeg|svg';
	                $config['max_size']      = 5120; // 5 MB
	                $config['file_name']     = $fileName;

	                $this->load->library('upload', $config);
	                $this->upload->initialize($config);

	                if(!$this->upload->do_upload($key)) {
	                	$this->session->set_flashdata('error', 'Gagal mengupload file untuk : ' . $key);
	                	redirect($post['url']);
	                	exit;
	                }
				}
				else if($key === 'file_ujian_soal' && $_FILES[$key]['error'] !== 4) {
					$data['file'] = $fileName;
					$data['tipe_file'] = $_FILES[$key]['type'];
					$config['upload_path']   = $this->_fileSoalPath;
	                $config['allowed_types'] = 'png|jpg|jpeg|svg';
	                $config['max_size']      = 5120; // 5 MB
	                $config['file_name']     = $fileName;

	                $this->load->library('upload', $config);
	                $this->upload->initialize($config);

	                if(!$this->upload->do_upload($key)) {
	                	$this->session->set_flashdata('error', 'Error saat mengupload gambar soal : ' . $this->upload->display_errors());
	                	redirect($post['url']);
	                	exit;
	                }	
				}
			endforeach;
		}

		$insert = $this->m_soal_penilaian->insert($data);

		if($insert) {
			$this->session->set_flashdata('success', 'Soal berhasil ditambahkan!');
        	redirect($post['from_url']);
        	exit;
		}
		else {
			$this->session->set_flashdata('error', 'Error saat menambahkan data!');
        	redirect($post['url']);
        	exit;
		}
	}

	/*
	*  @Deprecated, using insertSoal instead of this function
	*/
	function simpan_soal(){


			$p = $this->input->post();
			print_r($p);
			print_r($_FILES);
			exit;
			$pembuat_soal = ($this->log_lvl == "admin") ? $p['id_guru'] : $this->log_id;

			$pembuat_soal_u = ($this->log_lvl == "admin") ? ", id_guru = '".$p['id_guru']."'" : "";

			//etok2nya config

			$folder_gb_soal = "./upload/file_penilaian_soal/";

			$folder_gb_opsi = "./upload/file_penilaian_opsi/";



			$buat_folder_gb_soal = !is_dir($folder_gb_soal) ? @mkdir("./upload/file_penilaian_soal/") : false;

			$buat_folder_gb_opsi = !is_dir($folder_gb_opsi) ? @mkdir("./upload/file_penilaian_opsi/") : false;



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

			$pdata = array(

				"bobot"=>1,

				"soal"=>$p['soal'],

				"jawaban"=> 'A',

				'id_paket' => $p['id_paket'],

				'id_dimensi' => $p['dimensi'],

				'bobot' => $p['bobot']

			);



			if ($__mode == "edit") {

				$this->db->where("id", $p['id']);

				$this->db->update("m_soal_penilaian", $pdata);

				$__id_soal = $p['id'];

			} else {

				$this->db->insert("m_soal_penilaian", $pdata);

				$get_id_akhir = $this->db->query("SELECT MAX(id) maks FROM m_soal_penilaian LIMIT 1")->row_array();

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



					if ($k == "file_penilaian_soal") {

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

			$get_opsi_awal = $this->db->query("SELECT opsi_a, opsi_b, opsi_c, opsi_d, opsi_e FROM m_soal_penilaian WHERE id = '".$__id_soal."'")->row_array();



			$data_simpan = array();



			if (!empty($nama_file['file_penilaian_soal'])) {

				$data_simpan = array(

								"file"=>$nama_file['file_penilaian_soal'],

								"tipe_file"=>$tipe_file['file_penilaian_soal'],

								);

			}



			

			$a['huruf_opsi'] = array("a","b","c","d","e");

			$a['jml_opsi'] =$this->jml_opsi;



			for ($t = 0; $t < $a['jml_opsi']; $t++) {

				$idx 	= "opsi_".$a['huruf_opsi'][$t];

				$idx2 	= "gj".$a['huruf_opsi'][$t];





				//jika file kosong

				$pc_opsi_awal = explode("#####", $get_opsi_awal[$idx]);

				$nama_file_opsi = empty($nama_file[$idx2]) ? $pc_opsi_awal[0] : $nama_file[$idx2];



				$data_simpan[$idx] = $nama_file_opsi."#####".$p[$idx];

			}



		



			$this->db->where("id", $__id_soal);

			$this->db->update("m_soal_penilaian", $data_simpan);



			$teks_gagal = "";

			foreach ($gagal as $k => $v) {

				$arr_nama_file_upload = array("file_penilaian_soal"=>"File Soal ", "gja"=>"File opsi A ", "gjb"=>"File opsi B ", "gjc"=>"File opsi C ", "gjd"=>"File opsi D ", "gje"=>"File opsi E ");

				$teks_gagal .= $arr_nama_file_upload[$k].': '.$v.'<br>';

			}



			$this->session->set_flashdata('k', '<div class="alert alert-info">'.$teks_gagal.'</div>');

			redirect(base_url('penilaian/data_soal/'.encrypt_url($p['id_paket'])));

				

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

				unlink("./upload/file_penilaian_soal/".$nama_gambar->file);

				$update['file'] = NULL;

				$update['type_file'] = NULL;

			}else if($link2 == $num){

				$pc_opsi_a = explode("#####", $nama_gambar->opsi_a);

				unlink("./upload/file_penilaian_opsi/".$pc_opsi_a[0]);

				$update['opsi_a'] = "#####".$pc_opsi_a[1];

			}else if($link3 == $num){

				$pc_opsi_b = explode("#####", $nama_gambar->opsi_b);

				unlink("./upload/file_penilaian_opsi/".$pc_opsi_b[0]);

				$update['opsi_b'] = "#####".$pc_opsi_b[1];

			}else if($link4 == $num){

				$pc_opsi_c = explode("#####", $nama_gambar->opsi_c);

				unlink("./upload/file_penilaian_opsi/".$pc_opsi_c[0]);

				$update['opsi_c'] = "#####".$pc_opsi_c[1];

			}else if($link5 == $num){

				$pc_opsi_d = explode("#####", $nama_gambar->opsi_d);

				unlink("./upload/file_penilaian_opsi/".$pc_opsi_d[0]);

				$update['opsi_d'] = "#####".$pc_opsi_d[1];

			}else if($link6 == $num){

				$pc_opsi_e = explode("#####", $nama_gambar->opsi_e);

				unlink("./upload/file_penilaian_opsi/".$pc_opsi_e[0]);

				$update['opsi_e'] = "#####".$pc_opsi_e[1];

			}



			$this->m_soal_ujian->update($update,['id'=>$id]);



			exit;

		}



		public function hapus_soal(){

			$post = $this->input->post();



			foreach ($post['id'] as $key => $id) {



				$nama_gambar = $this->m_soal_penilaian->get_by(array('id'=>$id));



				$pc_opsi_a = explode("#####", $nama_gambar->opsi_a);

				$pc_opsi_b = explode("#####", $nama_gambar->opsi_b);

				$pc_opsi_c = explode("#####", $nama_gambar->opsi_c);

				$pc_opsi_d = explode("#####", $nama_gambar->opsi_d);

				$pc_opsi_e = explode("#####", $nama_gambar->opsi_e);



				$kirim = $this->m_soal_penilaian->delete(array('id'=>$id));

				if($kirim){

					@unlink($this->_fileSoalPath.$nama_gambar->file);

					@unlink($this->_fileOpsiPath.$pc_opsi_a[0]);

					@unlink($this->_fileOpsiPath.$pc_opsi_b[0]);

					@unlink($this->_fileOpsiPath.$pc_opsi_c[0]);

					@unlink($this->_fileOpsiPath.$pc_opsi_d[0]);

					@unlink($this->_fileOpsiPath.$pc_opsi_e[0]);

				}

			}



			echo json_encode(['result'=>true]);

		}

		public function batalkanPenilaian()
		{
			$post = $this->input->post();

			$update = $this->m_penilaian->update([
				'izin' => 0
			], ['id' => $post['id']]);
			$deleteHasil = $this->m_ikut_penilaian->delete(['id_penilaian' => $post['id']]);

			if($update && $deleteHasil) {
				$this->sendAjaxResponse([
					'status' => TRUE,
					'msg' => 'Penilaian berhasil dibatalkan'
				]);
			}
			else {
				$this->sendAjaxResponse([
					'status' => FALSE,
					'msg' => 'Penilaian gagal dibatalkan'
				], 500);
			}
		}

		/*
		* Function untuk mengatur suatu penilaian diizinkan oleh admin
		*/
		public function izinkan(){

			$post = $this->input->post();	
			$data = [
				'jumlah_soal' => $post['soal'],
				'izin'		  => 1,
			];
			$title = 'Mengizinkan';

			$kirim = $this->m_penilaian->update($data,['id'=>$post['id']]);
			if ($kirim) {
				$status = 1;
				$message = 'Berhasil '.$title;
			}else{
				$status = 0;
				$message = 'Gagal '.$title;
			}

			echo json_encode(['status'=>$status,'message'=>$message]);
		}


		/*
		* Function untuk menampilkan persiapan sebelum memulai Ujian untuk siswa
		*/
		public function ikuti_ujian($id_ujian){

			header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");

			header("Cache-Control: post-check=0, pre-check=0", false);

			header("Pragma: no-cache");

			// DU = Data Ujian
			$dataUjian = $this->m_penilaian->get_join_by(['pen.id' => decrypt_url($id_ujian)], 'array');
			// print_r($dataUjian);exit;
			$a['du'] = $dataUjian;
			$pen = $this->m_penilaian->get_by(['pen.id'=>decrypt_url($id_ujian)]);

			$a['jumlah_soal'] = $this->m_soal_penilaian->count_by(['id_paket'=>$pen->id_paket_soal]);

			$a['dp'] = $this->m_siswa->get_by(['id' =>$this->log_id]);

			if (!empty($a['du']) || !empty($a['dp'])) {

				$tgl_selesai = $a['du']['tgl_mulai'];

				$tgl_terlambat_baru = $a['du']['terlambat'];

				$a['tgl_mulai'] = $tgl_selesai;

				$a['terlambat'] = $tgl_terlambat_baru;

				$cek = $this->db->query("

					SELECT

					count(pen.id) as jmlh,

					tes.*

					FROM

					tb_ikut_penilaian pen

					INNER JOIN tb_penilaian tes ON tes.id = pen.id_penilaian 

					WHERE id_penilaian = '".decrypt_url($id_ujian)."' AND id_user = '".$this->log_id."' AND status = 'N'

					")->row();

				

				if ($this->total_ujian <= $cek->jmlh) {

					redirect('penilaian/');

					exit;

				}
				$this->session->set_userdata(array('selesai_ujian'=>0));

				$this->render('penilaian/ikuti_ujian', $a);



			} else {

				redirect('ujian_real/result');

			}

		}

		/*
		* Function untuk menjalankan Ujian untuk siswa
		*/
		public function ikut_ujian($id_ujian){
			$id_ujian = decrypt_url($id_ujian);
			if ($this->session->userdata('selesai_ujian') == 1) {

				$cek = $this->db->query("

					SELECT

					count(pen.id) as jmlh

					FROM

					tb_ikut_penilaian pen

					INNER JOIN tb_penilaian tes ON tes.id = pen.id_penilaian 

					WHERE id_penilaian = '$id_ujian' AND id_user = '".$this->akun->id."'

					")->row();



				redirect(base_url('penilaian'));

				exit;

			}

			

			header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");

			header("Cache-Control: post-check=0, pre-check=0", false);

			header("Pragma: no-cache");

			

	

			$cek_sdh_selesai = $this->m_ikut_penilaian->count_by(['id_penilaian'=>$id_ujian,'id_user'=>$this->akun->id,'status'=>'N']);



		

			//sekalian validasi waktu sudah berlalu...

			if ($cek_sdh_selesai <= $this->total_ujian) {

				//ini jika ujian belum tercatat, belum ikut

				//ambil detil soal



				$cek_detil_tes = $this->m_penilaian->get_by(['pen.id'=>$id_ujian]);





				$ikut_ujian = $this->m_ikut_penilaian->get_by(['id_penilaian'=>$id_ujian,'id_user'=>$this->akun->id]);

				$cek_sdh_ujian	= $this->m_ikut_penilaian->count_by(['id_penilaian'=>$id_ujian,'id_user'=>$this->akun->id]);

				

				$acakan = $cek_detil_tes->jenis == "ORDER BY id ASC";

				

				if ($cek_sdh_ujian <= $this->total_ujian)	{		

					$soal_urut_ok = array();

					$a_soal			= $this->db->query("SELECT id, file, jawaban, tipe_file, soal, opsi_a, opsi_b, opsi_c, opsi_d, opsi_e FROM m_soal_penilaian WHERE id_paket = '".$cek_detil_tes->id_paket_soal."' ".$acakan)->result();

				

					$q_soal	= $this->db->query("SELECT id, file, jawaban, tipe_file, soal, opsi_a, opsi_b, opsi_c, opsi_d, opsi_e, '' AS jawaban FROM m_soal_penilaian WHERE id_paket = '".$cek_detil_tes->id_paket_soal."' ".$acakan)->result();





					

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

							'id_penilaian' 	=> $id_ujian,

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

						$this->m_ikut_penilaian->insert($insert_data);
					}





					

					$cek_ujian_pertama = $this->db->select("count(*) as total")

												  ->from('tb_ikut_penilaian_pertama')

												  ->where(['id_penilaian'=>$id_ujian,'id_user'=>$this->akun->id])

												  ->get()

												  ->row();



					if($cek_ujian_pertama->total < 1) {

						$this->db->query("INSERT INTO tb_ikut_penilaian_pertama VALUES (null, '$id_ujian', NULL, '".$this->akun->id."', '$list_id_soal', '$list_jw_soal', 0, 0, 0, '$time_mulai', ADDTIME('$time_mulai', '$waktu_selesai'), 'N', '$list_jw_benar', 1)");

					}

					$detil_tes = $this->db->query("SELECT * FROM tb_ikut_penilaian WHERE status = 'Y' AND id_penilaian = '$id_ujian' AND id_user = '".$this->akun->id."'")->row();

	

	

					//echo $this->db->last_query();exit;



					$soal_urut_ok= $soal_urut_ok;

				} else {



					$q_ambil_soal = $this->m_ikut_penilaian->get_by(['id_penilaian'=>$id_ujian,'id_user'=>$this->akun->id]);



					$urut_soal 		= explode(",", $q_ambil_soal->list_jawaban);

					

					$soal_urut_ok	= array();

					for ($i = 0; $i < sizeof($urut_soal); $i++) {

						$pc_urut_soal = explode(":",$urut_soal[$i]);

						$pc_urut_soal1 = empty($pc_urut_soal[1]) ? "''" : "'".$pc_urut_soal[1]."'";

						$ambil_soal = $this->db->query("SELECT *, $pc_urut_soal1 AS jawaban FROM m_soal_penilaian WHERE id = '".$pc_urut_soal[0]."'")->row();



						$soal_urut_ok[] = $ambil_soal; 

					}

					

					$detil_tes = $q_ambil_soal;

					$soal_urut_ok = $soal_urut_ok;

				}



			



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

			

				if (!empty($soal_urut_ok)) {

					

				    foreach ($soal_urut_ok as $d) { 

				    	echo $d->id;

				        $tampil_media = tampil_media("./upload/file_penilaian_soal/".$d->file, '250px','auto');

				        $vrg = $arr_jawab[$d->id]["r"] == "" ? "N" : $arr_jawab[$d->id]["r"];



				        $html .= '<input type="hidden" name="id_soal_'.$no.'" value="'.$d->id.'">';

				        $html .= '<input type="hidden" name="rg_'.$no.'" id="rg_'.$no.'" value="'.$vrg.'">';

				        $html .= '<div class="step" id="widget_'.$no.'">';

				        $html .= $d->soal.'<br>'.$tampil_media.'<div class="funkyradio">';



				        for ($j = 0; $j <$this->jml_opsi; $j++) {

				            $opsi = "opsi_".$this->opsi[$j];

				            $checked = $arr_jawab[$d->id]["j"] == strtoupper($this->opsi[$j]) ? "checked" : "";

				            $pc_pilihan_opsi = explode("#####", $d->$opsi);

				            $tampil_media_opsi = (is_file('./upload/file_penilaian_soal/'.$pc_pilihan_opsi[0]) || $pc_pilihan_opsi[0] != "") ? tampil_media('./upload/file_penilaian_soal/'.$pc_pilihan_opsi[0],'250px','auto') : '';

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

				$this->load->view('penilaian/v_ujian', $a);
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

			$this->db->query("UPDATE tb_ikut_penilaian SET list_jawaban = '".$update_."' WHERE id_penilaian = '$id_ujian' AND id_user = '".$this->akun->id."'");

			$cek = $this->db->query("SELECT * from tb_ikut_penilaian where id_penilaian = " . $id_ujian . " and id_user = " . $this->akun->id . "");

			$cek_ujian_pertama = $this->db->query("SELECT * from tb_ikut_penilaian_pertama where id_penilaian = " . $id_ujian . " and id_user = " . $this->akun->id . "");

			if($cek_ujian_pertama->num_rows() == 1 ) {

				if($cek->num_rows() == 1) {

					$this->db->query("UPDATE tb_ikut_penilaian_pertama SET list_jawaban = '".$update_."' WHERE id_penilaian = '$id_ujian' AND id_user = '".$this->akun->id."'");

				}

				

			}

			//echo $this->db->last_query();



			$q_ret_urn 	= $this->db->query("SELECT list_jawaban FROM tb_ikut_penilaian WHERE status = 'Y' AND id_penilaian = '$id_ujian' AND id_user = '".$this->akun->id."'");

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



		$this->db->trans_begin();



			$get_jawaban = $this->db->query("SELECT list_jawaban FROM tb_ikut_penilaian WHERE status = 'Y' AND id_penilaian = '$id_ujian' AND id_user = '".$this->akun->id."'")->row_array();

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

				$cek_jwb 	= $this->db->query("SELECT bobot, jawaban FROM m_soal_penilaian WHERE id = '".$id_soal."'")->row();

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

			$nilai_bobot = ($nilai_bobot / $total_bobot)  * 100;

			



			//$a_banyak		= $this->db->query("SELECT SUM(banyak) AS jumlah FROM tb_ikut_penilaian")->row();

			//$this->db->query("UPDATE tb_ujian SET penggunaan = '$a_banyak->jumlah' WHERE id = '$id_ujian' ");



			$this->db->query("UPDATE tb_ikut_penilaian SET jml_benar = '$jumlah_benar', nilai = '$nilai', nilai_bobot = '$nilai_bobot', status = 'N',tgl_selesai= '".date('Y-m-d H:i:s')."' WHERE status = 'Y' AND id_penilaian = '$id_ujian' AND id_user = '".$this->akun->id."'");

			

			$cek = $this->db->query("SELECT * from tb_ikut_penilaian where id_penilaian = " . $id_ujian . " and id_user = " . $this->akun->id . "");

			$cek_ujian_pertama = $this->db->query("SELECT * from tb_ikut_penilaian_pertama where id_penilaian = " . $id_ujian . " and id_user = " . $this->akun->id . "");



			if($cek_ujian_pertama->num_rows() == 1 ) {

				if($cek->num_rows() > 0) {

					$this->db->query("UPDATE tb_ikut_penilaian_pertama SET jml_benar = '.$jumlah_benar.', nilai = '.$nilai.', nilai_bobot = '.$nilai_bobot.', status = 'N' WHERE status = 'Y' AND id_penilaian = '$id_ujian' AND id_user = '".$this->akun->id."'");

				}



				$this->session->set_userdata(array('selesai_ujian'=>1));





			}



		$ikut_pen = $this->db->select('id')->where(['id_penilaian'=>$id_ujian,'id_user'=>$this->akun->id])->get('tb_ikut_penilaian')->row();

		

		if ($this->db->trans_status() === FALSE)

		{

				$this->db->trans_rollback();

		}

		else

		{

				$this->db->trans_commit();



				$pen = $this->counting_skor($ikut_pen->id);



				$where = [

					'id_trainer' => $pen->id_trainer,

					'id_mapel' 	 => $pen->id_mapel,

					'tgl_input'  => $pen->tanggal,

					'id_instansi' => $this->akun->instansi

				];



				$count = $this->db->where($where)->count_all_results('tb_rank');



			

				if($count > 0){

					$rank = $this->db->where($where)->get('tb_rank')->row();



					$responden	= $rank->responden + $pen->responden;

					$total_a 	= $rank->total_a + $pen->jwb_a;

					$total_b 	= $rank->total_b + $pen->jwb_b;

					$total_c 	= $rank->total_c + $pen->jwb_c;

					$total_d 	= $rank->total_d + $pen->jwb_d;

					$total_e 	= $rank->total_e + $pen->jwb_e;

					$skor 		= $rank->skor + $pen->skor;



					$data = [

						'responden'  => $responden,

						'total_a' 	 => $total_a,

						'total_b' 	 => $total_b,

						'total_c' 	 => $total_c,

						'total_d' 	 => $total_d,

						'total_e' 	 => $total_e,

						'skor' 	     => $skor,

					];

					$send = $this->db->update('tb_rank',$data,$where);

				}else{

					

					$data = [

						'id_trainer' => $pen->id_trainer,

						'id_mapel'   => $pen->id_mapel,

						'id_instansi' => $this->akun->instansi,

						'tgl_input'  => $pen->tanggal,

						'responden'  => $pen->responden,

						'total_a' 	 => $pen->jwb_a,

						'total_b' 	 => $pen->jwb_b,

						'total_c' 	 => $pen->jwb_c,

						'total_d' 	 => $pen->jwb_d,

						'total_e' 	 => $pen->jwb_e,

						'skor' 	     => $pen->skor,

					];



					$send = $this->db->insert('tb_rank',$data);



				}

		}

			$a['status'] = "ok";

			j($a);

			exit;

		}



		public function counting_skor($id=0){



			if($id == 0){

				exit;

			}

	

			$penilaian = $this->db->select("kls.id_trainer,kls.id_mapel,list_jawaban,DATE_FORMAT(ikut.tgl_mulai,'%Y-%m-%d') as tanggal")

								  ->join('tb_penilaian pen','pen.id=ikut.id_penilaian','left')

								  ->join('tb_kelas kls','pen.id_kelas=kls.id','left')

								  ->where('ikut.id',$id)

								  ->get('tb_ikut_penilaian ikut')

								  ->row();



		

		

			$pasis = 0;

			$jwb_a = 0;

			$jwb_b = 0;

			$jwb_c = 0;

			$jwb_d = 0;

			$jwb_e = 0;

			$skor = 0;



				$jawaban = explode(',',$penilaian->list_jawaban);



				foreach($jawaban as $jwb1){

					//substr($list_jw_soal, 0, -1);

					$soal = substr($jwb1,0, 1);

					$jwb = substr($jwb1,-3);

					$jwb = substr($jwb,0,-2);



					if($jwb == 'A'){

						$jwb_a +=1;

						$skor += 5;

					}else if ($jwb == 'B'){

						$jwb_b +=1;

						$skor += 4;

					}else if ($jwb == 'C'){

						$jwb_c +=1;

						$skor += 3;

					}else if ($jwb == 'D'){

						$jwb_d +=1;

						$skor += 2;

					}else if ($jwb == 'E'){

						$jwb_e +=1;

						$skor += 1;

					}



				}



			$result = (object) [



				'jwb_a' => $jwb_a,

				'jwb_b' => $jwb_b,

				'jwb_c' => $jwb_c,

				'jwb_d' => $jwb_d,

				'jwb_e' => $jwb_e,

				'skor'  => $skor,

				'responden' => 1,

				'tanggal' => $penilaian->tanggal,

				'id_trainer' => $penilaian->id_trainer,

				'id_mapel' => $penilaian->id_mapel





			];



			return $result;

		}



		public function result($id,$mapel=null) {

	

			$data = array(

				'id_ujian' => decrypt_url($id)

			);



			$this->render('penilaian/list_hasil', $data);



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

			$q_cek_sdh_ujian= $this->db->query("SELECT id FROM tb_ikut_penilaian WHERE id = '$id' AND id_ujian = '$id_ujian' AND id_user = '".$this->akun->id."'");

			$d_cek_sdh_ujian= $q_cek_sdh_ujian->row();

			$cek_sdh_ujian	= $q_cek_sdh_ujian->num_rows();

			$acakan = $cek_detil_tes->jenis == "acak" ? "ORDER BY RAND()" : "ORDER BY id ASC";

			$q_ambil_soal 	= $this->db->query("SELECT * FROM tb_ikut_penilaian WHERE id = '$id' AND id_ujian = '$id_ujian' AND id_user = '".$this->akun->id."'")->row();

			$urut_soal 		= explode(",", $q_ambil_soal->list_jawaban);

			$soal_urut_ok	= array();

			for ($i = 0; $i < sizeof($urut_soal); $i++) {

				$pc_urut_soal = explode(":",$urut_soal[$i]);

				$pc_urut_soal1 = empty($pc_urut_soal[1]) ? "''" : "'".$pc_urut_soal[1]."'";

				$ambil_soal = $this->db->query("SELECT *, $pc_urut_soal1 AS jawaban FROM m_soal_penilaian WHERE id = '".$pc_urut_soal[0]."'")->row();

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

			$q_ambil_soal1 	= $this->db->query("SELECT * FROM tb_ikut_penilaian WHERE id = '$id' AND id_ujian = '$id_ujian' AND id_user = '".$this->akun->id."'")->row();

			$urut_soal1 	= explode(",", $q_ambil_soal1->jawaban_benar);

			$soal_urut_ok1	= array();

			for ($i = 0; $i < sizeof($urut_soal1); $i++) {

				$pc_urut_soal1 = explode(":",$urut_soal1[$i]);

				$pc_urut_soal1 = empty($pc_urut_soal1[1]) ? "''" : "'".$pc_urut_soal1[1]."'";

				$ambil_soal1 = $this->db->query("SELECT *, $pc_urut_soal1 AS jawaban FROM m_soal_penilaian WHERE id = '".$pc_urut_soal[0]."'")->row();

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



					for ($j = 0; $j <$this->jml_opsi; $j++) {

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

			$this->load->view('penilaian/v_riwayat', $a);

		}

		

	public function multi_delete(){
		$where = [];
		$post = $this->input->post();
		foreach ($post['id'] as $val) {
			$where[] = $val;
		}

		$this->db->trans_begin();
		$kirim = $this->db->where_in('id',$where)->delete('tb_penilaian');
		$kirim = $this->db->where_in('id_penilaian', $where)->delete('tb_ikut_penilaian');
		$kirim = $this->db->where_in('id_penilaian', $where)->delete('tb_ikut_penilaian_pertama');

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		}
		else {
			$this->db->trans_commit();
		}

		if ($kirim) {
			$result = true;
			$this->sendAjaxResponse([
				'status' => TRUE,
				'msg' => 'Penilaian berhasil dihapus'
			]);
		} else {
			$this->sendAjaxResponse([
				'status' => FALSE,
				'msg' => 'Penilaian gagal dihapus'
			], 500);
		}
	}

	



	public function paket_soal()

	{

		$data = array(

				'searchFilter' => array('Nama Paket')

			);

			$this->render('paket_soal/list',$data);

	}



	public function page_load_paket($pg = 1){



		$post = $this->input->post();

		$limit = $post['limit'];

		$where = [];

		if (!empty($post['search'])) {

			switch ($post['filter']) {

				case 0:

					$where["(lower(nama) like '%".strtolower($post['search'])."%' )"] = null;

					break;

				default:

					# code...

					break;

			}

   		}

		if ($this->log_lvl != 'admin') {

			$where['id_instansi'] = $this->akun->instansi;

		}



		$paginate = $this->m_paket_soal->paginate($pg,$where,$limit);

		$data['paginate'] = $paginate;

		$data['paginate']['url']	= 'penilaian/page_load_paket';

		$data['paginate']['search'] = 'lookup_key';

		$data['page_start'] = $paginate['counts']['from_num'];



		$this->load->view('paket_soal/table',$data);

		$this->generate_page($data);

  }



  public function paket_soal_simpan()

  {

	$post = $this->input->post();

	

	$data = [

		'nama' 			=> $post['nama'],

		'id_instansi' 	=>  $this->akun->instansi

	];



	if($post['id'] == 0){

		$kirim = $this->m_paket_soal->insert($data);

		$info = ($kirim) ? 'Berhasil Menambahkan ' : 'Gagal Menambahkan';

	}else{

		$kirim = $this->m_paket_soal->update($data,['id'=>$post['id']]);

		$info = ($kirim) ? 'Berhasil Mengupdate ' : 'Gagal Mengupdate';

	}



    $json = ['result'=>$kirim,'info'=>$info];



    echo json_encode($json);

    

  }



  public function get_paket($id)

  {

	 $paket = $this->m_paket_soal->get_by(['id'=>decrypt_url($id)]);

	 echo json_encode($paket);

  }



  public function output1()

	{

		$data = array(

				'searchFilter' => array('Nama Paket')

			);

		$this->render('penilaian/output1',$data);

	}





	public function output2()

	{

		$data = array(

				'searchFilter' => array('Nama Paket')

			);

		$this->render('penilaian/output2',$data);

	}



	public function output3()

	{

		$data = array(

				'searchFilter' => array('Nama Paket')

			);

		$this->render('penilaian/output3',$data);

	}



	public function page_load_out1($pg = 1){

		

		$post = $this->input->post();

		$limit = $post['limit'];

		$where = [];

		if (!empty($post['search'])) {

			switch ($post['filter']) {

				case 0:

					$where["(lower(nama) like '%".strtolower($post['search'])."%' )"] = null;

					break;

				default:

					# code...

					break;

			}

		   }

		   

		if ($this->log_lvl != 'admin') {

			$where['kls.id_instansi'] = $this->akun->instansi;

		}



		$data = $this->m_penilaian->out1($pg,$where,$limit);
		print_r($data);exit;
	

		$this->load->view('penilaian/table_out1',$data);



  }



	public function page_load_out2($pg = 1){



		$post = $this->input->post();

		$limit = $post['limit'];

		$where = [];

		if (!empty($post['search'])) {

			switch ($post['filter']) {

				case 0:

					$where["(lower(nama) like '%".strtolower($post['search'])."%' )"] = null;

					break;

				default:

					# code...

					break;

			}

		}

		

		if ($this->log_lvl != 'admin') {

			$where['kls.id_instansi'] = $this->akun->instansi;

		}



		$data = $this->m_penilaian->out2($pg,$where,$limit);



		$this->load->view('penilaian/table_out2',$data);



	}



	public function page_load_out3($pg = 1){



		$post = $this->input->post();

		$limit = $post['limit'];

		$where = [];

		if (!empty($post['search'])) {

			switch ($post['filter']) {

				case 0:

					$where["(lower(nama) like '%".strtolower($post['search'])."%' )"] = null;

					break;

				default:

					# code...

					break;

			}

		}

		

		if ($this->log_lvl != 'admin') {

			$where['kls.id_instansi'] = $this->akun->instansi;

		}



		$data = $this->m_penilaian->out3($pg,$where,$limit);



		$this->load->view('penilaian/table_out3',$data);



	}



	public function luaran() {

		$this->page_title = 'Luaran EDOPM';

		$data = [];

		$this->render('penilaian/luaran', $data);

	}

	public function hapusSoalFile()
	{
		$post = $this->input->post();
		$data = $this->m_soal_penilaian->get_by(['id' => $post['id']]);
		$update = NULL;
		if(!empty($data)) {
			if(file_exists($this->_fileSoalPath . $data->file)) {
				unlink($this->_fileSoalPath . $data->file);
			}

			$update = $this->m_soal_penilaian->update([
				'file' => NULL,
				'tipe_file' => NULL
			], ['id' => $post['id']]);
		}

		if($update) {
			$this->sendAjaxResponse([
				'status' => TRUE,
				'msg' => 'File berhasil dihapus'
			], 200);
		}
		else {
			$this->sendAjaxResponse([
				'status' => FALSE,
				'msg' => 'File gagal dihapus'
			], 500);	
			exit;
		}
	}

	public function hapusOpsiFile()
	{
		$post = $this->input->post();
		$data = $this->m_soal_penilaian->get_by_array(['id' => $post['id']]);
		$update = NULL;
		if(!empty($data)) {
			$dataOpsi = explode('#####', $data['opsi_' . $post['opsi']]);
			if(!empty($dataOpsi[0]) && file_exists($this->_fileOpsiPath . $dataOpsi[0])) {
				unlink($this->_fileOpsiPath . end($dataOpsi));
			}

			$newOpsi = '#####' . end($dataOpsi);
			$update = $this->m_soal_penilaian->update([
				'opsi_' . $post['opsi'] => $newOpsi
			], ['id' => $post['id']]);
		}

		if($update) {
			$this->sendAjaxResponse([
				'status' => TRUE,
				'msg' => 'File berhasil dihapus'
			], 200);
		}
		else {
			$this->sendAjaxResponse([
				'status' => FALSE,
				'msg' => 'File gagal dihapus'
			], 500);	
			exit;
		}
	}

	public function paket_soal_multi_delete()
	{
		$post = $this->input->post();

		foreach ($post['id'] as $val) {
			$where[] = $val;
		}

		$this->db->trans_begin();

		$kirim = $this->db->where_in('id',$where)->delete('tb_paket_soal');

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

	/*
	* Function untuk melihat hasil penilaian oleh admin
	*/
	public function hasilPenilaian($encryptIdPenilaian)
	{
		$this->load->model('m_ikut_penilaian');
		$id = decrypt_url($encryptIdPenilaian);
		$dataPenilaian = $this->m_penilaian->get_by(['pen.id' => $id]);
		$data['id_penilaian'] = $id;
		$data['penilaian'] = $dataPenilaian;

		$this->render('penilaian/hasil-penilaian', $data);
	}

	public function pageLoadHasilPenilaian($pg = 1)
	{
		$post = $this->input->post();
		$limit = $post['limit'];
		$where = [];
		$where['id_penilaian'] = $post['id_penilaian'];

		$paginate = $this->m_ikut_penilaian->paginate($pg,$where,$limit);

		$data['paginate'] = $paginate;
		$data['paginate']['url']	= 'penilaian/load-hasil-penilaian';
		$data['paginate']['search'] = 'lookup_key';
		$data['page_start'] = $paginate['counts']['from_num'];

		$this->load->view('penilaian/table-hasil-penilaian',$data);
		$this->generate_page($data);		
	}

	/*
	* Function untuk melihat jawaban yang dipilih siswa saat penilaian
	*/
	public function hasilPenilaianSiswa($encryptIdSiswa, $encryptIdPenilaian)
	{
		$post = $this->input->post();
		$idSiswa = decrypt_url($encryptIdSiswa);
		$idPenilaian = decrypt_url($encryptIdPenilaian);

		$getPaketSoal = $this->m_penilaian->get_by(['pen.id' => $idPenilaian]);

		$soalPenilaian = $this->m_soal_penilaian->get_many_by([
			'id_paket' => $getPaketSoal->id_paket_soal
		]);

		$result = $this->m_ikut_penilaian->get_by([
			'id_penilaian' => $idPenilaian,
			'id_user' => $idSiswa
		]);

		$jawabanUser = explode(',', $result->list_jawaban);

		$datas = [
			'soal' => $soalPenilaian,
			'result' => $result,
			'jawabanUser' => $jawabanUser,
			'backUrl' => base_url('penilaian/hasil-penilaian/') . $encryptIdPenilaian
		];
		// print_r($datas);exit;
		$this->load->view('penilaian/v_periksa_penilaian', $datas);
	}
}