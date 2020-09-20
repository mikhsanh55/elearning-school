<div class="col-md-9 page-content">
	<div class="inner-box">

		<div id="accordion" class="panel-group">
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
									<?php foreach ($searchFilter as $key => $val): ?>
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
				<a href="javascript:void(0);" title="Edit" id="edited" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> &nbsp;Edit</a>
				<a href="javascript:void(0);" id="deleted" title="Hapus" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> &nbsp;Hapus</a>
				<a href="<?= base_url('export/jadwal') ?>" class="btn btn-sm btn-success ml-2">
					<i class="fas fa-file"></i> &nbsp;Export</a>
				<div id="content-view"></div>
			</div>
		</div>
	</div>
</div>
</div>
<!--/.row-box End-->
<script src="<?= base_url(); ?>assets/js/jquery/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
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


	})

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

	$(document).on('click','#checkall',function(){
		if ($(this).is(':checked')) {
			$('.checklist').prop('checked',true);
		} else {
			$('.checklist').prop('checked',false);
		}		
	});

	$(document).on('click','#deleted',function(){
    var totalChecked = $('.checklist:checked').length;
    var opsi = [];

    if (totalChecked > 0) {
      var y = confirm('Apakah anda yakin untuk menghapus data ?');
      $(".checklist:checked").each(function(){
        opsi.push($(this).val());
      });
    }else{
      alert('Tidak ada yang dipilih!');
    }

    if (y == true) {
      $.ajax({
        type:'post',
        url : '<?=base_url('jadwal/multi_delete');?>',
        dataType : 'json',
        data : {
          id : opsi,
        },
        success:function(res){
          if(res.status) {
            pageLoad(1,'jadwal/page_load');
          }
          else {
            alert(res.msg)
            console.error(res);
            return false;
          }
        },
        error: function(e) {
          alert(e.responseText.msg);
          console.error(e.responseText);
          return false;
        }
      });
    } else {
      return false;
    }
  });

	$(document).on('click','#edited',function(){
		var totalChecked = $('.checklist:checked').length;
		var opsi = [];

		if (totalChecked > 1) {
			alert('Pilih satu untuk edit  !');
			return false;
		}else if(totalChecked < 1){
			alert('Tidak ada yang dipilih!');
			return false;
		}else{
			window.location = base_url + 'jadwal/edit/' + $('.checklist:checked').data('id');
		}	
	});
</script>