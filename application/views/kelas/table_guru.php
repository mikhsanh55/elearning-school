<table id="custumtb">

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
		<?php $i = 1;foreach($paginate['data'] as $rows) : 
			$mapel = $this->m_mapel->get_by(['id' => $rows->id_mapel]);
		?>
			<tr>
				<td><?= $i++; ?></td>
				<td><?= $rows->nama; ?></td>
				<td><?= $rows->nama_guru; ?></td>
				<td><?= $rows->nama_mapel; ?></td>
				<td>
					<button class="btn btn-primary btn-sm rekrut mb-2" data-id="<?= $rows->id; ?>" onclick="displaySiswa(this)">Lihat Siswa</button>

					<a class="btn btn-sm btn-primary" href="<?= base_url('Materi/lists/') . md5($rows->dmapel); ?>">Mulai Kelas</button>
				</td>
			</tr>
		<?php endforeach;?>
		
	</tbody>

</table>





