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
				<h2>Form Tambah <?=$this->page_title;?></h2>
			</div>
			<div class="col-sm-12 col-md-6 col-lg-6 text-right">
				<a href="<?= base_url('ujian_essay/data_soal/' . $this->uri->segment(3)); ?>" class="btn btn-light">Kembali</a>
			</div>
		</div>
		
		<?php echo form_open_multipart(base_url() . "ujian_essay/simpan_soal", "class='form-horizontal'"); ?>
			<input type="hidden" name="id" id="id" value="<?php echo $d['id']; ?>">
			<div id="konfirmasi" class="m-3">
				<?= $this->session->flashdata('msg'); ?>
			</div>

			<div class="form-group fgsoal">
				<input type="hidden" name="mode" id="mode" value="<?php echo $d['mode']; ?>">
				<input type="hidden" name="id_ujian" id="id_ujian" value="<?php echo $id_ujian; ?>">
			</div>

			<div class="form-group fgsoal">
				<div class="col-md-5"><label>Teks Soal</label></div>
				<div class="col-md-30">
					<input type="file" name="file_ujian_soal_essay" id="file_ujian_soal_essay" class="btn btn-info upload">
					<?php
					if (is_file('./upload/file_ujian_soal_essay/' . $d['file'])) {
						echo tampil_media('./upload/file_ujian_soal_essay/' . $d['file'], "100%");
						$number = 1;
						echo '<a href="#" onclick="return hapus_file_ujian('.$d['id'].','.$number.');" class="btn btn-danger btn-sm mr-2"><i class="glyphicon glyphicon-random" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Hapus File</a>';
					}
					?>
				</div>
				<div class="col-md-30">
					<textarea class="form-control" id="editornya" style="height: 50px;" name="soal"><?php echo $d['soal']; ?></textarea>
				</div>
			</div>

			<div class="form-group fgsoal">
		
				<div class="col-md-12"><label>Bobot Nilai Soal</label></div>
				<div class="col-md-5"><input type="text" name="bobot" class="form-control" required value="<?php echo $d['bobot']; ?>"></div>
			</div>
			<div class="form-group" style="margin-top: 20px">
				<div class="col-md-12">
					<button type="submit" class="btn btn-info"><i class="fa fa-check"></i> Simpan</button>
					<?php $url = 'ujian_essay/data_soal/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6);?>
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
	})
</script>





