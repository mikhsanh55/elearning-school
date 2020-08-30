<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>No</th>
			<th class="text-left">Nama Siswa</th>
			<th class="text-center">Waktu Mulai</th>
			<th class="text-center">Waktu Selesai</th>
			<th class="text-center">Opsi</th>
		</tr>
	</thead>
	<tbody>
		<?php if(count($paginate['data']) > 0) { ?>
			<?php $i = 1;foreach($paginate['data'] as $rows): 
			?>
				<tr>
					<td class="text-center"><?= $i++; ?></td>
					<td><?= uniqid('Siswa_'); ?></td>
					<td class="text-center"><?= date('d-m-Y H:i:s', strtotime($rows->tgl_mulai)); ?></td>
					<td class="text-center"><?= date('d-m-Y H:i:s', strtotime($rows->tgl_selesai)); ?></td>
					<td class="text-center">
						<a href="<?= base_url('penilaian/hasil-penilaian-siswa/') . encrypt_url($rows->id_user) . '/' . encrypt_url($rows->id_penilaian); ?>" class="btn btn-sm btn-primary">Lihat Hasil Penilaian</a>
					</td>
				</tr>
			<?php endforeach; ?>
		<?php } else { ?>

		<?php } ?>
	</tbody>
</table>