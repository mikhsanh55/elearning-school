<!--<div class="se-pre-con"></div>-->
<div class="theme-layout">
	<div class="postoverlay"></div>
	<div class="responsive-header">
		<div class="mh-head first Sticky">
			<span class="mh-btns-left">
				<a class="" href="#menu"><i class="fa fa-align-justify"></i></a>
			</span>
			<span class="mh-text">
				<a href="#" title=""><img src="images/logo2.png" alt=""></a>
			</span>
		</div>
		<div class="mh-head second">
			<form class="mh-form">
				<input placeholder="search" />
				<a href="#/" class="fa fa-search"></a>
			</form>
		</div>
		<nav id="menu" class="res-menu">
			<ul>
				<li><a href="#" title="">Beranda</a></li>
				<li><a href="http://192.168.0.11/halamansiswa/modul.html" title="">Modul</a></li>
				<li><a href="#" title="">Jadwal</a></li>
				<li><a href="#" title="">Ujian</a></li>
				<li><a href="#" title="">Pengajar</a></li>
			</ul>
		</nav>
		
	</div> <!-- responsive header -->
	
	<div class="topbar stick">
		<div class="logo">
			<a title="" href="#"><img src="images/logo.png" alt=""></a>
		</div>
		
		<div class="top-area">
			<ul class="main-menu">
				<?php foreach($this->menu as $row) : ?>
					
					<?php if ($this->active_menu == $row['id']){ ?>
						<li><a class="active" href="<?= base_url($row['link']); ?>"><i class="<?= $row['icon'] ?>"></i><?= $row['nama_menu'] ?></a></li>
					<?php }else { ?>
						<li><a href="<?= base_url($row['link']); ?>"><i class="<?= $row['icon'] ?>"></i><?= $row['nama_menu'] ?></a></li>
					<?php } ?>
				<?php endforeach; ?>
				<!-- <li>
					<a href="http://192.168.0.11/halamansiswa/modul.html">Modul</a>
				</li>
				<li>
					<a href="http://192.168.0.11/halamansiswa/tugas.html" title="">Tugas</a>
				</li>
				<li>
					<a href="#" title="">Jadwal</a>
				</li>
				<li>
					<a href="">Ujian</a>
				</li>
				<li>
					<a href="">Pengajar</a>
				</li> -->
				
			</ul>

			<ul class="setting-area">
				<li><a href="#" title="Home" data-ripple=""><i class="ti-home"></i></a></li>
				<li>
					<a href="#" title="Notification" data-ripple="" >
						<i class="ti-bell"></i> <span class="badge badge-danger" style="color:white"> 3</span>
					</a>
					<div class="dropdowns">
						<span>2 New Notifications</span>
						<ul class="drops-menu">
							<li>
								<a href="notifications.html" title="">
									<img src="images/resources/thumb-1.jpg" alt="">
									<div class="mesg-meta">
										<h6>sarah Loren</h6>
										<span>Hi, how r u dear ...?</span>
										<i>2 min ago</i>
									</div>
								</a>
								<span class="tag green">New</span>
							</li>
							<li>
								<a href="notifications.html" title="">
									<img src="images/resources/thumb-5.jpg" alt="">
									<div class="mesg-meta">
										<h6>Amy</h6>
										<span>Hi, how r u dear ...?</span>
										<i>2 min ago</i>
									</div>
								</a>
								<span class="tag">New</span>
							</li>
						</ul>
						<a href="notifications.html" title="" class="more-mesg">view more</a>
						<li>
					<a href="#" title="Messages" data-ripple=""><i class="ti-comment"></i><span class="badge badge-danger" style="color:white">12</span></a>
					<div class="dropdowns">
						<span>5 New Messages</span>
						<ul class="drops-menu">
							<li>
								<a href="notifications.html" title="">
									<img src="images/resources/thumb-1.jpg" alt="">
									<div class="mesg-meta">
										<h6>sarah Loren</h6>
										<span>Hi, how r u dear ...?</span>
										<i>2 min ago</i>
									</div>
								</a>
								<span class="tag green">New</span>
							</li>
							<li>
								<a href="notifications.html" title="">
									<img src="images/resources/thumb-2.jpg" alt="">
									<div class="mesg-meta">
										<h6>Jhon doe</h6>
										<span>Hi, how r u dear ...?</span>
										<i>2 min ago</i>
									</div>
								</a>
								<span class="tag red">Reply</span>
							</li>
							<li>
								<a href="notifications.html" title="">
									<img src="images/resources/thumb-3.jpg" alt="">
									<div class="mesg-meta">
										<h6>Andrew</h6>
										<span>Hi, how r u dear ...?</span>
										<i>2 min ago</i>
									</div>
								</a>
								<span class="tag blue">Unseen</span>
							</li>

							<li>
								<a href="notifications.html" title="">
									<img src="images/resources/thumb-4.jpg" alt="">
									<div class="mesg-meta">
										<h6>Tom cruse</h6>
										<span>Hi, how r u dear ...?</span>
										<i>2 min ago</i>
									</div>
								</a>
								<span class="tag">New</span>
							</li>
							<li>
								<a href="notifications.html" title="">
									<img src="images/resources/thumb-5.jpg" alt="">
									<div class="mesg-meta">
										<h6>Amy</h6>
										<span>Hi, how r u dear ...?</span>
										<i>2 min ago</i>
									</div>
								</a>
								<span class="tag">New</span>
							</li>
					</div>

				</li>

			</ul>
			<div class="user-img">
				<img src="images/resources/admin.jpg" alt="">
				<span class="status f-online"></span>
				<div class="user-setting">
					<a href="#" title=""><i class="ti-user"></i> Profile</a>
					<a href="#" title=""><i class="ti-pencil-alt"></i>Ubah Password</a>
					<a href="#" title=""><i class="ti-power-off"></i>log out</a>
				</div>
			</div>
		</div>
	</div><!-- topbar -->

	<!-- banner -->
		<section>
		<div class="gap1 color-bg">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="top-banner">
							<h1><?=$this->page_title ;?></h1>
							<nav class="breadcrumb">
							  <a class="breadcrumb-item" href="index.html">Home</a>
							  <span class="breadcrumb-item active"><?=$this->page_title ;?></span>
							</nav>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section><!-- banner -->

	<section>
		<div class="gap gray-bg">