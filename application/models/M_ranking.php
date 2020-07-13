<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class M_ranking extends MY_Model {



	protected $_table = 'tb_rank';

	protected $order_by = array('id','desc');



	public function __construct()

	{

		parent::__construct();

		

	}


 
	public function get_relation($where=array())

	{

		$get = $this->db->select('rank.*,sum(rank.skor) as skor,gur.nama as nama_trainer,map.nama as nama_mapel')

						->from('tb_rank rank')

						->join('m_guru gur','gur.id = rank.id_trainer','left')

						->join('m_mapel map','map.id = rank.id_mapel','left')

						->where($where)

						->group_by('rank.id_trainer,rank.id_mapel')

						->order_by('sum(rank.skor)','desc')

						->get()

						->result();

					

		return $get;

	}

	 
	public function get_rank($where=array())

	{

		$get = $this->get_relation($where);

		$i=1;
		$rows = [];
		foreach ($get as $key => $value) {
			$rows[$value->id_trainer.$value->id_mapel] = $i;
			$i++;
		}

		return $rows;

	}



	public function count_join_by($where)

	{

		return count($this->get_relation($where));

	}

	public function paginate($page = 1, $where = array(), $limit = 10)

    {

        // get filtered results

        $where = array_merge($where, $this->where);

        $offset = ($page<=1) ? 0 : ($page-1)*$limit;

        $this->db->limit($limit, $offset);

        $results = $this->get_relation($where);

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
    
    public function get_pdf_many_by($where = array())
    {
        $where = array_merge($where, $this->where);
        
        $results = $this->get_relation($where);
        return $results;
    }



}

