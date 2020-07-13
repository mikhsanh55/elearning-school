<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class M_jurusan extends MY_Model {

  protected $_table = 'tb_jurusan';
	protected $order_by = array('id','desc');

  public function __construct()
  {
    parent::__construct();
  }

  public function get_all($where=array()){
    $get = $this->db->select('jurus.*, in.instansi AS nama_instansi')
            ->from('tb_jurusan jurus')
            ->join('tb_instansi in','in.id = jurus.id_instansi')
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
        $results = $this->get_all($where);
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


}

/* End of file M_jurusan.php */
/* Location: ./application/models/M_jurusan.php */