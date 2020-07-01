

<div class="col-md-9 page-content">

	<div class="inner-box">



		<div id="accordion" class="panel-group">

			<div class="row">

				<div class="col-md-12">

					<div class="panel panel-info">

						<div class="panel-heading">

							<div class="tombol-kanan">

								
								<div class="row align-items-center mb-4">
									<div class="col-sm-12 col-md-6 col-lg-6">
										<h2><strong>Edit Jadwal</strong></h2>
									</div>
									<div class="col-sm-12 col-md-6 col-lg-6 text-right">
										<button class="btn btn-light" onclick="back_page('jadwal', false)">Kembali</button>
									</div>
								</div>

								<?php if( $this->session->userdata('admin_level') == "admin"){ ?>

								

								<?php } ?>

								<!--<a class="btn btn-warning btn-sm tombol-kanan" href="<?php echo base_url(); ?>upload/format_import_guru.xlsx"><i class="glyphicon glyphicon-download"></i> &nbsp;&nbsp;Download Format Import</a>-->

								<!--<a class="btn btn-info btn-sm tombol-kanan" href="<?php echo base_url(); ?>trainer/m_guru/import"><i class="glyphicon glyphicon-upload"></i> &nbsp;&nbsp;Import</a>-->

							</div>

						</div>

					</div>

					<br>

				</div>

			</div>

			<form action="" method="post" id="form-jadwal">

				<div class="form-group">

						<label for="id_kelas">Kelas:</label>

						<select id="id_kelas" name="id_kelas" class="form-control">

						<option value="">Pilih</option>

						<?php foreach ($kelas as $rows): ?>

							<?php if ($rows->id == $edit->id_kelas): ?>

								<option value="<?=$rows->id;?>" selected><?=$rows->nama.' ( '.$rows->nama_guru.' - '.$rows->nama_mapel.' )';?></option>


							<?php else: ?>

								<option value="<?=$rows->id;?>"><?=$rows->nama.' ( '.$rows->nama_guru.' - '.$rows->nama_mapel.' )';?></option>


							<?php endif ?>

						<?php endforeach ?>

					</select>



				</div>

				<div class="form-group">

					<label for="pwd">Materi:</label>

					<select id="materi" name="materi" class="form-control">

						<option value="">Pilih</option>

					</select>

				</div>

				<div class="form-group">

					<label for="pwd">Warna:</label>

					<select name="color" class="form-control">

						<option value="">Choose</option>

						<?php foreach ($warna as $kode => $color): ?>

							<?php if ($kode == $edit->color): ?>

								<option style="color:<?=$kode;?>" value="<?=$kode;?>" selected>&#9724; <?=$color;?></option>

							<?php else: ?>

								<option style="color:<?=$kode;?>" value="<?=$kode;?>">&#9724; <?=$color;?></option>

							<?php endif ?>

						<?php endforeach ?>

					</select>

				</div>

				<div class="form-group">

					<label for="pwd">Keterangan:</label>

					<textarea name="keterangan" class="form-control"><?=$edit->keterangan;?></textarea>

				</div>

				<?php

					if (!empty($edit->start_date)) {

						$datetime1 = explode(' ', $edit->start_date);

						$date = $datetime1[0];

						$time = time_short($datetime1[1]);

					}else{

						$date = NULL;

						$time = NULL;

					}



					if (!empty($edit->end_date)) {

						$datetime2 = explode(' ', $edit->end_date);

						$date2 = $datetime2[0];

						$time2 = time_short($datetime2[1]);

					}else{

						$date2 = NULL;

						$time2 = NULL;

					}

					;?>

				<div class="form-group">

					<label for="pwd">Mulai:</label>

					<input type="date" class="" id="start_date" name="start_date" value="<?=$date;?>">

					<input type="time" class="" id="start_time" name="start_time" value="<?=$time?>">

					<label for="pwd">Selesai:</label>

					<input type="date" class="" id="end_date" name="end_date" value="<?=$date2;?>">

					<input type="time" class="" id="end_time" name="end_time" value="<?=$time2;?>">

					<input type="hidden" name="id" value="<?=$edit->id;?>">

				</div>

				<div class="form-group">

					

				</div>

				<button type="submit" class="btn btn-primary">Simpan</button>

				<button type="button" class="btn btn-danger" onclick="window.location='<?=base_url('jadwal');?>'">Batal</button>

			</form> 

		</div>

	</div>



</div>

</div>

<!--/.row-box End-->

<script src="<?= base_url(); ?>assets/js/jquery/jquery-3.3.1.min.js"></script>

<script type="text/javascript">

	$(document).ready(function(){

		load_materi();

		$('#id_kelas').change(function(){

			$.ajax({

				type : 'post',

				url  : '<?=base_url('jadwal/get_materi');?>',

				dataType : 'json',

				data : {

					id_kelas : $(this).val()

				},

				success:function(response){

					$('#materi').html(response.select)



				}

			})

		})



		$('#mp').change(function(){

			$.ajax({

				type : 'post',

				url  : '<?=base_url('jadwal/get_materi');?>',

				dataType : 'json',

				data : {

					id_mapel : $(this).val()

				},

				success:function(response){

					$('#materi').html(response.select);



				}

			})

		})



	})





	





	function load_materi(){

		$.ajax({

			type : 'post',

			url  : '<?=base_url('jadwal/get_materi');?>',

			dataType : 'json',

			data : {

				id_kelas : '<?=$edit->id_kelas;?>',

				id_materi : '<?=$edit->id_materi;?>'

			},

			success:function(response){

				$('#materi').html(response.select);



			}

		})

	}



	$(document).on('submit','#form-jadwal',function(event){

			event.preventDefault(0);

			$.ajax({

				type : 'post',

				url  : '<?=base_url('jadwal/update');?>',

				dataType : 'json',

				data : $(this).serialize(),

				success:function(response){

					window.location = '<?=base_url('jadwal');?>'



				}

			})

		})



</script>









