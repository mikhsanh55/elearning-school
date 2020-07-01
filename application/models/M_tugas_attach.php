<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_tugas_attach extends MY_Model {

	protected $_table = 'tb_tugas_attachment';
	protected $order_by = array('id','asc');

	public function __construct()
	{
		parent::__construct();
		
	}

}

/* End of file m_tugas.php */
/* Location: ./application/models/m_tugas_attach.php */