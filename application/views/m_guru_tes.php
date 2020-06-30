<div class="row col-md-12 ini_bodi">
  <div class="panel panel-info">
  <?php foreach($nama as $d) :?>
    <div class="panel-heading">Daftar Kuis  <b><?= $d['nama']; ?></b>
    <?php endforeach ?>
      <div class="tombol-kanan">
<?php 
$uri4 = $this->uri->segment(4);
?>      
 <?php if( $this->session->userdata('admin_level') == "guru"){ ?>
        <a class="btn btn-success btn-sm tombol-kanan" href="#" onclick="return m_ujian_a(<?= $uri4; ?>);"><i class="glyphicon glyphicon-plus"></i> &nbsp;&nbsp;Tambah</a>
        <?php } ?>
      </div>
    </div>
    <div class="panel-body">


      <table class="table table-bordered" id="datatabel">
        <thead>
          <tr>
            <th width="5%">No</th>
            <th width="20%">Nama Tes</th>
            <th width="20%">Nama Modul</th>
            <th width="10%">Jumlah Soal</th>
            <th width="15%">Waktu</th>
            <th width="15%">Pengacakan Soal</th>
            <th width="15%">Status Modul</th>
            <th width="15%">Opsi</th>
          </tr>
        </thead>

        <tbody></tbody>
      </table>
    
      </div>
    </div>
  </div>
</div>
                    

<div class="modal fade bd-example-modal-lg" id="ujian_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
       <div class="modal-content">
      <div class="modal-header">
        <h4 id="myModalLabel">Buat Ujian</h4>
      </div>
      <div class="modal-body">
        <div class="alert alert-info">
        <a href="#" onclick="return view_petunjuk('petunjuk');">petunjuk ..?</a>
        <div id="petunjuk">
          <ul>
            <li><b>Jml Soal</b>, harap dimasukkan sesuai jumlah soal yang sudah ada di bank soal</li>
            <li><b>Tgl Mulai</b>, adalah waktu awal boleh mulai meng-klik tombol "mulai ujian"</li>
            <li><b>Tgl Selesai</b>, adalah waktu akhir boleh mulai meng-klik tombol "mulai ujian"</li>
            <li><b>Acak Soal</b>, jika dipilih acak, maka soal akan diacak, jika diurutkan, maka akan diurutkan berdasarkan urutan soal masuk</li>
          </ul>
        </div>
      </div>

          <form name="f_ujian" id="f_ujian" onsubmit="return m_ujian_s();">
            <input type="hidden" name="id" id="id" value="0">
            <input type="hidden" name="jumlah_soal1" id="jumlah_soal1" value="0">
              <table class="table table-form">
                <tr><?php echo form_dropdown('mapel', $p_mapel, '', 'class="form-control"  id="mapel" hidden'); ?></tr>
		<tr><td style="width: 25%">Nama Ujian</td><td style="width: 75%"><input type="text" class="form-control" name="nama_ujian" id="nama_ujian" required></td></tr>
                <tr><td>Jumlah soal</td><td><?php echo form_input('jumlah_soal', '', 'class="form-control" number id="jumlah_soal" required'); ?></td></tr>
                <tr><td>Tgl Mulai</td><td>
                  <input type="date" name='tgl_mulai' class="form-control" style="width: 100%; display: inline; float: left" id="tgl_mulai" placeholder="Tgl" data-tooltip="waktu awal boleh menge-klik tombol \"mulai\" ujian" required>
                  <input type="hidden" name='wkt_mulai' class="form-control" style="width: 130px; display: inline; float: left" id="wkt_mulai" placeholder="Waktu" required >
                </td></tr>
                <tr><td>Tgl Selesai</td><td>
                  <input type="date" name='terlambat' class="form-control" style="width: 100%; display: inline; float: left" id="terlambat" placeholder="Tgl" required>
                  <input type="hidden" name='terlambat2' class="form-control" style="width: 130px; display: inline; float: left" id="terlambat2" placeholder="Waktu" required >
                </td></tr>
                <tr><td>Waktu Ujian</td><td><?php echo form_input('waktu', '', 'class="form-control" id="waktu" placeholder="menit" required style="width: 100px; display: inline; float: left"'); ?> <div style="float: left; margin: 4px 0 0 10px"> menit</div></td></tr>
                <tr><td>Acak Soal</td><td><?php echo form_dropdown('acak', $pola_tes, 'acak', 'class="form-control"  id="acak" required'); ?></td></tr>
		<tr><td>Token Ujian</td><td><?php echo form_dropdown('token', $token, '', 'class="form-control"  id="token" required'); ?></td></tr>
              </table>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i> Simpan</button>
        <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="fa fa-minus-circle"></i> Tutup</button>
      </div>
        </form>
    </div>
  </div>
</div>


<div class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">

  </div>
</div>
