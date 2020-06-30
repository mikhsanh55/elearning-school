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
		<div class="row align-items-center">
            <div class="col-sm-12 col-md-6 col-lg-6">
                <h2><?=(empty($edit->id)) ? 'Tambah' : 'Update' ;?> Kelas</h2>

            </div>
            <div class="col-sm-12 col-md-6 col-lg-6 text-right">
                <button class="btn btn-light" onclick="back_page('kelas', true)">Kembali</button>
            </div>
        </div>
		
		<section id="display-error"></section>
		<form id="form-kelas" method="post">
		<div class="row">
			<div class="form-group col-md-6">
				<label for="mapel"><?=$this->transTheme->guru;?></label>
				<div class="rs-select2 js-select-simple select--no-search">
					<select name="id_trainer" id="id_trainer" style="width: 70%;" required>
						<option disabled="disabled" value="null" selected="selected">Pilih</option>
						<?php 
						$id_trainer = (empty($edit->id_trainer)) ? NULL : $edit->id_trainer;
						foreach ($guru as $rows): ?>
							<option value="<?=$rows->id;?>" <?=($id_trainer == $rows->id) ? 'selected="selected"' : '';?> ><?=$rows->nama;?></option>
						<?php endforeach ?>
					</select>
					<div class="select-dropdown"></div>
				</div>
			</div>
			<div class="form-group col-md-6">
				<label for="mapel">Mata Kuliah</label>
				<div class="rs-select2 js-select-simple select--no-search">
					<select name="mapel" id="mapel" style="width: 70%;" required>
						<option disabled="disabled" value="null" selected="selected">Pilih</option>
					</select>
					<div class="select-dropdown"></div>
				</div>
			</div>
			</div>
			<div class="row">
			<div class="form-group col-md-6">
				<label for="mapel">Jurusan</label>
				<div class="rs-select2 js-select-simple select--no-search">
					<select name="id_jurusan" id="id_jurusan" style="width: 70%;" required>
						<option disabled="disabled" value="null" selected="selected">Pilih</option>
						<?php 
						$id_jurusan = (empty($edit->id_jurusan)) ? NULL : $edit->id_jurusan;
						foreach ($jurusan as $rows): ?>
							<option value="<?=$rows->id;?>" <?=($id_jurusan == $rows->id) ? 'selected' : '';?> ><?=$rows->jurusan;?></option>
						<?php endforeach ?>
					</select>
					<div class="select-dropdown"></div>
				</div>
			</div>
			</div>
			<div class="form-group">
				<label for="nama">Nama Kelas:</label>
				<input type="text" value="<?=(empty($edit->nama)) ? NULL : $edit->nama ;?>" class="form-control" id="nama" placeholder="Masukan Nama Kelas" name="nama" required="" maxlength="150">
			</div>
			<div class="form-group">
				<label for="username">Keterangan:</label>
				<textarea id="keterangan" name="keterangan" class="form-control" placeholder="Keterangan kelas"><?=(empty($edit->keterangan)) ? NULL : $edit->keterangan ;?></textarea>
				<span id="errors-username" class="errors"></span>
			</div>
			
			<input type="hidden" id="id" name="id" value="<?=(empty($edit->id)) ? NULL : $edit->id ;?>">
			<button type="submit" class="btn btn-primary">Simpan</button>
			<button type="button" class="btn btn-danger" onclick="back_page('kelas')">Kembali</button>
		</form>
		
		
	</div>

</div>
</div>
<!--/.row-box End-->
<script src="<?= base_url(); ?>assets/js/jquery/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){

		function get_mapel(){
			$.ajax({
					type : 'post',
					url  : base_url + 'kelas/get_mapel',
					dataType : 'json',
					data : {
						id_trainer : $('#id_trainer').val(),
						id_mapel : '<?=(empty($edit->id_mapel)) ? NULL : $edit->id_mapel ;?>'
					},
					success:function(response) {
						$('#mapel').html(response.select);
					}
				})
		}

		get_mapel();

	})

	$(document).on('submit','#form-kelas',function(event){
		event.preventDefault();
		var valid = false;
		var error = [], errorMsg = '';
		var id = $('#id').val();
        //  Validation		
		if($('#id_trainer').val() == null) {
		    error.push('Harap pilih Pengajar!');
		}
		
		if($('#mapel').val() == null) {
		    error.push('Harap pilih mata pelajaran!');
		}
		
		if( $('#id_jurusan').val() == null) {
		    error.push('Harap pilih jurusan!');
		}

		if (id == '') {
			var link = '<?=base_url('kelas/insert');?>';
		} else {
			var link = '<?=base_url('kelas/update');?>';
		}
		
		console.warn(error)
		if (error.length == 0) {
			$.ajax({
				type : 'post',
				url  : link,
				dataType : 'json',
				data : $(this).serialize(),
				success:function(response) {
					alert(response.message);
					if(response.result == true){
						back_page('kelas');
					}else{
						window.reload();
					}
				}
			})
		}
		else {
		    console.log(errorMsg)
		    for(let i = 0;i < error.length;i++) {
		        errorMsg += `<div class="alert alert-danger"><small>${error[i]}</small></div>`
		    }
		    
		    $('#display-error').fadeIn().html(errorMsg)
		    
		    setTimeout(() => {
		        $('#display-error').fadeOut() 
		    }, 3000)
		    
		}

	})

	$(document).on('change','#id_trainer',function(){
		$.ajax({
				type : 'post',
				url  : base_url + 'kelas/get_mapel',
				dataType : 'json',
				data : {
					id_trainer : $(this).val(),
					id_mapel : '<?=(empty($edit->id_mapel)) ? NULL : $edit->id_mapel ;?>'
				},
				success:function(response) {
					$('#mapel').html(response.select);
				}
			})
	})

	

</script>





