<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mapel extends MY_Controller {

	public $_gambarSampulPath = './upload/mapel/';

    function __construct() {
        parent::__construct();
        $this->db->query("SET time_zone='+7:00'");
        $waktu_sql = $this->db->query("SELECT NOW() AS waktu")->row_array();
        $this->waktu_sql = $waktu_sql['waktu'];
        $this->opsi = array("a","b","c","d","e");
        $this->load->model('m_kelas');
        $this->load->model('m_mapel');
        $this->load->model('m_admin');
        $this->load->model('m_mapel_cs');
        $this->load->model('m_instansi');
        $this->load->model('m_materi');
        $this->load->model('m_detail_mapel');
        $this->page_title = 'Modul Pelatihan';
	}
	

	public function index() {

		$data = [
			'searchFilter' => ['Nama Modul'],
			'instansi' => ($this->log_lvl == 'admin') ? $this->m_instansi->get_all() : $this->m_instansi->get_many_by(['id'=>$this->akun->instansi]) 
		];

		$this->render_siswa('mapel/daftar', $data);
	}


	public function page_load($pg = 1) {
		$this->load->model('m_mapel_cs');
		$post = $this->input->post();
		$limit = 6;
		$where = [];

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
		$data['paginate']['url']	= 'mapel/page_load';
		$data['paginate']['search'] = 'lookup_key';
		$data['page_start'] = $paginate['counts']['from_num'];

		$data['paging'] = $this->gen_paging($data['paginate']);


		$this->load->view('mapel/data', $data);

		
	}


	public function materi($id=null) {
		$data = array('id' => decrypt_url($id), );
		$this->render_siswa('mapel/daftar_materi',$data);
	}


	public function page_load_materi($pg = 1) {
		$this->load->model('m_mapel_cs');
		$post = $this->input->post();
		$limit = $post['limit'];
		$where = [];

		$where['id_mapel'] = $post['id_mapel'];
		$where['is_verify'] = 1;
		if (!empty($post['search'])) {
			switch ($post['filter']) {
				case 0:
				$where["(lower(mp.nama) like '%".strtolower($post['search'])."%' )"] = null;
				break;
						# code...
				break;
			}
		}

		$paginate = $this->m_materi->paginate($pg, $where, $limit, $post);
		$data['paginate'] = $paginate;
		$data['paginate']['url']	= 'mapel/page_load_materi';
		$data['paginate']['search'] = 'lookup_key';
		$data['page_start'] = $paginate['counts']['from_num'];

		$data['paging'] = $this->gen_paging($data['paginate']);


		$this->load->view('mapel/data_materi', $data);

		
	}

	public function insert()
	{
		$post = $this->input->post();
		$data = [
			'kd_mp' => $post['kode'],
			'nama' => $post['nama'],
			'id_instansi' => $this->akun->instansi
		];

		// For response ajax data
		$responseCode = 200;
		$returnedData = [];

		if(isset($_FILES['gambar_sampul'])) {
			$fileName = uniqid() . '_' . $_FILES['gambar_sampul']['name'];

			$config['upload_path']   = 'upload/mapel/';
            $config['allowed_types'] = 'png|jpg|jpeg|gif';
            $config['max_size']      = 3240; // 3 MB
            $config['file_name']     = $fileName;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if(!$this->upload->do_upload('gambar_sampul')) {
            	$this->sendAjaxResponse([
            		'status' => FALSE,
            		'msg' => 'Tidak bisa mengupload gambar, ' . $this->upload->display_errors(),
            		'info' => $this->upload->display_errors()
            	], 500);
            	exit;
            }
            else {
            	$uploaded = $this->upload->data();
            	$data['file'] = $uploaded['file_name'];
            }        
		}

		$insert = $this->m_mapel->insert($data);
        if($insert) {
        	$returnedData = [
        		'status' => TRUE,
        		'msg' => 'Berhasil membuat mata pelajaran'
        	];
        	$responseCode = 200;
        }
        else {
        	$returnedData = [
        		'status' => FALSE,
        		'msg' => 'Gagal membuat mata pelajaran'
        	];
        	$responseCode = 500;	
        }

        $this->sendAjaxResponse($returnedData, $responseCode);
	}

	/*
	* Get detail mapel ( if admin click edit btn )
	*/
	public function getDetail()
	{
		$post = $this->input->post();
		$id = decrypt_url($post['id']);

		$data = $this->m_mapel->get_by(['id' => $id]);
		if(!is_null($data->file)) {
			$data->file = base_url($this->_gambarSampulPath . $data->file);
		}

		$this->sendAjaxResponse([
			'status' => TRUE,
			'data' => $data
		]);
	}

	public function update()
	{
		$post = $this->input->post();
		$id = decrypt_url($post['id']);

		$data = [
			'kd_mp' => $post['kode'],
			'nama' => $post['nama']
		];

		// For response ajax data
		$responseCode = 200;
		$returnedData = [];

		if(isset($_FILES['gambar_sampul'])) {
			$fileName = uniqid() . '_' . $_FILES['gambar_sampul']['name'];

			$config['upload_path']   = 'upload/mapel/';
            $config['allowed_types'] = 'png|jpg|jpeg|gif';
            $config['max_size']      = 3240; // 3 MB
            $config['file_name']     = $fileName;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if(!$this->upload->do_upload('gambar_sampul')) {
            	$this->sendAjaxResponse([
            		'status' => FALSE,
            		'msg' => 'Tidak bisa mengupload gambar, ' . $this->upload->display_errors(),
            		'info' => $this->upload->display_errors()
            	], 500);
            	exit;
            }
            else {
            	$uploaded = $this->upload->data();
            	$data['file'] = $uploaded['file_name'];
            	// Hapus file yang sudah ada
            	$oldData = $this->m_mapel->get_by(['id' => $id]);
            	if(is_file($this->_gambarSampulPath . $oldData->file) && file_exists($this->_gambarSampulPath . $oldData->file)) {
            		unlink($this->_gambarSampulPath . $oldData->file);
            	}
            }
		}


		$update = $this->m_mapel->update($data, ['id' => $id]);

		if($update) {
			$returnedData = [
        		'status' => TRUE,
        		'msg' => 'Data mata pelajaran berhasil diperbaharui'
        	];
        	$responseCode = 200;
		}
		else {
			$returnedData = [
        		'status' => FALSE,
        		'msg' => 'Data mata pelajaran gagal diperbaharui'
        	];
        	$responseCode = 500;	
		}

		$this->sendAjaxResponse($returnedData, $responseCode);
	}

	/*
	* Delete mapel dan set semua materi dengan ke NULL jadi tidak terhapus
	*/
	public function delete()
	{
		$post = $this->input->post();
		$id = decrypt_url($post['id']);
		$returnedData = [];
		$responseCode = 200;

		// Update id_mapel in m_materi set to NULL
		$update = $this->m_materi->update([
			'id_mapel' => NULL
		], ['id_mapel' => $id ]);

		// Hapus gambar sampul mapel
		$dataMapel = $this->m_mapel->get_by(['id' => $id]);
		if(!is_null($dataMapel->file) && file_exists($this->_gambarSampulPath . $dataMapel->file)) {
			unlink($this->_gambarSampulPath . $dataMapel->file);
		}

		$delete = $this->m_mapel->delete(['id' => $id]);

		if($update && $delete) {
			$returnedData = [
				'status' => TRUE,
				'msg' => 'Data Mata pelajaran berhasil dihapus'
			];
			$responseCode = 200;
		}
		else {
			$returnedData = [
				'status' => FALSE,
				'msg' => 'Data Mata pelajaran gagal dihapus'
			];
			$responseCode = 500;	
		}

		$this->sendAjaxResponse($returnedData, $responseCode);
	}

	public function update_guru_mapel() {
		
		$post = $this->input->post(null, true);

  		$data = [
  			'id_mapel' => $post['id_mapel'],
  			'id_guru'  => $post['id_guru'],
  		];

  		if($post['aktif'] == 1) {
  			$this->m_detail_mapel->insert($data);
  		}
  		else {
  			$this->m_detail_mapel->delete($data);	
  		}

  		$this->sendAjaxResponse($data, 200);
	}
	
	public function page_load_mapel_guru($pg = 1) {
		$post = $this->input->post();
		$limit = $post['limit'];
		$where = [];
		// $where['dmapel.id_guru'] = $post['id'];
		// $where['is_verify'] = 1;
		$where['id_instansi'] = $this->akun->instansi;
		if (!empty($post['search'])) {
			switch ($post['filter']) {
				case 0:
				$where["(lower(nama) like '%".strtolower($post['search'])."%' )"] = null;
				break;
						# code...
				break;
			}
		}
		$paginate = $this->m_mapel->paginate_mapel_guru($pg, $where, $limit);
		foreach($paginate['data'] as $d) {
			$d->id_guru = $post['id'];
		}
		// print_r($paginate);exit;

		$data['paginate'] = $paginate;
		$data['paginate']['url']	= 'mapel/page_load_mapel_guru';
		$data['paginate']['search'] = 'lookup_key';
		$data['page_start'] = $paginate['counts']['from_num'];
	
		$this->load->view('modul_pelatihan/table_murid', $data);		
		$this->generate_page($data);
	}

	public function daftar_mapel($pg = 1) {
		$post = $this->input->post();
		// print_r($paginate);exit;
		$data = [
			'searchFilter' => ['Mata Pelajaran'],
			'id_mapel' => $post['id_mapel']
		];
		
		// print_r($data['paginate']);exit;

		$this->load->view('modul_pelatihan/daftar_murid', $data);
		
	}

	public function get_mapel_penilaian()
	{
		$this->load->model('m_detail_kelas_mapel');
		$post = $this->input->post();
		$idKelas = $post['id_kelas'];
		$idGuru = $post['id_guru'];
		$res = $this->m_detail_kelas_mapel->get_many_by(['id_kelas' => $idKelas, 'guru.id' => $idGuru]);

		if(count($res) > 0) {
			$html = '<option disabled="disabled" value="0" selected="selected">Pilih</option>';

			foreach($res as $row) {
				$mapel = $this->m_mapel->get_by(['id' => $row->id_mapel]);
				$nama_mapel = !empty($mapel->nama) ? $mapel->nama : '';
				$html .= '<option value="'. $row->id_mapel .'" >'.$nama_mapel.'</option>';
			}
		}
		else {
			$html = '<option disabled="disabled" value="0" selected="selected">Data Kosong</option>';
		}

		$this->sendAjaxResponse([
			'status' => TRUE,
			'data' => $html
		], 200);
	}

	public function get_mapel() 
	{
		$this->load->model('m_detail_kelas_mapel');
		$post = $this->input->post();
		$id_kelas = $post['id_kelas'];
		$html = '';
		if($this->log_lvl == 'guru') {
			$res = $this->m_detail_kelas_mapel->get_many_by(['id_kelas' => $id_kelas,'guru.id'=>$this->akun->id]);
		}
		else {
			$res = $this->m_detail_kelas_mapel->get_many_by(['id_kelas' => $id_kelas]);	
		}

		if(count($res) > 0) {
			$html = '<option disabled="disabled" value="null" selected="selected">Pilih</option>';

			foreach($res as $row) {
				$mapel = $this->m_mapel->get_by(['id' => $row->id_mapel]);
				$nama_mapel = !empty($mapel->nama) ? $mapel->nama : '';
				$html .= '<option value="'. $row->id_mapel .'" >'.$nama_mapel.'</option>';
			}
		}
		else {
			$html = '<option disabled="disabled" value="null" selected="selected">Data Kosong</option>';			
		}

		echo $html;
	}
}
