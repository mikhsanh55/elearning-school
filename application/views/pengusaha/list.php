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
								<h2><strong>Data <?= ucfirst($this->transTheme->siswa);?></strong></h2>
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
		
				<a class="btn btn-success btn-sm tombol-kanan" href="#" onclick="return m_siswa_add();"><i class="fa fa-user-plus"></i> &nbsp;Tambah</a>
				<a href="javascript:void(0);" title="edit" id="edited" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> &nbsp;Edit</a>
				<a href="javascript:void(0);" id="deleted" title="Hapus" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> &nbsp;Hapus</a>

				<a class="btn btn-warning btn-sm tombol-kanan" href="<?php echo base_url(); ?>upload/format_siswa_baru.xlsx"><i class="fa fa-cloud-download" aria-hidden="true"></i> &nbsp;Download Format Import</a>
				<a class="btn btn-warning btn-sm tombol-kanan" href="<?php echo base_url(); ?>pengusaha/import"><i class="fa fa-cloud-upload" aria-hidden="true"></i> &nbsp;Import</a>
				<a class="btn btn-success btn-sm tombol-kanan" href="<?php echo base_url('export/siswa'); ?>"><i class="fa fa-file-excel-o" aria-hidden="true"></i> &nbsp;Export</a>
				<a class="btn btn-success btn-sm tombol-kanan" href="javascript:void(0);" id="riwayat" title="Riwayatkan"><i class="fa fa-check" aria-hidden="true"></i> &nbsp;Riwayatkan Kelulusan</a>
	
			
			
				<div id="content-view"></div>
			</div>
		</div>
	</div>

</div>
</div>

<div class="modal fade" id="m_siswa_modif" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-sm" style="max-width: 500px;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 id="myModalLabel">Data <?=$this->transTheme->siswa;?></h4>
			</div>
			<div class="modal-body">
				<form action="" method="post" id="form-siswa" enctype="multipart/form-data">
					<input type="hidden" name="id" id="id" value="0">
					<table class="table table-form">
						<tr>
							<td style="width: 25%">Nama Lengkap<span class="text-danger">*</span> </td>
							<td style="width: 75%"><input type="text" class="form-control" name="nama" id="nama" required></td>
						</tr>
						<tr>
							<td style="width: 25%">Username<span class="text-danger">*</span></td>
							<td style="width: 75%"><input type="text" class="form-control" name="username" id="username" required></td>
						</tr>
						<tr>
							<td style="width: 25%">NISN<span class="text-danger">*</span></td>
							<td style="width: 75%"><input type="text" class="form-control" name="nrp" id="nrp" required></td>
						</tr>
						<!-- <tr>
							<td style="width: 25%">Kelas<span class="text-danger">*</span></td>
							<td>
								<select name="id_kelas" id="id_kelas" class="form-control" required>
									<option value="0">Belum Ada</option>
								    <?php foreach($kelas as $rows) : ?>
								        <option value="<?= $rows->id; ?>"><?= $rows->nama; ?></option>
								    <?php endforeach; ?>
								</select>
							</td>
						</tr> -->
						

						<tr>
							<td style="width: 25%">No.Telp/Hp</td>
							<td style="width: 75%"><input type="text" class="form-control only-number" name="telp" id="telp" ></td>
						</tr>
						
						<tr>
							<td style="width: 25%">Jenis Kelamin<span class="text-danger">*</span></td>
							<td style="width: 75%">
								<select name="nik" id="nik" class="form-control" required>
									<option value="L" selected>Laki-Laki</option>
									<option value="P">Perempuan</option>
								</select>
							</td>
						</tr>
						<tr>
							<td style="width: 25%">E-mail</td>
							<td style="width: 75%"><input type="text" class="form-control" name="email" id="email" ></td>
						</tr>
						<tr>
							<td style="width: 25%">Alamat</td>
							<td style="width: 75%"><textarea type="text" class="form-control" name="alamat" id="alamat" ></textarea></td>
						</tr>
						</table>
					</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary btn-sm" ><i class="fa fa-check"></i> Simpan</button>
				<button class="btn btn-sm" data-dismiss="modal" aria-hidden="true"><i class="fa fa-minus-circle"></i> Tutup</button>
			</div>
			</form>
		</div>
	</div>
</div>
<!--/.row-box End-->
<script src="<?= base_url(); ?>assets/js/jquery/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		let i, elementsId = [];
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

	function emptyAllInput() {
		i = 0;
		elementsId = ['id', 'kelompok', 'nama', 'username', 'pangkat', 'nrp', 'telp', 'tempat', 'tanggal', 'nim', 'nik', 'email', 'alamat', 'instansi', 'tahun_angkatan_masuk'];
		for(i  = 0;i < elementsId.length;i++) {
			$('#' + elementsId[i]).val('');
			if(elementsId === 'nama') {
				$('#nama').focus();
			}
		}
	}

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

	$(document).on('submit','#form-siswa',function(e){

		e.preventDefault()

		$.ajax({		
			type: "POST",
			url: base_url+"pengusaha/m_siswa/simpan",
            data:new FormData(this),
			dataType: 'json',
			processData:false,
            contentType:false,
            cache:false,
            async:false,
		}).done(function(response) {
			if (response.status == "ok") {
				pageLoad(1,'pengusaha/page_load');
				$("#m_siswa_modif").modal('hide');
			} else {
				alert(response.caption);
			}
		});
		
	})
    
    $(document).on('click', '#riwayat', function() {
        var totalChecked = $('.checklist:checked').length;
		var opsi = [];

		if (totalChecked > 0) {
			var y = confirm('Apakah anda yakin ?');
			$(".checklist:checked").each(function(){
				opsi.push($(this).val());
			});
			
			if(y) {
			    $.ajax({
    				type: 'POST',
    				url: '<?= base_url("pengusaha/multi_restore") ?>',
    				dataType: 'JSON',
    				data: {
    					id:opsi,
    					graduated:0,
    					deleted:0
    				},
    				success: res => alert(res.msg),
    				error:function(e) {
    					alert('Something wrong!')
    					console.error(e.responseText)
    					return false
    				}
    			}).done(() => pageLoad(1,'pengusaha/page_load'))
			    
			}
			
		}else{
			alert('Tidak ada yang dipilih!');
		}

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
				url : '<?=base_url('pengusaha/multi_delete');?>',
				dataType : 'json',
				data : {
					id : opsi,
				},
				success:function(response){
					if (response.result == true) {
						alert('Hapus Berhasil');
					}else{
						alert('Hapus Gagal');
					}

					pageLoad(1,'pengusaha/page_load');
				}
			})


		}else{
			return false;
		}

		
	})

	

	$(document).on('click','#edited',function(){
		emptyAllInput();
		var totalChecked = $('.checklist:checked').length;
		var opsi = [];

		if (totalChecked > 1) {
			alert('Pilih satu untuk edit  !');
			return false;
		}else if(totalChecked < 1){
			alert('Tidak ada yang dipilih!');
			return false;
		}else{
			$("#m_siswa_modif").modal('show');
			 var id = $('.checklist:checked').val();
				$.ajax({
					type: "GET",
					url: base_url+"pengusaha/detail_siswa/"+id,
					dataType : 'json',
					success: function(response) {
					    
						if (response.data != null) {
							$("#id").val(response.data.id);
							$("#kelompok").val(response.data.kelompok);
							$("#nama").val(response.data.nama);
							$("#username").val(response.data.username);
							$("#pangkat").val(response.data.pangkat);			
							$("#nrp").val(response.data.nrp);
							$("#telp").val(response.data.no_telpon);
							$("#tempat").val(response.data.tempat_lahir);
							$("#tanggal").val(response.data.tanggal_lahir);
							$("#nim").val(response.data.nim);
							// var jk =  == 'L' ? 1 : 0;
							$("#nik").val(response.data.nik);
							$("#email").val(response.data.email);
							$("#alamat").val(response.data.alamat);
							$("#instansi").val(response.data.instansi);
							// $("#id_kelas").val(response.data.id_kelas);
							$("#tahun_angkatan_masuk").val(response.data.tahun_angkatan_masuk);
							// $("#angkatan").val(response.data.angkatan)
							$("#nama").focus();
							if(response.data.photo != null){
								$('#photo_before').val(response.data.photo);
								$('#photo-txt').html('<img src="<?=base_url('upload/siswa_photo/');?>'+ response.data.photo +'" width="auto" height="50">');
							}
						}
					    
						
					}
				});
	
		}

		
	})

	function m_siswa_add() {
		$("#m_siswa_modif").modal('show');

		$("#id").val('');
		$("#kelompok").val('');
		$("#nama").val('');
		$("#username").val('');
		$("#pangkat").val('');			
		$("#nrp").val('');
		$("#telp").val('');
		$("#tempat").val('');
		$("#tanggal").val('');
		$("#nim").val('');
		$("#nik").val('');
		$("#email").val('');
		$("#alamat").val('');
		$("#id_kelas").val('');
		$("#tahun_angkatan_masuk").val('');
		// $("#angkatan").val('');
		$("#nama").focus();

		$('#photo_before').val('');
		$('#photo-txt').html('');
	
	return false;
}

</script>




