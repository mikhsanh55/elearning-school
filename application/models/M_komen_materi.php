<<<<<<< HEAD
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_komen_materi extends MY_Model {

	protected $_table = 'tb_komen_materi';
	protected $order_by = array('id','asc');

	public function __construct()
	{
		parent::__construct();
		
	}

	 public function get_all($where=array()){
        $get = $this->db->select('
					        *,
							IF(id_trainer <> 0,(SELECT nama FROM m_guru WHERE id = komen.id_trainer),(SELECT nama FROM m_siswa WHERE id = komen.id_siswa)) as nama_lengkap
					    ')
                        ->from($this->_table.' komen')
                        ->where($where)
                        ->order_by($this->order_by[0],$this->order_by[1])
                        ->get()
                        ->result();
        return $get;
    }

    public function get_group($where=array(),$group=array()){
         $get = $this->db->select('
                                *
                        ')
                        ->from($this->_table.' km1')
                        ->where($where)
                        ->group_by($group)
                        ->get()
                        ->result();

                        
        return $get;
    }

    public function check_komen_all($where=array(),$group=array()){
    	 $get = $this->db->select('
					    	 	km1.id_siswa as peserta1,
					    	 	km2.id_siswa as peserta2,
					    	 	km1.id_trainer as trainer1,
					    	 	km2.id_trainer as trainer2
					    ')
                        ->from($this->_table.' km1')
                        ->join($this->_table.' km2','km2.id_head = km1.id','left')
                        ->where($where)
                        ->group_by($group)
                        ->get()
                        ->result();

                        
        return $get;
    }

    public function rank(){
        $get = $this->db->select('sis.id,
                                  sis.nama,
                                  count( id_siswa ) AS total ')
                        ->from('tb_komen_materi mt')
                        ->join('m_siswa sis','sis.id = mt.id_siswa','inner')
                        ->where('id_siswa <>',0)
                        ->group('id_siswa')
                        ->get()
                        ->result();
        return $get;
    }

}

/* End of file m_komen_materi.php */
=======
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_komen_materi extends MY_Model {

	protected $_table = 'tb_komen_materi';
	protected $order_by = array('id','asc');

	public function __construct()
	{
		parent::__construct();
		
	}

	 public function get_all($where=array()){
        $get = $this->db->select('
					        *,
							IF(id_trainer <> 0,(SELECT nama FROM m_guru WHERE id = komen.id_trainer),(SELECT nama FROM m_siswa WHERE id = komen.id_siswa)) as nama_lengkap
					    ')
                        ->from($this->_table.' komen')
                        ->where($where)
                        ->order_by($this->order_by[0],$this->order_by[1])
                        ->get()
                        ->result();
        return $get;
    }

    public function get_group($where=array(),$group=array()){
         $get = $this->db->select('
                                *
                        ')
                        ->from($this->_table.' km1')
                        ->where($where)
                        ->group_by($group)
                        ->get()
                        ->result();

                        
        return $get;
    }

    public function check_komen_all($where=array(),$group=array()){
    	 $get = $this->db->select('
					    	 	km1.id_siswa as peserta1,
					    	 	km2.id_siswa as peserta2,
					    	 	km1.id_trainer as trainer1,
					    	 	km2.id_trainer as trainer2
					    ')
                        ->from($this->_table.' km1')
                        ->join($this->_table.' km2','km2.id_head = km1.id','left')
                        ->where($where)
                        ->group_by($group)
                        ->get()
                        ->result();

                        
        return $get;
    }

    public function rank(){
        $get = $this->db->select('sis.id,
                                  sis.nama,
                                  count( id_siswa ) AS total ')
                        ->from('tb_komen_materi mt')
                        ->join('m_siswa sis','sis.id = mt.id_siswa','inner')
                        ->where('id_siswa <>',0)
                        ->group('id_siswa')
                        ->get()
                        ->result();
        return $get;
    }

}

/* End of file m_komen_materi.php */
>>>>>>> first push
/* Location: ./application/models/m_komen_materi.php */