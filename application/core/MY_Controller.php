<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//require 'vendor/autoload.php';

class MY_Controller extends CI_Controller
{

	public $title;
	public $footer;
	public $logo;
	public $video_beranda;
	public $jumlah_pengecekan_ujian_selesai = 2;
	public $total_ujian = 1;
	public $total_tes_only;
	public $log_id;
	public $log_lvl;
	public $menu;
	public $get_url;
	public $active_menu;
	public $sub_menu;
	public $create_date;
	public $create_time;
	public $update_date;
	public $update_time;
	public $page_title;
	public $validasi_akses_menu = false;
	public $akun = NULL;
	public $theme = 'tni';
	public $transTheme;
	public $backButton;
	public $id_level;

	/*
	* Untuk update keaktifan user
	*/
	public function updateActiveUser($level, $type_active) {
		$level = $this->convertLevel($level);
		$update = NULL; $data_update = NULL;

		if($level === 3) {
			$data_update = $this->m_siswa->get_by_array(['id' => $this->session->userdata('admin_konid')]) ?? NULL;
			$update = $this->m_siswa->update([
					$type_active => $data_update[$type_active] + 1
				], ['id' => $this->session->userdata('admin_konid')]);
			

		}
		else if($level === 2) {
			$data_update = $this->m_guru->get_by_array(['id' => $this->session->userdata('admin_konid')]) ?? NULL;
			$update = $this->m_guru->update([
				$type_active => $data_update[$type_active] + 1
			], ['id' => $this->session->userdata('admin_konid')]);

		}

		// Check it works
		if($update) {
			$this->sendAjaxResponse([
				'status' => TRUE,
				'msg' => 'Data ' . $type_active . ' berhasil update'
			], 200);
		}
		else {
			$this->sendAjaxResponse([
				'status' => FALSE,
				'msg' => 'Data ' . $type_active . ' gagal update'
			], 500);
		}
	}

	/*
	* Untuk convert level ke int
	*/
	protected function convertLevel($level) {
		$return_level = 1;
		switch($level) {
			case 'admin' :
				$return_level = 1;
			break;
			case 'guru' :
				$return_level = 2;
			break;
			case 'siswa' :
				$return_level = 3;
			break;
			case 'instansi' :
				$return_level = 4;
			break;
			case 'admin_instansi' :
				$return_level = 5;
			break;
		}

		return intval($return_level);
	}

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->dbforge();
		// Alter table
		// $fields = [
		// 	'status_ujian' => ['type' => 'TINYINT']
		// ];
		// $this->dbforge->add_column('tb_ikut_ujian', $fields);

		// $fields = [
		// 	'status_ujian' => ['type' => 'TINYINT']
		// ];
		// $this->dbforge->add_column('tb_ikut_ujian_essay', $fields);



		if(!is_dir('./upload/file_jawaban_essay/')) {
			@mkdir('./upload/file_jawaban_essay/');
		}
		
		$this->load->model('m_instansi');
		$this->backButton = '<button class="btn btn-light text-right" onclick="history.back()">Kembali</button>';
		if ($this->uri->segment(1) == 'login') {
		} else if ($this->uri->segment(1) == 'awal' || $this->uri->segment(1) == 'lupa_password') {
		} else {

			if (empty($this->session->userdata('admin_konid'))) {
				redirect(base_url('login'), 'refresh');
				exit;
			}
		} 

		$this->create_date = date('Y-m-d');
		$this->create_time = date('H:i:s');
		$this->update_date = date('Y-m-d');
		$this->update_time = date('H:i:s');

		$this->transTheme = translate_theme($this->theme);

		/*	$this->title  = 'E-Learning Management System';
		$this->footer = '&copy; '.date('Y').' E-Learning Management System  All Rights Reserved.';*/

		$this->load->model('m_setting');
		$this->load->model('m_setting_instansi');
		$this->load->model('m_siswa');
		$this->load->model('m_detail_kelas');
		$this->load->model('m_mapel');
		$this->load->model('m_submenu');

		$this->log_id  = $this->session->userdata('admin_konid');
		$this->log_lvl = $this->session->userdata('admin_level');

		if ($this->log_lvl == 'siswa') {
			$this->akun = $this->db->select("si.*, in.instansi AS ins")
				->where('si.id', $this->log_id)
				->join('tb_instansi in', 'in.id = si.instansi')
				->get('m_siswa si')
				->row();
		} else if ($this->log_lvl == 'instansi') {
			$this->akun = $this->db->select('si.*,"" as nrp, in.instansi AS ins')
				->where('si.id', $this->log_id)
				->join('tb_instansi in', 'in.id = si.instansi')
				->get('tb_akun_lembaga si')
				->row();
		} else if ($this->log_lvl == 'admin_instansi') {
			$this->akun = $this->db->select('si.*,"" as nrp, in.instansi AS ins')
				->where('si.id', $this->log_id)
				->join('tb_instansi in', 'in.id = si.instansi')
				->get('tb_admin_lembaga si')
				->row();
		} else if ($this->log_lvl == 'guru') {
			$this->akun = $this->db->select("*,'' AS ins, nrp ")
				->where('id', $this->log_id)->get('m_guru')->row();
		} else {
			$data = (object) array("nama" => "Administrator", "instansi" => 0, "nrp" => "", "username" => "Admin");
			$this->akun = $data;
		}


		if ($this->uri->segment(1) != 'login') {
			if ($this->log_lvl == 'admin') {
				$setting = $this->m_setting->get_by(array('id' => 1));

				$this->title = $setting->judul;
				$this->footer = '&copy; ' . date('Y') . ' ' . $setting->footer;
				$this->logo = base_url('assets/img/' . $setting->logo);


				$this->total_tes_only = $setting->jumlah_testing;
				$this->jumlah_pengecekan_ujian_selesai = $this->total_tes_only - 1;
			} else {

				if (empty($this->session->userdata('admin_konid'))) {
					$setting = $this->m_setting->get_by(array('id' => 1));

					$this->title = $setting->judul;
					$this->footer = '&copy; ' . date('Y') . ' ' . $setting->footer;
					$this->logo = base_url('assets/img/' . $setting->logo);


					$this->total_tes_only = $setting->jumlah_testing;
					$this->jumlah_pengecekan_ujian_selesai = $this->total_tes_only - 1;
				} else {
					$setting = $this->m_setting_instansi->get_by(array('id_instansi' => $this->akun->instansi));

					$footer = (empty($setting->footer)) ? NULL : $setting->footer;
					$logo = (empty($setting->logo)) ? NULL : $setting->logo;
					$video = (empty($setting->video)) ? NULL : $setting->video;
					$this->title = (empty($setting->judul)) ? 'E-Learning TNI AL' : $setting->judul;
					$this->footer = '&copy; ' . date('Y') . ' ' . $footer;
					$this->logo = $logo === NULL ? base_url('assets/img/default-logo.png') : base_url('assets/logo/' . $logo);
					$this->video_beranda = $video === NULL ? base_url('images/tnial.mp4') : base_url('upload/video_beranda/' . $video);


					$this->total_tes_only = (empty($setting->jumlah_testing)) ? NULL : $setting->jumlah_testing;
					$this->jumlah_pengecekan_ujian_selesai = $this->total_tes_only - 1;
				}
			}
		} else {
			$setting = $this->m_setting->get_by(array('id' => 1));

			$this->title = $setting->judul;
			$this->footer = '&copy; ' . date('Y') . ' ' . $setting->footer;
			if ($setting->logo_login == 1) {
				$this->logo = base_url('assets/img/' . $setting->logo);
			} else {
				$this->logo = base_url('assets/img/default-logo.png');
			}



			$this->total_tes_only = $setting->jumlah_testing;
			$this->jumlah_pengecekan_ujian_selesai = $this->total_tes_only - 1;
		}
		switch ($this->log_lvl) {
			case 'admin':
				$this->id_level = 1;
				break;
			case 'guru':
				$this->id_level = 2;
				break;
			case 'instansi':
				$this->id_level = 4;
				break;
			case 'siswa':
				$this->id_level = 3;
				break;
			case 'admin_instansi':
				$this->id_level = 5;
				break;
		}
		

		$this->menu = $this->db->select('menu.id,nama_menu,rule_users.id_level, link, icon')
			->from('rule_users')
			->join('menu', 'rule_users.id_menu = menu.id', 'inner')
			->join('level', 'rule_users.id_level = level.id', 'inner')
			->where('rule_users.id_level', $this->id_level)
			->order_by('menu.urutan', 'asc')
			->get()
			->result_array();
			

		foreach($this->menu as $i => $menu) {
			$submenu = $this->m_submenu->get_many_by(['id_menu' => $menu['id'], 'id_level' => $this->id_level ]);
			if(count($submenu) > 0) {
				$this->menu[$i]['sub'] = $submenu;	
			}
		}	

		if (!empty($this->uri->segment(1))) {
			$this->get_url .= $this->uri->segment(1);
		}

		if (!empty($this->uri->segment(2))) {
			$this->get_url .= '/' . $this->uri->segment(2);
		}

		$this->db->where(['link' => $this->get_url]);
		$active_menu = $this->db->get('menu');

		
		$sub_menu = $this->db->select('*')
							->from('sub_menu')
							->where(['link' => $this->get_url])->get()->row();
	
		$this->sub_menu = $sub_menu;

		if($active_menu->num_rows() > 0) {
			$this->active_menu = $active_menu->row()->id;
			if($this->checkactivemenu() == FALSE) {
				$this->active_menu = !empty($this->get_url) ? $this->get_url : $sub_menu->id_menu;
				$this->sub_menu = $sub_menu;
			}
		}
		else {
			$this->active_menu = (!empty($sub_menu->id_menu)) ? $sub_menu->id_menu : NULL;	
		}

		$this->page_title = (!empty($this->sub_menu->nama_menu)) ? $this->sub_menu->nama_menu : NULL;
		
	}

	public function generateCSRFToken() {
		return [
			'name'   => $this->security->get_csrf_token_name(),
			'token' => $this->security->get_csrf_hash()
		];
	}

	function checkactivemenu() {
		foreach($this->menu as $menu) {
			if($menu['id'] == $this->active_menu) {
				return TRUE;
			}
		}
		return FALSE;
	}

	function getClient()
	{
		header("Access-Control-Allow-Origin: *");
		$data = parse_url($_SERVER['REQUEST_URI']);
		$uri2 = $this->uri->segment(2);
		// 		print_r($data);
		// 		exit;
		$client = new Google_Client();
		$client->setApplicationName('E-Learning');
		$client->setScopes(Google_Service_Calendar::CALENDAR);
		$client->setAuthConfig('credentials.json');
		$client->setAccessType('offline');
		$client->setPrompt('select_account consent');

		$folderToken = 'token/' . $this->akun->username . '/';
		$buat_folder_gb_soal = !is_dir($folderToken) ? @mkdir($folderToken) : false;

		$tokenPath = $folderToken . 'token.json';
		if (file_exists($tokenPath)) {
			$accessToken = json_decode(file_get_contents($tokenPath), true);
			$client->setAccessToken($accessToken);
		}
		if ($client->isAccessTokenExpired()) {
			if ($client->getRefreshToken()) {
				$client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
			} else {

				if ($data['query'] == NULL) {
					$authUrl = $client->createAuthUrl();
					redirect($authUrl);
				}

				$authCode = trim($data['query']);
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

	public function insertCalendar(
		$id_guru = NULL,
		$id_kelas,
		$ket,
		$color,
		$start_date,
		$start_time,
		$end_date,
		$end_time,
		$materi
	) {
		$client = $this->getClient();
		$service = new Google_Service_Calendar($client);
		$where = [
			'id_kelas' => $id_kelas,
			'kls.id_instansi' => $this->akun->instansi
		];
		$kelas = $this->m_kelas->get_all_siswa($where);
		foreach ($kelas as $key => $kl) {
			$email[$key]['email'] = $kl->email_siswa; 
			$email_guru = $kl->email_guru;
			
		};
		$key += 1;
		$email[$key]['email'] = $email_guru;

		$mapel = $this->m_materi->get_by(array('id'=>$materi));
		
		if($mapel != NULL){
		    $loc  = $mapel->title;
		}else if($mapel == NULL){
		    $loc = 'No Title';
		}
	
		$event = new Google_Service_Calendar_Event([
			'kind'              => 'calendar#calendarListEntry',
			'summary'           => $loc,
			'location'          => base_url(),
			'sendNotifications' => TRUE,
			'sendUpdates'       => 'all',
			'description'       => $ket,
			'backgroundColor'   => $color,
			'start' => [
				'dateTime' => $start_date . 'T' . $start_time . ':00-00:00',
				'timeZone' => 'Asia/Jakarta',
			],
			'end' => [
				'dateTime' => $end_date . 'T' . $end_time . ':00-00:00',
				'timeZone' => 'Asia/Jakarta',
			],
			'recurrence' => [
				'RRULE:FREQ=DAILY;COUNT=1'
			],
			'attendees' => $email,
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
		$calendar_id = explode('https://www.google.com/calendar/event?eid=', $event->htmlLink);
		$data = array(
			'id_kelas' 		=> $id_kelas,
			'id_calendar'	=> $calendar_id[1],
			'id_materi'  	=> $materi,
			'keterangan' 	=> $ket,
			'start_date' 	=> $start_date . ' ' . $start_time,
			'end_date'   	=> $end_date . ' ' . $end_time,
			'color'  	 	=> $color,
		);

		if(!is_null($id_guru)) {
			$data['id_guru'] = $id_guru;
		}

		$this->m_jadwal->insert($data);
		echo json_encode(array('result' => true));
	}

	public function render($content = null, $data = NULL)
	{


		$data['sess_level'] = $this->session->userdata('admin_level');
		$data['sess_user'] = $this->session->userdata('admin_user');
		$data['sess_konid'] = $this->session->userdata('admin_konid');

		$data['menu'] = $this->menu;

		$data['header'] 	= $this->load->view('dashboard/template/header', $data, TRUE);
		$data['navbar'] 	= $this->load->view('dashboard/template/navbar', $data, TRUE);
		$data['content'] 	= $this->load->view($content, $data, TRUE);
		$data['foot_new'] 	= $this->load->view('dashboard/foot_new', $data, TRUE);
		$data['footer'] 	= $this->load->view('dashboard/template/footer', $data, TRUE);

		$this->load->view('dashboard/index', $data);
	}

	public function render_siswa($content = null, $data = NULL)
	{

		$data['head'] 		= $this->load->view('content/head', $data, TRUE);
		$data['header'] 	= $this->load->view('content/header', $data, TRUE);
		$data['content'] 	= $this->load->view($content, $data, TRUE);
		$data['footer'] 	= $this->load->view('content/footer', $data, TRUE);

		$this->load->view('content/index', $data);
	}

	public function generate_page_modal($paginate = []) 
	{
		$this->load->view('dashboard/content/pagination_modal', $paginate);
	}

	public function generate_page($paginate = array())
	{
		$this->load->view('dashboard/content/pagination', $paginate);
	}

	public function gen_paging($paginate = array())
	{



		if (!isset($paginate['template_view']))
			$paginate['template_view'] = 'contain_view';

		$page = '<div class="container">
							<div class="row">
								<ul class="pagination mx-auto">';
		if ($paginate['counts']['curr_page'] == 1) :

			$page .= '<li class = "page-item disabled">
				<a href="javascript:void(0)" class="page-link" aria-label="First">
					<span aria-hidden="true"> First </span>
					<span class="sr-only">First</span>
				</a>
			</li>';
		else :
			$page .= '<li  class = "page-item">
					<a href="javascript:void(0)" class="page-link" aria-label="First"  onclick="pageLoad(\'1\',\'' . $paginate['url'] . '\',\'' . $paginate['template_view'] . '\')">
						<span aria-hidden="true"> First </span>
					<span class="sr-only">First</span>
					</a>
				</li>';
		endif;

		$count = 1;
		if ($paginate['counts']['total_num'] > 0)
			$count = ceil($paginate['counts']['total_num'] / $paginate['counts']['limit']);

		$page_show = 2;
		$page_start = $paginate['counts']['curr_page'] - $page_show;
		$page_start = $page_start < 1 ? 1 : $page_start;

		$page_end = $paginate['counts']['curr_page'] + $page_show;
		$page_end = $count > $page_end ? $page_end : $count;
		$page_end = $count > 1 ? $page_end : 1;


		if ($page_start > 1) :

			$prev = $paginate['counts']['curr_page'] - 1;
			$page .= '<li class="page-item">
			<a href="javascript:void(0)" class="page-link" onclick="pageLoad(\'' . $prev . '\',\'' . $paginate['url'] . '\',\'' . $paginate['template_view'] . '\')"> <i class="fa fa-angle-left"></i> Prev </a></li>
				<li>
				<a href="javascript:void(0)" class="page-link"> ... </a>
				</li>';
		endif;

		for ($i = $page_start; $i <= $page_end; $i++) :


			if ($paginate['counts']['curr_page'] == $i) :
				$page .= '<li  class = "page-item disabled">
						<a href="javascript:void(0)" class="page-link" >' . $i . '</a>
					</li>';

			else :
				$page .= '<li  class = "page-item">
			<a href="javascript:void(0)"  class="page-link" onclick="pageLoad(\'' . $i . '\',\'' . $paginate['url'] . '\',\'' . $paginate['template_view'] . '\')">' . $i . '</a>
						</li>';
			endif;

		endfor;

		if ($page_end < $count) :
			$next = $paginate['counts']['curr_page'] + 1;
			$page .= '<li  class = "page-item">
					<a href="javascript:void(0)" class="page-link"> ... </a></li>
					<li>
					<a href="javascript:void(0)" class="page-link" onclick="pageLoad(\'' . $next . '\',\'' . $paginate['url'] . '\',\'' . $paginate['template_view'] . '\')"> Next <i class="fa fa-angle-right"></i> </a>
					</li>';

		endif;



		if ($paginate['counts']['curr_page'] == $count) :

			$page .= '<li class = "page-item disabled">
						<a href="javascript:void(0)" aria-label="Last" class="page-link" onclick="pageLoad(\'' . $count . '\',\'' . $paginate['url'] . '\',\'' . $paginate['template_view'] . '\')">
							<span aria-hidden="true">Last</span>
						</a>
					</li>';
		else :
			$page .= '<li  class = "page-item">
						<a href="javascript:void(0)" class="page-link" aria-label="Last" onclick="pageLoad(\'' . $count . '\',\'' . $paginate['url'] . '\',\'' . $paginate['template_view'] . '\')"><span aria-hidden="true">Last </span>
							</a>
						</li>';
		endif;
		$page .= '<li  class = "page-item disabled">
						<a href="javascript:void(0)" class="page-link" aria-label="Last" onclick="pageLoad(\'' . $count . '\',\'' . $paginate['url'] . '\',\'' . $paginate['template_view'] . '\')">
							<span aria-hidden="true">Show ' . $paginate['counts']['from_num'] . ' To ' . $paginate['counts']['to_num'] . ' From ' . $paginate['counts']['total_num'] . '</span>
						</a>
					</li>
				</ul>
			</div>
		</div>';

		return $page;
	}
	public function cek_aktif() 
	{
		if ($this->session->userdata('admin_valid') == false && $this->session->userdata('admin_id') == "") {
			redirect('login');
		} 
	}
	
	public function sendAjaxResponse($data, $responseCode = 200) 
	{
		echo json_encode($data);
		http_response_code($responseCode);
	}

	private function checkDBTables($tableName)
	{
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `".$tableName."`(
				id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
			    id_ujian INT NOT NULL,
			    id_user INT NOT NULL,
			    status TINYINT(3) DEFAULT 0
			);
		");
	}

	/*
	* Function untuk mengecek apakah sudah ujian atau belum
	*/
	protected function sudahUjian($typeUjian = 'pg', $id_ujian)
	{
		$checkSoal = NULL;
		$jawabanUjian = NULL;
		switch ($typeUjian) {
			case 'pg':
				$checkSoal = $this->m_soal_ujian->count_by([
					'id_ujian'
				]);
				$jawabanUjian = $this->m_ikut_ujian->count_by([
					'id_ujian' => $id_ujian,
					'id_user' => $this->akun->id,
					'status_ujian' => 1
				]);
			break;
			case 'essay':
				$checkSoal = $this->m_soal_ujian_essay->count_by([
					'id_ujian'
				]);
				$jawabanUjian = $this->m_ikut_ujian_essay->count_by([
					'id_ujian' => $id_ujian,
					'id_user' => $this->akun->id,
					'status_ujian' => 1
				]);
			break;
		}

		// Jika siswa sudah ujian maka redirect ke halaman ujian
		if($checkSoal > 0 && $jawabanUjian > 0) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}
}
