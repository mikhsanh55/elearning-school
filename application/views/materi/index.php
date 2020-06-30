<style>
.trainer-photo {
    width:40px;
    height:40px;
    border-radius:50%;
}
.title {
    font-size:18px;
    font-weight:500;
    color:#00b894;
    padding-bottom:0;
    margin-left:-20px;
    margin-top:-7px;
}
.title + small {
    position:absolute;
    color:#888;
    padding:0;
    top:50px;
    margin-bottom:0;
    margin-left:-20px;
    margin-top:-30px;
}
.cover-image-blog {
    height:400px;
    width:100%;
}
.content {
    
}
</style>
<div id="wrapper">
	<div class="header">
		<nav class="navbar  fixed-top navbar-site navbar-light bg-light navbar-expand-md" role="navigation">
			<div class="container">
				<div class="navbar-identity">
					<a href="index.html" class="navbar-brand logo logo-title">
					<span class="logo-icon"><i class="icon icon-search-1 ln-shadow-logo "></i></span><?=$this->title;?></span> </a>
				</div>
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav navbar-left">
						<li class="flag-menu country-flag tooltipHere hidden-xs nav-item" data-toggle="tooltip" data-placement="bottom" title="Select Country">
						</li>
					</ul>
					<ul class="nav navbar-nav ml-auto navbar-right">
						<li class="dropdown no-arrow nav-item"><a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
						<li class="postadd nav-item"><a class="btn btn-block btn-border btn-post btn-danger1 nav-link" href="<?= base_url('auth/logout'); ?>">Log Out</a>
						</li>
					</ul>
				</div>
				<!--/.nav-collapse -->
			</div>
			<!-- /.container-fluid -->
		</nav>
	</div>

    <div class="main-container">
        <div class="container">
            <section class="inner-box">
            <div class="row" style="padding:25px;">
                <div class="col-sm-1">
                    <img src="<?= base_url('assets/ico/apple-touch-icon-57-precomposed.png'); ?>" alt="logo-trainer" class="trainer-photo">
                </div>
                <div class="col-sm-8">
                    <p class="title"><?= $content->title; ?></p>
                    <small><?= $content->updated_date; ?></small>
                </div>
                <div class="col-sm-3">
                    <p style="color:red;">Materi belum diverifikasi</p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm image-cover"></div>
            </div>
            <main class="container content mt-4">
                <?= $content->content; ?>
            </main>
            </section>
        </div>
    </div>
</div>
<script>
    const coverImage = document.createElement('img');
    const placeCoverImage = document.querySelector('.image-cover');
    coverImage.classList.add('cover-image-blog');
    coverImage.setAttribute('src', "<?= base_url('assets/img/cover-blog1.jpg'); ?>");
    placeCoverImage.appendChild(coverImage);
</script>