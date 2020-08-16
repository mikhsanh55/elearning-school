<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Model extends CI_Model
{
    protected $_table;
    protected $order_by = array('id','desc');
    protected $where = array();


    public function get_by($where=array()){
        $get = $this->db->select('*')
                        ->from($this->_table)
                        ->where($where)
                        ->order_by($this->order_by[0],$this->order_by[1])
                        ->get()
                        ->row();
        return $get;
    }

    public function get_by_array($where = []) {
        $get = $this->db->select('*')
                        ->from($this->_table)
                        ->where($where)
                        ->order_by($this->order_by[0],$this->order_by[1])
                        ->get()
                        ->row_array();
        return $get;   
    }

     public function get_many_by($where=array())
    {
   
        $this->db->where($where);
        return $this->get_all();
    }

    public function get_all($where=array()){
        $get = $this->db->select('*')
                        ->from($this->_table)
                        ->where($where)
                        ->order_by($this->order_by[0],$this->order_by[1])
                        ->get()
                        ->result();
        return $get;
    }

    public function count_by($where=array()){
        $get = $this->db->select('count(*) as hasil')
                ->from($this->_table)
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

    public function delete($where){
        return $this->db->delete($this->_table,$where);
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

    public function get_many_wherein($columnName, $where = [], $customeWhere = []) {
        $get = $this->db->select('*')
                        ->from($this->_table)
                        ->where_in($columnName, $where)
                        ->where($customeWhere)
                        ->get()
                        ->result();
        return $get;
    }

    public function delete_wherein($columnName, $where = []) {
        $delete = $this->db->where_in($columnName, $where)->delete($this->_table); 

        return $delete;
    }

}
