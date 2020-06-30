<<<<<<< HEAD
        <style type="text/css">
          *{
            margin:5px;
          }
          #isi{
            font-size: 12px;
          }
          #head{
            font-size: 14px;

          }
          th{
            text-align: center;
          }
        </style>
        <h2 style="text-align: center;">Hasil Latihan Soal</h2>
        <table id="head">
          <tr>
            <th>Nama </th>
            <td>:</td>
            <td><?=$this->akun->nama;?></td>
          </tr>
           <tr>
            <th>Email </th>
            <td>:</td>
            <td><?=$this->akun->email;?></td>
          </tr>
           <tr>
            <th>Trainer</th>
            <td>:</td>
            <td><?=$detail->nama_guru;?></td>
          </tr>
          <tr>
            <th>Materi</th>
            <td>:</td>
            <td><?=$detail->nama_mapel;?></td>
          </tr>
        </table>
        <br>
        <table border="1" width="80%" cellpadding="2" cellspacing="0" id="isi">
          <thead>
            <tr>
              <th width="5%">No</th>
              <th>Nama Tes</th>
              <th width="20%">Jumlah Soal</th>
              <th width="10%">Waktu</th>
             <?php  if ($this->session->userdata('admin_level') == 'siswa'): ?>
                <th width="20%">Hasil</th>
             <?php endif;?>

            </tr>
          </thead>

          <tbody>
            <?php 
             $total = 0;
              if (!empty($data)) {
                $no = 1;
               
                foreach ($data as $d) {
                  $where = array(
                    'id_tes'  => $d->id, 
                    'id_user' => $this->session->userdata('admin_konid'),
                    'status'  => 'N'
                  );


                  $checking = $this->db->select("
                                  count(ujian.id) as jmlh,
                              ")
                              ->from('tr_ikut_ujian ujian')
                              ->join('tr_guru_tes tes',' tes.id = ujian.id_tes ','inner')
                              ->where($where)
                              ->get()
                              ->row();

                  echo '<tr>
                        <td class="ctr">'.$no.'</td>
                        <td>'.$d->nama_ujian.'</td>
                        <td class="ctr" align="center">'.$d->jumlah_soal.'</td>
                        <td class="ctr" align="center">'.$d->waktu.' menit</td>';
                     if ($this->session->userdata('admin_level') == 'siswa'):
                        echo '<td align="center">'.(int)$d->hasil.'</td>';
                        $total += $d->hasil;
                     endif;
                $no++;
                }
              } else {
                echo '<tr><td colspan="7">Belum ada data</td></tr>';
              }
            ?>
             <?php if ($this->session->userdata('admin_level') == 'siswa'): ?>
            <tr>
              <td colspan="4">Total Nilai</td>
              <td align="center"><?=$total;?></td>
            </tr>
              <?php endif ?>
          </tbody>
        </table>
       
           <p class="btn btn-success"></p>
=======
        <style type="text/css">
          *{
            margin:5px;
          }
          #isi{
            font-size: 12px;
          }
          #head{
            font-size: 14px;

          }
          th{
            text-align: center;
          }
        </style>
        <h2 style="text-align: center;">Hasil Latihan Soal</h2>
        <table id="head">
          <tr>
            <th>Nama </th>
            <td>:</td>
            <td><?=$this->akun->nama;?></td>
          </tr>
           <tr>
            <th>Email </th>
            <td>:</td>
            <td><?=$this->akun->email;?></td>
          </tr>
           <tr>
            <th>Trainer</th>
            <td>:</td>
            <td><?=$detail->nama_guru;?></td>
          </tr>
          <tr>
            <th>Materi</th>
            <td>:</td>
            <td><?=$detail->nama_mapel;?></td>
          </tr>
        </table>
        <br>
        <table border="1" width="80%" cellpadding="2" cellspacing="0" id="isi">
          <thead>
            <tr>
              <th width="5%">No</th>
              <th>Nama Tes</th>
              <th width="20%">Jumlah Soal</th>
              <th width="10%">Waktu</th>
             <?php  if ($this->session->userdata('admin_level') == 'siswa'): ?>
                <th width="20%">Hasil</th>
             <?php endif;?>

            </tr>
          </thead>

          <tbody>
            <?php 
             $total = 0;
              if (!empty($data)) {
                $no = 1;
               
                foreach ($data as $d) {
                  $where = array(
                    'id_tes'  => $d->id, 
                    'id_user' => $this->session->userdata('admin_konid'),
                    'status'  => 'N'
                  );


                  $checking = $this->db->select("
                                  count(ujian.id) as jmlh,
                              ")
                              ->from('tr_ikut_ujian ujian')
                              ->join('tr_guru_tes tes',' tes.id = ujian.id_tes ','inner')
                              ->where($where)
                              ->get()
                              ->row();

                  echo '<tr>
                        <td class="ctr">'.$no.'</td>
                        <td>'.$d->nama_ujian.'</td>
                        <td class="ctr" align="center">'.$d->jumlah_soal.'</td>
                        <td class="ctr" align="center">'.$d->waktu.' menit</td>';
                     if ($this->session->userdata('admin_level') == 'siswa'):
                        echo '<td align="center">'.(int)$d->hasil.'</td>';
                        $total += $d->hasil;
                     endif;
                $no++;
                }
              } else {
                echo '<tr><td colspan="7">Belum ada data</td></tr>';
              }
            ?>
             <?php if ($this->session->userdata('admin_level') == 'siswa'): ?>
            <tr>
              <td colspan="4">Total Nilai</td>
              <td align="center"><?=$total;?></td>
            </tr>
              <?php endif ?>
          </tbody>
        </table>
       
           <p class="btn btn-success"></p>
>>>>>>> first push
      