<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_notif_forum extends MY_Model {

	protected $_table = 'tb_notifikasi_forum';
	protected $order_by = array('id','asc');

	public function __construct()
	{
		parent::__construct();
		
	}

	public function get_all($where=array())
	{
		$get = $this->db->select("
								nf.*,
								ma.title,
								CASE sender_lvl
								WHEN 'siswa' THEN
									(SELECT nama FROM m_siswa WHERE id = sender_id)
								ELSE
									(SELECT nama FROM m_guru WHERE id = sender_id)
								END as nama_pengirim
						")
						->from('tb_notifikasi_forum nf')
						->join('m_materi ma','ma.id=nf.id_materi','left')
						->where($where)
						->get()
						->result();
		return $get;
	}

	public function count_by($where=array())
	{
		return count($this->get_all($where));
	}

}

/* End of file m_mapel.php */
/* Location: ./application/models/m_mapel.php */