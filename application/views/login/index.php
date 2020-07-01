<style type="text/css">
	body{
		 /* The image used */
		  background-image: url("assets/img/bg.jpg");
		     content: ' ';
    display: block;
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
 
  
    background-repeat: no-repeat;
    background-position: 50% 0;
    -ms-background-size: cover;
    -o-background-size: cover;
    -moz-background-size: cover;
    -webkit-background-size: cover;
    background-size: cover;
}
	}

</style>
<div id="wrapper" class="bg-image">
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

					<!-- <ul class="nav navbar-nav ml-auto navbar-right">
						<li class="dropdown no-arrow nav-item">
							<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
						<li class="postadd nav-item"><a class="btn btn-block   btn-border btn-post btn-danger nav-link" href="post-ads.html">Daftar</a>
						</li>
						<li class="postadd nav-item"><a class="btn btn-block btn-border btn-post btn-danger1 nav-link" href="post-ads.html">Login</a>
						</li>
					</ul> -->
				</div>
				<!--/.nav-collapse -->
			</div>
			<!-- /.container-fluid -->
		</nav>
	</div>
	<!-- /.header -->
	<div class="main-container " >
		<div class="container">
			<div class="row">
				<div class="col-sm-5 login-box">
					<div class="card card-default">
						<div class="panel-intro text-center">
							<h1>Login</h1>
						</div>
						<div id="konfirmasi"></div>
						<div class="card-body">
							<form role="form" method="post" name="fl" id="f_login" onsubmit="return login();">
								<div class=" form-group">
									<label for="sender-email" class="control-label">Username:</label>
									<div class="input-icon"><i class="icon-user fa"></i>
										<input id="username" name="username" type="text" class="form-control" placeholder="Username">
									</div>
								</div>
								<div class=" form-group">
									<label for="user-pass" class="control-label">Password:</label>

									<div class="input-icon"><i class="icon-lock fa"></i>
										<input type="password" id="password" name="password" class="form-control" placeholder="Password">
									</div>
								</div>
								<div class="login-actions">
									<!-- <input type="submit" name="submit" value="MASUK" class="btn btn-primary  btn-block"> -->
									<button class="btn btn-primary  btn-block" type="submit">MASUK
									</button>
									<button class="btn btn-danger  btn-block" type="button" onclick="return window.location = '<?=base_url('lupa_password');?>' ">Lupa Password
									</button>
									<!-- <div class="">
										<button class="button btn btn-dafault btn-large col-lg-12 top15">Login</button>
									</div> -->
								</div>
							</form>
						</div>
						<div class="card-footer">
							<div class="text-center">
								<label class="custom-control mb-2 mr-sm-2 mb-sm-0">
									<span class="custom-control-indicator"></span>
									<p><a href="lupa_password" class="text-center color-btn"></a>
									</p>
								</label>
							</div>
							<div style=" clear:both"></div>
						</div>
					</div>
					<!-- <div class="login-box-btm text-center">
						<p> Belum punya akun ? <br>
							<a href="<?= base_url('register'); ?>" class="text-center color-btn"><strong>Segera daftar</strong> </a></p>
					</div> -->
				</div>
			</div>
		</div> 
	</div>
</div>
