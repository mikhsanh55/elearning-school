<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Ranking extends MY_Controller
{
    
  public function __construct()
  {
    parent::__construct();
    $this->load->model('m_jurusan');
    $this->load->model('m_ranking');
    $this->load->model('m_dimensi');
    $this->load->model('m_soal_penilaian');
  }

  public function index()
  {
      $this->page_title = 'Ranking Pengajar';
    $data = array(
			'searchFilter' => array('Trainer')
		);
		$this->render('ranking/list',$data);
  }

  public function page_load($pg = 1){
		$post = $this->input->post();
		$limit = $post['limit'];
		$where = [];
		if (!empty($post['search'])) {
			switch ($post['filter']) {
				case 0:
					$where["(lower(gur.nama) like '%".strtolower($post['search'])."%' )"] = null;
					break;
				default:
					# code...
					break;
			}
    }
    if ($this->log_lvl != 'admin') {
      $where['rank.id_instansi'] = $this->akun->instansi;
    }

		$paginate = $this->m_ranking->paginate($pg,$where,$limit);
		$data['paginate'] = $paginate;
		$data['paginate']['url']	= 'ranking/page_load';
		$data['paginate']['search'] = 'lookup_key';
    $data['page_start'] = $paginate['counts']['from_num'];
    $data['rank'] = $this->m_ranking->get_rank();

		$this->load->view('ranking/table',$data);
		$this->generate_page($data);
  }

  public function chart(Type $var = null)
  {
    $rank =  $this->m_ranking->get_relation(['rank.id_instansi'=>$this->akun->instansi]);
    foreach ($rank as $rows) {
        $labels[] = $rows->nama_trainer.'('.$rows->nama_mapel.')';
        $skor[] = $rows->skor;
    }

    $dimensi = $this->m_dimensi->get_all();
    $bobot_indikator = 0;
    foreach ($dimensi as $rows) {
    
      $labels2[] = $rows->nama;
      $soal = $this->m_soal_penilaian->get_many_by(['id_dimensi'=>$rows->id]);
        foreach ($soal as $rws) {
          $bobot_indikator += $rws->bobot * 4.5;
        }
        $bobot[] = $bobot_indikator;
        $bobot_indikator = 0;
    }

    if(empty($rank)){
      $labels = [];
      $skor   = [];
    };

    if(empty($dimensi)){
      $labels2 = [];
      $bobot   = [];
    };

    $data = array(
      'label' => $labels,
      'skor' => $skor,
      'label2' => $labels2,
      'bobot' => $bobot
    );

    
   

		$this->render('ranking/result',$data);
  }
  
  public function export_pdf() 
  {
    // Load PDF Libs  
    $this->load->library('dpdf');
    $where = [];
    // Stores Data
    if ($this->log_lvl != 'admin') {
      $where['rank.id_instansi'] = $this->akun->instansi;
    }
    $data['data'] = $this->m_ranking->get_pdf_many_by($where);
    $data['rank'] = $this->m_ranking->get_rank();
    $this->dpdf->setPaper('A4', 'portrait');
    $this->dpdf->filename = "Laporan Ranking.pdf";
    $this->dpdf->view('ranking/table_pdf', $data);
    
  }

}


/* End of file Jurusan.php */
/* Location: ./application/controllers/Rangking.php */