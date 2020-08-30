<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_detail_materi extends MY_Model 
{
    protected $_table = 'tb_detail_materi';
    protected $order_by = array('id','desc');
}