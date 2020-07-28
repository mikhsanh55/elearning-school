<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_admin_detail extends MY_Model 
{
    protected $_table = 'm_admin_detail';
    protected $order_by = array('id','desc');
}