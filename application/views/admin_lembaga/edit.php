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
				<h2>Edit Admin <?=$this->akun->ins;?></h2>		
			</div>
			<div class="col-sm-12 col-md-6 col-lg-6 text-right">
				<button class="btn btn-light" onclick="back_page('adminlembaga')">Kembali</button>
			</div>
		</div>
		<form id="form-akun-lembaga" method="post">
			<div class="form-group">
				<input type="hidden" name="lembaga" id="lembaga" value="<?=$this->akun->instansi;?>">
			</div>
			<div class="form-group">
				<input type="hidden" name="id" value="<?=$edit->id;?>">
				<label for="nama">Nama:</label>
				<input type="text" class="form-control" id="nama" placeholder="Masukan Nama" name="nama" required="" value="<?=$edit->nama;?>">
			</div>
			<div class="form-group">
				<label for="username">Username:</label>
				<input type="text" class="form-control" id="username" placeholder="Masukan Username" name="username" required="" value="<?=$edit->username;?>">
				<span id="errors-username" class="errors"></span>
			</div>
			<div class="form-group">
				<label for="email">Email:</label>
				<input type="email" class="form-control" id="email" placeholder="Masukan Email" name="email" required="" value="<?=$edit->email;?>">
				<span id="errors-email" class="errors"></span>
			</div>
		
			<div class="form-group">
				<label for="tempat_lahir">Tempat Lahir:</label>
				<input type="text" class="form-control" id="tempat_lahir" placeholder="Masukan Tempat Lahir" name="tempat_lahir" value="<?=$edit->tempat_lahir;?>">
			</div>
			<div class="form-group">
				<label for="tempat_lahir">Tanggal Lahir:</label>
				<input class="form-control js-datepicker" type="text" name="tgl_lahir" value="<?=(!empty($edit->tanggal_lahir)) ? shortdate_indo($edit->tanggal_lahir) : NULL;?>">
			</div>
			
			<button type="submit" class="btn btn-primary">Simpan</button>
			<button type="button" class="btn btn-danger" onclick="back_page('adminlembaga')">Kembali</button>
		</form>
		
	</div>

</div>
</div>
<!--/.row-box End-->
<script src="<?= base_url(); ?>assets/js/jquery/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
	$(document).on('submit','#form-akun-lembaga',function(event){
		event.preventDefault();
		var valid = false;
		var error = 0;

		if (error == 0) {
			$.ajax({
				type : 'post',
				url  : '<?=base_url('adminlembaga/update');?>',
				dataType : 'json',
				data : $(this).serialize(),
				success:function(response) {
					if(response.status == 0){

						alert(response.message.info);
				
						if (response.message.username !== undefined) {
							$('#username').addClass('errors-input');
							$('#errors-username').text(response.message.username);
						}else{
							$('#username').removeClass('errors-input');
							$('#errors-username').text('');
						}

						if (response.message.email !== undefined) {
							$('#email').addClass('errors-input');
							$('#errors-email').text(response.message.email);
						}else{
							$('#email').removeClass('errors-input');
							$('#errors-email').text('');
						}

					}else{
						alert(response.message.info);
						window.location = '<?=base_url('adminlembaga');?>'
					}
				}
			})
		}

	})
</script>





