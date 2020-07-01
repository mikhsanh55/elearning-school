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


}
