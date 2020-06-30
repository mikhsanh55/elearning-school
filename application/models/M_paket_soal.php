<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class M_paket_soal extends MY_Model {

  protected $_table = 'tb_paket_soal';
	protected $order_by = array('id','asc');

  public function __construct()
  {
    parent::__construct();
  }

}