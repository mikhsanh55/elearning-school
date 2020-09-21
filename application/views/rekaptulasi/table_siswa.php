<table class="table table-bordered table-striped table-hovered">
	<thead>
		<tr>
			<th rowspan="2">No</th>
			<th rowspan="2">Mata Pelajaran</th>
			<th rowspan="2">Guru</th>
			<th colspan="5">Nilai</th>
		</tr>
		<tr>
			<th>Ujian Harian</th>
			<th>UTS</th>
			<th>UAS</th>
			<th>Tugas</th>
		</tr>
	</thead>
	<tbody>
		<?php if(count($paginate['data']) > 0) { 
			$i = 1;
			foreach($paginate['data'] as $rows) :
				$guru = $this->m_guru->get_by(['id' => $rows->id_guru]);
		?>
			<tr>
				<td><?= $i++; ?></td>
				<td><?= $rows->nama_mapel; ?></td>
				<td><?= !is_null($guru) ? $guru->nama : 'Kosong'; ?></td>

				<td class="text-center">
					<a href="<?= base_url('rekaptulasi/detail-ujian/1/') . encrypt_url($rows->id_mapel); ?>" class="btn btn-sm btn-primary">Detail</a>
				</td>
				<td class="text-center">
					<a href="<?= base_url('rekaptulasi/detail-ujian/2/') . encrypt_url($rows->id_mapel); ?>" class="btn btn-sm btn-primary">Detail</a>
				</td>
				<td class="text-center">
					<a href="<?= base_url('rekaptulasi/detail-ujian/3/') . encrypt_url($rows->id_mapel); ?>" class="btn btn-sm btn-primary">Detail</a>
				</td>
				<td class="text-center">
					<a href="<?= base_url('tugas/detail-nilai/') . encrypt_url($rows->id_mapel); ?>" class="btn btn-sm btn-primary">Detail</a>
				</td>
			</tr>
		<?php endforeach; } else { ?>
			<tr><td colspan="8" class="text-center">Data Kosong</td></tr>
		<?php } ?>
	</tbody>
</table>
<script src="<?=base_url();?>assets/js/jquery/jquery-3.3.1.min.js"></script>
<script src="<?= base_url('assets/plugin/datatables/jquery.dataTables.min.js') ?>"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>

<script>
	$(document).ready(function() {
		$('table').DataTable({
            paging: false,
            info: false
        });
	});
</script>