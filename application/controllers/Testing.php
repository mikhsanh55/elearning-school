<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Testing extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('PDF2Text');
	}
 
	public function index()
	{	
		echo '<a href="'.base_url('login/logout').'">logout</a>';
	}

	public function arrays(){
		$data = array(
        array(
                'title' => 'My title',
                'name' => 'My Name',
                'date' => 'My date'
        ),
        array(
                'title' => 'Another title',
                'name' => 'Another Name',
                'date' => 'Another date'
        )
);

		echo "<pre>";
		print_r($data);
	}

}

/* End of file Testing.php */
/* Location: ./application/controllers/Testing.php */