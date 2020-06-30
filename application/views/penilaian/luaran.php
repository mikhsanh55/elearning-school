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
								<h2><strong>Data Luaran Penilaian </strong></h2>
							</div>

						</div>

					</div>
<<<<<<< HEAD
=======
					<br>
>>>>>>> first push

				</div>

			</div>

		</div>
<<<<<<< HEAD
		<div class="row">
			<div class="col-md-12">
				<section id="export" class="mb-4">
					<a href="<?= base_url('export/penilaian') ?>" title="export semua" id="export-semua" class="btn btn-success btn-sm  ml-2">&nbsp;Export Semua</a>
					
				</section>
				<!-- Output 1 -->
				<section id="output1" class="mb-4">
					<h3>Data Rekapitulasi</h3>
					<form class="form-inline mb-4" style="display: block;">
						<div class="form-group">&nbsp;&nbsp;
							<label for="search">Search&nbsp;&nbsp;</label>
							<div class="rs-select2 js-select-simple select--no-search">
								<select id="filter1" class="form-control input-sm">
									<?php foreach ($searchFilter as $key => $val): ?>
										<option value="<?=$key;?>"><?=$val;?></option>
									<?php endforeach ?>
								</select>
								<div class="select-dropdown"></div>
							</div>
							&nbsp;&nbsp;
							<input type="text" style="width: 30%;height:30px;" class="form-control input-sm" id="search-output1" placeholder="ketikan yang anda cari" name="search">
						</div>
					</form>
					<span class="ml-2">Limit </span>
					<select class="limit" id="limit1">

						<option value="10">10</option>

						<option value="50">50</option>

						<option value="100">100</option>

					</select>
					<a href="<?= base_url('export/penilaian_output1') ?>" title="export" id="export" class="btn btn-primary btn-sm  ml-2">&nbsp;Export</a>
					<div id="content-view1"></div>

				</section>

				<!-- Output 2 -->
				<section id="output2" class="mb-4">
					<h3>Sebaran Jawaban</h3>
					<form class="form-inline mb-4" style="display: block;">
						<div class="form-group">&nbsp;&nbsp;
							<label for="search">Search&nbsp;&nbsp;</label>
							<div class="rs-select2 js-select-simple select--no-search">
								<select id="filter2" class="form-control input-sm">
									<?php foreach ($searchFilter as $key => $val): ?>
										<option value="<?=$key;?>"><?=$val;?></option>
									<?php endforeach ?>
								</select>
								<div class="select-dropdown"></div>
							</div>
							&nbsp;&nbsp;
							<input type="text" style="width: 30%;height:30px;" class="form-control input-sm" id="search-output2" placeholder="ketikan yang anda cari" name="search">
						</div>
					</form>
					<span class="ml-2">Limit </span>
					<select class="limit" id="limit2">

						<option value="10">10</option>

						<option value="50">50</option>

						<option value="100">100</option>

					</select>
					<a href="<?= base_url('export/penilaian_output2') ?>" title="export" id="export" class="btn btn-primary btn-sm  ml-2">&nbsp;Export</a>
					<div id="content-view2"></div>
				</section>

				<!-- Output 3 -->
				<section id="output3">
					<h3>Deskriptif Jawaban</h3>
					<form class="form-inline mb-4" style="display: block;">
						<div class="form-group">&nbsp;&nbsp;
							<label for="search">Search&nbsp;&nbsp;</label>
							<div class="rs-select2 js-select-simple select--no-search">
								<select id="filter3" class="form-control input-sm">
									<?php foreach ($searchFilter as $key => $val): ?>
										<option value="<?=$key;?>"><?=$val;?></option>
									<?php endforeach ?>
								</select>
								<div class="select-dropdown"></div>
							</div>
							&nbsp;&nbsp;
							<input type="text" style="width: 30%;height:30px;" class="form-control input-sm" id="search-output3" placeholder="ketikan yang anda cari" name="search">
						</div>
					</form>
					<span class="ml-2">Limit </span>
					<select class="limit" id="limit3">

						<option value="10">10</option>

						<option value="50">50</option>

						<option value="100">100</option>

					</select>
					<a href="<?= base_url('export/penilaian_output3') ?>" title="export" id="export" class="btn btn-primary btn-sm  ml-2">&nbsp;Export</a>
					<div id="content-view3"></div>
				</section>
			</div>
			
			<!-- Sesi Ranking Pengajar -->
			<section class="row container mt-4">
				<div class="col-sm-12">
					<h3>Ranking Pengajar</h3>
					<form action="" class="form-inline">
						<div class="form-group">
							<label for="search">Search&nbsp;&nbsp;</label>
							<div class="rs-select2 js-select-simple select--no-search">
								<select id="filter-ranking" class="form-control input-sm">
									<?php foreach ($searchFilterRanking as $key => $val): ?>
										<option value="<?=$key;?>"><?=$val;?></option>
									<?php endforeach ?>
								</select>
								<div class="select-dropdown"></div>
							</div>
							<input type="text" style="width: 50%;height:30px;" class="form-control input-sm" id="search-ranking" placeholder="ketikan yang anda cari" name="search">
						</div>
					</form>
				</div>
				<div class="col-sm-12 mt-4">
					Limit 
					<select id="limit-ranking">
						<option value="10">10</option>
						<option value="50">50</option>
						<option value="100">100</option>
					</select>
						<a class="btn btn-primary btn-sm tombol-kanan ml-2" href="<?=base_url('ranking/chart');?>"><i class="fa fa-bar-chart"></i> &nbsp;Grafik</a>
						<a class="btn btn-success btn-sm ml-2" id="export-ranking-pdf" target="_blank" href="<?= base_url('ranking/export_pdf') ?>"> <i class="fa fa-file-pdf-o mr-1"></i>&nbsp;Cetak Dokumen </a>
		
				
					<div id="content-view-ranking"></div>
				</div>
				
			</section>
			
			<!-- Chart -->
			<section class="container mt-4">
				<h3>Grafik Penilaian Pengajar</h3>
				<div id="accordion" class="panel-group">
					<canvas id="radar" width="1000" height="600"></canvas>
				</div>
				<div id="accordion" class="panel-group">
					<canvas id="myChart" width="1000" height="600"></canvas>
				</div>
			</section>
		</div>
		
=======

		<div class="row">
			<div class="col-md-12">
				<div id="content-view">
					<table class="table table-striped table-hover">
						<thead>
							<tr width="10">
								<th><i class="fas fa-circle"></i></th>
								<th class="text-left">Sub Menu</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td width="10">
									<i class="fas fa-print"></i>
								</td>
								<td>
									
										<a class="text-primary" href="<?= base_url('penilaian/output1'); ?>">
											Rekapitulasi
										</a>
									
								</td>
							</tr>
							<tr>
								<td width="10">
									<i class="fas fa-question-circle"></i>
								</td>
								<td>
									
										<a class="text-primary" href="<?= base_url('penilaian/output2'); ?>">
											Sebaran Jawaban
										</a>
									
								</td>
							</tr>
							<tr>
								<td width="10">
									<i class="fas fa-reply-all"></i>
								</td>
								<td>
									
										<a class="text-primary" href="<?= base_url('penilaian/output3'); ?>">
											Deskriptif Jawaban
										</a>
									
								</td>
							</tr>
							<tr>
								<td width="10">
									<i class="fas fa-line-chart"></i>
								</td>
								<td>
									
										<a class="text-primary" href="<?= base_url('ranking/chart'); ?>">
											Grafik
										</a>
									
								</td>
							</tr>
							<tr>
								<td width="10">
									<i class="fas fa-trophy"></i>
								</td>
								<td>
									
										<a class="text-primary" href="<?= base_url('ranking'); ?>">
											Ranking
										</a>
									
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

		</div>
>>>>>>> first push

	</div>



</div>

<<<<<<< HEAD
</div>

<script>
	let options = [
		{
			type: 'POST',
			url: "<?= base_url('penilaian/page_load_out1/1'); ?>",
			data: {
				pg: 1,
				limit: $('#limit1').val(),
				filter: $('#filter1').val(),
				search: $('#search-output1').val() ,
				tipe_penilaian: 1
			},
			success:function(res) {
				$('#content-view1').html(res)
			}
		},
		{
			type: 'POST',
			url: "<?= base_url('penilaian/page_load_out2'); ?>",
			data: {
				pg: 1,
				limit: $('#limit2').val(),
				filter: $('#filter2').val(),
				search: $('#search-output2').val() ,
				tipe_penilaian: 2
			},
			success:function(res) {
				$('#content-view2').html(res)
			}
		},
		{
			type: 'POST',
			url: "<?= base_url('penilaian/page_load_out3'); ?>",
			data: {
				pg: 1,
				limit: $('#limit3').val(),
				filter: $('#filter3').val(),
				search: $('#search-output3').val() ,
				tipe_penilaian: 3
			},
			success:function(res) {
				$('#content-view3').html(res)
			}
		},
		{
			type: 'POST',
			url  : '<?php echo base_url() ?>' + 'ranking/page_load',
			data :{
				pg    : 1,
				limit : $('#limit-ranking').val(),
				filter : $('#filter-ranking').val(),
				search : $('#search-ranking').val()
			},
			success:function(response){
				$('#content-view-ranking').html(response);
			}

		}
	]

	function createFormData(obj) {
		var formData = new FormData()
		for(const [key, val] of Object.entries(obj)) {
			formData.append(key, val)
		}

		return formData
	}

	function fetchData() {
		let i = -1
		const allRequests = urls.map(url => {
			i++
			fetch(url, options[i]).then(res => res)
		})

		return Promise.all(allRequests)
	}

	function page_load_all(options) {
		var datas = []

		for(let x = 0;x < options.length;x++) {
			$.ajax(options[x])
		}
	}

	function pageLoadRanking(pg, url, search) {
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
				$('#content-view-ranking').html(response);
			}
		})
	}

	function pageLoad(pg, url, search) {
		$.ajax({
			type : 'post',
			url  : '<?php echo base_url() ?>' + url + '/' + pg,
			data :{
				pg    : pg,
				limit : $('#limit-ranking').val(),
				filter : $('#filter-ranking').val(),
				search : $('#search-ranking').val()
			},
			success:function(response){
				$('#content-view-ranking').html(response);
			}
		})
	}

	function pageLoad1(pg, url, search){

		$.ajax({

			type : 'post',

			url  : '<?php echo base_url() ?>' + url + '/' + pg,

			data :{

				pg    : pg,

				limit : $('#limit1').val(),

				filter : $('#filter1').val(),

				search : $('#search-output1').val(),

				tipe_penilaian : $('#tipe_penilaian').val()

			},

			success:function(response){

				$('#content-view1').html(response);

			}

		})
	}

	function pageLoad2(pg, url, search){

		$.ajax({

			type : 'post',

			url  : '<?php echo base_url() ?>' + url + '/' + pg,

			data :{

				pg    : pg,

				limit : $('#limit2').val(),

				filter : $('#filter2').val(),

				search : $('#search-output2').val(),

				tipe_penilaian : $('#tipe_penilaian').val()

			},

			success:function(response){

				$('#content-view2').html(response);

			}

		})
	}

	function pageLoad3(pg, url, search){

		$.ajax({

			type : 'post',

			url  : '<?php echo base_url() ?>' + url + '/' + pg,

			data :{

				pg    : pg,

				limit : $('#limit3').val(),

				filter : $('#filter3').val(),

				search : $('#search-output3').val(),

				tipe_penilaian : $('#tipe_penilaian').val()

			},

			success:function(response){

				$('#content-view3').html(response);

			}

		})
	}

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

	$(document).ready(function() {
		$('.data-table').DataTable()
		page_load_all(options)

		$('#limit1').change(function(){

			pageLoad1(1,'penilaian/page_load_out1');

		});
		$('#limit2').change(function(){

			pageLoad2(1,'penilaian/page_load_out2');

		});
		$('#limit3').change(function(){

			pageLoad3(1,'penilaian/page_load_out3');

		});

		$('#limit-ranking').change(function(){
			pageLoadRanking(1,'ranking/page_load');
		});

		$('#search-output1').keyup(delay(function (e) {
			pageLoad1(1,'penilaian/page_load_out1');
		}, 500));
		$('#search-output2').keyup(delay(function (e) {
			pageLoad2(1,'penilaian/page_load_out2');
		}, 500));
		$('#search-output3').keyup(delay(function (e) {
			pageLoad3(1,'penilaian/page_load_out3');
		}, 500));

		$('#search-ranking').keyup(delay(function (e) {
			pageLoadRanking(1,'ranking/page_load');
		}, 500));

		var setBg = () =>  '#' + Math.floor(Math.random()*16777215).toString(16);
	    var ctx = document.getElementById('myChart').getContext('2d');
	    
	    var backgroundColors = [], labels = <?=json_encode($label);?>;

	    for(let i = 0;i < labels.length;i++) {
	        backgroundColors.push(setBg());
	    }

	    var chart = new Chart(ctx, {
	    type: 'bar',
	    data: {
	        labels: <?=json_encode($label);?>,
	        datasets: [{
	            label: 'Nilai',
	            backgroundColor: backgroundColors,
	            borderColor: '#93C3D2',
	            data: <?=json_encode($skor);?>
	        }]
	    },
	    options: {
	        title: {
	            display: true,
	            text: 'Grafik Penilaian Pengajar'
	        },
	        scales: {
	            yAxes: [{
	            scaleLabel: {
	                display: true,
	                labelString: 'Skor'
	            }
	            }]
	        }     
	    }
	});


	var marksCanvas = document.getElementById("radar");

	var marksData = {
	  labels: <?=json_encode($label2);?>,
	  datasets: [{
	    label: "Nilai",
	    backgroundColor: backgroundColors,
	    data: <?=json_encode($bobot);?>
	  }]
	};

	var radarChart = new Chart(marksCanvas, {
	  type: 'radar',
	  data: marksData
	});
	})
</script>
=======
</div>
>>>>>>> first push
