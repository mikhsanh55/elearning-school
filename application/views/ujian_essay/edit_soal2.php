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
				<h2>Form Tambah Soal Essay</h2>
			</div>
			<div class="col-sm-12 col-md-6 col-lg-6 text-right">
				<a href="<?= base_url('ujian_essay/data_soal/' . $this->uri->segment(3)); ?>" class="btn btn-light">Kembali</a>
			</div>
		</div>
		
		<?php echo form_open_multipart(base_url() . "ujian_essay/updateSoal", "class='form-horizontal'"); ?>
			<div id="konfirmasi" class="m-3">
				<?= $this->session->flashdata('msg'); ?>
			</div>

			<div class="form-group fgsoal">
				<input type="hidden" name="id_ujian" id="id_ujian" value="<?php echo $id_ujian; ?>">
				<input type="hidden" name="id" id="id" value="<?= $id; ?>">
			</div>

			<div class="form-group fgsoal">
				<div class="col-md-5"><label>Teks Soal</label></div>
				<div class="col-md-30">
					<?php if(!empty($data->file)) { 
						$mediaSoal = getMediaSoalFile($data->file, $this->_fileSoalPath, $data->tipe_file);
							echo $mediaSoal . '<button class="btn btn-danger btn-sm hapus-file-soal" data-id="'.$id.'" onclick="hapusFileSoal(this, event)">Hapus </button><br><br>';
						}
					?>
					<input type="file" name="file_ujian_soal_essay" id="file_ujian_soal_essay" class="btn btn-info upload">
				</div>
				<div class="col-md-30">
					<textarea class="form-control" id="editornya" style="height: 50px;" name="soal"><?= $data->soal; ?></textarea>
				</div>
			</div>

			<div class="form-group fgsoal">
		
				<div class="col-md-12"><label>Bobot Nilai Soal</label></div>
				<div class="col-md-5"><input type="text" name="bobot" class="form-control" required value="<?= $data->bobot; ?>"></div>
			</div>
			<div class="form-group" style="margin-top: 20px">
				<div class="col-md-12">
					<button type="submit" id="btn-submit" class="btn btn-primary btn-block">
						<i class="fas fa-spinner spin-icon d-none"></i> 
						<span>Simpan</span>
					</button>
					<a href="<?= base_url('ujian_essay/data_soal/' . $id_ujian); ?>" class="btn btn-default btn-block"><i class="fa fa-minus-circle"></i> Kembali</a>
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
		if (editor_style == "inline") {
			CKEDITOR.inline('editornya');
		} else if (editor_style == "replace") {
			CKEDITOR.replace('editornya');
		}

		$('form').on('submit', () => {
			let content = CKEDITOR.instances['editornya'].getData();

			if(content == '' || content == null) {
				alert('harap isi pertanyaan!');
				$('#file_ujian_soal_essay').val('');
				return false;
			}

			$('#btn-submit').prop('disabled', true);
			$('#btn-submit span').toggleClass('d-none');
			$('#btn-submit i').toggleClass('d-none');
		});

		$('.hapus-file-soal').on('click', function(e) {
			hapusSoalFile(this, e);
		});
	});
	function hapusSoalFile(self, e) {
		e.preventDefault();
		conf = confirm('Anda yakin?');

		if(conf) {
			$.ajax({
				type: 'post',
				url: "<?= base_url('ujian_essay/hapus_file_soal') ?>",
				data: {
					id: $(self).data('id')
				},
				dataType: 'json',
				success: () => window.location.reload(),
				error: e => {
					console.error(e.responseJSON);
					alert(e.responseJSON.msg);
					return false;
				}
			});
		}
	}
</script>