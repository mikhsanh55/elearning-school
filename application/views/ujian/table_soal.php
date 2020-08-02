
<table class="table table-bordered table-striped table-hovered">
	<thead>
		<tr>
			<th class="frist"><input type="checkbox" name="checkall" id="checkall"></th>
			<th class="frist">No</th>
			<th>Soal</th>
			<!-- <th>Analisa</th> -->
		
		</tr>
		<?php 
			if (count($paginate['data']) > 0) {
			$i= $page_start; foreach ($paginate['data'] as $rows):
			$opsi_a = preg_replace("/[#]/", "", $rows->opsi_a);
			$opsi_b = preg_replace("/[#]/", "", $rows->opsi_b);
			$opsi_c = preg_replace("/[#]/", "", $rows->opsi_c);
			$opsi_d = preg_replace("/[#]/", "", $rows->opsi_d);
			$opsi_e = preg_replace("/[#]/", "", $rows->opsi_e);

		?>
			<tr>
				<td><input type="checkbox" name="checklist[]" class="checklist" data-id= "<?=$rows->id;?>" value="<?=$rows->id;?>"></td>
				<td align="center" class="frist"><?=$i;?></td>
				<td><?=$rows->soal;?></td>
			</tr>
			<tr>
				<td colspan="2"><button class="btn btn-sm btn-block btn-primary btn-opsi" data-toggle="collapse" data-target="#opsi<?= $i; ?>" aria-expanded="false" aria-controls="opsi<?= $i; ?>"><i class="fas fa-angle-double-right" ></i></button></td>
				<td>
					<p>Tekan tombol <i class="fas fa-angle-double-right"></i> untuk melihat opsi</p>
					<div class="collapse" id="opsi<?= $i; ?>">
						<div class="card card-body">
							<ul>
								<li class="d-flex flex-row"><span>A. </span> <?= $opsi_a; ?></li>
								<li class="d-flex flex-row"><span>B. </span> <?= $opsi_b; ?></li>
								<li class="d-flex flex-row"><span>C. </span> <?= $opsi_c; ?></li>
								<li class="d-flex flex-row"><span>D. </span> <?= $opsi_d; ?></li>
								<li class="d-flex flex-row"><span>E. </span> <?= $opsi_e; ?></li>
							</ul>
						</div>
					</div>
				</td>
			</tr>
		<?php $i++; endforeach; } else { echo '<tr><td colspan="3" align="center">DATA KOSONG</td></tr>';} ?>
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


