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

	.center {

  margin: auto;

  width: 60%;

  border: 3px solid #73AD21;

  padding: 10px;

}



.switch {

  position: relative;

  display: inline-block;

  width: 60px;

  height: 34px;

}



.switch input { 

  opacity: 0;

  width: 0;

  height: 0;

}



.slider {

  position: absolute;

  cursor: pointer;

  top: 0;

  left: 0;

  right: 0;

  bottom: 0;

  background-color: #ccc;

  -webkit-transition: .4s;

  transition: .4s;

}



.slider:before {

  position: absolute;

  content: "";

  height: 26px;

  width: 26px;

  left: 4px;

  bottom: 4px;

  background-color: white;

  -webkit-transition: .4s;

  transition: .4s;

}



input:checked + .slider {

  background-color: #2196F3;

}



input:focus + .slider {

  box-shadow: 0 0 1px #2196F3;

}



input:checked + .slider:before {

  -webkit-transform: translateX(26px);

  -ms-transform: translateX(26px);

  transform: translateX(26px);

}



/* Rounded sliders */

.slider.round {

  border-radius: 34px;

}



.slider.round:before {

  border-radius: 50%;

}

</style>

<div class="col-md-9 page-content">

	<div class="inner-box">



		<div id="accordion" class="panel-group">

			<div class="row">

				<div class="col-md-12">

					<div class="panel panel-info">

						<div class="panel-heading">

						Selamat datang di <?=$this->title;?> | <a href="javascript:void(0);"><i class="icon-user"></i> <?php echo $this->session->userdata('admin_nama');?> </a> - <a href="#" onclick="return rubah_password();"><i class="icon-key"></i> Ubah Password </a>
						<a href="<?php echo base_url(); ?>login/logout" onclick="return confirm('Keluar ?');" style="float:right"> <i class=" icon-logout "></i> Log out </a>

						

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

			<form action="<?=base_url('setting/update');?>" method="post" enctype="multipart/form-data">

				<div class="row">

					<div class=" col-md-6 form-group">

						<?php

						if (is_file('./assets/img/'.$setting->logo)) {

							echo tampil_media('./assets/img/'.$setting->logo, "auto","40px");

						}

						?>

						<label for="email">Logo:</label>

						<div class="custom-file mb-3">

							<input type="file" class="custom-file-input" id="logo" name="logo">

							<label class="custom-file-label" for="customFile">Choose file</label>

						</div>

					</div>



					<div class=" col-md-6 form-group">

						<label for="email">Tampilkan Logo di login:</label>

						<label class="switch" data-toggle="tooltip">

							<input type="checkbox" class="aktivasi" name="status_logo"  data-peserta="" <?=($setting->logo_login == 1) ? 'checked' : '' ;?> value="1">

							<span class="slider round"></span>

						</label>

						<input type="hidden" name="logo_before" value="<?=$setting->logo;?>">

					</div>

				</div>

				<div class="form-group">

					<label for="email">Judul:</label>

					<input type="hidden" name="id" value="<?=$setting->id;?>">

					<input type="text" class="form-control" id="judul" name="judul" required="" value="<?=$setting->judul;?>">

				</div>

					<label for="email">Footer:</label>

					<input type="text" class="form-control" id="footer" name="footer" required="" value="<?=$setting->footer;?>">

					<div class="form-group">

					<!-- <label for="email">Jumlah Pengulangan Latihan:</label> -->

					<input type="hidden" class="form-control" id="jumlah_testing" name="jumlah_testing" required="" value="<?=$setting->jumlah_testing;?>">

				</div>

					

				<button type="submit" class="btn btn-default">Update</button>

			</form> 

		</div>

	</div>



</div>

</div>







<script type="text/javascript">

	$(document).ready(function(){

		$('input[type="file"]').change(function(e){

            var fileName = e.target.files[0].name;

  	

            var files = e.target.files; 

            var name = '';



            for (var i = 0, file; file = files[i]; i++) {

            	console.log(file);

            	name += file.name + '';

            }

            $('.custom-file-label').text(name)

   

        });

	})

</script>

