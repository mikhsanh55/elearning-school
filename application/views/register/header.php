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
</head>

<body>
<div id="wrapper">
    <div class="header">
        	<nav class="navbar  fixed-top navbar-site navbar-light bg-light navbar-expand-md"
        		 role="navigation">
        		<div class="container">
                <div class="navbar-identity">
        			<a href="<?= base_url('awal'); ?>" class="navbar-brand logo logo-title">
        			<span class="logo-icon mr-3"><img src="<?= base_url('assets/img/rds.jpeg'); ?>" width="auto" height="40" /></span><?=$this->title;?></span> </a>
        			<button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggler pull-right"
    					type="button">
    				<svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 30 30" width="30" height="30" focusable="false"><title>Menu</title><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-miterlimit="10" d="M4 7h22M4 15h22M4 23h22"/></svg>
    			</button>
                </div>
        			<div class="navbar-collapse collapse">
        				<ul class="nav navbar-nav navbar-left">
        					<li class="flag-menu country-flag tooltipHere hidden-xs nav-item" data-toggle="tooltip"
        						data-placement="bottom" title="Select Country">
        					</li>
        				</ul>
        				<ul class="nav navbar-nav ml-auto navbar-right">
        					<li class="postadd nav-item"><a class="btn btn-block btn-border btn-primary btn-gradient nav-link" href="<?= base_url('login'); ?>">Login</a>
        					</li>
        				</ul>
        			</div>
        		</div>
        	</nav>
        </div>
    <!-- /.header -->
