<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_ujian extends MY_Model {

	protected $_table = 'tb_ujian';
	protected $order_by = array('id','desc');

	public function __construct()
	{
		parent::__construct();
		
	}

	public function get_all($where=array()){
		$get = $this->db->select('
							uji.*,
							kls.nama as kelas,
							mp.nama as nama_mapel,
							ins.instansi as nama_instansi
						')
		->from('tb_ujian uji')
		->join('tb_kelas kls','kls.id=uji.id_kelas','left')
		->join('tb_detail_kelas_mapel dmkls', 'dmkls.id_kelas = kls.id', 'left')
		->join('m_mapel mp','mp.id=dmkls.id_mapel','left')
		->join('tb_instansi ins','ins.id=kls.id_instansi','left')
		->order_by('uji.id','asc')
		->where($where)
		->get()
		->result();
	
      
		return $get;
	}

	public function get_nilai($where=array()){
		$get = $this->db->select('
							ikut.nilai
						')
		->from('tb_ujian uji')
		->join('tb_ikut_ujian ikut','ikut.id_ujian = uji.id','inner')
		->order_by('uji.id','asc')
		->where($where)
		->get()
		->row();
	
      
		return $get;
	}

	public function get_essay($where=array()){
		$get = $this->db->select('
						sum(jwb.nilai) as nilai
						')
		->from('tb_ujian uji')
		->join('tb_ikut_ujian_essay ikut','ikut.id_ujian = uji.id','inner')
		->join('tb_jawaban_essay jwb','jwb.id_ikut_essay = ikut.id','inner')
		->order_by('uji.id','asc')
		->where($where)
		->group_by('ikut.id_user')
		->get()
		->row();
	
      
		return $get;
	}

	public function get_check($where=array()){
		$get = $this->db->select('
						count(uji.id) as cek
						')
		->from('tb_ujian uji')
		->join('m_soal_ujian_essay soal','soal.id_ujian = uji.id','inner')
		->order_by('uji.id','asc')
		->where($where)
		->get()
		->row();
	
		return $get->cek;
	}


	public function get_all_siswa($where=array()){
		$get = $this->db->select('
							uji.*,
							kls.nama as kelas,
							mp.nama as nama_mapel,
							ins.instansi as nama_instansi
						')
		->from('tb_ujian uji')
		->join('tb_kelas kls', 'kls.id = uji.id_kelas', 'left')
		->join('tb_detail_kelas dkls', 'dkls.id_kelas = kls.id', 'left')
		->join('m_siswa sis', 'sis.id = dkls.id_peserta', 'left')
		// ->join('tb_kelas kls','kls.id=uji.id_kelas','left')
		// ->join('tb_detail_kelas dekls','dekls.id_kelas=kls.id','left')
		->join('m_mapel mp','mp.id=uji.id_mapel','left')
		->join('tb_instansi ins','ins.id=kls.id_instansi','left')
		->order_by('uji.id','asc')
		->where($where)
		->get()
		->result();
	
      
		return $get;
	}

	public function count_by_siswa($where=array()){
		$get = $this->get_all_siswa($where);
		return count($get);
	}

	public function count_by_cs($where=array()){
		$get = $this->get_all($where);
		return count($get);
	}

	public function get_by($where=array()){
		$get = $this->db->select('
							uji.*,
							kls.nama as kelas,
							gr.nama as nama_guru,
							mp.nama as nama_mapel,
							ins.instansi as nama_instansi
						')
		->from('tb_ujian uji')
		->join('tb_kelas kls', 'kls.id = uji.id_kelas', 'left')
		->join('m_siswa sis', 'sis.id_jurusan = kls.id', 'left')
		->join('m_guru gr','gr.id=uji.id_guru','left')
		->join('m_mapel mp','mp.id=uji.id_mapel','left')
		->join('tb_instansi ins','ins.id=kls.id_instansi','left')
		->order_by('uji.id','asc')
		->where($where)
		->get()
		->row();
	
      
		return $get;
	}

	public function get_many_by($where=array()){
		$get = $this->db->select('
							uji.*,
							kls.nama as kelas,
							gr.nama as nama_guru,
							mp.nama as nama_mapel,
							ins.instansi as nama_instansi
						')
		->from('tb_ujian uji')
		->join('tb_kelas kls', 'kls.id = uji.id_kelas', 'left')
		->join('m_guru gr','gr.id=uji.id_guru','left')
		->join('m_mapel mp','mp.id=uji.id_mapel','left')
		->join('tb_instansi ins','ins.id=kls.id_instansi','left')
		->order_by('uji.id','asc')
		->where($where)
		->get()
		->result();
	
      
		return $get;
	}

	 public function paginate($page = 1, $where = array(), $limit = 10)
    {
        // get filtered results
        $where = array_merge($where, $this->where);
        $offset = ($page<=1) ? 0 : ($page-1)*$limit;
        $this->db->limit($limit, $offset);
        $results = $this->get_many_by($where);
        //echo  $this->db->last_query(); exit;
        // get counts (e.g. for pagination)
        $count_results = count($results);
        $count_total = $this->count_by_cs($where);
        $total_pages = ceil($count_total / $limit);
        $counts = array(
            'from_num'      => ($count_results==0) ? 0 : $offset + 1,
            'to_num'        => ($count_results==0) ? 0 : $offset + $count_results,
            'total_num'     => $count_total,
            'curr_page'     => $page,
            'total_pages'   => ($count_results==0) ? 1 : $total_pages,
            'limit'         => $limit,
        );

        return array('data' => $results, 'counts' => $counts);
	}
	
	public function paginate_siswa($page = 1, $where = array(), $limit = 10)
    {
        // get filtered results
        $where = array_merge($where, $this->where);
        $offset = ($page<=1) ? 0 : ($page-1)*$limit;
        $this->db->limit($limit, $offset);
        $results = $this->get_all_siswa($where);
        //echo  $this->db->last_query(); exit;
        // get counts (e.g. for pagination)
        $count_results = count($results);
        $count_total = $this->count_by_siswa($where);
        $total_pages = ceil($count_total / $limit);
        $counts = array(
            'from_num'      => ($count_results==0) ? 0 : $offset + 1,
            'to_num'        => ($count_results==0) ? 0 : $offset + $count_results,
            'total_num'     => $count_total,
            'curr_page'     => $page,
            'total_pages'   => ($count_results==0) ? 1 : $total_pages,
            'limit'         => $limit,
        );

        return array('data' => $results, 'counts' => $counts);
    }


}

/* End of file m_ujian.php */
/* Location: ./application/models/m_ujian.php */