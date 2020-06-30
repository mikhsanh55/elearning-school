<style>
  table {
    width: 100%;
    padding: 10px 40px;
    font-size: 12px;
  }

  td {
  
    border-top: 1px solid #eaeaea;
  }
</style>
<div class="container-fluid">
  <div class="row" id="page-contents">

    <div class="offset-lg-1 col-lg-10">
      <div class="career-page">
        <div class="carrer-title">

          <div class="row">

            <div class="col-lg-12 col-sm-6">
              <div class="open-position" style="border-radius: 10px;">
                <div class="card" style="width: 50rem;">
                  <!-- <img src="<?= base_url('assets/front/'); ?>images/example.jpg" class="card-img-top rounded img-thumbnail" alt="thumb-5"> -->
                  <div class="card-body">

                    <h5 class="card-title"><?php echo ($du['izin'] == 0) ? 'Ujian belum di setujui' : 'Selamat Ujian'; ?></h5>

                    <input type="hidden" name="id_ujian" id="id_ujian" value="<?php echo encrypt_url($du['id']); ?>">
                    <input type="hidden" name="_token" id="_token" value="<?php echo $du['token']; ?>">
                    <input type="hidden" name="_tgl_sekarang" id="_tgl_sekarang" value="<?php echo date('Y-m-d H:i:s'); ?>">
                    <input type="hidden" name="_tgl_mulai" id="_tgl_mulai" value="<?php echo $tgl_mulai; ?>">
                    <input type="hidden" name="_terlambat" id="_terlambat" value="<?php echo $terlambat; ?>">
                    <input type="hidden" name="_statuse" id="_statuse" value="<?php echo $du['statuse']; ?>">

                    <table border="0">
                      <tr>
                          <th>Nama</th>
                          <th>Modul</th>
                          <th>Trainer</th>
                          <th>Nama Ujian</th>
                          <th>Jumlah Soal</th>
                          <th>Waktu</th>
                      </tr>
                      <tr>
                        <td><?php echo $dp->nama; ?></td>
                        <td><?php echo $du['nmmapel']; ?></td>
                        <td><?php echo $du['nmguru']; ?></td>
                        <td><?php echo $du['nama_ujian']; ?></td>
                        <td><?php echo $du['jumlah_soal']; ?></td>
                        <td><?php echo $du['waktu']; ?> menit</td>
                      </tr>
             

                      <input type="hidden" name="token" id="token" required="true" class="form-control col-md-12" value="<?php echo $du['token']; ?>">
                      <!-- <?php if ($du['status_token'] == 1) { ?>
                    <tr><td><input type="text" name="token" id="token" required="true" class="form-control col-md-12" ></td></tr>
                  <?php } else { ?>
                    <tr><td>Token</td><td><input type="hidden" name="token" id="token" required="true" class="form-control col-md-12" value="<?php echo $du['token']; ?>"></td></tr> -->
                    <?php } ?>
                    </table>
                    <br>
                    <p class="card-text">
                      Waktu boleh mengerjakan ujian adalah saat tombol "MULAI" berwarna hijau..!
                    </p>

                    <?php if ($du['izin'] == 1) : ?>
                      <div id="btn_mulai">Ujian akan mulai dalam
                        <div id="akan_mulai"></div>
                      </div>
                    <?php endif ?>

                    <div class="btn btn-danger btn-sm" id="waktu_" style="margin-top: 20px">
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
</div>
</div>
<script src="<?= base_url(); ?>assets/js/jquery/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    timer2();
  })
</script>