<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Ujian Siswa</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<link href="<?= base_url(); ?>assets/ujian/css/bootstrap.css" rel="stylesheet">
<link href="<?= base_url(); ?>assets/ujian/css/style.css?<?php echo time(); ?>" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

<style type="text/css">
    .no-js #loader { display: none;  }
    .js #loader { display: block; position: absolute; left: 100px; top: 0; }
    .se-pre-con {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url(<?php echo base_url('assets/img/facebook.gif'); ?>) center no-repeat #fff;
    }

    .ajax-loading {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: #6f6464;
        opacity: 0.75;
        color: #fff;
        text-align: center;
        font-size: 25px;
        padding-top: 200px;
        display: none;
    }
</style>
</head>
<body>
<!-- <div class="se-pre-con"></div> -->

<nav class="navbar navbar-findcond navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand"><i class="fa fa-globe"></i> Tes Online</a>
        </div>

        <div class="collapse navbar-collapse" id="navbar">
            <ul class="nav navbar-nav navbar-right" style="z-index: 1000">
                <li><a class="#" onclick="return simpan_akhir();"><i class="fa fa-ban"></i> Selesai Ujian</a></li>
            </ul>
        </div>
    </div>
</nav>


<div class="floating container">
    <a id="tbl_show_jawaban" href="#" onclick="return show_jawaban()" class="btn btn-info" title="Tampilkan bilah jawaban"><i class="fa fa-search"></i> Lihat Soal</a>
</div>

<div class="dmobile">
    <div class="col-md-3" id="v_jawaban">
        <div class="panel panel-default">
            <div class="panel-heading" id="nav_soal" style="overflow: auto">
                <div class="btn btn-default col-md-12"><i class="fa fa-search"></i> Navigasi Soal</div>
            </div>
            <div class="panel-body" style="overflow: auto;  height: 450px; padding: 10px">
                <div id="tampil_jawaban" class="text-center"></div>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <form role="form" name="_form" method="post" id="_form">
            <div class="panel panel-default">
                <div class="panel-heading">Soal Ke <div class="btn btn-info" id="soalke"></div>
        
                    <div class="tbl-kanan-soal">
                        <div id="clock" style="font-weight: bold" class="btn btn-danger"></div>
                    </div>
                    <div class="tbl-kanan-soal">
                    <div onclick="return hide();" style="font-size: 18px;" class="btn btn-primary fa fa-eye"></div>
                    </div>
                </div>

                <div class="panel-body" style="overflow: auto">

                <!-- Print Soal -->
                <?php $i = 1; foreach($soalUjian as $soal) : 
                ?>
                    <input type="hidden" name="id_soal_<?= $i; ?>" value="<?= $soal->id; ?>">
                    <input type="hidden" name="ragu_<?= $i; ?>" value="N">

                    <!-- Print per Page/Widget -->
                    <div class="step" id="widget_<?= $i; ?>" data-id="<?= $soal->id; ?>" data-no="<?= $i; ?>">
                        <p><?= $soal->soal; ?></p>
                        <br>
                        <div class="funkyradio">
                            <!-- Print Option -->
                            <?php for($j = 0;$j < count($hurufOpsi); $j++) { 
                                $opsinya = 'opsi_' . $hurufOpsi[$j];
                                $jawabanOpsi = $soal->$opsinya;
                            ?>
                                <div class="funkyradio-success" onclick="saveSatuSoal(this, event)">
                                    <input type="radio" name="opsi_<?= $hurufOpsi[$j]; ?>" value="<?= strtoupper($hurufOpsi[$j]); ?>" id="opsi_<?= $hurufOpsi[$j]; ?>">
                                    <label for="opsi_<?= $hurufOpsi[$j]; ?>">
                                        <!-- Print Abjad -->
                                        <div class="huruf_opsi">
                                            <?= $hurufOpsi[$j] . '. '; ?>
                                        </div>
                                        <!-- Print opsi -->
                                        <p>
                                            <?= !empty($jawabanOpsi) ? $jawabanOpsi : '-'; ?>
                                        </p>
                                    </label>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php $i++; endforeach; ?>
                </div>

                <div class="panel-footer text-center">
                    <a class="action back btn btn-info" rel="0" onclick="return back();"><i class="fa fa-step-backward"></i> Back</a>

                    <a class="action next btn btn-info" rel="2" onclick="return next();"><i class="fa fa-step-forward"></i> Next</a>

                    <!-- <a class="ragu_ragu btn btn-warning" rel="1" onclick="return tidak_jawab();">Ragu-ragu</a> -->
                    
                    <a class="selesai action submit btn btn-danger" onclick="return simpan_akhir();"><i class="fa fa-ban"></i> Selesai</a>

                    <!-- <input type="hidden" name="jml_soal" id="jml_soal" value="<?php echo $no; ?>">
                    <?php $uri5 = $this->uri->segment(5); ?>
                    <input type="hidden" name="url3" id="url3" value="<?php echo $uri5; ?>"> -->
                </div>
            </div>
        </form>
    </div>

</div>

<!-- <div class="ajax-loading"><i class="fa fa-spin fa-spinner"></i> Loading ...</div> -->
<!-- Modal for zoomed image -->
<div class="modal fade" id="sliderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="background: transparent;border:none;">
      <div class="modal-body" style="background: transparent;padding: 0;">
        
      </div>
    </div>
  </div>
</div>


<script src="<?php echo base_url(); ?>assets/js/jquery-1.11.3.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
<script src="<?php echo base_url(); ?>assets/plugin/countdown/jquery.countdownTimer.js"></script> 
<script src="<?php echo base_url(); ?>assets/plugin/jquery_zoom/jquery.zoom.min.js"></script>

<script type="text/javascript">
    let base_url = "<?php echo base_url(); ?>",
        currentSoal = 1;

    // Set label soal ke to currentSoal var
    $('#soalke').text(currentSoal);

    // Hide all page except currentSoal
    $('.step').hide();
    $(`#widget_${currentSoal}`).show();
    
    $(window).load(function() {
        $(".se-pre-con").fadeOut("slow");
    });

    // Function for set timer ujian
    function initTimer()
    {

    }

    </script>
</body>
</html>