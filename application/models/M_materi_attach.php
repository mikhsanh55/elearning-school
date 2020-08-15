<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_materi_attach extends MY_Model 
{
    protected $_table = 'tb_materi_attach';
    protected $order_by = array('id','desc');
}