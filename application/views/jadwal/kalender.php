
  <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/font-awesome/css/font-awesome.min.css'; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/plugins/fullcalendar/fullcalendar.css'; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css'; ?>">
<style type="text/css">
   
</style>

<div class="col-md-9 page-content">
    <div class="inner-box">
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
                  
                },
                events: JSON.parse(get_data)
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
                      <td>`+response.data.nama_guru+`</td>
                    </tr>
                     <tr>
                      <td>Modul</td>
                      <td>:</td>
                      <td>`+ response.data.nama_mp+`</td>
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
                      <td></td>
                      <td>Pukul</td>
                      <td>`+response.custom.waktu_mulai+`</td>
                    </tr>
                     <tr>
                      <td>Tanggal Selesai</td>
                      <td>:</td>
                      <td>`+response.custom.tgl_selesai+`</td>
                      <td></td>
                      <td>Pukul</td>
                      <td>`+response.custom.waktu_selesai+`</td>
                    </tr>
                    
                    
                  </table>
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