

				<div class="col-md-9 page-content">
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

					<div class="inner-box">
						<header><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
							<?php if($this->session->userdata('admin_level') == 'admin' || $this->session->userdata('admin_level') == 'guru') : ?>
    							<a class="btn btn-primary btn-sm mt-3 mb-3" onclick="setSess(event, this)" href="#" data-href="<?= base_url('Materi/add') ?>"><i class="fas fa-plus ml-2 mr-2"></i> Tambah Materi</a>
    						 <!--    <a class="ml-3 btn btn-success btn-sm mt-3 mb-3 upload-sub-modul" href="<?= base_url('Materi/add') ?>"><i class="fas fa-upload ml-2 mr-2"></i> Upload Materi PDF </a> -->
							<?php endif; ?>
							<!-- breadcrumb -->
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item">
										<a href="<?= base_url('dtest/m_mapel'); ?>">
										<i class="fas fa-home"></i>
										Home
										</a>
									</li>
									<?php if(isset($kelas->nama_mapel)) : ?>
									<li class="breadcrumb-item active" aria-current="page">
										<?= (empty($kelas->nama_mapel)) ? NULL : $kelas->nama_mapel; ?>
									</li>
									<?php endif; ?>	
								</ol>
							</nav>
						</header>
						<div id="accordion" class="panel-group">
							<div id="content-view">
							</div>
						</div>
			
			
					</div>
					<!--/.row-box End-->
										
				</div>
			</div>
			<!--/.page-content-->
		</div>
		<!--/.row-->
	</div>
	<!--/.container-->
</div>
<!-- /.main-container -->
<div id="tampilkan_modal"></div>

</div>
<style>
    @keyframes rot {
        0% {
            transform:rotate(0deg);
        }
        100% {
            transform:rotate(360deg);
        }
    }
    #spin-icons {
        animation:rot 0.5s linear infinite;
    }
</style>
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="yt-video">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title video-title">Video</h5>
        <button type="button" class="close" onclick="close_video()" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<div class="embed-responsive embed-responsive-16by9">
	      <iframe class="embed-responsive-item" src=""></iframe>
	    </div>
      </div>
      <div class="modal-footer">
        <form>
            <input type="hidden" name="video-filename" value="" />
            <input type="hidden" name="video-url" value="" />
            <!-- <button type="submit" id="download-btn" data-url="" class="btn btn-primary btn-sm">Download</button> -->
        </form>  
      	
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="upload-materi">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Upload Materi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<input type="text" name="title" class="form-control mb-3" id="title-upload" placeholder="Title Materi" data-mapel="<?= $data[0]->id_mapel; ?>">
        <p class="text-danger"><small>Maksimal ukuran file 20 MB  </small></p>
        <small class="text-danger">Format yang diizinkan ( .pdf ) </small>
        <input type="file" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-sm" id="upload-file">Upload <i class="ml-2 hide fas fa-spinner" id="spin-icons"></i></button>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
	function setSess(e, el) {
		e.preventDefault()
    	sessionStorage.setItem('url', window.location.href);
    	localStorage.setItem('url', window.location.href);
    	window.location = el.getAttribute('data-href');
    }

    function close_video(){
    	let video = `<div class="embed-responsive embed-responsive-16by9" style="position:relative;">

					      <div style="width: 80px; height: 80px; position: absolute; opacity: 0; right: 0px; top: 0px; background:#000;">&nbsp;</div>
					</div>`;

    	$('#yt-video .modal-body').html(video);
    	$('#yt-video').modal('toggle');
    }

    function viewVideo(el, e) {
    	e.preventDefault();
    	var title = el.getAttribute('data-title');
    	$('.video-title').text(title);
    	let video = ''
    	// Jika video manual
    	if(el.getAttribute('data-type-video') == 1) {
    		video = `<div class="embed-responsive embed-responsive-16by9" style="position:relative;">

			      <iframe  src="${el.getAttribute('data-video')}" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe>

			      <div style="width: 80px; height: 80px; position: absolute; opacity: 0; right: 0px; top: 0px; background:#000;">&nbsp;</div>
			</div>`;
    	}
    	else {
    		video = `<div class="embed-responsive embed-responsive-16by9" style="position:relative;">

			      <iframe  src="https://drive.google.com/file/d/${el.getAttribute('data-video')}/preview" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe>

			      <div style="width: 80px; height: 80px; position: absolute; opacity: 0; right: 0px; top: 0px; background:#000;">&nbsp;</div>
			</div>`;
    	}
    	
    	// $('#upload-materi').modal('hide');
    	url = el.getAttribute('data-url');
    	$('#download-btn').attr('data-url',url);

    	$('#yt-video .modal-body').html(video);
    	$('#yt-video').modal({backdrop: 'static', keyboard: false});

    	$.ajax({
    		type:"POST",
    		url:"<?= base_url('Materi/active_nonton/') ?>",
    	});

    	$('#download-btn').on('click', function(e) {
    	    e.preventDefault();
    	    let url = $(this).data('url');
    	    $('title').text('Loading...');
    	    $.ajax({
    	        type:"POST",
    	        url:"<?= base_url('Materi/download_drive/') ?>",
    	        data:{video:url},
    	        dataType : 'json',
    	        success:function(res) {
    	           window.location.href = res.url
    	           console.log(res)
    	        },
    	        error:function(e) {
    	            console.error(e);
    	            return false;
    	        }
    	    });
    	     
    	});
    }
	$(document).ready(function() {
	    let uploadOk = 0, file, ext, filename
	    ;
		
	    var data = new FormData();
		$('.loading').hide();
		$('.hapus-materi').click(function(e) {
		    e.preventDefault();
		    let src = window.location.href, materi = $(this).data('materi');
		    let conf = confirm("Anda akan menghapus Materi ini?");
		    
		    if(conf)
		    
    		    $.ajax({
    		        type:"POST",
    		        url:"<?= base_url('Materi/s_delete'); ?>",
    		        data:{src:src, materi:materi},
    		        dataType:"JSON",
    		        success:function(res) {
    		            window.location.href = res.src;      
    		        }
    		    });
		    
		});
		
		$('.upload-sub-modul').click(function(e) {
		    e.preventDefault();
		    let url = window.location.href;
		    url = url.split('/');
		    url = url[url.length - 1];
		    console.log(url);
		    $.ajax({
		        type:"GET",
		        url:"<?= base_url('Materi/get_') ?>",
		        data:{md5:url},
		        dataType:"JSON",
		        success:function(res) {
		        	console.log(res.data);
		            $('#title-upload').data('mapel', res.data.id);
		        	// $('#yt-video').modal('hide');
		            $('#upload-materi').modal('show');        

		        }
		    });
		    
		})
		$('#buat-kategori').click(function(e) {
			e.preventDefault();
			$.ajax({
				type:"POST",
				beforeSend:function() {
					$('.loading').show();
				},
				url:"<?= base_url('Materi/insert_mapel'); ?>",
				data:{nama:$('input[name=mapel]').val()},
				dataType:"JSON",
				success:function(res) {
					console.log(res);
				},
				complete:function() {
					$('.loading').hide();
				}
			});
		});		
		$('input[type=file]').change(function() {
		   file = this.files[0]; 
		   filename = this.value;
		   ext = filename.substring(filename.lastIndexOf('.') + 1);
		   if(ext != 'pdf') {
		       alert('File harus PDF!');
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
		
		$('#upload-file').click(function(e) {
		    e.preventDefault();
		    $('#spin-icons').toggleClass('hide');
		    if($('#title-upload').val() != '') {
    		    if(uploadOk === 1) 
    		        
    		        data.append('file', file);
    		    	data.append('title', $('input[type=text]').val());
    		        data.append('id_mapel', $('input[type=text]').data('mapel'));
    		        
    		        $.ajax({
    		            url:"<?= base_url('Materi/upload_materi') ?>",
    		            type:"POST",
    		            data:data,
    		            contentType:false,
    		            processData:false,
    		            success:function(res) {
    		              $('#spin-icons').toggleClass('hide');
    		              res = JSON.parse(res);
    		              //  console.log(res);
    		              if(res.status == true) {
    		                  alert(res.msg);
    		                  window.location.reload();
    		              }
    		              else {
    		                  alert(res.msg);
    		                  return false;
    		              }
    		            }
    		        });
		    }
    		else {
    			$('#spin-icons').addClass('hide');
    		    alert('Judul artikel harap diisi!');
    		    return false;
    		}
		});
		
        //  When Download Video Youtube 		
		$('#download-btn').click(function(e) {
		    e.preventDefault();
		    $.ajax({
		        
		    })
		})
	});
</script>
<script src="<?= base_url(); ?>assets/js/jquery/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		pageLoad(1,'materi/page_load_kelas');

		$('#limit').change(function(){
			pageLoad(1,'materi/page_load_kelas');
		});

		$('#search').keyup(delay(function (e) {
			pageLoad(1,'materi/page_load_kelas');
		}, 500));

		function delay(callback, ms) {
			var timer = 0;
			return function() {
				var context = this, args = arguments;
				clearTimeout(timer);
				timer = setTimeout(function () {
					callback.apply(context, args);
				}, ms || 0);
			};
		}


	})

	function pageLoad(pg, url, search){
		$.ajax({
			type : 'post',
			url  : '<?php echo base_url() ?>' + url + '/' + pg,
			data :{
				pg    : pg,
				limit : $('#limit').val(),
				filter : $('#filter').val(),
				search : $('#search').val(),
				id_trainer : '<?=$kelas->id_trainer;?>',
				id_mapel : '<?=$kelas->id_mapel;?>'
			},
			success:function(response){
				$('#content-view').html(response);
			}
		})
	}
</script>

