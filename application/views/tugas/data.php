<div class="row">
	<?php $i= $page_start; foreach ($paginate['data'] as $rows):

		if (!empty($rows->end_date) && $rows->end_date != '0000-00-00 00:00:00') {
			$datetime1 = explode(' ', $rows->end_date);
			$date = longdate_indo($datetime1[0]).' Pukul '.$time = time_short($datetime1[1]);

		}else{
			$date = NULL;
		}
	?>
	<div class="col-lg-4 col-sm-6">
		<div class="open-position">
			<div class="card" style="width: 18rem;">
				<div class="card-body">
					<h5 class="card-title">Tugas</h5>
					<h6 class="card-subtitle mb-2 text-muted"><?=$rows->nama_mapel.' <br> ('.$rows->nama_trainer.')';?></h6>
					<p class="card-text"><?=$rows->keterangan;?></p>
					<p class="card-text">Tanggal Selesai <br><?=$date;?></p>
					<button type="button" class="btn btn-primary">Lihat Tugas</button>
				</div>
			</div>
		</div>
	</div>
<?php endforeach;?>
</div>
<?= $paging;?>