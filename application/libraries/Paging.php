<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Paging extends CI_Model {
	public function generate_page($paginate=array()){
    	$this->load->view('dashboard/content/pagination', $paginate);
    }
}