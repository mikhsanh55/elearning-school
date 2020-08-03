
<table class="table table-bordered table-striped table-hovered">
	<thead>
		<tr>
			<th class="frist"><input type="checkbox" name="checkall" id="checkall"></th>
			<th class="frist">No</th>
			<th>Gambar</th>
			<th>Soal</th>
			<!-- <th>Analisa</th> -->
		
		</tr>
		<?php 
			if (count($paginate['data']) > 0) {
			$i= $page_start; foreach ($paginate['data'] as $rows):
			$opsi_a = explode('#####', $rows->opsi_a);
			$gambar_a = !empty($opsi_a[0]) ? $opsi_a[0] : NULL;

			$opsi_b = explode('#####', $rows->opsi_b);
			$gambar_b = !empty($opsi_b[0]) ? $opsi_b[0] : NULL;

			$opsi_c = explode('#####', $rows->opsi_c);
			$gambar_c = !empty($opsi_c[0]) ? $opsi_c[0] : NULL;

			$opsi_d = explode('#####', $rows->opsi_d);
			$gambar_d = !empty($opsi_d[0]) ? $opsi_d[0] : NULL;

			$opsi_e = explode('#####', $rows->opsi_e);
			$gambar_e = !empty($opsi_e[0]) ? $opsi_e[0] : NULL;

		?>
			<tr>
				<td><input type="checkbox" name="checklist[]" class="checklist" data-id= "<?=$rows->id;?>" value="<?=$rows->id;?>"></td>
				<td align="center" class="frist"><?=$i;?></td>
				<td>
					<?php if(!empty($rows->file)) : ?>
						<img src="<?= base_url('upload/file_ujian_soal/') . $rows->file; ?>" alt="" class="img-thumbnail" width="80" height="80">
					<?php endif; ?>
				</td>
				<td><?=$rows->soal;?></td>
			</tr>
				
			<tr>
				<td colspan="3"><button class="btn btn-sm btn-block btn-primary btn-opsi" data-toggle="collapse" data-target="#opsi<?= $i; ?>" aria-expanded="false" aria-controls="opsi<?= $i; ?>"><i class="fas fa-angle-double-right" ></i></button></td>
				<td>
					<p>Tekan tombol <i class="fas fa-angle-double-right"></i> untuk melihat opsi</p>
					<div class="collapse" id="opsi<?= $i; ?>">
						<div class="card card-body">
							<ul>
								<li class="d-flex flex-row ">
									<div>A. </div><?= end($opsi_a); ?>
										<?php if(!is_null($gambar_a)) { ?> 
											<img src="<?= base_url('upload/file_ujian_opsi/') . $gambar_a;?>" alt="" width="100" height="100">
										<?php } ?> 
									 
								</li>
								<li class="d-flex flex-row ">
									<div>B. </div><?= end($opsi_b); ?>
										<?php if(!is_null($gambar_b)) { ?> 
											<img src="<?= base_url('upload/file_ujian_opsi/') . $gambar_b;?>" alt="" width="100" height="100">
										<?php } ?> 
									 
								</li>
								
								<li class="d-flex flex-row ">
									<div>C. </div><?= end($opsi_c); ?>
										<?php if(!is_null($gambar_c)) { ?> 
											<img src="<?= base_url('upload/file_ujian_opsi/') . $gambar_c;?>" alt="" width="100" height="100">
										<?php } ?> 
									 
								</li>
								<li class="d-flex flex-row ">
									<div>D. </div><?= end($opsi_d); ?>
										<?php if(!is_null($gambar_d)) { ?> 
											<img src="<?= base_url('upload/file_ujian_opsi/') . $gambar_d;?>" alt="" width="100" height="100">
										<?php } ?> 
									 
								</li>
								<li class="d-flex flex-row ">
									<div>E. </div><?= end($opsi_e); ?>
										<?php if(!is_null($gambar_e)) { ?> 
											<img src="<?= base_url('upload/file_ujian_opsi/') . $gambar_e;?>" alt="" width="100" height="100">
										<?php } ?> 
									 
								</li>
							</ul>
						</div>
					</div>
				</td>
			</tr>
		<?php $i++; endforeach; } else { echo '<tr><td colspan="4" align="center">DATA KOSONG</td></tr>';} ?>
	</thead>
<tbody>
</tbody>
</table>
<script>
	$('.btn-opsi').on('click', function(e) {
		e.preventDefault();
		$(this).find('i').toggleClass('fa-angle-double-right').toggleClass('fa-angle-double-down')
	})
</script>


