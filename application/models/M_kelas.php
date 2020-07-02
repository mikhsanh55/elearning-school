<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_kelas extends MY_Model {

	protected $_table = 'tb_kelas';
	protected $order_by = array('id','asc');

	public function __construct()
	{
		parent::__construct();
		
	}

	public function get_all($where=array()){
		$get = $this->db->select('
							kls.*,
							gr.nama as nama_guru,
							mp.nama as nama_mapel,
							ins.instansi
						')
		->from('tb_kelas kls')
		->join('m_guru gr','gr.id=kls.id_trainer','left')
		->join('m_mapel mp','mp.id=kls.id_mapel','left')
		->join('tb_instansi ins','ins.id=kls.id_instansi','left')
		->order_by('mp.id','asc')
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
							gr.email as email_guru,
							gr.id_instansi as guru_instansi,
							gr.id_jurusan as guru_kelas
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
							jurus.jurusan
						')
		->from('tb_kelas kls')
		->join('m_guru gr','gr.id=kls.id_trainer','left')
		->join('m_mapel mp','mp.id=kls.id_mapel','left')
		->join('tb_instansi ins','ins.id=kls.id_instansi','left')
		->join('tb_jurusan jurus','jurus.id=kls.id_jurusan','left')
		->order_by('mp.id','asc')
		->where($where)
		->get()
		->row();
	
		return $get;
	}

	public function count_by($where=array()){
		$get = $this->db->select('
							kls.id,
						')
		->from('tb_kelas kls')
		->join('m_guru gr','gr.id=kls.id_trainer','left')
		->join('m_mapel mp','mp.id=kls.id_mapel','left')
		->join('tb_instansi ins','ins.id=kls.id_instansi','left')
		->order_by('mp.id','asc')
		->where($where)
		->get()
		->result();
	
		return count($get);
	}

	public function count_by_siswa($where=array()){
		
		return count($this->get_all_siswa($where));
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

}

/* End of file m_perusahaan.php */
/* Location: ./application/models/m_perusahaan.php */