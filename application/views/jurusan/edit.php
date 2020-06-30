<<<<<<< HEAD
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
				<h2>Edit Jurusan</h2>		
			</div>
			<div class="col-sm-12 col-md-6 col-lg-6 text-right">
				<button class="btn btn-light" onclick="back_page('jurusan', false)">Kembali</button>
			</div>
		</div>
		<form id="form-jurusan" method="post">
			<div class="form-group">
				<label for="lembaga">Lembaga</label>
				<?php if ($this->log_lvl == 'admin'): ?>
					<div class="rs-select2 js-select-simple select--no-search">
						<select name="id_instansi" id="id_instansi" style="width: 30%;">
							<option disabled="disabled" selected="selected">Pilih</option>
							<?php foreach ($instansi as $rows): ?>
							<?php if($rows->id == $edit->id_instansi): ?>
								<option value="<?=$rows->id;?>"  selected="selected"><?=$rows->instansi;?></option>
							<?php else : ?>
								<option value="<?=$rows->id;?>"><?=$rows->instansi;?></option>
							<?php endif;?>
							
							<?php endforeach ?>
						</select>
						<div class="select-dropdown"></div>
					</div>
				<?php else: ?>
					<input type="text" class="form-control" value="<?=$instansi->instansi;?>" readonly>
				<?php endif ;?>
				
			
			</div>
			<div class="form-group">
				<input type="hidden" class="form-control" value="<?=$edit->id;?>" name="id" readonly>
				<label for="jurusan">Jurusan:</label>
				<input type="text" class="form-control" value="<?=$edit->jurusan;?>" id="jurusan" placeholder="Masukan Jurusan" name="jurusan" required="" maxlength="150">
			</div>

			
			<button type="submit" class="btn btn-primary">Simpan</button>
			<button type="button" class="btn btn-danger" onclick="back_page('jurusan')">Kembali</button>
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
				url  : '<?=base_url('jurusan/update');?>',
				dataType : 'json',
				data : $(this).serialize(),
				success:function(response) {
					if(response.result == true){
						alert(response.info);
						window.location = '<?=base_url('jurusan');?>'
					}else{
						alert(response.info);
					}
				}
			})
		}

	})
</script>





=======
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
				<h2>Edit Kelas</h2>		
			</div>
			<div class="col-sm-12 col-md-6 col-lg-6 text-right">
				<button class="btn btn-light" onclick="back_page('jurusan', false)">Kembali</button>
			</div>
		</div>
		<form id="form-jurusan" method="post">
			<div class="form-group">
				<label for="lembaga">Lembaga</label>
				<?php if ($this->log_lvl == 'admin'): ?>
					<div class="rs-select2 js-select-simple select--no-search">
						<select name="id_instansi" id="id_instansi" style="width: 30%;">
							<option disabled="disabled" selected="selected">Pilih</option>
							<?php foreach ($instansi as $rows): ?>
							<?php if($rows->id == $edit->id_instansi): ?>
								<option value="<?=$rows->id;?>"  selected="selected"><?=$rows->instansi;?></option>
							<?php else : ?>
								<option value="<?=$rows->id;?>"><?=$rows->instansi;?></option>
							<?php endif;?>
							
							<?php endforeach ?>
						</select>
						<div class="select-dropdown"></div>
					</div>
				<?php else: ?>
					<input type="text" class="form-control" value="<?=$instansi->instansi;?>" readonly>
				<?php endif ;?>
				
			
			</div>
			<div class="form-group">
				<input type="hidden" class="form-control" value="<?=$edit->id;?>" name="id" readonly>
				<label for="jurusan">Kelas:</label>
				<input type="text" class="form-control" value="<?=$edit->jurusan;?>" id="jurusan" placeholder="Masukan Kelas" name="jurusan" required="" maxlength="150">
			</div>

			
			<button type="submit" class="btn btn-primary">Simpan</button>
			<button type="button" class="btn btn-danger" onclick="back_page('jurusan')">Kembali</button>
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
				url  : '<?=base_url('jurusan/update');?>',
				dataType : 'json',
				data : $(this).serialize(),
				success:function(response) {
					if(response.result == true){
						alert(response.info);
						window.location = '<?=base_url('jurusan');?>'
					}else{
						alert(response.info);
					}
				}
			})
		}

	})
</script>





>>>>>>> first push
