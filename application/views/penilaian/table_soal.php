<table id="custumtb">
	<thead>
		<tr>
			<th class="frist"><input type="checkbox" name="checkall" id="checkall"></th>
			<th class="frist">No</th>
			<th class="text-center">Media</th>
			<th class="text-left">Soal</th>
		</tr>

	</thead>
	<tbody>
		<?php 
		
			if (count($paginate['data']) > 0) {
			$i= $page_start; foreach ($paginate['data'] as $rows):
			$opsiA = $rows->opsi_a;
			$mediaA = $this->m_soal_penilaian_opsi->get_by(['opsi' => 'opsi_a', 'id_soal' => $rows->id]);
			$fileA = ($mediaA) != '' ? getMediaOpsiFile($mediaA->file, $this->_fileOpsiPath) : NULL;

			$opsiB = $rows->opsi_b;
			$mediaB = $this->m_soal_penilaian_opsi->get_by(['opsi' => 'opsi_b', 'id_soal' => $rows->id]);
			$fileB = ($mediaB) != '' ? getMediaOpsiFile($mediaB->file, $this->_fileOpsiPath) : NULL;

			$opsiC = $rows->opsi_c;
			$mediaC = $this->m_soal_penilaian_opsi->get_by(['opsi' => 'opsi_c', 'id_soal' => $rows->id]);
			$fileC = ($mediaC) != '' ? getMediaOpsiFile($mediaC->file, $this->_fileOpsiPath) : NULL;

			$opsiD = $rows->opsi_d;
			$mediaD = $this->m_soal_penilaian_opsi->get_by(['opsi' => 'opsi_d', 'id_soal' => $rows->id]);
			$fileD = ($mediaD) != '' ? getMediaOpsiFile($mediaD->file, $this->_fileOpsiPath) : NULL;

			$opsiE = $rows->opsi_e;
			$mediaE = $this->m_soal_penilaian_opsi->get_by(['opsi' => 'opsi_e', 'id_soal' => $rows->id]);
			$fileE = ($mediaE) != '' ? getMediaOpsiFile($mediaE->file, $this->_fileOpsiPath) : NULL;
		?>
			<tr>
				<td><input type="checkbox" name="checklist[]" class="checklist" data-id= "<?= encrypt_url($rows->id); ?>" value="<?= encrypt_url($rows->id) ;?>"></td>
				<td align="center" class="frist"><?=$i;?></td>
				<td>
					<?php if(!empty($rows->file)) : 
						$mediaSoal = getMediaSoalFile($rows->file, $this->_fileSoalPath, $rows->tipe_file);

						echo $mediaSoal;
					 endif; ?>
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
										<div>A. </div><?= ($opsiA); ?>
										<?= $fileA; ?>
									</li>
									<li class="d-flex flex-row ">
										<div>B. </div><?= ($opsiB); ?>
										<?= $fileB; ?>
									</li>
									
									<li class="d-flex flex-row ">
										<div>C. </div><?= ($opsiC); ?>
										<?= $fileC; ?>
									</li>
									<li class="d-flex flex-row ">
										<div>D. </div><?= ($opsiD); ?>
										<?= $fileD; ?>
									</li>
									<li class="d-flex flex-row ">
										<div>E. </div><?= ($opsiE); ?>
										<?= $fileE; ?>
									</li>
								</ul>
							</div>
						</div>		
				</td>
			</tr>
		<?php $i++; endforeach; }?>
	</tbody>
</table>
<script>
	$(document).ready(function() {
		$('.btn-opsi').on('click', function(e) {
			e.preventDefault();
			$(this).find('i').toggleClass('fa-angle-double-right').toggleClass('fa-angle-double-down')
		});
	});
</script>