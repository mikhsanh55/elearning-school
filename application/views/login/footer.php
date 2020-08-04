<?php if($contact_person === TRUE) : ?>
<div class="popup-chat flex-column m-4 animate-hide" id="popup-start">
	<header class="bg-success pl-3 pr-4 pt-3 pb-3 d-flex justify-content-center align-items-center">
		Halo, Ada kendala mengenai E-Learning nya?
	</header>
	<section class="d-flex flex-column pl-3 pr-4 pt-3 pb-3" style="line-height: 20px;">
		<p><i class="far fa-comments mr-2" style="line-height: 20px;transform: scale(1);"></i> Chat kami sekarang yuk!</p>
		<div class="d-flex justify-content-between">
			<p><strong> Pak Ikhsan </strong></p>
			<p><strong> Pak Aji </strong></p>
		</div>
		<div class="d-flex justify-content-between">
			<p><strong> 085314028181 </strong></p>
			<p><strong>	087710781433 </strong></p>
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
<!-- /.modal -->
<!-- Placed at the end of the document so the pages load faster -->

<script>
	window.jQuery || document.write('<script src="<?= base_url(); ?>assets/js/jquery/jquery-3.3.1.min.js">\x3C/script>')
</script>
<script>
 	$('#chat-start').click(() => {
    	$('#popup-start').toggleClass('animate-hide')
    	$('#popup-start').toggleClass('animate-show')
    })
	window.jQuery || document.write('<script src="<?= base_url(); ?>assets/js/jquery/jquery-3.3.1.min.js">\x3C/script>')

</script>
<script src="<?= base_url(); ?>assets/js/vendors.min.js"></script>
<script src="<?= base_url(); ?>assets/js/sweetalert2.all.min.js"></script>
<script src="<?= base_url(); ?>assets/js/jquery-1.11.3.min.js"></script>
<script src="<?= base_url(); ?>assets/js/bootstrap.js"></script>
<script type="text/javascript">
	base_url = "<?= base_url(); ?>";
	uri_js = "<?= $this->config->item('uri_js'); ?>";
</script>
<script src="<?= base_url(); ?>assets/js/aplikasi.js"></script>
<script>
</script>
</body>
<!-- Mirrored from templatecycle.com/demo/bootclassified-4.4/dist/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 03 Mar 2019 16:23:10 GMT -->

</html>

