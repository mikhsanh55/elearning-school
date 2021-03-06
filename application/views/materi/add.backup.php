<style type="text/css">
    html, body {
        overflow: auto;
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
	.hide {
	    display:none;
	}
</style>
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"><div id="wrapper">
        <div class="header">
            <nav class="navbar  fixed-top navbar-site navbar-light bg-light navbar-expand-md"
                 role="navigation">
                <div class="container">
                <div class="navbar-identity">
                    <a href="<?= base_url('adm'); ?>" class="navbar-brand logo logo-title">
                    <span class="logo-icon mr-3"><img src="<?=$this->logo;?>" width="auto" height="40" /></span><?=$this->title;?></span> </a>
                    <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggler pull-right"
                        type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 30 30" width="30" height="30" focusable="false"><title>Menu</title><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-miterlimit="10" d="M4 7h22M4 15h22M4 23h22"/></svg>
                </button>
                </div>
                    <div class="navbar-collapse collapse">
                        <ul class="nav navbar-nav navbar-left">
                            <li class="flag-menu country-flag tooltipHere hidden-xs nav-item" data-toggle="tooltip"
                                data-placement="bottom" title="Select Country">
                            </li>
                        </ul>
                        <ul class="nav navbar-nav ml-auto navbar-right">
                        <li class="dropdown no-arrow nav-item"><a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">

                                <span><?php echo $this->session->userdata('admin_nama')."(".$this->session->userdata('admin_user').")"; ?></span> <i class="icon-user fa"></i> <i class=" icon-down-open-big fa"></i></a>
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
                        <input type="hidden" name="mapel" value="" id="mapels" />
                    </div>
                </div>
                <br><br>            
                <div class="row container mx-auto">
                    <div class="col-sm-12">
                        <h4><label for="title" class="text-success">Title</label><span class="text-danger"> *</span></h4>        
                        <input type="text" class="form-control" placeholder="Judul sub modul..." name="title" value="" autofocus>
                    </div>
				</div>
				<br><br>            
                <div class="row container mx-auto">
                    <div class="col-sm-12">
                        <h4><label for="video" class="text-success">Video</label><span class="text-danger"> *</span></h4>        
                        <input type="text" class="form-control" placeholder="Masukan Id Video..." name="video" value="" autofocus>
                    </div>
                </div>
                <br><br>            
                <div class="row container mx-auto">
                    <div class="col-sm-12">
                        <h4><label for="title" class="text-success">Konten</label><span class="text-danger"> *</span></h4>        
                        <textarea id="content" name="content"></textarea>
                    </div>
                </div>
                <br><br><br><br>
                <div class="row container mx-auto">
                     <div class="col-sm-12 mx-auto">
                         <button class="btn btn-primary  mb-4 " type="submit">Buat Sub Modul! <i class="fas fa-spinner ml-2 spin-icon d-none"></i> </button>       
                         <br>
                         <div class="progress d-none mt-4" id="progress-container">
                             <div id="progressBar" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
        						<span class="sr-only">0%</span>
        					</div>
                         </div>
                         <div class="alert text-left d-none" id="progress-msg"></div>
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
        CKEDITOR.editorConfig = function (config) {
            config.language = 'es';
            config.uiColor = '#F7B42C';
            config.height = 300;
            config.toolbarCanCollapse = true;
        };
        CKEDITOR.replace('content');

        // Define variables
        let title = $('input[name=title]'),
        uploadOk = 0,
        select = document.querySelector('input[type=hidden][name=mapel]'),
        file = '', filename = '', ext = '', 
        video = document.querySelector('input[type=text][name=video]'),
        progressBar = $('#bar1'), progressPercent = $('#percent1');

        select.value = sessionStorage.getItem('mapel');    

        // Validasi file
        $('input[type=file]').change(function() {
           file = this.files[0]; 
		   filename = this.value;
		   ext = filename.substring(filename.lastIndexOf('.') + 1);
		   if(ext != 'mp4') {
		       alert('Harap upload video!');
		       this.value = '';
		       return false;
		   }
		   else {
		       uploadOk = 1;
		   }

        });
        
        // When Trainer / Admin create Sub MOdule
		$('button[type=submit]').click(function(e) {
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
			data.append('video', video.value)
			data.append('mapel', select.value);
			let dataAjax = {};
			$('.spin-icon').toggleClass('d-none');
			if(filename != '') {
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
					url:"<?= base_url('Materi/insert'); ?>",
					data:data,
					contentType:false,
					processData:false,
					success:function(res) {
						res = JSON.parse(res);
						alert(res.msg);
						console.log(res);
						$('.spin-icon').toggleClass('d-none');
						window.location.href = sessionStorage.getItem('url');
					},
					error:function(e) {
						console.log(e);
						return false;
					}
				});
			}
			else {
				alert(2);
				false;
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
				                $('#progressBar').attr('aria-valuenow', percent).css('width', percent + '%').text(percent + '%');
				            }
				        }, false);
				        
				        return xhr;
				    },
					type:"POST",
					url:"<?= base_url('Materi/insert'); ?>",
					data:data,
					contentType:false,
					processData:false,
					success:function(res) {
						res = JSON.parse(res);
						$('.spin-icon').addClass('d-none');
						if(res.status == true) {
							alert(res.msg);
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
			}
		});
    });
</script>
