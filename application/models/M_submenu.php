<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_submenu extends MY_Model 
{
    protected $_table = 'sub_menu';
    protected $order_by = array('urutan','asc');
}