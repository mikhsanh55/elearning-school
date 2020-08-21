<?php
defined('BASEPATH') or die('No direct access script allowed!');

class Materi extends MY_Controller
{
    protected $root_path = FCPATH;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_materi');
        $this->load->model('m_komen_materi');
        $this->load->model('m_notif_forum');
        $this->load->model('m_jadwal');
        $this->load->model('m_materi');
        $this->load->model('m_guru');
        $this->load->model('m_kelas');
        $this->load->model('m_instansi');
        $this->load->model('m_detail_kelas');
        $this->load->model('m_detail_kelas_mapel');
        // $this->load->model('m_detail_materi');
        

        if ($this->session->userdata('admin_level') == null) {
            redirect('login');
        }

        $this->root_path = FCPATH;
        $this->root_path = str_replace('\\', '/', $this->root_path);
    }
    public function index()
    {
        redirect(base_url('adm'));
    }

    public function get_()
    {
        $this->db->where('MD5(id)', $this->input->get('md5'));
        $data = $this->db->get('m_mapel')->row();

        echo json_encode(['status' => true, 'data' => $data]);
    }
    public function check_sub_modul($id)
    {
        $this->db->where('id_mapel', $id);
        $res              = $this->db->get('m_materi');
        $data['sum_data'] = $res->num_rows();
        $data['data']     = $res->result();
        echo json_encode($data);
    }
    public function get_mapel($ajax = false, $id = false)
    {
        if ($ajax == false) {
            $this->db->select('*')
                ->from('m_mapel')
                ->order_by('nama', 'ASC');
            return $this->db->get()->result();
        } else {
            if ($id != false) {
                $this->db->where('id !=', $id);
                $res          = $this->db->get('m_mapel')->result();
                $data['data'] = $res;
                echo json_encode($data);
            }

        }
    }

    /* View Logic */
    private function get_list_materi_by_mapel($md5_id, $single = false)
    {
        if ($single == false) {
            $this->db->select('materi.*, mapel.nama as mapel')
                ->from('m_materi materi')
                ->join('m_mapel mapel', 'materi.id_mapel = mapel.id', 'inner')
                ->where('MD5(materi.id_mapel)', $md5_id);
            return $this->db->get()->result();
        } else {
            $this->db->select('materi.*, mapel.nama as mapel')
                ->from('m_materi materi')
                ->join('m_mapel mapel', 'materi.id_mapel = mapel.id', 'inner')
                ->where('MD5(materi.id)', $md5_id);
            return $this->db->get()->row();
        }
    }

    // Get semua modul yang belum diverifikasi
    public function get_list_not_verify()
    {
        $uri1 = $this->uri->segment(1);

        $uri2 = $this->uri->segment(2);

        $this->db->select('materi.*, mapel.nama as mapel')
            ->from('m_materi materi')
            ->join('m_mapel mapel', 'materi.id_mapel = mapel.id', 'inner')
            ->where('materi.is_verify', 0)
            ->where('req_add', 1);
        $add                             = $this->db->get();
        $data['data']['sum_request_add'] = $add->num_rows();
        $data['data']['request_add']     = $add->result();

        $this->db->select('materi.*, mapel.nama as mapel')
            ->from('m_materi materi')
            ->join('m_mapel mapel', 'materi.id_mapel = mapel.id', 'inner')
            ->where('materi.is_verify', 0)
            ->where('req_edit', 1);
        $edit                             = $this->db->get();
        $data['data']['sum_request_edit'] = $edit->num_rows();
        $data['data']['request_edit']     = $edit->result();

        $this->db->select('materi.*, mapel.nama as mapel')
            ->from('m_materi materi')
            ->join('m_mapel mapel', 'materi.id_mapel = mapel.id', 'inner')
            ->where('materi.is_verify', 0)
            ->where('req_delete', 1);
        $delete                             = $this->db->get();
        $data['data']['sum_request_delete'] = $delete->num_rows();
        $data['data']['request_delete']     = $delete->result();

        $a['sess_level'] = $this->session->userdata('admin_level');
        $a['menu']       = $this->db->query("SELECT `nama_menu`, `link`, `icon` FROM rule_users JOIN menu ON rule_users.id_menu = menu.id JOIN level ON rule_users.id_level = level.id WHERE level = '" . $a['sess_level'] . "' ")->result_array();

        $a['link'] = $this->db->query("SELECT link FROM rule_users JOIN menu ON rule_users.id_menu = menu.id JOIN level ON rule_users.id_level = level.id WHERE link = '" . $uri1 . "/" . $uri2 . "' AND level = '" . $a['sess_level'] . "' ")->result_array();

        $this->load->view('dashboard/template/header');
        $this->load->view('dashboard/template/navbar', $a);
        $this->load->view('materi/materi_not_verify', $data);
        $this->load->view('dashboard/template/footer');

    }

    public function lists($id_mapel = NULL,$id_guru=NULL,$id_kelas=NULL)
    {

        $data = [
            'title' => 'Daftar Materi',
            'mapel' => $this->m_mapel->get_by(['md5(id)' => $id_mapel]),
            'id_guru' => $id_guru,
            'id_kelas' => $id_kelas
        ];
        // print_r($data);exit;
        // print_r($this->m_mapel->get_by(['md5(id)' => $id_mapel]));exit;

        $this->render('materi/list', $data);
      

    }

    public function page_load($pg = 1){
		$post = $this->input->post();
		$limit = 10;
		$where = [];

        if ($this->log_lvl == 'guru') {
            $where['mt.id_trainer'] = $this->akun->id;
        }

        if ($this->log_lvl == 'siswa') {
            $where['mt.id_trainer'] = decrypt_url($post['id_guru']);
            $where['jdwl.id_kelas'] = decrypt_url($post['id_kelas']);
        }
        

       
        if($this->log_lvl != 'admin'){
			$where['gur.instansi'] = $this->akun->instansi;
        }
        
        $where['mt.id_mapel'] = $post['id_mapel'];
        
        $paginate         = $this->m_materi->paginate_materi($pg,$where,$limit);

        // Cek keaktifan akses materi oleh siswa
        foreach($paginate['data'] as $key => $row) :
            $now = date('Y-m-d H:i:s');
            if($now >= $row->start_date && $now <= $row->end_date) {
                $row->in_jadwal = TRUE;
            }
            else {
                $row->in_jadwal = FALSE;
            }
        endforeach;
      
        $data['paginate'] = $paginate;
		$data['paginate']['url']	= 'materi/page_load';
		$data['paginate']['search'] = 'lookup_key';
		$data['page_start'] = $paginate['counts']['from_num'];
        $data['id_kelas'] = decrypt_url($post['id_kelas']);

        $this->load->view('materi/list_materi',$data);
		$this->generate_page($data);
		
	}

    // Function for get instasi
    private function getInstansi() {
        $id_instansi = $this->m_siswa->get_by(['id' => $this->session->userdata('admin_konid')])->instansi;
        return $this->m_instansi->get_by(['id' => $id_instansi]);
    }

    public function materi_kelas($id_kelas = null)
    {

        $data = [
            'title' => 'Daftar Materi - Elearning UMKM',
            'kelas' => $this->m_kelas->get_by(['kls.id'=>decrypt_url($id_kelas)]),
        ];
        
        $this->render('materi/kelas', $data);
    }

    public function page_load_kelas($pg = 1){
		$post = $this->input->post();
		$limit = 10;
		$where = [];

        $where['id_trainer'] = $post['id_trainer'];
        $where['id_mapel']   = $post['id_mapel'];

        $where['start_date <= '] = date('Y-m-d H:i');
        $where['end_date >= '] = date('Y-m-d H:i');

        $paginate    = $this->m_materi->paginate_kelas($pg,$where,$limit);
        $data['paginate'] = $paginate;
		$data['paginate']['url']	= 'materi/page_load_kelas';
		$data['paginate']['search'] = 'lookup_key';
		$data['page_start'] = $paginate['counts']['from_num'];
        $data['lembaga'] = $this->getInstansi();

        $this->load->view('materi/list_kelas',$data);
		$this->generate_page($data);
		
	}

    // slider section
    public function read()
    {

        $md5_id = $this->uri->segment(3) or die('You do not have access yet.');
        $data   = [
            'materi' => $this->get_list_materi_by_mapel($md5_id, true),
        ];
        $this->load->view('dashboard/template/header');
        $this->load->view('materi/read_default', $data);
        $this->load->view('materi/read_script', $data);
        $this->load->view('dashboard/template/footer');
    }
    public function add()
    {
        if($this->log_lvl == 'siswa') {
            redirect('dtest/data_mapel');
        }
        $data = [
            'title' => 'Buat materi yang menarik untuk para UMKM',
            'mapel' => $this->get_mapel(),
            'disabled' => FALSE,
            'placeholder' => 'Isi judul materi'
        ];

        // JIka user bukan instansi, set var untuk men-disable input judul materi
        // if($this->log_lvl != 'instansi') {
        //     $data['placeholder'] = 'Diisi oleh Lembaga';
        //     $data['disabled'] = TRUE;
        // }

        $this->render('materi/add', $data);

    }

    public function edit()
    {
        $this->load->model('m_materi_attach');
        $md5_id = $this->uri->segment(3) or die('You donot have access yet.');
        $materi = $this->get_list_materi_by_mapel($md5_id, true);
        $type = '';
        switch($materi->id_type_video) {
            case 2:
                $type = 'video-gdrive';
            break;
            case 3:
                $type = 'video-youtube';
            break;
        }

        $uploadedFiles = $this->m_materi_attach->get_many_by(['id_materi' => $materi->id, 'type_file' => $type]);
        $data   = [
            'mapel'  => $this->get_mapel(),
            'materi' => $materi,
            'uploadedFiles' => $uploadedFiles
        ];
        // print_r($uploadedFiles);exit;

        $this->load->view('dashboard/template/header');
        $this->load->view('materi/edit', $data);
        $this->load->view('dashboard/template/footer');
    }

    public function edit_pdf()
    {
        $md5_id = $this->uri->segment(3) or die('You donot have access yet.');
        $data   = [
            'mapel'  => $this->get_mapel(),
            'materi' => $this->get_list_materi_by_mapel($md5_id, true),
        ];
        $this->load->view('dashboard/template/header');
        $this->load->view('materi/edit_pdf', $data);
        $this->load->view('dashboard/template/footer');
    }

    
    public function edit_ppt()
    {
        $md5_id = $this->uri->segment(3) or die('You donot have access yet.');
        $data   = [
            'mapel'  => $this->get_mapel(),
            'materi' => $this->get_list_materi_by_mapel($md5_id, true),
        ];
        $this->load->view('dashboard/template/header');
        $this->load->view('materi/edit_ppt', $data);
        $this->load->view('dashboard/template/footer');
    }


    // Logic section
    public function update()
    {
        $this->load->model('m_materi_attach');
        $post = $this->input->post();

        $data = [
            'id_mapel'   => $post['mapel'],
            'id_trainer' => $this->akun->id,
            'title'      => $post['title'],
            'content'    => $post['content'],
            'req_edit'    => 1,
            'is_verify'  => 1
        ];
        $idTypeVideo = '';
        if(isset($post['video']) && count($post['video']) > 0) {
            switch($post['type-video']) {
                case 'video-gdrive': 
                $idTypeVideo = 2;
                break;
                case 'video-youtube': 
                $idTypeVideo = 3;
                break;
            }

            $data['id_type_video'] = $idTypeVideo;
        }

        $this->db->trans_start();

        $this->m_materi->update($data, ['id' => $post['imateri']]);

        if(isset($post['video']) && count($post['video']) > 0) {
            $this->m_materi_attach->delete([
                'id_materi' => $post['imateri'], 
                'type_file' => $post['type-video']
            ]);
            $x = 1;
            $chunk = '';$modifiedUrl = '';
            for($i = 0;$i < count($post['video']);$i++ ) {
            
                switch($post['type-video']) {
                    case 'video-youtube' :
                        $chunk = explode('?v=', $post['video'][$i]);
                        $modifiedUrl = 'https://www.youtube.com/embed/' . end($chunk);
                    break;
                    case 'video-gdrive' :
                        $chunk = explode('/', $post['video'][$i]);
                        array_pop($chunk);
                        $chunk = implode('/', $chunk);
                        $modifiedUrl = $chunk . '/preview';
                    break;
                }

                $dataMateri[] = [
                    'id_materi' => $post['imateri'],
                    'file_name' => 'Video ' . $x,
                    'type_file' => $post['type-video'],
                    'path' => $post['video'][$i],
                    'view_path' => $modifiedUrl
                ];
                $x++;
            }
            
            $this->db->insert_batch('tb_materi_attach', $dataMateri);
        }
            
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE) {
            $this->sendAjaxResponse([
                'status' => FALSE,
                'msg' => 'Materi gagal ditambahkan'
            ], 500);
            exit;
        }
        else {
            $this->sendAjaxResponse([
                'status' => TRUE,
                'msg' => 'Materi berhasil ditambahkan'
            ], 200);
        }
    }

    public function update_pdf()
    {
        $this->load->model('m_materi_attach');
        $post = $this->input->post();

        if (isset($_FILES['file']['name'])) {
            $lengthFile = count($_FILES['file']['name']);

            for($i = 0;$i < $lengthFile;$i++) {
                $_FILES['f']['name'] = $_FILES['file']['name'][$i];
                $_FILES['f']['type'] = $_FILES['file']['type'][$i];
                $_FILES['f']['tmp_name'] = $_FILES['file']['tmp_name'][$i];
                $_FILES['f']['error'] = $_FILES['file']['error'][$i];
                $_FILES['f']['size'] = $_FILES['file']['size'][$i];

                $file     = stripcslashes($_FILES['f']['name'][$i]);
                $namafile = DATE('d-m-Y') . "-" . time() . "-" . Str_replace(" ", "_", $file);

                $config['upload_path']   = 'assets/materi/pdf/';
                $config['allowed_types'] = 'pdf|pdfx|doc|docx';
                $config['max_size']      = 10240; // 10 MB
                $config['file_name']     = $namafile;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('f')) {
                    $this->sendAjaxResponse([
                        'status' => false,
                        'msg'    => 'Upload file gagal! .'.$this->upload->display_errors()
                    ], 500);
                    exit;

                } else {
                    $this->db->trans_start();
                    $upload_data = $this->upload->data();
                    $file_name = 'assets/materi/pdf/' . $upload_data['file_name'];

                    $this->m_materi_attach->insert([
                        'id_materi' => $post['imateri'],
                        'file_name' => $upload_data['file_name'],
                        'type_file' => 'pdf',
                        'path' => $file_name
                    ]); 
                        
                    $this->db->trans_complete();

                    if($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                        $this->sendAjaxResponse([
                            'status' => FALSE,
                            'msg' => 'Cannot insert data file'
                        ], 500);
                        exit;
                    }
                    else {
                        $this->db->trans_commit();
                    }
                }
            }

            // Update point keaktifan Guru
            if($this->log_lvl === 'guru') {
                $dataGuru = $this->m_guru->get_by(['id' => $this->session->userdata('admin_konid')]);
                $this->m_guru->update([
                    'sum_upload_materi' => $dataGuru->sum_upload_materi + 1
                ], ['id' => $this->session->userdata('admin_konid')]);
            }

            // Get Uploaded File
            $uploaded_files = $this->m_materi_attach->get_many_by(['id_materi' => $post['imateri']]);
                
            $this->sendAjaxResponse([
                'status' => TRUE,
                'data' => $uploaded_files,
                'msg' => 'File PDF berhasil ditambahkan'
            ], 200);

        } else {

           $this->sendAjaxResponse([
                'status' => FALSE,
                'msg' => 'Harap pilih minimal 1 file PDF'
           ], 500);
        }

    }
    
    public function update_ppt()
    {
        $this->load->model('m_materi_attach');
        $post = $this->input->post();

        if (isset($_FILES['file']['name'])) {
            $lengthFile = count($_FILES['file']['name']);
            for($i = 0;$i < $lengthFile;$i++) {
                $_FILES['f']['name'] = $_FILES['file']['name'][$i];
                $_FILES['f']['type'] = $_FILES['file']['type'][$i];
                $_FILES['f']['tmp_name'] = $_FILES['file']['tmp_name'][$i];
                $_FILES['f']['error'] = $_FILES['file']['error'][$i];
                $_FILES['f']['size'] = $_FILES['file']['size'][$i];

                $file     = stripcslashes($_FILES['f']['name']);
                $namafile = DATE('d-m-Y') . "-" . time() . "-" . Str_replace(" ", "_", $file);

                $config['upload_path']   = 'assets/materi/ppt/';
                $config['allowed_types'] = 'ppt|pptx';
                $config['max_size']      = 20240; // 20 MB
                $config['file_name']     = $namafile;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('f')) {
                    $this->sendAjaxResponse([
                        'status' => false,
                        'msg'    => 'Upload file gagal! .'.$this->upload->display_errors()
                    ], 500);
                    exit;

                } else {
                    $this->db->trans_start();
                    $upload_data = $this->upload->data();
                    $file_name = 'assets/materi/pdf/' . $upload_data['file_name'];

                    $this->m_materi_attach->insert([
                        'id_materi' => $post['imateri'],
                        'file_name' => $upload_data['file_name'],
                        'type_file' => 'ppt',
                        'path' => $file_name
                    ]); 
                        
                    $this->db->trans_complete();

                    if($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                        $this->sendAjaxResponse([
                            'status' => FALSE,
                            'msg' => 'Cannot insert data file'
                        ], 500);
                        exit;
                    }
                    else {
                        $this->db->trans_commit();
                    }
                }
            }

            // Update point keaktifan guru
            if($this->log_lvl === 'guru') {
                $dataGuru = $this->m_guru->get_by(['id' => $this->session->userdata('admin_konid')]);
                $this->m_guru->update([
                    'sum_upload_materi' => $dataGuru->sum_upload_materi + 1
                ], ['id' => $this->session->userdata('admin_konid')]);
            }

            // Get Uploaded File
            $uploaded_files = $this->m_materi_attach->get_many_by(['id_materi' => $post['imateri']]);
                
            $this->sendAjaxResponse([
                'status' => TRUE,
                'data' => $uploaded_files,
                'msg' => 'File PPT berhasil ditambahkan'
            ], 200);
                
        } else {
            $this->sendAjaxResponse([
                'status' => FALSE,
                'msg' => 'Harap pilih minimal 1 file PPT'
           ], 500);
        }

    }

    public function delete()
    {
        $this->load->model('m_materi_attach');
        $post = $this->input->post();
        $id = decrypt_url($post['imateri']);

        $uploadedFiles = $this->m_materi_attach->get_many_by(['id_materi' => $id]);
        if(count($uploadedFiles) > 0) {
            foreach($uploadedFiles as $file) :
                if(file_exists($file->path)) {
                    unlink($file->path);
                }
            endforeach;
        }
        $this->db->trans_start();
        $deleteFiles = $this->m_materi_attach->delete(['id_materi' => $id]);
        $delete = $this->m_materi->delete(['id' => $id]);
        $this->db->trans_complete();
        if($deleteFiles && $delete && $this->db->trans_status() === TRUE) {
            $this->sendAjaxResponse([
                'status' => TRUE,
                'msg' => 'Materi berhasil dihapus'
            ], 200);
        } 
        else {
            $this->sendAjaxResponse([
                'status' => FALSE,
                'msg' => 'Materi gagal dihapus'
            ], 500);
            exit;
        }
    }

    public function delete_using_php($id, $pdf = 0, $url_feed = null)
    {
        $id = $id;
        if ($pdf == 0) {
            $this->db->where('MD5(id)', $id);
            $data = $this->db->get('m_materi')->row();
            if (file_exists($data->path_video)) {
                if (unlink($data->path_video)) {
                    $this->db->where('MD5(id)', $id);
                    $delete = $this->db->delete('m_materi');
                    if ($delete) {
                        if ($url_feed != null) {
                            echo json_encode(['status' => true, 'src' => $url_feed]);
                        } else {
                            echo json_encode(['status' => true]);
                        }

                    } else {
                        echo json_encode(['status' => false]);
                        http_response_code(500);
                    }
                } else {
                    echo json_encode(['status' => false]);
                    http_response_code(500);
                }
            } else {
                $this->db->where('MD5(id)', $id);
                $delete = $this->db->delete('m_materi');
                if ($delete) {
                    if ($url_feed != null) {
                        echo json_encode(['status' => true, 'src' => $url_feed]);
                    } else {
                        echo json_encode(['status' => true]);
                    }
                } else {
                    echo json_encode(['status' => false]);
                    http_response_code(500);
                }
            }

        } else {

            // if($delete) {

            $data = $this->get_list_materi_by_mapel($id, true);
            $path = $data->content;
            if (file_exists($path)) {
                if (unlink($path)) {
                    if (file_exists($data->path_video)) {
                        if (unlink($data->path_video)) {
                            $this->db->where('MD5(id)', $id);
                            $delete = $this->db->delete('m_materi');
                            if ($delete) {
                                if ($url_feed != null) {
                                    echo json_encode(['status' => true, 'src' => $url_feed]);
                                } else {
                                    echo json_encode(['status' => true]);
                                }
                            } else {
                                die("Something wrong");
                            }
                        } else {
                            echo json_encode(['status' => false]);
                            http_response_code(500);
                        }
                    } else {
                        $this->db->where('MD5(id)', $id);
                        $delete = $this->db->delete('m_materi');
                        if ($delete) {
                            if ($url_feed != null) {
                                echo json_encode(['status' => true, 'src' => $url_feed]);
                            } else {
                                echo json_encode(['status' => true]);
                            }
                        } else {
                            die("Something wrong");
                        }
                    }

                } else {
                    echo json_encode(['status' => false]);
                    http_response_code(500);
                }
            } else {
                if (file_exists($data->path_video)) {
                    if (unlink($data->path_video)) {
                        $this->db->where('MD5(id)', $id);
                        $delete = $this->db->delete('m_materi');
                        if ($delete) {
                            if ($url_feed != null) {
                                echo json_encode(['status' => true, 'src' => $url_feed]);
                            } else {
                                echo json_encode(['status' => true]);
                            }
                        } else {
                            die("Something wrong");
                        }
                    } else {
                        echo json_encode(['status' => false]);
                        http_response_code(500);
                    }
                } else {
                    $this->db->where('MD5(id)', $id);
                    $delete = $this->db->delete('m_materi');
                    if ($delete) {
                        if ($url_feed != null) {
                            echo json_encode(['status' => true, 'src' => $url_feed]);
                        } else {
                            echo json_encode(['status' => true]);
                        }
                    } else {
                        die("Something wrong");
                    }
                }
            }
        }

    }

    public function insert($md5_id_mapel = NULL)
    {

        $this->load->model('m_materi_attach');
        $post = $this->input->post();

        if(isset($post['video']) && count($post['video']) > 0) {
            switch($post['type-video']) {
                case 'video-gdrive': 
                $idTypeVideo = 2;
                break;
                case 'video-youtube': 
                $idTypeVideo = 3;
                break;
            }

            $data = [
                'id_mapel'   => $this->input->post('mapel'),
                'id_trainer' => $this->akun->id,
                'id_type_video' => $idTypeVideo,
                'title'      => $this->input->post('title'),
                'content'    => $this->input->post('content'),
                'req_add'    => 1,
                'is_verify'  => 1
            ];
            
            $this->db->trans_start();
            $this->m_materi->insert($data);
            $id_materi = $this->db->insert_id();

            $dataMateri = [];$x = 1;
            $modifiedUrl = '';
            for($i = 0;$i < count($post['video']);$i++ ) {
                
                switch($post['type-video']) {
                    case 'video-youtube' :
                        $chunk = explode('?v=', $post['video'][$i]);
                        $modifiedUrl = 'https://www.youtube.com/embed/' . end($chunk);
                    break;
                    case 'video-gdrive' :
                        $chunk = explode('/', $post['video'][$i]);
                        array_pop($chunk);
                        $chunk = implode('/', $chunk);
                        $modifiedUrl = $chunk . '/preview';
                    break;
                }

                $dataMateri[] = [
                    'id_materi' => $id_materi,
                    'file_name' => 'Video ' . $x,
                    'type_file' => $post['type-video'],
                    'path' => $post['video'][$i],
                    'view_path' => $modifiedUrl
                ];
            }

            $this->db->insert_batch('tb_materi_attach', $dataMateri);
            $this->db->trans_complete();

            if($this->db->trans_status() === FALSE) {
                $this->sendAjaxResponse([
                    'status' => FALSE,
                    'msg' => 'Materi gagal ditambahkan'
                ], 500);
                exit;
            }
            else {
                $this->sendAjaxResponse([
                    'status' => TRUE,
                    'msg' => 'Materi berhasil ditambahkan'
                ], 200);
            }
        }
        else {
             $data = [
                'id_mapel'   => $this->input->post('mapel'),
                'id_trainer' => $this->akun->id,
                'title'      => $this->input->post('title'),
                'content'    => $this->input->post('content'),
                'req_add'    => 1,
                'is_verify'  => 1
            ];
            $this->db->trans_start();
            $insert = $this->m_materi->insert($data);
            $this->db->trans_complete();

            if($this->db->trans_status() === FALSE && !$insert) {
                $this->sendAjaxResponse([
                    'status' => FALSE,
                    'msg' => 'Materi gagal ditambahkan'
                ], 500);
                exit;
            }
            else {
                $this->sendAjaxResponse([
                    'status' => TRUE,
                    'msg' => 'Materi berhasil ditambahkan tidak ada video'
                ], 200);
            }
        }

    }

    public function verify()
    {
        $md5_id = $this->input->post('imateri') or die('You do not have access yet!');

        $this->db->where('MD5(id)', $md5_id);
        $update = $this->db->update('m_materi', ['is_verify' => 1, 'req_add' => 0, 'req_edit' => 0, 'req_delete' => 0]);

        if ($update) {
            echo json_encode(['status' => true, 'msg' => 'Materi berhasil diupdate']);
        }
    }

    // Logic Mapel
    public function insert_mapel()
    {
        $nama = $this->input->post('nama') or die('You do not have access yet.');

        $this->db->insert('m_mapel', ['nama' => $nama]);
        echo 'Berhasil';
    }

    public function delete_mapel()
    {
        $md5_id = $this->input->post('ikategori') or die('You do not have access yet.');

        $this->db->where('MD5(id)', $md5_id);
        $this->db->delete('m_mapel');

        echo 'Berhasil';
    }

    // Ajax upload function
    public function upload_materi()
    {
        if (!$this->input->post()) {
            $data = [
                'status' => false,
                'msg'    => 'Parameter not found!',
            ];

            echo json_encode($data);
            http_response_code(400);
        } else {
            if (isset($_FILES['file']['name'])) {
                $judul       = $this->input->post('title');
                $file        = $_FILES['file'];
                $filename    = explode('.', $_FILES['file']['name']);
                $filename    = $filename[0];
                $newfile     = $filename . '_' . uniqid() . '.pdf';
                $target_path = base_url('assets/materi/pdf/');

                $data = [
                    'title'     => $judul,
                    'content'   => $_SERVER['DOCUMENT_ROOT'] . '/assets/materi/pdf/' . $newfile,
                    'id_mapel'  => $this->input->post('id_mapel'),
                    'is_verify' => 0,
                    'pdf'       => 1,
                    'req_add'   => 1,
                ];
                $insert = $this->db->insert('m_materi', $data);
                if ($insert) {
                    if (move_uploaded_file($_FILES['file']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/assets/materi/pdf/' . $newfile)) {
                        $d = [
                            'status' => true,
                            'msg'    => 'Materi berhasil diupload!',
                        ];
                        echo json_encode($d);
                        http_response_code(200);
                    } else {
                        $d = [
                            'status' => false,
                            'msg'    => 'Upload file gagal!',
                        ];
                        echo json_encode($d);
                        http_response_code(500);
                    }
                } else {
                    $d = [
                        'status' => false,
                        'msg'    => 'Internal Server Error!',
                    ];
                    echo json_encode($d);
                    http_response_code(500);
                }
            }
        }
    }

    public function read_pdf($md5_id)
    {
        $md5_id = $this->uri->segment(3) or die('You do not have access yet.');
        $data   = [
            'materi' => $this->get_list_materi_by_mapel($md5_id, true),
        ];

        $file   = base_url('assets/materi/pdf/') . '/' . $data['materi']->file_pdf;
        $lokasi = 'assets/materi/pdf/' . $data['materi']->file_pdf;
        if (!file_exists($lokasi)) {
            echo "<h1 align='center' style='color:red;'>File tidak ada atau Rusak</h1>";
            exit;
        }

        if ($this->session->userdata('admin_level') == 'siswa') {
            $det_user = $this->db->where("id", $this->session->userdata('admin_konid'))->get("m_siswa")->row();
            $data     = array(
                'active_read' => $det_user->active_read + 1,
            );

            $this->db->update('m_siswa', $data, array('id' => $det_user->id));
        }

        // $expl = explode('/pengusa6/', $data['materi']->content);
        $pdffile = file_get_contents($file);
        header('Content-Type:application/pdf');
        header('Content-Disposition:inline; filename=' . $pdffile . '');
        // echo $pdffile;
        @readfile($file);
    }

    public function read_ppt($md5_id)
    {
        
        $md5_id = $this->uri->segment(3) or die('You do not have access yet.');
        $materi = $this->m_materi->get_by(['md5(id)'=>$md5_id]);
     

        $back_dir    ='assets/materi/ppt/';
        $file = $back_dir.$materi->file_ppt;
            if (file_exists($file)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename='.basename($file));
                header('Content-Transfer-Encoding: binary');
                header('Expires: 0');
                header('Cache-Control: private');
                header('Pragma: private');
                header('Content-Length: ' . filesize($file));
                ob_clean();
                flush();
                readfile($file);
                
                exit;
            } 
            else {
                echo "Oops! File - not found ...";exit;
            }
    }

    public function active_nonton()
    {
      
        if ($this->session->userdata('admin_level') == 'siswa') {
            $det_user = $this->db->where("id", $this->session->userdata('admin_konid'))->get("m_siswa")->row();
            $data     = array(
                'active_video' => $det_user->active_video + 1,
            );

            $this->db->update('m_siswa', $data, array('id' => $det_user->id));
        }
    }

    // SILABUS
    public function check_silabus_exist()
    {
        if (!$this->input->get()) {
            $data = [
                'status' => false,
                'msg'    => 'Parameter not found!',
            ];

            echo json_encode($data);
            http_response_code(400);
        } else {
            $this->db->where('MD5(id)', $this->input->get('md5'));
            $res = $this->db->get('m_mapel')->row();
            if ($res->silabus > 0) {
                $data = [
                    'status' => true,
                    'msg'    => 'Data found!',
                    'data'   => $res,
                ];

                echo json_encode($data);
                http_response_code(200);
            } else {
                $data = [
                    'status' => false,
                    'msg'    => 'Data not found!',
                ];

                echo json_encode($data);
                http_response_code(200);
            }
        }
    }
    public function silabus()
    {
        $md5_id = $this->uri->segment(3) or die('You do not have access yet.');
        $this->db->where('MD5(id)', $md5_id);
        $res  = $this->db->get('m_mapel')->row();
        $data = [
            'silabus' => $res,
        ];
        trim($data['silabus']->path_silabus);
        // print_r($data);
        $pdffile = file_get_contents($data['silabus']->path_silabus);
        // header('Content-Type:application/pdf');
        // header('Content-Disposition:attachment; filename=' . $pdffile .'');
        // // echo $pdffile;
        // readfile($data['silabus']->path_silabus);
        // echo filesize($data['silabus']->path_silabus);
        header('Content-type: application/octet-stream;name="' . $data['silabus']->path_silabus . '"');
        header('Content-Disposition: attachment; filename=' . $data['silabus']->path_silabus . '');
        header('Accept-Ranges: bytes');
        header('Pragma: no-cache');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-transfer-encoding: binary');
        header('Content-Length: ' . filesize($data['silabus']->path_silabus));

        @readfile($data['silabus']->path_silabus);
    }

    public function upload_silabus()
    {
        // print_r($this->input->post());
        if (!$this->input->post()) {
            $data = [
                'status' => false,
                'msg'    => 'Parameter not found!',
            ];

            echo json_encode($data);
            http_response_code(400);
        } else {
            if (isset($_FILES['file']['name'])) {
                $file        = $_FILES['file'];
                $filename    = explode('.', $_FILES['file']['name']);
                $filename    = $filename[0];
                $newfile     = $filename . '_' . uniqid() . '.pdf';
                $target_path = base_url('assets/materi/silabus/');

                $data = [
                    'silabus'      => 1,
                    'path_silabus' => $_SERVER['DOCUMENT_ROOT'] . '/assets/materi/silabus/' . $newfile,
                ];
                $this->db->where("MD5(id)", $this->input->post('token_modul'));
                $update = $this->db->update('m_mapel', $data);
                if ($update) {
                    if (move_uploaded_file($_FILES['file']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/assets/materi/silabus/' . $newfile)) {

                        $d = [
                            'status' => true,
                            'msg'    => 'Silabus berhasil diupload!',
                        ];
                        echo json_encode($d);
                        http_response_code(200);
                    } else {
                        $d = [
                            'status' => false,
                            'msg'    => 'Upload file gagal!',
                        ];
                        echo json_encode($d);
                        http_response_code(500);
                    }
                } else {
                    $d = [
                        'status' => false,
                        'msg'    => 'Internal Server Error!',
                    ];
                    echo json_encode($d);
                    http_response_code(500);
                }
            }
        }
    }

    public function delete_silabus()
    {
        if (!$this->input->post()) {
            $data = [
                'status' => false,
                'msg'    => 'Parameter not found!',
            ];

            echo json_encode($data);
            http_response_code(400);
        } else {
            $this->db->where('MD5(id)', $this->input->post('md5'));
            $res = $this->db->get('m_mapel')->row();
            if (file_exists($res->path_silabus)) {
                if (unlink($res->path_silabus)) {
                    $data = [
                        'silabus'      => 0,
                        'path_silabus' => null,
                    ];

                    $this->db->where('MD5(id)', $this->input->post('md5'));
                    $delete = $this->db->update('m_mapel', $data);
                    if ($delete) {
                        $data = [
                            'status' => true,
                            'msg'    => 'File berhasil dihapus!',
                        ];

                        echo json_encode($data);
                        http_response_code(200);
                    } else {
                        $data = [
                            'status' => false,
                            'msg'    => 'Gagal memperbaharui status',
                        ];

                        echo json_encode($data);
                        http_response_code(500);
                    }
                } else {
                    $data = [
                        'status' => false,
                        'msg'    => 'Gagal menghapus file silabus!',
                    ];

                    echo json_encode($data);
                    http_response_code(500);
                }
            } else {
                $data = [
                    'status' => false,
                    'msg'    => 'File silabus tidak ditemukan!',
                ];

                echo json_encode($data);
                http_response_code(200);
            }
        }
    }

    /*
    * Soft delete: belum terpakai lagi
    * tgl catatan : 16 Agustus 2020 11:33 WIB
    */
    public function s_delete()
    {
        if ($this->session->userdata('admin_level') == 'admin') {
            $this->delete_using_php($this->input->post('materi'), 1, $this->input->post('src'));
        } else {
            $this->db->where('MD5(id)', $this->input->post('materi'));
            $soft_delete = $this->db->update('m_materi', ['is_verify' => 0, 'req_delete' => 1]);
            if ($soft_delete) {
                echo json_encode(['status' => true, 'src' => $this->input->post('src')]);
            } else {
                echo json_encode(['status' => false, 'src' => $this->input->post('src')]);
            }
        }

    }

    public function get_youtube_video()
    {
        $url     = $this->input->get('url');
        $expl    = explode('www.', $url);
        $new_url = $expl[0] . 'www.ss' . end($expl);

        echo json_encode(['url' => $new_url]);
    }

    public function download_drive()
    {
        $video = $this->input->post('video');
        $url   = 'https://drive.google.com/uc?id=' . $video . '&export=download';
        echo json_encode(['url' => $url]);
    }

    public function diskusi($id = null, $id_kelas = null)
    {

        if ($this->log_lvl == 'siswa') {
            $id_trainer = 0;
            $id_siswa   = $this->log_id;
        } else {
            $id_trainer = $this->log_id;
            $id_siswa   = 0;
        }

        $cari = array(
            'id_materi'     => $id,
            'start_date <=' => date('Y-m-d H:i:s'),
            'end_date >='   => date('Y-m-d H:i:s'),
        );

        $data = array(
            'materi'     => $this->m_materi->get_by(array('id' => $id)),
            'komentar'   => $this->m_komen_materi->get_many_by(array('id_materi' => $id, 'id_head' => 0)),
            'jadwal'     => $this->m_jadwal->get_by(['id_materi' => $id, 'id_kelas' => $id_kelas]),
            'jadwal_by'  => $this->m_jadwal->get_by(['id_materi' => $id, 'id_kelas' => $id_kelas]),
            'id_trainer' => $id_trainer,
            'id_siswa'   => $id_siswa,
            'id_kelas' => $this->uri->segment(4),
        );

        $this->render('materi/diskusi_head', $data);
    }

    public function page_komen($id = null, $id_koment = null)
    {
        $post = $this->input->post();

        $where = array();

        if (!empty($id_koment)) {

            $get = $this->m_komen_materi->get_by(array('id' => $id_koment));

            if (!empty($get->id_head)) {
                $get = $this->m_komen_materi->get_by(array('id' => $get->id_head));
            }

            $where['id'] = (!empty($get->id)) ? $get->id : null;
        }

        $where['komen.id_materi'] = $id;
        $where['id_head']   = 0;
        $where['komen.id_kelas'] = $post['id_kelas'];
        // print_r($this->log_id);exit;
        if ($this->log_lvl == 'siswa') {
            $id_trainer = 0;
            $id_siswa   = $this->log_id;
            $data_detail_kelas = $this->m_detail_kelas->get_siswa(['dk.id_peserta' => $this->log_id]);
            $id_kelas = $data_detail_kelas->id_kelas;
            // $where['dk.id_kelas'] = $id_kelas;
            // $datas = $this->m_komen_materi->get_join_jadwal($where);
            $datas = $this->m_komen_materi->get_many_by($where);   
            // print_r($this->db->last_query());exit;
            
        } else {
            $id_trainer = $this->log_id;
            $id_siswa   = 0;
            // $data_detail_kelas = $this->m_detail_mapel->get_by(['id_guru' =>])
            $datas = $this->m_komen_materi->get_many_by($where);
        }
        $cari = array(
            'id_materi'     => $id,
            'start_date <=' => date('Y-m-d H:i:s'),
            'end_date >='   => date('Y-m-d H:i:s'),
        );
        $this->m_jadwal->get_by($cari);

        $data = array(
            'materi'     => $this->m_materi->get_by(array('id' => $id)),
            'komentar'   => $datas,
            'jadwal'     => $this->m_jadwal->get_by($cari),
            'id_trainer' => $id_trainer,
            'id_siswa'   => $id_siswa,
        );
        // print_r($data['komentar']);exit;
        $this->load->view('materi/isi_konten_komen', $data);
    }

    public function insert_koment()
    {
        
        $post = $this->input->post();
        $file = isset($_FILES['file']) ? $_FILES['file'] : NULL;
        $replyFile = isset($_FILES['reply-file']) ? $_FILES['reply-file'] : NULL;

        $cari = array(
            'id_materi'     => $post['id_materi'],
            'start_date <=' => date('Y-m-d H:i:s'),
            'end_date >='   => date('Y-m-d H:i:s'),
        );

        $jadwal = $this->m_jadwal->get_by($cari);
        $error = [];
        if (!empty($jadwal)) {

            $post['create_date'] = $this->create_date;
            $post['create_time'] = $this->create_time;

            // Upload file section untuk Start chat (chat pertama)
            if($file !== NULL) {
                // Set file configuration
                $config['upload_path'] = 'assets/materi/diskusi';
                $config['allowed_types'] = 'jpg|jpeg|png|pdf|docx|xls|xlsx';
                $config['max_size'] = 50000;
                $config['encrypt_name'] = TRUE;

                // Load upload library
                $this->load->library('upload', $config);

                if($this->upload->do_upload('file')) {
                    $uploadedFileData = $this->upload->data();
                    $uploadedFileName = $uploadedFileData['file_name'];

                    // Set filepath for file that uploaded in komentar
                    $post['file'] = $config['upload_path'] . '/' .$uploadedFileName;    
                }
                else {
                    $result = false;
                    $error['upload_diskusi']   = $this->upload->display_errors();
                }
                
            }

            $komentar = $this->m_komen_materi->check_komen_all(array('km1.id' => $post['id_head']), array('km1.id_siswa', 'km2.id_siswa'));
            $kirim_notif = '';
            $materi = $this->m_materi->get_by_join(array('mt.id' => $post['id_materi']));
            $data   = array();

            $this->db->trans_begin();
            $kirim     = $this->m_komen_materi->insert($post);
            $id_koment = $this->db->insert_id();

            if (!empty($post['id_head'])) {

                $komentar_grup = $this->m_komen_materi->get_group(array('id_head' => $post['id_head']), array('id_siswa'));

                if ($this->log_lvl == 'guru') {
                    foreach ($komentar as $index => $rows) {
                        $peserta      = (empty($rows->peserta2)) ? $rows->peserta1 : $rows->peserta2;
                        $data[$index] = array(
                            'id_koment'   => $id_koment,
                            'id_materi'   => $post['id_materi'],
                            'id_siswa'    => $peserta,
                            'id_trainer'  => $this->log_id,
                            'keterangan'  => 'Trainer ikut berkomentar',
                            'see'         => 0,
                            'sender_id'   => $this->log_id,
                            'sender_lvl'  => $this->log_lvl,
                            'create_date' => $post['create_date'] . ' ' . $post['create_time'],
                        );
                    }
                } else if ($this->log_lvl == 'siswa') {

                    $cek      = $this->m_komen_materi->get_by(array('id' => $post['id_head']));
                    $cek_head = $this->m_komen_materi->get_group(array('id_head' => $post['id_head'], 'id_siswa' => $cek->id_siswa), array('id_siswa'));

                    if (empty($cek_head->id_siswa)) {
                        $data[1] = array(
                            'id_koment'   => $id_koment,
                            'id_materi'   => $post['id_materi'],
                            'id_siswa'    => $cek->id_siswa,
                            'id_trainer'  => $this->log_id,
                            'keterangan'  => 'peserta lain ikut berkomentar',
                            'see'         => 0,
                            'sender_id'   => $this->log_id,
                            'sender_lvl'  => $this->log_lvl,
                            'create_date' => $post['create_date'] . ' ' . $post['create_time'],
                        );
                    }
                    $index = 2;
                    foreach ($komentar_grup as $rows) {

                        if ($this->log_lvl == 'siswa') {

                            if ($this->log_id != $rows->id_siswa) {

                                $data[$index] = array(
                                    'id_koment'   => $id_koment,
                                    'id_materi'   => $post['id_materi'],
                                    'id_siswa'    => $rows->id_siswa,
                                    'id_trainer'  => 0,
                                    'keterangan'  => 'peserta lain ikut berkomentar',
                                    'see'         => 0,
                                    'sender_id'   => $this->log_id,
                                    'sender_lvl'  => $this->log_lvl,
                                    'create_date' => $post['create_date'] . ' ' . $post['create_time'],
                                );

                            } else {
                                $materi  = $this->m_materi->get_by_join(array('mt.id' => $post['id_materi']));
                                $data[0] = array(
                                    'id_koment'   => $id_koment,
                                    'id_materi'   => $post['id_materi'],
                                    'id_siswa'    => null,
                                    'id_trainer'  => $materi->id_guru,
                                    'keterangan'  => 'peserta membalas ikut membalas komentar',
                                    'see'         => 0,
                                    'sender_id'   => $this->log_id,
                                    'sender_lvl'  => $this->log_lvl,
                                    'create_date' => $post['create_date'] . ' ' . $post['create_time'],
                                );
                            }

                        }
                        $index++;
                    }
                }

                $kirim_notif = $this->db->insert_batch('tb_notifikasi_forum', $data);

            } else {
                if ($this->log_lvl == 'siswa') {

                    if (empty($post['id_head'])) {
                        $materi = $this->m_materi->get_by_join(array('mt.id' => $post['id_materi']));


                        $data = array(
                            'id_kelas'    => $post['id_kelas'],
                            'id_koment'   => $id_koment,
                            'id_materi'   => $post['id_materi'],
                            'id_siswa'    => $this->log_id,
                            'id_trainer'  => $materi->id_trainer,
                            'keterangan'  => 'Menulis sesuatu di materi yang anda tulis',
                            'see'         => 0,
                            'sender_id'   => $this->log_id,
                            'sender_lvl'  => $this->log_lvl,
                            'create_date' => $post['create_date'] . ' ' . $post['create_time'],
                        );

                        $kirim_notif = $this->m_notif_forum->insert($data);

                    }

                }
                else if($this->log_lvl == 'guru') {
                    $data = [
                        'id_kelas'    => $post['id_kelas'],
                        'id_koment' => $id_koment,
                        'id_materi'   => $post['id_materi'],
                        'id_siswa'  => 0,
                        'id_trainer' => $this->log_id,
                        'keterangan' => 'Guru menulis sesuatu di forum',
                        'see' => 0,
                        'sender_id'   => $this->log_id,
                        'sender_lvl'  => $this->log_lvl,
                        'create_date' => $post['create_date'] . ' ' . $post['create_time']
                    ];

                    $kirim_notif = $this->m_notif_forum->insert($data);
                }
            }

            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }

            if ($kirim) {
                $komentar = 'komentar berhasil';
            } else {
                $komentar = 'komentar tidak berhasil';
            }

            if ($kirim_notif) {
                $notif = 'notif berhasil di buat';
            } else {
                $notif = 'notif tidak berhasil di buat';
            }

            $data   = array('komentar' => $komentar, 'notif' => $komentar);
            $result = true;
            $type = $this->log_lvl === 'siswa' ? 'active_diskusi' : 'sum_diskusi';
            // Update Activity Siswa
            $this->updateActiveUser($this->log_lvl, $type);
        } else {
            $result = false;
            $data   = array();
        }

        echo json_encode(array('result' => $result, 'status' => $data, 'error' => $error));
    }

    public function update_koment()
    {
        $post                = $this->input->post();
        $data['komentar']    = $post['komentar'];
        $data['update_date'] = $this->update_date;
        $data['update_time'] = $this->update_time;
        $kirim               = $this->m_komen_materi->update($data, array('id' => $post['id']));

        // Update sum diskusi
        $this->updateSumDiskusi();
        echo json_encode(array('result' => true));
    }

    public function updateSumDiskusi() {
        if($this->log_lvl == 'guru') {
            $data_update = $this->m_guru->get_by(['id' => $this->session->admin_konid]);
            // print_r($data_update);exit;
            $this->db->where('id', $this->session->admin_konid);
            $this->db->update('m_guru', ['sum_diskusi' => $data_update->sum_diskusi + 1]);
        }
        else if($this->log_lvl === 'siswa') {
            $data_update = $this->m_guru->get_by(['id' => $this->session->admin_konid]);
            $this->m_siswa->update([
                'active_diskusi' => $data_update->active_diskusi + 1,
                'is_graduated' => 0
            ], ['id' => $this->session->admin_konid]);
        }
        
    }

    public function updateSumUploadMateri() {
        $data_guru = $this->m_guru->get_by(['id' => $this->session->admin_konid]);
        $this->db->where('id', $this->session->admin_konid);
        $this->db->update('m_guru', ['sum_upload_materi' => $data_guru->sum_upload_materi + 1]);
    }

    public function delete_head_koment()
    {
        $post = $this->input->post();

        $this->db->trans_begin();

        $kirim = $this->m_komen_materi->delete(array('id' => $post['id']));
        $kirim = $this->m_komen_materi->delete(array('id_head' => $post['id']));

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }

        echo json_encode(array('result' => true));
    }

    public function delete_balasan_koment()
    {
        $post = $this->input->post();

        $this->db->trans_begin();

        $kirim = $this->m_komen_materi->delete(array('id' => $post['id']));

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }

        echo json_encode(array('result' => true));
    }

    public function get_notif()
    {
        if ($this->log_lvl == 'siswa') {
            $id_kelas = $this->m_detail_kelas->get_by(['id_peserta' => $this->log_id])->id_kelas;

            $total = $this->m_notif_forum->count_by(array('id_kelas' => $id_kelas, 'see' => 0));
            $list  = $this->m_notif_forum->get_many_by(array('id_kelas' => $id_kelas, 'see' => 0));
        } else {
            $id_kelas = $this->m_detail_kelas_mapel->get_many_by(['dklsmapel.id_guru' => $this->log_id]);

            // For storing multi data in many kelas
            $total = [];
            $list = [];

            if( count($id_kelas) > 0) {
                foreach($id_kelas as $rows) :
                    $total[] = $this->m_notif_forum->count_by(['nf.id_trainer' => $this->log_id,'nf.id_kelas' => $rows->id_kelas, 'see' => 0]);
                    $list[] = $this->m_notif_forum->get_many_by([ 'nf.id_trainer' => $this->log_id, 'nf.id_kelas' => $rows->id_kelas, 'see' => 0]);
                endforeach;
            }

            // Extract multi array list to one array
            $new_list = [];
            foreach($list as $arr) :
                foreach($arr as $data) :
                    $new_list[] = $data;
                endforeach;
            endforeach;

            
            // Make to num
            $total = array_sum($total);

            // Make to one array in var List for foreach action
            $list = $new_list;
            
        }


        $notifNumber = ($total > 0) ? $total : null;
        $see_all     = ($total > 0) ? 'all_see' : null;

        $data = array();

        $i = 1;
        foreach ($list as $index => $rows) {

            $datetime = explode(' ', $rows->create_date);
            $date     = date_indo($datetime[0]) . ' ' . time_short($datetime[1]);

            if ($i % 2 == 0) {
                $gray = 'bg-gray';
            } else {
                $gray = '';
            }

            $sender = ($rows->sender_lvl == 'siswa') ? 'Siswa' : 'Guru';

            $data[$index]['nama_pengirim'] = $rows->nama_pengirim;
            $data[$index]['sender']        = $sender;
            $data[$index]['url']           = base_url('Materi/diskusi/' . $rows->id_materi . '/' . $rows->id_kelas);
            $data[$index]['keterangan']    = $rows->keterangan;
            $data[$index]['title']         = $rows->title;
            $data[$index]['date']          = $date;
            $data[$index]['id_materi']     = $rows->id_materi;
            $data[$index]['id_koment']     = $rows->id_koment;
            $data[$index]['id']            = $rows->id;
            $data[$index]['bg']            = $gray;

            $i++;
        }

        $notif['data']        = $data;
        $notif['notifNumber'] = $notifNumber;
        $notif['see_all']     = $see_all;

        echo json_encode($notif);
    }

    public function diskusi_single($id = null, $id_koment = null, $id_notif = null)
    {

        $this->m_notif_forum->update(array('see' => 1), array('id' => $id_notif));

        if ($this->log_lvl == 'siswa') {
            $id_trainer = null;
            $id_siswa   = $this->log_id;
        } else {
            $id_trainer = $this->log_id;
            $id_siswa   = null;
        }

        $cari = array(
            'id_materi'     => $id,
            'start_date <=' => date('Y-m-d H:i:s'),
            'end_date >='   => date('Y-m-d H:i:s'),
        );

        $data = array(
            'materi'     => $this->m_materi->get_by(array('id' => $id)),
            'komentar'   => $this->m_komen_materi->get_many_by(array('id_materi' => $id, 'id_head' => 10)),
            'jadwal'     => $this->m_jadwal->get_by($cari),
            'jadwal_by'  => $this->m_jadwal->get_by(array('id_materi' => $id)),
            'id_trainer' => $id_trainer,
            'id_siswa'   => $id_siswa,
            'id_koment'  => $id_koment,
        );

        $this->render('materi/diskusi_head_single', $data);
    }

    public function see_all_notif()
    {
        if ($this->log_lvl == 'siswa') {
            $this->m_notif_forum->update(array('see' => 1), array('id_siswa' => $this->log_id));
        } else {
            $this->m_notif_forum->update(array('see' => 1), array('id_trainer' => $this->log_id));
        }

        echo json_encode(array('result' => true));

    }

    function deleteMapel(){
        $post = $this->input->post();

        $id = decrypt_url($post['id_materi']);
        $materi = $this->m_materi->get_by(['id'=>$id]);
        // print_r($materi);exit;
        $filePdf = $materi->file_pdf;
        $filePpt = $materi->file_ppt;
        
        $delete = $this->m_materi->delete(['id'=>$id]);
        if($delete){
            if(isset($filePdf)){
                $lokasi = 'assets/materi/pdf/' .$filePdf;
                if (file_exists($lokasi)) {
                    unlink($lokasi);
                }
            }

            if(isset($filePpt)){
                $lokasi    ='assets/materi/ppt/'.$filePpt;
                if (file_exists($lokasi)) {
                    unlink($lokasi);
                }
            }
        }

        $json = ['status' => true , 'delete' => $delete];
        echo json_encode($json);

    }

    public function get_list_videos()
    {
        $this->load->model('m_materi_attach');
        $post = $this->input->post();
        $datas = $this->m_materi_attach->get_many_wherein('type_file', ['video-youtube', 'video-gdrive'], ['id_materi' => $post['imateri']]);
        $html = '<header class="mb-4">List Videos: </header>';
        if(count($datas) > 0) {
            foreach($datas as $video) :
                $html .= '<div class="embed-responsive embed-responsive-16by9" style="position:relative;">

                          <iframe  src="'.$video->view_path.'" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe>

                          <div style="width: 80px; height: 80px; position: absolute; opacity: 0; right: 0px; top: 0px; background:#000;">&nbsp;</div>

                    </div>
                    <span class="mt-2">Klik <a href="'.$video->path.'" target="_blank">disini</a> untuk belajar</span>';
            endforeach;
        }
        else {
            $html .= '<p class="alert alert-warning">Tidak ada video</p>';
        }

        $this->sendAjaxResponse([
            'status' => true,
            'data' => $html
        ]);
    }

    public function get_list_file()
    {
        $this->load->model('m_materi_attach');
        $post = $this->input->post();
        $dataFiles = $this->m_materi_attach->get_many_by([
            'type_file' => $post['type_file'],
            'id_materi' => $post['imateri']
        ]);
        $html = '<header class="mb-4">List Files: </header>';

        if(count($dataFiles) > 0) {
            $i = 1;
            // ada aksi hapusnya (khusus guru)
            if(!isset($post['view'])) {
                foreach($dataFiles as $file) {
                    $html .= '<span class="alert alert-success m-2">
                                <a href="'.base_url($file->path).'" download class="text-primary">' .$i. '. ' . $file->file_name .'</a> <a href="javascript:void(0);" class="btn btn-sm btn-danger ml-2 delete-file-tugas" data-id="'.$file->id.'"><i class="fas fa-trash"></i></a>
                            </span>';
                    $i++;
                }
            }
            else { // untuk siswa, guru agar bisa download fie\le pdf
                foreach($dataFiles as $file) {
                    $html .= '<span class="alert alert-success m-2">
                                <a href="'.base_url($file->path).'" download class="text-primary">' .$i. ' ' . $file->file_name .'</a>
                            </span>';
                    $i++;
                }    
            }
                
        }
        else {
            $html .= '<p class="alert alert-warning">Tidak ada file</p>';
        }

        $this->sendAjaxResponse([
            'status' => true,
            'data' => $html
        ]);
    }
    
    /*
    * Delete file materi via ajax call
    */
    public function delete_file_materi()
    {
        $this->load->model('m_materi_attach');
        $post = $this->input->post();
        $file = $this->m_materi_attach->get_by(['id' => $post['id']]);

        if(file_exists($file->path)) {
            unlink($file->path);
        }

        $delete = $this->m_materi_attach->delete([
            'id' => $post['id']
        ]);

        if($delete) {
            $this->sendAjaxResponse([
                'status' => true,
                'msg' => 'File berhasil dihapus'
            ], 200);
        }
        else {
            $this->sendAjaxResponse([
                'status' => false,
                'msg' => 'File gagal dihapus'
            ], 500);
            exit;
        }
    }
}
