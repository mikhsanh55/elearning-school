<style type="text/css">
.kecil-switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.kecil-switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.kecil-slider {
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

.kecil-slider:before {
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

input:checked + .kecil-slider {
  background-color: #2196F3;
}

input:focus + .kecil-slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .kecil-slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.kecil-slider.round {
  border-radius: 34px;
}

.kecil-slider.round:before {
  border-radius: 50%;
}
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
			<div class="progress d-none mt-4" id="progress-container">
                         <div id="progressBar" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                            <span class="sr-only">0%</span>
                        </div>
                     </div>
                     <div class="alert text-left d-none" id="progress-msg"></div>
					 <br>
			<div class="col-md-12">
				<div class="container">
					<ul id="lightslider">
						<?php foreach ($slide as $rows):?>
						<li data-thumb="<?=$patch.$rows->file;?>" data-src="<?=$patch.$rows->file;?>">
							<img class="img-slider img-thumbnail rounded mx-auto d-block" src="<?=$patch.$rows->file;?>" alt="">
						</li>
						<?php endforeach;?>
					<!-- <li data-thumb="https://images.pexels.com/photos/956999/milky-way-starry-sky-night-sky-star-956999.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" data-src="https://images.pexels.com/photos/956999/milky-way-starry-sky-night-sky-star-956999.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500">
							<img class="img-slider img-thumbnail rounded mx-auto d-block" src="https://images.pexels.com/photos/956999/milky-way-starry-sky-night-sky-star-956999.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" alt="">
					</li> -->
					</ul>  
				</div>      
			</div>		 
			<div class="col-md-12">
			<form id="form-slide" action="<?=base_url('setting_client/update_slide');?>" method="post" enctype="multipart/form-data">
			<div class="form-group">
					<label for="email">Slide :</label>
					<div class="custom-file mb-3">
						<input type="file" class="custom-file-input" id="slide" name="slide[]" multiple>
						<label class="custom-file-label file-slide" for="customFile">Choose file</label>
					</div>
			</div>
			<div id="attach-file">

			</div>

			<div class="form-group">
	
					<button type="submit" class="btn btn-success">Update Slide</button>
			</div>
		

			</form>
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

					<input type="hidden" class="form-control" id="jumlah_testing" name="jumlah_testing" required="" value="<?=(empty($setting->jumlah_testing)) ? 0 : $setting->jumlah_testing;?>">

					<label for="email">Video Beranda:</label>

					<div class="custom-file mb-3">

						<input type="file" class="custom-file-input" id="video" name="video">

						<label class="custom-file-label file-video" for="customFile">Choose file</label><label><?=(empty($setting->video)) ? NULL : $setting->video;?></label>

						<input type="hidden" name="video_before" value="<?=(empty($setting->video)) ? NULL : $setting->video;?>">

					</div>

				</div>
				<div class="form-group">
					<label for="">Pengaturan Bobot Ujian</label>
					<input type="hidden" name="bobot" id="bobot" value="<?= $setting->bobot == 1 ? 1 : 0; ?>">	
					<div style="position: relative;">
						<label class="kecil-switch">
						  <input type="checkbox" id="switch" <?= $setting->bobot == 1 ? 'checked': '' ?>>
						  <span class="kecil-slider round"></span>
						</label>
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
		$('#switch').change(function() {
			if($(this).prop('checked') === true) {
				$('#bobot').val(1)
			}
			else {
				$('#bobot').val(0)
			}
		})
		$('#lightslider').lightSlider({
            item:1,
            slideMargin:0,
            loop:true,
            controls:true 
        })
        $('.img-slider').click(function() {
            // $(this).toggleClass('zoom');
            var src = $(this).attr('src')
            $('#sliderModal .modal-body').html(`
                <img src="${src}" class="img-thumbnail mx-auto d-block img-zoom" />
            `)
            $('#sliderModal').modal('show')
        })
		listAttach();
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
		

		$('#slide').change(function(e){

			var fileName = e.target.files[0].name;



			var files = e.target.files; 

			var name = '';



			for (var i = 0, file; file = files[i]; i++) {

				console.log(file);

				name += file.name + '';

			}

			$('.file-slide').text(name)



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

	$(document).on('submit','#form-slide',function(event){
		event.preventDefault();
        // Check file exist
        if($('#slide').get(0).files.length == 0) {
            alert('Harap pilih file yang hendak diupload!')
            return false
        }
		var valid = false;
		var error = 0;

		$("#save").prop('disabled', true).html('<i class="fas fa-spinner ml-2 spin-icon"></i>');
        $('#progressBar').removeClass('bg-danger').text('')
		if (error == 0) {

		var form = $('#form-slide')[0];

		// Create an FormData object 
		var data = new FormData(form);

		// If you want to add an extra field for the FormData
		//data.append("CustomField", "This is some extra data, testing");
        // $('#progressBar').css('width', 0 + '%').addClass('bg-primary');
			$.ajax({
                xhr:function() {
                    let xhr = new window.XMLHttpRequest();
                    
                    xhr.upload.addEventListener("progress", function(e) {
                        if(e.lengthComputable) {
                            let percentComplete = e.loaded / e.total;
                            console.log(percentComplete);
                            // console.log('e.total : ' . e.total);
                            percentComplete = parseInt(percentComplete * 100);
                            $('#progress-container').removeClass('d-none');
                            $('#progressBar').attr('aria-valuenow', percentComplete).css('width', percentComplete + '%').text(percentComplete + '%');
                            if(percentComplete == 100) {
                                $('#progressBar').text('Complete!').addClass('bg-success');
                            }
                        }
                    }, false);
                    
                    return xhr;
                },
				type : 'post',
				url  : '<?=base_url('setting_client/update_slide');?>',
				enctype: 'multipart/form-data',
				processData: false,
				contentType: false,
				cache: false,
				dataType : 'json',
				data : data,
				success:function(response) {
                    $("#save").html('Upload').prop("disabled", false);
					if(response.status == 0){
						$('#errors-file').html(response.info);
                        $('#progressBar').text('Something wrong when create Tugas').addClass('bg-danger');
                        $('input[type=file]').val('')
                        
                        return false
					}else{
						$('#errors-file').html('');
						$('.file-slide').text('Choose file');
						listAttach();
					}
				},
                error: function() {
                    $("#save").html('Upload').prop("disabled", false);
                    $('#progressBar').text('Something wrong when upload file').addClass('bg-danger');
                    setTimeout(() => {
                        $('#progress-container').addClass('d-none');
                        $('#progressBar').removeClass('bg-success').attr('aria-valuenow', 0).css('width', 0 + '%').text('');
                    }, 3000)
                }
			}).done(() => {
                setTimeout(() => {
                    $('#progress-container').addClass('d-none');
                    $('#progressBar').removeClass('bg-success').attr('aria-valuenow', 0).css('width', 0 + '%').text('');
                }, 3000)
            })
		}

	})

	$(document).on('click','.delete-file',function(){
		
		var y = confirm('Apakah anda yakin menghapus file?');
	
		if (y == true) {

			$.ajax({
				type :'post',
				url  : base_url + 'setting_client/slide_delete',
				data : {
					id : $(this).data('id'),
					location : $(this).data('location')
				},
				success:function(response){
					listAttach();
				}
			})


		}else{
			return false;
		}

		
	})

	function listAttach(){
			$.ajax({
				type : 'post',
				url  : base_url + 'beranda/slide',
				success:function(response){
					$('#attach-file').html(response);
				}
			})
		}

</script>







