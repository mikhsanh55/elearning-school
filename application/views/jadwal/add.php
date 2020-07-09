

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
										<h2><strong>Tambah Jadwal</strong></h2>
									</div>
									<div class="col-sm-12 col-md-6 col-lg-6 text-right">
										<button class="btn btn-light" onclick="back_page('jadwal', true)">Kembali</button>
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

							<!-- <option value="<?=$rows->id;?>"><?=$rows->nama.' ( '.$rows->nama_guru.')';?></option> -->
							<option value="<?=$rows->id;?>"><?=$rows->nama;?></option>


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

						<option style="color:#0071c5;" value="#0071c5">&#9724; Dark blue</option>

						<option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquoise</option>

						<option style="color:#008000;" value="#008000">&#9724; Green</option>                       

						<option style="color:#FFD700;" value="#FFD700">&#9724; Yellow</option>

						<option style="color:#FF8C00;" value="#FF8C00">&#9724; Orange</option>

						<option style="color:#FF0000;" value="#FF0000">&#9724; Red</option>

						<option style="color:#000;" value="#000">&#9724; Black</option>

					</select>

				</div>

				

				<div class="form-group">

					<label for="pwd">Keterangan:</label>

					<textarea name="keterangan" class="form-control"></textarea>

				</div>

				<div class="form-group">

					<label for="pwd">Mulai:</label>

					<input type="date" class="" id="start_date" name="start_date">

					<input type="time" class="" id="start_time" name="start_time">

					<label for="pwd">Selesai:</label>

					<input type="date" class="" id="end_date" name="end_date">
					<input type="time" class="" id="end_time" name="end_time">

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



	})



	$(document).on('submit','#form-jadwal',function(event){

			event.preventDefault(0);

			$.ajax({

				type : 'post',

				url  : '<?=base_url('jadwal/insert');?>',

				dataType : 'json',

				data : $(this).serialize(),

				success:function(response){

					window.location = '<?=base_url('jadwal');?>'

				}

			})

		})



</script>









