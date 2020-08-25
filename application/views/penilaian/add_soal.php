<style type="text/css">
	.errors{
		color: #ff2121;
		font-weight: bold;
	}

	.errors-input{
		border: 1px solid #ff2121;
	}
</style>
<div class="col-md-9 page-content">
	<div class="inner-box">
		<div class="row">
			<div class="col-sm-12 col-md-6 col-lg-6">
                <h2>Form Tambah <?=$this->page_title;?></h2>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6 text-right">
                <?= $this->backButton; ?>
            </div>
        </div>
		<section class="m-2">
			<?php if(!empty($this->session->flashdata('error')) ) { ?>
			<p class="alert alert-danger"> <?= $this->session->flashdata('error'); ?></p>
			<?php } ?>

			<?php if(!empty($this->session->flashdata('success')) ) { ?>
			<p class="alert alert-success"> <?= $this->session->flashdata('success'); ?></p>
			<?php } ?>

		</section>
		<?php echo form_open_multipart($targetUrl, "class='form-horizontal'"); ?>
			<input type="hidden" name="id" id="id" value="<?php echo $d['id']; ?>">
			<div id="konfirmasi"></div>

			<div class="form-group fgsoal">
				<input type="hidden" name="url" value="<?= $url; ?>">
				<input type="hidden" name="from_url" value="<?= $from_url; ?>">
				<input type="hidden" name="mode" id="mode" value="<?php echo $d['mode']; ?>">
				<input type="hidden" name="id_paket" id="id_paket" value="<?php echo $id_paket; ?>">
			</div>

			<div class="form-group fgsoal">
				<div class="col-md-5"><label>Teks Soal</label></div>
				<div class="col-md-30">
					<input type="file" name="file_ujian_soal" id="file_ujian_soal" class="btn btn-info upload">
					<?php
					if (is_file($soalPath . $d['file'])) {
						echo tampil_media($soalPath . $d['file'], "100%");
						$number = 1;
						echo '<a href="#" data-id="'.$d['id'].'" class="btn btn-danger btn-sm mr-2 hapus-soal-file"><i class="glyphicon glyphicon-random" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Hapus File</a>';
					}
					?>
				</div>
				<div class="col-md-30">
					<textarea class="form-control" id="editornya" style="height: 50px;" name="soal"><?php echo $d['soal']; ?></textarea>
				</div>
			</div>

			<?php
			for ($j = 0; $j < $jml_opsi; $j++) {
				$idx = $huruf_opsi[$j];
				?>

				<div class="form-group fgsoal">
					<div class="col-md-2"><label>Jawaban <?php echo $huruf_opsi[$j]; ?></label></div>
					<div class="col-md-3">
						<input type="file" name="opsi_<?php echo $huruf_opsi[$j]; ?>" id="gambar_soal" class="btn btn-success upload"><br>
						<?php
						
						if (is_file($opsiPath . $data_pc[$idx]['gambar'])) {
							echo tampil_media($opsiPath . $data_pc[$idx]['gambar'], "100%");	
							$number1 = 2;$number2 = 3;$number3 = 4;$number4 = 5;$number5 = 6;
							
							if($huruf_opsi[$j] == "a"){
								echo '<a href="#" data-opsi="a" data-id="'.$d['id'].'" class="btn btn-danger btn-sm mr-2 hapus-opsi-file"><i class="glyphicon glyphicon-random" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Hapus File</a>';
							}else if($huruf_opsi[$j] == "b"){
								echo '<a href="#" data-opsi="b" data-id="'.$d['id'].'" class="btn btn-danger btn-sm mr-2 hapus-opsi-file"><i class="glyphicon glyphicon-random" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Hapus File</a>';
							}else if($huruf_opsi[$j] == "c"){
								echo '<a href="#" data-opsi="c" data-id="'.$d['id'].'" class="btn btn-danger btn-sm mr-2 hapus-opsi-file"><i class="glyphicon glyphicon-random" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Hapus File</a>';
							}else if($huruf_opsi[$j] == "d"){
								echo '<a href="#" data-opsi="d" data-id="'.$d['id'].'" class="btn btn-danger btn-sm mr-2 hapus-opsi-file"><i class="glyphicon glyphicon-random" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Hapus File</a>';
							}else if($huruf_opsi[$j] == "e"){
								echo '<a href="#" data-opsi="e" data-id="'.$d['id'].'" class="btn btn-danger btn-sm mr-2 hapus-opsi-file"><i class="glyphicon glyphicon-random" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Hapus File</a>';
							}
							
							
						}
						?>
					</div>
					<div class="col-md-30">
						<textarea class="form-control" id="editornya_<?php echo $huruf_opsi[$j]; ?>" style="height: 30px" name="opsi_<?php echo $huruf_opsi[$j]; ?>"><?php echo $data_pc[$idx]['opsi']; ?></textarea>
					</div>
				</div>

			<?php } ?>
			<br><br>
			<div class="form-group">
				<label for="">Pilih Dimensi</label>
				<select name="dimensi" id="dimensi" required class="form-control">
					<?php 
						$selected_dimensi = isset($d['id_dimensi']) ? $d['id_dimensi'] : 0;
						$dimensi = $this->m_dimensi->get_all();
						foreach($dimensi as $data) :
					 ?>
					 	<?php if($data->id == $selected_dimensi) { ?>
					 		<option value="<?= $data->id; ?>" selected><?= $data->nama; ?></option>
					 	<?php } else { ?>
							<option value="<?= $data->id; ?>"><?= $data->nama; ?></option>
					 	<?php } ?>
						
					<?php endforeach; ?>
				</select>
			</div>
			<div class="form-group">
				<label for="">Bobot Indikator</label>
				<input type="text" class="form-control" name="bobot" value="<?= isset($d['bobot']) ? $d['bobot'] : ''; ?>" required>
			</div>
			<div class="form-group" style="margin-top: 20px">
				<div class="col-md-12">
					<button type="submit" class="btn btn-info"><i class="fa fa-check"></i> Simpan</button>
					<?php $url = 'penilaian/data_soal/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6);?>
					<a href="javascript:void(0);" onclick="back_page('<?=$url;?>')" class="btn btn-default"><i class="fa fa-minus-circle"></i> Kembali</a>
				</div>
			</div>
			</form>
		
	</div>

</div>
</div>
<!--/.row-box End-->

<script src="<?= base_url(); ?>assets/js/jquery/jquery-3.3.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugin/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		let self, conf;
		if (editor_style == "inline") {
			CKEDITOR.inline('editornya');
			CKEDITOR.inline('editornya_a');
			CKEDITOR.inline('editornya_b');
			CKEDITOR.inline('editornya_c');
			CKEDITOR.inline('editornya_d');
			CKEDITOR.inline('editornya_e');
		} else if (editor_style == "replace") {
			CKEDITOR.replace('editornya');
			CKEDITOR.replace('editornya_a');
			CKEDITOR.replace('editornya_b');
			CKEDITOR.replace('editornya_c');
			CKEDITOR.replace('editornya_d');
			CKEDITOR.replace('editornya_e');
		}

		
		$('.hapus-opsi-file').click(function(e) {
			e.preventDefault();
			self = this;
			conf = confirm('Anda yakin akan menghapus file ini?');
			if(conf) {
				$.ajax({
					type: 'post',
					url: "<?= base_url('penilaian/hapus-opsi-file') ?>",
					data: {
						opsi: $(self).data('opsi'),
						id: $(self).data('id')
					},
					dataType: 'json',
					success: function(res) {
						window.location.reload();
					}
				});
			}
		});

		$('.hapus-soal-file').click(function(e) {
			e.preventDefault();
			self = this;
			conf = confirm('Anda yakin akan menghapus file ini?');
			if(conf) {
				$.ajax({
					type: 'post',
					url: "<?= base_url('penilaian/hapus-soal-file') ?>",
					data: {
						id: $(self).data('id')
					},
					dataType: 'json',
					success: function(res) {
						window.location.reload();
					}
				});
			}
		})
	});
</script>





