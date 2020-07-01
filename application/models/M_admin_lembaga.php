<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_admin_lembaga extends MY_Model
{
    protected $_table = 'tb_admin_lembaga';
    protected $order_by = array('id','desc');

    public function get_all($where=array()){
    	$get = $this->db->select('akun.*, in.instansi AS nama_instansi')
				    	->from('tb_admin_lembaga akun')
				    	->join('tb_instansi in','in.id = akun.instansi')
				    	->where($where)
				    	->get()
				    	->result();
		return $get;
	}
	
	public function count_by($where=array()){
		return count($this->get_all($where));
	}

}
