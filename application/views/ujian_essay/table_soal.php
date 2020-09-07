
<table class="table table-bordered table-striped table-hovered">
	<thead>
		<tr>
			<th class="frist"><input type="checkbox" name="checkall" id="checkall"></th>
			<th class="frist">No</th>
			<th>Media</th>
			<th>Soal</th>		
		</tr>
		<?php 
			if (count($paginate['data']) > 0) {
			$i= $page_start; foreach ($paginate['data'] as $rows):

		?>
			<tr>
				<td><input type="checkbox" name="checklist[]" class="checklist" data-id= "<?=$rows->id;?>" value="<?=$rows->id;?>"></td>
				<td align="center" class="frist"><?=$i;?></td>
				<td>
					<?php if(!empty($rows->file)) : ?>
						<?php $mediaSoal = getMediaSoalFile($rows->file, $this->_fileSoalPath, $rows->tipe_file);
							echo $mediaSoal;
						?>
					<?php endif; ?>
				</td>
				<td><?=$rows->soal;?></td>
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


