<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_materi_instansi extends MY_Model {

	protected $_table = 'tb_materi_instansi';
	protected $order_by = array('id','asc');

	public function __construct()
	{
		parent::__construct();
		
	}

}

/* End of file m_perusahaan.php */
/* Location: ./application/models/m_perusahaan.php */