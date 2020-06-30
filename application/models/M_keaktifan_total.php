<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class M_keaktifan_total extends MY_Model {

  protected $_table = 'tb_keaktifan_total';
  protected $order_by = array('id','desc');


  public function __construct()
  {
    parent::__construct();
  }
  // ------------------------------------------------------------------------


  // ------------------------------------------------------------------------
  public function index()
  {
    // 
  }

  // ------------------------------------------------------------------------

}

/* End of file M_keaktifan_total_model.php */
/* Location: ./application/models/M_keaktifan_total_model.php */