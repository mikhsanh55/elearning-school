
<table class="table table-bordered table-striped table-hovered">
	<thead>
		<tr>
			<th class="frist"><input type="checkbox" name="checkall" id="checkall"></th>
			<th class="frist">No</th>
			<th>Gambar</th>
			<th>Soal</th>
		</tr>
		<?php 
			if (count($paginate['data']) > 0) {
			$i= $page_start; foreach ($paginate['data'] as $rows):
			$opsi_a = explode('#####', $rows->opsi_a);
			$gambar_a = !empty($opsi_a[0]) ? $opsi_a[0] : NULL;
			$mediaOpsiA = getMediaOpsiFile($gambar_a, $this->_fileOpsiPath);

			$opsi_b = explode('#####', $rows->opsi_b);
			$gambar_b = !empty($opsi_b[0]) ? $opsi_b[0] : NULL;
			$mediaOpsiB = getMediaOpsiFile($gambar_b, $this->_fileOpsiPath);

			$opsi_c = explode('#####', $rows->opsi_c);
			$gambar_c = !empty($opsi_c[0]) ? $opsi_c[0] : NULL;
			$mediaOpsiC = getMediaOpsiFile($gambar_c, $this->_fileOpsiPath);			

			$opsi_d = explode('#####', $rows->opsi_d);
			$gambar_d = !empty($opsi_d[0]) ? $opsi_d[0] : NULL;
			$mediaOpsiD = getMediaOpsiFile($gambar_d, $this->_fileOpsiPath);

			$opsi_e = explode('#####', $rows->opsi_e);
			$gambar_e = !empty($opsi_e[0]) ? $opsi_e[0] : NULL;
			$mediaOpsiE = getMediaOpsiFile($gambar_e, $this->_fileOpsiPath);

			$mediaSoal = '';
		?>
			<tr>
				<td><input type="checkbox" name="checklist[]" class="checklist" data-id= "<?=$rows->id;?>" value="<?=$rows->id;?>"></td>
				<td align="center" class="frist"><?=$i;?></td>
				<td>
					<?php $mediaSoal = getMediaSoalFile($rows->file, $this->_fileSoalPath, $rows->tipe_file);
						echo $mediaSoal;
					?>
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
											<?= $mediaOpsiA; ?>
										<?php } ?> 
									 
								</li>
								<li class="d-flex flex-row ">
									<div>B. </div><?= end($opsi_b); ?>
										<!-- <?php if(!is_null($gambar_b)) { ?>  -->
											<?= $mediaOpsiB; ?>
										<!-- <?php } ?>  -->
									 
								</li>
								
								<li class="d-flex flex-row ">
									<div>C. </div><?= end($opsi_c); ?>
										<!-- <?php if(!is_null($gambar_c)) { ?>  -->
											<?= $mediaOpsiC; ?>
										<!-- <?php } ?>  -->
									 
								</li>
								<li class="d-flex flex-row ">
									<div>D. </div><?= end($opsi_d); ?>
										<!-- <?php if(!is_null($gambar_d)) { ?>  -->
											<?= $mediaOpsiD; ?>
										<!-- <?php } ?>  -->
									 
								</li>
								<li class="d-flex flex-row ">
									<div>E. </div><?= end($opsi_e); ?>
										<!-- <?php if(!is_null($gambar_e)) { ?>  -->
											<?= $mediaOpsiE; ?>
										<!-- <?php } ?>  -->
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
	});
</script>