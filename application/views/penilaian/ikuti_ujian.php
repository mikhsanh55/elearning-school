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
                    <td>Guru</td>
                    <td><?php echo $du['nama_guru']; ?></td>
                  </tr>
                  <tr>
                    <td>Mata Pelajaran</td>
                    <td><?= $du['nama_mapel']; ?></td>
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
                    <td><?php echo ($du['izin'] == 0) ? 'Ujian belum di setujui' : 'Silahkan mengikuti penilaian' ; ?></td>
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
    var tgl_sekarang = $("#_tgl_sekarang").val();
    var tgl_mulai = $("#_tgl_mulai").val();
      var tgl_terlambat = $("#_terlambat").val();
    var id_ujian = $("#id_ujian").val();
    var statuse = $("#_statuse").val();
    statuse = parseInt(statuse);
    if (statuse == 1) {
      $("#btn_mulai").html(`<a href="${base_url}/penilaian/ikut_ujian/${id_ujian}" target="_blank" class="btn btn-primary btn-block" id="tbl_mulai"><i class="fa fa-check-circle"></i> MULAI</a>`);
      
      $('#waktu_akhir_ujian').countdowntimer({
            startDate : tgl_sekarang,
            dateAndTime : tgl_terlambat,
            size : "lg",
            labelsFormat : true,
        timeUp : hilangkan_tombol,
        });
    } else if (statuse == 0) {
      $("#btn_mulai").html(`<a href="${base_url}/penilaian/ikut_ujian/${id_ujian}" target="_blank" class="btn btn-primary btn-block" id="tbl_mulai"><i class="fa fa-check-circle"></i> MULAI</a>`);
      $("#waktu_").hide();
      $('#akan_mulai').countdowntimer({
            startDate : tgl_sekarang,
            dateAndTime : tgl_mulai,
            size : "lg",
            labelsFormat : true,
        timeUp : timeIsUp,
        });
    } else if (statuse == 2) {
      hilangkan_tombol();
    } else {
      hilangkan_tombol();
    }
  })
</script>