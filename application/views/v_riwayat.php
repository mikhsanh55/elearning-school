<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Hasil Ujian</title>
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
        left: 30%;
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
    body{
        font-family: arial !important;
    }
</style>
</head>
<body>
<div class="se-pre-con"></div>

<nav class="navbar navbar-findcond navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand"><i class="fa fa-globe"></i> Tes Kemampuan</a>
        </div>

        <div class="collapse navbar-collapse" id="navbar">
            <ul class="nav navbar-nav navbar-right" style="z-index: 1000">
                <li><a class="#" onclick="return balik();"><i class="fa fa-ban"></i> Kembali</a></li>
            </ul>
        </div>

    </div>
</nav>
<div class="container" style="margin-top: 50px;">
    <div class="col-md-12">
        <div class="panel panel-warning">
          <div class="panel-heading"><h4 style="text-align: center;"><strong>Hasil Tes Jawaban</strong> (<span style="color: #86c186;">Benar</span>/<span style="color: #EC3A3A;">Salah</span>)</h4></div>
          <div class="panel-body">

              <form role="form" name="_form" method="post" id="_form">
                <?php echo $html; ?>

            </form>
        </div>
    </div>
</div>
</div>

</div>

<div class="ajax-loading"><i class="fa fa-spin fa-spinner"></i> Loading ...</div>

<script src="<?php echo base_url(); ?>assets/js/jquery-1.11.3.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
<script src="<?php echo base_url(); ?>assets/plugin/countdown/jquery.countdownTimer.js"></script> 
<script src="<?php echo base_url(); ?>assets/plugin/jquery_zoom/jquery.zoom.min.js"></script>

<script type="text/javascript">

    var base_url = "<?php echo base_url(); ?>";
    id_tes = "<?php echo $id_tes; ?>";
    $(window).load(function() {
        $(".se-pre-con").fadeOut("slow");
    });

    function getFormData($form){
        var unindexed_array = $form.serializeArray();
        var indexed_array = {};
        $.map(unindexed_array, function(n, i){
            indexed_array[n['name']] = n['value'];
        });
        return indexed_array;
    }

    //jawaban dan nomer ujian
    simpan_sementara = function() {
        var f_asal  = $("#_form");
        var form  = getFormData(f_asal);
        //form = JSON.stringify(form);
        var jml_soal = form.jml_soal;
        jml_soal = parseInt(jml_soal);

        var hasil_jawaban = "";

        $("#tampil_jawaban").html('<div id="yes"></div>'+hasil_jawaban);
    }

    balik = function() {
    window.location.assign("<?php echo base_url(); ?>ujian/sudah_selesai_ujian/"+id_tes); 
    }

    show_jawaban = function() {
        $("#v_jawaban").toggle();
    }
    </script>
</body>
</html>