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

    .img-thumbnail{
        width:100%;
    }

    .modal-content{
        pointer-events: none;
        width:50% !important;
    }
    .lSAction{
        background : #000 !important;
    }

    .fa-edit:hover {
        cursor:pointer;
    }
    img.round {
        border-radius:50%;
        position: relative;
    }

    .img-wrapper.round:hover:after {
        content:'';
        position: absolute;
        top:100px;
        left: 100px;
        display: block;
        height: 100%;
        width:100%;
        background: rgba(0, 0, 0, 0.85);
        z-index: 100;
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
            <br><br>
            <div class="well well-sm mt-4 container">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <input type="hidden" value="<?= $this->akun->id; ?>" id="id">
                      <table class="table" id="info-user">
                            <tr>
                                <th colspan="3" class="text-center text-uppercase font-weight-bold">
                                    <h3>Profil</h3>
                                    <img class="round" src="<?= empty($this->akun->photo) ? 'assets/img/avatar-default.jpg' : $this->akun->photo ?>" alt="" width="90" height="90" id="avatar">
                                </th>
                            </tr>
                            <tr>
                                <th class="text-secondary text-uppercase">Nama</th>
                                <td class="text-uppercase font-weight-bold">
                                    <span><?= (empty($this->akun->nama)) ? NULL : $this->akun->nama ;?></span>
                                    <input data-key="nama" type="text" class="d-none in-edit form-control input-sm" name="nama" value="<?= (empty($this->akun->nama)) ? NULL : $this->akun->nama  ?>">
                                </td>
                                <td class="text-right text-primary font-weight-bold">
                                    <i class="fas fa-edit"></i>
                                    <i class="d-none fas fa-spinner text-primary spin-icon"></i>
                                    <button class="d-none btn btn-sm btn-outline-danger"><i class="fas  fa-times"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-secondary text-uppercase">Jenis Kelamin</th>
                                <td class="text-uppercase font-weight-bold">
                                    <span><?= $this->akun->nik ;?></span>
                                    <input data-key="nik" type="text" class="d-none in-edit form-control input-sm" name="nik" value="<?= (empty($this->akun->nik)) ? NULL : $this->akun->nik  ?>">
                                </td>
                                <td class="text-right text-primary font-weight-bold">
                                    <i class="fas fa-edit"></i>
                                    <i class="d-none fas fa-spinner text-primary spin-icon"></i>
                                    <button class="d-none btn btn-sm btn-outline-danger"><i class="fas  fa-times"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-secondary text-uppercase">NIS</th>
                                <td class="text-uppercase font-weight-bold">
                                    <span><?= $this->akun->nrp ;?></span>
                                    <input data-key="nrp" type="text" class="d-none in-edit form-control input-sm" name="nrp" value="<?= (empty($this->akun->nrp)) ? NULL : $this->akun->nrp  ?>">
                                </td>
                                <td class="text-right text-primary font-weight-bold">
                                    <i class="fas fa-edit"></i>
                                    <i class="d-none fas fa-spinner text-primary spin-icon"></i>
                                    <button class="d-none btn btn-sm btn-outline-danger"><i class="fas  fa-times"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-secondary text-uppercase">Username</th>
                                <td class="text-lowercase font-weight-bold">
                                    <?= (empty($this->akun->username)) ? NULL : $this->akun->username ;?>
                                </td>
                                <td class="text-right text-primary font-weight-bold">
                                    <i class="fas fa-check"></i>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-secondary text-uppercase">Email</th>
                                <td class="font-weight-bold">
                                    <span><?= (empty($this->akun->email)) ? NULL : $this->akun->email  ?></span>
                                    <input data-key="email" type="text" class="d-none in-edit form-control input-sm" name="email" value="<?= (empty($this->akun->email)) ? NULL : $this->akun->email  ?>">
                                </td>
                                <td class="text-right text-primary font-weight-bold">
                                    <i class="fas fa-edit"></i>
                                    <i class="d-none fas fa-spinner text-primary spin-icon"></i>
                                    <button class="d-none btn btn-sm btn-outline-danger"><i class="fas  fa-times"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-secondary text-uppercase">Telpon</th>
                                <td class="text-uppercase font-weight-bold">
                                    <span><?= (empty($this->akun->no_telpon)) ? NULL : $this->akun->no_telpon  ?></span>
                                    <input data-key="no_telpon" type="text" class="d-none in-edit form-control input-sm" name="no_telpon" value="<?= (empty($this->akun->no_telpon)) ? NULL : $this->akun->no_telpon  ?>">

                                </td>
                                <td class="text-right text-primary font-weight-bold">
                                    <i class="fas fa-edit"></i>
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
                                    <button class="btn btn-sm btn-outline-primary" id="upload-photo" title="Update Photo">
                                        <i class="fas fa-upload"></i>
                                        <i class="fas fa-spinner spin-icon text-primary d-none"></i>
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
    var imgObject, ext, size, enableExt
	$(document).ready(function(){
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

        $('#photo-file').change(function() {
                imgObject = $(this)[0].files[0]
                ext = imgObject.type.split('/')
                size = imgObject.size
                enableExt = ['jpeg', 'jpg', 'png', 'svg', 'gif']

                ext = ext[ext.length - 1]

                if(!enableExt.includes(ext)) {
                    alert('Harap upload gambar!')
                    $(this).val('')
                    return false
                }

                if(size > 5000000) {
                    alert('Gambar terlalu besar! maksimal 5 mb')
                    $(this).val('')
                    return false
                }
        })

        $('#upload-photo').click(function(e) {
            e.preventDefault()
            var formData = new FormData(), self = this

            if($('#photo-file').val() == '') {
                alert('Harap upload photo terlebih dahulu')
                return false
            }

            // Display loading
            $(this).find('.fa-spinner').toggleClass('d-none')
            $(this).find('.fa-upload').toggleClass('d-none')

            // Set data image
            formData.append('photo', imgObject)
            formData.append('id', '<?= $this->akun->id; ?>')

            $.ajax({
                type: 'post',
                url: "<?= base_url('pengusaha/update_photo') ?>",
                data: formData,
                contentType: false,
                processData: false,
                success: function(res) {
                    res = JSON.parse(res)
                    $(self).find('.fa-spinner').toggleClass('d-none')
                    $(self).find('.fa-upload').toggleClass('d-none')
                    $('#avatar').prop('src', res.url)
                },
                error: function(e) {
                    $(self).find('.fa-spinner').toggleClass('d-none')
                    $(self).find('.fa-upload').toggleClass('d-none')
                    alert('Upload Photo gagal!')
                    console.error(e.responseText)
                    return false
                }
            })
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
                    url: "<?= base_url('pengusaha/update_profile') ?>",
                    data: {
                        id: $('#id').val(),
                        key: $(this).data('key'),
                        value: $(this).val()
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







