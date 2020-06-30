<style type="text/css">

	.success{

		background: #c4ffbb;

		padding: 10px;

		border: 3px solid #000;

		border-radius: 10px;

		text-align: center;

		width: 500px;

		margin:auto;



	}



	.errors{

		background: #ffc8bb;

		padding: 10px;

		border: 3px solid #000;

		border-radius: 10px;

		text-align: center;

		width: 500px;

		margin:auto;



	}



	.center {

		margin: auto;

		width: 60%;

		border: 3px solid #73AD21;

		padding: 10px;

	}



</style>

<div class="col-md-9 page-content">

	<div class="inner-box">



		<div id="accordion" class="panel-group">

			<div class="row">

				<div class="col-md-12">

					<div class="panel panel-info">

						<div class="panel-heading">

							<h2><strong>Pengaturan Aplikasi <?=$this->akun->ins;?></strong></h2>

						

								<?php if (!empty($this->session->userdata('show'))) {

									if ($this->session->userdata('hasil') == 1) {

										echo '<div class="success">'.$this->session->userdata('pesan').'</div>';

									}else{

										echo '<div class="errors">'.$this->session->userdata('pesan').'</div>';

									}

								};

								$this->session->unset_userdata('show');

								?>

					

							<!--<a class="btn btn-warning btn-sm tombol-kanan" href="<?php echo base_url(); ?>upload/format_import_guru.xlsx"><i class="glyphicon glyphicon-download"></i> &nbsp;&nbsp;Download Format Import</a>-->

							<!--<a class="btn btn-info btn-sm tombol-kanan" href="<?php echo base_url(); ?>trainer/m_guru/import"><i class="glyphicon glyphicon-upload"></i> &nbsp;&nbsp;Import</a>-->



						</div>

					</div>

					<br>

				</div>

			</div>

			<form action="<?=base_url('setting_client/update');?>" method="post" enctype="multipart/form-data">

				<div class="form-group">

					<?php

					if (!empty($setting->logo)) {

						if (is_file('./assets/logo/'.$setting->logo)) {

							echo tampil_media('./assets/logo/'.$setting->logo, "auto","40px");

						}

					}

					?>

					<label for="email">Logo:</label>

					<div class="custom-file mb-3">

						<input type="file" class="custom-file-input" id="logo" name="logo">

						<label class="custom-file-label file-logo" for="customFile">Choose file</label>

					</div>

					<input type="hidden" name="logo_before" value="<?=(empty($setting->logo)) ? NULL : $setting->logo;?>">

					<br>

					<label for="email">Judul:</label>

					<input type="hidden" name="id" value="<?=(empty($setting->id)) ? NULL : $setting->id;?>">

					<input type="text" class="form-control" id="judul" name="judul" required="" value="<?=(empty($setting->judul)) ? NULL : $setting->judul;?>">

					<label for="email">Footer:</label>

					<input type="text" class="form-control" id="footer" name="footer" required="" value="<?=(empty($setting->footer)) ? NULL : $setting->footer;?>">

					<!-- <label for="email">Jumlah Pengulangan Latihan:</label> -->

					<input type="hidden" class="form-control" id="jumlah_testing" name="jumlah_testing" required="" value="<?=(empty($setting->jumlah_testing)) ? NULL : $setting->jumlah_testing;?>">

					<label for="email">Video Beranda:</label>

					<div class="custom-file mb-3">

						<input type="file" class="custom-file-input" id="video" name="video">

						<label class="custom-file-label file-video" for="customFile">Choose file</label><label><?=(empty($setting->video)) ? NULL : $setting->video;?></label>

						<input type="hidden" name="video_before" value="<?=(empty($setting->video)) ? NULL : $setting->video;?>">

					</div>

				</div>

				<button type="submit" class="btn btn-default">Update</button>

			</form> 

		</div>

	</div>



</div>

</div>

<script type="text/javascript">

	$(document).ready(function(){

		$('#logo').change(function(e){

            var fileName = e.target.files[0].name;

  	

            var files = e.target.files; 

            var name = '';



            for (var i = 0, file; file = files[i]; i++) {

            	console.log(file);

            	name += file.name + '';

            }

            $('.file-logo').text(name)

   

        });

        

        	$('#video').change(function(e){

            var fileName = e.target.files[0].name;

  	

            var files = e.target.files; 

            var name = '';



            for (var i = 0, file; file = files[i]; i++) {

            	console.log(file);

            	name += file.name + '';

            }

            $('.file-video').text(name)

   

        });

	})

</script>







