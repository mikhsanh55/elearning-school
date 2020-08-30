<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?=$this->title;?></title>
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
            <a class="navbar-brand"><i class="fa fa-globe"></i>Hasil Penilaian</a>
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
                <div id="tampil_jawaban" class="text-center">
                    <?php $i = 1; foreach($soal as $data) : ?>
                        <button class="btn-widget" id="btn_widget_<?= $i; ?>" data-soal="<?= $data->id; ?>" data-no="<?= $i; ?>">
                            <?= $i; ?>
                        </button>
                    <?php $i++;endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <form role="form" name="_form" method="post" id="_form">
            <div class="panel panel-default">
                <div class="panel-heading">Soal Ke <div class="btn btn-info" id="soalke"></div>
                    <div class="tbl-kanan-soal">
                    <div onclick="return hide();" style="font-size: 18px;" class="btn btn-primary fa fa-eye"></div>
                    </div>
                </div>

                <div class="panel-body" style="overflow: auto">
                    <?php $i = 0;foreach($soal as $data) : 
                        $arrayUserAnswer = explode(':', $jawabanUser[$i]);
                        $idSoal = $arrayUserAnswer[0];
                        $userAnswer = $arrayUserAnswer[1];

                        $startI = ++$i;
                        $question = '';

                        // Pecah opsi
                        $chunkOptionA = explode('#####', $data->opsi_a);
                        $chunkOptionA = end($chunkOptionA);
                        $chunkOptionB = explode('#####', $data->opsi_b);
                        $chunkOptionB = end($chunkOptionB);
                        $chunkOptionC = explode('#####', $data->opsi_c);
                        $chunkOptionC = end($chunkOptionC);
                        $chunkOptionD = explode('#####', $data->opsi_d);
                        $chunkOptionD = end($chunkOptionD);
                        $chunkOptionE = explode('#####', $data->opsi_e);
                        $chunkOptionE = end($chunkOptionE);
                        
                        $allOptions = [
                            'a' => ['value' => $chunkOptionA], 
                            'b' => ['value' => $chunkOptionB], 
                            'c' => ['value' => $chunkOptionC], 
                            'd' => ['value' => $chunkOptionD], 
                            'e' => ['value' => $chunkOptionE]
                        ];

                        // Detemine the correct answer
                        foreach($allOptions as $key => $option) {

                            if(strtoupper($key) == $userAnswer) {
                                $allOptions[$key]['class'] = 'btn-success';
                            }
                            else {
                                $allOptions[$key]['class'] = '';
                            }
                        }

                    ?>
                        <section class="step widget" id="widget_<?= $startI; ?>">
                            <div style="display: flex;flex-flow: row wrap;">
                                <div class="">
                                    <?= $startI; ?>.
                                </div>
                                <div>
                                    <?= $data->soal; ?>
                                </div>
                            </div>
                            <br>
                            <?php $x = 1; foreach($allOptions as $option => $optionValue) { 
                            ?>
                            <div class="funkyradio">
                                <div class="">
                                    <input type="radio" id="opsi_<?= $data->id . '_' . $option; ?>" name="opsi_<?= $x++; ?>" value="<?= strtoupper($option); ?>" > 
                                    <label class="<?= $optionValue['class']; ?>" for="opsi_<?= $data->id . '_' . $option; ?>">
                                        <div class="huruf_opsi"><?= $option; ?></div> 
                                        <p><p><?= $optionValue['value']; ?></p></p><p></p>
                                    </label>
                                </div>
                            </div>
                            <?php } ?>
                        </section>
                    <?php endforeach; ?>
                </div>

                <div class="panel-footer text-center">
                    <a class="action back btn btn-info" rel="0"><i class="fa fa-step-backward"></i> Back</a>

                    <a class="action next btn btn-info" rel="2"><i class="fa fa-step-forward"></i> Next</a>

                    <!-- <a class="ragu_ragu btn btn-warning" rel="1" onclick="return tidak_jawab();">Ragu-ragu</a> -->
                    
                    <a class="selesai action submit btn btn-danger" href="<?= $backUrl; ?>" ><i class="fa fa-undo"></i> Kembali</a>
                </div>
            </div>
        </form>
    </div>

</div>

<div class="ajax-loading"><i class="fa fa-spin fa-spinner"></i> Loading ...</div>



<script src="<?php echo base_url(); ?>assets/js/jquery-1.11.3.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
<script src="<?php echo base_url(); ?>assets/plugin/countdown/jquery.countdownTimer.js"></script> 
<script src="<?php echo base_url(); ?>assets/plugin/jquery_zoom/jquery.zoom.min.js"></script>
<script>
    $(document).ready(function() {
        let activeWidget = '#widget_', 
            activeSoal = 1, 
            sumSoal = "<?= count($soal); ?>";
        
        $('.widget').css('display', 'none');
        $(activeWidget + activeSoal).css('display', 'block');
        $('#soalke').text(activeSoal);
        
        if(activeSoal == 1) {
            $('.back').css('display', 'none');
        }
        else {
            $('.back').css('display', 'inline');   
        }

        $('.next').on('click', function(e) {

            e.preventDefault();
            $('.widget').css('display', 'none');
            activeSoal = activeSoal + 1;
            $(activeWidget + activeSoal).css('display', 'block');
            $('#soalke').text(activeSoal);
            if(activeSoal == 1) {
                $('.back').css('display', 'none');
            }
            else if(activeSoal == sumSoal){
                $(this).css('display', 'none');   
                $('.back').css('display', 'inline');   
            }
            else {
                $('.back').css('display', 'inline');   
            }
        });

        $('.back').on('click', function(e) {
            e.preventDefault();
            $('.widget').css('display', 'none');
            activeSoal = activeSoal - 1;
            $(activeWidget + activeSoal).css('display', 'block');
            $('#soalke').text(activeSoal);
            if(activeSoal == 1) {
                $('.back').css('display', 'none');
                $('.next').css('display', 'inline');
            }
            else if(activeSoal >= sumSoal) {
                $('.back').css('display', 'inline');
                $('.next').css('display', 'none');
            }
            else {
                $('.back').css('display', 'inline');
                $('.next').css('display', 'inline');   
            }
        });

        $('.btn-widget').on('click', function(e) {
            e.preventDefault();
            let noSoal = $(this).data('no');
            $('.widget').css('display', 'none');
            activeSoal = noSoal;
            $(activeWidget + activeSoal).css('display', 'block');
            $('#soalke').text(activeSoal);
            // Bagian Button bawah
            if(activeSoal == 1) {
                $('.back').css('display', 'none');
                $('.next').css('display', 'inline');
            }
            else if(activeSoal >= sumSoal) {
                $('.back').css('display', 'inline');
                $('.next').css('display', 'none');
            }
            else {
                $('.back').css('display', 'inline');
                $('.next').css('display', 'inline');   
            }
        });
        $('.funkyradio').on('click', function(e) {
            e.preventDefault();
            return false;
        });
    });
</script>
</body>
</html>