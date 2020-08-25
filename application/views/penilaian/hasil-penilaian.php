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
								<h2><strong>Data Hasil Penilaian <?= $penilaian->nama_ujian; ?> </strong></h2>
							</div>
						</div>
					</div>
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
					<!-- <a class="btn btn-success btn-sm tombol-kanan ml-2" href="<?=base_url('penilaian/add');?>"><i class="fa fa-user-plus"></i> &nbsp;Tambah</a>

					<a href="javascript:void(0);" title="edit" id="edited" class="btn btn-primary btn-sm  ml-2"><i class="fas fa-edit"></i> &nbsp;Edit</a>

					<a href="javascript:void(0);" id="deleted" title="Hapus" class="btn btn-danger btn-sm ml-2"><i class="fas fa-trash-alt"></i> &nbsp;Hapus</a>
					
					<a href="<?= base_url('ranking') ?>" title="Ranking & Grafik" class="btn btn-primary btn-sm ml-2"><i class="fa fa-line-chart"></i> &nbsp;Ranking & Grafik</a> -->
					<!-- <div class="dropdown d-inline-block ml-2">
					  <button class="btn btn-sm btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    Download Laporan EDOPM
					  </button>
					  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					    <a class="dropdown-item" href="<?= base_url('penilaian/output1') ?>">Output 1</a>
					    <a class="dropdown-item" href="<?= base_url('penilaian/output2') ?>">Output 2</a>
					    <a class="dropdown-item" href="#">Output 3</a>
					  </div>
					</div> -->
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
		pageLoad(1,'penilaian/load-hasil-penilaian');

		$('#limit,#tipe_penilaian').change(function(){
			pageLoad(1,'penilaian/load-hasil-penilaian');
		});

		$('#search').keyup(delay(function (e) {
			pageLoad(1,'penilaian/load-hasil-penilaian');
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
	});

	function pageLoad(pg, url, search){
		$.ajax({
			type : 'post',
			url  : '<?php echo base_url() ?>' + url + '/' + pg,
			data :{
				pg    : pg,
				limit : $('#limit').val(),
				filter : $('#filter').val(),
				search : $('#search').val(),
				id_penilaian: "<?= $id_penilaian; ?>"
			},
			success:function(response){
				$('#content-view').html(response);
			}
		});
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
		} else {
			alert('Tidak ada yang dipilih!');
		}
		if (y == true) {
			$.ajax({
				type:'post',
				url : '<?=base_url('penilaian/multi_delete');?>',
				dataType : 'json',
				data : {
					id : opsi,
				},
				success:function(response){
					if (response.result == true) {
						pageLoad(1,'penilaian/load-hasil-penilaian');
					} else {
						alert('Hapus Gagal');
					}
					pageLoad(1,'penilaian/load-hasil-penilaian');
				}
			});
		} else {
			return false;
		}
	});
</script>