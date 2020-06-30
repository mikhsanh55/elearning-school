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
                        <h4><?= (empty($this->akun->nama)) ? NULL : $this->akun->nama ;?></h4>
                        <small><cite title="<?= (empty($this->akun->alamat)) ? NULL : $this->akun->alamat ;?>"><?= (empty($this->akun->alamat)) ? NULL : $this->akun->alamat ;?><i class="glyphicon glyphicon-map-marker">
                        </i></cite></small>
                        <table class="table table-borderless">
                            <tr>
                                <th>Username</th>
                                <td><?= (empty($this->akun->username)) ? NULL : $this->akun->username ;?></td>
                            </tr>
                            <tr>
                                <th>Pangkat</th>
                                <td><?= (empty($this->akun->pangkat)) ? NULL : $this->akun->pangkat ;?></td>
                            </tr>
                            <tr>
                                <th>NISN</th>
                                <td>
                                    <?= (empty($this->akun->nrp)) ? NULL : $this->akun->nrp ;?>
                                </td>
                            </tr>
                            <tr>
                                <th>Tahun Angkatan Masuk</th>
                                <td>
                                    <?= (empty($this->akun->tahun_angkatan_masuk)) ? NULL : $this->akun->tahun_angkatan_masuk ;?>
                                </td>
                            </tr>
                            <tr>
                                <th>Angkatan</th>
                                <td>
                                    <?= (empty($this->akun->angkatan)) ? NULL : $this->akun->angkatan ;?>
                                </td>
                            </tr>
                            <tr>
                                <th>No Telpon</th>
                                <td>
                                    <?= (empty($this->akun->no_telpon)) ? NULL : $this->akun->no_telpon ;?>
                                </td>
                            </tr>
                            <tr>
                                <th>NIP</th>
                                <td><?= (empty($this->akun->nim)) ? NULL : $this->akun->nim ;?></td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td><?= (empty($this->akun->nik)) ? NULL : $this->akun->nik ;?></td>
                            </tr>
                            <tr>
                                <th>Jurusan</th>
                                <td><?= (empty($this->akun->jurusan)) ? NULL : $this->akun->jurusan ;?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?= (empty($this->akun->email)) ? NULL : $this->akun->email ;?></td>
                            </tr>
                            <tr>
                                <th>Tempat Lahir</th>
                                <td><?= (empty($this->akun->tempat_lahir)) ? NULL : $this->akun->tempat_lahir ;?></td>
                            </tr>
                            <tr>
                                <th>Tanggal Lahir</th>
                                <td><?= (empty($this->akun->tanggal_lahir)) ? NULL : longdate_indo($this->akun->tanggal_lahir) ;?></td>
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







