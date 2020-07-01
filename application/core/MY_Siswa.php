<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require 'vendor/autoload.php';

class MY_Siswa extends CI_Controller {

	public $title;
	public $footer;
	public $logo;
	public $jumlah_pengecekan_ujian_selesai = 2;
	public $total_tes_only;
	public $log_id;
	public $log_lvl;
	public $menu;
	public $get_url;
	public $active_menu;
	public $create_date;
	public $create_time ;
	public $update_date ;
	public $update_time ;
	public $validasi_akses_menu = false;
	public $akun = NULL;



	public function __construct()
	{
		parent::__construct();
	

		$this->create_date = date('Y-m-d');
		$this->create_time = date('H:i:s');
		$this->update_date = date('Y-m-d');
		$this->update_time = date('H:i:s');

	/*	$this->title  = 'E-Learning Management System';
		$this->footer = '&copy; '.date('Y').' E-Learning Management System  All Rights Reserved.';*/

		$this->load->model('m_setting');
		$setting = $this->m_setting->get_by(array('id'=>1));

		$this->title = $setting->judul;
		$this->footer = '&copy; '.date('Y').' '.$setting->footer;
		$this->logo = base_url('assets/img/'.$setting->logo);

		
		$this->total_tes_only = $setting->jumlah_testing;
		$this->jumlah_pengecekan_ujian_selesai = $this->total_tes_only - 1;


		$this->log_id  = $this->session->userdata('admin_konid');
		$this->log_lvl = $this->session->userdata('admin_level');

		if ($this->log_lvl =='siswa') {
			$this->akun = $this->db->select("si.*, in.instansi AS ins")
									->where('si.id',$this->log_id)
									->join('tb_instansi in','in.id = si.instansi')
									->get('m_siswa si')
									->row();
		}else if ($this->log_lvl =='instansi') {
			$this->akun = $this->db->select('si.*,"" as nrp, in.instansi AS ins')
									->where('si.id',$this->log_id)
									->join('tb_instansi in','in.id = si.instansi')
									->get('tb_akun_lembaga si')
									->row();
		}else if($this->log_lvl == 'guru'){
			$this->akun = $this->db->select("*,'' AS ins, nrp ")
			->where('id',$this->log_id)->get('m_guru')->row();
		}else {
			$data = (object) array("nama" => "Administrator", "ins" => "", "nrp"=>"");
			$this->akun = $data;
		}

		
		// if($this->akun->nrp != NULL){
		// 	$data = $this->akun->nrp;
		// 	$this->nrp = $data;
		// }else{
		// 	$this->nrp = "";
		// }

		$this->menu = $this->db->select('menu.id,nama_menu,rule_users.id_level, link, icon')
								->from('rule_users')
								->join('menu','rule_users.id_menu = menu.id','inner')
								->join('level','rule_users.id_level = level.id','inner')
								->where('level',$this->log_lvl)
								->order_by('menu.urutan','asc')
								->get()
								->result_array();


		if (!empty( $this->uri->segment(1) ) )
		{
			$this->get_url .= $this->uri->segment(1);
		}

		if (!empty( $this->uri->segment(2) ) )
		{
			$this->get_url .= '/'.$this->uri->segment(2);
		}

		$sub_menu = $this->db->select('menu.id,nama_menu,rule_users.id_level, link, icon')
								->from('rule_users')
								->join('menu','rule_users.id_menu = menu.id','inner')
								->join('tb_sub_menu sub','sub.id_menu = menu.id','inner')
								->join('level','rule_users.id_level = level.id','inner')
								->where('level',$this->log_lvl)
								->where('sub.sub_menu',$this->get_url)
								->order_by('menu.urutan','asc')
								->get()
								->row();

								//echo $this->db->last_query();exit;
		$this->active_menu = (!empty($sub_menu->id)) ? $sub_menu->id : NULL ;

		if ($this->uri->segment(1) == 'login' ) {

		}else if ($this->uri->segment(1) == 'awal' || $this->uri->segment(1) == 'lupa_password' ) {
			
		}else{

			if (empty($this->session->userdata('admin_konid'))) {
				redirect(base_url('login'),'refresh');
				exit;
			}
			if ($this->validasi_akses_menu == true) {

				if ($this->uri->segment(1) != 'adm' ){
					if (empty($this->active_menu)) {
						redirect(base_url('login'),'refresh');
						exit;
					}
				}
			}
			

		}
		
	}
	function getClient(){
		//var def uri segment
		$uri1 = $this->uri->segment(1);
		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		header( "Access-Control-Allow-Origin: *" );
		$client = new Google_Client();
		$client->setApplicationName('Google Calendar API PHP Quickstart');
		$client->setScopes(Google_Service_Calendar::CALENDAR);
		$client->setAuthConfig('credentials.json');
		$client->setAccessType('offline');
		$client->setPrompt('select_account consent');
	
		$tokenPath = 'token.json';
		if (file_exists($tokenPath)) {
			$accessToken = json_decode(file_get_contents($tokenPath), true);
			$client->setAccessToken($accessToken);
		}
		if ($client->isAccessTokenExpired()) {
			if ($client->getRefreshToken()) {
				$client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
			} else {
			// if($uri3 == NULL){
			// 	$authUrl = $client->createAuthUrl();
			// 	redirect($authUrl);
			// }
			$authCode = trim('4/yAEEwfkVupL579X0lGxkRYmuXy_gOByPpNdacfPtm7nhOhiUHwR1o7VX4pWS5Friv0fL9B-z2q0VumGw77NpqlY');
				$accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
				$client->setAccessToken($accessToken);
	
				if (array_key_exists('error', $accessToken)) {
					throw new Exception(join(', ', $accessToken));
				}
			}
			if (!file_exists(dirname($tokenPath))) {
				mkdir(dirname($tokenPath), 0700, true);
			}
			file_put_contents($tokenPath, json_encode($client->getAccessToken()));
		}
		return $client;
	}

	public function insertCalendar($ket, $start_date, $start_time, $end_date, $end_time){
		$client = $this->getClient();
		$service = new Google_Service_Calendar($client);

		$event = new Google_Service_Calendar_Event([
			'kind'              => 'calendar#calendarListEntry',
			'summary'           => 'Diskusi Kepemimpinan',
			'location'          => base_url(),
			'sendNotifications' => TRUE,
			'sendUpdates'       => 'all',
			'description'       => $ket,
			'backgroundColor'   => '#FFD700',
			'foregroundColor'   => '#FF0000',
			'start' => [
			'dateTime' => $start_date.'T'.$start_time.':00-00:00',
			'timeZone' => 'Asia/Jakarta',
			],
			'end' => [
			'dateTime' => $end_date.'T'.$end_time.':00-00:00',
			'timeZone' => 'Asia/Jakarta',
			],
			'recurrence' => [
			'RRULE:FREQ=DAILY;COUNT=1'
			],
			'attendees' => [
			['email' => 'dwisurdiana88@gmail.com'],
			//   array('email' => 'rezharanmark@gmail.com'),
			],
			'reminders' => [
			'useDefault' => FALSE,
			'overrides' => [
				['method' => 'email', 'minutes' => 5],
				['method' => 'popup', 'minutes' => 10],
				],
			],
			]);
		
		$calendarId = 'primary';
		$event = $service->events->insert($calendarId, $event);
		//   printf('Event created: %s\n', $event->htmlLink);
	}

	public function render($content=null, $data = NULL){

		$data['header'] 	= $this->load->view('content/header', $data, TRUE);
		$data['navbar'] 	= $this->load->view('content/navbar', $data, TRUE);
        $data['content'] 	= $this->load->view($content, $data, TRUE);
        $data['foot_new'] 	= $this->load->view('foot_new', $data, TRUE);
		$data['footer'] 	= $this->load->view('template/footer', $data, TRUE);

        $this->load->view('dashboard/index', $data);
    }

    public function generate_page($paginate=array()){
    	$this->load->view('dashboard/content/pagination', $paginate);
    }

}