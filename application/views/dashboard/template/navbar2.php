
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

                        <span><i class="icon-user fa"></i>
                                <?php if($this->session->userdata('admin_level') == "admin"){
                                    echo "Admin";
                               }else if($this->session->userdata('admin_level') == "guru"){
                                  echo "Pengajar";
                              }else if($this->session->userdata('admin_level') == "siswa"){
                                 echo "Siswa";
                             }else if($this->session->userdata('admin_level') == "instansi"){
                                 echo "Lembaga";
                             }?>
                                 <?php echo "(".$this->akun->nama." - ".$this->akun->nrp.")"; ?></span>  <i class=" icon-down-open-big fa"></i></a>
                            <ul class="dropdown-menu user-menu dropdown-menu-right">

                                <li class="dropdown-item"><a href="#" onclick="return rubah_password();"><i class="icon-key"></i> Ubah Password </a>
                                </li>

                                <li class="dropdown-item"><a href="<?php echo base_url(); ?>login/logout" onclick="return confirm('Keluar ?');"> <i class=" icon-logout "></i> Log out </a>
                                </li>
                            </ul>
                        </li>
                    </ul>  
                    </div>
                    <?php if ($this->log_lvl == 'siswa' || $this->log_lvl == 'guru'): ?>
                        
                        
                        
                        <ul class="nav nav-pills mr-auto justify-content-end">

                            
                            <li class="nav-item dropdown">

                                <a class="nav-link text-blue" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="far fa-comments fa-2x"></i><span class="badge badge-danger notif-number"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-custom scrollable-menu" role="menu">
                                    <li class="head text-white bg-dark">
                                        <div class="row">
                                            <div class="col-lg-12 col-sm-12 col-12">
                                                <span>Notifikasi <span class="notif-number"></span></span>
                                                <a href="javascript:void(0);" class="float-right text-light see_all" id="all_see">Tandai semua telah dibaca</a>
                                            </div>
                                        </li>
                                        <div id="notif-list"></div>



                                        <li class="footer bg-dark text-center">
                                            <a href="" class="text-light">Lihat Semua</a>
                                        </li>
                                    </ul>

                                </li>
                            </ul>

                        <?php endif ?>
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
                                            <?php foreach($this->menu as $row) : ?>
        
                                            <?php if ($this->active_menu == $row['id']){ ?>
                                            <li><a class="active" href="<?= base_url($row['link']); ?>"><i class="<?= $row['icon'] ?>"></i><?= $row['nama_menu'] ?></a></li>
                                            <?php }else { ?>
                                                <li><a href="<?= base_url($row['link']); ?>"><i class="<?= $row['icon'] ?>"></i><?= $row['nama_menu'] ?></a></li>
                                            <?php } ?>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                                <!-- /.collapse-box  -->
                            </div>
                        </div>
                        <!-- /.inner-box  -->
