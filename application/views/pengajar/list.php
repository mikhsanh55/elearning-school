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
								<h2><strong>Data <?=$this->page_title;?></strong></h2>
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
				<?php if ($this->log_lvl == 'admin' || $this->log_lvl == 'instansi' || $this->session->userdata('admin_level') == "admin_instansi"): ?>
				
				<a class="btn btn-success btn-sm tombol-kanan" href="#" onclick="return m_guru_e(0);"><i class="fa fa-user-plus"></i> &nbsp;Tambah</a>
				<a href="javascript:void(0);" title="edit" id="edited" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> &nbsp;Edit</a>
				<a href="javascript:void(0);" id="deleted" title="Hapus" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> &nbsp;Hapus</a>

				<a class="btn btn-warning btn-sm tombol-kanan" href="<?php echo base_url(); ?>upload/format_import_pengajar.xlsx"><i class="fa fa-cloud-download" aria-hidden="true"></i> &nbsp;Download Format Import</a>
				<a class="btn btn-warning btn-sm tombol-kanan" href="<?php echo base_url('trainer/import/'); ?>"><i class="fa fa-cloud-upload" aria-hidden="true"></i> &nbsp;Import</a>

				<a href="<?=base_url('export/pengajar') ?>" class="btn btn-sm btn-success"><i class="fas fa-file-excel-o"></i>&nbsp;Export</a>
	
				<?php endif ?>
			
				<div id="content-view"></div>
			</div>
		</div>
	</div>

</div>
</div>
<!-- Mapel Modal -->
<div class="modal fade" id="modalMapel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Mata Pelajaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="list-mapel">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal CRUD -->
<div class="modal fade" id="m_siswa_modif" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-sm" style="max-width: 600px;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 id="myModalLabel">Data <?=$this->page_title;?></h4>
			</div>
			<div class="modal-body">
					<form name="f_guru" id="f_guru" enctype="multipart/form-data">
					
					<table class="table table-form w-100">
					<input type="hidden" name="id" id="id" value="0">

						

						<!-- <tr>
							<td style="width: 25%">Tahun Akademik</td>
							<td style="width: 75%"><input type="text" class="form-control" name="ta" id="ta" required></td>
						</tr> -->
						<tr>
							<td style="width: 25%">NUPTK</td>
							<td style="width: 75%"><input type="text" class="form-control" name="nidn" id="nidn" placeholder="contoh: 1283749209287387" ></td>
						</tr>
						<tr>
							<td style="width: 25%">NIP</td>
							<td style="width: 75%"><input type="text" class="form-control" name="nrp" id="nrp" ></td>
						</tr>
						<tr>
							<td style="width: 25%">Nama Guru<span class="text-danger">*</span></td>
							<td style="width: 75%"><input type="text" class="form-control" name="nama" id="nama" required></td>
						</tr>
						<tr>
							<td style="width: 25%">Username<span class="text-danger">*</span></td>
							<td style="width: 75%"><input type="text" class="form-control" name="username" id="username" required></td>
						</tr>
						<tr>
							<td style="width: 25%">Mata Pelajaran<span class="text-danger">*</span></td>
							<td style="width: 75%">
								<div class="dropdown show">
								  <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width:100%;text-align: left;">
								    Pilih Mata Pelajaran
								  </a>
									<div class="dropdown-menu" aria-labelledby="dropdownMenuLink" id="mapel-list-input">
										<?php foreach($mapel as $row) : ?>
											<div>
											<input type="checkbox" name="mapel[]" value="<?= $row->id; ?>"
									    	> <span class="ml-1"><?= $row->nama; ?></span>
									    	</div>
										<?php endforeach; ?>
									</div>
								</div>
								<!-- <select name="mapel" id="mapel" required class="form-control">
									<option value="0">Belum Ada</option>
									<?php foreach($mapel as $row) : ?>
										<option value="<?= $row->id; ?>"><?= ucwords($row->nama); ?></option>
									<?php endforeach; ?>
								</select> -->
							</td>
						</tr>
						
						
						
						<tr>
							<td style="width: 25%">Email</td>
							<td style="width: 75%"><input type="text" class="form-control" name="email" id="email" ></td>
						</tr>
						<tr>
							<td style="width: 25%">No. Telpon<span class="text-danger">*</span></td>
							<td style="width: 75%"><input type="text" class="form-control only-number" name="telp" id="telp" required></td>
						</tr>
						
					</table>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Simpan</button>
				<button class="btn btn-sm" data-dismiss="modal" aria-hidden="true"><i class="fa fa-minus-circle"></i> Tutup</button>
			</div>
			</form>
		</div>
	</div>
</div>
<!--/.row-box End-->
<script src="<?= base_url(); ?>assets/js/jquery/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
	let html;
	function displayMapel(self) {
		html = ''
		$(self).prop('disabled', true).text('Loading...')
		$.ajax({
			type: 'post',
			url: '<?= base_url('trainer/get_mapel') ?>',
			data: {
				id: $(self).data('id')
			},
			dataType: 'JSON',
			success: function(res) {
				$(self).prop('disabled', false).text('Mata Pelajaran')
				html += `
					<ul class="list-group">
				`
				if(res.data.length > 0) {
					res.data.forEach((item, i) => {
						html += `<li class="list-group-item">${item.nama_mapel}</li>`
					})
				}
				else {
					html += `<li class="list-group-item text-center">Data Kosong</li>`
				}

				html += `</ul>`
				$('#list-mapel').html(html)
			}
		}).done(() => $('#modalMapel').modal('show'))
	}
	$(document).ready(function(){
		pageLoad(1,'trainer/page_load');

		$('#limit').change(function(){
			pageLoad(1,'trainer/page_load');
		});

		$('#search').keyup(delay(function (e) {
			pageLoad(1,'trainer/page_load');
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

	$(document).on('submit','#f_guru',function(e){

		e.preventDefault()
		var f_asal	= $(this);
		var form	= getFormData((f_asal));
		$.ajax({		
			type: "POST",
			url: base_url+"trainer/m_guru/simpan",
			data: $(this).serialize(),
			dataType: 'json',
		}).done(function(response) {
			if (response.status == "ok") {
				pageLoad(1,'trainer/page_load');
				$("#m_siswa_modif").modal('hide');
			} else {
				alert(response.caption);
			}
		});
		
	})


	$(document).on('click','#checkall',function(){
		if ($(this).is(':checked')) {
			$('.checklist').prop('checked',true);
		}else{
			$('.checklist').prop('checked',false);
		}
		
	})


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
				url : '<?=base_url('trainer/multi_delete');?>',
				dataType : 'json',
				data : {
					id : opsi,
				},
				success:function(response){
					if (response.result == true) {
						pageLoad(1,'trainer/page_load');
					}else{
						alert('Hapus Gagal');
					}

					
				}
			})


		}else{
			return false;
		}

		
	})

	

	$(document).on('click','#edited',function(){
		html = ''
		var totalChecked = $('.checklist:checked').length;
		var opsi = [];

		if (totalChecked > 1) {
			alert('Pilih satu untuk edit  !');
			return false;
		}else if(totalChecked < 1){
			alert('Tidak ada yang dipilih!');
			return false;
		}else{
			$('#m_siswa_modif').modal({backdrop: 'static', keyboard: false}) 
			 var id = $('.checklist:checked').val();
			 $.ajax({
			 	type: "GET",
			 	url: base_url+"trainer/m_guru/det/"+id,
			 	success: function(res) {
			 		$("#id").val(res.data.id);
			 		$("#ta").val(res.data.tahun_akademik);
			 		$("#nidn").val(res.data.nidn);
			 		$("#username").val(res.data.username);
			 		$("#nrp").val(res.data.nrp);
			 		$("#nama").val(res.data.nama);
			 		$("#pangkat").val(res.data.pangkat);
			 		$("#ja").val(res.data.jabatan_akademik);
			 		$("#tempat").val(res.data.tempat_lahir);
			 		$("#tanggal").val(res.data.tanggal_lahir);
			 		$("#alamat").val(res.data.alamat);
			 		$("#email").val(res.data.email);
			 		$("#telp").val(res.data.no_telpon);
			 		$("#status").val(res.data.status);
			 		$("#instansi").val(res.data.instansi);
			 		$("#put").val(res.data.pendidikan_umum_terakhir);
			 		$("#pmt").val(res.data.pendidikan_militer_terakhir);
			 		$("#semester").val(res.data.semester);
			 		$("#ta").focus();
			 		$('#mapel-list-input').html(res.opsi)
				 		
			 		
			 	}
			 });
		}

		
	})

</script>


