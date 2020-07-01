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
					<br>

				</div>

			</div>

		</div>

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

	</div>



</div>

</div>