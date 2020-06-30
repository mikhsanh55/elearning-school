<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Keaktifan_off_model extends MY_Model {

  protected $_table = 'tb_keaktifan_offline';
  protected $order_by = array('id','desc');


  public function __construct()
  {
    parent::__construct();
  }


  public function get_join($where=array())
  {
      $get = $this->db->select('
                  dekls.id_kelas,
                  dekls.id_peserta,
                  sis.nama,
                  sis.nrp,
                  off.id as id_keatifan,
                  off.nilai
               ')
               ->from('tb_kelas kls')
               ->join('tb_detail_kelas dekls','dekls.id_kelas = kls.id','inner')
               ->join('m_siswa sis','sis.id = dekls.id_peserta','inner')
               ->join('tb_keaktifan_offline off','off.id_kelas = kls.id AND dekls.id_peserta = off.id_siswa','left')
               ->where($where)
               ->get()
               ->result();
        return $get;

  }

  public function count_join_by($where=array())
  {
      $get = count($this->get_join($where));
       return $get;
  }


  public function paginate($page = 1, $where = array(), $limit = 10)
    {
        // get filtered results
        $where = array_merge($where, $this->where);
        $offset = ($page<=1) ? 0 : ($page-1)*$limit;
        $this->db->limit($limit, $offset);
        $results = $this->get_join($where);
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

/* End of file Keaktifan_model.php */
/* Location: ./application/models/Keaktifan_model.php */