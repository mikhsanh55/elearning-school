<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Instansi extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_instansi');
		$this->load->model('m_mapel');
		$this->load->model('m_mapel_cs');
		$this->load->model('m_guru');
		$this->load->model('m_materi_instansi');
		$this->load->model('m_siswa');
		$this->load->model('m_kelas');
	}

	public function index()
	{	
        
		$data = array(
			'searchFilter' => array('Instansi','nama pimpinan','no telp','alamat')
		);

		$this->render('instansi/list',$data);
	}

	public function add()
	{	

		$data = array(
			'searchFilter' => array('Instansi','nama pimpinan','no telp','email','alamat')
		);

		$this->render('instansi/add',$data);
	}

	public function edit($id=null)
	{	

		$data = array(
			'edit' => $this->m_instansi->get_by(array('MD5(id)'=> $id))
		);


		$this->render('instansi/edit',$data);
	}

	public function insert(){
		$post = $this->input->post(null,true);
		$this->m_instansi->insert($post);
		redirect('instansi');
	}

	public function update(){
		$post = $this->input->post(null,true);


		$this->m_instansi->update($post,array('id'=>$post['id']));
		redirect('instansi');
	}

	public function delete($id){
		$this->m_instansi->delete(array('md5(id)'=>$id));
		redirect('instansi');
	}

	public function page_load($pg = 1){
		$post = $this->input->post();
		$limit = $post['limit'];
		$where = [];
		if (!empty($post['search'])) {
			switch ($post['filter']) {
				case 0:
					$where["(lower(instansi) like '%".strtolower($post['search'])."%' )"] = null;
					break;
				case 1:
					$where["(lower(nama_pimpinan) like '%".strtolower($post['search'])."%' )"] = null;
					break;
				case 2:
					$where["(lower(no_telp) like '%".strtolower($post['search'])."%' )"] = null;
					break;
				case 4:
					$where["(lower(alamat) like '%".strtolower($post['search'])."%' )"] = null;
					break;
				
				default:
					# code...
					break;
			}
		}

		if ($this->log_lvl == 'instansi') {
			$where['id'] = $this->akun->instansi;
		}

		$paginate = $this->m_instansi->paginate($pg,$where,$limit);
		$data['paginate'] = $paginate;
		$data['paginate']['url']	= 'instansi/page_load';
		$data['paginate']['search'] = 'lookup_key';
		$data['page_start'] = $paginate['counts']['from_num'];

		$this->load->view('instansi/table',$data);
		$this->generate_page($data);
	}

	public function aktivasi_materi($id)
	{	

		$data = array(
			'trainer' => ($this->log_lvl == 'admin') ? $this->m_guru->get_all() : $this->m_guru->get_many_by(['instansi'=>$this->akun->instansi]),
			'instansi' => $this->m_instansi->get_by(array('md5(id)'=>$id)),
		);
		$this->render('instansi/aktivasi_materi',$data);
	}

	public function pageload_materi($pg = 1){
		$post = $this->input->post();
		$limit = $post['limit'];
		$where = [];
		if (!empty($post['trainer'])) {
			$where["gr.id"] = $post['trainer'];
		}
		if($this->log_lvl != 'admin'){
			$where['gr.instansi'] = $this->akun->instansi;
		}

		$paginate = $this->m_mapel_cs->paginate($pg,$where,$limit);
		$data['paginate'] = $paginate;
		$data['paginate']['url']	= 'instansi/pageload_materi';
		$data['paginate']['search'] = 'lookup_key';
		$data['page_start'] = $paginate['counts']['from_num'];
		$data['id_instansi'] = $post['id_instansi'];
 
		$this->load->view('instansi/table_materi',$data);
		$this->generate_page($data);
	}


	public function update_aktivasi(){
		$post = $this->input->post(null,true);
		$data = array(
			'id_mapel'    => $post['id_mapel'], 
			'id_instansi' => $post['id_instansi'], 
			'id_trainer'  => $post['id_trainer'], 
		);
		if ($post['aktif'] == 1) {
			$action = 1;
			$this->m_materi_instansi->insert($data);
		}else{
			$this->m_materi_instansi->delete($data);
			$action = 2;
		}

		$json = array(
			'id_mapel'    => $post['id_mapel'], 
			'id_instansi' => $post['id_instansi'], 
			'id_trainer'  => $post['id_trainer'], 
			'id_mapel_enc'  =>md5($post['id_mapel']), 
			'id_trainer_enc'  => md5($post['id_trainer']),
			'url' => base_url('instansi/setting_peserta/'.md5($post['id_instansi']).'/'.md5($post['id_mapel']).'/'.md5($post['id_trainer'])),
			'action' => $action
		);

		echo json_encode($json);

	}

	public function update_kelas(){
		$post = $this->input->post(null,true);

		$data = array(
			'id_peserta'    => $post['id_peserta'], 
			'id_trainer'    => $post['id_trainer'], 
			'id_instansi' => $post['id_instansi'], 
			'id_mapel' => $post['id_mapel'], 
		);

		if ($post['aktif'] == 1) {
			$this->m_kelas->insert($data);
		}else{
			$this->m_kelas->delete($data);
		}

		$json = array(
			'id_peserta'    => $post['id_peserta'], 
			'id_trainer'    => $post['id_trainer'], 
			'id_instansi' => $post['id_instansi'], 
			'id_mapel' => $post['id_mapel'], 
		);

		echo json_encode($json);

	}

	public function aktif_non(){
		$post = $this->input->post(null,true);
		if ($post['deleted'] == 0) {
			$post['deleted'] = 1;
		}else{
			$post['deleted'] = 0;
		}
		$kirim = $this->m_instansi->update(array('deleted'=>$post['deleted']),array('id'=>$post['id']));
		if ($kirim) {
			$result = true;
		}else{
			$result = false;
		}

		

		echo json_encode(array('result'=>$result,'deleted'=>$post['deleted'],'id'=>$post['id']));

	}

	public function aktifkan_semua_peserta(){
		$post = $this->input->post();
		$siswa = $this->m_siswa->get_many_by(array('in.id'=>$post['id_instansi']));

		$data = array();
		foreach ($siswa as $key => $rows) {
			$data[$key] = array(
				'id_peserta' 	=> $rows->id,
				'id_mapel'	 	=> $post['id_mapel'],
				'id_trainer' 	=> $post['id_trainer'],
				'id_instansi' 	=> $post['id_instansi']
			);
		}

		$where = array(
			'id_mapel'	 	=> $post['id_mapel'],
			'id_trainer' 	=> $post['id_trainer'],
			'id_instansi' 	=> $post['id_instansi']
		);

		$this->db->trans_begin();

		$this->m_kelas->delete($where);
		$this->db->insert_batch('tb_kelas',$data);


		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
		}
		else
		{
			$this->db->trans_commit();
		}

		echo json_encode(array('result'=>true));
	}

	public function nonaktifkan_semua_peserta(){
		$post = $this->input->post();

		$where = array(
			'id_mapel'	 	=> $post['id_mapel'],
			'id_trainer' 	=> $post['id_trainer'],
			'id_instansi' 	=> $post['id_instansi']
		);

		$this->db->trans_begin();

		$this->m_kelas->delete($where);

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
		}
		else
		{
			$this->db->trans_commit();
		}

		echo json_encode(array('result'=>true));
	}

}

/* End of file instantsi.php */
/* Location: ./application/controllers/instantsi.php */