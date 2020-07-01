<!DOCTYPE html>
<html lang="en" dir="ltr">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Fav and touch icons -->
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?= base_url(); ?>assets/ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?= base_url(); ?>assets/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?= base_url(); ?>assets/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" href="<?= base_url(); ?>assets/ico/apple-touch-icon-57-precomposed.png">
	<link rel="shortcut icon" href="<?= base_url(); ?>assets/ico/favicon.ico">
	<title><?=$this->title;?></title>
	<!-- Bootstrap core CSS -->
	<link href="<?= base_url(); ?>assets/bootstrap/css/bootstrap.css" rel="stylesheet">
	<link href="<?= base_url(); ?>assets/css/style.css" rel="stylesheet">
	<style type="text/css">
		.fa-ban:hover {
			cursor: not-allowed;
		}
		.modal-content {
			margin: 0 auto;
        	display: block;
		}
	</style>
	 <script src="https://use.typekit.net/hoy3lrg.js"></script>
    <script>try{Typekit.load({ async: true });}catch(e){}</script>
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css'>
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.min.css'>
    
	<!-- styles needed for carousel slider -->
	<link href="<?= base_url(); ?>assets/plugins/owl-carousel/owl.carousel.css" rel="stylesheet">
	<link href="<?= base_url(); ?>assets/plugins/owl-carousel/owl.theme.css" rel="stylesheet">
	<link class="cp-pen-styles" href="<?= base_url(); ?>assets/css/chat/chat.css" rel="stylesheet" />
	<!-- bxSlider CSS file -->
	<link href="<?= base_url(); ?>assets/plugins/bxslider/jquery.bxslider.css" rel="stylesheet" />
	<!-- Just for debugging purposes. -->
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
   <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
   <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
   <![endif]-->
   
   <!-- Video JS -->
   <link href="//vjs.zencdn.net/7.3.0/video-js.min.css" rel="stylesheet">
    <script src="//vjs.zencdn.net/7.3.0/video.min.js"></script>
	<script>
		const createSess = {
			setItem:function(key, value) {
				return Promise.resolve().then(function() {
					sessionStorage.setItem(key, value);
				});
			}
		}
		
		function saveSess(el) {
			let mapel = el.getAttribute('data-mapel'),
			url = el.getAttribute('data-href');
			createSess.setItem('mapel', mapel, url).then(function() {
				window.location = url;
			});
		}
		
		// For Hit modul
		function hit(el) {
			let hitToken = el.getAttribute('data-href'),
			mapel = el.getAttribute('data-mapel');
			sessionStorage.setItem('mapel', mapel);
			$.ajax({
				type:"POST",
				url:"<?= base_url('laporan/push_data') ?>",
				data:{mapel:mapel},
				dataType:"JSON",
				success:function(res) {
					if(res.status == true) {
						window.location.href = hitToken;
					}
					else {
						window.location.href = hitToken;		
					}
				}
			});
		}
		paceOptions = {
			elements: true
		};
	</script>
	<script src="<?= base_url(); ?>assets/js/pace.min.js"></script>
	<script src="<?= base_url(); ?>assets/plugins/modernizr/modernizr-custom.js"></script>
	<link href="<?= base_url(); ?>assets/plugin/fa/css/font-awesome.min.css" rel="stylesheet">
	<link href="<?= base_url(); ?>assets/plugin/datatables/dataTables.bootstrap.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>
