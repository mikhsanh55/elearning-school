<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class M_jurusan extends MY_Model {

  protected $_table = 'tb_jurusan';
	protected $order_by = array('id','asc');

  public function __construct()
  {
    parent::__construct();
  }

  public function get_all($where=array()){
    $get = $this->db->select('jurus.*, in.instansi AS nama_instansi')
            ->from('tb_jurusan jurus')
            ->join('tb_instansi in','in.id = jurus.id_instansi')
            ->where($where)
            ->get()
            ->result();
  return $get;
  }

}

/* End of file M_jurusan.php */
/* Location: ./application/models/M_jurusan.php */