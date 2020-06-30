<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_register extends CI_Model
{
    private $table = 'm_siswa';
    public function jumlah($id)
    {
        $this->db->SELECT('id')
                 ->FROM($this->table)
                 ->WHERE(array('nik'=>$id));
        return $this->db->get($this->table)->row();  

    }
    
    public function is_not_duplicate($email) {
        $this->db->where('email', $email);
        $result = $this->db->get($this->table);
        return $result->num_rows();
    }
}
