<!DOCTYPE html>
<html lang="en" dir="ltr">
<!-- Mirrored from templatecycle.com/demo/bootclassified-4.4/dist/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 03 Mar 2019 16:23:10 GMT -->
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Fav and touch icons -->
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?= base_url(); ?>assets/ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?= base_url(); ?>assets/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?= base_url(); ?>assets/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" href="<?= base_url(); ?>assets/ico/apple-touch-icon-57-precomposed.png">
	<link rel="shortcut icon" href="<?=$this->logo;?>">
	<title><?=$this->title;?></title>
	<!-- Bootstrap core CSS -->
	<link href="<?= base_url(); ?>assets/bootstrap/css/bootstrap.css" rel="stylesheet">
	<link href="<?= base_url(); ?>assets/css/style.css" rel="stylesheet">
	<!-- styles needed for carousel slider -->
	<link href="<?= base_url(); ?>assets/plugins/owl-carousel/owl.carousel.css" rel="stylesheet">
	<link href="<?= base_url(); ?>assets/plugins/owl-carousel/owl.theme.css" rel="stylesheet">
	<!-- bxSlider CSS file -->
	<link href="<?= base_url(); ?>assets/plugins/bxslider/jquery.bxslider.css" rel="stylesheet" />
	<!-- Just for debugging purposes. -->
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
	<!-- include pace script for automatic web page progress bar  -->
	<script>
		paceOptions = {
			elements: true
		};
	</script>
	<script src="<?= base_url(); ?>assets/js/pace.min.js"></script>
	<script src="<?= base_url(); ?>assets/plugins/modernizr/modernizr-custom.js"></script>
	<style>
	.popup-chat {
      z-index: 99;
      box-shadow: 0 0 3px 1px #ccc;
      transition: visibility .5s, opacity .5s, margin-bottom .4s;
      position: fixed;
      right: 0;
      bottom: 60px;
      background: #fff;
    }
    .animate-hide {
      opacity: 0;
      visibility: hidden;
    }
    .chat-container {
      cursor:pointer;
      z-index: 99;
      position: fixed;
      right: 0;
      bottom: 0;
      background: #f7f7f7;
      box-shadow: 0 0 5px 1px #ccc;
      margin: 20px;
      padding: 10px 20px;
      border-radius: 30px;
    }
    .chat-container .label-section {
      cursor:pointer;
      align-self: center;
    }
    .chat-container .chat-img {
      cursor:pointer;
      width: 30px;
      height: 30px;
    }
    .capitalize {
      text-transform: capitalize;
    }
	</style>
</head>

<body>
