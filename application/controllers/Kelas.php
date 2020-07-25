<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Kelas extends MY_Controller

{

  public $name = 'Kelas';  

  public function __construct()

  {

    parent::__construct();

    $this->load->model('m_detail_kelas_mapel');

    $this->load->model('m_detail_mapel');

	$this->load->model('m_instansi');

	$this->load->model('m_guru');

    $this->load->model('m_mapel_cs');

    $this->load->model('m_kelas');

	$this->load->model('m_detail_kelas');

	$this->load->model('m_jurusan');

	

  }



  public function index(){

    

    if ($this->log_lvl == 'siswa') {

      redirect(base_url('kelas/siswa'));

    }else if($this->log_lvl == 'guru'){

		redirect(base_url('kelas/guru'));

	}

	$data = $this->m_kelas->get_all();
	// print_r($data);exit;

		$data = array(

			'searchFilter' => array('Kelas','Wali Kelas'),


		);

		$this->render('kelas/list',$data);

  }


  public function guru(){

    

    	if ($this->log_lvl == 'siswa') {

     		redirect(base_url('kelas/siswa'));

    	}



		$data = array(

			'searchFilter' => array('Kelas', 'Wali Kelas', 'Mata Pelajaran')

		);

		$this->render('kelas/list_guru',$data);

  }

  

  public function siswa(){
  		$siswa = $this->m_detail_kelas->get_by(['id_peserta' => $this->session->admin_konid]);
  		$kelas = $this->m_kelas->get_by(['kls.id' => $siswa->id_kelas]);
  		
		$data = array(

			'searchFilter' => array('Nama Guru','Mata Pelajaran'),
			'id_kelas' => $siswa->id_kelas,
			'nama_kelas' => $kelas->nama

		);

		$this->render('kelas/list_siswa',$data);

	}



  public function add(){
  		
  		if($this->log_lvl == 'admin' || $this->log_lvl == 'admin_instansi' || $this->log_lvl == 'instansi') {
  			$guru = $this->m_guru->get_many_by(['instansi'=>$this->akun->instansi]);
  		}
  		else if($this->log_lvl == 'guru') {
  			$guru = $this->m_guru->get_many_by(['instansi'=>$this->akun->instansi, 'guru.id' => $this->session->admin_konid]);
  		}

		$data = array(
			'guru' => $this->m_guru->get_many_by(['instansi' => $this->akun->instansi]),
			'mapel' => $this->m_mapel->get_many_by(['id_instansi' => $this->akun->instansi])
		);
		
		// print_r($data['mapel']);exit;
		$this->render('kelas/add',$data);

  }



  public function edit($id=NULL){

		$data = array(

			'guru' => $this->m_guru->get_many_by(['instansi' => $this->akun->instansi]),
			'mapel' => $this->m_mapel->get_many_by(['id_instansi' => $this->akun->instansi]),
			'edit'     => $this->m_kelas->get_by(['kls.id'=>decrypt_url($id)]) 

		);

		$this->render('kelas/add',$data);

  }

  

  public function insert()

  {

    $post   = $this->input->post();



    $data = [

      'nama'        => $post['nama'],

      'keterangan'  => $post['keterangan'],

      'id_trainer'  => $post['id_trainer'], // Wali Kelas

      // 'id_mapel'    => implode(',', $post['mapel']),

	  'id_instansi' => $this->akun->instansi,

    ];



    $send = $this->m_kelas->insert($data);

    $result = ($send) ? true : false ;

    $msg = ($send) ? 'Berhasil menambah kelas !' : 'Gagal Menambah Kelas' ;



    $json = ['result' => $result,'message'=>$msg];

    echo json_encode($json);

  }



  public function update()

  {

    $post   = $this->input->post();



    $data = [

       'nama'        => $post['nama'],

      'keterangan'  => $post['keterangan'],

      'id_trainer'  => $post['id_trainer'], // Wali Kelas

      // 'id_mapel'    => implode(',', $post['mapel']),

	  'id_instansi' => $this->akun->instansi,

	  // 'id_jurusan'  => $post['id_jurusan'],

    ];



    $send = $this->m_kelas->update($data,['id'=>$post['id']]);

    $result = ($send) ? true : false ;

    $msg = ($send) ? 'Berhasil mengupdate kelas !' : 'Gagal mengupdate Kelas' ;



    $json = ['result' => $result,'message'=>$msg];

    echo json_encode($json);

  }

  public function page_load_guru($pg = 1) {
  	$post = $this->input->post();
  	$limit = $post['limit'];
  	$where = [];

  	$where['dmapel.id_guru'] = $this->session->admin_konid;
  	
	if(!empty($post['search'])) {
		switch($post['filter']) {
			case 0:
				$where["(lower(kls.nama) like '%" . strtolower($post['search']) . "%' )"] = null;
			break;
			case 1: 
				$where["(lower(gr.nama) like '%" . strtolower($post['search']) . "%' )"] = null;
			break;
			case 2: 
				$where["(lower(mp.nama) like '%" . strtolower($post['search']) . "%' )"] = null;
			break;
		}	
	}

	$paginate = $this->m_kelas->paginate_guru(1, $limit, $where);

	$data['paginate'] = $paginate;

	$data['paginate']['url']	= 'kelas/page_load_guru/1';

	$data['paginate']['search'] = 'lookup_key';


	$data['page_start'] = $paginate['counts']['from_num'];

	$this->load->view('kelas/table_guru', $data);
	$this->generate_page($data);

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

					$where["(lower(gr.nama) like '%".strtolower($post['search'])."%' )"] = null;

					break;

				default:

					# code...

					break;

			}

		}

		// if(!empty($post['id_jurusan'])) {
		// 	$where['kls.id_jurusan'] = $post['id_jurusan'];
		// }



		// if($this->log_lvl == 'guru'){

		// 	$where['kls.id_trainer'] = $this->akun->id;

		// }


		if($this->log_lvl != 'admin'){

			$where['kls.id_instansi'] = $this->akun->instansi;

		}


		$paginate = $this->m_kelas->paginate($pg,$where,$limit);

		$data['paginate'] = $paginate;

		$data['paginate']['url']	= 'kelas/page_load';

		$data['paginate']['search'] = 'lookup_key';

		$data['page_start'] = $paginate['counts']['from_num'];



		if($this->log_lvl == 'guru'){

			$this->load->view('kelas/table_guru',$data);

		}else{

			$this->load->view('kelas/table',$data);

		}



		$this->generate_page($data);

  }

  public function page_load_mapel($pg = 1) {
  	$post = $this->input->post();
  	$limit = $post['limit'];
  	$where = [];

  	// $where['dmapel.id_kelas'] = $post['id_kelas'];
  	$where['mapel.id_instansi'] = $this->akun->instansi;
  	if(!empty($post['search'])) {
  		switch($post['filter']) {
  			case 0: 
  				$where["(lower(mapel.nama) like '%" . strtolower($post['search']) . "%' )"] = null;
  				
  			break;
  			case 1:
  				$where["(lower(guru.nama) like '%" . strtolower($post['search']) . "%' )"] = null;
			  break;
			  case 2:
				$where["(lower(guru.username) like '%" . strtolower($post['search']) . "%' )"] = null;
			break;
  		}
  	}

  	$paginate = $this->m_mapel->paginate_mapel($pg, $where, $limit);
  	$data['paginate'] = $paginate;

	$data['paginate']['url']	= 'kelas/page_load_mapel';

	$data['paginate']['search'] = 'lookup_key';

	$data['page_start'] = $paginate['counts']['from_num'];

	$data['id_kelas'] = $post['id_kelas'];



	$this->load->view('kelas/table_mapel',$data);

	$this->generate_page($data);
  }

  public function page_load_siswa($pg = 1){

		$post = $this->input->post();

		$limit = $post['limit'];

		$where = [];

		$where['kls.id'] = $post['id_kelas'];

		if (!empty($post['search'])) {

			switch ($post['filter']) {

				case 0:

					$where["(lower(guru.nama) like '%".strtolower($post['search'])."%' )"] = null;

					break;

				case 1:

					$where["(lower(mapel.nama) like '%".strtolower($post['search'])."%' )"] = null;

					break;

				default:
					break;
			}

		}

		$paginate = $this->m_kelas->paginate_siswa($pg,$where,$limit);
	
		// print_r($paginate);exit;
		$data['paginate'] = $paginate;

		$data['paginate']['url']	= 'kelas/page_load_siswa';

		$data['paginate']['search'] = 'lookup_key';

		$data['page_start'] = $paginate['counts']['from_num'];



		$this->load->view('kelas/table_siswa',$data);

		$this->generate_page($data);

  }

  public function daftar_mapel() {
  	$post = $this->input->post();

  	$data = [
  		'searchFilter' => ['Mata Pelajaran', 'Guru','Username'],
  		'kelas' => $this->m_kelas->get_by(['kls.id' => $post['id_kelas']]),
  		'id_kelas' => $post['id_kelas']
  	];

  	$this->load->view('kelas/setting_mapel', $data);
  }

  /*
  *	Get Data Siswa per kelas
  *	Hak Akses : Admin & Guru
  *	Menu :  Kelas -> Button Pilih Kelas
  */
  public function daftar_murid(){
  	$post = $this->input->post();
  	
  		$filter = $this->log_lvl == 'guru' ? ['Nama', 'NIS'] : ['Nama', 'NIS', 'Kelas'];
		$data = array(

			'searchFilter' 	=> $filter,

			'kelas' 		=> $this->m_kelas->get_join_by(['kls.id'=>$post['id']]),

			'id_kelas' 	=> $post['id_kelas']

		);

		if($this->log_lvl == 'guru') {
			$this->load->view('kelas/setting_peserta_kelas',$data);
		}
		else {
			$this->load->view('kelas/setting_peserta',$data);
		}

	}



	public function daftar_murid2(){

		$post = $this->input->post();

	

			$data = array(

				'searchFilter' 	=> array('Nama'),

				'kelas' 		=> $this->m_kelas->get_by(['kls.id'=>$post['id']]),

				'id_jurusan' 	=> $post['id_jurusan']

			);

			$this->load->view('kelas/daftar_murid',$data);

		}

  

	public function page_load_murid($pg = 1){

		$post = $this->input->post();

		$limit = $post['limit'];

		$where = [];


		$where["akun.instansi"] = $this->akun->instansi;
		$where["akun.is_graduated"] = 0;
		$where["(dkls.id_kelas = ".$post['id_kelas']." OR dkls.id_peserta is null)"] = NULL;


 


		if ($post['search']) {
			switch($post['filter']) {
				case 0:
					$where["(lower(akun.nama) like '%".strtolower($post['search'])."%' )"] = null;
				break;

				case 1:
					$where["(lower(akun.nrp) like '%".strtolower($post['search'])."%' )"] = null;
				break;

				case 2: 
					$where["(lower(kls.nama) like '%".strtolower($post['search'])."%' )"] = null;
				break;

			}

		}

		$paginate = $this->m_siswa->paginate_siswa_not_class($pg,$where,$limit);
		// print_r($this->db->last_query());exit;
		$checked_siswa = [];
		$unchecked_siswa = [];
		foreach($paginate['data'] as $rows) {
			$check_kelas = $this->m_detail_kelas->count_by(['id_peserta'=>$rows->id,'id_kelas'=>$post['id_kelas']]);
			if($check_kelas > 0) {
				$checked_kelas[] = $rows;
			}
			else {
				$unchecked_kelas[] = $rows;
			}
		}

		$data['paginate'] = $paginate;

		$data['paginate']['url']	= 'kelas/page_load_murid';

		$data['paginate']['search'] = 'lookup_key';

    	$data['page_start'] = $paginate['counts']['from_num'];

    

		$data['id_kelas'] = $post['id_kelas'];


		// print_r($this->db->last_query());exit;


		$this->load->view('kelas/table_peserta',$data);

		$this->generate_page($data);

		

  }

  // Buat Guru lihat Siswa per kelas
  public function page_load_murid_kelas($pg = 1){

		$post = $this->input->post();

		$limit = $post['limit'];

		$where = [];
		// $where["akun.instansi"] = $this->akun->instansi;

		$where["dk.id_kelas"] = $post['id_kelas'];
		$where["sis.is_graduated"] = 0;

		if ($post['search']) {
			switch($post['filter']) {
				case 0:
					$where["(lower(sis.nama) like '%".strtolower($post['search'])."%' )"] = null;
				break;

				case 1:
					$where["(lower(sis.nrp) like '%".strtolower($post['search'])."%' )"] = null;
				break;
			}
			

		}
		$paginate = $this->m_detail_kelas->paginate($pg,$where,$limit);

		$data['paginate'] = $paginate;

		$data['paginate']['url']	= 'kelas/page_load_murid_kelas';

		$data['paginate']['search'] = 'lookup_key';

    	$data['page_start'] = $paginate['counts']['from_num'];

		$data['id_kelas'] = $post['id_kelas'];





		$this->load->view('kelas/table_peserta_kelas',$data);

		$this->generate_page($data);

  }



  public function page_load_murid2($pg = 1){

	$post = $this->input->post();

	$limit = $post['limit'];

	$where = [];

	$where["kls.id"] =$post['id_kelas'];

	if ($post['search']) {

		$where["(lower(sis.nama) like '%".strtolower($post['search'])."%' )"] = null;

	}

	

	$paginate = $this->m_kelas->paginate_siswa($pg,$where,$limit);

	$data['paginate'] = $paginate;

	$data['paginate']['url']	= 'kelas/page_load_murid';

	$data['paginate']['search'] = 'lookup_key';

	$data['page_start'] = $paginate['counts']['from_num'];



	$data['id_kelas'] = $post['id_kelas'];





	$this->load->view('kelas/table_murid',$data);

	$this->generate_page($data);

}



  	public function update_mapel() {
  		$post = $this->input->post(null, true);

  		$data = [
  			'id_mapel' => $post['id_mapel'],
  			'id_guru'  => $post['id_guru'],
  			'id_kelas' => $post['id_kelas']
  		];

  		if($post['aktif'] == 1) {
  			$this->m_detail_kelas_mapel->insert($data);
  		}
  		else {
  			$this->m_detail_kelas_mapel->delete($data);	
  		}

  		$this->sendAjaxResponse($data, 200);
  	}

	public function update_kelas(){

		$post = $this->input->post(null,true);



		$data = array(

			'id_peserta'    => $post['id_peserta'], 

			'id_kelas'    => $post['id_kelas'], 
		);



		if ($post['aktif'] == 1) {

			$this->m_detail_kelas->insert($data);

		}else{

			$this->m_detail_kelas->delete($data);

		}



		$json = array(

			'id_peserta'    => $post['id_peserta'], 

			'kelas'         => $post['id_kelas'], 

		);



		echo json_encode($json);



  }



  public function update_kelas_all(){

	$post = $this->input->post(null,true);



	if ($post['aksi'] == 1) {



		$siswa = $this->m_siswa->get_many_by(['id_jurusan'=>$post['id_jurusan']]);

		foreach ($siswa as $key => $rows) {

			$data[$key]['id_peserta'] = $rows->id;

			$data[$key]['id_kelas'] = $post['id_kelas'];

		}

		$this->m_detail_kelas->delete(['id_kelas'=>$post['id_kelas']]);

		$this->db->insert_batch('tb_detail_kelas',$data);

		

	}else{

		$this->m_detail_kelas->delete(['id_kelas'=>$post['id_kelas']]);

	}



	$json = array(

		'id_jurusan'    => $post['id_jurusan'], 

		'kelas'         => $post['id_kelas'], 

	);



	echo json_encode($json);



}

  



  public function multi_delete(){

		$post = $this->input->post();



		foreach ($post['id'] as $val) {

			$where[] = $val;

		}



		$this->db->trans_begin();


		$this->db->where_in('id_kelas', $where)->delete('tb_detail_kelas');
		$this->db->where_in('id_kelas', $where)->delete('tb_detail_kelas_mapel');
		$kirim = $this->db->where_in('id',$where)->delete('tb_kelas');



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



	public function get_mapel()

	{

		$post = $this->input->post();

		$mapel = $this->m_mapel_cs->get_many_by(['gr.id'=>$post['id_trainer'],'mp.id_instansi'=>$this->akun->instansi]);

	

		$select = '<option disabled="disabled" selected="selected">Pilih</option>';

		foreach ($mapel as $rows) {

			if($post['id_mapel'] == $rows->id){

				$select .= '<option value="'.$rows->id.'" selected="selected">'.$rows->nama.'</option>';

			}else{

				$select .= '<option value="'.$rows->id.'">'.$rows->nama.'</option>';

			}

		}



		$json = [

			'select' => $select,

		];



		echo json_encode($json);

	}

  	public function riwayat_mengajar($id_jurusan) {

  		if ($this->log_lvl == 'siswa') {
	      redirect(base_url('kelas/siswa'));
	    }else if($this->log_lvl == 'guru'){
			redirect(base_url('kelas/guru'));
		}

  		$data = array(

			'searchFilter' => array('Kelas','Modul Pelatihan'),
			'id_jurusan' => urldecode($id_jurusan)

		);

		$this->render('kelas/list',$data);
  	}

  	// Display Data Mapel per Kelas
  	public function data_mapel() {
  		$post = $this->input->post();
  		$where = [];

  		$where['dkmapel.id_kelas'] = $post['id_kelas'];
  		$data = [
  			'result' => $this->m_kelas->get_data_mapel($where)
  		];
  		// foreach($data['result'] as $i => $d) {
  		// 	$guru = $this->m_guru->get_by(['id_mapel' => $d->id]);
  		// 	// if(count($guru) > 0) {
  				
  		// 	if(!empty($guru)) {
  		// 		$data['result'][$i]->nama_guru = $guru->nama;	
  		// 	}
  		// 	else {
  		// 		$data['result'][$i]->nama_guru = 'Kosong';	
  		// 	}
  		// }
  		// exit;

  		$this->sendAjaxResponse($data, 200);
  	}
}





/* End of file Kelas.php */

/* Location: ./application/controllers/Kelas.php */