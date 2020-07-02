<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class Import extends MY_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('m_siswa');
        $this->load->model('m_guru');
        $this->load->model('m_ujian');
        $this->load->model('m_soal_ujian');
        $this->load->model('m_jurusan');
        $this->load->model('m_mapel');
        
        $this->db->query("SET time_zone='+7:00'");
    }
    
    public function cek_aktif() {
        if ($this->session->userdata('admin_valid') == false && $this->session->userdata('admin_id') == "") {
            redirect('adm/login');
        } 
    }

    public function siswa() {

        include APPPATH.'third_party/PHPExcel/PHPExcel.php';

        $config['upload_path'] = realpath('./upload/temp');
        $config['allowed_types'] = 'xlsx|xls|csv';
        $config['max_size'] = '10000';
        $config['encrypt_name'] = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {

            //upload gagal
            $this->session->set_flashdata('notif', '<div class="alert alert-danger"><b>PROSES IMPORT GAGAL!</b> '.$this->upload->display_errors().'</div>');
            //redirect halaman
            redirect(base_url('pengusaha/import'));

        } else {

            $data_upload = $this->upload->data();

            $excelreader     = new PHPExcel_Reader_Excel2007();
            $loadexcel         = $excelreader->load('./upload/temp/'.$data_upload['file_name']); // Load file yang telah diupload ke folder excel
            $sheet             = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
          

            $data = array();

            $last_id = $this->db->order_by('id','desc')->limit(1)->get('m_siswa')->row();

            if (!empty($last_id->id)) {
                $last_id = $last_id->id;
            }else{
                $last_id = 1;
            }

            $this->db->trans_begin();
            foreach($sheet as $index => $row){


                if ($index != 1) {
                        $id_kelas = $this->m_jurusan->get_by(['jurusan' => $row['E'], 'id_instansi' => $this->akun->instansi]);
                        $id_guru = $this->m_guru->get_by(['nama' => $row['F'], 'instansi' => $this->akun->instansi]);
                        $jk = ($row['G'] == 'L' || $row['G'] == 'Laki-laki') ? 1 : 0;
                        $data = array(
                            'nama'  => $row['B'],
                            'username'  => $row['C'],
                            'nrp' => $row['D'], // NIS
                            'id_jurusan' => !empty($id_kelas) ? $id_kelas->id : 0,
                            'id_guru' => !empty($id_guru) ? $id_guru->id : 0, // Wali Kelas
                            'no_telpon' => $row['J'],
                            'nik' => $jk, // Jenis Kelamin
                            'email'  => $row['H'],
                            'alamat'  => $row['I'],
                            'instansi'  => $this->akun->instansi,
                            'pembuatan_akun' => time(),
                            'verifikasi' => md5(time())
                        );

                        $this->db->insert('m_siswa', $data);
                        $inserted_id = $this->db->insert_id();

                        $data_admin = [
                            'user_id'  => $row['C'],
                            'username' => $row['H'],
                            'password'  => $this->encryption->encrypt($row['K']),
                            'level'    => 'siswa',
                            'kon_id'   => $inserted_id
                        ];

                        $this->db->insert('m_admin', $data_admin);

                    }
                }

              
               

                // $kirim = $this->db->insert_batch('m_siswa', $data);

               
            
                // $siswa = $this->m_siswa->get_many_by(array('akun.id > '=>$last_id));
        
                // $admin = array();

                // foreach ($siswa as $key => $rows) {
                //     $admin[$key] = array(
                //         'user_id'  => $rows->username,
                //         'username' => $rows->email,
                //         'password' => md5($rows->username),
                //         'level'    => 'siswa',
                //         'kon_id'   => $rows->id,
                //         'status'   => 0,

                //     );
                // }

            

                // $this->db->insert_batch('m_admin', $admin);


                if ($this->db->trans_status() === FALSE)
                {
                    $this->db->trans_rollback();
                }
                else
                {
                    $this->db->trans_commit();
                }

                
            }

          
            //delete file from server
            unlink(realpath('./upload/temp/'.$data_upload['file_name']));

            //upload success
            $this->session->set_flashdata('notif', '<div class="alert alert-success"><b>PROSES IMPORT BERHASIL!</b> Data berhasil diimport!</div>');
            //redirect halaman
             redirect(base_url('pengusaha/import'));;

    }


    public function guru() {

        include APPPATH.'third_party/PHPExcel/PHPExcel.php';

        $config['upload_path'] = realpath('./upload/temp');
        $config['allowed_types'] = 'xlsx|xls|csv';
        $config['max_size'] = '10000';
        $config['encrypt_name'] = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {

            //upload gagal
            $this->session->set_flashdata('notif', '<div class="alert alert-danger"><b>PROSES IMPORT GAGAL!</b> '.$this->upload->display_errors().'</div>');
            //redirect halaman
            redirect(base_url('trainer/import'));

        } else {

            $data_upload = $this->upload->data();

            $excelreader     = new PHPExcel_Reader_Excel2007();
            $loadexcel         = $excelreader->load('./upload/temp/'.$data_upload['file_name']); // Load file yang telah diupload ke folder excel
            $sheet             = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);

            $data = array(); $data_admin = [];

             $last_id = $this->db->order_by('id','desc')->limit(1)->get('m_guru')->row();

            if (!empty($last_id->id)) {
                $last_id = $last_id->id;
            }else{
                $last_id = 1;
            }
             $this->db->trans_begin();
            foreach($sheet as $index => $row){

                if($index > 1){
                    $id_mapel = $this->m_mapel->get_by(['nama' => trim($row['I']), 'id_instansi' => $this->akun->instansi]);
                    $data = array(
                        'nidn'  => $row['B'],
                        'nrp'  => $row['C'],
                        'nama' => $row['D'],
                        'username' => $row['E'],
                        'email'  => $row['F'],
                        'no_telpon'  => $row['G'],
                        'id_mapel' => !empty($id_mapel) ? $id_mapel->id : 0,
                        'instansi' => $this->akun->instansi
                    );

                    $this->db->insert('m_guru', $data);
                    $inserted_id = $this->db->insert_id();

                    $data_admin = [
                        'user_id'  => $row['E'],
                        'username' => $row['F'],
                        'password'  => $this->encryption->encrypt($row['H']),
                        'level'    => 'guru',
                        'kon_id'   => $inserted_id
                    ];

                    $this->db->insert('m_admin', $data_admin);
                }
            }

           

            // $this->db->insert_batch('m_guru', $data);
            // $this->db->insert_batch('m_admin', $data_admin);
        
            // $siswa = $this->m_guru->get_many_by(array('id > '=>$last_id));
        
            // $admin = array();

            // foreach ($siswa as $key => $rows) {
            //     $admin[$key] = array(
            //         'user_id'  => $rows->username,
            //         'username' => $rows->email,
            //         'password'  => $this->encryption->encrypt($row['H']),
            //         'level'    => 'guru',
            //         'kon_id'   => $rows->id,
            //         'status'   => 0,

            //     );
            // }

            //     $this->db->insert_batch('m_admin', $admin);

                if ($this->db->trans_status() === FALSE)
                {
                    $this->db->trans_rollback();
                }
                else
                {
                    $this->db->trans_commit();
                }
            
            //delete file from server
            unlink(realpath('./upload/temp/'.$data_upload['file_name']));

            //upload success
            $this->session->set_flashdata('notif', '<div class="alert alert-success"><b>PROSES IMPORT BERHASIL!</b> Data berhasil diimport!</div>');
            //redirect halaman
            redirect(base_url('trainer/import'));

        }

    }

    public function soal() {
        
        include APPPATH.'third_party/PHPExcel/PHPExcel.php';

        $config['upload_path'] = realpath('./upload/temp');
        $config['allowed_types'] = 'xlsx|xls|csv';
        $config['max_size'] = '10000';
        $config['encrypt_name'] = true;

        $p = $this->input->post();
        $uri3 = $this->uri->segment(3);

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {
            //upload gagal
            $this->session->set_flashdata('notif', '<div class="alert alert-danger"><b>PROSES IMPORT GAGAL!</b> '.$this->upload->display_errors().'</div>');
            //redirect halaman
            redirect(base_url('soal/m_soal/import/'.$uri3));
        } else {

            $data_upload = $this->upload->data();

            $excelreader     = new PHPExcel_Reader_Excel2007();
            $loadexcel         = $excelreader->load('./upload/temp/'.$data_upload['file_name']); // Load file yang telah diupload ke folder excel
            $sheet             = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);

            $data = array();

            $last_id = $this->db->order_by('id','desc')->limit(1)->get('m_soal')->row();

            if (!empty($last_id->id)) {
                $last_id = $last_id->id;
            }else{
                $last_id = 1;
            }

            foreach($sheet as $index => $row){

                if($index > 1){
                    $data[$index] = array(
                        'id_guru'   => $p['id_guru'],
                        'id_mapel'  => $p['id_mapel'],
                        'bobot'     => (int)$row['A'],
                        'soal'      => '<p>'.$row['B'].'</p>',
                        'opsi_a'    => '#####<p>'.$row['C'].'</p>',
                        'opsi_b'    => '#####<p>'.$row['D'].'</p>',
                        'opsi_c'    => '#####<p>'.$row['E'].'</p>',
                        'opsi_d'    => '#####<p>'.$row['F'].'</p>',
                        'opsi_e'    => '#####<p>'.$row['G'].'</p>',
                        'jawaban'   => $row['H'],
                        'tgl_input' => NOW(),
                        'jml_benar' => 0,
                        'jml_salah' => 0
                    );
                }
            }

            $this->db->insert_batch('m_soal', $data);

            //delete file from server
            unlink(realpath('./upload/temp/'.$data_upload['file_name']));

            //upload success
            $this->session->set_flashdata('notif', '<div class="alert alert-success"><b>PROSES IMPORT BERHASIL!</b> Data berhasil diimport!</div>');
            //redirect halaman
            redirect(base_url('soal/m_soal/import/'.$uri3));

        }

    }

    public function ujian($id_ujian) {

        $back_url = base_url('ujian_real/form_import/'.$id_ujian.'');
        
        include APPPATH.'third_party/PHPExcel/PHPExcel.php';

        $config['upload_path'] = realpath('./upload/temp');
        $config['allowed_types'] = 'xlsx|xls|csv';
        $config['max_size'] = '10000';
        $config['encrypt_name'] = true;

        $p = $this->input->post();
        $uri3 = $this->uri->segment(3);

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {
            //upload gagal
            $this->session->set_flashdata('notif', '<div class="alert alert-danger"><b>PROSES IMPORT GAGAL!</b> '.$this->upload->display_errors().'</div>');
            //redirect halaman
            redirect($back_url);
        } else {

            $data_upload = $this->upload->data();

            $excelreader     = new PHPExcel_Reader_Excel2007();
            $loadexcel         = $excelreader->load('./upload/temp/'.$data_upload['file_name']); // Load file yang telah diupload ke folder excel
            $sheet             = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);

            $data = array();

            $last_id = $this->db->order_by('id','desc')->limit(1)->get('m_soal')->row();

            if (!empty($last_id->id)) {
                $last_id = $last_id->id;
            }else{
                $last_id = 1;
            }

            foreach($sheet as $index => $row){

                if($index > 1){
                    $data[$index] = array(
                        'id_ujian'  => decrypt_url($id_ujian),
                        'bobot'     => (int)$row['A'],
                        'soal'      => '<p>'.$row['B'].'</p>',
                        'opsi_a'    => '#####<p>'.$row['C'].'</p>',
                        'opsi_b'    => '#####<p>'.$row['D'].'</p>',
                        'opsi_c'    => '#####<p>'.$row['E'].'</p>',
                        'opsi_d'    => '#####<p>'.$row['F'].'</p>',
                        'opsi_e'    => '#####<p>'.$row['G'].'</p>',
                        'jawaban'   => $row['H'],
                        'tgl_input' => NOW(),
                        'jml_benar' => 0,
                        'jml_salah' => 0
                    );
                }
            }
            // print_r(count($data));exit;

            $this->db->insert_batch('m_soal_ujian', $data);

            // Update jumlah soal di tb_ujian
            $data_ujian = $this->m_ujian->get_by(['uji.id' => decrypt_url($id_ujian)] );
            $jumlah_soal = count( $this->m_soal_ujian->get_many_by(['id_ujian' => decrypt_url($id_ujian)]) );
            
            $this->m_ujian->update([
                'jumlah_soal' => $data_ujian->jumlah_soal + count($data)
            ], ['id' => decrypt_url($id_ujian)]);

            //delete file from server
            unlink(realpath('./upload/temp/'.$data_upload['file_name']));

            //upload success
            $this->session->set_flashdata('notif', '<div class="alert alert-success"><b>PROSES IMPORT BERHASIL!</b> Data berhasil diimport!</div>');
            //redirect halaman
            redirect($back_url);

        }

    }
    
}




// $p = $this->input->post();

// $idx_baris_mulai = 3;
// $idx_baris_selesai = 106;

// $target_file = './upload/temp/';
// $buat_folder_temp = !is_dir($target_file) ? @mkdir("./upload/temp/") : false;

// move_uploaded_file($_FILES["import_excel"]["tmp_name"], $target_file.$_FILES['import_excel']['name']);

// $file   = explode('.',$_FILES['import_excel']['name']);
// $length = count($file);

// if($file[$length -1] == 'xlsx' || $file[$length -1] == 'xls') {

//     $tmp    = './upload/temp/'.$_FILES['import_excel']['name'];
//     //Baca dari tmp folder jadi file ga perlu jadi sampah di server :-p
    
//     $this->load->library('excel');//Load library excelnya
//     $read   = PHPExcel_IOFactory::createReaderForFile($tmp);
//     $read->setReadDataOnly(true);
//     $excel  = $read->load($tmp);

//     $_sheet = $excel->setActiveSheetIndexByName('data');
    
//     $data = array();
//     for ($j = $idx_baris_mulai; $j <= $idx_baris_selesai; $j++) {
//         $bobot = $_sheet->getCell("A".$j)->getCalculatedValue();
//         $soal = $_sheet->getCell("B".$j)->getCalculatedValue();
//         $opsi_a = $_sheet->getCell("C".$j)->getCalculatedValue();
//         $opsi_b = $_sheet->getCell("D".$j)->getCalculatedValue();
//         $opsi_c = $_sheet->getCell("E".$j)->getCalculatedValue();
//         $opsi_d = $_sheet->getCell("F".$j)->getCalculatedValue();
//         $opsi_e = $_sheet->getCell("G".$j)->getCalculatedValue();
//         $kunci = $_sheet->getCell("H".$j)->getCalculatedValue();

//         if ($soal != "") {
//             $data[] = "('".$p['id_guru']."', '".$p['id_mapel']."', '".$bobot."', '".$soal."', '#####".$opsi_a."', '#####".$opsi_b."', '#####".$opsi_c."', '#####".$opsi_d."', '#####".$opsi_e."', '".$kunci."', NOW(), 0, 0)"; 
//         }
//     }

//     $strq = "INSERT INTO m_soal (id_guru, id_mapel, bobot, soal, opsi_a, opsi_b, opsi_c, opsi_d, opsi_e, jawaban, tgl_input, jml_benar, jml_salah) VALUES ";
   
//     $strq .= implode(",", $data).";";
//     //echo $strq;
//     //exit;

//     $this->db->query($strq);
// } else {
//     exit('Bukan File Excel...');//pesan error tipe file tidak tepat
// }
// redirect('adm/m_soal');