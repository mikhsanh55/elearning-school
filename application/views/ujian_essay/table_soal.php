
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

		?>
			<tr>
				<td><input type="checkbox" name="checklist[]" class="checklist" data-id= "<?=$rows->id;?>" value="<?=$rows->id;?>"></td>
				<td align="center" class="frist"><?=$i;?></td>
				<td>
					<?php if(!empty($rows->file)) : ?>
						<img src="<?= base_url('upload/file_ujian_soal_essay/') . $rows->file; ?>" alt="" class="img-thumbnail" width="80" height="80">
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


