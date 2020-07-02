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
				<h2>Tambah Jurusan</h2>		
			</div>
			<div class="col-sm-12 col-md-6 col-lg-6 text-right">
				<button class="btn btn-light" onclick="back_page('jurusan', false)">Kembali</button>
			</div>
		</div>
		<form id="form-jurusan" method="post">
			
			<?php if ($this->log_lvl == 'admin'): ?>
				<div class="form-group">
				<label for="lembaga">Lembaga</label>
				<div class="rs-select2 js-select-simple select--no-search">
					<select name="id_instansi" id="id_instansi" style="width: 30%;">
						<option disabled="disabled" selected="selected">Pilih</option>
						<?php foreach ($instansi as $rows): ?>
							<option value="<?=$rows->id;?>"><?=$rows->instansi;?></option>
						<?php endforeach ?>
					</select>
					<div class="select-dropdown"></div>
				</div>
				</div>
			<?php else: ?>
				<input type="hidden" class="form-control" value="<?=$instansi->instansi;?>" readonly>
			<?php endif ;?>
				
			
			
			<div class="form-group">
				<label for="jurusan">Nama Jurusan<span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="jurusan" placeholder="Ex : MIPA, IPS" name="jurusan" required="" maxlength="150">
			</div>
			<div class="form-group">
				<label for="kode">Kode Jurusan</label>
				<input type="text" class="form-control" id="kode" placeholder="Ex : 0012" name="kode">
			</div>

			
			<button type="submit" class="btn btn-primary">Simpan</button>
			<!-- <button type="button" class="btn btn-danger" onclick="back_page('jurusan')">Kembali</button> -->
		</form>
		
	</div>

</div>
</div>
<!--/.row-box End-->
<script src="<?= base_url(); ?>assets/js/jquery/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
	$(document).on('submit','#form-jurusan',function(event){
		event.preventDefault();
		var valid = false;
		var error = 0;

		if (error == 0) {
			$.ajax({
				type : 'post',
				url  : '<?=base_url('jurusan/insert');?>',
				dataType : 'json',
				data : $(this).serialize(),
				success:function(response) {
					if(response.result == true){
						// alert(response.info);
						window.location = '<?=base_url('jurusan');?>'
					}else{
						alert(response.info);
						console.error(response)
						return false
					}
				}
			})
		}

	})
</script>





