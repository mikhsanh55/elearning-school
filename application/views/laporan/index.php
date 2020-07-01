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
			<table class="table table-bordered table-striped w-75 mx-auto">
				<thead>
					<tr>
						<th class="text-center">Ujian</th>
						<th class="text-center">Modul</th>
					</tr>
				</thead>
				<tr>
					<td class="text-center"><a href="<?= base_url('laporan/ujian') ?>" class="btn btn-sm btn-primary btn-sm">Lihat Laporan</a></td>
					<td class="text-center"><a href="<?= base_url('laporan/modul') ?>" class="btn btn-sm btn-success btn-sm">Lihat Laporan</a></td>
				</tr>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
	
</script>
</div>
</div>
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