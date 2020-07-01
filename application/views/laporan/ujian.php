</aside>
</div>
<style type="text/css">
	@keyframes roll {
		0% {
			transform: rotate(0deg) scale(.5);
		}
		50% {
			transform: rotate(180deg) scale(1);
		}
		100% {
			transform: rotate(360deg) scale(.5);
		}
	}
	.fa-spinner {
		animation-name: roll;
		animation-duration: .6s;
		animation-timing-function: linear;
		animation-iteration-count: infinite;
	}
</style>
<div class="col-md-9 page-content">
	<div class="inner-box">
		<div id="accordion" class="panel-group">
			<header class="mb-4 mt-4"><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
				<form class="d-flex w-50">
					<label class="mr-3 align-middle">Filter</label>
					<input type="date" name="date1" class="form-control mr-4">
					<input type="date" name="date2" class="form-control mr-4">
					<button class="btn btn-success" id="cari">Cari <i class="d-none fas fa-spinner ml-2"></i></button>
				</form>
			</header>
			<table class="table table-bordered table-striped mt-4">
				<thead>
					<tr>
						<th class="text-center align-middle" width="20">No</th>
						<th class=" align-middle">Modul</th>
						<th class="text-center  align-middle">Nama Ujian</th>
						<th class="text-center  align-middle" width="75">Jumlah Peserta</th>
						<th class="text-center  align-middle" width="75">Nilai Tertinggi</th>
						<th class="text-center  align-middle" width="75">Nilai Terendah</th>
						<th class="text-center  align-middle" width="75">Rata - rata</th>
					</tr>
				</thead>
				<tbody id="sa">
				</tbody>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		let date1 = '', date2 = '', html = '', no = 0;

		function sendRequest(url, data) {
			html = ''; no = 0;
			$('title').text('Loading...');
			$('.fa-spinner').toggleClass('d-none');
			$.ajax({
				type:"GET",
				url:url,
				data:data,
				dataType:"JSON",
				success:function(res) {
					$('.fa-spinner').toggleClass('d-none');
					$('title').text('E-Learning RDS');
					if(res.jumlah_data > 0) {
						console.log(res);
						res.data.forEach(function(data) {
							html += `<tr>
								<td class="text-center">${++no}</td>
								<td>${data.modul}</td>
								<td class="text-center">${data.nama_ujian}</td>
								<td class="text-center">${data.peserta}</td>
								<td class="text-center">${data.tertinggi * 100}</td>
								<td class="text-center">${data.terendah * 100}</td>
								<td class="text-center">${data.rata_rata * 100}</td>
							</tr>`;	
						});
					}
					else {
						html += `<tr> <td colspan="7" class="text-center">Belum ada data :(</td> </tr>`
					}

					$('#sa').html(html);
				}
			});			
		}
		sendRequest("<?= base_url('laporan/get_data_ujian') ?>", {date1:date1, date2:date2});

		$('input[name=date1]').change(function() {
			date1 = this.value;
		});
		$('input[name=date2]').change(function() {
			date2 = this.value;
		});

		$('#cari').click(function(e) {
			e.preventDefault();
			sendRequest("<?= base_url('laporan/get_data_ujian') ?>", {date1:date1, date2:date2});
		});

	})

</script>
</div>
</div>
</div>
<br>
<footer class="main-footer row mt-4">
	<div class="footer-content col-sm-12">
		<div class="container">
			<div class="row">
				<div style="clear: both"></div>
				<div class="col-xl-12">
					<div class="copy-info text-center">
						<?=$this->footer;?>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</footer>