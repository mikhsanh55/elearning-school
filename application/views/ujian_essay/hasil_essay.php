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
            <a class="navbar-brand"><i class="fa fa-globe"></i> Jawaban Essay</a>
        </div>

        <div class="collapse navbar-collapse" id="navbar">
            <ul class="nav navbar-nav navbar-right" style="z-index: 1000">
                <li><a href="<?=base_url('ujian_essay/result/'.encrypt_url($id_ujian));?>"><i class="fa fa-ban"></i> Kembali</a></li>
            </ul>
        </div>

    </div>
</nav>
<div class="container" style="margin-top: 50px;">
    <div class="col-md-12">
        <div class="panel panel-warning">
          <div class="panel-heading"><h4 style="text-align: center;"><strong>Penilaian Ujian Essay</strong> </h4></div>
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
    let bobot, nilai = 0, id_soal, id_ujian, id_user;

    $(document).on('keyup', '.nilai', function() {
        nilai = $(this).val();
    })

    $(document).on('click','.beri-nilai',delay(function(e){
        e.preventDefault();
        bobot = $(this).data('bobot');
        id_soal = $(this).data('soal');
        id_ujian = $(this).data('ujian');
        id_user = $(this).data('user');

        if(nilai <= bobot){
            $.ajax({
                type : 'post',
                url  : '<?=base_url('ujian_essay/beri_nilai');?>',
                data : {
                    nilai,
                    bobot,
                    id_soal,
                    id_ujian,
                    id_user,
                },
                success:function(response){
                   window.location.reload()
                }
            });
        }else{
            $(this).val('');
            console.warn(nilai)
            alert('Nilai melebihi bobot ! Bobot soal : ' + bobot);
        }
      

    },500));

    var base_url = "<?php echo base_url(); ?>";
    id_tes = "<?php echo $id_ujian; ?>";
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

    $('.only-number').keypress(function(evt){
             var charCode = (evt.which) ? evt.which : event.keyCode
             if (charCode > 31 && (charCode < 48 || charCode > 57))

                return false;
            return true;
    });

    function delay(callback, ms) {
			var timer = 0;
			return function() {
				var context = this, args = arguments;
				clearTimeout(timer);
				timer = setTimeout(function () {
					callback.apply(context, args);
				}, ms || 0);
			};
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