
	<style type="text/css">
		@media screen and (min-width: 992px) {
			#article header {
				margin-top:50px;
			}
			#article h1 {
				font-size:50px !important;
				margin:auto;
				width: 80%;margin-top: 20px;
			}	
			#article .lead {
				font-size: 20px !important;
				word-spacing: 5px;
				width:80%;
				margin:auto;
			}
			#article ul, ol {
				margin: auto;
				width: 80%;
			}
		}
		
		@media screen and (max-width: 576px) {
			#article .container {
				margin :0 !important;
				padding: 0 !important;
			}
			#article .lead {
				font-size: 12px !important;
				word-spacing: 5px;
				/*text-align: justify;*/
			}
			#article h1 {
				margin-top: 50px;
				font-size:30px !important;
				word-spacing: 3px;			
				line-height: 100%;
			}
			#article header {
				margin-top:40px;
			}
		}
		@media screen and (min-width: 768px ) {
			#article .container {
				margin :0 !important;
				padding: 0 !important;
			}
			#article .lead {
				font-size: 20px !important;
				word-spacing: 5px;
			}
			#article h1 {
				margin-top: 60px;
				font-size:45px !important;
				word-spacing: 3px;			
				line-height: 100%;
			}
			#article header {
				margin-top:40px;
			}	
		}
	</style>

<div id="wrapper">
    <div class="header">
        	<nav class="navbar  fixed-top navbar-site navbar-light bg-light navbar-expand-md"
        		 role="navigation">
        		<div class="container">
                <div class="navbar-identity">
        			<a href="<?= base_url('adm'); ?>" class="navbar-brand logo logo-title">
        			<span class="logo-icon mr-3"><img src="<?=$this->logo;?>" width="auto" height="40" /></span><?=$this->title;?></span> </a>
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
						<li class="dropdown no-arrow nav-item"><a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">

								<span><?php echo $this->session->userdata('admin_nama')."(".$this->session->userdata('admin_user').")"; ?></span> <i class="icon-user fa"></i> <i class=" icon-down-open-big fa"></i></a>
							<ul class="dropdown-menu user-menu dropdown-menu-right">

								<li class="dropdown-item"><a href="#" onclick="return rubah_password();"><i class="icon-th-thumb"></i> Ubah Password </a>
								</li>

								<li class="dropdown-item"><a href="<?php echo base_url(); ?>login/logout" onclick="return confirm('Keluar ?');"> <i class=" icon-logout "></i> Log out </a>
								</li>
							</ul>
						</li>
					</ul>  
        			</div>
        		</div>
        	</nav>
        </div>
    </div>
	<br>
	<main id="article">
		<div class="container">
			<br>
		<header class="mt-4 w-75 mx-auto" id="heading"><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<h1 class="text-dark"><?= $materi->title; ?></h1>
		</header>
		<br>
		<main class="mt-4">
			<?= $materi->content; ?>
		</main>
		</div>
	</main>
	<br><br><br><br><br><br>
	<footer class="main-footer">
		<div class="footer-content">
			<div class="container">
				<div class="row">


					<div style="clear: both"></div>

					<div class="col-xl-12">

						<div class="copy-info text-center">
							<?=$this->footer;?>
						</div>

					</div>

				</div>
			</div>
		</div>
	</footer>