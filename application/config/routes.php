<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'awal';
$route['kelas/riwayat-mengajar/(:any)'] = 'Kelas/riwayat_mengajar/$1';
$route['profile/guru/(:any)'] = 'beranda/profile/$1';
$route['aktivitas/detail-siswa/(:any)'] = 'aktivitas/detail_siswa/$1';
$route['ujian/batalkan-ujian'] = 'ujian_real/batalkanUjian';
$route['ujian/delete-hasil-ujian'] = 'ujian_real/delete_hasil_ujian';
$route['ujian/delete-hasil-ujian-essay'] = 'ujian_essay/delete_hasil_ujian';
$route['tugas/delete-file-tugas'] = 'tugas/delete_file_attach';
$route['tugas/get-list-alert'] = 'tugas/getListAlert';
$route['tugas/send-alert-message'] = 'tugas/sendAlertMessage';
$route['tugas/delete-alert-message'] = 'tugas/deleteAlertMessage';
$route['tugas/update-status-alert'] = 'tugas/updateStatusAlert';
$route['rekaptulasi/detail-ujian/(:any)/(:any)'] = 'rekaptulasi/detail_ujian/$1/$2';
// Type Ujian, Id_mapel, Id_guru, Id_kelas
$route['rekaptulasi/detail-ujian/(:any)/(:any)/(:any)/(:any)'] = 'rekaptulasi/detail_ujian_siswa/$1/$2/$3/$4';
$route['tugas/detail-nilai/(:any)'] = 'tugas/detail_nilai_tugas/$1';
$route['tugas/detail-nilai-siswa/(:any)/(:any)'] = 'tugas/detail_nilai_tugas_siswa/$1/$2';
$route['Materi/get-list-files'] = 'Materi/get_list_file';
$route['Materi/delete-file-materi'] = 'Materi/delete_file_materi';
$route['Materi/get-list-videos'] = 'Materi/get_list_videos';
$route['Materi/delete-materi'] = 'Materi/delete';
$route['rekaptulasi/get-data-by-kategori'] = 'rekaptulasi/get_data_by_kategori';
$route['rekaptulasi/get-kelas-by-data'] = 'rekaptulasi/get_kelas_by_data';
$route['export/rekap-tugas'] = 'export/rekapTugas';
$route['export/rekap-ujian'] = 'export/rekapUjian';
$route['export/pdf-rekap-ujian'] = 'export/pdfRekapUjian';
$route['export/pdf-rekap-tugas'] = 'export/pdfRekapTugas';
$route['ujian/hasil-pg/(:any)/(:any)'] = 'ujian_real/hasil_ujian_pg/$1/$2';
$route['ujian/hapus-opsi-file'] = 'ujian_real/hapusOpsiFile';
$route['ujian/hapus-soal-file'] = 'ujian_real/hapusSoalFile';
$route['aktivitas/detail-keaktifan-siswa'] = 'aktivitas/detail_keaktifan_siswa';
$route['penilaian/insert-soal'] = 'penilaian/insertSoal';
$route['penilaian/update-soal'] = 'penilaian/updateSoal';
$route['penilaian/hapus-opsi-file'] = 'penilaian/hapusOpsiFile';
$route['penilaian/hapus-soal-file'] = 'penilaian/hapusSoalFile';
$route['penilaian/hasil-penilaian/(:any)'] = 'penilaian/hasilPenilaian/$1';
$route['penilaian/load-hasil-penilaian/(:num)'] = 'penilaian/pageLoadHasilPenilaian/$1';
$route['penilaian/batalkan-penilaian'] = 'penilaian/batalkanPenilaian';
$route['penilaian/hasil-penilaian-siswa/(:any)/(:any)'] = 'penilaian/hasilPenilaianSiswa/$1/$2';
$route['ujian_essay/insert-jawaban'] = 'ujian_essay/insertJawaban';
$route['ujian_essay/update-jawaban'] = 'ujian_essay/updateJawaban';
$route['ujian_essay/check-jawaban-soal'] = 'ujian_essay/checkJawabanSoal';
$route['ujian_essay/selesai-ujian'] = 'ujian_essay/saveEndUjian';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
