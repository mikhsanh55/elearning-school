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
                        <h2 class="ml-4">Upload PDF</h2>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 text-right">
                        <button class="btn btn-light" onclick="back_page('materi', true)">Kembali</button>
                    </div>
                </div>
                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" action="POST" class="" enctype="multipart/form-data">

                    <div class="row container mx-auto">
                        <div class="col-sm-4">
                            <input type="hidden" name="imateri" value="<?= $materi->id; ?>" class="imateri">
                            <input type="hidden" name="imapel" value="<?= $materi->id_mapel; ?>" class="mapel">
                         
                        </div>
                    </div>
                    <br><br>
                  
                        <div class="row container mx-auto">
                            <div class="col-sm-12">
                                <h3><label for="title" class="text-success">File</label></h3>
                                <input type="file" name="file[]" id="file" class="form-control" value="<?= $materi->file_pdf; ?>" required multiple="multiple" /><span><?= $materi->file_pdf; ?></span>
                                <p id="passwordHelpBlock" class="form-text text-muted">
                                  File PDF yang akan diupload maksimal memiliki ukuran 100 MB.
                                </p>
                            </div>
                            <div class="col-sm-12 list-pdf">
                                <header>File PDF: </header>
                            </div>
                        </div>
                    <br>
                    <div class="row container mx-auto">
                        <div class="col-sm-12 mx-auto">
                            <button class="btn btn-primary btn-block" type="submit">Upload PDF <i id="spin-icon" class="ml-2 fas fa-spinner d-none"></i></button>
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
<script>
    $(document).ready(function() {
        let file = undefined, filename, ext, uploadOk = 1, maxSize = 104857600;
        let data = new FormData(), html, fileArray = [];
        
        // kontent
        $('input[type=file]').change(function() {
            html = '';
            for(var x = 0;x < this.files.length;x++) {
               file = this.files[x]; 
               filename = this.value;
               ext = filename.substring(filename.lastIndexOf('.') + 1);
               if(ext != 'pdf') {
                   alert('File harus PDF!');
                   this.value = '';
                   return false;
               }
               else if(file.size > maxSize) {
                   alert('File terlalu besar! Maksimal 100 MB');
                   this.value = '';
                   return false;
               }
               else {
                   html = `<span class="badge badge-primary m-1">${file.name}</span>`;
                   $('.list-pdf').append(html);
                   uploadOk = 1;
               }  
            }
              
        });

        $('form').submit(function(e) {
            e.preventDefault();

            
            if(uploadOk === 1)
            
                if(file != undefined) {
                    file = document.querySelector('input[type=file]').files.length;
                    
                    for(var x = 0;x < file;x++) {
                        data.append('file[]', document.querySelector('input[type=file]').files[x]);
                    }
                }
                data.append('imateri', $('input[name=imateri]').val());
                data.append('imapel', $('input[name=imapel]').val());
                $('#spin-icon').toggleClass('d-none');
                $.ajax({
			    xhr:function() {
			        let xhr = new window.XMLHttpRequest();
			        
			        xhr.upload.addEventListener("progress", function(e) {
			            if(e.lengthComputable) {
			                let percentComplete = e.loaded / e.total;
			                // console.log(percentComplete);
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
                    url:"<?= base_url('Materi/update_pdf'); ?>",
                    data:data,
                    cache: false,
                    contentType:false,
                    processData:false,
                    success:function(res) {
                        res = JSON.parse(res);
                        if(res.status == true) {
                            $('#spin-icon').toggleClass('d-none');
                            
                            console.log(res);
                            // window.location.href = sessionStorage.getItem('url');
                        }
                        else {
                            $('#spin-icon').toggleClass('hide');
                            console.log(res);
                            alert(res.msg);
                            return false;
                        }
                    }
                });    
            
            
        });
    });
</script>