<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class M_detail_mapel extends MY_Model {
	protected $_table = 'tb_detail_mapel';
	protected $order_by = array('id','desc');

	public function __construct() {
		parent::__construct();
	}

	public function get_all($where = []) {
		$get = $this->db->select('dmapel.*, mapel.nama AS nama_mapel, guru.nama AS nama_guru')
						->from('tb_detail_mapel dmapel')
						->join('m_mapel mapel', 'dmapel.id_mapel = mapel.id')
						->join('m_guru guru', 'dmapel.id_guru = guru.id')
						->where($where)
						->get()
						->result();

		return $get;
	}
}