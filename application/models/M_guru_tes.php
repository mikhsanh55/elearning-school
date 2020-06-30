<<<<<<< HEAD
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_guru_tes extends MY_Model {

	protected $_table = 'tr_guru_tes';
	protected $order_by = array('id','desc');

	public function __construct()
	{
		parent::__construct();
		
	}

	public function get_relation($mapel_id){
		$get = $this->db->select("
				tes.*,
				pel.nama nmmapel,
				gur.nama nmguru,
				( SELECT max( nilai ) FROM tr_ikut_ujian WHERE id_tes = tes.id AND id_user = ".$this->session->userdata('admin_konid').") AS hasil 
			")
			->from('tr_guru_tes tes')
			->join('m_mapel pel','tes.id_mapel = pel.id')
			->join('m_guru gur','tes.id_guru = gur.id')
			->where('tes.verifikasi','1')
			->where('md5(pel.id)',$mapel_id)
			->get()
			->result();
		return $get;
	}

	public function get_detail($mapel_id){
		$get = $this->db->select("
				pel.nama as nama_mapel,
				gur.nama as nama_guru 
			")
			->from('tr_guru_tes tes')
			->join('m_mapel pel','tes.id_mapel = pel.id')
			->join('m_guru gur','tes.id_guru = gur.id')
			->where('md5(pel.id)',$mapel_id)
			->get()
			->row();

		return $get;
	}

}

/* End of file M_guru_tes.php */
=======
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_guru_tes extends MY_Model {

	protected $_table = 'tr_guru_tes';
	protected $order_by = array('id','desc');

	public function __construct()
	{
		parent::__construct();
		
	}

	public function get_relation($mapel_id){
		$get = $this->db->select("
				tes.*,
				pel.nama nmmapel,
				gur.nama nmguru,
				( SELECT max( nilai ) FROM tr_ikut_ujian WHERE id_tes = tes.id AND id_user = ".$this->session->userdata('admin_konid').") AS hasil 
			")
			->from('tr_guru_tes tes')
			->join('m_mapel pel','tes.id_mapel = pel.id')
			->join('m_guru gur','tes.id_guru = gur.id')
			->where('tes.verifikasi','1')
			->where('md5(pel.id)',$mapel_id)
			->get()
			->result();
		return $get;
	}

	public function get_detail($mapel_id){
		$get = $this->db->select("
				pel.nama as nama_mapel,
				gur.nama as nama_guru 
			")
			->from('tr_guru_tes tes')
			->join('m_mapel pel','tes.id_mapel = pel.id')
			->join('m_guru gur','tes.id_guru = gur.id')
			->where('md5(pel.id)',$mapel_id)
			->get()
			->row();

		return $get;
	}

}

/* End of file M_guru_tes.php */
>>>>>>> first push
/* Location: ./application/models/M_guru_tes.php */