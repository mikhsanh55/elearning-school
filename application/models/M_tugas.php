<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_tugas extends MY_Model {

	protected $_table = 'tb_tugas';
	protected $order_by = array('id','asc');

	public function __construct()
	{
		parent::__construct();
		
	}

	public function get_all($where=array()){
		$get = $this->db->select('
							tgs.*,
							kls.nama as kelas,
							gr.nama as nama_trainer,
							mpl.nama as nama_mapel
						')
		->from('tb_tugas tgs')
		->join('tb_kelas kls','kls.id=tgs.id_kelas','left')
		->join('m_guru gr','gr.id=kls.id_trainer','left')
		->join('m_mapel mpl','mpl.id=kls.id_mapel','left')
		->order_by('tgs.id','desc')
		->where($where)
		->get()
		->result();
      
		return $get;
	}

	public function get_nilai($where=array()){
		$get = $this->db->select('
							AVG(tgs_nilai.nilai) as nilai
						')
		->from('tb_tugas tgs')
		->join('tb_tugas_nilai tgs_nilai','tgs_nilai.id_tugas = tgs.id','inner')
		->group_by('tgs_nilai.id_siswa')
		->where($where)
		->get()
		->row();
	
      
		return $get;
	}

	public function get_list_tugas($where=array()){
		$get = $this->db->select('
							tgs.*,
							kls.nama as kelas,
							(SELECT nama FROM m_mapel WHERE id = kls.id_mapel) as nama_mapel,
							(SELECT nama FROM m_guru WHERE id = kls.id_trainer) as nama_trainer,
						')
		->from('tb_tugas tgs')
		->join('tb_kelas kls','kls.id=tgs.id_kelas','left')
		->join('tb_detail_kelas detail_kls','detail_kls.id_kelas=kls.id','left')
		->order_by('tgs.id','desc')
		->where($where)
		->get()
		->result();
	
      
		return $get;
	}

	public function get_by($where=array()){
		$get = $this->db->select('
							tgs.*,
							gr.nama as nama_trainer,
							mpl.nama as nama_mapel
						')
						->from('tb_tugas tgs')
						->join('tb_kelas kls','kls.id=tgs.id_kelas','left')
						->join('m_guru gr','gr.id=kls.id_trainer','left')
						->join('m_mapel mpl','mpl.id=kls.id_mapel','left')
						->order_by('tgs.id','desc')
						->where($where)
						->get()
						->row();
	
      
		return $get;
	}

	public function count_by_tugas($where=array()){
		$get = $this->get_list_tugas($where);
		return count($get);
	}

	public function count_by_cs($where=array()){
		$get = $this->db->select('
							tgs.*,
							gr.nama as nama_trainer,
							mpl.nama as nama_mapel
						')
						->from('tb_tugas tgs')
						->join('tb_kelas kls','kls.id=tgs.id_kelas','left')
						->join('tb_detail_kelas_mapel dmkls', 'dmkls.id_kelas = kls.id', 'left')
						->join('m_guru gr','gr.id=dmkls.id_guru','left')
						->join('m_mapel mpl','mpl.id=dmkls.id_mapel','left')
						->order_by('tgs.id','desc')
						->where($where)
						->get()
						->result();
	
      
		return count($get);
	}

	public function get_many_by($where = []) {
		$get = $this->db->select('tugas.*, kls.nama AS kelas')
						->from('tb_tugas tugas')
						->join('tb_kelas kls', 'tugas.id_kelas = kls.id', 'left')
						// ->join('m_mapel mapel', 'tugas.id_mapel = mapel.id', 'left')
						// ->join('tb_detail_kelas_mapel dmkls', 'dmkls.id_kelas = kls.id', 'left')
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

     public function paginate_tugas($page = 1, $where = array(), $limit = 10)
    {
        // get filtered results
        $where = array_merge($where, $this->where);
        $offset = ($page<=1) ? 0 : ($page-1)*$limit;
        $this->db->limit($limit, $offset);
        $results = $this->get_list_tugas($where);
        //echo  $this->db->last_query(); exit;
        // get counts (e.g. for pagination)
        $count_results = count($results);
        $count_total = $this->count_by_tugas($where);
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

/* End of file m_tugas.php */
/* Location: ./application/models/m_tugas.php */