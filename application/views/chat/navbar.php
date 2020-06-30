<div id="wrapper">
    <div class="header">
        	<nav class="navbar  fixed-top navbar-site navbar-light bg-light navbar-expand-md"
        		 role="navigation">
        		<div class="container">
                <div class="navbar-identity">
        			<a href="<?= base_url('adm'); ?>" class="navbar-brand logo logo-title">
        			<span class="logo-icon mr-3"><img src="<?= base_url('assets/img/rds.jpeg'); ?>" width="70" height="40" /></span>E-Learning PT.RDS</span> </a>
        			<button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggler pull-right"
    					type="button">
    				<svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 30 30" width="30" height="30" focusable="false"><title>Menus</title><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-miterlimit="10" d="M4 7h22M4 15h22M4 23h22"/></svg>
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
    <!-- /.header -->
	<div class="main-container">
		<div class="container">
			<div class="row">
				<div class="col-md-3 page-sidebar">
					<aside>
						<div class="inner-box">
							<div class="user-panel-sidebar">
								<div class="collapse-box">
									<h5 class="collapse-title no-border"> Menu <a href="#MyClassified" aria-expanded="true" data-toggle="collapse" class="pull-right"><i class="fa fa-angle-down"></i></a></h5>

									<div class="panel-collapse collapse show" id="MyClassified">

										<ul class="acc-list">
                                        <?php foreach($link as $a) : ?>
                                            <?php foreach($menu as $row) : ?>
											<?php if ($a['link4'] == $row['link4']){ ?>
											<li><a class="active" href="<?= base_url($row['link']); ?>"><i class="<?= $row['icon'] ?>"></i><?= $row['nama_menu'] ?></a></li>
                                            <?php }else { ?>
                                                <li><a href="<?= base_url($row['link']); ?>"><i class="<?= $row['icon'] ?>"></i><?= $row['nama_menu'] ?></a></li>
                                            <?php } ?>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
										</ul>
									</div>
								</div>
								<!-- /.collapse-box  -->
							</div>
						</div>
						<!-- /.inner-box  -->
