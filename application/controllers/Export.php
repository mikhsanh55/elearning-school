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
		  
		  ['cell' => 'D', 'label' => 'Mata Pelajaran'],
		  ['cell' => 'E', 'label' => 'UTS'],
		  ['cell' => 'F', 'label' => 'UAS'],
		  ['cell' => 'G', 'label' => 'Tugas'],
		  ['cell' => 'H', 'label' => 'Keaktifan'],
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
			$this->excelObject->getActiveSheet()->SetCellValue('D' . $this->excelDataStart, $rows->mapel);
			$this->excelObject->getActiveSheet()->SetCellValue('E' . $this->excelDataStart, isset($uts->nilai) ? (int)$uts->nilai : 0 );
			$this->excelObject->getActiveSheet()->SetCellValue('F' . $this->excelDataStart, isset($uas->nilai) ? (int)$uas->nilai : 0 );
			$this->excelObject->getActiveSheet()->SetCellValue('G' . $this->excelDataStart, isset($tugas->nilai) ? (int)$tugas->nilai : 0 );
			$this->excelObject->getActiveSheet()->SetCellValue('H' . $this->excelDataStart, 0);

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
			['cell' => 'B', 'label' => 'Username'],
			['cell' => 'C', 'label' => 'No Telpon'],
			['cell' => 'D', 'label' => 'Email']
		];

		// Write heading excel use method on MY_Controller.php
    	$this->excelWriteHeading();

		// Set Writer for write data after heading
		$this->excelDataStart = 2;

		foreach($this->excelDatas as $key => $data) {
			$this->excelObject->getActiveSheet()->SetCellValue('A' . $this->excelDataStart, $data->nama);
			$this->excelObject->getActiveSheet()->SetCellValue('B' . $this->excelDataStart, $data->username);
			$this->excelObject->getActiveSheet()->SetCellValue('C' . $this->excelDataStart, $data->no_telpon);
			$this->excelObject->getActiveSheet()->SetCellValue('D' . $this->excelDataStart, $data->email);
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
			$this->excelObject->getActiveSheet()->SetCellValue('A' . $this->excelDataStart, $this->excelColumnNo);
			$this->excelObject->getActiveSheet()->SetCellValue('B' . $this->excelDataStart, $data->kd_mp);
			$this->excelObject->getActiveSheet()->SetCellValue('C' . $this->excelDataStart, $data->nama);
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
 		// print_r($this->excelDatas);exit;
 		// Initialize excel object
	    $this->excelInitialize();

	    $this->excelCellsHeading = [
	    	['cell' => 'A', 'label' => 'No'],
	    	['cell' => 'B', 'label' => 'NUPTK'],
	    	['cell' => 'C', 'label' => 'NIP'],
	    	['cell' => 'D', 'label' => 'Nama Guru'],
	    	['cell' => 'E', 'label' => 'Username'],
	    	['cell' => 'F', 'label' => 'Mata Pelajaran'],
	    	['cell' => 'G', 'label' => 'Email'],
	    	['cell' => 'H', 'label' => 'No Telpon'],
	    	['cell' => 'I', 'label' => 'Password'],
	    ];

	    // Write heading excel use method on MY_Controller.php
    	$this->excelWriteHeading();

	    $this->excelDataStart = 2;

	    foreach($this->excelDatas as $data) {
	      $this->excelObject->getActiveSheet()->SetCellValue('A' . $this->excelDataStart, $this->excelColumnNo);
	      $this->excelObject->getActiveSheet()->SetCellValue('B' . $this->excelDataStart, $data->nidn);
	      $this->excelObject->getActiveSheet()->SetCellValue('C' . $this->excelDataStart, $data->nrp);

	      $this->excelObject->getActiveSheet()->SetCellValue('D' . $this->excelDataStart, $data->nama);
	      $this->excelObject->getActiveSheet()->SetCellValue('E' . $this->excelDataStart, $data->username);
	      $this->excelObject->getActiveSheet()->SetCellValue('F' . $this->excelDataStart, $data->nama_mapel == '' ? 'Belum Ada' : $data->nama_mapel);
	      $this->excelObject->getActiveSheet()->SetCellValue('G' . $this->excelDataStart, $data->email);
	      $this->excelObject->getActiveSheet()->SetCellValue('H' . $this->excelDataStart, $data->no_telpon);
	      $this->excelObject->getActiveSheet()->SetCellValue('I' . $this->excelDataStart, $this->encryption->decrypt($data->password));

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
			['cell' => 'F', 'label' => 'Wali Kelas'],
			['cell' => 'G', 'label' => 'Jenis Kelamin'],
			['cell' => 'H', 'label' => 'Email'],
			['cell' => 'I', 'label' => 'Alamat'],
			// ['cell' => 'I', 'label' => 'Angkatan'],
			['cell' => 'J', 'label' => 'No Telpon'],
			['cell' => 'K', 'label' => 'Password'],
		];

		// Write heading excel use method on MY_Controller.php
    	$this->excelWriteHeading();

		$this->excelDataStart = 2;
		foreach($this->excelDatas as $i => $data) {
			$this->excelObject->getActiveSheet()->SetCellValue('A' . $this->excelDataStart, $this->excelColumnNo);
			$this->excelObject->getActiveSheet()->SetCellValue('B' . $this->excelDataStart, $data->nama);
			$this->excelObject->getActiveSheet()->SetCellValue('C' . $this->excelDataStart, $data->username);
			$this->excelObject->getActiveSheet()->SetCellValue('D' . $this->excelDataStart, $data->nrp);
			$this->excelObject->getActiveSheet()->SetCellValue('E' . $this->excelDataStart, $data->nama_kelas);
			$this->excelObject->getActiveSheet()->SetCellValue('F' . $this->excelDataStart, $data->nama_guru);
			$this->excelObject->getActiveSheet()->SetCellValue('H' . $this->excelDataStart, $data->email);
			$this->excelObject->getActiveSheet()->SetCellValue('I' . $this->excelDataStart, $data->alamat);
			$this->excelObject->getActiveSheet()->SetCellValue('J' . $this->excelDataStart, $data->no_telpon);
			$this->excelObject->getActiveSheet()->SetCellValue('K' . $this->excelDataStart, $this->encryption->decrypt($data->password));
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

	// Hasil Ujian PG
	public function hasil_ujian($md5_id_ujian) {
		$this->load->model('m_ikut_ujian');
		$this->load->model('m_ujian');
		$this->load->model('m_siswa');
		$id = decrypt_url($md5_id_ujian);
		$this->excelDatas = $this->m_ikut_ujian->get_many_by(['id_ujian' => $id, 'status' => 'N']);
		// print_r($this->excelDatas);exit;
		// Initialize excel object
		$this->excelInitialize();

		$this->excelCellsHeading = [
			['cell' => 'A', 'label' => 'No'],
			['cell' => 'B', 'label' => 'Siswa'],
			['cell' => 'C', 'label' => 'Jumlah Benar'],
			['cell' => 'D', 'label' => 'Keterangan'],
			['cell' => 'E', 'label' => 'KKM'],
			['cell' => 'F', 'label' => 'Waktu Mulai'],
			['cell' => 'G', 'label' => 'Waktu Selesai']
		];

		// Write heading excel use method on MY_Controller.php
		$this->excelWriteHeading();

		$this->excelDataStart = 2;

		foreach($this->excelDatas as $data) {
			$ujian = $this->m_ujian->get_by(['uji.id'=>$data->id_ujian]);
			$siswa = $this->m_siswa->get_by(['id'=>$data->id_user]);
			$keterangan = ($data->nilai >= $ujian->min_nilai) ? 'LULUS' : 'BELUM LULUS';
			$this->excelObject->getActiveSheet()->SetCellValue('A' . $this->excelDataStart, $this->excelColumnNo);
			$this->excelObject->getActiveSheet()->SetCellValue('B' . $this->excelDataStart, $siswa->nama);
			$this->excelObject->getActiveSheet()->SetCellValue('C' . $this->excelDataStart, $data->jml_benar);
			$this->excelObject->getActiveSheet()->SetCellValue('D' . $this->excelDataStart, $keterangan);
			$this->excelObject->getActiveSheet()->SetCellValue('E' . $this->excelDataStart, $ujian->min_nilai);
			$this->excelObject->getActiveSheet()->SetCellValue('F' . $this->excelDataStart, $data->tgl_mulai);
			$this->excelObject->getActiveSheet()->SetCellValue('G' . $this->excelDataStart, $data->tgl_selesai);

			$this->excelDataStart++;
			  $this->excelColumnNo++;
		}


		// Create Filename and output as .xlsx
		$this->excelFileName = "Data Hasil Ujian - " . date('m-d-Y') . ".xlsx";
		$this->excelDisplayOutput();

		// Set No Column back to 1 for reuse
		$this->excelColumnNo = 1;
	}

	public function list_tugas_siswa($encrypt_id) {
		$this->load->model('m_detail_kelas');
		$this->load->model('m_tugas');
		$this->load->model('m_tugas_nilai');
		$this->load->model('m_tugas_attach_siswa');
		$id = decrypt_url($encrypt_id);
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
			$id_tugas = $this->m_tugas->get_by(['id_kelas' => $id])->id;
			$count = $this->m_tugas_attach_siswa->count_by(array('id_tugas'=>$id_tugas,'id_siswa'=>$data->id_peserta));
			$countNilai = $this->m_tugas_nilai->count_by(array('id_tugas'=>$id_tugas,'id_siswa'=>$data->id_peserta));
			if($count > 0 && $countNilai > 0) {
				$status = 'Sudah';
				$nilai =  $this->m_tugas_nilai->get_by(array('id_tugas'=>$id_tugas,'id_siswa'=>$data->id_peserta))->nilai;
			}
			else {
				$status = 'Belum';
				$nilai = 0;
			}

			$this->excelObject->getActiveSheet()->SetCellValue('A' . $this->excelDataStart, $this->excelColumnNo);
			$this->excelObject->getActiveSheet()->SetCellValue('B' . $this->excelDataStart, $data->nama_siswa);
			$this->excelObject->getActiveSheet()->SetCellValue('C' . $this->excelDataStart, $data->nrp);
			$this->excelObject->getActiveSheet()->SetCellValue('D' . $this->excelDataStart, $status);
			$this->excelObject->getActiveSheet()->SetCellValue('E' . $this->excelDataStart, $nilai);

			$this->excelDataStart++;
			$this->excelColumnNo++;

			// Create Filename and output as .xlsx
			$this->excelFileName = "Data Hasil Tugas Siswa - " . date('m-d-Y') . ".xlsx";
			$this->excelDisplayOutput();

			// Set No Column back to 1 for reuse
			$this->excelColumnNo = 1;
		}
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

		// $this->sendPdf('rekaptulasi/rekap_pdf', 'A4', 'potrait', 'Rekapitulasi.pdf');
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