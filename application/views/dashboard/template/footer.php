<!-- Chat Whatsapp -->
<?php if($this->akun->ins == 'SMAN 5 Bandung') : ?>
<div class="popup-chat flex-column m-4 animate-hide" id="popup-start">
	<header class="bg-success pl-3 pr-4 pt-3 pb-3 d-flex justify-content-center align-items-center">
		Halo, Ada kendala mengenai E-Learning nya?
	</header>
	<section class="d-flex flex-column pl-3 pr-4 pt-3 pb-3" style="line-height: 20px;">
		<p><i class="far fa-comments mr-2" style="line-height: 20px;transform: scale(1);"></i> Chat kami sekarang yuk!</p>
		<div class="d-flex justify-content-between">
			<p><strong>	082216169143 </strong></p>
			<p><strong>	087825979439 </strong></p>
		</div>
	</section>
</div>
<div class="chat-container d-flex align-items-center" id="chat-start">
	
	<div class="img-section mr-2">
		<img src="https://elearning-rds.online/assets/img/logo/wa.png" alt="whatsapp-logo" class="chat-img">
	</div>
	<div class="label-section mt-1">
		<label for="" class="d-block" id="label-chat">Butuh Bantuan?</label>
	</div>
	
</div>
<?php endif; ?>
<script>
	window.jQuery || document.write('<script src="<?= base_url(); ?>assets/js/jquery/jquery-3.3.1.min.js">\x3C/script>')
</script>
<script type="text/javascript">
	$('#chat-start').click(() => {
    	$('#popup-start').toggleClass('animate-hide')
    	$('#popup-start').toggleClass('animate-show')
    })
    var base_url = "<?php echo base_url(); ?>";
	var editor_style = "<?php echo $this->config->item('editor_style'); ?>";
	var uri_js = "<?php echo $this->config->item('uri_js'); ?>";
	let uploadOk = 0, file, ext, filename
	    ;
	var token_modul = "";    
    var data = new FormData();
    function up_files(element) {
    	token_modul = element.getAttribute('data-modal');
    	$('#up_silabus').modal('toggle');
    }

    function back_page(url){
    	window.location = base_url + url;
    }

    function delete_silabus(element) {
    	token_modul = element.getAttribute('data-modal');
    	let sure = confirm('Kamu yakin?');
    	if(sure) {
    		$('title').text('Loading...');
    		$.ajax({
	    		type:"GET",
	    		url:"<?= base_url('Materi/check_silabus_exist'); ?>",
	    		data:{md5:token_modul},
	    		dataType:"JSON",
	    		success:function(res) {
	    			
	    			if(res.status === true) {
	    				$.ajax({
	    					type:"POST",
	    					url:"<?= base_url('Materi/delete_silabus'); ?>",
	    					data:{md5:token_modul},
	    					dataType:"JSON",
	    					success:function(res) {
	    						if(res.status == true) {
	    							alert('Silabus berhasil dihapus!');
	    							window.location.reload();
	    						}
	    						else {
	    							alert('Something went wrong, please contact your developer!');
	    							console.log(res);
	    							return false;
	    						}
	    					},
	    					error:function(e) {
	    						alert('Something went wrong, contact your developer!');
	    						console.log(e);
	    						return false;
	    					}
	    				})
	    			}
	    			else {
	    				$('title').text('E-Learning UMKM');
	    				alert('Hapus gagal, silabus belum ada!');
	    				return false;
	    			}
	    		}
	    	});
    	}
    }

    function checkExist(element) {
    	let src = element.getAttribute('data-src');
    	let md5 = src.split('/');
    	md5 = md5[md5.length - 1];
    	$('title').text('Loading...');
    	$.ajax({
    		type:"GET",
    		url:"<?= base_url('Materi/check_silabus_exist'); ?>",
    		data:{md5:md5},
    		dataType:"JSON",
    		success:function(res) {
    			$('title').text('E-Learning UMKM');
    			if(res.status === true) {
    				window.location.href = src;
    			}
    			else {
    				alert('Silabus belum ada, silahkan upload silabus!');
    				return false;
    			}
    		}
    	});
    }

	$('.loading').hide();
	$('#silabus_file').change(function(e) {
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
	$('#upload-silabus').click(function(e) {
		e.preventDefault();

		$('#spin-icon').toggleClass('hide');
		if($('#silabus_file').val() != '') {
			if(uploadOk === 1) {
				data.append('file', file);
				data.append('token_modul', token_modul);

				$.ajax({
					type:"POST",
					url:"<?= base_url('Materi/upload_silabus') ?>",
					data:data,
					contentType:false,
					processData:false,
					success:function(res) {
						$('#spin-icon').toggleClass('hide');
    		              res = JSON.parse(res);
    		               console.log(res);
    		              if(res.status == true) {
    		                  alert(res.msg);
    		                  window.location.reload();
    		              }
    		              else {
    		                  alert(res.msg);
    		                  return false;
    		              }
					}
				})
			}
		}
		else {
			alert('Harap upload silabusnya!');
			$('#spin-icon').toggleClass('hide');
			return false;	

		}
	});

	// Event for Sub Menu
	$('.parent-menu-link').click(function(e) {
		e.preventDefault()
		$(this).siblings('ul.sub-menu').toggleClass('d-none')
		let makeDownArrow = {
			transition: '.5s',
			transform: 'rotate(90deg)',
		}

		$(this).find('.caret-sub-menu').toggleClass('caret-90deg')
	})

	function formatAngka(angka) {
      if (typeof(angka) != 'string') angka = angka.toString();
      var reg = new RegExp('([0-9]+)([0-9]{3})');
      while(reg.test(angka)) angka = angka.replace(reg, '$1.$2');
      return angka;
    }
	$(document).on('keypress','.only-number',function(evt){
		var charCode = (evt.which) ? evt.which : event.keyCode
             if (charCode > 31 && (charCode < 48 || charCode > 57))

                return false;
            return true;
	})

	$(document).on('keyup','.format-uang',function(evt){
		val = $(this).val().replace(/\./g, '');
		$(this).val(formatAngka(val));
	})
	
</script>	
<script src="<?= base_url(); ?>assets/js/vendors.min.js"></script>
<script src="<?= base_url(); ?>assets/js/main.min.js"></script>
<?php
if ($this->uri->segment(2) == "m_soal" && $this->uri->segment(3) == "edit") {
	?>
<script src="<?php echo base_url(); ?>assets/plugin/ckeditor/ckeditor.js"></script>
<?php
}    
?> 

<script src="<?php echo base_url(); ?>assets/plugin/plugin/datatables/Indonesian.json"></script>
<script src="<?php echo base_url(); ?>assets/plugin/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugin/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugin/jquery_zoom/jquery.zoom.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugin/countdown/jquery.countdownTimer.js"></script>
<script src="<?php echo base_url(); ?>assets/js/aplikasi.js?time=<?php echo time(); ?>"></script>

<script src="<?=base_url();?>/assets/vendor/select2/select2.min.js"></script>
<script src="<?=base_url();?>/assets/vendor/datepicker/moment.min.js"></script>
<script src="<?=base_url();?>/assets/vendor/datepicker/daterangepicker.js"></script>

<script src="<?=base_url();?>/assets/vendor/global.js"></script>

<div class="modal fade" id="img-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body p-0">
        <img src="" alt="">
      </div>
    </div>
  </div>
</div>
<div id="siswa-modal"></div>
</body>

</html>