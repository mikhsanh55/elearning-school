<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_kelas extends MY_Model {

	protected $_table = 'tb_kelas';
	protected $order_by = array('id','asc');

	public function __construct()
	{
		parent::__construct();
		
	}

	public function count_by($where=array()){
		$get = $this->db->select('
							kls.id,
						')
		->from('tb_kelas kls')
		->join('m_guru gr','gr.id=kls.id_trainer','inner')
		->join('tb_instansi ins','ins.id=kls.id_instansi','inner')
		->get()
		->result();
	
		return count($get);
	}

	public function get_all($where=array()){
		$get = $this->db->select('
							kls.*,
							gr.nama as nama_guru,
							ins.instansi,
						')
		->from('tb_kelas kls')
		->join('m_guru gr','gr.id=kls.id_trainer','inner')
		->join('tb_instansi ins','ins.id=kls.id_instansi','inner')
		->where($where)
		->get()
		->result();
	
      
		return $get;
	}

	public function rekaptulasi($where=array()){
		$get = $this->db->select('
									dekls.id_peserta,
									sis.nama as siswa,
									(SELECT jurusan FROM tb_jurusan WHERE id = sis.id_jurusan) as jurusan,
									mpl.semester,
									mpl.nama as mapel,
									dekls.id_kelas
						')
		->from('tb_kelas kls')
		->join('tb_detail_kelas dekls','dekls.id_kelas = kls.id','inner')
		->join('m_mapel mpl','mpl.id=kls.id_mapel','inner')
		->join('m_siswa sis','sis.id = dekls.id_peserta','inner')
		->where($where)
		->get()
		->result();
		return $get;
	}

	public function count_guru($where = []) {
		return count($this->get_all($where));
	}

	public function count_siswa($where = []) {
		return count($this->get_data_mapel($where));
	}

	public function count_rekap($where=array()){
		
		return count($this->rekaptulasi($where));
	}

	public function get_all_siswa($where=array()){
		$get = $this->db->select('
							kls.*,
							gr.nama as nama_guru,
							mp.nama as nama_mapel,
							ins.instansi,
							sis.nama as nama_siswa,
							sis.email as email_siswa,
							gr.email as email_guru
						')
		->from('tb_kelas kls')
		->join('m_guru gr','gr.id=kls.id_trainer','left')
		->join('m_mapel mp','mp.id=kls.id_mapel','left')
		->join('tb_instansi ins','ins.id=kls.id_instansi','left')
		->join('tb_detail_kelas dekls','dekls.id_kelas=kls.id','left')
		->join('m_siswa sis','dekls.id_peserta=sis.id','left')
		->order_by('mp.id','asc')
		->where($where)
		->get()
		->result();
	
      
		return $get;
	}


	public function get_by($where=array()){
		$get = $this->db->select('
							kls.*,
							gr.nama as nama_guru,
							mp.nama as nama_mapel,
							ins.instansi,
							dmkls.id_mapel AS idmapel,
							dmkls.id_guru AS idguru
						')
		->from('tb_kelas kls')
		->join('tb_detail_kelas_mapel dmkls', 'kls.id = dmkls.id_kelas', 'inner')
		->join('m_guru gr','gr.id=dmkls.id_guru','left')
		->join('m_mapel mp','mp.id=dmkls.id_mapel','left')
		->join('tb_instansi ins','ins.id=kls.id_instansi','left')
		->order_by('mp.id','asc')
		->where($where)
		->get()
		->row();
	
		return $get;
	}

	

	public function count_by_siswa($where=array()){
		
		return count($this->get_all_siswa($where));
	}

	// Nanti dirubah karena field id_mapel di m_guru akan jadi array
	// public function get_all_mapel($where) {
	// 	$kelas = $this->get_by($)
	// }
	
	public function paginate_siswa($page = 1, $where = array(), $limit = 10)
    {
        // get filtered results
        $where = array_merge($where, $this->where);
        $offset = ($page<=1) ? 0 : ($page-1)*$limit;
        $this->db->limit($limit, $offset);
        $results = $this->get_data_mapel($where);
        
        $count_results = count($results);
        $count_total = $this->count_siswa($where);
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
	

	public function paginate_rekap($page = 1, $where = array(), $limit = 10)
    {
        // get filtered results
        $where = array_merge($where, $this->where);
        $offset = ($page<=1) ? 0 : ($page-1)*$limit;
        $this->db->limit($limit, $offset);
        $results = $this->rekaptulasi($where);
        //echo  $this->db->last_query(); exit;
        // get counts (e.g. for pagination)
        $count_results = count($results);
        $count_total = $this->count_rekap($where);
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

    public function get_data_mapel($where = array()) {
    	
    	// $kelas = $this->get_by($where);
    	// if(!empty($kelas)) {
    	// 	$id_mapel = explode(',', $kelas->id_mapel);
    	// 	$result = $this->db->select('*')
    	// 					->from('m_mapel')
    	// 					->where_in('id', $id_mapel)
    	// 					->get()
    	// 					->result();	
    	// }
    	// else {
    	// 	$result = [];
    	// }

    	$result = $this->db->select('kls.id, kls.nama, mapel.nama AS nama_mapel, guru.nama AS nama_guru, dkmapel.*, dkmapel.id_mapel AS dmapel')
    						->from('tb_kelas kls')
    						->join('tb_detail_kelas_mapel dkmapel', 'kls.id = dkmapel.id_kelas','inner')
    						->join('m_mapel mapel', 'dkmapel.id_mapel = mapel.id', 'left')
    						->join('m_guru guru', 'dkmapel.id_guru = guru.id', 'left')
    						->where($where)
    						->get()
    						->result();
    	
    	return $result;
    }

    public function get_kelas_by($where = []) {
    	$result = $this->db->select('kls.id, kls.nama, mapel.nama AS nama_mapel, guru.nama AS nama_guru')
    						->from('tb_kelas kls')
    						->join('tb_detail_kelas_mapel dkmapel', 'kls.id = dkmapel.id_kelas','inner')
    						->join('m_mapel mapel', 'dkmapel.id_mapel = mapel.id', 'left')
    						->join('m_guru guru', 'dkmapel.id_guru = guru.id', 'left')
    						->where($where)
    						->get()
    						->result();

    	return $data;
    }

    public function count_guru_all($where = []) {
    	return count($this->get_guru_all($where));
    }

    public function get_guru_all($where = []) {
    	$get = $this->db->select('
							kls.*,
							gr.nama as nama_guru,
							ins.instansi,
							dmapel.id_guru AS dguru,
							dmapel.id_mapel AS dmapel,
							mp.nama AS nama_mapel
						')
		->from('tb_kelas kls')
		->join('tb_detail_kelas_mapel dmapel', 'dmapel.id_kelas = kls.id', 'inner')
		->join('m_guru gr','gr.id=kls.id_trainer','left')
		->join('m_mapel mp','mp.id=dmapel.id_mapel','inner')
		->join('tb_instansi ins','ins.id=kls.id_instansi','left')
		->order_by('mp.id','asc')
		->where($where)
		->get()
		->result();
	
      
		return $get;
    }

    public function paginate_guru($page = 1, $limit = 10, $where = []) {
    	$where = array_merge($where, $this->where);
        $offset = ($page<=1) ? 0 : ($page-1)*$limit;
        $this->db->limit($limit, $offset);
        $results = $this->get_guru_all($where);
        //echo  $this->db->last_query(); exit;
        // get counts (e.g. for pagination)
        $count_results = count($results);
        $count_total = $this->count_guru_all($where);
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

/* End of file m_perusahaan.php */
/* Location: ./application/models/m_perusahaan.php */