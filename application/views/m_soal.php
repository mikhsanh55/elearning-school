<?php 
$uri4 = $this->uri->segment(4);
$uri6 = $this->uri->segment(6);
$uri7 = $this->uri->segment(7);
?>

<div class="row col-md-12 ini_bodi">
  <div class="panel panel-info">
    <div class="panel-heading">Data Soal <b><div id= "ket"></div></b>

	  <div class="tombol-kanan">
	  <?php if( $this->session->userdata('admin_level') == "guru"){ ?>
        <a class="btn btn-success btn-sm" href="#" onclick="return m_ujian_soal(<?= $uri6; ?>);"><i class="glyphicon glyphicon-plus" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Tambah Data</a>  
         <!-- <a class="btn btn-success btn-sm" href="#" onclick="return import_soal(<?= $uri6; ?>);"><i class="glyphicon glyphicon-plus" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Import Data Pdf</a>      -->
	  <?php } ?>
        <a class="btn btn-warning btn-sm tombol-kanan" href="<?php echo base_url(); ?>upload/format_soal_download-1.xlsx" ><i class="glyphicon glyphicon-download"></i> &nbsp;&nbsp;Download Format Import</a>
        <a class="btn btn-info btn-sm tombol-kanan" href="<?php echo base_url('soal/m_soal/import/'.$uri6); ?>" ><i class="glyphicon glyphicon-upload"></i> &nbsp;&nbsp;Import Excel</a>
        <!-- <a href='<?php echo base_url(); ?>soal/m_soal/cetak/<?php echo $uri4; ?>' class='btn btn-info btn-sm' target='_blank'><i class='glyphicon glyphicon-print'></i> Cetak</a> -->
      </div>
    </div>
    <div class="panel-body">
        
        <?php echo $this->session->flashdata('k'); ?>
          
        <table class="table table-responsive table-bordered" style="width:100%; padding:10px;" id="datatabel">
          <thead>
            <tr>
              <td width="5%">No</td>
              <td width="50%">Soal</td>
              <td width="15%">Materi/<?=$this->transTheme->guru;?></td>
              <td width="15%">Analisa</td>
              <td width="15%">Opsi</td>
            </tr>
          </thead>

          <tbody>

          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>



<div class="modal fade bd-example-modal-lg" id="form_uji" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        		<div class="panel-body">
				<?php echo form_open_multipart(base_url() . "soal/m_soal/simpan", "class='form-horizontal'"); ?>
			<input type="hidden" name="id" id="id" value="<?php echo $d['id']; ?>">
			<input type="hidden" name="mode" id="mode" value="<?php echo $d['mode']; ?>">
			<div id="konfirmasi"></div>

			<div class="form-group fgsoal">

				<div class="col-md-12"><?php echo form_dropdown('id_mapel', $p_mapel, $d['id_mapel'], 'class="form-control" id="id_mapel" required hidden'); ?></div>
			</div>

            <div class="form-group fgsoal">

				<div class="col-md-12"><?php echo form_dropdown('id_guru', $p_guru, $d['id_guru'], 'class="form-control" id="id_guru" required hidden'); ?></div>
			</div>


			<div class="form-group fgsoal">
				<div class="col-md-5"><label>Teks Soal</label></div>
				<div class="col-md-30">
					<input type="file" name="gambar_soal" id="gambar_soal" class="btn btn-info upload">
					<?php
					if (is_file('./upload/gambar_soal/' . $d['file'])) {
						echo tampil_media('./upload/gambar_soal/' . $d['file'], "100%");
					}
					?>
				</div>
				<div class="col-md-30">
					<textarea class="form-control editornya" id="editornya" style="height: 50px;" name="soal"><?php echo $d['soal']; ?></textarea>
				</div>
			</div>

			<?php
			for ($j = 0; $j < $jml_opsi; $j++) {
				$idx = $huruf_opsi[$j];
				?>

				<div class="form-group fgsoal">
					<div class="col-md-2"><label>Jawaban <?php echo $huruf_opsi[$j]; ?></label></div>
					<div class="col-md-3">
						<input type="file" name="gj<?php echo $huruf_opsi[$j]; ?>" id="gambar_soal" class="btn btn-success upload"><br>
						<?php
						if (is_file('./upload/gambar_opsi/' . $data_pc[$idx]['gambar'])) {
							echo tampil_media('./upload/gambar_opsi/' . $data_pc[$idx]['gambar'], "100%");
						}
						?>
					</div>
					<div class="col-md-30">
						<textarea class="form-control editornya_<?php echo $huruf_opsi[$j]; ?>" id="editornya_<?php echo $huruf_opsi[$j]; ?>" style="height: 30px" name="opsi_<?php echo $huruf_opsi[$j]; ?>"><?php echo $data_pc[$idx]['opsi']; ?></textarea>
					</div>
				</div>

			<?php } ?>

			<div class="form-group fgsoal">
				<div class="col-md-4"><label>Kunci Jawaban</label></div>
				<div class="col-md-7">
					<select class="form-control" name="jawaban" id="jawaban" required>
						<?php
						for ($o = 0; $o < $jml_opsi; $o++) {
							$_opsi = strtoupper($huruf_opsi[$o]);
							if ($d['jawaban'] == $_opsi) {
								echo '<option value="' . $_opsi . '" selected>' . $_opsi . '</option>';
							} else {
								echo '<option value="' . $_opsi . '">' . $_opsi . '</option>';
							}
						}
						?>
					</select>
				</div>
				<div class="col-md-12"><label>Bobot Nilai Soal</label></div>
				<div class="col-md-5"><input type="text" name="bobot" class="form-control" required value="<?php echo $d['bobot']; ?>"></div>
			</div>
			<div class="form-group" style="margin-top: 20px">
				<div class="col-md-12">
					<button type="submit" class="btn btn-info"><i class="fa fa-check"></i> Simpan</button>
					 <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="fa fa-minus-circle"></i> Tutup</button>
				</div>
			</div>
			</form>
		</div><!-- panel body-->
    </div>
  </div>
</div>

<div class="modal fade bd-example-modal-lg" id="form_soal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        		<div class="panel-body">
				<?php echo form_open_multipart(base_url() . "soal/import_soal/",array('id' => 'fupForm','class'=>'form-horizontal')); ?>
			<input type="hidden" name="id" id="id" value="<?php echo $d['id']; ?>">
			<input type="hidden" name="mode" id="mode" value="<?php echo $d['mode']; ?>">
			<div id="konfirmasi"></div>

			<div class="form-group fgsoal">

				<div class="col-md-12"><?php echo form_dropdown('id_mapel', $p_mapel, $d['id_mapel'], 'class="form-control" id="id_mapel2" hidden required '); ?></div>
			</div>

            <div class="form-group fgsoal">

				<div class="col-md-12"><?php echo form_dropdown('id_guru', $p_guru, $d['id_guru'], 'class="form-control" id="id_guru2" hidden required '); ?></div>
			</div>


			<div class="form-group fgsoal">
				<div class="col-md-5"><label>Import Soal (*PDF)</label></div>
				<div class="col-md-30">
					<input type="file" name="file_import" id="file_import" class="btn upload">
				</div>
				<span id="kotakUpload"></span>
			</div>



			<div class="form-group" style="margin-top: 20px">
				<div class="col-md-12">
					 <button type="submit" id="upload" class="btn btn-success submitBtn"><i class="fa fa-check"></i> Import</button>
					 <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="fa fa-minus-circle"></i> Tutup</button>
				</div>
			</div>
			</form>
		</div><!-- panel body-->
    </div>
  </div>
</div>
<script src="<?= base_url(); ?>assets/js/jquery/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
	$(function(){
    $('#upload').hide();
    //mencegah browser dari membuka file ketika didrag and drop
    $(document).on('drop dragover', function (e) {
        e.preventDefault();
    });
    //memanggil fungsi untuk menangani file upload saat milih File
    $('input[type=file]').on('change', fileUpload);
});
function fileUpload(event){
    //memberitahu pengguna tentang status file upload
    $("#kotakUpload").html(event.target.value+" sudah dipilih...");
    
    //mendapatkan file yang dipilih
    files = event.target.files;
    
    //memeriksa data form 
    var data = new FormData();                                   
    //file data is presented as an array
    for (var i = 0; i < files.length; i++) {
        var file = files[i];
        if(!file.type.match('pdf.*')) {              
            //memeriksa format file
            $("#kotakUpload").html("Silakan pilih file pdf.");
            $('#upload').hide();
        }else if(file.size > 1048576){
            //memeriksa ukuran file (dalam bytes)
            $("#kotakUpload").html("Maaf, file Anda terlalu besar (melebihi 1 MB)");
            $('#upload').hide();
        }else{
        	$('#upload').show();
        }
    }
}


$(document).ready(function(e){
    // Submit form data via Ajax
    $("#fupForm").on('submit', function(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?=base_url('soal/import_soal/');?>',
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('.submitBtn').attr("disabled","disabled");
                $('#fupForm').css("opacity",".5");
            },
            success: function(response){ //console.log(response);
                $('#kotakUpload').html('');
                if(response.status == 1){
    				location.reload();
                    $('#kotakUpload').html('<p class="alert alert-success">'+response.message+'</p>');
                }else{
                    $('#kotakUpload').html('<p class="alert alert-danger">'+response.message+'</p>');
                }
                $('#fupForm').css("opacity","");
                $(".submitBtn").removeAttr("disabled");
            }
        });
    });
});

</script>

