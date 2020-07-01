<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_mapel extends MY_Model {

	protected $_table = 'm_mapel';
	protected $order_by = array('id','asc');

	public function __construct()
	{
		parent::__construct();
		
	}

}

/* End of file m_mapel.php */
/* Location: ./application/models/m_mapel.php */