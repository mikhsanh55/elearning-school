<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_tugas_nilai extends MY_Model {

	protected $_table = 'tb_tugas_nilai';
	protected $order_by = array('id','desc');

	public function __construct()
	{
		parent::__construct();
		
	}

	public function get_detail_nilai($where = []) {
		$get = $this->db->select('tugas.*, tnilai.nilai')
						->from('tb_tugas tugas')
						->join('tb_tugas_nilai tnilai', 'tugas.id = tnilai.id_tugas', 'inner')
						->where($where)
						->get()
						->result();
		return $get;
	}

	public function count_detail_nilai($where = []) {
		return count($this->get_detail_nilai($where));
	}

	public function paginate_detail_nilai($page = 1, $where = [], $limit = 10) {
		// get filtered results
        $where = array_merge($where, $this->where);
        $offset = ($page<=1) ? 0 : ($page-1)*$limit;
        $this->db->limit($limit, $offset);
        $results = $this->get_detail_nilai($where);
        //echo  $this->db->last_query(); exit;
        // get counts (e.g. for pagination)
        $count_results = count($results);
        $count_total = $this->count_detail_nilai($where);
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
/* Location: ./application/models/m_tugas_nilai.php */