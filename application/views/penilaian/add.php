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
                <h2> Tambah <?=$this->page_title;?></h2>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6 text-right">
                <?= $this->backButton; ?>
            </div>
        </div>	
		

		<form id="form" method="post">

				<div class="form-group">

					<label for="lembaga">Kelas</label>

					<div class="rs-select2 js-select-simple select--no-search">

						<select name="id_kelas" id="id_kelas" style="width: 100%;" required>

							<option disabled="disabled" selected="selected">Pilih</option>

								<?php foreach ($kelas as $rows): ?>

								<option value="<?=$rows->id;?>"><?=$rows->nama.' ( '.$rows->nama_guru.' - '.$rows->nama_mapel.' )';?></option>

							<?php endforeach ?>

						</select>

						<div class="select-dropdown"></div>

					</div>

				</div>

				<div class="form-group">

					<label for="lembaga">Paket Soal</label>

					<div class="rs-select2 js-select-simple select--no-search">

						<select name="id_paket" id="id_paket" style="width: 100%;" required>

							<option disabled="disabled" selected="selected">Pilih</option>

								<?php foreach ($paket as $rows): ?>

								<option value="<?=$rows->id;?>"><?=$rows->nama;?></option>

							<?php endforeach ?>

						</select>

						<div class="select-dropdown"></div>

					</div>

				</div>

	



			<div class="form-group">

				<label for="nama_ujian">Nama Penilian:</label>

				<input type="text" class="form-control" id="nama_ujian" placeholder="Masukan Nama Penilaian" name="nama_ujian" required="">

			</div>

			<div class="row">

				<div class="col-md-6 form-group">

					<label for="tempat_lahir">Tanggal Mulai:</label>

					<input class="form-control js-datepicker" type="text" name="tgl_mulai" required>

				</div>

				<div class="col-md-6 form-group">

					<label for="tempat_lahir">Waktu Mulai:</label>

					<input class="form-control" type="time" name="waktu_mulai" required>

				</div>

			</div>



			<div class="row">

				<div class="col-md-6 form-group">

					<label for="tempat_lahir">Tanggal Selesai:</label>

					<input class="form-control js-datepicker" type="text" name="tgl_selesai" required>

				</div>

				<div class="col-md-6 form-group">

					<label for="tempat_lahir">Waktu Selesai:</label>

					<input class="form-control" type="time" name="waktu_selesai" required>

				</div>

			</div>

				<div class="form-group">

					<label for="waktu_ujian">Waktu Ujian:</label>

					<br>

					<input type="text" class="form-control only-number"  id="waktu_ujian" placeholder="Menit" name="waktu_ujian" required="" style="width: 100px; display: inline;"> Menit

					<input type="hidden" id="jenis" name="jenis" value="set">

				</div>



			<button type="submit" class="btn btn-primary">Simpan</button>

			<button type="button" class="btn btn-danger" onclick="back_page('penilaian')">Kembali</button>

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

				url  : '<?=base_url('penilaian/insert');?>',

				dataType : 'json',

				data : $(this).serialize(),

				success:function(response) {

					if(response.status == 0){

						alert(response.message);

					}else{

						alert(response.message);

						window.location = '<?=base_url('penilaian');?>'

					}

				}

			})

		}



	})

</script>











