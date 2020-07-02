<?php
defined('BASEPATH') or exit('No direct script access allowed');

class m_guru extends MY_Model
{
    protected $_table = 'm_guru';
    protected $order_by = array('id','desc');
    
    public function get_by($where=array()){
        $get = $this->db->select('*')
                        ->from($this->_table)
                        ->where($where)
                        ->order_by($this->order_by[0],$this->order_by[1])
                        ->get()
                        ->row();
        return $get;
    }

    public function count_by($where=array()){
        $get = $this->db->select('count(*) as hasil')
                ->from('m_guru guru')
                ->where($where)
                ->order_by($this->order_by[0],$this->order_by[1])
                ->get()
                ->row();

        return $get->hasil;
    }

    public function update($data,$where){
        return $this->db->update($this->_table,$data,$where);
    }

    public function insert($data){
        return $this->db->insert($this->_table,$data);
    }


    public function get_relation($where=array()){
        $get = $this->db->select("
                mp.id,
                mp.nama,
            ")
            ->from('tr_guru_mapel gm')
            ->join('m_guru gur','gm.id_guru = gur.id')
            ->join('m_mapel mp','mp.id = gm.id_mapel')
            ->where($where)
            ->get()
            ->result();
        return $get;
    }

    public function get_all($where = array()) {
        $get = $this->db->select('guru.*, user.password, user.id as user_id, mapel.nama as nama_mapel')
                    ->from('m_guru guru')
                    ->join('m_admin user', 'user.kon_id = guru.id', 'left')
                    ->join('m_mapel mapel', 'guru.id_mapel = mapel.id', 'left')
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

