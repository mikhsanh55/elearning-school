<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_ikut_ujian_essay extends MY_Model {

	protected $_table = 'tb_ikut_ujian_essay';
	protected $order_by = array('id','asc');

	public function __construct()
	{
		parent::__construct();
		
	}

}
