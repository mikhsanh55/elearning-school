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
								<h2><strong>Data Nilai Tugas</strong></h2>
							</div>
							<?php if($this->log_lvl !== 'siswa') : ?>
							<section class="mt-2 detail-info">
								<h5>Nama Siswa : <?= $nama_siswa; ?></h5>
								<h5>Kelas : <?= $nama_kelas; ?> </h5>
								<h5>Mata Pelajaran : <?= $nama_mapel; ?> </h5>
							</section>
							<?php endif; ?>
						</div>
					</div>
					<from class="form-inline" style="display: block;">
						<div class="form-group">
							<label for="search">Search&nbsp;&nbsp;</label>
							<select id="filter" class="form-control input-sm">
								<?php foreach ($searchFilter as $key => $val): ?>
									<option value="<?=$key;?>"><?=$val;?></option>
								<?php endforeach; ?>
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
                <?php if($this->log_lvl == 'instansi' || $this->log_lvl == 'admin') : ?>
				<!-- <a href="<?=base_url('export/rekapitulasi') ?>" class="btn btn-sm btn-success"><i class="fas fa-file-excel-o"></i>&nbsp;Export Excel</a>
				<a target="_blank" href="<?= base_url('export/pdf_rekapitulasi') ?>" class="btn btn-sm btn-danger">
					<i class="fas fa-file-pdf-o">&nbsp;Export PDF</i>
				</a> -->
				<button data-href="<?=base_url('export/rekapitulasi') ?>" class="btn btn-sm btn-success" disabled><i class="fas fa-file-excel-o" ></i>&nbsp;Export Excel</button>
				<button data-target="_blank" href="<?= base_url('export/pdf_rekapitulasi') ?>" class="btn btn-sm btn-danger" disabled>
					<i class="fas fa-file-pdf-o">&nbsp;Export PDF</i>
				</button>
				<?php endif; ?>
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
		pageLoad(1,'tugas/page_load_nilai_tugas');

		$('#limit').change(function(){
			pageLoad(1,'tugas/page_load_nilai_tugas');
		});

		$('#search').keyup(delay(function (e) {
			pageLoad(1,'tugas/page_load_nilai_tugas');
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

	<?php if($this->log_lvl === 'siswa') { ?>
	function pageLoad(pg, url, search){
		$.ajax({
			type : 'post',
			url  : '<?php echo base_url() ?>' + url + '/' + pg,
			data :{
				pg    : pg,
				limit : $('#limit').val(),
				filter : $('#filter').val(),
				search : $('#search').val(),
				id_kelas : "<?= $id_kelas->id_kelas; ?>",
				id_mapel : "<?= $id_mapel; ?>"
			},
			success:function(response){
				$('#content-view').html(response);
			}
		})
	}
	<?php } else { ?>
	function pageLoad(pg, url, search){
		$.ajax({
			type : 'post',
			url  : '<?php echo base_url() ?>' + url + '/' + pg,
			data :{
				pg    : pg,
				limit : $('#limit').val(),
				filter : $('#filter').val(),
				search : $('#search').val(),
				id_kelas : "<?= $id_kelas; ?>",
				id_mapel : "<?= $id_mapel; ?>",
				id_siswa : "<?= $id_siswa; ?>"
			},
			success:function(response){
				$('#content-view').html(response);
			}
		})
	}
	<?php } ?>
</script>