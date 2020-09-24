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
                <h2>Form Tambah Soal Penilaian</h2>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6 text-right">
                <a class="btn btn-light" href="<?= base_url('penilaian/data_soal/') . $idPaket; ?>">Kembali</a>
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
		<?php echo form_open_multipart('penilaian/insertSoal', "class='form-horizontal'"); ?>
			<div id="konfirmasi"></div>

			<div class="form-group fgsoal">
				<input type="hidden" name="id_paket" id="id_paket" value="<?php echo $idPaket; ?>">
			</div>

			<div class="form-group fgsoal">
				<div class="col-md-5"><label>Teks Soal</label></div>
				<div class="col-md-30">
					<input type="file" name="file_gambar_soal" id="file_gambar_soal" class="btn btn-info upload">
				</div>
				<div class="col-md-30">
					<textarea class="form-control" id="editornya" style="height: 50px;" name="soal"></textarea>
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
						<textarea class="form-control" id="editornya_<?= $opsi; ?>" style="height: 30px" name="opsi_<?= $opsi; ?>"></textarea>
					</div>
				</div>

			<?php } ?>
			<br><br>
			<div class="form-group">
				<label for="">Bobot </label>
				<input type="text" class="form-control" name="bobot" value="1" required>
			</div>
			<div class="form-group" style="margin-top: 20px">
				<div class="col-md-12">
					<button type="submit" class="btn btn-primary btn-block" id="btn-submit">
						<i class="fas fa-spinner spin-icon d-none"></i>
						<span> Simpan</span>
					</button>
					<a href="<?= base_url('penilaian/data_soal' . $idPaket) ?>" class="btn btn-default btn-block"><i class="fa fa-minus-circle"></i> Kembali</a>
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

		$('form').on('submit', () => {
			$('#btn-submit').prop('disabled', true);
			$('#btn-submit span').toggleClass('d-none');
			$('#btn-submit i').toggleClass('d-none');
		});
	});
</script>