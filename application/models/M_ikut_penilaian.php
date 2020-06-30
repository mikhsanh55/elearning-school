<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_ikut_penilaian extends MY_Model {

	protected $_table = 'tb_ikut_penilaian';
	protected $order_by = array('id','asc');

	public function __construct()
	{
		parent::__construct();
		
	}

	public function get_many_by_id_penilaian($where=array()){
        $get = $this->db->select('*')
                ->from($this->_table)
                ->where($where)
                ->order_by($this->order_by[0],$this->order_by[1])
                ->get();

        return $get;
    }
}
