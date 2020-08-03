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

    .title-profile{
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        display: inline-block;
        font-style: normal;
        font-variant: normal;
        text-rendering: auto;
        line-height: 1;
        margin-right:1rem !important;
        width:150px;
        border:0px solid #000;
    }

    .fa-edit:hover {
        cursor:pointer;
    }

    @keyframes rot {
      0% {
          transform:rotate(0deg);
      }
      100% {
          transform:rotate(360deg);
      }
  }
  .spin-icon {
      animation:rot 1s linear infinite;   
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
					</div>
					<div class="panel-body">
					<div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
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
            <div class="well well-sm">
                <div class="row">
                    
                    <div class="col-sm-12 col-md-12">
                        <br><br>
                            <input type="hidden" value="<?= $guru->id; ?>" id="id">
                        <table class="table" id="info-user">
                            <tr>
                                <th colspan="3" class="text-center text-uppercase font-weight-bold">
                                    <h3>Profil</h3>
                                    <img class="round" src="<?= empty($siswa->photo) ? 'assets/img/avatar-default.jpg' : $siswa->photo ?>" alt="" width="90" height="90" id="avatar">
                                </th>
                            </tr>
                            <tr>
                                <th class="text-secondary text-uppercase">Nama</th>
                                <td class="text-uppercase font-weight-bold">
                                    <span><?= (empty($guru->nama)) ? NULL : $guru->nama ;?></span>
                                    <input data-key="nama" type="text" class="d-none in-edit form-control input-sm" name="nama" value="<?= (empty($guru->nama)) ? NULL : $guru->nama  ?>">
                                </td>
                                <td class="text-right font-weight-bold">
                                    <i class="fas fa-edit edit text-primary"></i>
                                    <i class="d-none fas fa-spinner text-primary spin-icon"></i>
                                    <button class="d-none btn btn-sm btn-outline-danger"><i class="fas  fa-times"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-secondary text-uppercase">NIP</th>
                                <td class="text-uppercase font-weight-bold">
                                    <span><?= $guru->nidn ;?></span>
                                    <input data-key="nidn" type="text" class="d-none in-edit form-control" name="nidn" value="<?= (empty($guru->nidn)) ? NULL : $guru->nidn  ?>">
                                </td>
                                <td class="text-right font-weight-bold">
                                    <i class="fas fa-edit edit text-primary"></i>
                                    <i class="d-none fas fa-spinner text-primary spin-icon"></i>
                                    <button class="d-none btn btn-sm btn-outline-danger"><i class="fas  fa-times"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-secondary text-uppercase">NUPTK</th>
                                <td class="text-uppercase font-weight-bold">
                                    <span><?= $guru->nrp ;?></span>
                                    <input data-key="nrp" type="text" class="d-none in-edit form-control" name="nrp" value="<?= (empty($guru->nrp)) ? NULL : $guru->nrp  ?>">
                                </td>
                                <td class="text-right font-weight-bold">
                                    <i class="fas fa-edit edit text-primary"></i>
                                    <i class="d-none fas fa-spinner text-primary spin-icon"></i>
                                    <button class="d-none btn btn-sm btn-outline-danger"><i class="fas  fa-times"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-secondary text-uppercase">Username</th>
                                <td class="text-lowercase font-weight-bold">
                                    <?= (empty($guru->username)) ? NULL : $guru->username ;?>

                                </td>
                                <td class="text-right font-weight-bold">
                                    <i class="fas fa-check text-primary"></i>
                                    
                                </td>
                            </tr>
                            <tr>
                                <th class="text-secondary text-uppercase">Email</th>
                                <td class="font-weight-bold">
                                    <span><?= (empty($guru->email)) ? NULL : $guru->email  ?></span>
                                    <input data-key="email" type="text" class="d-none in-edit form-control" name="email" value="<?= (empty($guru->email)) ? NULL : $guru->email  ?>">
                                </td>
                                <td class="text-right font-weight-bold">
                                    <i class="fas fa-edit edit text-primary"></i>
                                    <i class="d-none fas fa-spinner text-primary spin-icon"></i>
                                    <button class="d-none btn btn-sm btn-outline-danger"><i class="fas fa-times"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-secondary text-uppercase">Telpon</th>
                                <td class="text-uppercase font-weight-bold">
                                    <span><?= (empty($guru->no_telpon)) ? NULL : $guru->no_telpon  ?></span>
                                    <input type="text" class="d-none in-edit form-control" data-key="no_telpon" name="telpon" value="<?= (empty($guru->no_telpon)) ? NULL : $guru->no_telpon  ?>">
                                </td>
                                <td class="text-right font-weight-bold">
                                    <i class="fas fa-edit edit text-primary "></i>
                                    <i class="d-none fas fa-spinner text-primary spin-icon"></i>
                                    <button class="d-none btn btn-sm btn-outline-danger"><i class="fas  fa-times"></i></button>

                                </td>
                            </tr>
                            <tr class="m-3">
                                <th class="text-secondary text-uppercase">
                                    <span class="badge badge-pill badge-light d-block p-1"></span>
                                </th>
                                <td class="text-uppercase">
                                    <span class="badge badge-pill badge-light d-block p-1"></span>
                                </td>
                                <td class="text-right text-primary font-weight-bold">
                                    <span class="badge badge-pill badge-light d-block p-1"></span>
                                </td>
                            </tr>
                            <tr class="m-3">
                                <th class="text-secondary text-uppercase">Photo</th>
                                <td class="text-uppercase font-weight-bold ">
                                    <input type="file" id="photo-file" class="form-control" />
                                    

                                </td>
                                <td class="text-right text-primary font-weight-bold">
                                    <button class="btn btn-outline-primary" id="upload-photo" title="Update Photo">
                                        <span id="upload">Upload</span>
                                        <i class="fas fa-spinner spin-icon text-primary d-none" id="spinner"></i>
                                    </button>
                                </td>
                            </tr>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
					</div>
					</div>

					<br>

				</div>

			</div>

		</div>

	</div>



</div>

</div>

<script type="text/javascript">
	$(document).ready(function(){
        var self, photoUser = null, photoFileName, photoExt, photoSize, maxSize, formData;
        const enableExtPictures = ['jpg', 'jpeg', 'png', 'gif', 'svg'];

         $('#photo-file').change(function(e) {
            photoUser = e.target.files[0];
            photoFileName = photoUser.name
            photoFileName = photoFileName.split('.')
            photoExt = photoFileName[ photoFileName.length - 1 ]
            photoSize = photoUser.size
            maxSize = 3145728

            // console.log(photoUser)
            if(!enableExtPictures.includes(photoExt)) {
                alert('Harap upload photo');
                photoUser = null;
                $(this).val('');
                return false;
            }
            else if(photoSize > maxSize) {
                alert('Maksimal Foto 3 MB');
                photoUser = null;
                $(this).val('');
                return false;   
            }
        });

        $('#upload-photo').on('click', function() {
            if(photoUser === null) {
                alert('Harap upload photo');
                return false;
            }
            // set loading button
            $(this).prop('disabled', true);
            $(this).find('#upload').toggleClass('d-none');
            $(this).find('.fa-spinner').toggleClass('d-none');
            formData = new FormData();
            formData.append('id', $('#id').val());
            formData.append('photo', photoUser);
            formData.append('<?= $csrf['name'] ?>', '<?= $csrf['token'] ?>')
            self = this;
            $.ajax({
                type: 'post',
                url: "<?= base_url('trainer/update_photo'); ?>",
                data: formData,
                dataType: 'json',
                contentType:false,
                processData:false,
                success:function(res) {
                    $(self).prop('disabled', false);
                    $(self).find('#upload').toggleClass('d-none');
                    $(self).find('#spinner').toggleClass('d-none');

                    $('#avatar').attr('src', res.url);
                },
                error:function(e) {
                    $(self).prop('disabled', false);
                    $(self).find('#upload').toggleClass('d-none');
                    $(self).find('#spinner').toggleClass('d-none');
                    alert(e.responseJSON.msg);
                    console.error(e.responseText);             
                    return false;       
                }
            })
        });

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

        $('#info-user tr td:last-child ').on('click', function() {
            $(this).children(':first').toggleClass('d-none')
            $(this).children(':last').toggleClass('d-none')

            // Visible/unvisible input
            $(this).prev().children(':first').toggleClass('d-none')
            $(this).prev().children(':last').toggleClass('d-none')
        })

        $('.in-edit').on('keydown', function(e) {
            
            if($(this).val() != '' && e.keyCode == 13) {
                e.preventDefault()
                self = this

                // Update button
                $(this).parent().next().find('.btn-outline-danger').toggleClass('d-none')
                $(this).parent().next().find('.spin-icon').toggleClass('d-none')
                $.ajax({
                    type: 'post',
                    url: "<?= base_url('trainer/update_profile') ?>",
                    data: {
                        id: $('#id').val(),
                        key: $(this).data('key'),
                        value: $(this).val(),
                        '<?= $csrf['name'] ?>': '<?= $csrf['token'] ?>'
                    },
                    dataType: 'json',
                    success: function(res) {
                        // Update button
                        $(self).parent().next().find('.fa-edit').toggleClass('d-none')
                        $(self).parent().next().find('.spin-icon').toggleClass('d-none')
                        
                        // Update field
                        $(self).toggleClass('d-none')
                        $(self).prev().text(res.value)
                        $(self).parent().children(':first').toggleClass('d-none')
                    },
                    error: function(e) {
                        alert('Gagal update profil')
                        // Update button
                        $(self).parent().next().find('.fa-edit').toggleClass('d-none')
                        $(self).parent().next().find('.spin-icon').toggleClass('d-none')
                        
                        // Update field
                        $(self).toggleClass('d-none')
                        $(self).parent().children(':first').toggleClass('d-none')
                        return false
                    }
                })
            }
        })

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







