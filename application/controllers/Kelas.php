<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Kelas extends MY_Controller

{

    

  public function __construct()

  {

    parent::__construct();

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



		$data = array(

			'searchFilter' => array('Kelas','Modul Pelatihan')

		);

		$this->render('kelas/list',$data);

  }



  public function guru(){

    

    	if ($this->log_lvl == 'siswa') {

     		redirect(base_url('kelas/siswa'));

    	}



		$data = array(

			'searchFilter' => array('Nama','Username','NRP','Kelompok')

		);

		$this->render('kelas/list_guru',$data);

  }

  

  public function siswa(){

		$data = array(

			'searchFilter' => array('Nama','Modul Pelatihan')

		);

		$this->render('kelas/list_siswa',$data);

	}



  public function add(){

		$data = array(

			'guru'     => $this->m_guru->get_many_by(['instansi'=>$this->akun->instansi]),

			'jurusan' => $this->m_jurusan->get_many_by(['id_instansi'=>$this->akun->instansi])

		);

		$this->render('kelas/add',$data);

  }



  public function edit($id=NULL){

		$data = array(

			'guru'     => $this->m_guru->get_many_by(['instansi'=>$this->akun->instansi]),

			'jurusan' => $this->m_jurusan->get_many_by(['id_instansi'=>$this->akun->instansi]),

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

      'id_trainer'  => $post['id_trainer'],

      'id_mapel'    => $post['mapel'],

	  'id_instansi' => $this->akun->instansi,

	  'id_jurusan'  => $post['id_jurusan'],

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

	  'id_trainer'  => $post['id_trainer'],

      'id_mapel'    => $post['mapel'],

	  'id_instansi' => $this->akun->instansi,

	  'id_mapel'    => $post['mapel'],

	  'id_jurusan'  => $post['id_jurusan'],

    ];



    $send = $this->m_kelas->update($data,['id'=>$post['id']]);

    $result = ($send) ? true : false ;

    $msg = ($send) ? 'Berhasil mengupdate kelas !' : 'Gagal mengupdate Kelas' ;



    $json = ['result' => $result,'message'=>$msg];

    echo json_encode($json);

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

					$where["(lower(mp.nama) like '%".strtolower($post['search'])."%' )"] = null;

					break;

				default:

					# code...

					break;

			}

		}



		if($this->log_lvl == 'guru'){

			$where['kls.id_trainer'] = $this->akun->id;

		}



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





  public function page_load_siswa($pg = 1){

		$post = $this->input->post();

		$limit = $post['limit'];

		$where = [];



		if($this->log_lvl != 'admin'){

			$where['kls.id_instansi'] = $this->akun->instansi;

		}



		if($this->log_lvl == 'siswa'){

			$where['dekls.id_peserta'] = $this->akun->id;

		}



		if (!empty($post['search'])) {

			switch ($post['filter']) {

				case 0:

					$where["(lower(kls.nama) like '%".strtolower($post['search'])."%' )"] = null;

					break;

				case 1:

					$where["(lower(mp.nama) like '%".strtolower($post['search'])."%' )"] = null;

					break;

				default:

					# code...

					break;

			}

		}

		$paginate = $this->m_kelas->paginate_siswa($pg,$where,$limit);

		$data['paginate'] = $paginate;

		$data['paginate']['url']	= 'kelas/page_load';

		$data['paginate']['search'] = 'lookup_key';

		$data['page_start'] = $paginate['counts']['from_num'];



		$this->load->view('kelas/table_siswa',$data);

		$this->generate_page($data);

  }

  

  public function daftar_murid(){

    $post = $this->input->post();



		$data = array(

			'searchFilter' 	=> array('Nama','Username','NRP','Kelompok'),

			'kelas' 		=> $this->m_kelas->get_by(['kls.id'=>$post['id']]),

			'id_jurusan' 	=> $post['id_jurusan']

		);

		$this->load->view('kelas/setting_peserta',$data);

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

		$where["akun.id_jurusan"] = $post['id_jurusan'];



		if ($post['search']) {

			$where["(lower(nama) like '%".strtolower($post['search'])."%' )"] = null;

		}

		

		$paginate = $this->m_siswa->paginate($pg,$where,$limit);

		$data['paginate'] = $paginate;

		$data['paginate']['url']	= 'kelas/page_load_murid';

		$data['paginate']['search'] = 'lookup_key';

    	$data['page_start'] = $paginate['counts']['from_num'];

    

		$data['id_kelas'] = $post['id_kelas'];





		$this->load->view('kelas/table_peserta',$data);

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

  







}





/* End of file Kelas.php */

/* Location: ./application/controllers/Kelas.php */