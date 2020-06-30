<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");

class Dimensi extends MY_Controller {
	function __construct() {
        parent::__construct();
        $this->load->model('m_dimensi');
	}

	public function index() {
		redirect('dimensi/list');
	}

	public function list() {
		$this->page_title = 'Dimensi';
    	$data = array(
			'searchFilter' => array('Nama')
		);
		$this->render('dimensi/list',$data);
	}

	public function edit($id = NULL) {
		if($id === NULL) {
			$this->sendAjaxResponse([
				'status' => FALSE,
				'msg' => 'Tentukan datanya'
			], 500);
		}

		$result = $this->m_dimensi->get_by(['id' => $id]);
		$this->sendAjaxResponse([
			'status' => TRUE,
			'msg' => 'Get detail dimensi berhasil',
			'data' => $result
		], 200);
	}

	public function insert() {
		$post = $this->input->post();

		$data = [
			'nama' => $post['nama'],
			'bobot' => $post['bobot']
		];

		$insert = $this->m_dimensi->insert($data);

		if($insert) {
			echo json_encode([
				'status' => TRUE,
				'msg' => 'Dimensi berhasil ditambah'
			]);
			http_response_code(200);
		}
		else {
			echo json_encode([
				'status' => FALSE,
				'msg' => 'Dimensi gagal ditambah'
			]);
			http_response_code(500);
		}
	}

	public function update() {
		$post = $this->input->post();

		$data = [
			'nama' => $post['nama'],
			'bobot' => $post['bobot']
		];

		$update = $this->m_dimensi->update($data, ['id' => $post['id']]);

		if($update) {
			$this->sendAjaxResponse([
				'status' => TRUE,
				'msg' => 'Data berhasil terupdate'
			], 200);
		}
		else {
			$this->sendAjaxResponse([
				'status' => FALSE,
				'msg' => 'Data gagal terupdate'
			], 500);	
		}
	}

	public function multi_delete() {
		$post = $this->input->post();
		foreach ($post['id'] as $val) {
			$where[] = $val;
		}

		$this->db->trans_begin();
		$delete = $this->db->where_in('id', $where)->delete('tb_dimensi');

		if($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		}
		else {
			$this->db->trans_commit();
		}

		if($delete) {
			$this->sendAjaxResponse([
				'status' => TRUE
			], 200);
		}
		else {
			$this->sendAjaxResponse([
				'status' => TRUE,
				'msg' => 'Data berhasil dihapus'
			], 500);	
		}

	}

	// Load data for table
	public function page_load($pg = 1) {
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

		$paginate = $this->m_dimensi->paginate($pg,$where,$limit);

		$data['paginate'] = $paginate;

		$data['paginate']['url']	= 'dimensi/page_load';

		$data['paginate']['search'] = 'lookup_key';

		$data['page_start'] = $paginate['counts']['from_num'];

		$this->load->view('dimensi/table',$data);
		$this->generate_page($data);
	}
}