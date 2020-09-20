<table class="table table-bordered table-striped table-hovered" id="detail-tugas-table">
	<thead>
		<tr>
			<th>No</th>
			<th>Keterangan</th>
			<th>Waktu Pengumpulan</th>
			<th>Nilai</th>
		</tr>
	</thead>
	<tbody>
		<?php if(count($paginate['data']) > 0) { ?>
			<?php $i = 1;foreach($paginate['data'] as $rows) { ?>
				<tr>
					<td class="text-center"><?= $i++; ?></td>
					<td><?= $rows->keterangan; ?></td>
					<td class="text-center"><?= $rows->end_date; ?></td>
					<td class="text-center"><?= $rows->nilai; ?></td>
				</tr>
			<?php } 
		} ?>
	</tbody>
</table>
<script src="<?=base_url();?>assets/js/jquery/jquery-3.3.1.min.js"></script>
<script src="<?= base_url('assets/plugin/datatables/jquery.dataTables.min.js') ?>"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<script>
    $(document).ready(function() {
        $('#detail-tugas-table').DataTable({
            responsive: true,
            paging: false,
            info: false
        });
    });
</script>