<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_rank extends MY_Model {

	protected $_table = 'tb_komen_materi';
	protected $order_by = array('id','asc');

	public function __construct()
	{
		parent::__construct();
		
	}

	public function get_all($where=array()){
		 $get = $this->db->select('
							 			sis.id,
										sis.nama,
										count( id_siswa ) AS jumlah,
										( SELECT count( mt2.id_siswa ) AS count FROM tb_komen_materi mt2 WHERE mt2.id_siswa <> 0 ) AS total,
    ( SELECT id_guru FROM tr_guru_mapel grm INNER JOIN `m_guru` `gr` ON `gr`.`id` = `grm`.`id_guru` LIMIT 1 ) AS id_guru,
    ( SELECT gr.nama FROM tr_guru_mapel grm INNER JOIN `m_guru` `gr` ON `gr`.`id` = `grm`.`id_guru` LIMIT 1 ) AS nama_guru 
		 				')
                        ->from('tb_komen_materi mt')
                        ->join('m_siswa sis','sis.id = mt.id_siswa','inner')
                        ->join('m_materi mm','mm.id = mt.id_materi','inner')
                        ->where('id_siswa <>',0)
                        ->order_by('count( id_siswa )','desc')
                        ->group_by('id_siswa')
                        ->get()
                        ->result();

      
		return $get;
	}

	public function count_join_by($where=array()){
	 	$this->db->where($where);
        $get = $this->get_all();
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
        $count_total = $this->count_join_by($where);
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

/* End of file M_rank.php */
/* Location: ./application/models/M_rank.php */