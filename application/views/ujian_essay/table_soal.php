<table class="table table-bordered table-striped table-hovered" id="soal-essay-table">
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
			
		<?php $i++; endforeach; }?>
	</tbody>
</table>
<script src="<?=base_url();?>assets/js/jquery/jquery-3.3.1.min.js"></script>
<script src="<?= base_url('assets/plugin/datatables/jquery.dataTables.min.js') ?>"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
<script>
	$(document).ready(function() {
		$('#soal-essay-table').DataTable({
			responsive: true,
			paging: false,
			info: false
		});

		$('.btn-opsi').on('click', function(e) {
			e.preventDefault();
			$(this).find('i').toggleClass('fa-angle-double-right').toggleClass('fa-angle-double-down');
		});
	});
</script>