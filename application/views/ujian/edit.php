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
				<h2>Form Edit <?=$this->page_title;?></h2>
			</div>
			<div class="col-sm-12 col-md-6 col-lg-6 text-right">
				<?= $this->backButton; ?>
			</div>
		</div>
		

		<form id="form" method="post">



			<div class="row">

				<div class="col-md-6 form-group">

					<label for="lembaga">Tipe Ujian</label>

					<div class="rs-select2 js-select-simple select--no-search">

						<select name="type_ujian" id="type_ujian" style="width: 100%;" required>

							<option disabled="disabled" selected="selected">Pilih</option>

							<?php foreach ($tipe_ujian as $key => $rows): ?>

								<?php if ($edit->type_ujian == $key): ?>

									<option value="<?=$key;?>" selected><?=$rows;?></option>

								<?php else: ?>

									<option value="<?=$key;?>"><?=$rows;?></option>

								<?php endif ?>

								

							<?php endforeach ?>

						</select>

						<div class="select-dropdown"></div>

					</div>

				</div>

				<div class="col-md-6 form-group">

					<label for="lembaga">Room</label>

					<div class="rs-select2 js-select-simple select--no-search">

						<select name="id_kelas" id="id_kelas" style="width: 100%;" required>

							<option disabled="disabled" selected="selected">Pilih</option>

								<?php foreach ($kelas as $rows): ?>

									<?php if ($edit->id_kelas == $rows->id): ?>

										<option value="<?=$rows->id;?>" selected><?=$rows->nama.' ( '.$rows->nama_guru.' - '.$rows->nama_mapel.' )';?></option>

									<?php else: ?>

										<option value="<?=$rows->id;?>"><?=$rows->nama.' ( '.$rows->nama_guru.' - '.$rows->nama_mapel.' )';?></option>


									<?php endif ?>

							<?php endforeach ?>

						</select>

						<div class="select-dropdown"></div>

					</div>

				</div>

			</div>



			<div class="form-group">

				<label for="nama_ujian">Nama Ujian:</label>

				<input type="text" value="<?=$edit->nama_ujian;?>" class="form-control" id="nama_ujian" placeholder="Masukan Nama Ujian" name="nama_ujian" required="">

			</div>

			<?php 



				if (!empty($edit->tgl_mulai)) {

					$datetime1 = explode(' ',$edit->tgl_mulai);

					$date1 = shortdate_indo($datetime1[0]);

					$time1 = time_short($datetime1[1]);

				}else{

					$date1 = NULL;

					$time1 = NULL;

				}



				if (!empty($edit->terlambat)) {

					$datetime2 = explode(' ',$edit->terlambat);

					$date2 = shortdate_indo($datetime2[0]);

					$time2 = time_short($datetime2[1]);

				}else{

					$date2 = NULL;

					$time2 = NULL;

				}



			?>

			<div class="row">

				<div class="col-md-6 form-group">

					<label for="tempat_lahir">Tanggal Mulai:</label>

					<input class="form-control js-datepicker" type="text" name="tgl_mulai" required value="<?=$date1;?>">

				</div>

				<div class="col-md-6 form-group">

					<label for="tempat_lahir">Waktu Mulai:</label>

					<input class="form-control" type="time" name="waktu_mulai" required value="<?=$time1;?>">

				</div>

			</div>



			<div class="row">

				<div class="col-md-6 form-group">

					<label for="tempat_lahir">Tanggal Selesai:</label>

					<input class="form-control js-datepicker" type="text" name="tgl_selesai" required value="<?=$date2;?>">

				</div>

				<div class="col-md-6 form-group">

					<label for="tempat_lahir">Waktu Selesai:</label>

					<input class="form-control" type="time" name="waktu_selesai" required value="<?=$time2;?>">

				</div>

			</div>

			<div class="row">

				<div class="col-md-6 form-group">

					<label for="waktu_ujian">Waktu Ujian:</label>

					<br>

					<input type="text" value="<?=$edit->waktu;?>" class="form-control only-number"  id="waktu_ujian" placeholder="Menit" name="waktu_ujian" required="" style="width: 100px; display: inline;"> Menit

					<input type="hidden" id="jenis" name="jenis" value="set">

				</div>

				<div class="col-md-6 form-group">

					<label for="waktu_ujian">Minimal Nilai Lulus:</label>

					<br>

					<input type="text" value="<?=$edit->min_nilai;?>" class="form-control only-number"  id="min_nilai" placeholder="Angka" name="min_nilai" required="" minlength="2">

				</div>

			</div>

			<input type="hidden" name="id" value="<?=$edit->id;?>">

			<button type="submit" class="btn btn-primary">Simpan</button>

			<button type="button" class="btn btn-danger" onclick="back_page('ujian_real')">Kembali</button>

		</form>

		

	</div>



</div>

</div>

<!--/.row-box End-->

<script src="<?= base_url(); ?>assets/js/jquery/jquery-3.3.1.min.js"></script>

<script type="text/javascript">

	$(document).ready(function(){

		

	})



	$(document).on('submit','#form',function(event){

		event.preventDefault();

		var valid = false;

		var error = 0;



		if (error == 0) {

			$.ajax({

				type : 'post',

				url  : '<?=base_url('ujian_real/update');?>',

				dataType : 'json',

				data : $(this).serialize(),

				success:function(response) {

					if(response.status == 0){

						alert(response.message);

					}else{

						alert(response.message);

						window.location = '<?=base_url('ujian_real');?>'

					}

				}

			})

		}



	})

</script>











