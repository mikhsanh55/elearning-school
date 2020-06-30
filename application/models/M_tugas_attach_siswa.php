<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_tugas_attach_siswa extends MY_Model {

	protected $_table = 'tb_tugas_attachment_siswa';
	protected $order_by = array('id','asc');

	public function __construct()
	{
		parent::__construct();
		
	}

	public function get_first_row($where) {
		return $this->db->select('*')
						->from($this->_table)
						->where($where)
						->order_by('id', 'asc')
						->get()->row();
	}

}

/* End of file m_tugas_attach_siswa.php */
/* Location: ./application/models/m_tugas_attach_siswa.php */