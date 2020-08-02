

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

	 @keyframes rot {
	    0% {
	        transform:rotate(0deg);
	    }
	    100% {
	        transform:rotate(360deg);
	    }
	}
	.spin-icon {
	    animation:rot 1s linear infinite;   
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
								<h2><strong>Aktivitas <?= $data_siswa->nama; ?></strong></h2>
							</div>
						</div>
					</div>
					<form style="display: block;" id="filter-aktivitas">
						<section class="form-row">
							<div class="form-group col-md-5 col-sm-12">
								<label for="search">Dari&nbsp;&nbsp;</label>
								<input type="date" name="date1" class="form-control" />
							</div>
							<div class="form-group col-md-5 col-sm-12">
								<label for="search">Sampai&nbsp;&nbsp;</label>
								<input type="date" name="date2" class="form-control" />
							</div>
							<div class="form-group col-md-2 col-sm-12">
								<label for="" style="visibility: hidden;">d</label>
								<button type="submit" id="filter-btn" class="btn btn-block btn-success">	<span>Filter</span>
									<i class="fas fa-spinner spin-icon d-none"></i>
								</button>	
							</div>
						</section>
					</form>
					<br>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
			<table class="table table-borderless">
			<?php if(count($datas) > 0) { ?>
				<?php foreach($datas as $data) : ?>
					<tr>
						<td style="width: 3%;">
							<i class="fas fa-circle <?= $data->type == 'login' ? 'text-primary' : ($data->type === 'logout' ? 'text-danger' : ''); ?> "></i>
						</td>
						<td class="text-left">
							<?= ucfirst($data->type) ?> pada <?= date_format(date_create($data->datetime), "d-m-Y"); ?> jam <?= date_format(date_create($data->datetime), "H:i:s"); ?>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php } else { ?>
				<tr>
					<td class="text-center" colspan="2">
						Belum ada aktivitas
					</td>
				</tr>
			<?php } ?>
			</table>
			</div>
		</div>
	</div>

</div>
</div>
<script>
	$(document).ready(function() {
		$('#filter-aktivitas').on('submit', function(e) {
			e.preventDefault()
			$('#filter-btn').prop('disabled', true);
			// Start ajax loading
			$('#filter-btn').find('span').toggleClass('d-none');
			$('#filter-btn').find('.fa-spinner').toggleClass('d-none');

			$.ajax({
				type: 'post',
				url: '<?= base_url('aktivitas/filter_aktivitas') ?>',
				data: $(this).serialize(),
				dataType: 'json',
				success: function(res) {
					$('#filter-btn').prop('disabled', false);
					// End ajax loading
					$('#filter-btn').find('span').toggleClass('d-none');
					$('#filter-btn').find('.fa-spinner').toggleClass('d-none');
					if(res.status) {
						$('table').html(res.data);	
					}
					
				}
			})

		})
	})
</script>