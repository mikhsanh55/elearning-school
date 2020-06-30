<div class="row">
	<?php
	$i = $page_start;
	foreach ($paginate['data'] as $rows) :
		if (!empty($rows->tgl_mulai) && $rows->tgl_mulai != '0000-00-00 00:00:00') {

			$datetime1 = explode(' ', $rows->tgl_mulai);
			$date      = longdate_indo($datetime1[0]) . ' Pukul ' . $time = time_short($datetime1[1]);
		} else {
			$date      = NULL;
		}
	?>
		<div class="col-lg-4 col-sm-6">
			<div class="open-position">
				<div class="card" style="width: 18rem;">
					<!-- <img src="<?= base_url('assets/front/'); ?>images/example.jpg" class="card-img-top rounded img-thumbnail" alt="thumb-5"> -->
					<div class="card-body">
						<p class="card-text"><strong><?= strtoupper($rows->type_ujian); ?></strong>
							<br>
							<b><?= $this->transTheme->guru . '</b> ' . $rows->nama_guru; ?>
								<br>
								<?= $date; ?>
						</p>
						<h5 class="card-title"><?= $rows->nama_mapel; ?></h5>
						<?php
					 	$ujian = $this->m_ikut_ujian->count_by(['id_ujian'=>$rows->id,'id_user'=>$this->akun->id,'status'=>'N']);
					    if ($ujian > 0): ?>
					 		<button type="button" class="btn btn-warning btn-sm mr-2" onclick="window.location = '<?=base_url('ujian_siswa/ikuti_ujian/'.encrypt_url($rows->id));?>'"  data-toggle="tooltip" title="" disabled>Sudah Ujian</button>
					 		<button type="button" class="btn btn-success btn-sm mr-2" onclick="window.location = '<?=base_url('ujian_siswa/result/'.encrypt_url($rows->id));?>'"  data-toggle="tooltip" title="">Lihat Hasil</button>
					 	<?php else: ?>
					 		<button type="button" class="btn btn-success btn-sm mr-2" onclick="window.location = '<?=base_url('ujian_siswa/ikuti_ujian/'.encrypt_url($rows->id));?>'"  data-toggle="tooltip" title="">Mulai Ujian</button>
					 	<?php endif ?>
					</div>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
</div>
<?= $paging; ?>