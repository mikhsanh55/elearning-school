<table id="custumtb">
	<thead>
		<tr>
			<th class="frist"><input type="checkbox" name="checkall" id="checkall"></th>
			<th class="frist">No</th>
			<th class="text-left">Soal</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			if (count($paginate['data']) > 0) {
			$i= $page_start; foreach ($paginate['data'] as $rows):
			$dimensi = $this->m_dimensi->get_by(['id'=>$rows->id_dimensi]);
		?>
			<tr>
				<td><input type="checkbox" name="checklist[]" class="checklist" data-id= "<?=$rows->id;?>" value="<?=$rows->id;?>"></td>
				<td align="center" class="frist"><?=$i;?></td>
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
		$('table').DataTable({
			responsive: true,
			paging: false,
			info: false
		});
	});
</script>