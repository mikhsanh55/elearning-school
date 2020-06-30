<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Keaktifan extends MY_Controller
{
    
  public function __construct()
  {
    parent::__construct();
    $this->load->model('keaktifan_off_model','keaktifanOffline');
    $this->load->model('m_kelas');
    $this->load->model('m_siswa');
    $this->load->model('m_keaktifan_total');
  }

  public function index()
  {
          $data = array(
            'searchFilter' => array('Nama','NRP'),
            'kelas' => $this->m_kelas->get_many_by(['kls.id_trainer'=>$this->akun->id])

          );

          $this->render('keaktifan/list_off',$data);
  }


  public function page_load($pg = 1){
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

    $where['kls.id_instansi'] = $this->akun->instansi;
    $where['kls.id'] = $post['id_kelas'];
    $where['kls.id_trainer'] = $this->akun->id;

    $paginate = $this->keaktifanOffline->paginate($pg,$where,$limit);

		$data['paginate'] = $paginate;
		$data['paginate']['url']	= 'keaktifan/page_load';
		$data['paginate']['search'] = 'lookup_key';
		$data['page_start'] = $paginate['counts']['from_num'];

		$this->load->view('keaktifan/table_off',$data);
		$this->generate_page($data);
  }
  

  public function beri_nilai()
	{
		$post = $this->input->post();

		$where = [
			'id_siswa' => $post['id_siswa'],
			'id_kelas' => $post['id_kelas']
		];

		$cek = $this->keaktifanOffline->count_by($where);

		if($cek > 0){
			$kirim = $this->keaktifanOffline->update($post,$where);
			$aksi = 'update';
		}else{
			$kirim = $this->keaktifanOffline->insert($post);
			$aksi = 'insert';
		}
		
		$json = ['send' => $kirim,'action'=>$aksi];

		echo json_encode($json);


  }
  
  public function beri_nilai_aktif()
	{
		$post = $this->input->post();

		$where = [
			'id_siswa' => $post['id_siswa'],
			'id_kelas' => $post['id_kelas']
		];

		$cek = $this->m_keaktifan_total->count_by($where);

		if($cek > 0){
			$kirim = $this->m_keaktifan_total->update($post,$where);
			$aksi = 'update';
		}else{
			$kirim = $this->m_keaktifan_total->insert($post);
			$aksi = 'insert';
		}
		
		$json = ['send' => $kirim,'action'=>$aksi];

		echo json_encode($json);


	}

}


/* End of file Keaktifan.php */
/* Location: ./application/controllers/Keaktifan.php */