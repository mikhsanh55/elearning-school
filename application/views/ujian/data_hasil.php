<div class="row">
	<?php
	$i = $page_start;
	foreach ($paginate['data'] as $rows) :
		$ujian = $this->m_ujian->get_by(['uji.id'=>$rows->id_ujian]);
		$keterangan = ($rows->nilai >= $ujian->min_nilai) ? 'LULUS' : 'BELUM LULUS';
		if (!empty($rows->tgl_mulai) && $rows->tgl_mulai != '0000-00-00 00:00:00') {

			$datetime1 = explode(' ', $rows->tgl_mulai);
			$date      = longdate_indo($datetime1[0]) . ' Pukul ' . $time = time_short($datetime1[1]);
		} else {
			$date      = NULL;
		}

		if (!empty($rows->tgl_mulai) && $rows->tgl_mulai != '0000-00-00 00:00:00') {

			$datetime2 = explode(' ', $rows->tgl_selesai);
			$date2      = longdate_indo($datetime2[0]) . ' Pukul ' . $time = time_short($datetime2[1]);
		} else {
			$date2      = NULL;
		}
	?>
		<div class="col-lg-4 col-sm-6">
			<div class="open-position">
				<div class="card" style="width: 18rem;">
					<!-- <img src="<?= base_url('assets/front/'); ?>images/example.jpg" class="card-img-top rounded img-thumbnail" alt="thumb-5"> -->
					<div class="card-body">
						<p class="card-text">
							<strong>Nilai</strong>
							<br>
							<?=(int)$rows->nilai;?>
							<br>
							<strong>Jumlah Benar</strong>
							<br>
							<?=(int)$rows->jml_benar;?>
							<br>
							<strong>Keterangan</strong>
							<br>
							<?=$keterangan;?>
							<br>
							<strong>Nilai Minimum</strong>
							<br>
							<?=$ujian->min_nilai;?>
							<br>
							<strong>Tanggal Mulai</strong>
							<br>
							<?=$date;?>
							<br>
							<strong>Tanggal Selesai</strong>
							<br>
							<?=$date2;?>
					
						</p>
						<h5 class="card-title"></h5>
						
					 		<button type="button" class="btn btn-primary btn-sm mr-2" onclick="window.location = '<?=base_url('ujian_real/riwayat/'.encrypt_url($rows->id).'/'.encrypt_url($ujian->id));?>'"  data-toggle="tooltip" title="">Lihat Jawaban</button>
					 	
					</div>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
</div>
<?= $paging; ?>