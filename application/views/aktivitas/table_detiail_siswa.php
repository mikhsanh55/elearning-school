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
			responsive: true,
			paging: false,
			info: false
		});
	});
</script>