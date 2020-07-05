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

	.only-number{
		width:20%;
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
								<h2><strong>Kurikulum</strong></h2>
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
							<input type="text" style="width: 50%;height:30px;" class="form-control input-sm" id="search" placeholder="ketikan yang anda cari" name="search">
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
				<?php if ($this->log_lvl == 'admin' || $this->log_lvl == 'instansi'): ?>
				
			<a class="btn btn-primary btn-sm tombol-kanan ml-2" href="#" onclick="return m_mapel_e(0);"><i class="fas fa-plus"></i> &nbsp;Tambah</a>
			<a href="<?= base_url('export/kurikulum'); ?>" class="tombol-kanan btn btn-success btn-sm ml-2">
				<i class="fas fa-file-excel-o"></i>&nbsp;Export
			</a>
	
				<?php endif ?>
			
				<div id="content-view"></div>
			</div>
		</div>
	</div>

</div>
</div>
<div class="modal fade" id="m_mapel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 id="myModalLabel">Data Mata Pelajaran</h4>
			</div>
			<div class="modal-body">
				<form name="f_mapel" id="f_mapel" onsubmit="return m_mapel_s();">
					<input type="hidden" name="id" id="id" value="0">
					<input type="hidden" name="instansi" value="<?= empty($this->akun->instansi) ? 1 : $this->akun->instansi; ?>" />
					<table class="table table-form">
						<tr>
							<td style="width: 25%">Kode Mata Pelajaran</td>
							<td style="width: 75%"><input type="text" class="form-control" name="kd_mp" id="kd_mp" required></td>
						</tr>
						<tr>
							<td style="width: 25%">Nama Mata Pelajaran</td>
							<td style="width: 75%"><input type="text" class="form-control" name="nama" id="nama" required></td>
						</tr>
						<!-- <tr>
							<td style="width: 25%">SKS</td>
							<td style="width: 75%"><input type="text" class="form-control only-number" name="sks" id="sks" maxlength="3" required></td>
						</tr> -->
						<!-- <tr>
							<td style="width: 25%">Semester</td>
							<td style="width: 75%"><input type="text" class="form-control only-number" name="semester" id="semester" maxlength="4" required></td>
						</tr>
						<tr>
							<td style="width: 25%">Angkatan</td>
							<td style="width: 75%"><input type="text" class="form-control only-number" name="angkatan" id="angkatan" maxlength="10" required></td>
						</tr> -->
						<!-- <tr>

							<td style="width: 25%"><?=$this->transTheme->instansi;?></td>
							<td style="width: 75%">
								<div class="rs-select2 js-select-simple select--no-search">
									<select name="instansi" id="instansi" style="width: 100%;">
										<option disabled="disabled" selected="selected">Pilih</option>
										<?php foreach ($instansi as $key => $rows): ?>
											<?php if ($this->log_lvl == 'admin'): ?>
												<option value="<?=$rows->id;?>" ><?=$rows->instansi;?></option>
											<?php else: ?>
												<option value="<?=$rows->id;?>" <?=($this->akun->instansi == $rows->id) ? 'selected' : NULL ;?> ><?=$rows->instansi;?></option>
											<?php endif ?>
											
										<?php endforeach ?>
									</select>
									<div class="select-dropdown"></div>
								</div>
							</td>
						</tr> -->
					</table>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>
				<button class="btn" data-dismiss="modal" aria-hidden="true"><i class="fa fa-minus-circle"></i> Tutup</button>
			</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade" id="modal_show" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 id="myModalLabel">Data Mata Pelajaran</h4>
			</div>
			<div class="modal-body">
				<div id="content_modals"></div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>
				<button class="btn" data-dismiss="modal" aria-hidden="true"><i class="fa fa-minus-circle"></i> Tutup</button>
			</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade" id="hapus_mapel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 id="myModalLabel">List Trainer</h4>
			</div>
			<div class="modal-body">
				<form name="f_mapel" id="f_mapel" onsubmit="return m_mapel_s();">
					<input type="hidden" name="id" id="id" value="0">
					<table class="table table-form">
						<tr>
							<td><input type="radio" name="aksi_hapus_modul" value="1"> </td>
							<td>Hapus semua Sub Mata Pelajaran</td>
						</tr>
						<!-- <tr>
						    <td><input type="radio" value="0" name="aksi_hapus_modul"> </td>
							<td>Pindahkan semua sub modul ke modul lain</td>
						</tr> -->
					</table>
					<p class="mt-2 mb-2 d-none" id="label-pindah-modul">Pindahkan sub mata pelajaran ke :</p>
					<select name="id_pindah_modul" class="d-none" id="select-ganti-modul">
					    
					</select>
			</div>
			<div class="modal-footer">
				<button class="btn btn-danger btn-sm" id="hapus-modul">Hapus Modul</button>
				<button class="btn btn-sm btn-primary" data-dismiss="modal" aria-hidden="true">Batal</button>
			</div>
			</form>
		</div>
	</div>
</div>


<!--/.row-box End-->
<script src="<?= base_url(); ?>assets/js/jquery/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		pageLoad(1,'dtest/page_load');

		$('#limit').change(function(){
			pageLoad(1,'dtest/page_load');
		});

		$('#search').keyup(delay(function (e) {
			pageLoad(1,'dtest/page_load');
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


	$(document).on('click','.lihat-trainer',function(){
		var mapel_id = $(this).data('id');
		$.ajax({
			type : 'post',
			url  : '<?=base_url('dtest/get_trainer_info');?>',
			dataType : 'json',
			data : {
				id : mapel_id,
			},
			success:function(response){
				html = '<ol>';
				var i = 1;
				$.each( response.trainer, function( key, rows ) {
					html += `<li>` + i + '.' +rows.nama_guru+ `</li>`;
					i++;
				});
				html += '</ol>';

				$('#modal_show').modal('show');
				$('#content_modals').html(html);
			}
		})
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
</script>


