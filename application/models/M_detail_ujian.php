<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_detail_ujian extends MY_Model {

	protected $_table = 'tb_detail_ujian';
	protected $order_by = array('id','asc');

	public function __construct()
	{
		parent::__construct();
		
	}
}