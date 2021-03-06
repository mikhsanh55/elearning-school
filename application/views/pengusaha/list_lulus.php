

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

<div class="col-md-9 page-content">
	<div class="inner-box">

		<div id="accordion" class="panel-group">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-info">
						<div class="panel-heading">
							<div class="tombol-kanan">
								<h2><strong>Data Riwayat Kelulusan <?= ucfirst($this->transTheme->siswa);?></strong></h2>
							</div>
						</div>
					</div>
					<from class="form-inline" style="display: block;">
						<div class="form-group">
							<label for="search">Search&nbsp;&nbsp;</label>
							<select id="filter" class="form-control input-sm">
								<?php foreach ($searchFilter as $key => $val): ?>
									<option value="<?=$key;?>"><?=$val;?></option>
								<?php endforeach ?>
							</select>
							<input type="text" style="width: 50%;" class="form-control input-sm" id="search" placeholder="ketikan yang anda cari" name="search">
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
		
				<!-- <a class="btn btn-success btn-sm tombol-kanan" href="#" onclick="return m_siswa_add();"><i class="fa fa-user-plus"></i> &nbsp;Tambah</a>
				<a href="javascript:void(0);" title="edit" id="edited" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> &nbsp;Edit</a>
				<a href="javascript:void(0);" id="deleted" title="Hapus" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> &nbsp;Hapus</a> -->

				<!-- <a class="btn btn-warning btn-sm tombol-kanan" href="<?php echo base_url(); ?>upload/format_siswa.xlsx"><i class="fa fa-cloud-download" aria-hidden="true"></i> &nbsp;Download Format Import</a>
				<a class="btn btn-warning btn-sm tombol-kanan" href="<?php echo base_url(); ?>pengusaha/import"><i class="fa fa-cloud-upload" aria-hidden="true"></i> &nbsp;Import</a> -->
				<a class="btn btn-success btn-sm tombol-kanan" href="#" id="restore"><i class="fa fa-undo" aria-hidden="true" data-graduated="1"></i> &nbsp;Restore</a>
				<a class="btn btn-success btn-sm tombol-kanan" href="<?php echo base_url('export/siswa/1'); ?>"><i class="fa fa-file-excel-o" aria-hidden="true"></i> &nbsp;Export</a>
	
			
			
				<div id="content-view"></div>
			</div>
		</div>
	</div>

</div>
</div>


<script src="<?= base_url(); ?>assets/js/jquery/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		pageLoad(1,'pengusaha/page_load');

		$('#limit').change(function(){
			pageLoad(1,'pengusaha/page_load');
		});

		$('#search').keyup(delay(function (e) {
			pageLoad(1,'pengusaha/page_load');
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
				search : $('#search').val(),
				graduated: 1,
				view: 'pengusaha/table_lulus'
			},
			success:function(response){
				$('#content-view').html(response);
			}
		})
	}

	$(document).on('click','#checkall',function(){
		if ($(this).is(':checked')) {
			$('.checklist').prop('checked',true);
		}else{
			$('.checklist').prop('checked',false);
		}
		
	})

	$(document).on('click', '.btn-restore', function(e) {
		e.preventDefault()
		let conf = confirm('Kamu yakin?')
		if(conf) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url("pengusaha/restore_kelulusan") ?>',
				dataType: 'JSON',
				data: {
					id:$(this).data('id'),
					graduated:$(this).data('graduated'),
					deleted:1
				},
				success: res => alert(res.msg),
				error:function(e) {
					console.error(e.responseText)
					return false
				}
			}).done(() => pageLoad(1,'pengusaha/page_load'))
		}
	})

	$(document).on('click', '#restore', function(e) {
		e.preventDefault()
		var totalChecked = $('.checklist:checked').length;
		var opsi = [];
		let conf;
		if (totalChecked > 0) {
			conf = confirm('Kamu yakin?')
			$(".checklist:checked").each(function(){
				opsi.push($(this).val());
			});
		}else{
			alert('Tidak ada yang dipilih!');
		}
		
		if(conf) {

			$.ajax({
				type: 'POST',
				url: '<?= base_url("pengusaha/multi_restore") ?>',
				dataType: 'JSON',
				data: {
					id:opsi,
					graduated:1,
					deleted:1
				},
				success: res => alert(res.msg),
				error:function(e) {
					alert('Something wrong!')
					console.error(e.responseText)
					return false
				}
			}).done(() => pageLoad(1,'pengusaha/page_load'))
		}

	})
</script>