<table class="table table-bordered table-striped table-hovered">

	<thead>

		<tr>

			<th class="frist">No</th>

			<th class="text-left">Daftar Kelas</th>

			<th class="text-left">Wali Kelas</th>

			<th class="text-left">Mata Pelajaran</th>

			<th class="frist">Opsi</th>

		</tr>
	</thead>

	<tbody>
		<?php if(count($paginate['data']) > 0) { ?>
		<?php $i = $paginate['counts']['from_num'];foreach($paginate['data'] as $rows) : 
			$mapel = $this->m_mapel->get_by(['id' => $rows->id_mapel]);
		?>
			<tr>
				<td><?= $i++; ?></td>
				<td><?= $rows->nama; ?></td>
				<td><?= $rows->nama_guru; ?></td>
				<td><?= $rows->nama_mapel; ?></td>
				<td>
					<button class="btn btn-primary btn-sm rekrut mb-2" data-id="<?= $rows->id; ?>" onclick="displaySiswa(this)">Lihat Siswa</button>

					<a href="<?= base_url('Materi/lists/') . md5($rows->dmapel); ?>" class="btn btn-sm btn-primary">Materi</a>
				</td>
			</tr>
		<?php endforeach;?>
		<?php } else { ?>
			<tr>
				<td class="text-center" colspan="5">Data Kosong</td>
			</tr>
		<?php } ?>
		
	</tbody>

</table>





