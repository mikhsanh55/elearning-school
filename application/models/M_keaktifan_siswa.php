<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_keaktifan_siswa extends MY_Model 
{
    protected $_table = 'tb_keaktifan_siswa';
    protected $order_by = array('id','desc');

    public function getSumKeaktifan($where = [])
    {
    	$get = $this->db->select('aktif.type, COUNT(*) as sum')
    					->from('tb_keaktifan_siswa aktif')
    					->where($where)
    					->get()
    					->row();
    	return $get;
    }
}