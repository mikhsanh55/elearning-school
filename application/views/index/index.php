<style>
.bg-image{
    background-image: url("assets/img/bg.jpg");
    
    background-repeat: no-repeat;
    -ms-background-size: cover;
    -o-background-size: cover;
    -moz-background-size: cover;
    -webkit-background-size: cover;
    background-size: cover;
    
}
</style>
<div id="wrapper">
    <div class="header">
            <nav class="navbar  fixed-top navbar-site navbar-light bg-light navbar-expand-md"
                 role="navigation">
                <div class="container">
                <div class="navbar-identity">
                    <a href="<?= base_url('awal'); ?>" class="navbar-brand logo logo-title">
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
                        <?php if($this->session->userdata('admin_konid') == NULL || $this->session->userdata('admin_konid') == '' ) { ?>
                             <!--<li class="postadd nav-item"><a class="btn btn-block   btn-border btn-post btn-danger nav-link" href="<?= base_url('register'); ?>">Daftar</a> -->
                             
                            </li>
                            <li class="postadd nav-item"><a class="btn btn-block btn-border btn-primary btn-gradient nav-link" href="<?= base_url('login'); ?>">Login</a>
                            </li>
                        <?php } else { ?>
                            <li class="postadd nav-item"><a class="btn btn-block btn-border btn-primary btn-gradient nav-link" href="<?= base_url('beranda'); ?>">Beranda</a>
                            </li>
                        <?php } ?>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    <!-- /.header -->


    <div class="intro bg-image">
        <div class="dtable hw100">
            <div class="dtable-cell hw100">
                <div class="container text-center" >
                    <h1 class="intro-title animated fadeInDown" style="text-shadow: 2px 2px #000;"> JALESVEVA JAYAMAHE</h1>
                    <p class="sub animateme fittext3 animated fadeIn" style="text-shadow: 2px 2px #000;">
                       <strong>Justru di Laut Kita Jaya</strong>
                    </p>
                    <div class="sub animateme fittext3 animated fadeInUp">
                            <!--<a href="<?= base_url('register'); ?>"><button class="btn btn-primary btn-search btn-block btn-gradient"><strong>Daftar Sekarang!</strong></button></a>-->
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.intro -->

    
    <!-- /.main-container -->

    <div class="page-info hasOverly" style="background-size:cover">
        <div class="bg-overly">
            <div class="container text-center section-promo">
                <div class="row">
                    <div class="col-sm-3 col-xs-6 col-xxs-12">
                        <div class="iconbox-wrap">
                            <div class="iconbox">
                                <div class="iconbox-wrap-icon">
                                    <i class="icon  icon-map"></i>
                                </div>
                                <div class="iconbox-wrap-content">
                                    <h5><span>DWI WARNA</span></h5>
                                </div>
                            </div>
                            <!-- /..iconbox -->
                        </div>
                        <!--/.iconbox-wrap-->
                    </div>

                    <div class="col-sm-3 col-xs-6 col-xxs-12">
                        <div class="iconbox-wrap">
                            <div class="iconbox">
                                <div class="iconbox-wrap-icon">
                                    <i class="icon  icon-map"></i>
                                </div>
                                <div class="iconbox-wrap-content">
                                    <h5><span>PURWA</span></h5>
                                </div>
                            </div>
                            <!-- /..iconbox -->
                        </div>
                        <!--/.iconbox-wrap-->
                    </div>

                    <div class="col-sm-3 col-xs-6  col-xxs-12">
                        <div class="iconbox-wrap">
                            <div class="iconbox">
                                <div class="iconbox-wrap-icon">
                                    <i class="icon  icon-map"></i>
                                </div>
                                <div class="iconbox-wrap-content">
                                    <h5><span>CENDEKIA</span></h5>
                                </div>
                            </div>
                            <!-- /..iconbox -->
                        </div>
                        <!--/.iconbox-wrap-->
                    </div>

                    <div class="col-sm-3 col-xs-6 col-xxs-12">
                        <div class="iconbox-wrap">
                            <div class="iconbox">
                                <div class="iconbox-wrap-icon">
                                    <i class="icon icon-map"></i>
                                </div>
                                <div class="iconbox-wrap-content">
                                    <h5><span>WUSANA</span></h5>
                                </div>
                            </div>
                            <!-- /..iconbox -->
                        </div>
                        <!--/.iconbox-wrap-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.page-info -->

    <div class="page-bottom-info">
        <div class="page-bottom-info-inner">
            <div class="page-bottom-info-content text-center">
                <h1></h1>
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
<!-- /.wrapper -->