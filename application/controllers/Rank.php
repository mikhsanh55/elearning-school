<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rank extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_rank');
	}

	public function index()
	{	

		$data = array(
			'searchFilter' => array('nama')
		);

		$this->render('rank/list',$data);
	}


	public function page_load($pg = 1){
		$post = $this->input->post();
		$limit = $post['limit'];
		$where = [];

		// if($this->log_lvl == 'guru'){
		// 	$where['gr.id'] = $this->log_id;
		// }
		
		if (!empty($post['search'])) {
			switch ($post['filter']) {
				case 0:
					$where["(lower(sis.nama) like '%".strtolower($post['search'])."%' )"] = null;
					break;
				default:
					# code...
					break;
			}
		}
		$paginate = $this->m_rank->paginate($pg,$where,$limit);
		
		$data['paginate'] = $paginate;
		$data['paginate']['url']	= 'rank/page_load';
		$data['paginate']['search'] = 'lookup_key';
		$data['page_start'] = $paginate['counts']['from_num'];

		$this->load->view('rank/table',$data);
		$this->generate_page($data);
	}

	public function aktivasi_materi($id)
	{	

		$data = array(
			'trainer' => $this->m_guru->get_all(),
			'rank' => $this->m_rank->get_by(array('md5(id)'=>$id)),
		);
		$this->render('rank/aktivasi_materi',$data);
	}

	public function setting_peserta($rank,$mapel)
	{	

		$data = array(
			'mapel' => $this->m_mapel->get_by(array('md5(id)'=>$mapel)),
			'rank' => $this->m_rank->get_by(array('md5(id)'=>$rank)),
		);
		$this->render('rank/setting_peserta',$data);
	}

	public function pageload_materi($pg = 1){
		$post = $this->input->post();
		$limit = $post['limit'];
		$where = [];
		if (!empty($post['trainer'])) {
			$where["gr.id"] = $post['trainer'];
		}
		$paginate = $this->m_mapel_cs->paginate($pg,$where,$limit);
		$data['paginate'] = $paginate;
		$data['paginate']['url']	= 'rank/pageload_materi';
		$data['paginate']['search'] = 'lookup_key';
		$data['page_start'] = $paginate['counts']['from_num'];
		$data['id_rank'] = $post['id_rank'];

		$this->load->view('rank/table_materi',$data);
		$this->generate_page($data);
	}

	public function pageload_peserta($pg = 1){
		$post = $this->input->post();
		$limit = $post['limit'];
		$where = [];
		
		$where["rank"] = $post['id_rank'];
		
		$paginate = $this->m_siswa->paginate($pg,$where,$limit);
		$data['paginate'] = $paginate;
		$data['paginate']['url']	= 'rank/pageload_peserta';
		$data['paginate']['search'] = 'lookup_key';
		$data['page_start'] = $paginate['counts']['from_num'];
		$data['id_rank'] = $post['id_rank'];
		$data['id_mapel'] = $post['id_mapel'];

		$this->load->view('rank/table_peserta',$data);
		$this->generate_page($data);
	}

	public function update_aktivasi(){
		$post = $this->input->post(null,true);
		if ($post['aktif'] == 1) {
			$data = array(
				'id_mapel'    => $post['id_mapel'], 
				'id_rank' => $post['id_rank'], 
			);
			$this->m_materi_rank->insert($data);
		}else{
			$this->m_materi_rank->delete(array('id_rank'=>$post['id_rank'],'id_mapel' => $post['id_mapel']));
		}

	}

	public function update_block_peserta(){
		$post = $this->input->post(null,true);
		if ($post['aktif'] == 1) {
			$data = array(
				'id_peserta'    => $post['id_peserta'], 
				'id_rank' => $post['id_rank'], 
				'id_mapel' => $post['id_mapel'], 
			);
			$this->m_block_materi->insert($data);
		}else{
			$this->m_block_materi->delete(array('id_rank'=>$post['id_rank'],'id_peserta' => $post['id_peserta'],'id_mapel' => $post['id_mapel']));
		}

	}

	public function aktif_non(){
		$post = $this->input->post(null,true);
		if ($post['deleted'] == 0) {
			$post['deleted'] = 1;
		}else{
			$post['deleted'] = 0;
		}
		$kirim = $this->m_rank->update(array('deleted'=>$post['deleted']),array('id'=>$post['id']));
		if ($kirim) {
			$result = true;
		}else{
			$result = false;
		}

		

		echo json_encode(array('result'=>$result,'deleted'=>$post['deleted'],'id'=>$post['id']));

	}

}

/* End of file instantsi.php */
/* Location: ./application/controllers/instantsi.php */