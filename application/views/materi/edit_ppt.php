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
                        <h2 class="ml-4">Upload PPT</h2>
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
                    <br>
                        <div class="row container mx-auto">
                            <div class="col-sm-12 form-group">
                                <label for="title" class="text-success"><h3>File PPT</h3></label>
                                <input type="file" class="form-control" name="file[]" id="file" required multiple="multiple" />
                                <p id="passwordHelpBlock" class="form-text text-muted">
                                  File PPT yang akan diupload maksimal memiliki ukuran 100 MB.
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-12 list-files">
                                
                        </div>
                    <br>
                    <div class="row container mx-auto">
                        <div class="col-sm-12 mx-auto">
                            <button class="btn btn-primary btn-block" type="submit">Update PPT<i id="spin-icon" class="ml-2 fas fa-spinner d-none"></i></button>
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
        let file = undefined, filename, ext, uploadOk = 1, maxSize = 20971520; // 20 MB
        let data = new FormData(), fileArray = [], self, conf;

        getListFiles({
            type_file: 'ppt',
            imateri: $('input[name=imateri]').val()
        }, "<?= base_url('Materi/get-list-files'); ?>");
        
        // kontent
        $('input[type=file]').change(function() {
            var errors = 0;
               var msg = null;
            for(var x = 0;x < this.files.length;x++) {
                file = this.files[x]; 
               filename = this.value;
               ext = filename.substring(filename.lastIndexOf('.') + 1);
               console.warn(ext)

               if(ext != 'ppt' && ext != 'pptx'){
                   alert('Format File Harus ppt atau pptx');
                   this.value = '';
                   return false;
               }
               else if(file.size > maxSize) {
                   alert('File terlalu besar! maksimal 20 MB');
                   this.value = '';
                   return false;
               }
               else {
                   uploadOk = 1;
               }
            }
                
        });

        $('form').submit(function(e) {
            e.preventDefault();

            console.warn(file); 
            if(uploadOk === 1)
                /*data.append('video', $('input[type=text][name=video]').val());*/
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
                            getListFiles({
                                type_file: 'ppt',
                                imateri: $('input[name=imateri]').val()
                            }, "<?= base_url('Materi/get-list-files'); ?>");

                            if(sessionStorage.getItem('url') != null) {
                                setTimeout(function() {
                                    window.location.href = sessionStorage.getItem('url');
                                }, 2000)
                            }
                        }
                        else {
                            $('#spin-icon').toggleClass('hide');
                            console.log(res);
                            alert('Something wrong, contact your developer');
                            return false;
                        }
                    }
                });    
        });

        $(document).on('click', '.delete-file-tugas', function(e){
            e.preventDefault();
            conf = confirm('Kamu yakin akan menghapus file ini?');
            if(conf) {
                self = this;
                $.ajax({
                    type: 'post',
                    url: "<?= base_url('Materi/delete-file-materi'); ?>",
                    data: {
                        id: $(self).data('id')
                    },
                    dataType: 'json',
                    success: function(res) {
                        if(res.status) {
                            getListFiles({
                                type_file: 'ppt',
                                imateri: $('input[name=imateri]').val()
                            }, "<?= base_url('Materi/get-list-files'); ?>");
                        }
                    },
                    error: function(e) {
                        alert(e.responseText.msg);
                        console.error(e.responseText);
                        return false;
                    }
                })
            }
            else {
                return false;
            }
        })
    });
</script>