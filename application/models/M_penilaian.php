<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class M_penilaian extends MY_Model {



	protected $_table = 'tb_penilaian';

	protected $order_by = array('id','asc');



	public function __construct()

	{

		parent::__construct();

		

	}



	public function get_all($where=array()){

		$get = $this->db->select('

							pen.*,

							kls.nama as kelas,

							gr.nama as nama_guru,

							gr.nrp,

							gr.pangkat,

							mp.nama as nama_mapel,

							ins.instansi as nama_instansi

						')

		->from('tb_penilaian pen')

		->join('tb_kelas kls','kls.id=pen.id_kelas','left')

		->join('m_guru gr','gr.id=kls.id_trainer','left')

		->join('m_mapel mp','mp.id=kls.id_mapel','left')

		->join('tb_instansi ins','ins.id=kls.id_instansi','left')

		->order_by('pen.id','asc')

		->where($where)

		->get()

		->result();

	

      

		return $get;

	}



	public function get_all_siswa($where=array()){

		$get = $this->db->select('

							pen.*,

							kls.nama as kelas,

							gr.nama as nama_guru,

							gr.nrp,

							gr.pangkat,

							mp.nama as nama_mapel,

							ins.instansi as nama_instansi

						')

		->from('tb_penilaian pen')

		->join('tb_kelas kls','kls.id=pen.id_kelas','left')

		->join('tb_detail_kelas dekls','dekls.id_kelas=kls.id','left')

		->join('m_guru gr','gr.id=kls.id_trainer','left')

		->join('m_mapel mp','mp.id=kls.id_mapel','left')

		->join('tb_instansi ins','ins.id=kls.id_instansi','left')

		->order_by('pen.id','asc')

		->where($where)

		->get()

		->result();

	

      

		return $get;

	}



	public function count_by_cs($where=array()){

		$get = $this->get_all($where);

		return count($get);

	}



	public function count_by_siswa($where=array()){

		$get = $this->get_all_siswa($where);

		return count($get);

	}



	// Fungsi untuk menghindari duplicate data untuk output 2

	public function searchIdPenilaian($id, $array, $searchby = 'tipe') {

		foreach ($array as $key => $val) {

	       if ($val[$searchby] === $id) {

	           return $key;

	       }

	   }

	   return null;

	}

	

	public function get_laporan($where = array(), $output = 1) {

        $where = array_merge($where, $this->where);



        // Array untuk store jawaban untuk data output 2 dan set jadi 20 item array

        $output2 = [];

        for($i = 0;$i < 20;$i++) {

        	$output2[] = ['tipe' => 0];

        }



        $array_jawaban = [];

        $jawaban5 = [];

        $jawaban4 = [];

        $jawaban3 = [];

        $jawaban2 = [];

        $jawaban1 = [];

        

        // Store data output1

        $output1 = $this->db->select('pen.*,gr.nama as nama_guru, kls.nama as kelas, mp.nama as nama_mapel, ins.instansi as nama_instansi')

                        ->from('tb_penilaian pen')

                        ->join('tb_kelas kls','kls.id=pen.id_kelas','left')

                		->join('m_guru gr','gr.id=kls.id_trainer','left')

                		->join('m_mapel mp','mp.id=kls.id_mapel','left')

                		->join('tb_instansi ins','ins.id=kls.id_instansi','left')

                		->order_by('pen.id','asc')

                		->where($where)

                		->get()

                		->result();



        // Restructure data as result

        foreach($output1 as $i => $data) {

        	$output2[$i]['id'] = $data->id;

            

        	$output2[$i]['A'] = [];

        	$output2[$i]['B'] = [];

        	$output2[$i]['C'] = [];

        	$output2[$i]['D'] = [];

        	$output2[$i]['E'] = [];



        	$data->soal = [];

        	$data->user = [];

        	$data_soal = $this->m_ikut_penilaian->get_by(['id_penilaian' => $data->id]);

        	if($data_soal != NULL) {

                // Chunk jawaban

                $list_jawaban = explode(',', $data_soal->list_jawaban);

                $nilai = [];



                // Set sum_question sebagai divider dari setiap jawaban

                $sum_answer = count($list_jawaban);

                $data_soal->sum_answer = $sum_answer;

        		$data->soal[] = $data_soal;

                $output2[$i]['sum_answer'] = $sum_answer;



        		// Proses pencocokan jawaban dengan kunci jawaban

                for($x = 0;$x < count($list_jawaban);$x++)  {

                    $list_jawaban[$x] = explode(':', $list_jawaban[$x]);

                    $sum_jawaban = count($list_jawaban[$x]);

                    $list_jawaban[$x] = $list_jawaban[$x][1];

                    

                    $jawaban = 0;

                    switch($list_jawaban[$x]) {

                        case 'A':

                            $jawaban = 5;

                            $output2[$i]['A'][] = 5;



                        break;

                        case 'B':

                            

                            $jawaban = 4;

                            $output2[$i]['B'][] = 4;

                        break;

                        case 'C':

                            

                            $jawaban = 3;

                            $output2[$i]['C'][] = 3;

                        break;

                        case 'D':

                            $jawaban2[] = 2;        

                            $jawaban = 2;

                            

                            $output2[$i]['D'][] = 2;

                        break;

                        case 'E':

                            $jawaban1[] = 1;        

                            $jawaban = 1;

                            $output2[$i]['E'][] = 1;

                        break;

                    }

                    $nilai[$x] = $jawaban;

                    

                }

        		$data->user[] = [

        			'id_user' => $data_soal->id_user,

        			'nilai' => $nilai

        		];

        	}

            

        }



        // Lengkapi item yang kosong di array output2

        for($i = 0;$i < count($output2);$i++) {

        	    if(!isset($output2[$i]['sum_answer'])) {

                    $output2[$i]['sum_answer'] = 1;

                }

                

                if(!isset($output2[$i]['A'])) {

                    $output2[$i]['A'] = 0;

                }

                else {

                    $output2[$i]['A'] = count($output2[$i]['A']) * 100 / $output2[$i]['sum_answer'];   

                }

                if(!isset($output2[$i]['B'])) {

                    $output2[$i]['B'] = 0;

                }

                else {

                    $output2[$i]['B'] = count($output2[$i]['B'])* 100 / $output2[$i]['sum_answer'];   

                }

                if(!isset($output2[$i]['C'])) {

                    $output2[$i]['C'] = 0;

                }

                else {

                    $output2[$i]['C'] = count($output2[$i]['C'])* 100 / $output2[$i]['sum_answer'];   

                }

                if(!isset($output2[$i]['D'])) {

                    $output2[$i]['D'] = 0;

                }

                else {

                    $output2[$i]['D'] = count($output2[$i]['D'])* 100 / $output2[$i]['sum_answer'];   

                }

                if(!isset($output2[$i]['E'])) {

                    $output2[$i]['E'] = 0;

                }

                else {

                    $output2[$i]['E'] = count($output2[$i]['E'])* 100 / $output2[$i]['sum_answer'];   

                }

        }

        

        $return_result = [];

        switch ($output) {

            case 1:

                $return_result = [

                    'datas' => $output1,

                    'tipe' => 'output1'

                ];

                break;

            case 2:

                $return_result = [

                    'datas' => $output2,

                    'tipe' => 'output2'

                ];

                break;

            case 3:

                $return_result = [

                    'datas' => $output2,

                    'tipe' => 'output3'

                ];

                break;

        }

        return $return_result;

    }



	public function get_by($where=array()){

		$get = $this->db->select('

							pen.*,

							kls.nama as kelas,

							gr.nama as nama_guru,

							mp.nama as nama_mapel,

							ins.instansi as nama_instansi

						')

		->from('tb_penilaian pen')

		->join('tb_kelas kls','kls.id=pen.id_kelas','left')

		->join('m_guru gr','gr.id=kls.id_trainer','left')

		->join('m_mapel mp','mp.id=kls.id_mapel','left')

		->join('tb_instansi ins','ins.id=kls.id_instansi','left')

		->order_by('pen.id','asc')

		->where($where)

		->get()

		->row();

	

      

		return $get;

    }

    



    public function get_output1($where=array()){

        $get = $this->db->select('

                            (SELECT nama FROM m_guru gur WHERE gur.id = kls.id_trainer) as nama_guru,

                            mpl.nama as nama_mapel,

                            ikut.list_soal,

                            ikut.list_jawaban

						')

		->from('tb_kelas kls')

		->join('m_mapel mpl','mpl.id=kls.id_mapel','left')

        ->join('tb_penilaian pen','kls.id = pen.id_kelas')

        ->join('tb_ikut_penilaian ikut','ikut.id_penilaian = pen.id')

		->order_by('ikut.id','asc')

		->where($where)

		->get()

		->result();

	

      

		return $get;

    }



    

    public function count_out1($where=array()){

		$get = $this->get_output1($where);

		return count($get);

	}



	 public function paginate($page = 1, $where = array(), $limit = 10)

    {

        // get filtered results

        $where = array_merge($where, $this->where);

        $offset = ($page<=1) ? 0 : ($page-1)*$limit;

		$this->db->limit($limit, $offset);

		if($this->log_lvl == 'siswa'){

			$results = $this->get_all_siswa($where);

		}else{

			$results = $this->get_many_by($where);

		}

      

        //echo  $this->db->last_query(); exit;

        // get counts (e.g. for pagination)

		$count_results = count($results);

		if($this->log_lvl == 'siswa'){

			$count_total = $this->count_by_siswa($where);

		}else{

			$count_total = $this->count_by_cs($where);

		}

    

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



    

	 public function out1($page = 1, $where = array(), $limit = 10)

     {

        



        $results = $this->get_output1($where);



        if(empty($results)){

            echo 'Belum ada penilaian';

            exit;

        };



                $pasis = 0;

                $nilai = 0;

                foreach($results as $rows){

                    $pasis += 1;



                        $nama_guru[$pasis] = $rows->nama_guru;

                        $nama_mapel[$pasis] = $rows->nama_mapel;



                        $i=1;

                        $x=0;

                        $jawaban = explode(',',$rows->list_jawaban);



                        foreach($jawaban as $jwb1){

                            //substr($list_jw_soal, 0, -1);

                            $soal = substr($jwb1,0, 1);

                            $jwb = substr($jwb1,-3);

                            $jwb = substr($jwb,0,-2);



                            $soal_ke = 'Q'.$i;

                        

                            if($jwb == 'A'){

                                $nilai +=5;

                            }else if ($jwb == 'B'){

                                $nilai +=4;

                            }else if ($jwb == 'C'){

                                $nilai +=3;

                            }else if ($jwb == 'D'){

                                $nilai +=2;

                            }else if ($jwb == 'E'){

                                $nilai +=1;

                            }



                            $jwb_set[$pasis][$i]['jawaban'] = $jwb;

                            $jwb_set[$pasis][$i]['nilai']   = $nilai;



                            $labels[$x] = $soal_ke;

                           

                            $nilai = 0;

    



                            $i++;

                            $x++;

                                

                        }

                        

                        $responden = $pasis;



                }



                $sub_total = [];

                $total_ = 0;

                for ($i=1; $i <= $responden; $i++){ 

                    foreach ($jwb_set[$i] as $index => $rows) {

                        $sub_total[$i][$index] = $rows['nilai'];

                        $total_ += $rows['nilai'];

                    }

                }

                $rata_total = $total_/$responden;

                $soal_total = count($labels);

                $total = 0;

                for ($i=1; $i <= $soal_total ; $i++) { 

                    for ($x=1; $x <= $responden; $x++){ 

                        $total +=  $sub_total[$x][$i];

                    }

                    $rata_[] = $total/$responden;

                    $total = 0;

                }

            $hasil = (object) [

                'responden' => $responden,

                'labels' => $labels,

                'jawaban' => $jwb_set,

                'rata' => $rata_,

                'rata_total' => $rata_total,

                'nama_mapel' => $nama_mapel,

                'nama_guru' => $nama_guru

            ];



            return $hasil;

     }



     public function out2($page = 1, $where = array(), $limit = 10)

     {

         $penilaian = $this->get_output1($where);

         if(empty($penilaian)){

            echo 'Belum ada penilaian';

            exit;

        };

                $pasis = 0;

                $jwb_a = 0;

                $jwb_b = 0;

                $jwb_c = 0;

                $jwb_d = 0;

                $jwb_e = 0;

                foreach($penilaian as $chart){

                    $pasis += 1;



                        $i=1;

                        $x=0;

                        $jawaban = explode(',',$chart->list_jawaban);



                        foreach($jawaban as $jwb1){

                            //substr($list_jw_soal, 0, -1);

                            $soal = substr($jwb1,0, 1);

                            $jwb = substr($jwb1,-3);

                            $jwb = substr($jwb,0,-2);



                            $soal_ke = 'Q'.$i;

                        

                            if($jwb == 'A'){

                                $jwb_a +=1;

                            }else if ($jwb == 'B'){

                                $jwb_b +=1;

                            }else if ($jwb == 'C'){

                                $jwb_c +=1;

                            }else if ($jwb == 'D'){

                                $jwb_d +=1;

                            }else if ($jwb == 'E'){

                                $jwb_e +=1;

                            }



                            $jwb_set[$pasis][0][] = $jwb_a;

                            $jwb_set[$pasis][1][] = $jwb_b;

                            $jwb_set[$pasis][2][] = $jwb_c;

                            $jwb_set[$pasis][3][] = $jwb_d;

                            $jwb_set[$pasis][4][] = $jwb_e;



                            $labels[$x] = $soal_ke;



                            $jwb_a = 0;

                            $jwb_b = 0;

                            $jwb_c = 0;

                            $jwb_d = 0;

                            $jwb_e = 0;



                            $i++;

                            $x++;

                                

                        }

                    



                }

                

            

            $A = 0;

            $B = 0;

            $C = 0;

            $D = 0;

            $E = 0;

            

            $ke = count($labels);

            for ($x=0; $x < $ke ; $x++) { 

                for ($i=1; $i <= $pasis; $i++) { 

                

                

                        

                        $A += $jwb_set[$i][0][$x];

                        $B += $jwb_set[$i][1][$x];

                        $C += $jwb_set[$i][2][$x];

                        $D += $jwb_set[$i][3][$x];

                        $E += $jwb_set[$i][4][$x];

                        



                        



                        $set_[$x]['A'] = $A;

                        $set_[$x]['B'] = $B;

                        $set_[$x]['C'] = $C;

                        $set_[$x]['D'] = $D;

                        $set_[$x]['E'] = $E;

                        $set_[$x]['total'] = $A+$B+$C+$D+$E;



                        $presentase[$x]['A'] = ($A/$set_[$x]['total'])*100;

                        $presentase[$x]['B'] = ($B/$set_[$x]['total'])*100;

                        $presentase[$x]['C'] = ($C/$set_[$x]['total'])*100;

                        $presentase[$x]['D'] = ($D/$set_[$x]['total'])*100;

                        $presentase[$x]['E'] = ($E/$set_[$x]['total'])*100;

                }

                

                $A = 0;

                $B = 0;

                $C = 0;

                $D = 0;

                $E = 0;

                

            }



            



           



            $data = array(

                'labels' => $labels,

                'presentase' => $presentase

            );



          return $data;

     }



     public function out3($page = 1, $where = array(), $limit = 10)

     {

         $penilaian = $this->get_output1($where);



         if(empty($penilaian)){

            echo 'Belum ada penilaian';

            exit;

        };



                $pasis = 0;

                $jwb_a = 0;

                $jwb_b = 0;

                $jwb_c = 0;

                $jwb_d = 0;

                $jwb_e = 0;



                $jwb_a2 = 0;

                $jwb_b2 = 0;

                $jwb_c2 = 0;

                $jwb_d2 = 0;

                $jwb_e2 = 0;



                foreach($penilaian as $chart){

                    $pasis += 1;



                        $i=1;

                        $x=0;

                        $jawaban = explode(',',$chart->list_jawaban);



                        foreach($jawaban as $jwb1){

                            //substr($list_jw_soal, 0, -1);

                            $soal = substr($jwb1,0, 1);

                            $jwb = substr($jwb1,-3);

                            $jwb = substr($jwb,0,-2);



                            $soal_ke = 'Q'.$i;

                        

                            if($jwb == 'A'){

                                $jwb_a +=1;

                            }else if ($jwb == 'B'){

                                $jwb_b +=1;

                            }else if ($jwb == 'C'){

                                $jwb_c +=1;

                            }else if ($jwb == 'D'){

                                $jwb_d +=1;

                            }else if ($jwb == 'E'){

                                $jwb_e +=1;

                            }



                            $jwb_set[$pasis][0][] = $jwb_a;

                            $jwb_set[$pasis][1][] = $jwb_b;

                            $jwb_set[$pasis][2][] = $jwb_c;

                            $jwb_set[$pasis][3][] = $jwb_d;

                            $jwb_set[$pasis][4][] = $jwb_e;



                            if($jwb == 'A'){

                                $jwb_a2 +=5;

                            }else if ($jwb == 'B'){

                                $jwb_b2 +=4;

                            }else if ($jwb == 'C'){

                                $jwb_c2 +=3;

                            }else if ($jwb == 'D'){

                                $jwb_d2 +=2;

                            }else if ($jwb == 'E'){

                                $jwb_e2 +=1;

                            }



                            $nilai_set[$pasis][0][] = $jwb_a2;

                            $nilai_set[$pasis][1][] = $jwb_b2;

                            $nilai_set[$pasis][2][] = $jwb_c2;

                            $nilai_set[$pasis][3][] = $jwb_d2;

                            $nilai_set[$pasis][4][] = $jwb_e2;





                            $labels[$x] = $soal_ke;



                            $jwb_a = 0;

                            $jwb_b = 0;

                            $jwb_c = 0;

                            $jwb_d = 0;

                            $jwb_e = 0;



                            

                            $jwb_a2 = 0;

                            $jwb_b2 = 0;

                            $jwb_c2 = 0;

                            $jwb_d2 = 0;

                            $jwb_e2 = 0;



                            $i++;

                            $x++;

                                

                        }

                    



                }

                

            

            $A = 0;

            $B = 0;

            $C = 0;

            $D = 0;

            $E = 0;



            $A2 = 0;

            $B2 = 0;

            $C2 = 0;

            $D2 = 0;

            $E2 = 0;

            

            $ke = count($labels);

            for ($x=0; $x < $ke ; $x++) { 

                for ($i=1; $i <= $pasis; $i++) { 

                

                

                        

                        $A += $jwb_set[$i][0][$x];

                        $B += $jwb_set[$i][1][$x];

                        $C += $jwb_set[$i][2][$x];

                        $D += $jwb_set[$i][3][$x];

                        $E += $jwb_set[$i][4][$x];



                        $A2 += $nilai_set[$i][0][$x];

                        $B2 += $nilai_set[$i][1][$x];

                        $C2 += $nilai_set[$i][2][$x];

                        $D2 += $nilai_set[$i][3][$x];

                        $E2 += $nilai_set[$i][4][$x];





                        if(!empty($nilai_set[$i][0][$x])){

                            $pilih[$i][$x] = $nilai_set[$i][0][$x];

                        }else if(!empty($nilai_set[$i][1][$x])){

                            $pilih[$i][$x] = $nilai_set[$i][1][$x];

                        }else   if(!empty($nilai_set[$i][2][$x])){

                            $pilih[$i][$x] = $nilai_set[$i][2][$x];

                        }else  if(!empty($nilai_set[$i][3][$x])){

                            $pilih[$i][$x] = $nilai_set[$i][3][$x];

                        }else{

                            $pilih[$i][$x] = $nilai_set[$i][4][$x];

                        }





                        $set_[$x]['A'] = $A;

                        $set_[$x]['B'] = $B;

                        $set_[$x]['C'] = $C;

                        $set_[$x]['D'] = $D;

                        $set_[$x]['E'] = $E;

                        $set_[$x]['total'] = $A+$B+$C+$D+$E;



                        

                        $skor[$x]['A'] = $A2;

                        $skor[$x]['B'] = $B2;

                        $skor[$x]['C'] = $C2;

                        $skor[$x]['D'] = $D2;

                        $skor[$x]['E'] = $E2;



                        $total_skor[$x] = $A2+$B2+$C2+$D2+$E2;

                        $rata_total[$x] = $total_skor[$x]/$pasis;



                        if(!empty( $set_[$x]['A'])){

                            $datas[$x]['max'] = 5;

                        }else if(!empty( $set_[$x]['B'])){

                            $datas[$x]['max'] = 4;

                        }else if(!empty( $set_[$x]['C'])){

                            $datas[$x]['max'] = 3;

                        }else if(!empty( $set_[$x]['D'])){

                            $datas[$x]['max'] = 2;

                        }else{

                            $datas[$x]['max'] = 1;

                        }



                        if(!empty( $set_[$x]['E'])){

                            $datas[$x]['min'] = 5;

                        }else if(!empty( $set_[$x]['D'])){

                            $datas[$x]['min'] = 4;

                        }else if(!empty( $set_[$x]['C'])){

                            $datas[$x]['min'] = 3;

                        }else if(!empty( $set_[$x]['B'])){

                            $datas[$x]['min'] = 2;

                        }else{

                            $datas[$x]['min'] = 1;

                        }



                        $datas[$x]['rata-rata'] =  ( $datas[$x]['max'] +  $datas[$x]['min'] ) / 2;

        

                }



                $A = 0;

                $B = 0;

                $C = 0;

                $D = 0;

                $E = 0;



                $A2 = 0;

                $B2 = 0;

                $C2 = 0;

                $D2 = 0;

                $E2 = 0;

                

            }



            $jumlah_hasil = [];

            $total_kuadrat = 0;

            $ke = count($labels);

            for ($x=0; $x < $ke ; $x++) { 

                for ($i=1; $i <= $pasis; $i++) { 

                    $kuadrat[$x][$i] = pow( ($pilih[$i][$x] - $rata_total[$x]) , 2); 

                    $total_kuadrat +=  $kuadrat[$x][$i];

                }

                $jumlah_hasil[$x] = $total_kuadrat;

                $total_kuadrat = 0;

            }



            $ke = count($labels);

            for ($x=0; $x < $ke ; $x++) { 

                if($pasis == 1){
                    $variansi[$x] = $jumlah_hasil[$x];
                }else{
                    $variansi[$x] = $jumlah_hasil[$x]/($pasis - 1);
                }
               

                $deviasi[$x] = number_format(SQRT($variansi[$x]),5);

            }

        

            $data = array(

                'labels' => $labels,

                'datas' => $datas,

                'rata_total' => $rata_total,

                'pilih' => $pilih,

                'kuadrat' => $kuadrat,

                'jumlah_hasil' => $jumlah_hasil,

                'variansi' => $variansi,

                'deviasi' => $deviasi

            );



          return $data;

     }

    

    





}



/* End of file m_ujian.php */

/* Location: ./application/models/m_ujian.php */