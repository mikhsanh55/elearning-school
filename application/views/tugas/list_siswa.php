

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
								<h2><strong>Tugas</strong></h2>
							</div>
							<div class="row">
							<div class="col-md-6 form-group">
								<label>Wali Kelas</label>
								<div class="label-isi" >
									<?=$kelas->nama_guru;?>
									<div class="select-dropdown"></div>
								</div>
							</div>
							<div class="col-md-6 form-group">
								<label>Kelas</label>
								<div class="label-isi" >
									<?=$kelas->nama;?>
									<div class="select-dropdown"></div>
								</div>
							</div>

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
				<a href="<?= base_url('export/pdf_list_tugas_siswa/') . encrypt_url($kelas->id); ?>" class="btn btn-sm btn-danger">
					<i class="fas fa-file-pdf-o"></i>&nbsp; Export ke PDF
				</a>
				<a href="<?= base_url('export/list_tugas_siswa/') . encrypt_url($kelas->id); ?>" class="btn btn-sm btn-success">
					<i class="fas fa-file-excel-o"></i>&nbsp; Export ke Excel
				</a>
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
		pageLoad(1,'tugas/page_load_kelas');

		$('#limit').change(function(){
			pageLoad(1,'tugas/page_load_kelas');
		});

		$('#filter').change(function(){
			pageLoad(1,'tugas/page_load_kelas');
		})

		$('#search').keyup(delay(function (e) {
			pageLoad(1,'tugas/page_load_kelas');
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

		$(document).on('keydown','.beri-nilai',delay(function(evt){
			var nilai = $(this).val();

			if(nilai > 100){
				nilai = 100;
			}else if(nilai == ''){
				nilai = 0;
			}

			if(evt.keyCode == 13) {
				$.ajax({
					type : 'post',
					url  : base_url + 'tugas/beri_nilai',
					dataType : 'json',
					data : {
						nilai : nilai,
						id_siswa : $(this).data('siswa'),
						id_tugas : $(this).data('tugas')
					},
					success:function(response){
						alert('Nilai Siswa berhasil dimasukan')
					}
				});
			}
				

			$(this).val(nilai);
		}, 500))


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
				id_kelas : '<?=$tugas->id_kelas;?>',
				id_tugas : '<?=$tugas->id;?>'
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
			url: base_url+"tugas/m_siswa/simpan",
			data: JSON.stringify(form),
			dataType: 'json',
			contentType: 'application/json; charset=utf-8'
		}).done(function(response) {
			if (response.status == "ok") {
				pageLoad(1,'tugas/page_load_kelas');
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
				url : '<?=base_url('tugas/multi_delete');?>',
				dataType : 'json',
				data : {
					id : opsi,
				},
				success:function(response){
					if (response.result == true) {
						pageLoad(1,'tugas/page_load_kelas');
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
		var totalChecked = $('.checklist:checked').length;
		var opsi = [];

		if (totalChecked > 1) {
			alert('Pilih satu untuk edit  !');
			return false;
		}else if(totalChecked < 1){
			alert('Tidak ada yang dipilih!');
			return false;
		}else{
			window.location = base_url + 'tugas/edit/' + $('.checklist:checked').data('id');
		}

		
	})

	$(document).on('click','.detail-tugas',function(){
			window.location = base_url + 'tugas/lampiran_detail/' + $(this).data('id_tugas') + '/' + $(this).data('id_siswa');
	})



</script>




