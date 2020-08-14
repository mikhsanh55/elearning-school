<table class="table table-bordered table-striped table-hovered">
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
			<?php $i = 1;foreach($paginate['data'] as $rows) : ?>
				<tr>
					<td class="text-center"><?= $i++; ?></td>
					<td><?= $rows->keterangan; ?></td>
					<td class="text-center"><?= $rows->end_date; ?></td>
					<td class="text-center"><?= $rows->nilai; ?></td>
				</tr>
			<? endforeach; ?>
		<?php } else { ?>
			<tr>
				<td class="text-center" colspan="4">Data Kosong</td>
			</tr>
		<?php } ?>
	</tbody>
</table>