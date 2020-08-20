<h3>
	Data Hasil Ujian Kelas : <?= $nama_ujian; ?>
</h3>
	<h3>Guru : <?= $nama_guru; ?></h3>
	<h3>Mata Pelajaran : <?= $nama_mapel; ?></h3>
<style>
    table {
        border-collapse:collapse;
        width: 100%;
    }
    th,td {
        padding:10px;
    }
    .text-center {
    	text-align: center;
    }
    .text-left {
    	text-align: left;
    }
</style>
<table border="1">
	<thead>
		<tr>
			<th>No</th>
			<th class="text-left">Nama Siswa</th>
			<th class="text-left">Kelas</th>
			<th>KKM</th>
			<th>Nilai</th>
		</tr>
	</thead>
	<tbody>
		<?php if(count($datas) > 0) { ?>
			<?php $i = 1;foreach($datas as $data): 
				$siswa = $this->m_siswa->get_by(['id' => $data->id_user]);
				$detailKelas = $this->m_detail_kelas->get_by(['id_peserta' => $data->id_user]);
				$kelas = $this->m_kelas->get_by(['kls.id' => $detailKelas->id_kelas]);
				if($data->nilai_essay == NULL || empty($data->nilai_essay)) {
					$nilai = $data->nilai_pg;
				}
				else {
					$nilai = ($data->nilai_pg + $data->nilai_essay) / 2;
				}
			?>
				<tr>
					<td class="text-center"><?= $i++; ?></td>
					<td class="text-left"><?= $siswa->nama; ?></td>
					<td><?= $kelas->nama; ?></td>
					<td class="text-center"><?= $data->min_nilai; ?></td>
					<td class="text-center"><?= $nilai; ?></td>
				</tr>
			<?php endforeach; ?>
		<?php } else { ?>
			<tr>
				<td rowspan="5" class="text-center">Data Kosong</td>
			</tr>
		<?php } ?>
	</tbody>
</table>