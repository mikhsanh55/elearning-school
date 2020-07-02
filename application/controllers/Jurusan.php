<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Jurusan extends MY_Controller
{
    
  public function __construct()
  {
    parent::__construct();
    $this->load->model('m_jurusan');
    $this->load->model('m_instansi');
    
    
  }

  public function index()
  {
    $data = array(
			'instansi' => $this->m_jurusan->get_all(), 
			'searchFilter' => array('jurusan' => 'Kelas')
		);
		$this->render('jurusan/list',$data);
  }

  public function page_load($pg = 1){
		$post = $this->input->post();
		$limit = $post['limit'];
		$where = [];
		if (!empty($post['search'])) {
			switch ($post['filter']) {
				case 0:
					$where["(lower(jurusan) like '%".strtolower($post['search'])."%' )"] = null;
					break;
				default:
					# code...
					break;
			}
    }
    if ($this->log_lvl != 'admin') {
      $where['id_instansi'] = $this->akun->instansi;
      // if($this->log_lvl == 'guru') {
      //   $where['']
      // }
      if($this->log_lvl == 'siswa') {
        $data = $this->m_siswa->get_by(['id' => $this->session->admin_konid]);
        $where['jurus.id'] = $data->id_jurusan;
      }
    }

		$paginate = $this->m_jurusan->paginate($pg,$where,$limit);
    foreach($paginate['data'] as $row) {
      $row->encrypt_id = $this->encryption->encrypt($row->id);
    }
		$data['paginate'] = $paginate;
		$data['paginate']['url']	= 'jurusan/page_load';
		$data['paginate']['search'] = 'lookup_key';
		$data['page_start'] = $paginate['counts']['from_num'];

		$this->load->view('jurusan/table',$data);
		$this->generate_page($data);
  }
  
  public function add()
  {
    $instansi = ($this->log_lvl == 'admin') ? $this->m_instansi->get_all() : $this->m_instansi->get_by(['id'=>$this->akun->instansi]); 
    $data = [
      'instansi' => $instansi
    ];
    $this->render('jurusan/add',$data);
  }

  public function insert()
  {
    $post = $this->input->post();
    if (empty($post['id_instansi'])) {
      $post['id_instansi'] = $this->akun->instansi;
    }

    $kirim = $this->m_jurusan->insert($post);
    $info = ($kirim) ? 'Berhasil Menambahkan ' : 'Gagal Menambahkan';
    $json = ['result'=>$kirim,'info'=>$info];

    echo json_encode($json);
    
  }

  public function edit($id=NULL)
  {
    if(!empty($id)){
      $id = decrypt_url($id);
    }else{
      redirect(base_url('jurusan'));
    }

    $instansi = ($this->log_lvl == 'admin') ? $this->m_instansi->get_all() : $this->m_instansi->get_by(['id'=>$this->akun->instansi]); 
    $data = [
      'instansi' => $instansi,
      'edit' => $this->m_jurusan->get_by(['id'=>$id])
    ];
   
    $this->render('jurusan/edit',$data);
  }

  public function update()
  {
    $post = $this->input->post();
    if (empty($post['id_instansi'])) {
      $post['id_instansi'] = $this->akun->instansi;
    }

    $kirim = $this->m_jurusan->update($post,['id'=>$post['id']]);
    $info = ($kirim) ? 'Berhasil Mengupdate ' : 'Gagal Mengupdate';
    $json = ['result'=>$kirim,'info'=>$info];

    echo json_encode($json);
    
  }

  
	public function multi_delete(){
		$post = $this->input->post();

		foreach ($post['id'] as $val) {
			$where[] = $val;
		}

		$this->db->trans_begin();

		$kirim = $this->db->where_in('id',$where)->delete('tb_jurusan');


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

  public function export($type = 'excel') {
    
    if ($this->log_lvl != 'admin') {
      $where['id_instansi'] = $this->akun->instansi;
    }
    $this->excelDatas = $this->m_jurusan->get_many_by($where);
    
    // Initialize excel object
    $this->excelInitialize();

    $this->excelCellsHeading = [
      ['cell' => 'A', 'label' => 'No'],
      ['cell' => 'B', 'label' => 'Kode'],
      ['cell' => 'C', 'label' => 'Jurusab'],
    ];

    // Write heading excel use method on MY_Controller.php
    $this->excelWriteHeading();

    $this->excelDataStart = 2;

    foreach($this->excelDatas as $data) {
      $this->excelObject->getActiveSheet()->SetCellValue('A' . $this->excelDataStart, $this->excelColumnNo);
      $this->excelObject->getActiveSheet()->SetCellValue('B' . $this->excelDataStart, $data->id);
      $this->excelObject->getActiveSheet()->SetCellValue('C' . $this->excelDataStart, $data->jurusan);

      $this->excelDataStart++;
      $this->excelColumnNo++;
    }

    // Create Filename and output as .xlsx
    $this->excelFileName = "Data Jurusan - " . date('m-d-Y') . ".xlsx";
    $this->excelDisplayOutput();

    // Set No Column back to 1 for reuse
    $this->excelColumnNo = 1;
  }

  public function siswa() {
    $data = array(
      'searchFilter' => array('jurusan' => 'Kelas')
    );
    $this->render('jurusan/list',$data);
  }
}


/* End of file Jurusan.php */
/* Location: ./application/controllers/Jurusan.php */