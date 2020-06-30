<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_jadwal extends MY_Model {

	protected $_table = 'tb_jadwal';
	protected $order_by = array('id','asc');

	public function __construct()
	{
		parent::__construct();
		
	}

	 public function get_all($where=array()){
        $get = $this->db->select("
                jwl.*,
				gr.nama as nama_guru,
				mp.nama as nama_mp,
				mt.title as nama_materi
            ")
            ->from('`tb_jadwal` jwl')
            ->join('tb_kelas kls','kls.id=jwl.id_kelas')
            ->join('m_guru gr','gr.id = kls.id_trainer')
            ->join('m_mapel mp','mp.id = kls.id_mapel','left')
            ->join('m_materi mt','mt.id = jwl.id_materi','left')
            ->where($where)
            ->get()
            ->result();

        return $get;
    }
    
     public function get_all_siswa($where=array()){
        $get = $this->db->select("
                jwl.*,
				gr.nama as nama_guru,
				mp.nama as nama_mp,
				mt.title as nama_materi
            ")
            ->from('`tb_jadwal` jwl')
            ->join('tb_kelas kls','kls.id=jwl.id_kelas')
            ->join('tb_detail_kelas dekls','kls.id=dekls.id_kelas')
            ->join('m_guru gr','gr.id = kls.id_trainer')
            ->join('m_mapel mp','mp.id = kls.id_mapel','left')
            ->join('m_materi mt','mt.id = jwl.id_materi','left')
            ->where($where)
            ->get()
            ->result();

        return $get;
    }


     public function get_count_join($where=array()){
         if($this->log_lvl == 'siswa'){
              return count($this->get_all_siswa($where));
         }else{
              return count($this->get_all($where));
         }
       
    }

     public function get_kalender($where=array()){
        $get = $this->db->select("
                jwl.*,
                gr.nama as nama_guru,
                mp.nama as nama_mp,
                mt.title as nama_materi
            ")
            ->from('`tb_jadwal` jwl')
            ->join('tb_kelas kls','kls.id=jwl.id_kelas','left')
            ->join('tb_detail_kelas dekls','kls.id=dekls.id_kelas','left')
            ->join('m_guru gr','gr.id = kls.id_trainer')
            ->join('m_mapel mp','mp.id = kls.id_mapel','left')
            ->join('m_materi mt','mt.id = jwl.id_materi','left')
          
            ->where($where)
            ->get()
            ->result();
        return $get;
    }


    public function get_by($where=array()){
        $get = $this->db->select("
                jwl.*,
                gr.nama as nama_guru,
                mp.nama as nama_mp,
                mt.title as nama_materi
            ")
            ->from('`tb_jadwal` jwl')
            ->join('tb_kelas kls','kls.id=jwl.id_kelas')
            ->join('tb_detail_kelas dekls','kls.id=dekls.id_kelas')
            ->join('m_guru gr','gr.id = kls.id_trainer')
            ->join('m_mapel mp','mp.id = kls.id_mapel','left')
            ->join('m_materi mt','mt.id = jwl.id_materi','left')
            ->where($where)
            ->get()
            ->row();
        return $get;
    }

     public function paginate($page = 1, $where = array(), $limit = 10)
    {
        // get filtered results
        $where = array_merge($where, $this->where);
        $offset = ($page<=1) ? 0 : ($page-1)*$limit;
        $this->db->limit($limit, $offset);
         if($this->log_lvl == 'siswa'){
             $results = $this->get_all_siswa($where);
         }else{
             $results = $this->get_all($where);
         }
        
        //echo  $this->db->last_query(); exit;
        // get counts (e.g. for pagination)
        $count_results = count($results);
        $count_total = $this->get_count_join($where);
        $total_pages = ceil($count_total / $limit);
        $counts = array(
            'from_num'      => ($count_results==0) ? 0 : $offset + 1,
            'to_num'        => ($count_results==0) ? 0 : $offset + $count_results,
            'total_num'     => $count_total,
            'curr_page'     => $page,
            'total_pages'   => ($count_results==0) ? 1 : $total_pages,
            'limit'         => $limit,
        );

        return array('data' => $results, 'counts' => $counts);
    }

}

/* End of file M_jadwal.php */
/* Location: ./application/models/M_jadwal.php */