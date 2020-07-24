<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_admin extends MY_Model
{
    protected $_table = 'm_admin';
    protected $order_by = array('id','desc');

    public function get_data_by($where = []) {
        $get = '';
        if($this->log_lvl == 'siswa') {
            $get = $this->db->select('admin.*, siswa.username AS usernames')
                            ->from('m_admin admin')
                            ->join('m_siswa siswa', 'admin.kon_id = siswa.id')
                            ->where($where)
                            ->get()
                            ->row();
        }
        else if($this->log_lvl == 'guru') {
            $get = $this->db->select('admin.*, guru.username AS usernames')
                            ->from('m_admin admin')
                            ->join('m_guru guru', 'admin.kon_id = guru.id')
                            ->where($where)
                            ->get()
                            ->row();
        }
        else if($this->log_lvl == 'instansi') {
            $get = $this->db->select('admin.*, akun.username AS usernames')
                            ->from('m_admin admin')
                            ->join('tb_akun_lembaga akun', 'admin.kon_id = akun.id', 'left')
                            ->where($where)
                            ->get()
                            ->row();
        }else{
            $get = $this->db->select('*,user_id as usernames , username as email')
                        ->from('m_admin admin')
                        ->where($where)
                        ->get()
                        ->row();

                      
        }

        return $get;
    }
}
