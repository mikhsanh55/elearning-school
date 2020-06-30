<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class m_mapel_cs extends MY_Model {

	protected $_table = 'm_mapel';
	protected $order_by = array('id','asc');

	public function __construct()
	{
		parent::__construct();
		
	}

	public function get_all($where=array()){
		$get = $this->db->select('
							mp.*,
							gr.id as guru_id,
							gr.nama as nama_guru,
						')
		->from('m_mapel mp')
		->join('tr_guru_mapel grm','grm.id_mapel=mp.id','left')
		->join('m_guru gr','gr.id=grm.id_guru','left')
		->order_by('mp.id','asc')
		->where($where)
		->get()
		->result();
	
      
		return $get;
	}


	public function get_siswa($where=array()){
		$get = $this->db->select('
							mp.*,
							gr.id as guru_id,
							gr.nama as nama_guru,
						')
		->from('m_mapel mp')
		->join('tr_guru_mapel grm','grm.id_mapel=mp.id','left')
		->join('m_guru gr','gr.id=grm.id_guru','left')
		->join('tb_kelas kls','kls.id_mapel=mp.id AND kls.id_trainer=gr.id','left')
		->order_by('mp.id','asc')
		->where($where)
		->get()
		->result();
	
      
		return $get;
	}

	public function count_by($where=array()){
	 	$this->db->where($where);
        $get = $this->get_all();
        return count($get);
    }

    public function count_siswa_by($where=array()){
	 	$this->db->where($where);
        $get = $this->get_siswa();
        return count($get);
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
        $count_total = $this->count_by($where);
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
        $results = $this->get_siswa($where);
        //echo  $this->db->last_query(); exit;
        // get counts (e.g. for pagination)
        $count_results = count($results);
        $count_total = $this->count_siswa_by($where);
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

/* End of file m_mapel.php */
/* Location: ./application/models/m_mapel.php */