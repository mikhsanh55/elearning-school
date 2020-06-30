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
                            <h4><label for="video" class="text-success">Video</label><span class="text-danger"> *</span></h4>
                            <input type="text" class="form-control" placeholder="Masukan Id Video..." name="video" value="<?= $materi->path_video; ?>" autofocus>
                        </div>
                    </div>
                    <br><br>
                    <div class="row container mx-auto">
                        <div class="col-sm-12">
                            <h4><label for="title" class="text-success">Konten</label><span class="text-danger"> *</span></h4>
                            <textarea name="content" id="content"><?= $materi->content; ?></textarea>
                        </div>
                    </div>
                    <br><br><br><br>
                    <div class="row container mx-auto">
                        <div class="col-sm-12 mx-auto">
                            <button class="btn btn-primary mb-4" id="update-materi-btn" type="submit">Update Materi! <i id="spin-icon" class="ml-2 hide fas fa-spinner"></i></button>
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
        video = document.querySelector('input[type=text][name=video]');

		$('#update-materi-btn').click(function(e) {
			e.preventDefault();

			// Base validation
			if(title.val() == '') {
				alert('Harap isi title');
				return false;
			}

			let content = CKEDITOR.instances['content'].getData();
			if(content == '') {
				alert('Harap isi konten');
				return false;
			}	

			// Store Data
			let data = new FormData();
			data.append('title', title.val());
			data.append('content', content);
			data.append('mapel', mapel.val());
			data.append('imateri', imateri.val());
			data.append('video', video.value);
			let dataAjax = {};
			$('#spin-icon').removeClass('hide');
			
			// Ajax
			$('.spin-icon').removeClass('d-none');
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
				contentType:false,
				processData:false,
				success:function(res) {
					res = JSON.parse(res);
					$('.spin-icon').addClass('d-none');
					if(res.status == true) {
						alert(res.msg);
						console.log(res);
						window.location.href = sessionStorage.getItem('url');
					}
					else {
						alert(res.msg);
						return false;
					}
					
				},
				error:function(e) {
					alert('An error occured. Please contact your developer!');
					console.log(e);
					return false;
				}
			});
		});
    });
</script>