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
                            <input type="text" class="form-control" placeholder="Judul materi..." name="title" value="<?= $materi->title; ?>" autofocus>
                        </div>
                    </div>
                      <br><br>
<!--                     <div class="row container mx-auto">
                        <div class="col-sm-12">
                            <h4><label for="video" class="text-success">Video</label><span class="text-danger"> *</span></h4>
                            <input type="text" class="form-control" placeholder="Masukan Id Video..." name="video" value="<?= $materi->path_video; ?>" autofocus>
                        </div>
                    </div> -->
                    <br><br>
                        <div class="row container mx-auto">
                            <div class="col-sm-12">
                                <h4><label for="title" class="text-success">File PPT</label></h4>
                                <input type="file" name="file" id="file" value="<?= $materi->file_ppt; ?>" /><span><?= $materi->file_ppt; ?></span>
                            </div>
                        </div>
                    <br><br><br><br>
                    <div class="row container mx-auto">
                        <div class="col-sm-12 mx-auto">
                            <button class="btn btn-primary" type="submit">Update Materi! <i id="spin-icon" class="ml-2 fas fa-spinner d-none"></i></button>
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
        let file = undefined, filename, ext, uploadOk = 1;
        let data = new FormData();
        
        // kontent
        $('input[type=file][name=file]').change(function() {
            file = this.files[0]; 
           filename = this.value;
           ext = filename.substring(filename.lastIndexOf('.') + 1);
           var errors = 0;
           var msg = null;

           if(ext == 'pptx') {
             
           }else if(ext == 'ppt'){
           
           }else{
            errors++;
           }

           if(errors > 0){
               alert('Format File Harus ppt atau pptx');
               this.value = '';
               return false;
           }
           else if(file.size > 20746185) {
               alert('File terlalu besar!');
               this.value = '';
               return false;
           }
           else {
               uploadOk = 1;
           }
        });

        $('button[type=submit]').click(function(e) {
            e.preventDefault();

            if($('input[name=title]').val() != '') {
                if(uploadOk === 1)
                    data.append('title', $('input[type=text][name=title]').val());
                    /*data.append('video', $('input[type=text][name=video]').val());*/
                    if(file != undefined) {
                        data.append('file', file);
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
                        url:"<?= base_url('Materi/update_ppt'); ?>",
                        data:data,
                        contentType:false,
                        processData:false,
                        success:function(res) {
                            res = JSON.parse(res);
                            if(res.status == true) {
                                $('#spin-icon').toggleClass('d-none');
                                // alert(res.msg);
                                // console.log(res);
                                window.location.href = sessionStorage.getItem('url');
                            }
                            else {
                                $('#spin-icon').toggleClass('hide');
                                console.log(res);
                                alert('Something wrong, contact your developer');
                                return false;
                            }
                        }
                    });    
            }
            else {
                alert('Judul artikel harap diisi!');
                return false;
            }
        });
    });
</script>