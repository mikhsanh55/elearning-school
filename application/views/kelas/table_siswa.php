<table class="table table-bordered table-striped table-hovered">
	<thead>
		<tr>
			<th class="frist">No</th>
			<th class="text-left">Mata Pelajaran</th>
			<th class="text-left">Guru</th>
			<th class="frist">Opsi</th>
		</tr>
		
	</thead>
	<tbody>
		<?php if(count($paginate['data']) > 0) { ?>
		<?php $no = $paginate['counts']['from_num'];foreach($paginate['data'] as $rows) : 

		?>
			<tr>
				<td><?= $no++; ?></td>
				<td><?= $rows->nama_mapel; ?></td>
				<td><?= $rows->nama_guru; ?></td>
				<td>
					<a href="<?= base_url('profile/guru/') . encrypt_url($rows->idguru); ?>" class="btn btn-primary btn-sm mb-2">Profil Guru</a>
					<a class="btn btn-primary btn-sm " href="<?= base_url('Materi/lists/') . md5($rows->dmapel) ?>">Materi</a>
				</td>
			</tr>
		<?php endforeach; ?>	
		<?php } else { ?>
			<tr>
				<td class="text-center" colspan="4">Data Kosong</td>
			</tr>
		<?php } ?>
		
	</tbody>
	
</table>


