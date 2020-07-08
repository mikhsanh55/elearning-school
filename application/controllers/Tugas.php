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
			'searchFilter' => array('Modul Pelatihan','Keterangan'),
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
			$kelas = $this->m_kelas->get_data_mapel(['kls.id_instansi' => $this->akun->instansi, 'dkmapel.id_guru' => $this->akun->id]);
			$mapel = $this->m_mapel->get_detail_all(['mapel.id_instansi' => $this->akun->instansi, 'guru.id' => $this->akun->id]);
		}
		// print_r($mapel);exit;
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
			'kelas' => $this->m_kelas->get_many_by(array('gr.id'=>$this->akun->id)), 
			'edit' => $this->m_tugas->get_by(array('md5(tgs.id)'=>$id)), 
		);
		$this->render('tugas/edit',$data);
	}


	public function insert(){
		$post = $this->input->post();
		$files = $_FILES;
		$qty_attach = $_FILES['attach']['name'];

		$this->db->trans_start();

		$data = array(
			'id_kelas' => $post['kelas'], 
			'id_mapel' => $post['mapel'],
			'keterangan' => $post['keterangan'],
			'end_date' => date_default($post['end_date']).' '.$post['end_time'],
		);

		if($this->log_lvl == 'guru') {
			$data['id_guru'] = $this->akun->id;
		}

		$kirim = $this->m_tugas->insert($data);
		$last_id = $this->db->insert_id();


		if(!empty($qty_attach[0])) {


			for($i=0; $i < count($qty_attach); $i++)
			{           

				$namafile = 'tugas-'.DATE('d-m-Y')."-".time().'-'.$i;

				$config['upload_path']   = 'assets/tugas/attach/';
				$config['allowed_types'] = 'xlsx|xls|pdf|pdfx|doc|docx|jpeg|jpg|png|zip|rar|ppt|pptx';
				$config['max_size']      = 222220480;
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
						'id_tugas' => $last_id,
						'file'     => $upload_data['file_name'],
						'format'   => $upload_data['file_ext']
					);
				}
			}

			$this->db->insert_batch('tb_tugas_attachment',$attach);
		}

		$this->db->trans_complete();

		$json = [
			'status' => true,
			'msg'    => 'success',
			'info' => NULL
		];
		echo json_encode($json);
		exit;

	}

	public function update(){
		$post = $this->input->post();
		$files = $_FILES;
		$qty_attach = $_FILES['attach']['name'];

		$this->db->trans_start();

		$data = array(
			'id_kelas' => $post['kelas'], 
			'id_mapel' => $post['mapel'],
			'keterangan' => $post['keterangan'],
			'end_date' => date_default($post['end_date']).' '.$post['end_time'],
		);

		if($this->log_lvl == 'guru') {
			$data['id_guru'] = $this->akun->id;
		}

		$kirim = $this->m_tugas->update($data,array('id'=>$post['id']));

		if(!empty($qty_attach[0])) {


			for($i=0; $i < count($qty_attach); $i++)
			{           

				$namafile = 'tugas-'.DATE('d-m-Y')."-".time().'-'.$i;

				$config['upload_path']   = 'assets/tugas/attach/';
				$config['allowed_types'] = 'pdf|pdfx|doc|docx|jpeg|jpg|png|zip|rar|ppt|pptx|xlsx|xls';
				$config['max_size']      = 222220480;
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
						'status' => FALSE,
						'msg'    => 'Upload file gagal!',
						'info' => $this->upload->display_errors()
					];
					echo json_encode($json);
					exit;
				}else{
					$upload_data = $this->upload->data();
					$file_name = $upload_data['file_name'];

					$attach[$i] = array(
						'id_tugas' => $post['id'],
						'file'     => $upload_data['file_name'],
						'format'   => $upload_data['file_ext']
					);
				}
			}

			$this->db->insert_batch('tb_tugas_attachment',$attach);
		}

		$this->db->trans_complete();

		$json = [
			'status' => true,
			'msg'    => 'success',
			'info' => NULL
		];
		echo json_encode($json);
		exit;

	}

	public function page_load($pg = 1){
		$post = $this->input->post();
		$limit = $post['limit'];
		$where = [];
		if (!empty($post['search'])) {
			switch ($post['filter']) {
				case 0:
					$where["(lower(mpl.nama) like '%".strtolower($post['search'])."%' )"] = null;
					break;
				case 1:
					$where["(lower(tgs.keterangan) like '%".strtolower($post['search'])."%' )"] = null;
					break;
				
				default:
					# code...
					break;
			}
		}

		if ($this->log_lvl != 'admin') {
			$where['kls.id_instansi'] = $this->akun->instansi;

		}

		// if ($this->log_lvl == 'guru') {
		// 	$where['tugas.id_guru'] = 9;
		// }

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
		$this->load->view('tugas/editListFIle',$data);
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


		$data = array(
			'detail' => $this->m_tugas->get_by(array('tgs.id'=>$id)),
			'attach' => $this->m_tugas_attach_siswa->get_many_by(array('id_tugas'=>$id,'id_siswa'=>$siswa)), 
			'type' => $this->type,
			'color' => $this->color,
			'tugas_id' => encrypt_url($id)
		);

		$this->render('tugas/lampiran_detail',$data);
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
			'searchFilter' => array('Kelas'),
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

				$namafile = 'tugas-'.$this->akun->nama.'-'.DATE('d-m-Y')."-".time().'-'.$i;

				$config['upload_path']   = 'assets/tugas/attach_siswa/';
				$config['allowed_types'] = 'pdf|pdfx|doc|docx|jpeg|jpg|png|zip|rar|ppt|pptx|xlsx|xls';
				$config['max_size']      = 222220480;
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

		$json = [
			'status' => true,
			'msg'    => 'success',
			'info' => NULL
		];
		echo json_encode($json);
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
		
		$json = ['send' => $kirim,'action'=>$aksi];

		echo json_encode($json);


	}

}

/* End of file Tugas.php */
/* Location: ./application/controllers/Tugas.php */