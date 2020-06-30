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
				<button class="btn btn-light" onclick="back_page('ujian')">Kembali</button>
			</div>
		</div>
		
		<?php echo form_open_multipart(base_url() . "ujian_real/simpan_soal", "class='form-horizontal'"); ?>
			<input type="hidden" name="id" id="id" value="<?php echo $d['id']; ?>">
			<div id="konfirmasi"></div>

			<div class="form-group fgsoal">
				<input type="hidden" name="mode" id="mode" value="<?php echo $d['mode']; ?>">
				<input type="hidden" name="id_ujian" id="id_ujian" value="<?php echo $id_ujian; ?>">
			</div>

			<div class="form-group fgsoal">
				<div class="col-md-5"><label>Teks Soal</label></div>
				<div class="col-md-30">
					<input type="file" name="file_ujian_soal" id="file_ujian_soal" class="btn btn-info upload">
					<?php
					if (is_file('./upload/file_ujian_soal/' . $d['file'])) {
						echo tampil_media('./upload/file_ujian_soal/' . $d['file'], "100%");
						$number = 1;
						echo '<a href="#" onclick="return hapus_file_ujian('.$d['id'].','.$number.');" class="btn btn-danger btn-sm mr-2"><i class="glyphicon glyphicon-random" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Hapus File</a>';
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
						<input type="file" name="gj<?php echo $huruf_opsi[$j]; ?>" id="gambar_soal" class="btn btn-success upload"><br>
						<?php
						
						if (is_file('./upload/file_ujian_opsi/' . $data_pc[$idx]['gambar'])) {
							echo tampil_media('./upload/file_ujian_opsi/' . $data_pc[$idx]['gambar'], "100%");
							$number1 = 2;$number2 = 3;$number3 = 4;$number4 = 5;$number5 = 6;
							
							if($huruf_opsi[$j] == "a"){
								echo '<a href="#" onclick="return hapus_file_ujian('.$d['id'].','.$number1.');" class="btn btn-danger btn-sm mr-2"><i class="glyphicon glyphicon-random" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Hapus File</a>';
							}else if($huruf_opsi[$j] == "b"){
								echo '<a href="#" onclick="return hapus_file_ujian('.$d['id'].','.$number2.');" class="btn btn-danger btn-sm mr-2"><i class="glyphicon glyphicon-random" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Hapus File</a>';
							}else if($huruf_opsi[$j] == "c"){
								echo '<a href="#" onclick="return hapus_file_ujian('.$d['id'].','.$number3.');" class="btn btn-danger btn-sm mr-2"><i class="glyphicon glyphicon-random" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Hapus File</a>';
							}else if($huruf_opsi[$j] == "d"){
								echo '<a href="#" onclick="return hapus_file_ujian('.$d['id'].','.$number4.');" class="btn btn-danger btn-sm mr-2"><i class="glyphicon glyphicon-random" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Hapus File</a>';
							}else if($huruf_opsi[$j] == "e"){
								echo '<a href="#" onclick="return hapus_file_ujian('.$d['id'].','.$number5.');" class="btn btn-danger btn-sm mr-2"><i class="glyphicon glyphicon-random" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Hapus File</a>';
							}
							
							
						}
						?>
					</div>
					<div class="col-md-30">
						<textarea class="form-control" id="editornya_<?php echo $huruf_opsi[$j]; ?>" style="height: 30px" name="opsi_<?php echo $huruf_opsi[$j]; ?>"><?php echo $data_pc[$idx]['opsi']; ?></textarea>
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
					<?php $url = 'ujian_real/data_soal/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6);?>
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





