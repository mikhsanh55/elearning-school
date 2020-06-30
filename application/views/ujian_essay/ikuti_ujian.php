<<<<<<< HEAD
<div class="col-md-9 page-content">
  <div class="inner-box">
    <div class="row col-md-12 ini_bodi">
      <div class="panel panel-info">
       

        <div class="panel-body">
          <input type="hidden" name="id_ujian" id="id_ujian" value="<?php echo encrypt_url($du['id']); ?>">
          <input type="hidden" name="_token" id="_token" value="<?php echo $du['token']; ?>">
          <input type="hidden" name="_tgl_sekarang" id="_tgl_sekarang" value="<?php echo date('Y-m-d H:i:s'); ?>">
          <input type="hidden" name="_tgl_mulai" id="_tgl_mulai" value="<?php echo $tgl_mulai; ?>">
          <input type="hidden" name="_terlambat" id="_terlambat" value="<?php echo $terlambat; ?>">
          <input type="hidden" name="_statuse" id="_statuse" value="<?php echo $du['statuse']; ?>">
          <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-body">
                <table class="table  table-bordered" border="1" style="width:100%; padding:10px;">
                  <tr>
                    <td width="20%">Nama</td>
                    <td ><?php echo $dp->nama; ?></td>
                  </tr>
                  <tr>
                    <td>Modul</td><td><?php echo $du['nmmapel']; ?></td>
                  </tr>
                  <tr>
                    <td>Trainer</td>
                    <td><?php echo $du['nmguru']; ?></td>
                  </tr>
                  <tr>
                    <td>Nama Ujian</td>
                    <td><?php echo $du['nama_ujian']; ?></td>
                  </tr>
                  <tr>
                    <td>Jumlah Soal</td><td><?php echo $jumlah_soal; ?></td>
                  </tr>
                  <tr>
                    <td>Waktu</td>
                    <td><?php echo $du['waktu']; ?> menit</td>
                  </tr>
                  <tr>
                    <td>Keterangan</td>
                    <td><?php echo ($du['izin'] == 0) ? 'Ujian belum di setujui' : 'Selamat Ujian' ; ?></td>
                  </tr>

                  <input type="hidden" name="token" id="token" required="true" class="form-control col-md-12" value="<?php echo $du['token']; ?>">
                   <!-- <?php if($du['status_token'] == 1){ ?>
                    <tr><td><input type="text" name="token" id="token" required="true" class="form-control col-md-12" ></td></tr>
                  <?php } else { ?>
                    <tr><td>Token</td><td><input type="hidden" name="token" id="token" required="true" class="form-control col-md-12" value="<?php echo $du['token']; ?>"></td></tr> -->
                  <?php } ?> 
                </table>
              </div>
            </div>
          </div>

          <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-body">
                <div class="alert alert-info">
                  Waktu boleh mengerjakan ujian adalah saat tombol "MULAI" berwarna hijau..!
                </div>
                 <?php if ($du['izin'] == 1): ?>
                <div id="btn_mulai">Ujian akan mulai dalam 
                     <div id="akan_mulai"></div>
                </div>
                 <?php endif ?>

                <div class="btn btn-danger" id="waktu_" style="margin-top: 20px">
                  Sisa waktu mengikuti ujian <br>
                  <span id="waktu_akhir_ujian"></span>
                </div>

                <div id="waktu_game_over"></div>

            <!--
            <a href="#" class="btn btn-success btn-lg" id="tbl_mulai" onclick="return konfirmasi_token(<?php echo $du['id']; ?>)"><i class="fa fa-check-circle"></i> MULAI</a>
            <div class="btn btn-danger" id="ujian_selesai">UJIAN TELAH SELESAI</div>
          -->
        </div>
      </div>
    </div>

  </div>
</div>
</div>
</div>
</div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    timer4();
  })
=======
<div class="col-md-9 page-content">
  <div class="inner-box">
    <div class="row col-md-12 ini_bodi">
      <div class="panel panel-info">
       

        <div class="panel-body">
          <input type="hidden" name="id_ujian" id="id_ujian" value="<?php echo encrypt_url($du['id']); ?>">
          <input type="hidden" name="_token" id="_token" value="<?php echo $du['token']; ?>">
          <input type="hidden" name="_tgl_sekarang" id="_tgl_sekarang" value="<?php echo date('Y-m-d H:i:s'); ?>">
          <input type="hidden" name="_tgl_mulai" id="_tgl_mulai" value="<?php echo $tgl_mulai; ?>">
          <input type="hidden" name="_terlambat" id="_terlambat" value="<?php echo $terlambat; ?>">
          <input type="hidden" name="_statuse" id="_statuse" value="<?php echo $du['statuse']; ?>">
          <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-body">
                <table class="table  table-bordered" border="1" style="width:100%; padding:10px;">
                  <tr>
                    <td width="20%">Nama</td>
                    <td ><?php echo $dp->nama; ?></td>
                  </tr>
                  <tr>
                    <td>Modul</td><td><?php echo $du['nmmapel']; ?></td>
                  </tr>
                  <tr>
                    <td>Trainer</td>
                    <td><?php echo $du['nmguru']; ?></td>
                  </tr>
                  <tr>
                    <td>Nama Ujian</td>
                    <td><?php echo $du['nama_ujian']; ?></td>
                  </tr>
                  <tr>
                    <td>Jumlah Soal</td><td><?php echo $jumlah_soal; ?></td>
                  </tr>
                  <tr>
                    <td>Waktu</td>
                    <td><?php echo $du['waktu']; ?> menit</td>
                  </tr>
                  <tr>
                    <td>Keterangan</td>
                    <td><?php echo ($du['izin'] == 0) ? 'Ujian belum di setujui' : 'Selamat Ujian' ; ?></td>
                  </tr>

                  <input type="hidden" name="token" id="token" required="true" class="form-control col-md-12" value="<?php echo $du['token']; ?>">
                   <!-- <?php if($du['status_token'] == 1){ ?>
                    <tr><td><input type="text" name="token" id="token" required="true" class="form-control col-md-12" ></td></tr>
                  <?php } else { ?>
                    <tr><td>Token</td><td><input type="hidden" name="token" id="token" required="true" class="form-control col-md-12" value="<?php echo $du['token']; ?>"></td></tr> -->
                  <?php } ?> 
                </table>
              </div>
            </div>
          </div>

          <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-body">
                <div class="alert alert-info">
                  Waktu boleh mengerjakan ujian adalah saat tombol "MULAI" berwarna hijau..!
                </div>
                 <?php if ($du['izin'] == 1): ?>
                <div id="btn_mulai">Ujian akan mulai dalam 
                     <div id="akan_mulai"></div>
                </div>
                 <?php endif ?>

                <div class="btn btn-danger" id="waktu_" style="margin-top: 20px">
                  Sisa waktu mengikuti ujian <br>
                  <span id="waktu_akhir_ujian"></span>
                </div>

                <div id="waktu_game_over"></div>

            <!--
            <a href="#" class="btn btn-success btn-lg" id="tbl_mulai" onclick="return konfirmasi_token(<?php echo $du['id']; ?>)"><i class="fa fa-check-circle"></i> MULAI</a>
            <div class="btn btn-danger" id="ujian_selesai">UJIAN TELAH SELESAI</div>
          -->
        </div>
      </div>
    </div>

  </div>
</div>
</div>
</div>
</div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    timer4();
  })
>>>>>>> first push
</script>