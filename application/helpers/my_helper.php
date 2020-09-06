<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* fungsi non database */
function tjs ($tgl, $tipe) {
	if ($tgl != "0000-00-00 00:00:00") {
		$pc_satu	= explode(" ", $tgl);
		if (count($pc_satu) < 2) {	
			$tgl1		= $pc_satu[0];
			$jam1		= "";
		} else {
			$jam1		= $pc_satu[1];
			$tgl1		= $pc_satu[0];
		}

		$pc_dua		= explode("-", $tgl1);
		$tgl		= $pc_dua[2];
		$bln		= $pc_dua[1];
		$thn		= $pc_dua[0];

		$bln_pendek		= array("Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des");
		$bln_panjang	= array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

		$bln_angka		= intval($bln) - 1;

		if ($tipe == "l") {
			$bln_txt = $bln_panjang[$bln_angka];
		} else if ($tipe == "s") {
			$bln_txt = $bln_pendek[$bln_angka];
		}

		return $tgl." ".$bln_txt." ".$thn."  ".$jam1;
	} else {
		return "Tgl Salah";
	}
}

function hari($wekday) {
	$hari	= array("Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu","Minggu");
	return $hari[$wekday];
}

function emtpy_check($data, $teks) {
	if (empty($data)) {
		return $teks;
	} else {
		return $data;
	}
}

function terbilang($bilangan){
	$bilangan = abs($bilangan);

	$angka 	= array("Nol","satu","dua","tiga","empat","lima","enam","tujuh","delapan","sembilan","sepuluh","sebelas");
	$temp 	= "";

	if($bilangan < 12){
		$temp = " ".$angka[$bilangan];
	}else if($bilangan < 20){
		$temp = terbilang($bilangan - 10)." belas";
	}else if($bilangan < 100){
		$temp = terbilang($bilangan/10)." puluh".terbilang($bilangan%10);
	}else if ($bilangan < 200) {
		$temp = " seratus".terbilang($bilangan - 100);
	}else if ($bilangan < 1000) {
		$temp = terbilang($bilangan/100). " ratus". terbilang($bilangan % 100);
	}else if ($bilangan < 2000) {
		$temp = " seribu". terbilang($bilangan - 1000);
	}else if ($bilangan < 1000000) {
		$temp = terbilang($bilangan/1000)." ribu". terbilang($bilangan % 1000);
	}else if ($bilangan < 1000000000) {
		$temp = terbilang($bilangan/1000000)." juta". terbilang($bilangan % 1000000);
	}

	return $temp;
}

function tambah_jam_sql($menit) {
	$str = "";
	if ($menit < 60) {
		$str = "00:".str_pad($menit, 2, "0", STR_PAD_LEFT).":00";
	} else if ($menit >= 60) {
		$mod = $menit % 60;
		$bg = floor($menit / 60);
		$str = str_pad($bg, 2, "0", STR_PAD_LEFT).":".str_pad($mod, 2, "0", STR_PAD_LEFT).":00";
	} 
	return $str;
}

function bersih($data, $pil) {
	//return mysql_real_escape_string 
	return $data->$pil;
}


function obj_to_array($obj, $pilih) {
	$pilihpc	= explode(",", $pilih);
	$array 		= array(""=>"-");

	foreach ($obj as $o) {
		$xx = $pilihpc[0];
		$x = $o->$xx;
		$y = $pilihpc[1];

		$array[$x] = $o->$y; 
	}

	return $array;
}


function tampil_media($file,$width="320px",$height="240px") {
	$ret = '';

	$pc_file = explode(".", $file);
	$eks = end($pc_file);
	$eks = strtolower($eks);

	$eks_video = array("mp4","flv","mpeg");
	$eks_audio = array("mp3","acc");
	$eks_image = array("jpeg","jpg","gif","bmp","png");


	if (!in_array($eks, $eks_video) && !in_array($eks, $eks_audio) && !in_array($eks, $eks_image)) {
		$ret .= '';
	} else {
		if (in_array($eks, $eks_video)) {
			if (is_file("./".$file)) {
				$ret .= '<p class="mt-2 mb-2"><video width="'.$width.'" height="'.$height.'" controls>
				  <source src="'.base_url().$file.'" type="video/mp4">
				  <source src="'.base_url().$file.'" type="application/octet-stream">Browser tidak support</video></p>';
			} else {
				$ret .= '';
			}
		} 

		if (in_array($eks, $eks_audio)) {
			if (is_file("./".$file)) {
				$ret .= '<p><audio width="'.$width.'" height="'.$height.'" controls>
				<source src="'.base_url().$file.'" type="audio/mpeg">
				<source src="'.base_url().$file.'" type="audio/wav">Browser tidak support</audio></p>';
			} else {
				$ret .= '';
			}
		}

		if (in_array($eks, $eks_image)) {
			if (is_file("./".$file)) {
				$ret .= '<div class="gambar mt-2 mb-2"><img src="'.base_url().$file.'" style="width: '.$width.'; height: '.$height.'; display: inline; float: left"></div><br>';
			} else {
				$ret .= '';
			}
		}
	}
	

	return $ret;
}

function j($data) {
	header('Content-Type: application/json');
	echo json_encode($data);
}


function gen_menu() {
	$CI 	=& get_instance();
	$sess_level = $CI->session->userdata('admin_level');
	$url = $CI->uri->segment(2);

	$menu = array();

	if ($sess_level == "guru") {
	  $menu = array(
	            array("icon"=>"dashboard", "url"=>"", "text"=>"Dashboard"),
	            array("icon"=>"list-alt", "url"=>"m_soal", "text"=>"Soal"),
	            array("icon"=>"file", "url"=>"m_ujian", "text"=>"Ujian"),
	            array("icon"=>"file", "url"=>"h_ujian", "text"=>"Hasil Ujian"),
	          );
	} else if ($sess_level == "siswa") {
	  $menu = array(
	            array("icon"=>"dashboard", "url"=>"", "text"=>"Dashboard"),
	            array("icon"=>"file", "url"=>"ikuti_ujian", "text"=>"Ujian"),
	          );
	} else if ($sess_level == "admin") {
	  $menu = array(
	            array("icon"=>"dashboard", "url"=>"", "text"=>"Dashboard"),
	            array("icon"=>"list-alt", "url"=>"m_siswa", "text"=>"Data Siswa"),
	            array("icon"=>"list-alt", "url"=>"m_guru", "text"=>"Data Guru/Dosen"),
	            array("icon"=>"list-alt", "url"=>"m_mapel", "text"=>"Data Mapel"),
	            array("icon"=>"list-alt", "url"=>"m_soal", "text"=>"Soal"),
	            array("icon"=>"file", "url"=>"h_ujian", "text"=>"Hasil Ujian"),
	          );
	} else {
	  $menu = array(
	            array("icon"=>"dashboard", "url"=>"", "text"=>"Dashboard")
	          );
	  if ($url == "ikut_ujian") {
	    $menu = null;
	  }
	}


	
	if ($menu != null) {
		echo '
		<div class="container" style="margin-top: 70px">

		<div class="col-lg-12 row">
		  <div class="panel panel-default">
		    <div class="panel-body">';
 
		    foreach ($menu as $m) {
		        if ($url == $m['url']) {
		          echo '<a href="'.base_url().'adm/'.$m['url'].'" class="btn btn-sq btn-warning"><i class="glyphicon glyphicon-'.$m['icon'].' g3x"></i><br><br/>'.$m['text'].' </a>';
		        } else {
		          echo '<a href="'.base_url().'adm/'.$m['url'].'" class="btn btn-sq btn-primary"><i class="glyphicon glyphicon-'.$m['icon'].' g3x"></i><br><br/>'.$m['text'].' </a>';
		        }
		    }

		echo '</div>
		  </div>
		</div>';

	}
}

function cek_hakakses($arr_yg_boleh_akses, $userid) {
	if (!in_array($userid, $arr_yg_boleh_akses)) {
		redirect('adm');
	}
}

function translate_theme($opsi='sekolah'){

	switch ($opsi) {
		case 'tni':
				$data['siswa'] = 'Siswa';
				$data['guru'] = 'Pengajar';
				$data['instansi'] = 'Lembaga';
			break;

		case 'bank':
				$data['siswa'] = 'Peserta';
				$data['guru'] = 'Trainer';
				$data['instansi'] = 'Instansi';
			break;

		case 'kampus':
				$data['siswa'] = 'Mahasiswa';
				$data['guru'] = 'Dosen';
				$data['instansi'] = 'Kampus';
			break;
		
		default:
				$data['siswa'] = 'Siswa';
				$data['guru'] = 'Guru';
				$data['instansi'] = 'Sekolah';
			break;
	}

	return $data = (object)$data;

}		

/*
* Function untuk menentukan format media soal ujian
*/
function getMediaSoalFile($file, $filePath, $fileType, $class = '', $width = 80, $height = 80, $imgOnClick = NULL)
{
	$html = '';
	if(!empty($file)) {
		switch($fileType) {
			case 'image/jpeg':
			case 'image/png':
			case 'image/gif':
				$html = '<img src="'. base_url($filePath . $file) .'" class="img-thumbnail '.$class.'" alt="'.$file.'" width="'.$width.'" height="'.$height.'" />';
			break;
			case 'audio/mpeg':
			case 'audio/mpg':
			case 'audio/mpeg3':
			case 'audio/mp3':
			case 'audio/x-wav':
			case 'audio/wave':
			case 'audio/wav':
				$html = '<audio controls>
					<source src="'.base_url($filePath . $file).'" type="'.$fileType.'" />
					Browser anda tidak mendukung file audio ini.
				</audio>';
			break;

			case 'video/mp4':
				$html = '<video width="300" height="200" controls>
					<source src="'.base_url($filePath . $file).'" type="'.$fileType.'" />
					Browser anda tidak mendukung file video ini.
				</video>';
			break;

			case 'application/octet-stream':
				$html = '<a href="'.base_url($filePath . $file).'" download>Download File</a>';
			break;
		}
	}

	return $html;
}

/*
* Function untuk  menentukan format media opsi
* @return html
*/
function getMediaOpsiFile($file, $filePath)
{
	$fileName = explode('.', $file);
	$html = '';
	if(!is_null($file)) {
		switch(end($fileName)) {
			case 'png':
			case 'jpeg':
			case 'jpg':
			case 'gif':
				$html = '<img src="'.base_url($filePath . $file).'" width="100" height="100" alt="'.$file.'" />';
			break;

			case 'mpeg':
			case 'mpg':
			case 'mpeg3':
			case 'mp3':
			case 'x-wav':
			case 'wave':
			case 'wav':
				$html = '<audio controls>
					<source src="'.base_url($filePath . $file).'" type="audio/'.end($fileName).'" />
					Browser anda tidak mendukung file audio ini.
				</audio>';
			break;

			case 'mp4': 
				$html = '<video width="" height="" controls>
					<source src="'.base_url($filePath . $file).'" type="video/mp4" />
					Browser anda tidak mendukung file video ini.
				</video>';
			break;
		}
	}
		
	return $html;
}