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
		<div class="row align-items-center mb-4">
			<div class="col-sm-12 col-md-6 col-lg-6">
				<h2>Form Tambah Ujian</h2>
			</div>
			<div class="col-sm-12 col-md-6 col-lg-6 text-right">
				<a href="<?= base_url('ujian_real/data_soal/' . $idUjian); ?>" class="btn btn-light" >Kembali</a>
			</div>
		</div>
		
		<?php echo form_open_multipart(base_url() . "ujian_real/insertSoal", "class='form-horizontal'"); ?>
			<div id="konfirmasi"></div>

			<div class="form-group fgsoal">
				<input type="hidden" name="id_ujian" id="id_ujian" value="<?php echo $idUjian; ?>">
			</div>

			<div class="form-group fgsoal">
				<div class="col-md-5"><label>Teks Soal</label></div>
				<div class="col-md-30">
					<input type="file" name="file_ujian_soal" id="file_ujian_soal" class="btn btn-info upload">
				</div>
				<div class="col-md-30">
					<textarea class="form-control" id="editornya" style="height: 50px;" name="soal" required></textarea>
				</div>
			</div>

			<?php
			for ($j = 0; $j < count($hurufOpsi); $j++) {
				$opsi = $hurufOpsi[$j]; // a, b, ...

			?>

				<div class="form-group fgsoal">
					<div class="col-md-2"><label>Jawaban <?= $opsi; ?></label></div>
					<div class="col-md-3">
						<input type="file" name="gj<?= $opsi; ?>" id="gambar_soal" class="btn btn-success upload"><br>
					</div>
					<div class="col-md-30">
						<textarea class="form-control" id="editornya_<?= $opsi; ?>" style="height: 30px" name="opsi_<?= $opsi; ?>" required></textarea>
					</div>
				</div>

			<?php } ?>

			<div class="form-group fgsoal">
				<div class="col-md-4"><label>Kunci Jawaban</label></div>
				<div class="col-md-7">
					<select class="form-control" name="jawaban" id="jawaban" required>
						<?php
						for ($i = 0; $i < count($hurufOpsi); $i++) {
							$opsi = strtoupper($hurufOpsi[$i]);
						?>
							<option value="<?= $opsi; ?>">
								<?= $opsi; ?>
							</option>
						<?php } ?>
					</select>
				</div>
				<?php if($bobot->bobot === 1) {?>
				
				<div class="col-md-12"><label>Bobot Nilai Soal</label></div>
				<div class="col-md-5"><input type="text" name="bobot" class="form-control" required value="1"></div>
				<?php } else { ?>
					<input type="hidden" name="bobot" value="1">
				<?php } ?>
			</div>
			<div class="form-group" style="margin-top: 20px">
				<div class="col-md-12">
					<button type="submit" id="simpan-btn" class="btn btn-primary btn-block">
						<i class="fas fa-spinner mr-2 spin-icon d-none"></i>
						<span>Simpan</span>
					</button>
					<a href="<?= base_url('ujian_real/data_soal/' . $idUjian); ?>" class="btn btn-default btn-block"><i class="fa fa-minus-circle"></i> Kembali</a>
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
		let id, opsi, file, conf;
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

		
	});

	$('form').on('submit', function() {
		let inputSoal = CKEDITOR.instances['editornya'].getData(),
			inputOpsiA = CKEDITOR.instances['editornya_a'].getData(),
			inputOpsiB = CKEDITOR.instances['editornya_b'].getData(),
			inputOpsiC = CKEDITOR.instances['editornya_c'].getData(),
			inputOpsiD = CKEDITOR.instances['editornya_d'].getData(),
			inputOpsiE = CKEDITOR.instances['editornya_e'].getData();

		if(inputSoal == '' || inputSoal == null) {
			alert('Harap lengkapi soal dan kunci jawabannya!');
			return false;
		}

		$('#simpan-btn').prop('disabled', true);
		$('#simpan-btn i').toggleClass('d-none');
		$('#simpan-btn span').toggleClass('d-none');
	});

	function hapusOpsiFile(self, event) {
		
		conf = confirm('Anda yakin?');
		if(conf) {
			id = $(self).data('id');
			opsi = $(self).data('opsi');
			file = $(self).data('file');
			$.ajax({
				type: 'post',
				url: "<?= base_url('ujian/hapus-opsi-file') ?>",
				data: {
					id,
					opsi,
					file
				},
				dataType: 'json',
				success: () => window.location.reload(),
				error: (e) => {
					alert(e.responseText.msg);
					console.error(e.responseText);
					return false;
				}
			});
		}
	}

	function hapusSoalFile(self, event) {
		conf = confirm('Anda yakin?');
		if(conf) {
			id = $(self).data('id');

			$.ajax({
				type: 'post',
				url: "<?= base_url('ujian/hapus-soal-file'); ?>",
				data: {
					id
				},
				dataType: 'json',
				success: () => window.location.reload(),
				error: (e) => {
					alert(e.responseText.msg);
					console.error(e.responseText);
					return false;
				}
			});
		}
	}
</script>	