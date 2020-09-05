<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_tugas_alert extends MY_Model 
{
    protected $_table = 'tb_tugas_alert';
    protected $order_by = array('id','desc');
}