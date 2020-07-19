<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_kelas_ujian extends MY_Model {

	protected $_table = 'tb_kelas_ujian';
	protected $order_by = array('id','desc');

	public function __construct()
	{
		parent::__construct();
		
	}

	public function get_join_kls($where=array()){
                $get = $this->db->select('kls.id,kls.nama')
                                ->from('tb_kelas kls')
                                ->join('tb_detail_kelas_mapel klsmp','kls.id=klsmp.id_kelas','inner')
                                ->join('tb_kelas_ujian klsuji','kls.id=klsuji.id_kelas','left')
                                ->join('tb_ujian uji','uji.id=klsuji.id_ujian','left')
                                ->where($where)
                                ->group_by('kls.nama')
                                ->get()
                                ->result();
                return $get;
         }

         public function count_join_kls($where=array()){
                $get = count($this->get_join_kls($where));
                return $get;
         }

        public function paginate_join_kelas($page = 1, $where = array(), $limit = 10)
        {
                // get filtered results
                $where = array_merge($where, $this->where);
                $offset = ($page<=1) ? 0 : ($page-1)*$limit;
                $this->db->limit($limit, $offset);
                $results = $this->get_join_kls($where, $limit);
                //echo  $this->db->last_query(); exit;
                // get counts (e.g. for pagination)
                $count_results = count($results);
                $count_total = $this->count_join_kls($where, $limit);
                // $count_total =count($results);
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
