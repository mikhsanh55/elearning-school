<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tugas extends MY_Controller {

	protected $type;
	protected $color;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_mapel_cs');
		$this->load->model('m_tugas');
		$this->load->model('m_tugas_attach');
		$this->load->model('m_tugas_attach_siswa');
		$this->load->model('m_tugas_nilai');
		$this->load->model('m_siswa');
		$this->load->model('m_kelas');
		$this->load->model('m_detail_kelas');
		
		$this->load->helper('security');

		$this->type = array(
			'.pdf' => 'fa fa-file-pdf-o', 
			'.png' => 'fa fa-file-image-o', 
			'.jpg' => '	fa fa-file-image-o', 
			'.jpeg' => 'fa fa-file-image-o', 
			'.zip' => 'fa fa-file-archive-o',
			'.rar' => 'fa fa-file-archive-o',
			'.doc' => 'fa fa-file-word-o',
			'.docx' => 'fa fa-file-word-o',
			'.ppt' => 'fa fa-file-powerpoint-o',
			'.pptx' => 'fa fa-file-powerpoint-o',
			'.xls' => 'fa fa-file-excel-o',
			'.xlsx' => 'fa fa-file-excel-o'
		);

		$this->color = array(
			'.pdf' => 'red', 
			'.png' => '#bf4d4d', 
			'.jpg' => '#bf4d4d', 
			'.jpeg' => '#bf4d4d',
			'.zip' => '#ff8f19',
			'.rar' => '#ff8f19',
			'.doc' => 'blue',
			'.docx' => 'blue',
			'.ppt' => 'red',
			'.pptx' => 'red',
			'.xls' => 'green',
			'.xlsx' => 'green'
		);
	}

	public function index()
	{	

		$data = array(
			'searchFilter' => array('Mata Pelajaran','Keterangan'),
			'kelas' => $this->m_kelas->get_all()
		);

		$this->render('tugas/list',$data);
	}


	public function add(){
		if($this->log_lvl == 'admin' || $this->log_lvl == 'admin_instansi' || $this->log_lvl == 'instansi') {
			$kelas = $this->m_kelas->get_all(['kls.id_instansi' => $this->akun->instansi]);
			$mapel = $this->m_mapel->get_detail_all(['mapel.id_instansi' => $this->akun->instansi]);
		}
		else {
			$kelas = $this->m_kelas->kelas_tugas(['kls.id_instansi' => $this->akun->instansi, 'dmapel.id_guru' => $this->akun->id]);

			// $kelas = $this->m_kelas->get_all();
			$mapel = $this->m_mapel->get_detail_all(['mapel.id_instansi' => $this->akun->instansi, 'guru.id' => $this->akun->id]);
			// $mapel = $this->m_mapel->get_detail_all(['mapel.id_instansi' => $this->akun->instansi]);
		}
		// print_r($kelas);
		// exit;
		$data = array(
			'kelas' => $kelas,
			'mapel' => $mapel
		);
		$this->render('tugas/add',$data);
	}

	public function edit($id=0){

		$type = array(
			'.pdf' => 'fa fa-file-pdf-o', 
			'.png' => 'fa fa-file-image-o', 
			'.jpg' => '	fa fa-file-image-o', 
			'.jpeg' => 'fa fa-file-image-o', 
			'.pdf' => 'fa fa-file-pdf-o', 
			'.zip' => 'fa fa-file-archive-o',
			'.rar' => 'fa fa-file-archive-o',
			'.doc' => 'fa fa-file-word-o'
		);

		$data = array(
			'kelas' => $this->m_kelas->get_all(['kls.id_instansi' => $this->akun->instansi]), 
			'edit' => $this->m_tugas->get_by(array('md5(tgs.id)'=>$id)),
			'uploadedFiles' => $this->m_tugas_attach->get_many_by(['md5(id_tugas)' => $id])
		);
		// print_r($data['edit']);exit;
		$this->render('tugas/edit',$data);
	}


	public function insert(){
		try {
			$post = $this->input->post();
			$files = $_FILES;
				$qty_attach = $_FILES['file']['name'];

				$data = array(
					'id_kelas' => $post['kelas'], 
					'id_mapel' => $post['mapel'],
					'id_guru' => $post['guru'],
					'keterangan' => $post['keterangan'],
					'end_date' => date_default($post['end_date']).' '.$post['end_time'],
				);

				// if($this->log_lvl == 'guru') {
				// 	$data['id_guru'] = $this->akun->id;
				// }
				$this->db->trans_start();
				$kirim = $this->m_tugas->insert($data);
				$last_id = $this->db->insert_id();


				// if(!empty($qty_attach[0])) {


				// 	for($i=0; $i < count($qty_attach); $i++)
				// 	{           

						$namafile = 'tugas-'.DATE('d-m-Y')."-".time().'-';

						$config['upload_path']   = 'assets/tugas/attach/';
						$config['allowed_types'] = 'xlsx|xls|pdf|pdfx|doc|docx|jpeg|jpg|png|zip|rar|ppt|pptx';
						$config['max_size']      = 222220480;
						$config['file_name']     = $namafile;

						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						

						$_FILES['file']['name'] 		= $files['file']['name'];
						$_FILES['file']['type']  		= $files['file']['type'];
						$_FILES['file']['tmp_name']	= $files['file']['tmp_name'];
						$_FILES['file']['error']		= $files['file']['error'];
						$_FILES['file']['size']		= $files['file']['size'];    
						$this->upload->initialize($config);
						if ( ! $this->upload->do_upload('file') ){
							$json = [
								'status' => 0,
								'msg'    => 'Upload file gagal!',
								'info' => $this->upload->display_errors()
							];
							echo json_encode($json);
							exit;
						}else{
							$upload_data = $this->upload->data();
							$file_name = $upload_data['file_name'];

							$attach = array(
								'id_tugas' => $last_id,
								'file'     => $upload_data['file_name'],
								'format'   => $upload_data['file_ext']
							);
						}
					// }

					$this->db->insert('tb_tugas_attachment',$attach);
				// }

				$this->db->trans_complete();

				$json = [
					'status' => true,
					'msg'    => 'success',
					'info' => NULL
				];
				echo json_encode($json);
				exit;

			} catch (Exception $e) {
				$this->sendAjaxResponse(['error' => $e], 500);
			}
		}

		public function update(){
			try {
				$post = $this->input->post();
				
				if(is_null($post['mapel'])) {
					$this->sendAjaxResponse([
						'status' => FALSE,
						'msg' => 'Harap pilih Mata Pelajaran'
					], 400);
				}

				if(is_null($post['kelas'])) {
					$this->sendAjaxResponse([
						'status' => FALSE,
						'msg' => 'Harap pilih Kelas'
					], 400);
				}

				$data = array(
					'id_kelas' => $post['kelas'], 
					'id_mapel' => $post['mapel'],
					'keterangan' => $post['keterangan'],
					'end_date' => date_default($post['end_date']).' '.$post['end_time'],
				);

				if(isset($_FILES['file']['name'])) {
					$files = $_FILES;
					
					$qty_attach = $_FILES['file']['name'];

				

					$this->db->trans_start();
					
					$namafile = 'tugas-'.DATE('d-m-Y')."-".time().'-';

					$config['upload_path']   = 'assets/tugas/attach/';
					$config['allowed_types'] = 'pdf|pdfx|doc|docx|jpeg|jpg|png|zip|rar|ppt|pptx|xlsx|xls';
					$config['max_size']      = 22222220480;
					$config['file_name']     = $namafile;

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					

					$_FILES['file']['name'] 		= $files['file']['name'];
					$_FILES['file']['type']  		= $files['file']['type'];
					$_FILES['file']['tmp_name']	= $files['file']['tmp_name'];
					$_FILES['file']['error']		= $files['file']['error'];
					$_FILES['file']['size']		= $files['file']['size'];    

					$this->upload->initialize($config);
					if ( ! $this->upload->do_upload('file') ){
						$json = [
							'status' => FALSE,
							'msg'    => 'Upload file gagal!',
							'info' => $this->upload->display_errors()
						];
						echo json_encode($json);
						exit;
					}else{
						$upload_data = $this->upload->data();
						$file_name = $upload_data['file_name'];

						$attach = array(
							'id_tugas' => $post['id'],
							'file'     => $upload_data['file_name'],
							'format'   => $upload_data['file_ext']
						);
					}

					$this->db->insert('tb_tugas_attachment',$attach);
					$this->db->trans_complete();
				}
					
				//  Update
				$update = $this->m_tugas->update($data,array('id'=>$post['id']));

				if($update) {
					$this->sendAjaxResponse([
						'status' => FALSE,
						'msg' => 'Tugas berhasil update'
					], 200);
				}
				else {
					$this->sendAjaxResponse([
						'status' => FALSE,
						'msg' => 'Error update data tugas'
					], 500);
				}

			} catch (Exception $e) {
				$this->sendAjaxResponse(['status' => false, 'error' => $e], 500);
			}
	}

	public function page_load($pg = 1){
		$post = $this->input->post();
		$limit = $post['limit'];
		$where = [];
		if (!empty($post['search'])) {
			switch ($post['filter']) {
				case 0:
					$where["(lower(mapel.nama) like '%".strtolower($post['search'])."%' )"] = null;
					break;
				case 1:
					$where["(lower(tugas.keterangan) like '%".strtolower($post['search'])."%' )"] = null;
					break;
				
				default:
					# code...
					break;
			}
		}

		if ($this->log_lvl != 'admin') {
			$where['kls.id_instansi'] = $this->akun->instansi;
		}


		if ($this->log_lvl == 'guru') {
			$where['tugas.id_guru'] = $this->akun->id;
		}
		else if($this->log_lvl == 'siswa') {
			$id_kelas = $this->m_detail_kelas->get_by(['id_peserta' => $this->akun->id]);
			if(empty($id_kelas)) {
				die('Siswa belum memiliki kelas, harap hubungi admin');
			}

			$where['id_kelas'] = $id_kelas->id_kelas;
		}

		$paginate = $this->m_tugas->paginate($pg,$where,$limit);
		// print_r($paginate);exit;
		$data['paginate'] = $paginate;
		$data['paginate']['url']	= 'tugas/page_load';
		$data['paginate']['search'] = 'lookup_key';
		$data['page_start'] = $paginate['counts']['from_num'];

		$this->load->view('tugas/table',$data);
		$this->generate_page($data);
	}

	public function page_load_kelas($pg = 1){
		$post = $this->input->post();
		$limit = $post['limit'];
		$where = [];
		if (!empty($post['search'])) {
			switch ($post['filter']) {
				case 0:
					$where["(lower(sis.nama) like '%".strtolower($post['search'])."%' )"] = null;
					break;
				case 1:
					$where["(lower(sis.nrp) like '%".strtolower($post['search'])."%' )"] = null;
					break;
				
				default:
					# code...
					break;
			}
		}

		$where['id_kelas'] = $post['id_kelas'];

		$paginate = $this->m_detail_kelas->paginate($pg,$where,$limit);
		$data['paginate'] = $paginate;
		$data['paginate']['url']	= 'tugas/page_load_kelas';
		$data['paginate']['search'] = 'lookup_key';
		$data['page_start'] = $paginate['counts']['from_num'];
		$data['id_tugas'] = $post['id_tugas'];

		$this->load->view('tugas/table_siswa',$data);
		$this->generate_page($data);
	}

	public function multi_delete(){
		$post = $this->input->post();

		foreach ($post['id'] as $val) {
			$where[] = $val;
			$attach[]  = $this->m_tugas_attach->get_many_by(array('id_tugas'=>$val));
		}

		$this->db->trans_begin();

		$kirim = $this->db->where_in('id',$where)->delete('tb_tugas');
		$kirim = $this->db->where_in('id_tugas',$where)->delete('tb_tugas_attachment');

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
		}
		else
		{
			$this->db->trans_commit();

			foreach ($attach as $key => $row) {
				foreach ($row as $key => $rows) {
					$lokasi = 'assets/tugas/attach/'.$rows->file;
					if (file_exists($lokasi)) {
						unlink($lokasi);
					}
				}
			}
		}

		if ($kirim) {
			$result = true;
		}else{
			$result = false;
		}

		echo json_encode(array('result'=>$result));
	}

	public function get_attach_list(){
		$data = array(
			'attach' => $this->m_tugas_attach->get_many_by(array('id_tugas'=>$this->input->post('id_tugas'))), 
			'type' => $this->type,
			'color' => $this->color
		);
		$this->load->view('tugas/editListFile',$data);
	}

	public function get_attach_list_siswa(){
		$data = array(
			'attach' => $this->m_tugas_attach_siswa->get_many_by(array('id_tugas'=>$this->input->post('id_tugas'),'id_siswa'=>$this->akun->id)), 
			'type' => $this->type,
			'color' => $this->color
		);
		$this->load->view('tugas/attach_siswa',$data);
	}

	public function lampiran($id=0){

		$data = array(
			'detail' => $this->m_tugas->get_by(array('md5(tgs.id)'=>$id)),
			'attach' => $this->m_tugas_attach->get_many_by(array('md5(id_tugas)'=>$id)), 
			'type' => $this->type,
			'color' => $this->color
		);
		$this->render('tugas/lampiran',$data);
	}

	public function lampiran_detail($id=0,$siswa=0){
	
		$id = decrypt_url($id);
		$siswa = decrypt_url($siswa);

		$nilai_siswa = !empty($this->m_tugas_nilai->get_by(['id_tugas' => $id, 'id_siswa' => $siswa])) ? $this->m_tugas_nilai->get_by(['id_tugas' => $id, 'id_siswa' => $siswa])->nilai : 0;
		$data = array(
			'detail' => $this->m_tugas->get_by(array('tgs.id'=>$id)),
			'attach' => $this->m_tugas_attach_siswa->get_many_by(array('id_tugas'=>$id,'id_siswa'=>$siswa)), 
			'type' => $this->type,
			'color' => $this->color,
			'tugas_id' => encrypt_url($id),
			'id_siswa' => $siswa,
			'id_tugas' => $id,
			'nilai_siswa' => $nilai_siswa
		);

		$this->render('tugas/lampiran_detail',$data);
	}

	/*
	* Ini versi json dari method attach_file_delete
	*/
	public function delete_file_attach() {
		$post = $this->input->post();
		
		$data = $this->m_tugas_attach->get_by(['id' => $post['id']]);
		if(!is_null($data)) {
			$path_file = 'assets/tugas/attach/' . $data->file;
			if(file_exists($path_file)) {
				unlink($path_file);
			}


			$delete = $this->m_tugas_attach->delete(['id' => $post['id']]);
			if($delete) {
				$this->sendAjaxResponse([
					'status' => true,
					'msg' => 'File berhasil dihapus'
				], 200);
			}
			else {
				$this->sendAjaxResponse([
					'status' => false,
					'msg' => 'File gagal dihapus'
				], 500);	
			}
		}
	}

	public function attach_file_delete(){
		$post = $this->input->post();
		
		$kirim = $this->m_tugas_attach->delete(array('id'=>$post['id']));
		if ($kirim) {
			$status = 1;
			if (file_exists($post['location'])) {
				unlink($post['location']);
			}
		}else{
			$status = 0;
		}
	}

	public function attach_file_delete_siswa(){
		$post = $this->input->post();
		
		$kirim = $this->m_tugas_attach_siswa->delete(array('id'=>$post['id']));
		if ($kirim) {
			$status = 1;
			if (file_exists($post['location'])) {
				unlink($post['location']);
			}
		}else{
			$status = 0;
		}
	}

	public function get_file()
	{	
		$this->load->helper('download');
		$get = $this->input->get();

		$link = decrypt_url($get['file']);

		force_download($link, null);
		
	}

	public function siswa_list($id=0)
	{	

		$data = array(
			'searchFilter' => array('Nama'),
			'tugas' => $tugas = $this->m_tugas->get_by(array('tgs.id'=>decrypt_url($id))),
			'kelas' => $this->m_kelas->get_by(array('kls.id'=>$tugas->id_kelas))
		);

		

		$this->render('tugas/list_siswa',$data);
	}

	public function daftar_tugas($id=0)
	{	

		$data = array(
			'searchFilter' => ['Kelas', 'Mata Pelajaran'],
			'tugas' => $this->m_tugas->get_by(array('tgs.id'=>decrypt_url($id)))
		);

		

		$this->render('tugas/list_tugas',$data);
	}

	public function page_load_list_tugas($pg = 1){
		$post = $this->input->post();
		$limit = $post['limit'];
		$where = [];
		if (!empty($post['search'])) {
			switch ($post['filter']) {
				case 0:
					$where["(lower(kls.nama) like '%".strtolower($post['search'])."%' )"] = null;
					break;
				case 1:
					$where["(lower(guru.nama) like '%".strtolower($post['search'])."%' )"] = null;
					break;
			}
		}

		if ($this->log_lvl == 'instansi') {
			$where['kls.id_instansi'] = $this->akun->instansi;
		}

		$where['detail_kls.id_peserta'] = $this->akun->id;

		$paginate = $this->m_tugas->paginate_tugas($pg,$where,$limit);
		
		$data['paginate'] = $paginate;
		$data['paginate']['url']	= 'tugas/page_load_list_tugas';
		$data['paginate']['search'] = 'lookup_key';
		$data['page_start'] = $paginate['counts']['from_num'];

		$this->load->view('tugas/table_list_tugas',$data);
		$this->generate_page($data);
	}

	public function lampiran_siswa($id=0){

		$id = decrypt_url($id);


		$data = array(
			'detail' => $this->m_tugas->get_by(array('tgs.id'=>$id)),
			'attach' => $this->m_tugas_attach->get_many_by(array('id_tugas'=>$id)), 
			'type' => $this->type,
			'color' => $this->color
		);

		$this->render('tugas/lampiran_siswa',$data);
	}

	public function insert_attach_siswa(){
		$post = $this->input->post();
		$files = $_FILES;
		$qty_attach = $_FILES['attach']['name'];

		$this->db->trans_start();

		if(!empty($qty_attach[0])) {


			for($i=0; $i < count($qty_attach); $i++)
			{           
				$nama = $this->akun->nama;
				$nama = str_replace('.', '_', $nama);
				$nama = str_replace('', '_', $nama);
				$namafile = 'tugas-'.$nama.'-'.DATE('d-m-Y')."-".time().'-'.$i;

				$config['upload_path']   = 'assets/tugas/attach_siswa/';
				$config['allowed_types'] = 'pdf|pdfx|doc|docx|jpeg|jpg|png|zip|rar|ppt|pptx|xlsx|xls';
				$config['max_size']      = 20480; // 20 MB
				$config['file_name']     = $namafile;

				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				

				$_FILES['attach']['name'] 		= $files['attach']['name'][$i];
				$_FILES['attach']['type']  		= $files['attach']['type'][$i];
				$_FILES['attach']['tmp_name']	= $files['attach']['tmp_name'][$i];
				$_FILES['attach']['error']		= $files['attach']['error'][$i];
				$_FILES['attach']['size']		= $files['attach']['size'][$i];    

				$this->upload->initialize($config);
				if ( ! $this->upload->do_upload('attach') ){
					$json = [
						'status' => 0,
						'msg'    => 'Upload file gagal!',
						'info' => $this->upload->display_errors()
					];
					echo json_encode($json);
					exit;
				}else{
					$upload_data = $this->upload->data();
					$file_name = $upload_data['file_name'];

					$attach[$i] = array(
						'id_tugas' => $post['id_tugas'],
						'id_siswa' => $this->akun->id,
						'file'     => $upload_data['file_name'],
						'format'   => $upload_data['file_ext']
					);
				}
			}

			$this->db->insert_batch('tb_tugas_attachment_siswa',$attach);
		}

		$this->db->trans_complete();
		$this->updateActiveUser($this->log_lvl, 'active_tugas');
		exit;

	}

	public function beri_nilai()
	{
		$post = $this->input->post();

		$where = [
			'id_siswa' => $post['id_siswa'],
			'id_tugas' => $post['id_tugas']
		];

		$cek = $this->m_tugas_nilai->count_by($where);

		if($cek > 0){
			$kirim = $this->m_tugas_nilai->update($post,$where);
			$aksi = 'update';
		}else{
			$kirim = $this->m_tugas_nilai->insert($post);
			$aksi = 'insert';
		}

		if($kirim) {
			$this->sendAjaxResponse([
				'nilai' => $post['nilai'],
				'status' => TRUE,
				'msg' => 'Nilai Siswa berhasil diupdate'	
			], 200);
		}
		else {
			$this->sendAjaxResponse([
				'nilai' => $post['nilai'],
				'status' => FALSE,
				'msg' => 'Nilai Siswa gagal diupdate'	
			], 500);
		}
	}
	/*
	* Section Nilai Tugas untuk Admin / Guru
	*/
	public function detail_nilai_tugas_siswa($id_mapel, $id_siswa) {
		$id_mapel = decrypt_url($id_mapel);
		$id_siswa = decrypt_url($id_siswa);

		$detail_kelas = $this->m_detail_kelas->get_by(['id_peserta' => $id_siswa]);

		$mapel = $this->m_mapel->get_by(['id' => $id_mapel]);
		$kelas = $this->m_kelas->get_by(['kls.id' => $detail_kelas->id_kelas]);
		$siswa = $this->m_siswa->get_by(['id' => $id_siswa]);

		$data = [
			'id_mapel' => $id_mapel,
			'id_kelas' => $detail_kelas->id_kelas,
			'id_siswa' => $id_siswa,
			'nama_siswa' => $siswa->nama,
			'nama_mapel' => $mapel->nama,
			'nama_kelas' => $kelas->nama,
			'searchFilter' => ['Keterangan']
		];

		$this->render('tugas/list_detail_nilai', $data);
	}

	/*
	* Section Nilai Tugas untuk siswa
	*/
	public function detail_nilai_tugas($id_mapel) {
		$id_mapel = decrypt_url($id_mapel);

		$detail_kelas = $this->m_detail_kelas->get_by(['id_peserta' => $this->session->userdata('admin_konid')]);


		$data = [
			'id_mapel' => $id_mapel,
			'id_kelas' => $detail_kelas,
			'searchFilter' => ['Keterangan']
		];

		$this->render('tugas/list_detail_nilai', $data);
	}

	public function page_load_nilai_tugas($pg = 1) {
		$post = $this->input->post();
		$limit = $post['limit'];
		$where = [];

		$where['tugas.id_kelas'] = $post['id_kelas'];
		$where['tugas.id_mapel'] = $post['id_mapel'];

		switch($this->log_lvl) {
			case 'siswa':
				$where['tnilai.id_siswa'] = $this->session->userdata('admin_konid');
			break;
			case 'guru' :
				$where['tugas.id_guru'] = $this->session->userdata('admin_konid');
				$where['tnilai.id_siswa'] = $post['id_siswa'];
			default:
				$where['tnilai.id_siswa'] = $post['id_siswa'];
			break;
		}

		if (!empty($post['search'])) {
			switch ($post['filter']) {
				case 0:
					$where["(lower(tugas.keterangan) like '%".strtolower($post['search'])."%' )"] = null;
					break;
			}
		}

		$paginate = $this->m_tugas_nilai->paginate_detail_nilai($pg, $where, $limit);

		$data['paginate'] = $paginate;
		$data['paginate']['url']	= 'tugas/page_load_nilai_tugas';
		$data['paginate']['search'] = 'lookup_key';
		$data['page_start'] = $paginate['counts']['from_num'];

		$this->load->view('tugas/table_detail_nilai',$data);
		$this->generate_page($data);
	}
}

/* End of file Tugas.php */
/* Location: ./application/controllers/Tugas.php */