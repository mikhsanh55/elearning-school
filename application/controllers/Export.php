<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
include APPPATH.'third_party/PHPExcel/PHPExcel.php';

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
		$this->excelInitialize();
	}

	/* Built-in Methods */
	public function excelInitialize() {
		$this->excelObject = new PHPExcel();
		$this->excelObject->setActiveSheetIndex(0);
	}

	public function excelWriteHeading() {
		foreach($this->excelCellsHeading as $cells) {
			$this->excelObject->getActiveSheet()->SetCellValue($cells['cell'] . '1', $cells['label']);
		}
	}

	public function excelDisplayOutput() {
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="'.$this->excelFileName.'"');
		header('Cache-Control: max-age=0'); 
		$this->excelObjectWriter = PHPExcel_IOFactory::createWriter($this->excelObject, 'Excel2007');  
		$this->excelObjectWriter->save('php://output'); 
	}

	// Rekapitulasi
	public function rekapitulasi() {
		$this->load->model('m_kelas');
		$this->load->model('m_ujian');
		$this->load->model('m_tugas');
		$where = [];
		$this->excelDatas = $this->m_kelas->rekaptulasi($where);

	    $this->excelCellsHeading = [
	      ['cell' => 'A', 'label' => 'No'],
	      ['cell' => 'B', 'label' => 'Siswa'],
		  ['cell' => 'C', 'label' => 'Kelas'],
		  ['cell' => 'D', 'label' => 'Semester'],
		  ['cell' => 'E', 'label' => 'Mata Kuliah'],
		  ['cell' => 'F', 'label' => 'UTS'],
		  ['cell' => 'G', 'label' => 'UAS'],
		  ['cell' => 'H', 'label' => 'Tugas'],
		  ['cell' => 'I', 'label' => 'Keaktifan'],
	    ];

	    // Write heading excel use method on MY_Controller.php
	    $this->excelWriteHeading();

		$this->excelDataStart = 2;
		
		foreach($this->excelDatas as $rows) {
			
			$uts = $this->m_ujian->get_nilai(['uji.type_ujian'=>'uts','uji.id_kelas'=>$rows->id_kelas,'id_user'=>$rows->id_peserta]);

			$uas = $this->m_ujian->get_nilai(['uji.type_ujian'=>'uas','uji.id_kelas'=>$rows->id_kelas,'id_user'=>$rows->id_peserta]);

			$tugas = $this->m_tugas->get_nilai(['tgs.id_kelas'=>$rows->id_kelas,'id_siswa'=>$rows->id_peserta]);

			$this->excelObject->getActiveSheet()->SetCellValue('A' . $this->excelDataStart, $this->excelColumnNo);
			$this->excelObject->getActiveSheet()->SetCellValue('B' . $this->excelDataStart, $rows->siswa);
			$this->excelObject->getActiveSheet()->SetCellValue('C' . $this->excelDataStart, $rows->jurusan);
			$this->excelObject->getActiveSheet()->SetCellValue('D' . $this->excelDataStart, $rows->semester);
			$this->excelObject->getActiveSheet()->SetCellValue('E' . $this->excelDataStart, $rows->mapel);
			$this->excelObject->getActiveSheet()->SetCellValue('F' . $this->excelDataStart, isset($uts->nilai) ? (int)$uts->nilai : 0 );
			$this->excelObject->getActiveSheet()->SetCellValue('G' . $this->excelDataStart, isset($uas->nilai) ? (int)$uas->nilai : 0 );
			$this->excelObject->getActiveSheet()->SetCellValue('H' . $this->excelDataStart, isset($tugas->nilai) ? (int)$tugas->nilai : 0 );
			$this->excelObject->getActiveSheet()->SetCellValue('I' . $this->excelDataStart, 0);

			$this->excelDataStart++;
	      	$this->excelColumnNo++;
		}

		// Create Filename and output as .xlsx
	    $this->excelFileName = "Data Rekapitulasi - " . date('m-d-Y') . ".xlsx";
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
	      $this->excelObject->getActiveSheet()->SetCellValue('A' . $this->excelDataStart, $this->excelColumnNo);
	      $this->excelObject->getActiveSheet()->SetCellValue('B' . $this->excelDataStart, $data->id);
	      $this->excelObject->getActiveSheet()->SetCellValue('C' . $this->excelDataStart, $data->jurusan);

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
			['cell' => 'B', 'label' => 'Tempat Lahir'],
			['cell' => 'C', 'label' => 'Tanggal Lahir'],
			['cell' => 'D', 'label' => 'Lembaga'],
			['cell' => 'E', 'label' => 'No Telpon'],
			['cell' => 'F', 'label' => 'Email']
		];

		// Write heading excel use method on MY_Controller.php
    	$this->excelWriteHeading();

		// Set Writer for write data after heading
		$this->excelDataStart = 2;

		foreach($this->excelDatas as $key => $data) {
			$this->excelObject->getActiveSheet()->SetCellValue('A' . $this->excelDataStart, $data->nama);
			$this->excelObject->getActiveSheet()->SetCellValue('B' . $this->excelDataStart, $data->tempat_lahir);
			$this->excelObject->getActiveSheet()->SetCellValue('C' . $this->excelDataStart, $data->tanggal_lahir);
			$this->excelObject->getActiveSheet()->SetCellValue('D' . $this->excelDataStart, $data->nama_instansi);
			$this->excelObject->getActiveSheet()->SetCellValue('E' . $this->excelDataStart, $data->no_telpon);
			$this->excelObject->getActiveSheet()->SetCellValue('F' . $this->excelDataStart, $data->email);
			$this->excelDataStart++;
		}

		// Create New File use method on MY_Controller.php
		$this->excelFileName = "Data Admin Lembaga - " . date('m-d-Y') . ".xlsx";
		$this->excelDisplayOutput();

	}

	// Mapel / Kurikulum
	public function kurikulum() {
		$this->load->model('m_mapel');
		
		$where['id_instansi'] = $this->akun->instansi;
		$this->excelDatas = $this->m_mapel->get_many_by($where);

		$this->excelCellsHeading = [
			['cell' => 'A', 'label' => 'No'],
			['cell' => 'B', 'label' => 'Kode Mata Kuliah'],
			['cell' => 'C', 'label' => 'Mata Kuliah'],
			['cell' => 'D', 'label' => 'SKS'],
			['cell' => 'E', 'label' => 'Semester'],
			['cell' => 'F', 'label' => 'Angkatan'],
		];

		// Write heading excel use method on MY_Controller.php
    	$this->excelWriteHeading();

		// Set Writer for write data after heading
		$this->excelDataStart = 2;

		foreach($this->excelDatas as $key => $data) {
			$this->excelObject->getActiveSheet()->SetCellValue('A' . $this->excelDataStart, $this->excelColumnNo);
			$this->excelObject->getActiveSheet()->SetCellValue('B' . $this->excelDataStart, $data->kd_mp);
			$this->excelObject->getActiveSheet()->SetCellValue('C' . $this->excelDataStart, $data->nama);
			$this->excelObject->getActiveSheet()->SetCellValue('D' . $this->excelDataStart, $data->sks);
			$this->excelObject->getActiveSheet()->SetCellValue('E' . $this->excelDataStart, $data->semester);
			$this->excelObject->getActiveSheet()->SetCellValue('F' . $this->excelDataStart, $data->angkatan);
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

		$this->excelDatas = $this->m_guru->get_many_by($where);
 		
 		// Initialize excel object
	    $this->excelInitialize();

	    $this->excelCellsHeading = [
	    	['cell' => 'A', 'label' => 'No'],
	    	['cell' => 'B', 'label' => 'Nama'],
	    	['cell' => 'C', 'label' => 'Tempat Lahir'],
	    	['cell' => 'D', 'label' => 'Tanggal Lahir'],
	    	['cell' => 'E', 'label' => 'Alamat'],
	    	['cell' => 'F', 'label' => 'NIDN'],
	    	['cell' => 'G', 'label' => 'NRP'],
	    	['cell' => 'H', 'label' => 'Pangkat'],
	    	['cell' => 'I', 'label' => 'Jabatan Akademik'],
	    	['cell' => 'J', 'label' => 'Tahun Akademik'],
	    	['cell' => 'K', 'label' => 'Pendidikan Umum Terakhir'],
	    	['cell' => 'L', 'label' => 'Pendidikan Militer Terakhir'],
	    	['cell' => 'M', 'label' => 'Semester'],
	    	['cell' => 'N', 'label' => 'Status'],
	    	['cell' => 'O', 'label' => 'No Telpon'],
	    	['cell' => 'P', 'label' => 'Username'],
	    	['cell' => 'Q', 'label' => 'Email']
	    ];

	    // Write heading excel use method on MY_Controller.php
    	$this->excelWriteHeading();

	    $this->excelDataStart = 2;

	    foreach($this->excelDatas as $data) {
	      $this->excelObject->getActiveSheet()->SetCellValue('A' . $this->excelDataStart, $this->excelColumnNo);
	      $this->excelObject->getActiveSheet()->SetCellValue('B' . $this->excelDataStart, $data->nama);
	      $this->excelObject->getActiveSheet()->SetCellValue('C' . $this->excelDataStart, $data->tempat_lahir);

	      $this->excelObject->getActiveSheet()->SetCellValue('D' . $this->excelDataStart, $data->tanggal_lahir);
	      $this->excelObject->getActiveSheet()->SetCellValue('E' . $this->excelDataStart, $data->alamat);
	      $this->excelObject->getActiveSheet()->SetCellValue('F' . $this->excelDataStart, $data->nidn);
	      $this->excelObject->getActiveSheet()->SetCellValue('G' . $this->excelDataStart, $data->nrp);
	      $this->excelObject->getActiveSheet()->SetCellValue('H' . $this->excelDataStart, $data->pangkat);
	      $this->excelObject->getActiveSheet()->SetCellValue('I' . $this->excelDataStart, $data->jabatan_akademik);
	      $this->excelObject->getActiveSheet()->SetCellValue('J' . $this->excelDataStart, $data->tahun_akademik);
	      $this->excelObject->getActiveSheet()->SetCellValue('K' . $this->excelDataStart, $data->pendidikan_umum_terakhir);
	      $this->excelObject->getActiveSheet()->SetCellValue('L' . $this->excelDataStart, $data->pendidikan_militer_terakhir);
	      $this->excelObject->getActiveSheet()->SetCellValue('M' . $this->excelDataStart, $data->semester);
	      $this->excelObject->getActiveSheet()->SetCellValue('N' . $this->excelDataStart, $data->status);
	      $this->excelObject->getActiveSheet()->SetCellValue('O' . $this->excelDataStart, $data->no_telpon);
	      $this->excelObject->getActiveSheet()->SetCellValue('P' . $this->excelDataStart, $data->username);
	      $this->excelObject->getActiveSheet()->SetCellValue('Q' . $this->excelDataStart, $data->email);

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
			['cell' => 'A', 'label' => 'Nama'],
			['cell' => 'B', 'label' => 'NIK'],
			['cell' => 'C', 'label' => 'NRP'],
			['cell' => 'D', 'label' => 'NIM'],
			['cell' => 'E', 'label' => 'Tempat Lahir'],
			['cell' => 'F', 'label' => 'Tanggal Lahir'],
			['cell' => 'G', 'label' => 'Alamat'],
			['cell' => 'H', 'label' => 'Pangkat'],
			// ['cell' => 'I', 'label' => 'Angkatan'],
			['cell' => 'I', 'label' => 'Tahun Angkatan Masuk'],
			['cell' => 'J', 'label' => 'No Telpon'],
			['cell' => 'K', 'label' => 'Email'],
		];

		// Write heading excel use method on MY_Controller.php
    	$this->excelWriteHeading();

		$this->excelDataStart = 2;
		foreach($this->excelDatas as $i => $data) {
			$this->excelObject->getActiveSheet()->SetCellValue('A' . $this->excelDataStart, $data->nama);
			$this->excelObject->getActiveSheet()->SetCellValue('B' . $this->excelDataStart, $data->nik);
			$this->excelObject->getActiveSheet()->SetCellValue('C' . $this->excelDataStart, $data->nim);
			$this->excelObject->getActiveSheet()->SetCellValue('D' . $this->excelDataStart, $data->nrp);
			$this->excelObject->getActiveSheet()->SetCellValue('E' . $this->excelDataStart, $data->tempat_lahir);
			$this->excelObject->getActiveSheet()->SetCellValue('F' . $this->excelDataStart, $data->tanggal_lahir);
			$this->excelObject->getActiveSheet()->SetCellValue('G' . $this->excelDataStart, $data->alamat);
			$this->excelObject->getActiveSheet()->SetCellValue('H' . $this->excelDataStart, $data->pangkat);
			// $this->excelObject->getActiveSheet()->SetCellValue('I' . $this->excelDataStart, $data->angkatan)
			// ;
			$this->excelObject->getActiveSheet()->SetCellValue('I' . $this->excelDataStart, $data->tahun_angkatan_masuk);
			$this->excelObject->getActiveSheet()->SetCellValue('J' . $this->excelDataStart, $data->no_telpon);
			$this->excelObject->getActiveSheet()->SetCellValue('K' . $this->excelDataStart, $data->email);
			$this->excelDataStart++;
		}

		// Create New File use method on MY_Controller.php
		$this->excelFileName = "Data Siswa - " . date('m-d-Y') . ".xlsx";
		$this->excelDisplayOutput();
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
			['cell' => 'B', 'label' => 'Nama Pengajar'],
			['cell' => 'C', 'label' => 'Room'],
			['cell' => 'D', 'label' => 'Mata Kuliah'],
			['cell' => 'E', 'label' => 'Keterangan'],
			['cell' => 'F', 'label' => 'Total Siswa'],
			['cell' => 'G', 'label' => 'Lembaga'],
		];

		// Write heading excel use method on MY_Controller.php
    	$this->excelWriteHeading();

		$this->excelDataStart = 2;

		foreach($this->excelDatas as $data) {
			$jml_siswa = $this->m_detail_kelas->count_by(['id_kelas'=>$data->id]);
			
			$this->excelObject->getActiveSheet()->SetCellValue('A' . $this->excelDataStart, $this->excelColumnNo);
			$this->excelObject->getActiveSheet()->SetCellValue('B' . $this->excelDataStart, $data->nama_guru);
			$this->excelObject->getActiveSheet()->SetCellValue('C' . $this->excelDataStart, $data->nama);
			$this->excelObject->getActiveSheet()->SetCellValue('D' . $this->excelDataStart, $data->nama_mapel);
			$this->excelObject->getActiveSheet()->SetCellValue('E' . $this->excelDataStart, $data->keterangan);
			$this->excelObject->getActiveSheet()->SetCellValue('F' . $this->excelDataStart, $jml_siswa);
			$this->excelObject->getActiveSheet()->SetCellValue('G' . $this->excelDataStart, $data->instansi);

			$this->excelDataStart++;
			$this->excelColumnNo++;
		}

		// Create New File use method on MY_Controller.php
		$this->excelFileName = "Data Room - " . date('m-d-Y') . ".xlsx";
		$this->excelDisplayOutput();

		$this->excelColumnNo = 1;
	}

	// Data Ujian
	public function ujian() {
		$this->load->model('m_ujian');
		$where['kls.id_instansi'] = $this->akun->instansi;
		$this->excelDatas = $this->m_ujian->get_many_by($where);
		// print_r($this->excelDatas);	

		$this->excelCellsHeading = [
			['cell' => 'A', 'label' => 'No'],
			['cell' => 'B', 'label' => 'Tipe Ujian'],
			['cell' => 'C', 'label' => 'Nama Ujian'],
			['cell' => 'D', 'label' => 'Kelas'],
			['cell' => 'E', 'label' => 'Tanggal Mulai'],
			['cell' => 'F', 'label' => 'Tanggal Selesai'],
			['cell' => 'G', 'label' => 'Waktu Ujian'],
			['cell' => 'H', 'label' => 'Minimal Nilai Lulus'],
		];

		// Write heading excel use method on MY_Controller.php
    	$this->excelWriteHeading();

		$this->excelDataStart = 2;

		foreach($this->excelDatas as $data) {
			$this->excelObject->getActiveSheet()->SetCellValue('A' . $this->excelDataStart, $this->excelColumnNo);
			$this->excelObject->getActiveSheet()->SetCellValue('B' . $this->excelDataStart, $data->type_ujian);			
			$this->excelObject->getActiveSheet()->SetCellValue('C' . $this->excelDataStart, $data->nama_ujian);
			$this->excelObject->getActiveSheet()->SetCellValue('D' . $this->excelDataStart, $data->kelas);
			$this->excelObject->getActiveSheet()->SetCellValue('E' . $this->excelDataStart, $data->tgl_mulai);
			$this->excelObject->getActiveSheet()->SetCellValue('F' . $this->excelDataStart, $data->terlambat);
			$this->excelObject->getActiveSheet()->SetCellValue('G' . $this->excelDataStart, $data->waktu);
			$this->excelObject->getActiveSheet()->SetCellValue('H' . $this->excelDataStart, $data->min_nilai);

			$this->excelDataStart++;
			$this->excelColumnNo++;

			// Create New File use method on MY_Controller.php
			$this->excelFileName = "Data Ujian - " . date('m-d-Y') . ".xlsx";
			$this->excelDisplayOutput();

			$this->excelColumnNo = 1;
		}
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
			['cell' => 'B', 'label' => 'Pengajar'],
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
			$this->excelObject->getActiveSheet()->SetCellValue('A' . $this->excelDataStart, $this->excelColumnNo);
			$this->excelObject->getActiveSheet()->SetCellValue('B' . $this->excelDataStart, 
				$data->nama_guru);
			$this->excelObject->getActiveSheet()->SetCellValue('C' . $this->excelDataStart, 
				$data->nama_mp);
			$this->excelObject->getActiveSheet()->SetCellValue('D' . $this->excelDataStart, 
				$data->nama_materi);
			$this->excelObject->getActiveSheet()->SetCellValue('E' . $this->excelDataStart, 
				$data->keterangan);
			$this->excelObject->getActiveSheet()->SetCellValue('F' . $this->excelDataStart, 
				$data->start_date);
			$this->excelObject->getActiveSheet()->SetCellValue('G' . $this->excelDataStart, 
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

	/**
	 * PDF Export Section
	 */

	

	//  Rekapitulasi
	public function pdf_rekapitulasi() {
		$this->load->library('dpdf');
		$this->load->model('m_kelas');
		$this->load->model('m_ujian');
   		$this->load->model('m_tugas');
		$result = [
			'datas' => $this->m_kelas->rekaptulasi([])
		];

		$this->sendPdf('rekaptulasi/rekap_pdf', 'A4', 'landscape', 'Rekapitulasi.pdf');
		$this->dpdf->setPaper('A4', 'landscape');
		$this->dpdf->filename = 'Rekapitulasi.pdf';
		$this->dpdf->view('rekaptulasi/rekap_pdf', $result);
	}

	public function pdf_hasil_ujian($encrypt_id) {
		$this->load->library('dpdf');
		$this->load->model('m_ikut_ujian');
		$id = decrypt_url($encrypt_id);
		$result = [
			'datas' => $this->m_ikut_ujian->get_many_by(['id' => $id, 'status' => 'N'])
		];

		// print_r($result['datas']);exit;
		$this->dpdf->setPaper('A4', 'landscape');
		$this->dpdf->filename = 'Hasil Ujian.pdf';
		$this->dpdf->view('ujian/hasil_ujian', $result);

	}

	public function pdf_hasil_ujian_essay($encrypt_id) {
		$id_ujian = decrypt_url($encrypt_id);

		$this->load->library('dpdf');
		$this->load->model('m_ikut_ujian_essay');
		$this->load->model('m_ujian');
		$this->load->model('m_siswa');

		$result = [
			'datas' => $this->m_ikut_ujian_essay->get_many_by(['id_ujian' => $id_ujian])
		];

		// print_r($result);
		$this->dpdf->setPaper('A4', 'landscape');
		$this->dpdf->filename = 'Hasil Ujian Essay.pdf';
		$this->load->view('ujian_essay/pdf_list_hasil', $result);
	}
}