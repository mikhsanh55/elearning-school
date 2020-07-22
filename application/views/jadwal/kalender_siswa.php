

<style type="text/css">
  h1{
    font-family: sans-serif;
  }

  table {
    margin-top: 10px;
    font-family: Arial, Helvetica, sans-serif;

    font-size: 12px;
    width: 100%;
    color: #666;
    background: #eaebec;
    border: #ccc 1px solid;
    border-radius: 25px;
  }

  table th {
    padding: 2px 5px;
    border:1px solid #337ab7;
    background: #337ab7;;
    text-align: center;
    color: #fff;
  }

  table th:first-child{  
    border-left:none;  
  }

  table tr {
    padding-left: 20px;
  }

  td.frist,th.frist {
    width: 1px;
    white-space: nowrap;
}

  table td {
    padding: 5px 5px;
    border-top: 1px solid #ffffff;
    border-bottom: 1px solid #e0e0e0;
    border-left: 1px solid #e0e0e0;
    background: #fff;
    background: -webkit-gradient(linear, left top, left bottom, from(#fbfbfb), to(#fafafa));
    background: -moz-linear-gradient(top, #fbfbfb, #fafafa);
  }

  table tr:last-child td {
    border-bottom: 0;
  }

  table tr:last-child td:first-child {
    -moz-border-radius-bottomleft: 3px;
    -webkit-border-bottom-left-radius: 3px;
    border-bottom-left-radius: 3px;
  }

  table tr:last-child td:last-child {
    -moz-border-radius-bottomright: 3px;
    -webkit-border-bottom-right-radius: 3px;
    border-bottom-right-radius: 3px;
  }

  table tr:hover td {
    background: #f2f2f2;
    background: -webkit-gradient(linear, left top, left bottom, from(#f2f2f2), to(#f0f0f0));
    background: -moz-linear-gradient(top, #f2f2f2, #f0f0f0);
  }

</style>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/font-awesome/css/font-awesome.min.css'; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/plugins/fullcalendar/fullcalendar.css'; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css'; ?>">
<style type="text/css">
   
</style>

<div class="col-md-9 page-content">
    <div class="inner-box">
      <br>
          <div class="container-fluid">

               <div id="calendarIO"></div>
           </div>
    </div>

</div>
</div>
<!--/.row-box End-->
<script src="<?= base_url(); ?>assets/js/jquery/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/moment.min.js'; ?>"></script>      
<script type="text/javascript" src="<?php echo base_url().'assets/js/bootstrap.min.js'; ?>"></script> 
<script type="text/javascript" src="<?php echo base_url().'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js'; ?>"></script>   
<script type="text/javascript" src="<?=base_url().'assets/plugins/fullcalendar/fullcalendar.js'; ?>"></script> 
<script type="text/javascript">
    var get_data        = '<?php echo $get_data; ?>';
    var backend_url     = '<?php echo base_url(); ?>';
    function pageLoad(pg, url, search){
      $.ajax({
        type : 'post',
        url  : '<?php echo base_url() ?>' + url + '/' + pg,
        data :{
          pg    : pg,
          limit : $('#limit').val(),
          filter : $('#filter').val(),
          search : $('#search').val()
        },
        success:function(response){
          $('#content-view').html(response);
        }
      })
    }
    $(document).ready(function() {
    
        $('.date-picker').datepicker();
       $('#calendarIO').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,basicWeek,basicDay'
            },
            defaultDate: moment().format('YYYY-MM-DD'),
            editable: true,
                eventLimit: true, // allow "more" link when too many events
                selectable: true,
                selectHelper: true,
                eventClick: function(event, element)
                {   
                    detail(event);
                  
                }
            ,
            eventSources: [
              {
                events: [{"id":98,"time":"Biologi - Kelas 11","title":"Sel","description":"kumpulkan dalam bentuk pdf","start":"2020-07-22 07:00:00","end":"2020-07-22 08:30:00","color":"#FF0000"},{"id":99,"time":"Bahasa Sunda - Kelas 11","title":"Testing Link Youtube","description":"","start":"2020-07-18 08:30:00","end":"2020-07-23 11:00:00","color":"#FF8C00"},{"id":104,"time":"Ekonomi - Kelas 11","title":"Testing Link Youtube, Upload PDF dan PPT","description":"Testing Jadwal","start":"2020-07-01 08:00:00","end":"2020-07-06 23:00:00","color":"#0071c5"},{"id":105,"time":"Fisika - Kelas 11","title":"Testing Link Youtube, Upload PDF dan PPT","description":"Testing Jadwal","start":"2020-07-21 09:00:00","end":"2020-07-22 11:03:00","color":"#FF0000"},{"id":109,"time":"Geografi - Kelas 11","title":"Testing Link Youtube, Upload PDF dan PPT","description":"Testing Jadwal","start":"2020-07-30 23:11:00","end":"2020-07-31 23:45:00","color":"#FF8C00"},{"id":112,"time":"Bahasa Indonesia - Kelas 11","title":"Testing Link Youtube, Upload PDF dan PPT","description":"Testing Jadwal","start":"2020-07-25 22:00:00","end":"2020-07-26 01:00:00","color":"#0071c5"},{"id":115,"time":"PAI - Kelas 11","title":"Upload Link Youtube, Upload PDF dan PPT","description":"TESTING","start":"2020-07-16 08:08:00","end":"2020-07-19 08:08:00","color":"#40E0D0"},{"id":121,"time":"PKn - Kelas 11","title":"hak dan kewajiban warga negara","description":"kerjakan dengan teliti","start":"2020-07-18 09:00:00","end":"2020-07-18 12:00:00","color":"#0071c5"},{"id":122,"time":"PKn - Kelas 11","title":"hak dan kewajiban warga negara","description":"kerjakan dengan teliti","start":"2020-07-18 09:00:00","end":"2020-07-18 12:00:00","color":"#0071c5"},{"id":130,"time":"Bahasa Inggris - Kelas 11","title":"Suggestion","description":"hhh","start":"0000-00-00 00:00:00","end":"0000-00-00 00:00:00","color":"#008000"},{"id":138,"time":"Matematika - Kelas 11","title":"persamaan trigonometri","description":"pertemuan ke 1","start":"2020-07-23 19:00:00","end":"2020-07-23 21:00:00","color":"#008000"},{"id":144,"time":"Bahasa Sunda - Kelas 11","title":"Biantara","description":"","start":"2020-07-17 00:00:00","end":"0000-00-00 00:00:00","color":"#FF0000"},{"id":147,"time":"","title":"","description":"hhh","start":"2020-07-17 18:30:00","end":"2020-07-17 12:30:00","color":"#008000"},{"id":149,"time":"","title":"","description":"hhh","start":"2020-07-17 18:30:00","end":"2020-07-17 12:30:00","color":"#008000"},{"id":150,"time":"Sejarah - Kelas 11","title":"Penjelajahan Samudera Bangsa Barat","description":"Penjelajahan Samudera","start":"2020-07-22 07:00:00","end":"2020-07-25 00:00:00","color":"#0071c5"},{"id":159,"time":"","title":"","description":"hhh","start":"2020-07-17 18:30:00","end":"2020-07-17 12:30:00","color":"#008000"},{"id":160,"time":"PAI - Kelas 11","title":"Taat, Kompetensi dalam Kebaikan","description":"","start":"2020-07-13 06:15:00","end":"2022-07-13 18:15:00","color":"#FF0000"},{"id":161,"time":"PAI - Kelas 11","title":"Taat, Kompetensi dalam Kebaikan","description":"","start":"2020-07-13 06:15:00","end":"2022-07-13 18:15:00","color":"#FF0000"},{"id":162,"time":"PAI - Kelas 11","title":"Taat, Kompetensi dalam Kebaikan","description":"","start":"2020-07-13 06:15:00","end":"2022-07-13 18:15:00","color":"#FF0000"},{"id":165,"time":"PAI - Kelas 11","title":"Taat, Kompetensi dalam Kebaikan","description":"","start":"2020-07-13 06:15:00","end":"2020-07-13 03:05:00","color":"#FF0000"},{"id":166,"time":"PKn - Kelas 11","title":"makna pancasila","description":"kerjakan secara individu","start":"2020-07-18 09:00:00","end":"2020-07-18 12:00:00","color":"#FF0000"},{"id":169,"time":"Matematika - Kelas 11","title":"matriks 1","description":"","start":"2020-07-18 07:00:00","end":"2020-07-18 09:00:00","color":"#0071c5"}],
                textColor: 'yellow'
              }
            ]
            });
    });

    function detail(event)
    {   
        $("#detail").modal('show');
        $.ajax({
          type : 'post',
          url  : '<?=base_url('jadwal/get_data_kalender/');?>',
          dataType : 'json',
          data : {
            id : event.id
          },
          success:function(response){
                var content  = `
                  <table>
                    <tr>
                      <td>Kegiatan</td>
                      <td>:</td>
                      <td>`+response.data.keterangan+`</td>
                    </tr>
                     <tr>
                      <td>Pengajar</td>
                      <td>:</td>
                      <td>`+response.custom.nama_guru+`</td>
                    </tr>
                     <tr>
                      <td>Mata Pelajaran</td>
                      <td>:</td>
                      <td>`+ response.custom.nama_mapel+`</td>
                    </tr>
                     <tr>
                      <td>Materi</td>
                      <td>:</td>
                      <td>`+response.data.nama_materi+`</td>
                    </tr>
                     <tr>
                      <td>Tanggal Mulai</td>
                      <td>:</td>
                      <td>`+response.custom.tgl_mulai+`</td>
                      
                    </tr>
                    <tr>
                      <td>Jam Mulai</td>  
                      <td>:</td>
                      <td>`+response.custom.waktu_mulai+`</td>
                    </tr>
                     <tr>
                      <td>Tanggal Selesai</td>
                      <td>:</td>
                      <td>`+response.custom.tgl_selesai+`</td>
                      
                    </tr>
                    <tr>
                      <td>Jam Selesai</td>
                      <td>:</td>
                      
                      <td>`+response.custom.waktu_selesai+`</td>
                    </tr>
                    
                    
                  </table>
                  <div class="mt-3">
                    <a href="${response.custom.link_materi}" class="btn btn-primary btn-sm btn-block">Mulai Belajar</a>
                `;
                $('#detail-kalendar').html(content);
          }
        })
       

    }


</script>
</body>
<div class="modal" id="detail"  tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" style="max-width: 400px !important;" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="head">Jadwal Kegiatan</h5>
          
        </button>
      </div>
      <div class="modal-body">
        <p id="detail-kalendar">Modal body text goes here</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>