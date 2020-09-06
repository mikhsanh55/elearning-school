<?php 
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
// include APPPATH.'third_party/PHPExcel/PHPExcel.php';

class Export extends MY_Controller {
	public $excelDatas = [];
	public $excelCellsHeading = [];
	public $excelDataStart = 2;
	public $excelColumnNo = 1;
	public $excelObject;
	public $excelFileName;
	public $excelDisplayOutput;
	public $excelObjectWriter;
	
	function __construct() {
		parent::__construct();
		$this->db->query("SET time_zone='+7:00'");
		$this->load->helper('download');
		$this->excelInitialize();
	}

	/* Built-in Methods */
	public function excelInitialize() {
		// $this->excelObject = new PHPExcel();
		// $this->excelObject->setActiveSheetIndex(0);
		$this->excelObject = new Spreadsheet();
	}

	public function excelWriteHeading($cell = 1) {
		foreach($this->excelCellsHeading as $cells) {
			$this->excelObject->getActiveSheet()->setCellValue($cells['cell'] . $cell, $cells['label']);
		}
	}

	public function excelDisplayOutput() {
		$this->excelObjectWriter = new Xlsx($this->excelObject);
		header('Content-Type: application/vnd.ms-excel'); // generate excel file
        header('Content-Disposition: attachment;filename="'. $this->excelFileName .'"'); 
        header('Cache-Control: max-age=0');
		ob_end_clean();
		$this->excelObjectWriter->save('php://output');
	}

	// Rekapitulasi
	public function rekaptulasi() {
		$this->load->model('m_kelas');
		$this->load->model('m_ujian');
		$this->load->model('m_tugas');
		$this->load->model('m_tugas_nilai');
		$post = $this->input->post();
		// print_r($post);exit;
		$datas = [];
		$where = [];
		$url = NULL;
		switch($post['kategori']) {
			case 'harian':
				$where['uji.id_instansi'] = $this->akun->instansi;
				$where['uji.type_ujian'] = 'harian';
				$where['pg.id_ujian'] = $post['data'];
				if($this->log_lvl === 'guru') {
					$where['uji.id_guru'] = $this->akun->id;
				}
				$this->session->set_userdata([
					'temp_datas' => $this->m_kelas->get_rekap_ujian($where)
				]);
				$url = $post['type'] === 'excel' ? base_url('export/rekap-ujian') : base_url('export/pdf-rekap-ujian');
			break;
			case 'tugas':
				$where['tugas.id'] = $post['data'];
				$where['tugas.id_kelas'] = $post['kelas'];
				$this->session->set_userdata([
					'temp_datas' => $this->m_tugas_nilai->get_detail_nilai($where)
				]);
				$url = $post['type'] === 'excel' ? base_url('export/rekap-tugas') : base_url('export/pdf-rekap-tugas');
			break;
		}

		$this->sendAjaxResponse([
			'status' => TRUE,
			'url' => $url
		], 200);

	}

	/*
	* PDF
	*/
	public function pdfRekapUjian()
	{
		$this->load->library('dpdf');
		$this->load->model('m_ujian');
		$this->load->model('m_siswa');
		$this->load->model('m_kelas');
		$this->load->model('m_detail_kelas');
		$this->load->model('m_guru');
		$this->load->model('m_mapel');
		$results['datas'] = $this->session->userdata('temp_datas');

		if(count($results['datas']) < 1 || empty($results['datas'])) {
			$this->session->set_flashdata('error', '<p class="alert alert-danger">Data Kosong, tidak bisa diexport</p>');
			redirect('rekaptulasi');
		}

		if(count($results['datas']) > 0) {
			$id_mapel = $results['datas'][0]->id_mapel;
			$id_guru = $results['datas'][0]->id_guru;
			$nama_mapel = $this->m_mapel->get_by(['id' => $id_mapel])->nama;
			$nama_guru = $this->m_guru->get_by(['id' => $id_guru])->nama;
			$results['nama_ujian'] = $results['datas'][0]->nama_ujian;
			$results['nama_guru'] = $nama_guru;
			$results['nama_mapel'] = $nama_mapel;
		}
		else {
			$results['nama_ujian'] = '';
			$results['nama_guru'] = '';
			$results['nama_mapel'] = '';	
		}

		$this->dpdf->setPaper('A4', 'landscape');
		$this->dpdf->filename = "Data Nilai Ujian ".$results['datas'][0]->nama_ujian." - " . date('m-d-Y') . ".pdf";
		$this->dpdf->view('rekaptulasi/nilai_ujian_pdf', $results);
	}

	/*
	* Excel
	*/
	public function rekapUjian()
	{
		$this->excelDatas = $this->session->userdata('temp_datas');
		$this->load->model('m_ujian');
		$this->load->model('m_siswa');
		$this->load->model('m_kelas');
		$this->load->model('m_detail_kelas');
		$this->load->model('m_guru');
		$this->load->model('m_mapel');

		if(count($this->excelDatas) < 1 || empty($this->excelDatas)) {
			$this->session->set_flashdata('error', '<p class="alert alert-danger">Data Kosong, tidak bisa diexport</p>');
			redirect('rekaptulasi');
		}

		$id_mapel = $this->excelDatas[0]->id_mapel;
		$id_guru = $this->excelDatas[0]->id_guru;
		$nama_mapel = $this->m_mapel->get_by(['id' => $id_mapel])->nama;
		$nama_guru = $this->m_guru->get_by(['id' => $id_guru])->nama;

		$this->excelInitialize();
		$this->excelCellsHeading = [
			['cell' => 'A', 'label' => 'No'],
			['cell' => 'B', 'label' => 'Nama Siswa'],
			['cell' => 'C', 'label' => 'Kelas'],
			['cell' => 'D', 'label' => 'KKM'],
			['cell' => 'E', 'label' => 'Nilai']
		];

		// Write header of Document
		$this->excelObject->getActiveSheet()->setCellValue('A' . 1, 'Data Nilai Ujian Harian ' . $this->excelDatas[0]->nama_ujian);
		$this->excelObject->getActiveSheet()->setCellValue('A' . 2, 'Guru ' . $nama_guru);
		$this->excelObject->getActiveSheet()->setCellValue('A' . 3, 'Mata Pelajaran ' . $nama_mapel);
		$this->excelDataStart = 6;
		// Write heading excel use method on MY_Controller.php
		$this->excelWriteHeading(5);

		foreach($this->excelDatas as $data) :
			$siswa = $this->m_siswa->get_by(['id' => $data->id_user]);
			$detailKelas = $this->m_detail_kelas->get_by(['id_peserta' => $data->id_user]);
			$kelas = $this->m_kelas->get_by(['kls.id' => $detailKelas->id_kelas]);
			if($data->nilai_essay == NULL || empty($data->nilai_essay)) {
				$nilai = $data->nilai_pg;
			}
			else {
				$nilai = ($data->nilai_pg + $data->nilai_essay) / 2;
			}
			$this->excelObject->getActiveSheet()->setCellValue('A' . $this->excelDataStart, $this->excelColumnNo);
	        $this->excelObject->getActiveSheet()->setCellValue('B' . $this->excelDataStart, $siswa->nama);
	        $this->excelObject->getActiveSheet()->setCellValue('C' . $this->excelDataStart, $kelas->nama);
	        $this->excelObject->getActiveSheet()->setCellValue('D' . $this->excelDataStart, $data->min_nilai);
	        $this->excelObject->getActiveSheet()->setCellValue('E' . $this->excelDataStart, $nilai);

	        $this->excelDataStart++;
	        $this->excelColumnNo++;
		endforeach;

		// Create Filename and output as .xlsx
	    $this->excelFileName = "Data Nilai Ujian ".$this->excelDatas[0]->nama_ujian." - " . date('m-d-Y') . ".xlsx";
	    $this->excelDisplayOutput();

	    // Set No Column back to 1 for reuse
	    $this->excelColumnNo = 1;
	}

	public function pdfRekapTugas()
	{
		$this->load->library('dpdf');
		$this->load->model('m_guru');
		$this->load->model('m_mapel');
		$this->load->model('m_kelas');
		$this->load->model('m_siswa');

		$results['datas'] = $this->session->userdata('temp_datas');
		if(count($results['datas']) < 1 || empty($results['datas'])) {
			$this->session->set_flashdata('error', '<p class="alert alert-danger">Data Kosong, tidak bisa diexport</p>');
			redirect('rekaptulasi');
		}
		if(count($results['datas']) > 0) {
			$id_kelas = $results['datas'][0]->id_kelas;
			$id_mapel = $results['datas'][0]->id_mapel;
			$id_guru = $results['datas'][0]->id_guru;
			$nama_kelas = $this->m_kelas->get_by(['kls.id' => $id_kelas])->nama;
			$nama_mapel = $this->m_mapel->get_by(['id' => $id_mapel])->nama;
			$nama_guru = $this->m_guru->get_by(['id' => $id_guru])->nama;
			$results['nama_kelas'] = $nama_kelas;
			$results['nama_guru'] = $nama_guru;
			$results['nama_mapel'] = $nama_mapel;
		}
		else {
			$results['nama_kelas'] = '';
			$results['nama_guru'] = '';
			$results['nama_mapel'] = '';	
		}

		$this->dpdf->setPaper('A4', 'landscape');
		$this->dpdf->filename = "Data Nilai Tugas Kelas ".$nama_kelas." - " . date('m-d-Y') . ".pdf";
		$this->dpdf->view('rekaptulasi/nilai_tugas_pdf', $results);
	}

	public function rekapTugas()
	{
		$this->excelDatas = $this->session->userdata('temp_datas');
		$this->load->model('m_guru');
		$this->load->model('m_mapel');
		$this->load->model('m_kelas');
		$this->load->model('m_siswa');
		if(count($this->excelDatas) < 1 || empty($this->excelDatas)) {
			$this->session->set_flashdata('error', '<p class="alert alert-danger">Data Kosong, tidak bisa diexport</p>');
			redirect('rekaptulasi');
		}
		$id_kelas = $this->excelDatas[0]->id_kelas;
		$id_mapel = $this->excelDatas[0]->id_mapel;
		$id_guru = $this->excelDatas[0]->id_guru;
		$nama_kelas = $this->m_kelas->get_by(['kls.id' => $id_kelas])->nama;
		$nama_mapel = $this->m_mapel->get_by(['id' => $id_mapel])->nama;
		$nama_guru = $this->m_guru->get_by(['id' => $id_guru])->nama;
		$this->excelInitialize();
		$this->excelCellsHeading = [
			['cell' => 'A', 'label' => 'No'],
			['cell' => 'B', 'label' => 'Nama'],
			['cell' => 'C', 'label' => 'NIS'],
			['cell' => 'D', 'label' => 'Nilai']
		];

		// Write header of Document
		$this->excelObject->getActiveSheet()->setCellValue('A' . 1, 'Data Nilai Tugas Kelas ' . $nama_kelas);
		$this->excelObject->getActiveSheet()->setCellValue('A' . 2, 'Guru ' . $nama_guru);
		$this->excelObject->getActiveSheet()->setCellValue('A' . 3, 'Mata Pelajaran ' . $nama_mapel);

		$this->excelDataStart = 6;
		// Write heading excel use method on MY_Controller.php
		$this->excelWriteHeading(5);

		foreach($this->excelDatas as $data) {
			$siswa = $this->m_siswa->get_by(['id' => $data->id_siswa]);
			$this->excelObject->getActiveSheet()->setCellValue('A' . $this->excelDataStart, $this->excelColumnNo);
	        $this->excelObject->getActiveSheet()->setCellValue('B' . $this->excelDataStart, $siswa->nama);
	        $this->excelObject->getActiveSheet()->setCellValue('C' . $this->excelDataStart, $siswa->nrp);
	        $this->excelObject->getActiveSheet()->setCellValue('D' . $this->excelDataStart, $data->nilai);

	        $this->excelDataStart++;
	        $this->excelColumnNo++;
		}

		// Create Filename and output as .xlsx
	    $this->excelFileName = "Data Nilai Tugas Kelas ".$nama_kelas." - " . date('m-d-Y') . ".xlsx";
	    $this->excelDisplayOutput();

	    // Set No Column back to 1 for reuse
	    $this->excelColumnNo = 1;
	}

	// Jurusan
	public function jurusan() {
		$this->load->model('m_jurusan');
		if ($this->log_lvl != 'admin') {
	      $where['id_instansi'] = $this->akun->instansi;
	    }
	    $this->excelDatas = $this->m_jurusan->get_many_by($where);

	    $this->excelCellsHeading = [
	      ['cell' => 'A', 'label' => 'No'],
	      ['cell' => 'B', 'label' => 'Kode'],
	      ['cell' => 'C', 'label' => 'Kelas'],
	    ];

	    // Write heading excel use method on MY_Controller.php
	    $this->excelWriteHeading();

	    $this->excelDataStart = 2;

	    foreach($this->excelDatas as $data) {
	      $this->excelObject->getActiveSheet()->setCellValue('A' . $this->excelDataStart, $this->excelColumnNo);
	      $this->excelObject->getActiveSheet()->setCellValue('B' . $this->excelDataStart, $data->id);
	      $this->excelObject->getActiveSheet()->setCellValue('C' . $this->excelDataStart, $data->jurusan);

	      $this->excelDataStart++;
	      $this->excelColumnNo++;
	    }

	    // Create Filename and output as .xlsx
	    $this->excelFileName = "Data Kelas - " . date('m-d-Y') . ".xlsx";
	    $this->excelDisplayOutput();

	    // Set No Column back to 1 for reuse
	    $this->excelColumnNo = 1;
	}

	// 	Admin Lembaga
	public function adminlembaga() {
		// Load Modul Admin Lembaga
		$this->load->model("m_admin_lembaga");
		if($this->log_lvl != 'admin') {
			$where['in.id'] = $this->akun->instansi;
		}

		$this->excelDatas = $this->m_admin_lembaga->get_many_by($where);

		$this->excelCellsHeading = [
			['cell' => 'A', 'label' => 'Nama'],
			['cell' => 'B', 'label' => 'Username'],
			['cell' => 'C', 'label' => 'No Telpon'],
			['cell' => 'D', 'label' => 'Email']
		];

		// Write heading excel use method on MY_Controller.php
    	$this->excelWriteHeading();

		// Set Writer for write data after heading
		$this->excelDataStart = 2;

		foreach($this->excelDatas as $key => $data) {
			$this->excelObject->getActiveSheet()->setCellValue('A' . $this->excelDataStart, $data->nama);
			$this->excelObject->getActiveSheet()->setCellValue('B' . $this->excelDataStart, $data->username);
			$this->excelObject->getActiveSheet()->setCellValue('C' . $this->excelDataStart, $data->no_telpon);
			$this->excelObject->getActiveSheet()->setCellValue('D' . $this->excelDataStart, $data->email);
			$this->excelDataStart++;
		}

		// Create New File use method on MY_Controller.php
		$this->excelFileName = "Data Admin User - " . date('m-d-Y') . ".xlsx";
		$this->excelDisplayOutput();

	}

	// Mapel / Kurikulum
	public function kurikulum() {
		$this->load->model('m_mapel');
		
		$where['id_instansi'] = $this->akun->instansi;
		$this->excelDatas = $this->m_mapel->get_many_by($where);

		$this->excelCellsHeading = [
			['cell' => 'A', 'label' => 'No'],
			['cell' => 'B', 'label' => 'Kode Mata Pelajaran'],
			['cell' => 'C', 'label' => 'Mata Pelajaran']
		];

		// Write heading excel use method on MY_Controller.php
    	$this->excelWriteHeading();

		// Set Writer for write data after heading
		$this->excelDataStart = 2;

		foreach($this->excelDatas as $key => $data) {
			$this->excelObject->getActiveSheet()->setCellValue('A' . $this->excelDataStart, $this->excelColumnNo);
			$this->excelObject->getActiveSheet()->setCellValue('B' . $this->excelDataStart, $data->kd_mp);
			$this->excelObject->getActiveSheet()->setCellValue('C' . $this->excelDataStart, $data->nama);
			$this->excelDataStart++;
			$this->excelColumnNo++;
		}

		// Create New File use method on MY_Controller.php
		$this->excelFileName = "Data Kurikulum - " . date('m-d-Y') . ".xlsx";
		$this->excelDisplayOutput();
			
		// Set No Column back to 1 for reuse
	    $this->excelColumnNo = 1;
	}

	// Data Pengajar / Trainer
	public function pengajar() {
		$this->load->model('m_guru');
		if ($this->log_lvl != 'admin') {
			$where['instansi'] = $this->akun->instansi;
		}

		$this->excelDatas = $this->m_guru->get_all($where);

 		// Initialize excel object
	    $this->excelInitialize();

	    $this->excelCellsHeading = [
	    	['cell' => 'A', 'label' => 'No'],
	    	['cell' => 'B', 'label' => 'NUPTK'],
	    	['cell' => 'C', 'label' => 'NIP'],
	    	['cell' => 'D', 'label' => 'Nama Guru'],
	    	['cell' => 'E', 'label' => 'Username'],
	    	['cell' => 'F', 'label' => 'Email'],
	    	['cell' => 'G', 'label' => 'No Telpon']
	    ];

	    // Write heading excel use method on MY_Controller.php
    	$this->excelWriteHeading();

	    $this->excelDataStart = 2;

	    foreach($this->excelDatas as $data) {
	      $this->excelObject->getActiveSheet()->setCellValue('A' . $this->excelDataStart, $this->excelColumnNo);
	      $this->excelObject->getActiveSheet()->setCellValue('B' . $this->excelDataStart, $data->nidn);
	      $this->excelObject->getActiveSheet()->setCellValue('C' . $this->excelDataStart, $data->nrp);

	      $this->excelObject->getActiveSheet()->setCellValue('D' . $this->excelDataStart, $data->nama);
	      $this->excelObject->getActiveSheet()->setCellValue('E' . $this->excelDataStart, $data->username);
	      $this->excelObject->getActiveSheet()->setCellValue('F' . $this->excelDataStart, $data->email);
	      $this->excelObject->getActiveSheet()->setCellValue('G' . $this->excelDataStart, $data->no_telpon);

	      $this->excelDataStart++;
	      $this->excelColumnNo++;
	    }


	    // Create Filename and output as .xlsx
	    $this->excelFileName = "Data Pengajar - " . date('m-d-Y') . ".xlsx";
	    $this->excelDisplayOutput();

	    // Set No Column back to 1 for reuse
	    $this->excelColumnNo = 1;
	}

	// Data Mahasiswa
	public function siswa($graduated = 0) {
		$this->load->model('m_siswa');
		if ($this->log_lvl != 'admin') {
			$where["akun.instansi"] = $this->akun->instansi;
		}

		
		$where["akun.is_graduated"] = $graduated;

		$this->excelDatas = $this->m_siswa->get_all($where);

		$this->excelCellsHeading = [
			['cell' => 'A', 'label' => 'No'],
			['cell' => 'B', 'label' => 'Nama'],
			['cell' => 'C', 'label' => 'Username'],
			['cell' => 'D', 'label' => 'NIS'],
			['cell' => 'E', 'label' => 'Kelas'],
			['cell' => 'F', 'label' => 'Jenis Kelamin'],
			['cell' => 'G', 'label' => 'Email'],
			['cell' => 'H', 'label' => 'Alamat'],
			['cell' => 'I', 'label' => 'No Telpon'],
		];

		// Write heading excel use method on MY_Controller.php
    	$this->excelWriteHeading();
    	// print_r($this->excelDatas);exit;
		$this->excelDataStart = 2;
		foreach($this->excelDatas as $i => $data) {
			$detail_kelas = $this->m_detail_kelas->get_siswa(['dk.id_peserta' => $data->id]);
			$kelas = !empty($detail_kelas->nama_kelas) ? $detail_kelas->nama_kelas : NULL;
			$this->excelObject->getActiveSheet()->setCellValue('A' . $this->excelDataStart, $this->excelColumnNo);
			$this->excelObject->getActiveSheet()->setCellValue('B' . $this->excelDataStart, $data->nama);
			$this->excelObject->getActiveSheet()->setCellValue('C' . $this->excelDataStart, $data->username);
			$this->excelObject->getActiveSheet()->setCellValue('D' . $this->excelDataStart, $data->nrp);
			$this->excelObject->getActiveSheet()->setCellValue('E' . $this->excelDataStart, $kelas);
			$this->excelObject->getActiveSheet()->setCellValue('F' . $this->excelDataStart, $data->nik);
			$this->excelObject->getActiveSheet()->setCellValue('G' . $this->excelDataStart, $data->email);
			$this->excelObject->getActiveSheet()->setCellValue('H' . $this->excelDataStart, $data->alamat);
			$this->excelObject->getActiveSheet()->setCellValue('I' . $this->excelDataStart, $data->no_telpon);
			$this->excelDataStart++;
			$this->excelColumnNo++;
		}

		// Create New File use method on MY_Controller.php
		$this->excelFileName = "Data Siswa - " . date('m-d-Y') . ".xlsx";
		$this->excelDisplayOutput();
		$this->excelColumnNo = 1;
	}

	// Data Kelas
	public function kelas() {
		$this->load->model('m_kelas');
		$this->load->model('m_detail_kelas');

		if($this->log_lvl == 'guru'){
			$where['kls.id_trainer'] = $this->akun->id;
		}
		if($this->log_lvl != 'admin'){
			$where['kls.id_instansi'] = $this->akun->instansi;
		}

		$this->excelDatas = $this->m_kelas->get_all($where);
		// print_r($this->excelDatas);exit;

		$this->excelCellsHeading = [
			['cell' => 'A', 'label' => 'No'],
			['cell' => 'B', 'label' => 'Wali Kelas'],
			['cell' => 'C', 'label' => 'Kelas'],
			['cell' => 'D', 'label' => 'Keterangan'],
			['cell' => 'E', 'label' => 'Total Siswa'],
		];

		// Write heading excel use method on MY_Controller.php
    	$this->excelWriteHeading();

		$this->excelDataStart = 2;

		foreach($this->excelDatas as $data) {
			$jml_siswa = $this->m_detail_kelas->count_by(['id_kelas'=>$data->id]);
			
			$this->excelObject->getActiveSheet()->setCellValue('A' . $this->excelDataStart, $this->excelColumnNo);
			$this->excelObject->getActiveSheet()->setCellValue('B' . $this->excelDataStart, $data->nama_guru);
			$this->excelObject->getActiveSheet()->setCellValue('C' . $this->excelDataStart, $data->nama);
			$this->excelObject->getActiveSheet()->setCellValue('D' . $this->excelDataStart, $data->keterangan);
			$this->excelObject->getActiveSheet()->setCellValue('E' . $this->excelDataStart, $jml_siswa);

			$this->excelDataStart++;
			$this->excelColumnNo++;
		}

		// Create New File use method on MY_Controller.php
		$this->excelFileName = "Data Kelas - " . date('m-d-Y') . ".xlsx";
		$this->excelDisplayOutput();

		$this->excelColumnNo = 1;
	}

	// Data Ujian
	public function ujian() {
		$this->load->model('m_ujian');
		$where['uji.id_instansi'] = $this->akun->instansi;
		$this->excelDatas = $this->m_ujian->get_many_by($where);
		// print_r($this->excelDatas);	

		$this->excelCellsHeading = [
			['cell' => 'A', 'label' => 'No'],
			['cell' => 'B', 'label' => 'Tipe Ujian'],
			['cell' => 'C', 'label' => 'Nama Ujian'],
			['cell' => 'D', 'label' => 'Tanggal Mulai'],
			['cell' => 'E', 'label' => 'Tanggal Selesai'],
			['cell' => 'F', 'label' => 'Waktu Ujian'],
			['cell' => 'G', 'label' => 'Minimal Nilai Lulus'],
		];

		// Write heading excel use method on MY_Controller.php
    	$this->excelWriteHeading();

		$this->excelDataStart = 2;

		foreach($this->excelDatas as $data) {
			$this->excelObject->getActiveSheet()->setCellValue('A' . $this->excelDataStart, $this->excelColumnNo);
			$this->excelObject->getActiveSheet()->setCellValue('B' . $this->excelDataStart, $data->type_ujian);			
			$this->excelObject->getActiveSheet()->setCellValue('C' . $this->excelDataStart, $data->nama_ujian);
			$this->excelObject->getActiveSheet()->setCellValue('D' . $this->excelDataStart, $data->tgl_mulai);
			$this->excelObject->getActiveSheet()->setCellValue('E' . $this->excelDataStart, $data->terlambat);
			$this->excelObject->getActiveSheet()->setCellValue('F' . $this->excelDataStart, $data->waktu);
			$this->excelObject->getActiveSheet()->setCellValue('G' . $this->excelDataStart, $data->min_nilai);

			$this->excelDataStart++;
			$this->excelColumnNo++;
		}
		$this->excelColumnNo = 1;
		// Create New File use method on MY_Controller.php
		$this->excelFileName = "Data Ujian - " . date('m-d-Y') . ".xlsx";
		$this->excelDisplayOutput();

		$this->excelColumnNo = 1;
		
	}
	public function jadwal() {
		$this->load->model('m_jadwal');
		if($this->log_lvl == 'siswa') {
			redirect('jadwal');
		}
		$where = [];
		if($this->log_lvl == 'guru'){
			$where['gr.id'] = $this->log_id;
		}

		// Set data for excel
		$this->excelDatas = $this->m_jadwal->get_many_by($where);

		// Initialize excel object
		$this->excelInitialize();

		$this->excelCellsHeading = [
			['cell' => 'A', 'label' => 'No'],
			['cell' => 'B', 'label' => 'Guru'],
			['cell' => 'C', 'label' => 'Mata Kuliah'],
			['cell' => 'D', 'label' => 'Materi'],
			['cell' => 'E', 'label' => 'Keterangan/Materi'],
			['cell' => 'F', 'label' => 'Tanggal Mulai'],
			['cell' => 'G', 'label' => 'Tanggal Selesai'],
		];

		// Write heading excel use method on MY_Controller.php
		$this->excelWriteHeading();

		$this->excelDataStart = 2;

		foreach($this->excelDatas as $data) {

			$this->excelObject->getActiveSheet()->setCellValue('A' . $this->excelDataStart, $this->excelColumnNo);
			$this->excelObject->getActiveSheet()->setCellValue('B' . $this->excelDataStart, 
				$data->nama_guru);
			$this->excelObject->getActiveSheet()->setCellValue('C' . $this->excelDataStart, 
				$data->nama_mp);
			$this->excelObject->getActiveSheet()->setCellValue('D' . $this->excelDataStart, 
				$data->nama_materi);
			$this->excelObject->getActiveSheet()->setCellValue('E' . $this->excelDataStart, 
				$data->keterangan);
			$this->excelObject->getActiveSheet()->setCellValue('F' . $this->excelDataStart, 
				$data->start_date);
			$this->excelObject->getActiveSheet()->setCellValue('G' . $this->excelDataStart, 
				$data->end_date);

			$this->excelDataStart++;
			  $this->excelColumnNo++;
		}

		// Create Filename and output as .xlsx
		$this->excelFileName = "Data Jadwal - " . date('m-d-Y') . ".xlsx";
		$this->excelDisplayOutput();

		// Set No Column back to 1 for reuse
		$this->excelColumnNo = 1;
	}

	public function hasil_ujian_essay($md5_id_ujian) {
		$this->load->model('m_ikut_ujian_essay');
		$this->load->model('m_ujian');
		$this->load->model('m_siswa');
		$this->load->model('m_kelas');
		$this->load->model('m_detail_kelas');
		$id = decrypt_url($md5_id_ujian);
		$this->excelDatas = $this->m_ikut_ujian_essay->get_many_by(['id_ujian' => $id]);

		if(count($this->excelDatas) > 0) {
			$data_ujian = $this->m_ujian->get_by(['uji.id' => $this->excelDatas[0]->id_ujian ]);
			$data_kelas = $this->m_detail_kelas->get_by(['id_peserta' => $this->excelDatas[0]->id_user]);
			$kelas = $this->m_kelas->get_by(['kls.id' => $data_kelas->id_kelas]);
			$nama_kelas = !empty($kelas) ? $kelas->nama : '';	

			
			$nama_guru = $data_ujian->nama_guru;
			$nama_mapel = $data_ujian->nama_mapel;
		}
		else {
			$result['nama_kelas'] = '';
			$nama_guru = '';
			$nama_mapel = '';	
		}
		// Initialize excel object
		$this->excelInitialize();

		$this->excelCellsHeading = [
			['cell' => 'A', 'label' => 'No'],
			['cell' => 'B', 'label' => 'Siswa'],
			['cell' => 'C', 'label' => 'Kelas'],
			['cell' => 'D', 'label' => 'Nilai'],
			['cell' => 'E', 'label' => 'KKM'],
			['cell' => 'F', 'label' => 'Keteramgan'],
			['cell' => 'G', 'label' => 'Waktu Mulai'],
			['cell' => 'H', 'label' => 'Waktu Selesai']
		];

		// Write header of Document
		$this->excelObject->getActiveSheet()->setCellValue('A' . 1, 'Data Hasil Ujian Essay Kelas ' . $nama_kelas);
		$this->excelObject->getActiveSheet()->setCellValue('A' . 2, 'Guru ' . $nama_guru);
		$this->excelObject->getActiveSheet()->setCellValue('A' . 3, 'Mata Pelajaran ' . $nama_mapel);

		$this->excelDataStart = 6;
		// Write heading excel use method on MY_Controller.php
		$this->excelWriteHeading(5);

		foreach($this->excelDatas as $data) {
			$ujian = $this->m_ujian->get_by(['uji.id'=>$data->id_ujian]);
			$nilai = $this->db->select('sum(nilai) as total')->where('id_ikut_essay',$data->id)->get('tb_jawaban_essay')->row();
			$keterangan = ($nilai->total >= $ujian->min_nilai) ? 'LULUS' : 'BELUM LULUS';

			$this->excelObject->getActiveSheet()->setCellValue('A' . $this->excelDataStart, $this->excelColumnNo);
			$this->excelObject->getActiveSheet()->setCellValue('B' . $this->excelDataStart, $data->nama_siswa);
			$this->excelObject->getActiveSheet()->setCellValue('C' . $this->excelDataStart, $data->nama_kelas);
			$this->excelObject->getActiveSheet()->setCellValue('D' . $this->excelDataStart, $nilai->total);
			$this->excelObject->getActiveSheet()->setCellValue('E' . $this->excelDataStart, $ujian->min_nilai);
			$this->excelObject->getActiveSheet()->setCellValue('F' . $this->excelDataStart, $keterangan);
			$this->excelObject->getActiveSheet()->setCellValue('G' . $this->excelDataStart, $data->tgl_mulai);
			$this->excelObject->getActiveSheet()->setCellValue('H' . $this->excelDataStart, $data->tgl_selesai);

			$this->excelDataStart++;
			$this->excelColumnNo++;
		}

		// Create Filename and output as .xlsx
		$this->excelFileName = "Data Hasil Ujian Essay - " . $nama_kelas . ' ' . date('m-d-Y') . ".xlsx";
		$this->excelDisplayOutput();

		// Set No Column back to 1 for reuse
		$this->excelColumnNo = 1;

	}

	// Hasil Ujian PG
	public function hasil_ujian($md5_id_ujian) {
		$this->load->model('m_ikut_ujian');
		$this->load->model('m_ujian');
		$this->load->model('m_siswa');
		$this->load->model('m_kelas');
		$this->load->model('m_detail_kelas');
		$id = decrypt_url($md5_id_ujian);
		$this->excelDatas = $this->m_ikut_ujian->get_many_by(['id_ujian' => $id]);

		if(count($this->excelDatas) > 0) {
			$data_ujian = $this->m_ujian->get_by(['uji.id' => $this->excelDatas[0]->id_ujian ]);
			$data_kelas = $this->m_detail_kelas->get_by(['id_peserta' => $this->excelDatas[0]->id_user]);
			$kelas = $this->m_kelas->get_by(['kls.id' => $data_kelas->id_kelas]);
			$nama_kelas = !empty($kelas) ? $kelas->nama : '';	

			
			$nama_guru = $data_ujian->nama_guru;
			$nama_mapel = $data_ujian->nama_mapel;
		}
		else {
			$result['nama_kelas'] = '';
			$nama_guru = '';
			$nama_mapel = '';	
		}
		// Initialize excel object
		$this->excelInitialize();

		$this->excelCellsHeading = [
			['cell' => 'A', 'label' => 'No'],
			['cell' => 'B', 'label' => 'Siswa'],
			['cell' => 'C', 'label' => 'Kelas'],
			['cell' => 'D', 'label' => 'Nilai'],
			['cell' => 'E', 'label' => 'Grade'],
			['cell' => 'F', 'label' => 'Jumlah Benar'],
			['cell' => 'G', 'label' => 'Keterangan'],
			['cell' => 'H', 'label' => 'KKM'],
			['cell' => 'I', 'label' => 'Waktu Mulai'],
			['cell' => 'J', 'label' => 'Waktu Selesai']
		];


		// Write header of Document
		$this->excelObject->getActiveSheet()->setCellValue('A' . 1, 'Data Hasil Ujian PG Kelas ' . $nama_kelas);
		$this->excelObject->getActiveSheet()->setCellValue('A' . 2, 'Guru ' . $nama_guru);
		$this->excelObject->getActiveSheet()->setCellValue('A' . 3, 'Mata Pelajaran ' . $nama_mapel);

		$this->excelDataStart = 6;
		// Write heading excel use method on MY_Controller.php
		$this->excelWriteHeading(5);

		foreach($this->excelDatas as $data) {
			$ujian = $this->m_ujian->get_by(['uji.id'=>$data->id_ujian]);
			$siswa = $this->m_siswa->get_by(['id'=>$data->id_user]);
			$keterangan = ($data->nilai >= $ujian->min_nilai) ? 'LULUS' : 'BELUM LULUS';
			if($data->nilai > 90 && $data->nilai < 101){
				$grade = 'A';
			}else if($data->nilai > 80 && $data->nilai < 91){
				$grade = 'B';
			} else if($data->nilai > 70 && $data->nilai < 81){
				$grade = 'C';
			} else {
				$grade = 'D';
			}
			$id_kelas = $this->m_detail_kelas->get_by(['id_peserta' => $data->id_user]);
			$nama_kelas = $this->m_kelas->get_by(['kls.id' => $id_kelas->id_kelas]);
			$nama_kelas = !empty($nama_kelas) ? $nama_kelas->nama : '';

			$this->excelObject->getActiveSheet()->setCellValue('A' . $this->excelDataStart, $this->excelColumnNo);
			$this->excelObject->getActiveSheet()->setCellValue('B' . $this->excelDataStart, $siswa->nama);

			$this->excelObject->getActiveSheet()->setCellValue('C' . $this->excelDataStart, $nama_kelas);

			$this->excelObject->getActiveSheet()->setCellValue('D' . $this->excelDataStart, $data->nilai);

			$this->excelObject->getActiveSheet()->setCellValue('E' . $this->excelDataStart, $grade);

			$this->excelObject->getActiveSheet()->setCellValue('F' . $this->excelDataStart, $data->jml_benar);
			$this->excelObject->getActiveSheet()->setCellValue('G' . $this->excelDataStart, $keterangan);
			$this->excelObject->getActiveSheet()->setCellValue('H' . $this->excelDataStart, $ujian->min_nilai);
			$this->excelObject->getActiveSheet()->setCellValue('I' . $this->excelDataStart, $data->tgl_mulai);
			$this->excelObject->getActiveSheet()->setCellValue('J' . $this->excelDataStart, $data->tgl_selesai);

			$this->excelDataStart++;
			  $this->excelColumnNo++;
		}


		// Create Filename and output as .xlsx
		$this->excelFileName = "Data Hasil Ujian PG Kelas - " . $nama_kelas . ' ' . date('m-d-Y') . ".xlsx";
		$this->excelDisplayOutput();

		// Set No Column back to 1 for reuse
		$this->excelColumnNo = 1;
	}

	public function list_tugas_siswa($encrypt_id, $idTugas) {
		$this->load->model('m_detail_kelas');
		$this->load->model('m_tugas');
		$this->load->model('m_tugas_nilai');
		$this->load->model('m_tugas_attach_siswa');
		$id = decrypt_url($encrypt_id);
		$idTugas = decrypt_url($idTugas);
		$this->excelDatas = $this->m_detail_kelas->get_all(['id_kelas' => $id]);

		// Initialize excel object
		$this->excelInitialize();

		$this->excelCellsHeading = [
			['cell' => 'A', 'label' => 'No'],
			['cell' => 'B', 'label' => 'Siswa'],
			['cell' => 'C', 'label' => 'NIS'],
			['cell' => 'D', 'label' => 'Terkumpul'],
			['cell' => 'E', 'label' => 'Nilai']
		];

		// Write heading excel use method on MY_Controller.php
		$this->excelWriteHeading();

		$this->excelDataStart = 2;

		foreach($this->excelDatas as $data) {
			// $idTugas = $this->m_tugas->get_by(['id_kelas' => $id])->id;
			$count = $this->m_tugas_attach_siswa->count_by(array('id_tugas'=>$idTugas,'id_siswa'=>$data->id_peserta));
			$countNilai = $this->m_tugas_nilai->count_by(array('id_tugas'=>$idTugas,'id_siswa'=>$data->id_peserta));
			if($count > 0) {
				$status = 'Sudah';
				$nilai =  $this->m_tugas_nilai->get_by(array('id_tugas'=>$idTugas,'id_siswa'=>$data->id_peserta))->nilai;
			}
			else {
				$status = 'Belum';
				$nilai = 0;
			}

			$this->excelObject->getActiveSheet()->setCellValue('A' . $this->excelDataStart, $this->excelColumnNo);
			$this->excelObject->getActiveSheet()->setCellValue('B' . $this->excelDataStart, $data->nama_siswa);
			$this->excelObject->getActiveSheet()->setCellValue('C' . $this->excelDataStart, $data->nrp);
			$this->excelObject->getActiveSheet()->setCellValue('D' . $this->excelDataStart, $status);
			$this->excelObject->getActiveSheet()->setCellValue('E' . $this->excelDataStart, $nilai);

			$this->excelDataStart++;
			$this->excelColumnNo++;
		}

		// Create Filename and output as .xlsx
			$this->excelFileName = "Data Hasil Tugas Siswa - " . date('m-d-Y') . ".xlsx";
			$this->excelDisplayOutput();
		// Set No Column back to 1 for reuse
			$this->excelColumnNo = 1;
	}

	/**
	 * PDF Export Section
	 */

	public function pdf_list_tugas_siswa($encrypt_id) {
		$this->load->library('dpdf');
		$this->load->model('m_detail_kelas');
		$this->load->model('m_tugas');
		$this->load->model('m_tugas_nilai');
		$this->load->model('m_tugas_attach_siswa');
		$id = decrypt_url($encrypt_id);
		$result['datas'] = $this->m_detail_kelas->get_all(['id_kelas' => $id]);
		// print_r($result);exit;
		
		$this->dpdf->setPaper('A4', 'potrait');
		$this->dpdf->filename = 'Data Hasil Tugas.pdf';
		$this->dpdf->view('tugas/siswa_pdf', $result);
	}

	//  Rekapitulasi
	public function pdf_rekapitulasi() {
		$this->load->library('dpdf');
		$this->load->model('m_kelas');
		$this->load->model('m_ujian');
   		$this->load->model('m_tugas');
		$result = [
			'datas' => $this->m_kelas->rekaptulasi([])
		];

		// $this->sendPdf('rekaptulasi/rekap_pdf', 'A4', 'landscape', 'Rekapitulasi.pdf');
		$this->dpdf->setPaper('A4', 'landscape');
		$this->dpdf->filename = 'Rekapitulasi.pdf';
		$this->dpdf->view('rekaptulasi/rekap_pdf', $result);
	}

	public function pdf_hasil_ujian($encrypt_id) {
		$this->load->library('dpdf');
		$this->load->model('m_ikut_ujian');
		$this->load->model('m_ujian');
		$this->load->model('m_siswa');
		$this->load->model('m_kelas');
		$this->load->model('m_detail_kelas');
		$id = decrypt_url($encrypt_id);

		$data_hasil = $this->m_ikut_ujian->get_many_by(['id_ujian' => $id]);
		$result = [
			'datas' => $data_hasil
		];
		if(count($data_hasil) > 0) {
			$data_ujian = $this->m_ujian->get_by(['uji.id' => $data_hasil[0]->id_ujian ]);
			$data_kelas = $this->m_detail_kelas->get_by(['id_peserta' => $data_hasil[0]->id_user]);
			$kelas = $this->m_kelas->get_by(['kls.id' => $data_kelas->id_kelas]);
			$nama_kelas = !empty($kelas) ? $kelas->nama : '';	

			$result['nama_kelas'] = $nama_kelas;
			$result['nama_guru'] = $data_ujian->nama_guru;
			$result['nama_mapel'] = $data_ujian->nama_mapel;
		}
		else {
			$result['nama_kelas'] = '';
			$result['nama_guru'] = '';
			$result['nama_mapel'] = '';	
		}
		
		$this->dpdf->setPaper('A4', 'landscape');
		$this->dpdf->filename = 'Hasil Ujian.pdf';
		$this->dpdf->view('ujian/hasil_ujian_pdf', $result);

	}

	public function pdf_hasil_ujian_essay($encrypt_id) {
	
		$this->load->library('dpdf');
		$this->load->model('m_ikut_ujian_essay');
		$this->load->model('m_ujian');
		$this->load->model('m_siswa');
		$this->load->model('m_kelas');
		$this->load->model('m_detail_kelas');
		$id_ujian = decrypt_url($encrypt_id);

		$result = [
			'datas' => $this->m_ikut_ujian_essay->get_many_by(['id_ujian' => $id_ujian])
		];
		if(count($result['datas']) > 0) {
			$data_ujian = $this->m_ujian->get_by(['uji.id' => $result['datas'][0]->id_ujian ]);
			$data_kelas = $this->m_detail_kelas->get_by(['id_peserta' => $result['datas'][0]->id_user]);
			$kelas = $this->m_kelas->get_by(['kls.id' => $data_kelas->id_kelas]);
			$nama_kelas = !empty($kelas) ? $kelas->nama : '';	

			$result['nama_kelas'] = $nama_kelas;
			$result['nama_guru'] = $data_ujian->nama_guru;
			$result['nama_mapel'] = $data_ujian->nama_mapel;
		}
		else {
			$result['nama_kelas'] = '';
			$result['nama_guru'] = '';
			$result['nama_mapel'] = '';
		}

		$this->dpdf->setPaper('A4', 'landscape');
		$this->dpdf->filename = 'Hasil Ujian Essay.pdf';
		$this->dpdf->view('ujian_essay/pdf_list_hasil', $result);
	}
}