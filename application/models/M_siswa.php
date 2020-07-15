<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_siswa extends MY_Model
{
    protected $_table = 'm_siswa';
    protected $order_by = array('id','desc');

    public function get_all($where = []) {
        $get = $this->db->select('akun.*, in.instansi AS nama_instansi, user.id as user_id, user.password, dkls.id_kelas')
                        ->from('m_siswa akun')
                        ->join('tb_detail_kelas dkls', 'akun.id = dkls.id_peserta', 'left')
                        ->join('tb_instansi in','akun.instansi = in.id','left')
                        ->join('m_admin user', 'akun.id = user.kon_id', 'left')
                        ->where($where)
                        ->get()
                        ->result();
        return $get;
    }

    /*
    *  Get Siswa based on its class and siswa which not have class
    *
    */
    public function get_siswa_not_class($where=array()){
        // Get siswa berdasarkan
    	$query1 = $this->db->select('akun.*, in.instansi AS nama_instansi, user.id as user_id, user.password, dkls.id_kelas')
				    	->from('m_siswa akun')
                        ->join('tb_detail_kelas dkls', 'akun.id = dkls.id_peserta', 'left')
				    	->join('tb_instansi in','akun.instansi = in.id','left')
                        ->join('m_admin user', 'akun.id = user.kon_id', 'left')
                        ->where($where)
                        ->group_by('akun.id')
                        ->get()
				    	->result();

		return $query1;
    }

    public function count_by_siswa_not_class($where = []) {

        $query1 = $this->db->select('akun.*, in.instansi AS nama_instansi, user.id as user_id, user.password, dkls.id_kelas')
                        ->from('m_siswa akun')
                        ->join('tb_detail_kelas dkls', 'akun.id = dkls.id_peserta', 'left')
                        ->join('tb_instansi in','akun.instansi = in.id','left')
                        ->join('m_admin user', 'akun.id = user.kon_id', 'left')
                        ->where($where)
                        ->group_by('akun.id')
                        ->get()
                        ->result();
        
        return count($query1);
    }

    /*
    * Get Count of $this->count_by_siswa_not_class($where = [])
    *
    */
    public function count_by_cs($where=array()){
    	$get = $this->db->select('akun.*, in.instansi AS nama_instansi, user.id as user_id, user.password, dkls.id_kelas')
                        ->from('m_siswa akun')
                        ->join('tb_detail_kelas dkls', 'akun.id = dkls.id_peserta', 'left')
                        ->join('tb_instansi in','akun.instansi = in.id','left')
                        ->join('m_admin user', 'akun.id = user.kon_id', 'left')
                        ->where($where)
                        ->get()
                        ->result();
		return count($get);
    }

    /*
    *  Get Data of $this->count_by_siswa_not_class() and $this->count_by_siswa_not_class
    */
    public function paginate_siswa_not_class($page = 1, $where = array(), $limit = 10)
    {
        // get filtered results
        $where = array_merge($where, $this->where);
        $offset = ($page<=1) ? 0 : ($page-1)*$limit;
        $this->db->limit($limit, $offset);
        $results = $this->get_siswa_not_class($where, $limit);
        //echo  $this->db->last_query(); exit;
        // get counts (e.g. for pagination)
        $count_results = count($results);
        $count_total = $this->count_by_siswa_not_class($where, $limit);
        // $count_total =count($results);
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

    public function paginate($page = 1, $where = array(), $limit = 10)
    {
        // get filtered results
        $where = array_merge($where, $this->where);
        $offset = ($page<=1) ? 0 : ($page-1)*$limit;
        $this->db->limit($limit, $offset);
        $results = $this->get_all($where);
        //echo  $this->db->last_query(); exit;
        // get counts (e.g. for pagination)
        $count_results = count($results);
        $count_total = $this->count_by_cs($where);
        // $count_total =count($results);
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

     public function get_kelas($where=array()){
        $get = $this->db->select('kls.*,
                                    sis.id as id_siswa,
                                    sis.nama,
                                    sis.nrp,
                                    sis.email,
                                    gur.nama as nama_guru,
                                    mpl.nama as nama_mapel
                        ')
                        ->from('tb_kelas kls')
                        ->join('M_siswa sis','sis.id = kls.id_peserta')
                        ->join('m_guru gur','kls.id_trainer = gur.id','left')
                          ->join('m_mapel mpl','kls.id_mapel = mpl.id','left')
                        ->where($where)
                        ->get()
                        ->result();
        return $get;
    }

    public function count_by_kelas($where=array()){
        $get = $this->get_kelas($where);
        return count($get);
    }

     public function paginate_kelas($page = 1, $where = array(), $limit = 10)
    {
        // get filtered results
        $where = array_merge($where, $this->where);
        $offset = ($page<=1) ? 0 : ($page-1)*$limit;
        $this->db->limit($limit, $offset);
        $results = $this->get_kelas($where);
        //echo  $this->db->last_query(); exit;
        // get counts (e.g. for pagination)
        $count_results = count($results);
        $count_total = $this->count_by_kelas($where);
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

    public function get_kelas_by($where = []) {
        $get = $this->db->select('akun.*, dkls.id_kelas')
                        ->from('m_siswa akun')
                        ->join('tb_detail_kelas dkls', 'akun.id = dkls.id_peserta', 'inner')
                        ->where($where)
                        ->get()
                        ->row();
        return $get;
    }

}
