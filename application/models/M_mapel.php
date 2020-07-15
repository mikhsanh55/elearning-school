<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_mapel extends MY_Model {

	protected $_table = 'm_mapel';
	protected $order_by = array('id','desc');

	public function __construct()
	{
		parent::__construct();
		
	}

	public function search_detail($where) {
		$get = $this->db->select('dmapel.*, mapel.nama AS nama_mapel, guru.nama AS nama_guru')
						->from('tb_detail_mapel dmapel')
						->join('m_mapel mapel', 'dmapel.id_mapel = mapel.id', 'left')
						->join('m_guru guru', 'dmapel.id_guru = guru.id', 'left')
						->like($where)
						->get()
						->result();

		return $get;
	}

	/*
	* Get mapel and it's teachers based on class and mapel which not already set yet.
	*/
	public function get_detail_all($where) {
		$query1 = $this->db->select('dmapel.*, mapel.nama AS nama_mapel, guru.nama AS nama_guru,guru.username as username_guru')
						->from('m_mapel mapel')
						->join('tb_detail_kelas_mapel dmapel', 'dmapel.id_mapel = mapel.id', 'left')
						->join('m_guru guru', 'dmapel.id_guru = guru.id', 'left')
						->where($where)
						->group_by('mapel.id,guru.id')
						->get()
						->result();

		$query2 = $this->db->query("
			SELECT dmapel.*, mapel.nama AS nama_mapel, mapel.id_instansi, guru.nama AS nama_guru, guru.username AS username_guru
			FROM m_mapel mapel
			LEFT JOIN tb_detail_mapel dmapel ON mapel.id = dmapel.id_mapel
			LEFT JOIN m_guru guru ON guru.id = dmapel.id_guru
			WHERE mapel.id_instansi = ".$this->akun->instansi."
			AND mapel.id NOT IN 
				(SELECT id_mapel FROM tb_detail_kelas_mapel)
			GROUP BY mapel.id, guru.id
		")->result();

		return array_merge($query1, $query2);
	}

	public function get_detail_all_switch($where) {
		$get = $this->db->select('mapel.id, mapel.nama AS nama_mapel, guru.nama AS nama_guru')
						->from('m_mapel mapel')
						->join('tb_detail_mapel dmapel', 'mapel.id = dmapel.id_mapel', 'left')
						->join('m_guru guru', 'guru.id = dmapel.id_guru', 'left')
						->where($where)
						->get()
						->result();
					

		return $get;
	}

	public function count_detail_all($where) {
		return count($this->get_detail_all($where));
	}

	public function count_detail_all_switch($where) {
		return count($this->get_detail_all_switch($where));
	}

	public function paginate_mapel($page = 1, $where = [], $limit = 10) {
		$where = array_merge($where, $this->where);
        $offset = ($page<=1) ? 0 : ($page-1)*$limit;
        $this->db->limit($limit, $offset);
        $results = $this->get_detail_all($where);
        
        $count_results = count($results);
        $count_total = $this->count_detail_all($where);
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

	public function paginate_mapel_switch($page = 1, $where = [], $limit = 10) {
		$where = array_merge($where, $this->where);
        $offset = ($page<=1) ? 0 : ($page-1)*$limit;
        $this->db->limit($limit, $offset);
        $results = $this->get_detail_all_switch($where);
        
        $count_results = count($results);
        $count_total = $this->count_detail_all_switch($where);
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

	public function get_all_mapel_guru($where = []) {
		$query1 = $this->db->select('dmapel.*, mapel.nama AS nama_mapel, mapel.id')
						->from('m_mapel mapel')
						->join('tb_detail_mapel dmapel', 'dmapel.id_mapel = mapel.id', 'left')
						->where($where)
						->group_by('mapel.id')
						->get()
						->result();
		$query2 = $this->db->query("
			SELECT dmapel.*, mapel.nama AS nama_mapel, mapel.id_instansi, mapel.id
			FROM m_mapel mapel
			LEFT JOIN tb_detail_mapel dmapel ON mapel.id = dmapel.id_mapel
			WHERE mapel.id_instansi = ".$this->akun->instansi."
			AND mapel.id NOT IN 
				(SELECT id_mapel FROM tb_detail_mapel)
			GROUP BY mapel.id
		")->result();

		return array_merge($query1, $query2);
	}

	public function count_all_mapel_guru($where = []) {
		return count($this->get_all_mapel_guru($where));
	}

	// Untuk Pilih Mapel di Menu Guru
	public function paginate_mapel_guru($page = 1, $where = [], $limit = 10) {
		$where = array_merge($where, $this->where);
        $offset = ($page<=1) ? 0 : ($page-1)*$limit;
        $this->db->limit($limit, $offset);
        $results = $this->get_all_mapel_guru($where);
        
        $count_results = count($results);
        $count_total = $this->count_all_mapel_guru($where);
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

	function join_kls_mpl($where){
		$get = $this->db->select('mp.id,mp.nama as mapel , klsmp.id_guru , gr.nama as nama_guru')
						->from('m_mapel mp')
						->join('tb_detail_kelas_mapel klsmp','klsmp.id_mapel = mp.id','inner')
						->join('m_guru gr','gr.id = klsmp.id_guru','left')
						->where($where)
						->get()
						->result();
		return $get;
	}

}

/* End of file m_mapel.php */
/* Location: ./application/models/m_mapel.php */