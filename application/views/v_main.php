<div class="row ini_bodi">
  <div class="panel panel-info col-md-12">
    <div class="panel-heading">Selamat dasatang di <?=$this->title;?></div>
    <div class="panel-body" style="border: 0px solid #000;">
        <div class="alert alert-info"><?php echo $this->session->userdata('admin_nama')."</br>".$this->akun->ins; ?></div>
       	  <?php if($opening != NULL) : ?>
            <!-- <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/63_Ym9SP50Y"></iframe>
            </div> -->
            <div class="embed-responsive embed-responsive-16by9" style="position:relative;">

            <video controls autoplay>
            <?php if($this->log_lvl != 'admin'):?>
                    <?php if(!empty($this->video_beranda)):?>
                        <source src="<?=$this->video_beranda;?>" type="video/mp4">
                    <?php else: ?>
                        <source src="<?=base_url('upload/video_beranda/tnial.mp4');?>" type="video/mp4">
                    <?php endif;?>
            <?php else: ?>
               <source src="<?=base_url('upload/video_beranda/tnial.mp4');?>" type="video/mp4">
            <?php endif;?>
         
          </video>

              <div style="width: 80px; height: 80px; position: absolute; opacity: 0; right: 0px; top: 0px; background:#000;">&nbsp;</div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="yt-video">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title video-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<div class="embed-responsive embed-responsive-16by9">
	      <iframe class="embed-responsive-item" src=""></iframe>
	    </div>
      </div>
      <div class="modal-footer">
      	<a href="" id="download-btn" class="btn btn-primary btn-sm" download>Download</a>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
	function setSess(el) {
    	sessionStorage.setItem('url', window.location.href);
    	window.location = el.getAttribute('data-href');
    }

    function viewVideo(el, e) {
    	e.preventDefault();
    	let src = el.getAttribute('data-video');
    	let video = `<div class="embed-responsive embed-responsive-16by9">
      <video controls class="video-js">
        <source src="${src}" />
      </video>
    </div>`;
    	// $('#upload-materi').modal('hide');
    	$('#yt-video .modal-body').html(video);
    	$('#yt-video').modal('show');
    	let btnDownload = `<a href=${src} class="btn btn-primary btn-sm" download>Dowload</a>`
    	console.log(el.getAttribute('data-video'));
    	$('#yt-video .modal-footer').html(btnDownload) ;
    }
	$(document).ready(function() {
	    let uploadOk = 0, file, ext, filename
	    ;
		
	    var data = new FormData();
		$('.loading').hide();
		$('.hapus-materi').click(function(e) {
		    e.preventDefault();
		    let src = window.location.href, materi = $(this).data('materi');
		    let conf = confirm("Anda akan menghapus sub modul ini?");
		    
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
		    $('#spin-icon').toggleClass('hide');
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
    		              $('#spin-icon').toggleClass('hide');
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
    			$('#spin-icon').addClass('hide');
    		    alert('Judul artikel harap diisi!');
    		    return false;
    		}
		});
	});
</script>
