<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jadwal extends MY_Controller {



	public function __construct()

	{

		parent::__construct();

		$this->load->model('m_guru');

		$this->load->model('m_mapel');

		$this->load->model('m_materi');

		$this->load->model('m_jadwal');

		$this->load->model('m_kelas');

	

	}



	public function index()

	{	

		$data = array(

			'searchFilter' => array('Trainer','Mata Pelajaran','Materi','keterangan'),

		);

		$this->render('jadwal/list',$data);

	}



	public function add()

	{   



		$warna = array(

			'#0071c5' => 'Dark blue',

			'#40E0D0' => 'Turquoise',

			'#008000' => 'Green',

			'#FFD700' => 'Yellow',

			'#FF8C00' => 'Orange',

			'#FF0000' => 'Red',

			'#000' 	  => 'Black'

		);

		$data = $this->getClient();
		
		if($this->log_lvl == 'guru'){
		    $kelas = $this->m_kelas->get_many_by(['id_trainer'=>$this->akun->id]);
		}else if($this->log_lvl == 'admin'){
		    $kelas = $this->m_kelas->get_all();
		    
		}else{
		    $kelas = $this->m_kelas->get_many_by(['kls.id_instansi'=>$this->akun->instansi]);
		}

		$data = array(

			'kelas' => $kelas,

			'warna'   => $warna

		);

		$this->render('jadwal/add',$data);

	}



	public function edit($id=null)

	{   

		$warna = array(

			'#0071c5' => 'Dark blue',

			'#40E0D0' => 'Turquoise',

			'#008000' => 'Green',

			'#FFD700' => 'Yellow',

			'#FF8C00' => 'Orange',

			'#FF0000' => 'Red',

			'#000' 	  => 'Black'

		);
		
		if($this->log_lvl == 'guru'){
		    $kelas = $this->m_kelas->get_many_by(['id_trainer'=>$this->akun->id]);
		}else if($this->log_lvl == 'admin'){
		    $kelas = $this->m_kelas->get_all();
		    
		}else{
		    $kelas = $this->m_kelas->get_many_by(['kls.id_instansi'=>$this->akun->instansi]);
		}

		$data = array(

			'kelas' => $kelas,

			'edit' 	  => $this->m_jadwal->get_by(array('md5(jwl.id)'=>$id)),

			'warna'   => $warna

		);

		$this->render('jadwal/edit',$data);

	}



	public function get_mp(){

		$get  = $this->m_guru->get_relation(array('gur.id'=>$this->input->post('trainer')));

		$post = $this->input->post();



		if (empty($post['id_mapel'])) {

			$post['id_mapel'] = null;

		}



		$select = '<option value="">Pilih</option>';

		foreach ($get as $rows) {

			if ($rows->id == $post['id_mapel']) {

				$select .= '<option value="'.$rows->id.'" selected>'.$rows->nama.'</option>';

			}else{

				$select .= '<option value="'.$rows->id.'">'.$rows->nama.'</option>';

			}

			

		}





		$json = array('result' => true, 'select' => $select );

		echo json_encode($json);

	}





	public function get_materi(){



		$kelas = $this->m_kelas->get_by(['kls.id'=>$this->input->post('id_kelas')]);



		$get = $this->m_materi->get_many_by(array('id_mapel'=>$kelas->id_mapel,'id_trainer'=>$kelas->id_trainer));





		$post = $this->input->post();



		if (empty($post['id_materi'])) {

			$post['id_materi'] = null;

		}



		$select = '<option value="">Pilih</option>';

		foreach ($get as $rows) {

			if ($rows->id == $post['id_materi']) {

				$select .= '<option value="'.$rows->id.'" selected>'.$rows->title.'</option>';

			}else{

				$select .= '<option value="'.$rows->id.'">'.$rows->title.'</option>';

			}

		}





		$json = array('result' => true, 'select' => $select );

		echo json_encode($json);

	}



	public function insert(){

		$post = $this->input->post();

		if($this->log_lvl == 'guru') {
			$this->insertCalendar( 
				$this->session->admin_konid,
				$post['id_kelas'], 
				$post['keterangan'], 
				$post['color'], 
				$post['start_date'], 
				$post['start_time'], 
				$post['end_date'], 
				$post['end_time'], 
				$post['materi']
			);
		}
		else {
			$this->insertCalendar( 
				NULL,
				$post['id_kelas'], 
				$post['keterangan'], 
				$post['color'], 
				$post['start_date'], 
				$post['start_time'], 
				$post['end_date'], 
				$post['end_time'], 
				$post['materi']
			);	
		}
			

	}





	public function update(){

		$post = $this->input->post();



		$data = array(

			'id_kelas' 	 => $post['id_kelas'] ,

			'id_materi'  => $post['materi'] ,

			'keterangan' => $post['keterangan'] ,

			'start_date' => $post['start_date'].' '.$post['start_time'] ,

			'end_date'   => $post['end_date'].' '.$post['end_time'] ,

			'color'  	 => $post['color'] ,

		);



		$this->m_jadwal->update($data,array('id'=>$post['id']));

		echo json_encode(array('result'=>true));

	}





	function hapus(){

		$id = $this->input->post('id');

		$data = $this->db->select('a.id_calendar')

							->where('a.id', $id)

							->get('tb_jadwal AS a')

							->row();

		// $this->deleteCalendar($data->id_calendar);

		$kirim = $this->m_jadwal->delete(array('id'=>$id));



		if ($kirim) {

			$result = 'hapus berhasil';

		}else{

			$result = 'hapus gagal';

		}



		$json = array('result' => $result, );

		echo json_encode($json);

	}



	public function page_load($pg = 1){

		$post = $this->input->post();

		$limit = $post['limit'];

		$where = [];



		if($this->log_lvl == 'guru'){

			$where['gr.id'] = $this->log_id;

		}
		
		$where['kls.id_instansi'] = isset($this->akun->instansi) ? $this->akun->instansi : 0;

		

		if (!empty($post['search'])) {

			switch ($post['filter']) {

				case 0:

					$where["(lower(gr.nama) like '%".strtolower($post['search'])."%' )"] = null;

					break;

				case 1:

					$where["(lower(mp.nama) like '%".strtolower($post['search'])."%' )"] = null;

					break;

				case 2:

					$where["(lower(mt.title) like '%".strtolower($post['search'])."%' )"] = null;

					break;

				case 3:

					$where["(lower(jwl.keterangan) like '%".strtolower($post['search'])."%' )"] = null;

					break;

				default:

					# code...

					break;

			}

		}

		$paginate = $this->m_jadwal->paginate($pg,$where,$limit);

		$data['paginate'] = $paginate;

		$data['paginate']['url']	= 'jadwal/page_load';

		$data['paginate']['search'] = 'lookup_key';

		$data['page_start'] = $paginate['counts']['from_num'];

		$this->load->view('jadwal/table',$data);

		$this->generate_page($data);
	}

	public function export_excel($where = []) {
		
	}

	public function kalender() 

	{

		$this->page_title = 'Jadwal';

		$uri3 = $this->uri->segment(3);

		$data = [];

		$calendar = array();


		if($this->log_lvl == 'siswa'){
			$data_calendar = $this->m_jadwal->get_kalender(array('dekls.id_peserta'=>$this->akun->id));
		}else{
			$data['filter'] = array(

				'searchFilter' => array('Trainer','Mata Pelajaran','Materi','keterangan'),

			);
			$data_calendar = $this->m_jadwal->get_kalender(array('kls.id_trainer'=>$this->akun->id));
		}
		
	
		

		foreach ($data_calendar as $key => $val) 

		{

			$calendar[] = array(

				'id' 	=> intval($val->id), 

				'time' => 01,

				'title' => $val->nama_materi, 

				'time' => $val->nama_mp, 

				'description' => trim($val->keterangan), 

				'start' => $val->start_date,

				'end' 	=> $val->end_date,

				'color' => $val->color,

			);

		}
		$data['get_data'] = json_encode($calendar);
		$this->render('jadwal/kalender', $data);

	}



	function get_data_kalender(){

		$get = $this->m_jadwal->get_by(array('jwl.id'=>$this->input->post('id')));



		if (!empty($get->start_date)) {

			$datetime1 = explode(' ', $get->start_date);

			$date = date_indo($datetime1[0]);

			$time = time_short($datetime1[1]);

		}else{

			$date = NULL;

			$time = NULL;

		}



		if (!empty($get->end_date)) {

			$datetime2 = explode(' ', $get->end_date);

			$date2 = date_indo($datetime2[0]);

			$time2 = time_short($datetime2[1]);

		}else{

			$date2 = NULL;

			$time2 = NULL;

		} 



		$custom = array(

			'tgl_mulai' => $date, 

			'tgl_selesai' => $date2,

			'waktu_mulai' => $time,

			'waktu_selesai' => $time2, 

		);



		echo json_encode(array('data'=>$get,'custom'=>$custom));

	}





	 public function paginate($page = 1, $where = array(), $limit = 10)

    {

        // get filtered results

        $where = array_merge($where, $this->where);

        $offset = ($page<=1) ? 0 : ($page-1)*$limit;

        $this->db->limit($limit, $offset);

        $results = $this->get_many_by($where);

        //echo  $this->db->last_query(); exit;

        // get counts (e.g. for pagination)

        $count_results = count($results);

        $count_total = $this->count_by($where);

        $total_pages = ceil($count_total / $limit);

        $counts = array(

            'from_num'      => ($count_results==0) ? 0 : $offset + 1,

            'to_num'        => ($count_results==0) ? 0 : $offset + $count_results,

            'total_num'     => $count_total,

            'curr_page'     => $page,

            'total_pages'   => ($count_results==0) ? 1 : $total_pages,

            'limit'         => $limit,

        );



        return array('data' => $results, 'counts' => $counts);

    }



}



/* End of file Jadwal.php */

/* Location: ./application/controllers/Jadwal.php */