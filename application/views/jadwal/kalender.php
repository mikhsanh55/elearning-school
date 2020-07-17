

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
      <?php if($this->log_lvl == 'guru') : ?>
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-info">
              <div class="panel-heading">
                <div class="tombol-kanan">
                  <h2><strong><?=$this->page_title;?></strong></h2>
                </div>
              </div>
            </div>
            <from class="form-inline" style="display: block;">
            <div class="form-group">
                <label for="search">Search&nbsp;&nbsp;</label>
                <div class="rs-select2 js-select-simple select--no-search">
                  <select id="filter" class="form-control input-sm">
                    <?php foreach ($filter['searchFilter'] as $key => $val): ?>
                      <option value="<?=$key;?>"><?=$val;?></option>
                    <?php endforeach ?>
                  </select>
                  <div class="select-dropdown"></div>
                </div>
                <input type="text" style="width: 50%;height:30px;" class="form-control input-sm" id="search" placeholder="Ketikan yang anda cari" name="search">
              </div>
            </from>
            <br>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            Limit 
            <select id="limit">
              <option value="10">10</option>
              <option value="50">50</option>
              <option value="100">100</option>
            </select>
            <button type="button" class="btn btn-sm btn-primary ml-2" onclick="return window.location = '<?=base_url('jadwal/add');?>' ">Tambah</button>
            <?php if($this->log_lvl == 'instansi' || $this->log_lvl == 'admin') : ?>
              <a href="<?= base_url('export/jadwal') ?>" class="btn btn-sm btn-success ml-2">Cetak Dokumen</a>
            <?php endif; ?>
            <div id="content-view"></div>
            
          </div>
        </div>
      <?php endif; ?>
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
      pageLoad(1,'jadwal/page_load');

      $('#limit').change(function(){
        pageLoad(1,'jadwal/page_load');
      });

      $('#search').keyup(delay(function (e) {
        pageLoad(1,'jadwal/page_load');
      }, 500));

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