<!DOCTYPE html>
<html lang="en" dir="ltr">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
  <script src="<?=base_url('assets/js/kit.fontawesome.js');?>"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Fav and touch icons -->
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?= base_url(); ?>assets/ico/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?= base_url(); ?>assets/ico/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?= base_url(); ?>assets/ico/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="<?= base_url(); ?>assets/ico/apple-touch-icon-57-precomposed.png">
  <link rel="shortcut icon" href="<?=$this->logo;?>">
  <title><?=$this->title;?></title>
  <!-- Bootstrap core CSS --> 
  <link href="<?= base_url(); ?>assets/bootstrap/css/bootstrap.css" rel="stylesheet">
  <link href="<?= base_url(); ?>assets/css/style.css" rel="stylesheet">
  <!-- Light Slider -->
  <script src="<?=base_url();?>assets/js/jquery/jquery-3.3.1.min.js"></script>
  <link rel="stylesheet" href="<?= base_url('assets/css/lightslider.css'); ?>">
  <script src="<?= base_url('assets/js/lightslider.js'); ?>"></script>
  <!-- Chart JS -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
  <style type="text/css">
    .capitalize {
      text-transform: capitalize;
    }
    .fa-ban:hover { 
      cursor: not-allowed;
    }
    .modal-content {
      margin: 0 auto;
          display: block;
    }

    .img-slider:hover {
      cursor: pointer;
    }

  /*Style in diskusi page*/
  .diskusi-img {
    cursor: pointer;
    width:30%;
    height: 30%;
    transition: .5s;
  }
  .view-diskusi-img {
    transition: 1s;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) scale(.8);
  }
  @keyframes rot {
      0% {
          transform:rotate(0deg);
      }
      100% {
          transform:rotate(360deg);
      }
  }
  .spin-icon {
      animation:rot 1s linear infinite;   
  }
  .hide {
      display:none;
  }
  .acc-list:hover {
    color:#f7f7f7 !important;
  }
  .parent-menu-link {
    position: relative;
  }
  .caret-sub-menu {
    transition: .4s;
    float: right;
    margin-top:5%;
  }
  .caret-0deg {
    transform:rotate(0deg);
  }
  .caret-90deg {
    transform:rotate(90deg);
  }
  </style>
  <!-- styles needed for carousel slider -->
  <link href="<?= base_url(); ?>assets/plugins/owl-carousel/owl.carousel.css" rel="stylesheet">
  <link href="<?= base_url(); ?>assets/plugins/owl-carousel/owl.theme.css" rel="stylesheet">
  <link href="<?= base_url(); ?>assets/css/chat/chat.css" rel="stylesheet" />
  <!-- bxSlider CSS file -->
  <link href="<?= base_url(); ?>assets/plugins/bxslider/jquery.bxslider.css" rel="stylesheet" />

  <link href="<?=base_url();?>/assets/vendor/select2/select2.min.css" rel="stylesheet" media="all">
  <link href="<?=base_url();?>/assets/vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">

  <!-- Just for debugging purposes. -->
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
   <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
   <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
   <![endif]-->
  <script>
    const createSess = {
      setItem:function(key, value) {
        return Promise.resolve().then(function() {
          sessionStorage.setItem(key, value);
          localStorage.setItem(key, value);
        });
      }
    }
    
    function saveSess(el) {
      let mapel = el.getAttribute('data-mapel'),
      url = el.getAttribute('data-href');
      createSess.setItem('mapel', mapel, url).then(function() {
        window.location = url;
      });
    }
    
    // For Hit modul
    function hit(el) {
      let hitToken = el.getAttribute('data-href'),
      mapel = el.getAttribute('data-mapel');
      sessionStorage.setItem('mapel', mapel);
      $.ajax({
        type:"POST",
        url:"<?= base_url('laporan/push_data') ?>",
        data:{mapel:mapel},
        dataType:"JSON",
        success:function(res) {
          if(res.status == true) {
            window.location.href = hitToken;
          }
          else {
            window.location.href = hitToken;    
          }
        }
      });
    }
    paceOptions = {
      elements: true
    };
  </script>
  <script src="<?= base_url(); ?>assets/js/pace.min.js"></script>
  <script src="<?= base_url(); ?>assets/plugins/modernizr/modernizr-custom.js"></script>
  <link href="<?= base_url(); ?>assets/plugin/fa/css/font-awesome.min.css" rel="stylesheet">
  <link href="<?= base_url(); ?>assets/plugin/datatables/dataTables.bootstrap.css" rel="stylesheet">
  
    <script type="text/javascript">
        $(document).ready(function () {
            CheckingSeassion();
            load_notif();

            var auto_refresh = setInterval(
              function () {
                load_notif();
            }, 5000); // refresh setiap 10000 milliseconds
        });
        function CheckingSeassion() {
            $.ajax({
                type: "POST",
                url: "<?=base_url('login/check_sess');?>",
                dataType: "json",
                success: function (response) {
                    if (response.d == 0) {
                        window.location = '<?=base_url('login');?>';
                    }
                },
                failure: function (msg) {
                    alert(msg);
                }
            });
        }

        $(document).on('click','#all_see',function(){
          var y = confirm('apakan anda yakin akan menandai semua telah di baca ?');
          if (y == true) {
            $.ajax({
                type: "POST",
                url: "<?=base_url('materi/see_all_notif');?>",
                dataType: "json",
                success: function (response) {
                   load_notif();
                },
                failure: function (msg) {
                    alert(msg);
                }
            });
          }else{
            return false;
          }
        })

         function load_notif() {
            $.ajax({
                type: "POST",
                url: "<?=base_url('materi/get_notif');?>",
                dataType: "json",
                success: function (response) {
                    $('.notif-number').text(response.notifNumber);
                    var html = '';
                    $.each(response.data, function(i, item) {
                   
                  html += `
                        <li class="notification-box `+item.bg+` ">
                                <div class="row">
                                  <div class="col-lg-3 col-sm-3 col-3 text-center">
                                    <img src="<?=base_url('assets/ico/info.png');?>" class="w-50 rounded-circle">
                                </div>    
                                <div class="col-lg-8 col-sm-8 col-8">
                                    <strong class="text-info">`+item.nama_pengirim+ ` - </strong>
                                    <strong class="text-danger text-right">`+item.sender+`</strong>
                                    <div>
                                     <a class="link-diskussi" href="`+item.url+`">`+item.keterangan+` - <strong>`+item.title+`</strong></a>
                                 </div>
                                 <small class="text-warning"><span id="notif-date"></span></small>
                             </div>    
                         </div>
                     </li>
                    `;
                     });

                    $('#notif-list').html(html);
                },
                failure: function (msg) {
                    alert(msg);
                }
            });
        }
        
</script> 
<style type="text/css">

.nav-pills .nav-link.active, .nav-pills .show > .nav-link{
  background-color: #eee;
}
.dropdown-menu-custom{
  top: 60px;
  right: 0px;
  left: unset;
  width: 460px;
  box-shadow: 0px 5px 7px -1px #c1c1c1;
  padding-bottom: 0px;
  padding: 0px;
}
.dropdown-menu-custom:before{
  content: "";
  position: absolute;
  top: -20px;
  right: 12px;
  border:10px solid #343A40;
  border-color: transparent transparent #343A40 transparent;
}
.head{
  padding:5px 15px;
  border-radius: 3px 3px 0px 0px;
}
.text-blue{
    color: #1489ff !important;
}
.footer{
  padding:5px 15px;
  border-radius: 0px 0px 3px 3px; 
}
.notification-box{
  padding: 10px 0px; 
}
.bg-blue{
  background-color: #1489ff !important;;
}
.bg-gray{
  background-color: #eee !important;;
}
.scrollable-menu {
    height: auto;
    max-height: 400px;
    overflow-x: hidden;
}
.link-diskusi:hover{
  color: #1489ff;;
}
@media (max-width: 640px) {
    .dropdown-menu-custom{
      top: 50px;
      left: -16px;  
      width: 290px;
    } 
 
    .message{
      font-size: 13px;
    }
}
.dataTables_empty {
  text-align: center;
}
#datatabel_wrapper {
  display: flex;
  flex-flow: column wrap;
  width: 100%;
}
.ini_bodi {
  width:100%;
}
.ini_bodi .panel {
  width: 100%;
}
#datatabel_wrapper .row {
  margin-bottom: 18px;
}
.img-zoom {
  transform: scale(1);
}
</style>
</head>
<body>
  <div class="modal fade" id="sliderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="background: transparent;border:none;">
      <div class="modal-body" style="background: transparent;padding: 0;">
        
      </div>
    </div>
  </div>
</div>