<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ujian_siswa extends MY_Controller
{
    
  public function __construct()
  {
    parent::__construct();
    $this->load->model('m_ujian');
    $this->load->model('m_ikut_ujian');
    
    $this->page_title = 'Ujian';
    
  }

  public function index()
  {
    $this->render_siswa('ujian/daftar');
  }

  public function page_load($pg = 1){
		$post = $this->input->post();
		$limit = 6;
		$where = [];
		if (!empty($post['search'])) {
			switch ($post['filter']) {
				case 0:
					$where["(lower(mp.nama) like '%".strtolower($post['search'])."%' )"] = null;
					break;
				case 1:
					$where["(lower(gr.nama) like '%".strtolower($post['search'])."%' )"] = null;
					break;
				default:
					# code...
					break;
			}
		}

		if (!empty($post['tipe_ujian'])) {
			$where['type_ujian'] = $post['tipe_ujian'];
		}

		$where['uji.id_instansi'] = $this->akun->instansi;

		if ($this->log_lvl == 'guru') {
			$where['uji.id_guru'] = $this->akun->id;
		}

		$paginate                   = $this->m_ujian->paginate($pg,$where,$limit);
		$data['paginate']           = $paginate;
		$data['paginate']['url']    = 'ujian_real/page_load';
		$data['paginate']['search'] = 'lookup_key';
   		$data['page_start']      = $paginate['counts']['from_num'];
    	$data['paging']          = $this->gen_paging($data['paginate']);

		$this->load->view('ujian/data',$data);
	}

	public function result($id=NULL)
	{
		$this->page_title = 'Hasil Ujian';
		$data = array(
			'id_ujian' => decrypt_url($id), 
		);

		$this->render_siswa('ujian/hasil',$data);
	}

	public function page_load_hasil($pg = 1){
		$post = $this->input->post();
		$limit = 6;
		$where = [];
		if (!empty($post['search'])) {
			switch ($post['filter']) {
				case 0:
					$where["(lower(mp.nama) like '%".strtolower($post['search'])."%' )"] = null;
					break;
				case 1:
					$where["(lower(gr.nama) like '%".strtolower($post['search'])."%' )"] = null;
					break;
				default:
					# code...
					break;
			}
		}
		$where['id_ujian'] = $post['id_ujian'];
		$where['status'] = 'N';
		$where['id_user'] = $this->akun->id;


		$paginate = $this->m_ikut_ujian->paginate($pg,$where,$limit);
		$data['paginate']           = $paginate;
		$data['paginate']['url']    = 'ujian_real/page_load';
		$data['paginate']['search'] = 'lookup_key';
   		$data['page_start']      = $paginate['counts']['from_num'];
    	$data['paging']          = $this->gen_paging($data['paginate']);

		$this->load->view('ujian/data_hasil',$data);
	}

	public function ikuti_ujian($id_ujian){

			header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");

			//$id_tes = abs($id_ujian);
			/*$a['du'] = $this->db->query("SELECT a.id, a.penggunaan, a.tgl_mulai, a.terlambat, 
				a.token, a.nama_ujian, a.jumlah_soal, a.waktu,
				a.status_token, b.nama nmguru, c.nama nmmapel,
				(case
				when (now() < a.tgl_mulai) then 0
				when (now() >= a.tgl_mulai and now() <= a.terlambat) then 1
				else 2
				end) statuse
				FROM tb_ujian a 
				INNER JOIN m_guru b ON a.id_guru = b.id
				INNER JOIN m_mapel c ON a.id_mapel = c.id 
				WHERE a.id = '$id_ujian'")->row_array();*/

			$a['du'] = $this->db->select("	
										a.id, a.tgl_mulai, a.terlambat,a.izin, 
										a.token, a.nama_ujian, a.jumlah_soal, a.waktu,
										a.status_token, b.nama nmguru, c.nama nmmapel,
										(case
										when (now() < a.tgl_mulai) then 0
										when (now() >= a.tgl_mulai and now() <= a.terlambat) then 1
										else 2
										end) statuse
										")
								->from('tb_ujian a')
								->join('m_guru b','a.id_guru = b.id')
								->join(' m_mapel c','a.id_mapel = c.id')
								->where('a.id',decrypt_url($id_ujian))
								->get()
								->row_array();


			$a['dp'] = $this->m_siswa->get_by(['id' =>$this->log_id]);
			//$q_status = $this->db->query();

			if (!empty($a['du']) || !empty($a['dp'])) {
				$tgl_selesai = $a['du']['tgl_mulai'];
			    //$tgl_selesai2 = strtotime($tgl_selesai);
			    //$tgl_baru = date('F j, Y H:i:s', $tgl_selesai);

			    //$tgl_terlambat = strtotime("+".$a['du']['terlambat']." minutes", $tgl_selesai2);	
				$tgl_terlambat_baru = $a['du']['terlambat'];

				$a['tgl_mulai'] = $tgl_selesai;
				$a['terlambat'] = $tgl_terlambat_baru;

				$cek = $this->db->query("
					SELECT
					count(ujian.id) as jmlh,
					tes.*
					FROM
					tb_ikut_ujian ujian
					INNER JOIN tb_ujian tes ON tes.id = ujian.id_ujian 
					WHERE id_ujian = '".decrypt_url($id_ujian)."' AND id_user = '".$this->log_id."' AND status = 'N'
					")->row();
				
				if ($this->total_ujian <= $cek->jmlh) {
					redirect('ujian_real/');
					exit;
				}

				$this->session->set_userdata(array('selesai_ujian'=>0));
				$this->render_siswa('ujian/ikuti', $a);

			} else {
				redirect('ujian_real/result');
			}
		}

}


/* End of file Ujian_siswa.php */
/* Location: ./application/controllers/Ujian_siswa.php */