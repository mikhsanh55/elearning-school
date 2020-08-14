<table class="table table-bordered table-striped table-hovered">
	<thead>
		<tr>
			<th class="frist" rowspan="2">No</th>
			<th rowspan="2">Nama Siswa</th>
			<th rowspan="2">Kelas</th>
			<th rowspan="2">Mata Pelajaran</th>
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
	    <?php if(count($paginate['data']) > 0) { ?>
	<?php $i= $page_start; foreach ($paginate['data'] as $rows): 

		// Nilai Keaktifan
		$sumKeaktifan = 4;
		$nilaiKeaktifan = ($rows->active_login + $rows->active_video + $rows->active_materi + $rows->active_diskusi + $rows->active_tugas) / $sumKeaktifan;
			?>
				<tr>
					<td align="center" class="frist"><?=$i;?></td>
					<td><?=$rows->siswa;?></td>
					<td><?=$rows->nama_kelas;?></td>
					<td><?= $rows->nama_mapel; ?></td>
					<td class="text-center">
						<a href="<?= base_url('rekaptulasi/detail-ujian/1/') . encrypt_url($rows->id_mapel) . '/' . encrypt_url($rows->id_siswa) . '/' . encrypt_url($rows->id_kelas); ?>" class="btn btn-sm btn-primary">Detail</a>
					</td>
					<td class="text-center">
						<a href="<?= base_url('rekaptulasi/detail-ujian/2/') . encrypt_url($rows->id_mapel) . '/' . encrypt_url($rows->id_siswa) . '/' . encrypt_url($rows->id_kelas); ?>" class="btn btn-sm btn-primary">Detail</a>
					</td>
					<td class="text-center">
						<a href="<?= base_url('rekaptulasi/detail-ujian/3/') . encrypt_url($rows->id_mapel) . '/' . encrypt_url($rows->id_siswa) . '/' . encrypt_url($rows->id_kelas); ?>" class="btn btn-sm btn-primary">Detail</a>
					</td>
					<td class="text-center">
						<button data-href="<?= base_url('rekaptulasi/detail-ujian/1/') . encrypt_url($rows->id_mapel); ?>" class="btn btn-sm btn-primary" disabled>Detail</button>
					</td>
					<td><?=$nilaiKeaktifan <= 0 ? 0 : (int)$nilaiKeaktifan;?></td>
				</tr>
			<?php $i++;endforeach ?>
	<?php } else { ?>		
	    <tr>
	        <td colspan="10" rowspan="2" class="text-center">Data Not Found</td>
	    </tr>
	    
	<?php } ?>
	</tbody>
</table>
