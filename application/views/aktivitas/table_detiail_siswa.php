<table class="table table-bordered table-striped table-hovered">
	<thead>
		<tr>
			<th>No</th>
			<th>Jumlah Login</th>
			<th>Jumlah Download Materi</th>
			<th>Jumlah Tonton Video</th>
			<th>Jumlah Keaktifan Diskusi</th>
			<th>Jumlah Keaktifan Tugas</th>
		</tr>
	</thead>
	<tbody>
		<?php if(count($paginate['data']) > 0) { ?>
		<?php $i = 1;foreach($paginate['data'] as $rows) : 
			$sumLogin = $this->m_keaktifan_siswa->getSumKeaktifan([
                'id_siswa' => $rows->id,
                'id_mapel' => $rows->id_mapel,
                'type' => 'login'
            ]);

            $sumVideos = $this->m_keaktifan_siswa->getSumKeaktifan([
                'id_siswa' => $rows->id,
                'id_mapel' => $rows->id_mapel,
                'type' => 'video'
            ]);

            $sumRead = $this->m_keaktifan_siswa->getSumKeaktifan([
                'id_siswa' => $rows->id,
                'id_mapel' => $rows->id_mapel,
                'type' => 'read'
            ]);

            $sumDiskusi = $this->m_keaktifan_siswa->getSumKeaktifan([
                'id_siswa' => $rows->id,
                'id_mapel' => $rows->id_mapel,
                'type' => 'diskusi'
            ]);

            $sumTugas = $this->m_keaktifan_siswa->getSumKeaktifan([
                'id_siswa' => $rows->id,
                'id_mapel' => $rows->id_mapel,
                'type' => 'tugas'
            ]);
		?>
			<tr>
				<td><?= $i++; ?></td>
				<td><?= $sumLogin->sum; ?></td>
				<td><?= $sumRead->sum; ?></td>
				<td><?= $sumVideos->sum; ?></td>
				<td><?= $sumDiskusi->sum; ?></td>
				<td><?= $sumTugas->sum; ?></td>
			</tr>
		<?php endforeach; ?>
		<?php } else { ?>
			<tr>
				<td class="text-center" colspan="<?= $this->log_lvl === 'siswa' ? 6 : 7; ?>">Data Kosong</td>
			</tr>
		<?php } ?>
	</tbody>
</table>