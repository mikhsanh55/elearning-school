<style type="text/css">
    html,
    body {
        overflow: auto;
    }
</style>
<div id="wrapper">
    <div class="header">
        <nav class="navbar  fixed-top navbar-site navbar-light bg-light navbar-expand-md" role="navigation">
            <div class="container">
                <div class="navbar-identity">
                    <a href="<?= base_url('adm'); ?>" class="navbar-brand logo logo-title">
                       <span class="logo-icon mr-3"><img src="<?=$this->logo;?>" width="auto" height="40" /></span><?=$this->title;?></span> </a>
                    <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggler pull-right" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 30 30" width="30" height="30" focusable="false">
                            <title>Menu</title>
                            <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-miterlimit="10" d="M4 7h22M4 15h22M4 23h22" />
                        </svg>
                    </button>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-left">
                        <li class="flag-menu country-flag tooltipHere hidden-xs nav-item" data-toggle="tooltip" data-placement="bottom" title="Select Country">
                        </li>
                    </ul>
                    <ul class="nav navbar-nav ml-auto navbar-right">
                        <li class="dropdown no-arrow nav-item"><a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">

                                <span><?php echo $this->session->userdata('admin_nama') . "(" . $this->session->userdata('admin_user') . ")"; ?></span> <i class="icon-user fa"></i> <i class=" icon-down-open-big fa"></i></a>
                            <ul class="dropdown-menu user-menu dropdown-menu-right">

                                <li class="dropdown-item"><a href="#" onclick="return rubah_password();"><i class="icon-th-thumb"></i> Ubah Password </a>
                                </li>

                                <li class="dropdown-item"><a href="<?php echo base_url(); ?>login/logout" onclick="return confirm('keluar..?');"> <i class=" icon-logout "></i> Log out </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <!-- end of header -->

    <div class="main-container">
        <div class="container">
            <div class="inner-box">
                <div class="row align-items-center">
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <h2 class="ml-4">Edit Materi</h2>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 text-right">
                        <button class="btn btn-light" onclick="back_page('materi', true)">Kembali</button>
                    </div>
                </div>
                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" action="POST" class="">
                    <div class="row container mx-auto">
                        <div class="col-sm-4">
                            <input type="hidden" name="imateri" value="<?= $materi->id; ?>" class="imateri">
                            <input type="hidden" name="imapel" value="<?= $materi->id_mapel; ?>" class="mapel">
                         
                        </div>
                    </div>
                    <br><br>
                    <div class="row container mx-auto">
                        <div class="col-sm-12">
                            <h4><label for="title" class="text-success">Title</label><span class="text-danger"> *</span></h4>
                            <input type="text" class="form-control" placeholder="Judul materi..." name="title" value="<?= $materi->title; ?>" >
                        </div>
                    </div>
                    <br><br>

                    <div class="row container mx-auto">
                        <div class="col-sm-12">
                            <h4><label for="title" class="text-success">Gambar Sampul</label></h4>
                            <div id="img-wrapper">
                                <?php if(!is_null($materi->image)) : ?>
                                    <img src="<?= base_url($this->_pathGambarSampul . $materi->image); ?>" alt="Gambar Sampul" width="130" height="130" class="img-thumbnail mb-3">
                                <?php endif; ?>
                            </div>        
                            
                            <input type="file" id="gambar_sampul" class="form-control" name="gambar_sampul">
                        </div>
                    </div>
                    <br><br>
                    <div class="row container mx-auto">
                        <div class="col-sm-12">
                            <h4><label for="video" class="text-success">Video</label><span class="text-danger"></span></h4>
                            <button class="btn btn-sm btn-primary mb-4" id="tambah-link">
                                <i class="fas fa-plus mr-2"></i>Tambah Link
                            </button>
                            <section class="section-video">
                                <div class="form-group d-flex">
                                    
                                    <div class="mr-4">
                                        <label for="type-gdrive">Google Drive</label>
                                        <input type="radio" name="typeVideo" id="type-gdrive" class="typeVideos"  <?php if($materi->id_type_video == 2): ?>
                                            checked
                                        <?php endif; ?> data-type="video-gdrive">
                                    </div>
                                    <div>
                                        <label for="type-youtube">Youtube</label>
                                        <input type="radio" name="typeVideo" data-type="video-youtube" id="type-youtube" class="typeVideos" <?php if($materi->id_type_video == 3) : ?> checked <?php endif; ?> >
                                    </div>
                                </div>
                                <?php if(count($uploadedFiles) > 0) { ?>
                                    <?php $i = 1;foreach($uploadedFiles as $file) : ?>
                                        
                                        <section class="section-video mt-2" style="position: relative;">        
                                            <?php if($i > 1) { ?>
                                            <div class="text-right" style="position:absolute;right:0;">
                                                <a href="javascript:void(0);" class="btn btn-danger btn-sm remove-link">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            </div>
                                            <?php } ?>
                                            <input type="text" class="form-control link-videos" placeholder="Masukan Link Video" name="video[]" value="<?= $file->path; ?>" autofocus>

                                        </section>
                                    <?php $i++; endforeach; ?>
                                <?php } else { ?>
                                    <input type="text" class="form-control link-videos" placeholder="Masukan Link Video" name="video[]" value="" autofocus>
                                <?php } ?>
                                <div id="section-video-container">
                                </div>
                            </section>
                        </div>
                    </div>
                    <br><br>
                    <div class="row container mx-auto">
                        <div class="col-sm-12">
                            <h4><label for="title" class="text-success">Konten</label><span class="text-danger"></span></h4>
                            <textarea name="content" id="content"><?= $materi->content; ?></textarea>
                        </div>
                    </div>
                    <br><br><br><br>
                    <div class="row container mx-auto">
                        <div class="col-sm-12 mx-auto">
                            <button class="btn btn-primary btn-block mb-4" id="update-materi-btn" type="submit">
                                <span id="label-materi">Update Materi </span>
                                <i id="spin-icon" class="spin-icon ml-2 d-none fas fa-spinner"></i>
                            </button>
                            <br>
                             <div class="progress d-none mt-4" id="progress-container">
                                 <div id="progressBar" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
            						<span class="sr-only">0%</span>
            					</div>
                             </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<link href="<?= base_url(); ?>assets/plugins/editor/dist/css/jquery.wysiwygEditor.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>
<script type="text/javascript" src="<?= base_url('assets/plugin/ckeditor/ckeditor.js') ?>"></script>
<script>
    $(document).ready(function() {
        let templateVideo = `
            <section class="section-video mt-2" style="position: relative;">        
                <div class="text-right" style="position:absolute;right:0;">
                    <a href="javascript:void(0);" class="btn btn-danger btn-sm remove-link">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
                <input type="text" class="form-control link-videos" placeholder="Masukan Link Video" name="video[]" value="" autofocus>

            </section>
        `;
        $('#tambah-link').on('click', function(e) {
            e.preventDefault();
            $('#section-video-container').append(templateVideo);

        });

        $(document).on('click', '.remove-link', function(e) {
            e.preventDefault();
            $(e.currentTarget).parent().parent().remove();
        })
        CKEDITOR.editorConfig = function(config) {
            config.language = 'es';
            config.uiColor = '#F7B42C';
            config.height = 300;
            config.toolbarCanCollapse = true;

        };
        CKEDITOR.replace('content');

        // Define variables
        let title = $('input[name=title]'),
        mapel = $('.mapel'),
        imateri = $('.imateri'),
        uploadOk = 0,
        video = '',
        typeVideo = document.querySelectorAll('input[type=radio][name=typeVideo]'),
        uploadManual = false, uploadType = 'manual';
        
        // Define Vars for Video Upload Manual
        var file = '', filename = '', ext = ''
       
		$('#update-materi-btn').click(function(e) {
			e.preventDefault();

			// Base validation
			if(title.val() == '') {
				alert('Harap isi title');
				return false;
			}
            
			let content = CKEDITOR.instances['content'].getData();
            let data = new FormData();
			if(content == '') {
				alert('Harap isi konten');
				return false;
			}

            video = document.querySelectorAll('.link-videos');
            for(let i = 0;i < video.length;i++) {
                
                if(video[i].value != '') {
                    if(!$('.typeVideos').is(':checked')) {
                        alert('Harap pilih tipe video');
                        return false;
                    }
                    data.append('video[]', video[i].value);
                }
            }

            if($('.typeVideos').is(':checked')) {
                data.append('type-video', $('.typeVideos:checked').data('type'));   
            }

			// Store Data
                    
			data.append('title', title.val());
			data.append('content', content);
			data.append('mapel', mapel.val());
            data.append('imateri', imateri.val());
            
            if($('#gambar_sampul').prop('files').length > 0) {
                data.append('gambar_sampul', $('#gambar_sampul').prop('files')[0]);
            }

			let dataAjax = {};
			
			// Start Insert Ajax
            $('.spin-icon').removeClass('d-none'); // start spinner
            $('#label-materi').addClass('d-none'); // Hide the label
            $('button[type=submit]').prop('disabled', true);
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
				type:"POST",
				url:"<?= base_url('Materi/update'); ?>",
				data:data,
                dataType: 'json',
				contentType:false,
				processData:false,
				success:function(res) {
                    $('.spin-icon').addClass('d-none'); // start spinner
                    $('#label-materi').removeClass('d-none'); // Hide the label
                    $('button[type=submit]').prop('disabled', false);

					if(res.status == true) {
						window.location.href = sessionStorage.getItem('url') || localStorage.getItem('url');
					}
					else {
						alert(res.msg);
                        console.error(res);
						return false;
					}
					
				},
				error:function(e) {
                    $('.spin-icon').addClass('d-none'); // start spinner
                    $('#label-materi').removeClass('d-none'); // Hide the label
                    $('button[type=submit]').prop('disabled', false);
					alert(e.responseJSON.msg);
					console.error(e);

                    $('#progressBar').text('Error!').addClass('bg-danger');
                    $('#progress-container').addClass('d-none');
					return false;
				}
			});
		});
    });
</script>