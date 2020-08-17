<?php 
use PhpOffice\PhpSpreadsheet\Spreadsheet;
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

date_default_timezone_set("Asia/Jakarta");
class Import extends MY_Controller {
    protected $_reader = '';
    function __construct() {
        parent::__construct();
        $this->load->model('m_siswa');
        $this->load->model('m_guru');
        $this->load->model('m_ujian');
        $this->load->model('m_soal_ujian');
        $this->load->model('m_soal_ujian_essay');
        $this->load->model('m_jurusan');
        $this->load->model('m_mapel');
        $this->load->model('m_kelas');
        
        $this->db->query("SET time_zone='+7:00'");
    }
    
    public function cek_aktif() {
        if ($this->session->userdata('admin_valid') == false && $this->session->userdata('admin_id') == "") {
            redirect('adm/login');
        } 
    }

    public function createUsername($name) {
        $name = explode(' ', $name);

        $name = array_map(function($n){
            return strtolower($n);
        }, $name);

        $name = implode('', $name);
        return $name;
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

            $excelreader     = new PHPExcel_Reader_Excel5();
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


                if ($index != 1 && $row['B'] != '') {
                        // $id_kelas = $this->m_jurusan->get_by(['jurusan' => $row['E'], 'id_instansi' => $this->akun->instansi]);
                        // $id_guru = $this->m_guru->get_by(['nama' => $row['F'], 'instansi' => $this->akun->instansi]);
                        // $jk = ( == 'L' || $row['G'] == 'Laki-Laki') ? 1 : 0;
                        $username = empty($row['C']) ? $this->createUsername($row['B']) : $row['B'];
                        $email = $row['G'];
                        $alamat = empty($row['H']) ? '-' : $row['H'];
                        $data = array(
                            'nama'  => $row['B'],
                            // 'username'  => $username,
                            'username' => $row['C'],
                            'nrp' => $row['D'], // NIS
                            'id_jurusan' => 0,
                            'no_telpon' => $row['E'],
                            'nik' => $row['F'], // Jenis Kelamin
                            'email'  => $email,
                            'alamat'  => $alamat,
                            'instansi'  => $this->akun->instansi,
                            'pembuatan_akun' => time(),
                            'verifikasi' => md5(time())
                        );

                        $this->db->insert('m_siswa', $data);
                        $inserted_id = $this->db->insert_id();
                        $password = (!empty($row['I']) && $row['I'] != '') ? $this->encryption->encrypt($row['I']) : $this->encryption->encrypt($username);
                        $data_admin = [
                            // 'user_id'  => $username,
                            'user_id' => $row['C'],
                            'username' => $email,
                            'password'  => $password,
                            'level'    => 'siswa',
                            'kon_id'   => $inserted_id
                        ];

                        $this->db->insert('m_admin', $data_admin);

                        if(!empty($row['J'])) {
                            $get = $this->m_kelas->get_by(['kls.nama' => trim($row['J'])]);
                            if(!empty($get)) {
                                $data_detail_kelas = [
                                    'id_peserta' => $inserted_id,
                                    'id_kelas' => $get->id
                                ];    

                                $this->db->insert('tb_detail_kelas', $data_detail_kelas);
                            }
                            
                        }
                        

                    }
                }

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

            $excelreader     = new PHPExcel_Reader_Excel5();
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
                    // $id_mapel = $this->m_mapel->get_by(['nama' => trim($row['I']), 'id_instansi' => $this->akun->instansi]);
                    $data = array(
                        'nidn'  => $row['B'],
                        'nrp'  => $row['C'],
                        'nama' => $row['D'],
                        'username' => $row['E'],
                        'email'  => $row['F'],
                        'no_telpon'  => $row['G'],
                        // 'id_mapel' => !empty($id_mapel) ? $id_mapel->id : 0,
                        'instansi' => $this->akun->instansi
                    );

                    $this->db->insert('m_guru', $data);
                    $inserted_id = $this->db->insert_id();

                    $data_admin = [
                        'user_id'  => $row['E'],
                        'username' => $row['F'],
                        'password'  => $this->encryption->encrypt($row['E']),
                        'level'    => 'guru',
                        'kon_id'   => $inserted_id,
                        'login_at' => date('Y-m-d H:i:s')
                    ];

                    $this->db->insert('m_admin', $data_admin);

                    // Insert Data
                    if(!is_null($row['I'])) {

                        // Jika Mapel > 1
                        if(strpos(trim($row['I']), ',')) {
                            $mapel = explode(',', $row['I']);
                            for($x = 0;$x < count($mapel);$x++) {
                                $id_mapel = $this->m_mapel->get_by(['nama' => trim($mapel[$x])]);
                                $id_mapel = empty($id_mapel) ? 0 : $id_mapel->id;
                                $data_detail_mapel = [
                                    'id_mapel' => $id_mapel,
                                    'id_guru' => $inserted_id
                                ];

                                $this->db->insert('tb_detail_mapel', $data_detail_mapel);
                            }
                        }
                        else {
                            $id_mapel = $this->m_mapel->get_by(['nama' => trim($row['I'])]);
                            $id_mapel = empty($id_mapel) ? 0 : $id_mapel->id;
                            $data_detail_mapel = [
                                'id_mapel' => $id_mapel,
                                'id_guru' => $inserted_id
                            ];

                            $this->db->insert('tb_detail_mapel', $data_detail_mapel);
                        } 
                            
                    }
                        
                }
            }

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

            $excelreader     = new PHPExcel_Reader_Excel5();
            $loadexcel         = $excelreader->load('./upload/temp/'.$data_upload['file_name']); // Load file yang telah diupload ke folder excel
            $sheet             = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);

            $data = array();

            $last_id = $this->db->order_by('id','desc')->limit(1)->get('m_soal')->row();

            if (!empty($last_id->id)) {
                $last_id = $last_id->id;
            }else{
                $last_id = 1;
            }
            $x = 1;
            foreach($sheet as $index => $row){

                if($index > 1){
                    $data[$index] = array(
                        'id_guru'   => $p['id_guru'],
                        'id_mapel'  => $p['id_mapel'],
                        // 'bobot'     => (int)$row['A'],
                        'bobot'     => 1,
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

                    // Update Jumlah Soal
                    $data_ujian = $this->m_ujian->get_by(['uji.id' => $p['id_ujian']]);
                    $this->m_ujian->update(['jumlah_soal' => $data_ujian->jumlah_soal + $x], [
                        'id' => $p['id_ujian']
                    ]);
                    $x++;
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

    public function ujian($id_ujian) 
    {
        $back_url = base_url('ujian_real/form_import/'.$id_ujian.'');

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
            $extension = pathinfo($data_upload['file_name'], PATHINFO_EXTENSION);

            switch($extension) {
                case 'csv':
                    $this->_reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                break;
                case 'xlsx':
                    $this->_reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                break;
                default :
                    $this->_reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                break;
            }
            $loadexcel         = $this->_reader->load('./upload/temp/'.$data_upload['file_name']); // Load file yang telah diupload ke folder excel
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
                        'tgl_input' => date('Y-m-d h:i:s'),
                        'jml_benar' => 0,
                        'jml_salah' => 0
                    );
                }
            }

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

    public function soal_ujian_essay() {
        $post = $this->input->post();
        $id_ujian = $post['id_ujian'];
        $back_url = base_url('ujian_essay/data_soal/') . $id_ujian;

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
            $extension = pathinfo($data_upload['file_name'], PATHINFO_EXTENSION);

            switch($extension) {
                case 'csv':
                    $this->_reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                break;
                case 'xlsx':
                    $this->_reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                break;
                default :
                    $this->_reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                break;
            }

            $loadexcel         = $this->_reader->load('./upload/temp/'.$data_upload['file_name']); // Load file yang telah diupload ke folder excel
            $sheet             = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);

            $data = array();

            $last_id = $this->db->order_by('id','desc')->limit(1)->get('m_soal_ujian_essay')->row();

            if (!empty($last_id->id)) {
                $last_id = $last_id->id;
            }else{
                $last_id = 1;
            }

            foreach($sheet as $index => $row){

                if($index > 1){
                    $data[$index] = array(
                        'id_ujian'  => decrypt_url($post['id_ujian']),
                        'bobot'     => (int)$row['C'],
                        'soal'      => '<p>'.$row['B'].'</p>'
                    );
                }
            }

            $this->db->insert_batch('m_soal_ujian_essay', $data);

            // Update jumlah soal di tb_ujian
            $data_ujian = $this->m_ujian->get_by(['uji.id' => decrypt_url($id_ujian)] );
            $jumlah_soal = count( $this->m_soal_ujian_essay->get_many_by(['id_ujian' => decrypt_url($id_ujian)]) );
            
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