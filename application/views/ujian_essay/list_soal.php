

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

	.label-isi{
		color: #000;
		line-height: 28px;
		padding-left:10px;
		border:1px solid #e8e8e8;
		border-radius:10px;
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
								<div class="row">
									<div class="col-sm-12 col-md-6 col-lg-6">
						                <h2><strong>Data <?=$this->page_title;?></strong></h2>
						            </div>
						            <div class="col-sm-12 col-md-6 col-lg-6 text-right">
						                <?= $this->backButton; ?>
						            </div>
					            </div>	
								
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 form-group">
							<label>Modul Pelatihan</label>
							<div class="label-isi" >
								<?=$ujian->nama_mapel;?>
								<div class="select-dropdown"></div>
							</div>
						</div>
						<div class="col-md-4 form-group">
							<label>Trainer</label>
							<div class="label-isi">
								<?=$ujian->nama_guru;?>
								<div class="select-dropdown"></div>
							</div>
						</div>
						<div class="col-md-4 form-group">
							<label>Tipe Ujian</label>
							<div class="label-isi">
								<?=strtoupper($ujian->type_ujian);?>
								<div class="select-dropdown"></div>
							</div>
						</div>
					</div>
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
				
				<?php if ($this->log_lvl != 'siswa'): ?>
					<a class="btn btn-success btn-sm tombol-kanan" href="<?=$url_form;?>"><i class="fa fa-user-plus"></i> &nbsp;Tambah</a>
					<a href="javascript:void(0);" title="edit" id="edited" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> &nbsp;Edit</a>
					<a href="javascript:void(0);" id="deleted" title="Hapus" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> &nbsp;Hapus</a>
					<!-- <a class="btn btn-warning btn-sm tombol-kanan" href="<?php echo base_url(); ?>upload/format_soal_download-1.xlsx" ><i class="glyphicon glyphicon-download"></i> &nbsp;&nbsp;Download Format Import</a>
					 <a class="btn btn-info btn-sm tombol-kanan" href="<?=$url_import;?>" ><i class="glyphicon glyphicon-upload"></i> &nbsp;&nbsp;Import Excel</a> -->

				<?php endif ?>
				
			
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
		pageLoad(1,'ujian_essay/page_load_soal');

		$('#limit,#tipe_ujian_essay').change(function(){
			pageLoad(1,'ujian_essay/page_load_soal');
		});

		$('#search').keyup(delay(function (e) {
			pageLoad(1,'ujian_essay/page_load_soal');
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
				tipe_ujian_essay : $('#tipe_ujian_essay').val(),
				id_ujian : '<?=$ujian->id;?>'
			},
			success:function(response){
				$('#content-view').html(response);
			}
		})
	}

	$(document).on('submit','#form-siswa',function(e){

		e.preventDefault()
		var f_asal	= $(this);
		var form	= getFormData((f_asal));
		$.ajax({		
			type: "POST",
			url: base_url+"pengusaha/m_siswa/simpan",
			data: JSON.stringify(form),
			dataType: 'json',
			contentType: 'application/json; charset=utf-8'
		}).done(function(response) {
			if (response.status == "ok") {
				pageLoad(1,'ujian_essay/page_load_soal');
			} else {
				alert(response.caption);
			}
		});
		$("#m_siswa_modif").modal('hide');
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
				url : '<?=base_url('ujian_essay/hapus_soal');?>',
				dataType : 'json',
				data : {
					id : opsi,
					link : '<?=$url_form;?>'
				},
				success:function(response){
					if (response.result == true) {
						alert('Hapus Berhasil');
					}else{
						alert('Hapus Gagal');
					}

					pageLoad(1,'ujian_essay/page_load_soal');
				}
			})


		}else{
			return false;
		}

		
	})

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
			window.location = '<?=$url_form;?>' + '/' + $('.checklist:checked').data('id');			
		}

		
	})

	$(document).on('click','.buat-pass',function(){
	
		var y = confirm('Apakah anda yakin untuk membuat password untuk nama ' + $(this).data('nama') +' ?');

		if (y == true) {

			$.ajax({
				type:'post',
				url : '<?=base_url('ujian_essay/buatkan_password');?>',
				dataType : 'json',
				data : {
					id : $(this).data('id'),
				},
				success:function(response){
					if (response.status == 1) {
						alert(response.message);
					}else{
						alert(response.message);
					}

					pageLoad(1,'ujian_essay/page_load_soal');
				}
			})


		}else{
			return false;
		}
	})

	$(document).on('click','.reset-pass',function(){
	
		var y = confirm('Apakah anda yakin untuk membuat password untuk nama ' + $(this).data('nama') +' ?');

		if (y == true) {

			$.ajax({
				type:'post',
				url : '<?=base_url('ujian_essay/reset_password');?>',
				dataType : 'json',
				data : {
					id : $(this).data('id'),
				},
				success:function(response){
					if (response.status == 1) {
						alert(response.message);
					}else{
						alert(response.message);
					}

					pageLoad(1,'ujian_essay/page_load_soal');
				}
			})


		}else{
			return false;
		}
	})

	$(document).on('click','.aktif-non-akun',function(){
	
		var y = confirm('Apakah anda yakin untuk membuat password untuk nama ' + $(this).data('nama') +' ?');

		if (y == true) {

			$.ajax({
				type:'post',
				url : '<?=base_url('ujian_essay/aktif_non_akun');?>',
				dataType : 'json',
				data : {
					id : $(this).data('id'),
					status : $(this).data('status')
				},
				success:function(response){
					if (response.status == 1) {
						alert(response.message);
					}else{
						alert(response.message);
					}

					pageLoad(1,'ujian_essay/page_load_soal');
				}
			})


		}else{
			return false;
		}
	})

</script>




