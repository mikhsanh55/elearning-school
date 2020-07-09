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
</style>

<div class="col-md-9 page-content">
        <div class="inner-box">
        	<div class="row align-items-center">
        		<div class="col-sm-12 col-md-6 col-lg-6">
        			<h2 class="ml-4">Tambah Materi</h2>
        		</div>
        		<div class="col-sm-12 col-md-6 col-lg-6 text-right">
					<button class="btn btn-light" onclick="back_page('materi', true)">Kembali</button>
				</div>
        	</div>
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
                        
                        <input type="text" class="form-control" placeholder="<?= $placeholder; ?>" name="title" autofocus >
                        
                    </div>
				</div>
				<br><br>            
                <div class="row container mx-auto">
                    <div class="col-sm-12">
                        <h4><label for="video" class="text-success">Video</label><span class="text-danger"> *</span></h4>
                        <div class="form-group d-flex">
                        	<!-- <div class="mr-4">
                        		<label for="type-manual">Upload Manual</label>
                        		
                        		<input type="radio" name="typeVideo" id="type-manual" data-type="manual">
                        	</div> -->
                        	<div class="mr-4">
                        		<label for="type-gdrive">Google Drive</label>
                        		<input type="radio" name="typeVideo" id="type-gdrive" checked data-type="gdrive">
                        	</div>
                        	<div>
                        		<label for="type-youtube">Youtube Link</label>
                        		<input type="radio" name="typeVideo" id="type-youtube" data-type="youtube">
                        	</div>
                        </div>        
                        <input type="text" class="form-control" placeholder="Masukan Id Video Google Drive" name="video" value="" autofocus>
                        <!-- <input type="file" name="video-manual" class="form-control d-none" value=""> -->
                        <input type="text" class="form-control d-none" placeholder="Masukan Link Video Youtube" name="videoYt">
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
                         <!-- Progress Bar -->
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
        mapel = sessionStorage.getItem('mapel') != null ? sessionStorage.getItem('mapel') : localStorage.getItem('mapel'),
        video = document.querySelector('input[type=text][name=video]'),
        videoYt = document.querySelector('input[type=text][name=videoYt]'),
        videoManual = document.querySelector('input[type=file][name=video-manual]'),
        typeVideo = document.querySelectorAll('input[type=radio][name=typeVideo]'),
        uploadManual = false,
        /*fileVideo = '', fileVideoName = '', extVideo = '',*/
        progressBar = $('#bar1'), progressPercent = $('#percent1'),
        uploadType = $('input[type=radio][name=typeVideo]:checked').data('type');
        

        // Validasi file
        typeVideo.forEach(function(el) {
        	el.addEventListener('change', function() {
        		if(el.dataset.type == 'manual')	{
        			// videoManual.classList.remove('d-none')

        			video.classList.add('d-none')
        			videoYt.classList.add('d-none')
        			uploadManual = true
        			uploadType = 'manual'
        		}
        		else if(el.dataset.type == 'gdrive') { // Google Drive
        			video.classList.remove('d-none')
        			
        			// videoManual.classList.add('d-none')
					videoYt.classList.add('d-none')
        			uploadManual = false
        			uploadType = 'gdrive'
        		}
        		else if(el.dataset.type == 'youtube'){ // Youtube Link
        			videoYt.classList.remove('d-none')

        			// videoManual.classList.add('d-none')
        			video.classList.add('d-none')
        			uploadManual = false
        			uploadType = 'youtube'
        		}	
        	})
        	
        });

        // Define Vars for Video Upload Manual
        var file = '', filename = '', ext = ''
        videoManual.addEventListener('change', function() {
           file = this.files[0]; 
		   filename = this.value;
		   ext = filename.substring(filename.lastIndexOf('.') + 1);
		   if(ext != 'mp4' && ext != 'mkv') {
		       alert('Harap upload video!');
		       this.value = '';
		       return false;
		   }
        })
        
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
			switch(uploadType) {
				case 'manual':
				data.append('video_manual', file)
				data.append('id_type_video', 1)
				break

				case 'gdrive':
				data.append('video-gdrive', video.value)
				data.append('id_type_video', 2)
				break

				case 'youtube':
				data.append('video-youtube', videoYt.value)
				data.append('id_type_video', 3)
				break
			}

			data.append('title', title.val());
			data.append('content', content);
			data.append('mapel', mapel);
			 
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
						// alert(res.msg);
						// console.log(res);
						$('.spin-icon').toggleClass('d-none');
						window.location.href = sessionStorage.getItem('url') || localStorage.getItem('url');
					},
					error:function(e) {
						console.log(e);
						return false;
					}
				});
			}
			else {
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
				                // let percentComplete = e.loaded / e.total;
				                // console.log(percentComplete);
				                // // console.log('e.total : ' . e.total);
				                // percentComplete = parseInt(percentComplete * 100);
				                // $('#progress-container').removeClass('d-none');
				                // $('#progressBar').attr('aria-valuenow', percent).css('width', percent + '%').text(percent + '%');
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
							// alert(res.msg);
							window.location.href = sessionStorage.getItem('url') || localStorage.getItem('url');
						}
						else {
							alert(res.msg);
							return false;
						}
						
					},
					error:function(e) {
						alert(e.responseText.msg);
						console.log(e);
						return false;
					}
				});
			}
		});
    });
</script>
