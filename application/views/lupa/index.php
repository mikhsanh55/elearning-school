	<div id="wrapper">

		<div class="header">
			<nav class="navbar  fixed-top navbar-site navbar-light bg-light navbar-expand-md" role="navigation">
				<div class="container">

					<div class="navbar-identity">


						<a href="<?= base_url('awal'); ?>" class="navbar-brand logo logo-title">
						<span class="logo-icon mr-3"><img src="<?=$this->logo;?>" width="auto" height="40" /></span><?=$this->title;?></span> </a>
					</div>



					<div class="navbar-collapse collapse">
						<ul class="nav navbar-nav navbar-left">
							<li class="flag-menu country-flag tooltipHere hidden-xs nav-item" data-toggle="tooltip" data-placement="bottom" title="Select Country">
							</li>
						</ul>
						<ul class="nav navbar-nav ml-auto navbar-right">
						</ul>
					</div>
				</div>
			</nav>
		</div>



		<div class="main-container">
			<div class="container">
				<div class="row">
					<div class="col-sm-5 login-box">
						<div class="card card-default">
							<div class="panel-intro text-center">
								<h2 class="logo-title">
									<!-- Original Logo will be placed here  -->
									
									<span pan class="logo-icon"><!--<i class="icon icon-search-1 ln-shadow-logo shape-0"></i>--></span> Reset Password<span>  </span>
								</h2>
							</div>

							<div class="card-body">
								<?php
								$pesan = $this->session->flashdata('pesan');
								if (isset($pesan)) { ?>
									<h4><?php echo $this->session->flashdata('pesan'); ?></h4>
								<?php }
								?>
								<form role="form" method="post" action="<?= base_url('lupa_password/resetlink'); ?>">
									<div class="form-group">
										<label for="email" class="control-label">Email:</label>

										<div class="input-icon"><i class="icon-user fa"></i>
											<input id="email" name="email" type="email" placeholder="Email" class="form-control email">
										</div>
									</div>
									<div class="form-group">
										<button type="submit" class="btn btn-primary btn-lg btn-block">Reset Password
										</button>
									</div>
								</form>
							</div>
							<div class="card-footer">
								<p class="text-center "><a href="<?= base_url('login'); ?>"> Back to Login </a></p>

								<div style=" clear:both"></div>
							</div>
						</div>
				<!-- 		<div class="login-box-btm text-center">
							<p> Don't have an account? <br>
								<a href="<?= base_url('register'); ?>"><strong>Sign Up !</strong> </a></p>
						</div> -->
					</div>
				</div>
			</div>
		</div>




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
	</div>
	<script src="../../../../cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script>
		window.jQuery || document.write('<script src="<?= base_url(); ?>assets/js/jquery/jquery-3.3.1.min.js">\x3C/script>')
	</script>
	<script src="<?= base_url(); ?>assets/js/vendors.min.js"></script>
	<script src="<?= base_url(); ?>assets/js/main.min.js"></script>
