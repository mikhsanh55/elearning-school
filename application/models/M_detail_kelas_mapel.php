<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class M_detail_kelas_mapel extends MY_Model {
	protected $_table = 'tb_detail_kelas_mapel';
	protected $order_by = array('id','desc');

	public function __construct()
	{
		parent::__construct();
		
	}

	public function get_all($where = [])
	{
		$get = $this->db->select('dklsmapel.*, mapel.nama AS nama_mapel, guru.nama AS nama_guru, kls.nama AS nama_kelas')
						->from('tb_detail_kelas_mapel dklsmapel')
						->join('m_mapel mapel', 'dklsmapel.id_mapel = mapel.id', 'inner')
						->join('m_guru guru', 'dklsmapel.id_guru = guru.id', 'inner')
						->join('tb_kelas kls', 'dklsmapel.id_kelas = kls.id', 'inner')
						->where($where)
						->get()
						->result();
		return $get;
	}
}