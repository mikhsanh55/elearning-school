

<style type="text/css">
	.text-capitalize {
		text-transform: capitalize;
	}

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
		<div class="row">
			<div class="col-sm-12 col-md-6 col-lg-6">
				<h2><strong> Daftar <?= $this->name; ?></strong></h2>	
			</div>
			<div class="col-sm-12 col-md-6 col-lg-6 text-right">
				<a class="btn btn-light" onclick="window.history.back()">Kembali</a>
			</div>
		</div>
		<div id="accordion" class="panel-group">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-info">
						<div class="panel-heading">
							<div class="tombol-kanan">
								
							</div>
						</div>
					</div>
					<from class="form-inline" style="display: block;">
					<div class="form-group">
							<label for="search">Search&nbsp;&nbsp;</label>
							<div class="rs-select2 js-select-simple select--no-search">
								<select id="modal-filter" class="form-control input-sm">
									<?php foreach ($searchFilter as $key => $val): ?>
										<option value="<?=$key;?>"><?=$val;?></option>
									<?php endforeach ?>
								</select>
								<div class="select-dropdown"></div>
							</div>
							<input type="text" style="width: 50%;height:30px;" class="form-control input-sm" id="modal-search" placeholder="ketikan yang anda cari" name="search">
						</div>
					</from>
					<br>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				Limit 
				<select id="modal-limit">
					<option value="10">10</option>
					<option value="50">50</option>
					<option value="100">100</option>
				</select>
		
				<a class="btn btn-success btn-sm tombol-kanan" href="<?=base_url('kelas/add');?>"><i class="fa fa-user-plus"></i> &nbsp;Tambah</a>
				<a href="javascript:void(0);" title="edit" id="edited" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> &nbsp;Edit</a>
				<a href="javascript:void(0);" id="deleted" title="Hapus" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> &nbsp;Hapus</a>
				<a href="<?= base_url('export/kelas'); ?>" class="tombol-kanan btn btn-sm btn-success">
					<i class="fas fa-file-excel-o"> &nbsp;Export</i>
				</a>

		<!-- 		<a class="btn btn-warning btn-sm tombol-kanan" href="<?php echo base_url(); ?>upload/format_siswa.xlsx"><i class="fa fa-cloud-download" aria-hidden="true"></i> &nbsp;Download Format Import</a>
				<a class="btn btn-warning btn-sm tombol-kanan" href="<?php echo base_url(); ?>pengusaha/import"><i class="fa fa-cloud-upload" aria-hidden="true"></i> &nbsp;Import</a> -->
	
			
			
				<div id="content-view"></div>
			</div>
		</div>
	</div>

</div>
</div>

<!-- Modal -->
<div class="modal fade" id="listSiswaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-target=".bd-example-modal-sm">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Daftar Siswa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="daftar-siswa"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- <div class="modal fade" id="rekrut_murid" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" style="max-width:80%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 id="myModalLabel"></h4>
				<a href="javascripti:void(0);" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></a>
			</div>
			<div class="modal-body">
				<div id="daftar-murid"></div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-sm" data-dismiss="modal" aria-hidden="true"><i class="fa fa-minus-circle"></i> Tutup</button>
			</div>

		</div>
	</div>
</div> -->
<!--/.row-box End-->
<script src="<?= base_url(); ?>assets/js/jquery/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
	let html;
	function displaySiswa(self) {
		html = ''
		$('#listSiswaModal .modal-title').text('Daftar Siswa')
		$(self).prop('disabled', true).text('Loading...')
		$.ajax({
			type: 'POST',
			url  : '<?php echo base_url() ?>' + 'kelas/daftar_murid' + '/' + 1,
			data : {
				id : $(self).data('id'),
				id_kelas : $(self).data('id'),
			},
			success: function(res) {
				$(self).prop('disabled', false).text('Pilih Siswa')
				$('#daftar-siswa').html(res)		
				$('#listSiswaModal').modal('show')
			}			
		}).done(() => $('#listSiswaModal').modal('show'))
	}

	function displayMapel(self) {
		html = ''
		
		$(self).prop('disabled', true).text('Loading...')
		$.ajax({
			type: 'POST',
			url: "<?= base_url('kelas/daftar_mapel') ?>",
			data: {
				id_kelas: $(self).data('id'),
			},
			success: function(res) {
				$(self).prop('disabled', false).text('Pilih Mapel')
				$('#listSiswaModal .modal-title').text('Daftar Mata Pelajaran Kelas ')
				
				$('#listSiswaModal .modal-body #daftar-siswa').html(res)

			}
		}).done(() => {
			// $('#mapel-table').DataTable()
			$('#listSiswaModal').modal('show')
		})
	}

	$(document).ready(function(){
		pageLoad(1,'kelas/page_load');

		$(document).on('change','#modal-limit',function(){
			pageLoad(1,'kelas/page_load');
		});

		$('#limit').change(function(){
			pageLoad(1,'kelas/page_load');
		});

		$('#modal-search').keyup(delay(function (e) {
			pageLoad(1,'kelas/page_load');
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
				limit : $('#modal-limit').val(),
				filter : $('#modal-filter').val(),
				search : $('#modal-search').val()
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
				url : '<?=base_url('kelas/multi_delete');?>',
				dataType : 'json',
				data : {
					id : opsi,
				},
				success:function(response){
					if (response.result == true) {
						pageLoad(1,'kelas/page_load');
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
			window.location = base_url + 'kelas/edit/' + $('.checklist:checked').data('id');			
		}
	})

	$(document).on('click','.rekrut',function(){
		
		$.ajax({
			type : 'post',
			url  : '<?php echo base_url() ?>' + 'kelas/daftar_murid' + '/' + 1,
			data : {
				id : $(this).data('id'),
				id_jurusan : $(this).data('jurusan')
			},
			success:function(response){
				$('#daftar-murid').html(response);
			}
		})

		$('#rekrut_murid').modal('show');
	})


</script>




