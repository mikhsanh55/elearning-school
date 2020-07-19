<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class M_detail_kelas extends MY_Model {

 
	protected $_table = 'tb_detail_kelas';
	protected $order_by = array('id','desc');

	public function __construct()
	{
		parent::__construct();
		
	}

	public function get_all($where=array()){
		$get = $this->db->select('
							dk.*,
							sis.nama as nama_siswa,
							sis.nrp,
							sis.email
						')
		->from('tb_detail_kelas dk')
		->join('m_siswa sis','sis.id=dk.id_peserta','left')
		->order_by('sis.nama','asc')
		->where($where)
		->get()
		->result();

		return $get;
	}

	public function get_siswa($where = []) {
		$get = $this->db->select('
							dk.*,
							sis.nama as nama_siswa,
							sis.nrp,
							sis.email,
							kls.nama as nama_kelas
						')
		->from('tb_detail_kelas dk')
		->join('tb_kelas kls', 'dk.id_kelas = kls.id', 'inner')
		->join('m_siswa sis','sis.id=dk.id_peserta','left')
		->order_by('sis.nama','asc')
		->where($where)
		->get()
		->row();

		return $get;
	}

	public function count_by($where=array()){
		$get = $this->db->select('
							dk.id
						')
		->from('tb_detail_kelas dk')
		->join('m_siswa sis','sis.id=dk.id_peserta','left')
		->order_by('sis.nama','asc')
		->where($where)
		->get()
		->result();
	
      
		return count($get);
	}

}

/* End of file M_detail_kelas_model.php */
/* Location: ./application/models/M_detail_kelas_model.php */