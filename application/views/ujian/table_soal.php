<table class="table table-bordered table-striped table-hovered">
	<thead>
		<tr>
			<th class="frist"><input type="checkbox" name="checkall" id="checkall"></th>
			<th class="frist">No</th>
			<th>Media</th>
			<th>Soal</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			if (count($paginate['data']) > 0) {
			$i= $page_start; foreach ($paginate['data'] as $rows):
			$opsi_a = explode('#####', $rows->opsi_a);
			$gambarA = $this->m_soal_opsi->get_by(['opsi' => 'opsi_a', 'id_soal' => $rows->id]);
			$fileA = ($gambarA) != '' ? getMediaOpsiFile($gambarA->file, $this->_fileOpsiPath) : NULL;

			$opsi_b = explode('#####', $rows->opsi_b);
			$gambarB = $this->m_soal_opsi->get_by(['opsi' => 'opsi_b', 'id_soal' => $rows->id]);
			$fileB = ($gambarB) != '' ? getMediaOpsiFile($gambarB->file, $this->_fileOpsiPath) : NULL;

			$opsi_c = explode('#####', $rows->opsi_c);
			$gambarC = $this->m_soal_opsi->get_by(['opsi' => 'opsi_c', 'id_soal' => $rows->id]);
			$fileC = ($gambarC) != '' ? getMediaOpsiFile($gambarC->file, $this->_fileOpsiPath) : NULL;		

			$opsi_d = explode('#####', $rows->opsi_d);
			$gambarD = $this->m_soal_opsi->get_by(['opsi' => 'opsi_d', 'id_soal' => $rows->id]);
			$fileD = ($gambarD) != '' ? getMediaOpsiFile($gambarD->file, $this->_fileOpsiPath) : NULL;

			$opsi_e = explode('#####', $rows->opsi_e);
			$gambarE = $this->m_soal_opsi->get_by(['opsi' => 'opsi_e', 'id_soal' => $rows->id]);
			$fileE = ($gambarE) != '' ? getMediaOpsiFile($gambarE->file, $this->_fileOpsiPath) : NULL;

			$mediaSoal = '';
		?>
			<tr>
				<td><input type="checkbox" name="checklist[]" class="checklist" data-id= "<?= encrypt_url($rows->id); ?>" value="<?= encrypt_url($rows->id); ?>"></td>
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
										<?= $fileA; ?>
								</li>
								<li class="d-flex flex-row ">
									<div>B. </div><?= end($opsi_b); ?>
										<?= $fileB; ?>
								</li>
								
								<li class="d-flex flex-row ">
									<div>C. </div><?= end($opsi_c); ?>
										<?= $fileC; ?>
								</li>
								<li class="d-flex flex-row ">
									<div>D. </div><?= end($opsi_d); ?>
										<?= $fileD; ?>
								</li>
								<li class="d-flex flex-row ">
									<div>E. </div><?= end($opsi_e); ?>
										<?= $fileE; ?>
								</li>
							</ul>
						</div>
					</div>
				</td>
			</tr>
		<?php $i++; endforeach; } else { ?>
			<tr>
				<td colspan="4" class="text-center">Data Kosong</td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<script src="<?=base_url();?>assets/js/jquery/jquery-3.3.1.min.js"></script>
<script src="<?= base_url('assets/plugin/datatables/jquery.dataTables.min.js') ?>"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
<script>
	$(document).ready(function() {
		$('.btn-opsi').on('click', function(e) {
			e.preventDefault();
			$(this).find('i').toggleClass('fa-angle-double-right').toggleClass('fa-angle-double-down')
		});
	});
</script>