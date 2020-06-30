<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_jawaban_essay extends MY_Model {

	protected $_table = 'tb_jawaban_essay';
	protected $order_by = array('id','asc');

	public function __construct()
	{
		parent::__construct();
		
	}

}
