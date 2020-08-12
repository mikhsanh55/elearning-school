<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_ikut_ujian_essay extends MY_Model {

	protected $_table = 'tb_ikut_ujian_essay';
	protected $order_by = array('id','desc');

	public function __construct()
	{
		parent::__construct();
		
	}

	public function get_all($where = []) {
		$get = $this->db->select("hasilessay.*, siswa.nama as nama_siswa, kls.nama as nama_kelas")
						->from('tb_ikut_ujian_essay hasilessay')
						->join('m_siswa siswa', 'hasilessay.id_user = siswa.id', 'inner')
						->join('tb_detail_kelas dkls', 'dkls.id_peserta = siswa.id', 'inner')
						->join('tb_kelas kls', 'kls.id = dkls.id_kelas', 'inner')
						->where($where)
						->get()
						->result();

		return $get;
	}

	public function count_by($where = []) {
		return count($this->get_all($where));
	}
}
