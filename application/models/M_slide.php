<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_slide extends MY_Model 
{
    protected $_table = 'tb_slider';
    protected $order_by = array('id','asc');
}