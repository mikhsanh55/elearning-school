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
                <div id="tampil_jawaban" class="text-center">
                    
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <form role="form" name="_form" method="post" id="_form">
            <div class="panel panel-default">
                <div class="panel-heading">Soal Ke <div class="btn btn-info" id="soalke"></div>
        
                    <div class="tbl-kanan-soal">
                        <div id="clock" style="font-weight: bold" class="btn btn-danger "></div>
                    </div>
                    <div class="tbl-kanan-soal" style="margin-right: 10px;">
                        <!-- <div onclick="return hide();" style="font-size: 18px;" class="">Sembunyikan timer</div> -->
                        
                        <button id="hide-timer" class="btn btn-primary" data-hide="0">
                            Sembunyikan timer
                        </button>
                    </div>
                </div>

                <div class="panel-body" style="overflow: auto">
                    <input type="hidden" id="idUjian" value="<?= $idUjian; ?>">
                <?= $htmls; ?>
                </div>

                <div class="panel-footer text-center">
                    <a class="action back btn btn-info" id="back-btn" rel="0" data-form="1"><i class="fa fa-step-backward"></i> Back</a>

                    <a class="action next btn btn-info" id="next-btn" rel="2" data-form="1"><i class="fa fa-step-forward"></i> Next</a>

                    <!-- <a class="ragu_ragu btn btn-warning" rel="1" data-form="1" >Ragu-ragu</a> -->
                    
                    <a class="selesai action submit btn btn-danger" id="selesai-ujian"><i class="fa fa-ban"></i> Selesai</a>
<!-- 
                    <input type="hidden" name="jml_soal" id="jml_soal" value="<?php echo $no; ?>">
                    <?php $uri5 = $this->uri->segment(5); ?>
                    <input type="hidden" name="url3" id="url3" value="<?php echo $uri5; ?>"> -->
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

<script type="text/javascript">
    $(document).ready(function() {
        /* Deklarasi global vars */
        var base_url = "<?php echo base_url(); ?>", 
            file = undefined, // useless
            activeForm = 'form-soal-1', // useless
            jumlahSoal = "<?= $jumlahSoal; ?>",
            formData = '', // untuk FormData object
            conf = '',
            url = ''; // var untuk url pas input jawaban & file siswa
        
        id_tes = "<?php echo $id_tes; ?>";

        // Set label soal ke 1
        $('#soalke').text(1);

        // Get jawaban dan gambar siswa di soal pertama, kalo ada
        getJawaban({
            idSoal: $('#id_soal_1').val(),
            idUjian: $('#idUjian').val()
        }, 1);    

        function getFormData($form)
        {
            var unindexed_array = $form.serializeArray();
            var indexed_array = {};
            $.map(unindexed_array, function(n, i){
                indexed_array[n['name']] = n['value'];
            });
            return indexed_array;
        }

        function getJawaban(data = {}, pageSoal = 1)
        {
            $.ajax({
                type: 'post',
                url: '<?= base_url('ujian_essay/check-jawaban-soal'); ?>',
                data,
                dataType: 'json',
                success:function(res) {
                    $('textarea[name=isi_' + pageSoal + ']').val(res.data.jawaban);
                    if(res.data.file != null) {
                        $('#img-place-' + pageSoal).html(res.data.file); 
                    }
                },
                error: function(e) {
                    console.error(e.responseText);
                    return false;
                }
            });
        }

        // Animasi loading
        $(window).load(function() {
            $(".se-pre-con").fadeOut("slow");
        });

        // Useless
        $('.file_essay').on('change', function(e) {
            e.preventDefault();
            file = this.files[0];
        });

        // Hide timer button
        $('#hide-timer').click(function(e) {
            e.preventDefault();
            if($(this).data('hide') == 1) {
                $(this).data('hide', 0);
                $(this).text('Sembunyikan timer');
                $('#clock').css('display', 'block');       
            }
            else {
                $(this).data('hide', 1);   
                $(this).text('Munculkan');
                $('#clock').css('display', 'none');       
            }
        });

        // Event Navigasi soal
        $('.link-navigasi-soal').on('click', function(e) {
            e.preventDefault();
            var idSoal = $(this).data('soal'),
                noSoal = $(this).data('no'),
                jawaban = $('textarea[name=isi_' + noSoal + ']'),
                file = $('#file_essay_' + noSoal),
                ragu = $('#rg_' + noSoal),
                idJawaban = $('id-jawaban-' + noSoal);
            console.warn(noSoal)
            console.warn(jawaban)

            // Set label soal ke
            $('#soalke').text(noSoal);

            if(file.prop('files').length > 0 || jawaban.val() != '') {
                

                if(idJawaban == 0 || idJawaban < 1) {
                    url = "<?= base_url('ujian_essay/insert-jawaban') ?>";
                }
                else {
                    url = "<?= base_url('ujian_essay/update-jawaban') ?>";
                }

                
                formData = new FormData();
                formData.append('idSoal', idSoal);
                formData.append('ragu', ragu.val());
                formData.append('id', $('#id-jawaban-' + noSoal).val())
                if(file.prop('files').length > 0) {
                    formData.append('file', file.prop('files')[0]);    
                }

                if(jawaban.val() != '') {
                    formData.append('jawaban', jawaban.val());
                }
                
                $.ajax({
                    type: 'post',
                    url,
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    beforeSend: () => $('.ajax-loading').show(),    
                    success: function(res) {
                        $('.ajax-loading').hide();
                    },
                    error: function(e) {
                        $('.ajax-loading').hide();
                        alert(e.responseText.msg);
                        console.error(e.responseText);
                        return false;
                    }
                });                
            }


            // Pindahkan page
            $(".step").hide();
            $("#widget_" + noSoal).show();
        });

        // Event back button
        $('#back-btn').on('click', function() {
            /*
            * var currentSoal buat acuan get data seperti id soal, id *file,dari soal yang sedang tampil
            * sedangkan pageSoal hanya berfungsi untuk memindahkan
            * page ke soal sebelumnya
            */
            var currentSoal = parseInt($(this).data('form')),
                pageSoal = parseInt($(this).data('form')) > jumlahSoal ? jumlahSoal : parseInt($(this).data('form')) - 1,
                jawaban = $('textarea[name=isi_' + currentSoal + ']'),
                file = $('#file_essay_' + currentSoal),
                idSoal = $('#id_soal_' + currentSoal),
                ragu = $('#rg_' + currentSoal),
                id = $('#id-jawaban-' + currentSoal);

            // Set page untuk pagination
            $(this).data('form', pageSoal);
            $('#next-btn').data('form', pageSoal);

            // Set label soal ke
            $('#soalke').text(pageSoal);

            if(file.prop('files').length > 0 || jawaban.val() != '') {

                /* tentukan url berdasarkan id jawaban 
                * Kalo 0, berarti aksinya Insert, kalo selain itu Update
                */
                var idJawaban = $('#id-jawaban-' + currentSoal).val();
                if(idJawaban == 0 || idJawaban < 1) {
                    url = "<?= base_url('ujian_essay/insert-jawaban') ?>";
                }
                else {
                    url = "<?= base_url('ujian_essay/update-jawaban') ?>";
                }

                formData = new FormData();
                formData.append('idSoal', idSoal.val());
                formData.append('ragu', ragu.val());
                formData.append('id', $('#id-jawaban-' + currentSoal).val())
                if(file.prop('files').length > 0) {
                    formData.append('file', file.prop('files')[0]);    
                }

                if(jawaban.val() != '') {
                    formData.append('jawaban', jawaban.val());
                }
                
                $.ajax({
                    type: 'post',
                    url,
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    beforeSend: () => $('.ajax-loading').show(),    
                    success: function(res) {
                        $('.ajax-loading').hide();
                    },
                    error: function(e) {
                        $('.ajax-loading').hide();
                        alert(e.responseText.msg);
                        console.error(e.responseText);
                        return false;
                    }
                });
            }


            // Pindahkan page
            $(".step").hide();
            $("#widget_" + pageSoal).show();

            // Get jawaban dan file 
            var nextIdSoal = $('#id_soal_' + pageSoal).val();
            getJawaban({
                idSoal: nextIdSoal,
                idUjian: $('#idUjian').val()
            }, pageSoal);

            if(pageSoal == 1) {
                $('#back-btn').hide();
                $('#next-btn').show();
            }
            else if(pageSoal < jumlahSoal) {
                $('#back-btn').show();
                $('#next-btn').show();
            }
            else if(pageSoal >= jumlahSoal) {
                $('#back-btn').show();
                $('#next-btn').hide();
            }
        });

        // Event next button
        $('#next-btn').on('click', function() {
            /*
            * var currentSoal buat acuan get data seperti id soal, id *file,dari soal yang sedang tampil
            * sedangkan pageSoal hanya berfungsi untuk memindahkan
            * page ke soal berikutnya
            */

            var currentSoal = parseInt($(this).data('form')),
                pageSoal = parseInt($(this).data('form')) > jumlahSoal ? jumlahSoal : parseInt($(this).data('form')) + 1,
                jawaban = $('textarea[name=isi_' + currentSoal + ']'),
                file = $('#file_essay_' + currentSoal),
                idSoal = $('#id_soal_' + currentSoal),
                ragu = $('#rg_' + currentSoal);
            
            // Set page untuk pagination
            $(this).data('form', pageSoal);
            $('#back-btn').data('form', pageSoal);

            // Set label soal ke
            $('#soalke').text(pageSoal);
            
            if(file.prop('files').length > 0 || jawaban.val() != '') {

                /* tentukan url berdasarkan id jawaban 
                * Kalo 0, berarti aksinya Insert, kalo selain itu Update
                */
                var idJawaban = $('#id-jawaban-' + currentSoal).val();
                if(idJawaban == 0 || idJawaban < 1) {
                    url = "<?= base_url('ujian_essay/insert-jawaban') ?>";
                }
                else {
                    url = "<?= base_url('ujian_essay/update-jawaban') ?>";
                }

                formData = new FormData();
                formData.append('idSoal', idSoal.val());
                formData.append('ragu', ragu.val());
                formData.append('id', $('#id-jawaban-' + currentSoal).val())
                if(file.prop('files').length > 0) {
                    formData.append('file', file.prop('files')[0]);
                }

                if(jawaban.val() != '') {
                    formData.append('jawaban', jawaban.val());
                }
                
                $.ajax({
                    type: 'post',
                    url,
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    beforeSend: () => $('.ajax-loading').show(),    
                    success: function(res) {
                        $('.ajax-loading').hide();
                    },
                    error: function(e) {
                        $('.ajax-loading').hide();
                        alert(e.responseText.msg);
                        console.error(e.responseText);
                        return false;
                    }
                });
            }

            // Pindahkan page
            $(".step").hide();
            $("#widget_" + pageSoal).show();

            // Get jawaban dan file 
            var nextIdSoal = $('#id_soal_' + pageSoal).val();
            getJawaban({
                idSoal: nextIdSoal,
                idUjian: $('#idUjian').val()
            }, pageSoal);

            if(pageSoal == 1) {
                $('#back-btn').hide();
                $('#next-btn').show();
            }
            else if(pageSoal < jumlahSoal) {
                $('#back-btn').show();
                $('#next-btn').show();
            }
            else if(pageSoal >= jumlahSoal) {
                $('#back-btn').show();
                $('#next-btn').hide();
            }
        });

        // Hide semua soal dan tampilkan soal pertama
        $('.step').hide();
        $('#widget_1').show();
        $('#back-btn').hide();

        $('#selesai-ujian').click(function() {
            
            conf = confirm('Anda yakin sudah mengisi semua soal dengan benar?');

            if(conf) {
                
                // Insert atau update soal terakhir
                var jawaban = $('textarea[name=isi_' + jumlahSoal + ']'),
                    file = $('#file_essay_' + jumlahSoal),
                    idSoal = $('#id_soal_' + jumlahSoal),
                    ragu = $('#rg_' + jumlahSoal);
                
                // Set page untuk pagination
                $(this).data('form', jumlahSoal);
                $('#back-btn').data('form', jumlahSoal);

                // Set label soal ke
                $('#soalke').text(jumlahSoal);
                
                if(file.prop('files').length > 0 || jawaban.val() != '') {

                    /* tentukan url berdasarkan id jawaban 
                    * Kalo 0, berarti aksinya Insert, kalo selain itu Update
                    */
                    var idJawaban = $('#id-jawaban-' + jumlahSoal).val();
                    if(idJawaban == 0 || idJawaban < 1) {
                        url = "<?= base_url('ujian_essay/insert-jawaban') ?>";
                    }
                    else {
                        url = "<?= base_url('ujian_essay/update-jawaban') ?>";
                    }

                    formData = new FormData();
                    formData.append('idSoal', idSoal.val());
                    formData.append('ragu', ragu.val());
                    formData.append('id', $('#id-jawaban-' + jumlahSoal).val())
                    if(file.prop('files').length > 0) {
                        formData.append('file', file.prop('files')[0]);
                    }

                    if(jawaban.val() != '') {
                        formData.append('jawaban', jawaban.val());
                    }
                    
                    $.ajax({
                        type: 'post',
                        url,
                        data: formData,
                        dataType: 'json',
                        processData: false,
                        contentType: false,
                        beforeSend: () => $('.ajax-loading').show(),    
                        success: function(res) {
                            $('.ajax-loading').hide();
                        },
                        error: function(e) {
                            $('.ajax-loading').hide();
                            alert(e.responseText.msg);
                            console.error(e.responseText);
                            return false;
                        }
                    });
                }

                // Get jawaban dan file 
                var nextIdSoal = $('#id_soal_' + jumlahSoal).val();
                getJawaban({
                    idSoal: nextIdSoal,
                    idUjian: $('#idUjian').val()
                }, jumlahSoal);

                // Update data ujian terakhir
                $.ajax({
                    type: 'post',
                    url: "<?= base_url('ujian_essay/selesai-ujian'); ?>",
                    data: {
                        idUjian:$('#idUjian').val()
                    },
                    dataType: 'json',
                    beforeSend: () => $('.ajax-loading').show(),
                    success: function(res) {
                        $('.ajax-loading').hide();
                        alert(res.msg);
                        window.location.href = "<?= base_url('ujian_real'); ?>"
                    },
                    error: function(e) {
                        alert(e.responseText.msg);
                        console.error(e.responseText);
                        return false;
                    }
                });
            }
        });
    });

    // Start clock timer
    $('#clock').countdowntimer({
        var selesaiTime = parseInt("<?= $jamSelesai; ?>"),
            jamMulai = new Date(),
            jamSelesai = new Date(jamMulai.getTime() + ( selesaiTime * 60 * 1000));
        startDate: jamMulai,
        dateAndTime: jamSelesai,
        size: 'lg',
        displayFormat: 'HMS',
        timeUp: () => {
            // Update data ujian terakhir
            $.ajax({
                type: 'post',
                url: "<?= base_url('ujian_essay/selesai-ujian'); ?>",
                data: {
                    idUjian:$('#idUjian').val()
                },
                dataType: 'json',
                beforeSend: () => $('.ajax-loading').show(),
                success: function(res) {
                    $('.ajax-loading').hide();
                    alert(res.msg);
                    window.location.href = "<?= base_url('ujian_real'); ?>"
                },
                error: function(e) {
                    alert(e.responseText.msg);
                    console.error(e.responseText);
                    return false;
                }
            });                        
        }

    });
    

    //jawaban dan nomer
    simpan_sementara_ujian = function() {
        var f_asal  = $(activeForm);
        var form  = getFormData(f_asal);
        //form = JSON.stringify(form);
        var jml_soal = form.jml_soal;
        jml_soal = parseInt(jml_soal);
        var hasil_jawaban = "";

        for (var i = 1; i < jml_soal; i++) {
            var idx = 'opsi_'+i;
            var idx2 = 'rg_'+i;
            var jawab = form[idx];
            var ragu = form[idx2];

            if (jawab != undefined) {
                if (ragu == "Y") {
                    if (jawab == "-") {
                        hasil_jawaban += '<a id="btn_soal_'+(i)+'" class="btn btn-default btn_soal btn-sm" onclick="return buka('+(i)+');">'+(i)+". "+jawab+"</a>";
                    } else {
                        hasil_jawaban += '<a id="btn_soal_'+(i)+'" class="btn btn-warning btn_soal btn-sm" onclick="return buka('+(i)+');">'+(i)+". "+jawab+"</a>";
                    }
                } else {
                    if (jawab == "-") {
                        hasil_jawaban += '<a id="btn_soal_'+(i)+'" class="btn btn-default btn_soal btn-sm" onclick="return buka('+(i)+');">'+(i)+". "+jawab+"</a>";
                    } else {
                        hasil_jawaban += '<a id="btn_soal_'+(i)+'" class="btn btn-success btn_soal btn-sm" onclick="return buka('+(i)+');">'+(i)+". "+jawab+"</a>";
                    }
                }
            } else {
                hasil_jawaban += '<a id="btn_soal_'+(i)+'" class="btn btn-default btn_soal btn-sm" onclick="return buka('+(i)+');">'+(i)+". -</a>";
            }
        }

        $("#tampil_jawaban").html('<div id="yes"></div>'+hasil_jawaban);
    }

    simpan = function() {
        var f_asal  = $(activeForm);
        var form  = getFormData(f_asal);
        var formData = new FormData();
        for(var prop in form) {
            formData.append(prop, form[prop]);
        }
        // if(file != undefined) {
        //     formData.append('file', file);
        // }
        var id_penggunaan = $("#url3").val();
        $.ajax({    
            type: "POST",
            url: base_url+"ujian_essay/insertOneData/"+id_tes+"/"+id_penggunaan,
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('.ajax-loading').show();    
            },
            success: function(response) {
                $('.ajax-loading').hide(); 
            
                var hasil_jawaban = "";
                var panjang       = response.data.length;
                
                for (var i = 0; i < panjang; i++) {
                    if (response.data[i] != "_N") {
                        var getjwb = response.data[i];
                        var pc_getjwb = getjwb.split('_');

                        if (pc_getjwb[1] == "Y") {
                            if (pc_getjwb[0] == "-") {
                                hasil_jawaban += '<a id="btn_soal_'+(i+1)+'" class="btn btn-default btn_soal btn-sm" onclick="return buka('+(i+1)+');">'+(i+1)+". "+pc_getjwb[0]+"</a>";
                            } else {
                                hasil_jawaban += '<a id="btn_soal_'+(i+1)+'" class="btn btn-warning btn_soal btn-sm" onclick="return buka('+(i+1)+');">'+(i+1)+". "+pc_getjwb[0]+"</a>";
                            }
                        } else {
                            if (pc_getjwb[0] == "-") {
                                hasil_jawaban += '<a id="btn_soal_'+(i+1)+'" class="btn btn-default btn_soal btn-sm" onclick="return buka('+(i+1)+');">'+(i+1)+". "+pc_getjwb[0]+"</a>";
                            } else {
                                hasil_jawaban += '<a id="btn_soal_'+(i+1)+'" class="btn btn-success btn_soal btn-sm" onclick="return buka('+(i+1)+');">'+(i+1)+". "+pc_getjwb[0]+"</a>";
                            }
                        }
                    } else {
                        hasil_jawaban += '<a id="btn_soal_'+(i+1)+'" class="btn btn-default btn_soal btn-sm" onclick="return buka('+(i+1)+');">'+(i+1)+". -</a>";
                    }
                }
            },
            error: function(e) {
                alert('Kesalahan terjadi');
                $('.ajax-loading').hide(); 
                var dataError = e.responseText;
                console.error(dataError);
            }
        }).done(function(response) {
            

            //$("#tampil_jawaban").html('<div id="yes"></div>'+hasil_jawaban);
        });
        return false;
    }


function hide() {
  var x = document.getElementById("clock");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

    
    hitung = function() {
        var selesaiTime = parseInt("<?= $jamSelesai; ?>"),
            jamMulai = new Date(),
            jamSelesai = new Date(jamMulai.getTime() + ( selesaiTime * 60 * 1000));

        $("div#clock").countdowntimer({
            startDate : jamMulai,
            dateAndTime : jamSelesai,
            size : "lg",
            displayFormat: "HMS",
            timeUp : selesai,
        });
    }

    selesai = function() {
        var f_asal  = $("#_form");
        var form  = getFormData(f_asal);
        simpan_akhir(id_tes);
        //window.location.assign("<?php echo base_url(); ?>ujian/sudah_selesai_ujian/"+id_tes); 
          
        return false;
    }

    next = function() {
        var berikutnya  = $(".next").attr('rel');
        berikutnya = parseInt(berikutnya);
        berikutnya = berikutnya > total_widget ? total_widget : berikutnya;

        $("#soalke").html(berikutnya);

        $(".next").attr('rel', (berikutnya+1));
        $(".back").attr('rel', (berikutnya-1));
        $(".ragu_ragu").attr('rel', (berikutnya));
        cek_status_ragu(berikutnya);
        cek_terakhir(berikutnya);
        
        var sudah_akhir = berikutnya == total_widget ? 1 : 0;

        $(".step").hide();
        $("#widget_"+berikutnya).show();

        if (sudah_akhir == 1) {
            $(".back").show();
            $(".next").hide();
        } else if (sudah_akhir == 0) {
            $(".next").show();
            $(".back").show();
        }

        simpan_sementara_ujian();
        simpan();
    }

    back = function() {
        var back  = $(".back").attr('rel');
        back = parseInt(back);
        back = back < 1 ? 1 : back;

        $("#soalke").html(back);
        
        $(".back").attr('rel', (back-1));
        $(".next").attr('rel', (back+1));
        $(".ragu_ragu").attr('rel', (back));
        cek_status_ragu(back);
        cek_terakhir(back);
        
        $(".step").hide();
        $("#widget_"+back).show();

        var sudah_awal = back == 1 ? 1 : 0;
         
        $(".step").hide();
        $("#widget_"+back).show();
        
        if (sudah_awal == 1) {
            $(".back").hide();
            $(".next").show();
        } else if (sudah_awal == 0) {
            $(".next").show();
            $(".back").show();
        }

        simpan_sementara_ujian();
        simpan();
    }

    tidak_jawab = function() {
        var id_step = $(".ragu_ragu").attr('rel');
        var status_ragu = $("#rg_"+id_step).val();

        if (status_ragu == "N") {
            $("#rg_"+id_step).val('Y');
            $("#btn_soal_"+id_step).removeClass('btn-success');
            $("#btn_soal_"+id_step).addClass('btn-warning');

        } else {
            $("#rg_"+id_step).val('N');
            $("#btn_soal_"+id_step).removeClass('btn-warning');
            $("#btn_soal_"+id_step).addClass('btn-success');
        }


        cek_status_ragu(id_step);

        simpan_sementara_ujian();
        simpan();
    }

    cek_status_ragu = function(id_soal) {
        var status_ragu = $("#rg_"+id_soal).val();

        if (status_ragu == "N") {
            $(".ragu_ragu").html('Ragu');
        } else {
            $(".ragu_ragu").html('Tidak Ragu');
        }
    }

    cek_terakhir = function(id_soal) {
        var jml_soal = $("#jml_soal").val();
        jml_soal = (parseInt(jml_soal) - 1);

        if (jml_soal == id_soal) {
            $(".selesai").show();
        } else {
            $(".selesai").hide();
        }
    }

    buka = function(id_widget) {
        $(".next").attr('rel', (id_widget+1));
        $(".back").attr('rel', (id_widget-1));
        $(".ragu_ragu").attr('rel', (id_widget));
        cek_status_ragu(id_widget);
        cek_terakhir(id_widget);

        $("#soalke").html(id_widget);
        
        $(".step").hide();
        $("#widget_"+id_widget).show();
    }

 simpan_akhir = function() {
        simpan();
        var id_penggunaan = $("#url3").val();
        if (confirm('Ujian telah selesai. Anda yakin akan mengakhiri tes ini..?')) {
            simpan();
            $.ajax({
                type: "GET",
                url: base_url+"ujian_essay/simpan_akhir_ujian/"+id_tes+"/"+id_penggunaan,
                beforeSend: function() {
                    $('.ajax-loading').show();    
                },
                success: function(r) {
                    if(r.status == "ok") {
                        window.location.assign("<?php echo base_url(); ?>ujian_real"); 
                    }
                }
            });

            return false;
        }
    }

    show_jawaban = function() {
        $("#v_jawaban").toggle();
    }
    </script>
</body>
</html>