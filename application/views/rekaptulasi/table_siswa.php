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
			<th>Keaktifan</th>
		</tr>
	</thead>
	<tbody>
		<?php if(count($paginate['data']) > 0) { 
			$i = 1;
			foreach($paginate['data'] as $rows) :
				$guru = $this->m_guru->get_by(['id' => $rows->id_guru]);
				// Nilai Keaktifan
				$sumKeaktifan = 4;
				$nilaiKeaktifan = ($rows->active_login + $rows->active_video + $rows->active_materi + $rows->active_diskusi + $rows->active_tugas) / $sumKeaktifan;	
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
				<td class="text-center">
					<?= $nilaiKeaktifan; ?>
				</td>
			</tr>
		<?php endforeach; } else { ?>
			<tr><td colspan="8" class="text-center">Data Kosong</td></tr>
		<?php } ?>
	</tbody>
</table>