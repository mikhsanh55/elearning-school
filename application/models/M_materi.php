<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class m_materi extends MY_Model {

	protected $_table = 'm_materi';
	protected $order_by = array('id','desc');

	public function __construct()
	{
		parent::__construct();
		
	}

	public function get_by_join($where=array()){
		$get = $this->db->select('*')->from('m_materi mt')->join('tr_guru_mapel grm','grm.id_mapel=mt.id_mapel','left')->where($where)->get()->row();
		return $get;
	}

	public function join_jadwal($where=array())
	{
		$get = $this->db->select('
							mt.*,
							jdwl.start_date,
							jdwl.end_date,
						')
					->from('m_materi mt')
					->join('tb_jadwal jdwl','jdwl.id_materi =mt.id','inner')
					->order_by('mt.id','asc')
					->where($where)
					->get()
					->result();
		return $get;
	}

	public function join_jadwal2($where=array())
	{
		$get = $this->db->select('
							mt.*,
							jdwl.start_date,
							jdwl.end_date,
							gur.nama as nama_guru
						')
					->from('m_materi mt')
					->join('tb_jadwal jdwl','jdwl.id_materi =mt.id','left')
					->join('m_guru gur','gur.id = mt.id_trainer','left')
					->order_by('mt.id','asc')
					->where($where)
					->get()
					->result();
		return $get;
	}

	public function join_jadwal_count($where = array())
	{
		return count($this->join_jadwal($where));
	}

	public function join_jadwal_count2($where = array())
	{
		return count($this->join_jadwal2($where));
	}

	public function paginate_kelas($page = 1, $where = array(), $limit = 10)
    {
        // get filtered results
        $where = array_merge($where, $this->where);
        $offset = ($page<=1) ? 0 : ($page-1)*$limit;
        $this->db->limit($limit, $offset);
        $results = $this->join_jadwal($where);
        //echo  $this->db->last_query(); exit;
        // get counts (e.g. for pagination)
        $count_results = count($results);
        $count_total = $this->join_jadwal_count($where);
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
	
	public function paginate_materi($page = 1, $where = array(), $limit = 10)
    {
        // get filtered results
        $where = array_merge($where, $this->where);
        $offset = ($page<=1) ? 0 : ($page-1)*$limit;
        $this->db->limit($limit, $offset);
        $results = $this->join_jadwal2($where);
        //echo  $this->db->last_query(); exit;
        // get counts (e.g. for pagination)
        $count_results = count($results);
        $count_total = $this->join_jadwal_count2($where);
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

/* End of file m_materi.php */
/* Location: ./application/models/m_materi.php */