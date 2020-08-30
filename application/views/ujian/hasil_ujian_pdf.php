<h3>
	Data Hasil Ujian Kelas : <?= $nama_kelas; ?>
</h3>
	<h3>Guru : <?= $nama_guru; ?></h3>
	<h3>Mata Pelajaran : <?= $nama_mapel; ?></h3>

<br>
<style>
	table {
		border-collapse: collapse;
		width:100%;
	}
</style>
<div class="container">
	<header>
		<h4>Hasil Ujian</h4>
	</header>	
	<section>
		<table border="1">
			<thead>
				<tr>
					<th class="frist">No</th>
					<th>Siswa</th>
					<th>Kelas</th>
					<th>Nilai</th>
					<th>Grade</th>
					<th>Jumlah Benar</th>
					<th>Keterangan</th>
					<th>KKM</th>
					<th>Waktu Mulai</th>
					<th>Waktu Selesai</th>
				</tr>
			</thead>
			<tbody>
				<?php if(count($datas) > 0) { ?>
					<?php $i = 1;foreach($datas as $rows) : 
					$ujian = $this->m_ujian->get_by(['uji.id'=>$rows->id_ujian]);
					$siswa = $this->m_siswa->get_by(['id'=>$rows->id_user]);
					$keterangan = ($rows->nilai >= $ujian->min_nilai) ? 'LULUS' : 'BELUM LULUS';

					if($rows->nilai > 90 && $rows->nilai < 101){
						$grade = 'A';
					}else if($rows->nilai > 80 && $rows->nilai < 91){
						$grade = 'B';
					} else if($rows->nilai > 70 && $rows->nilai < 81){
						$grade = 'C';
					} else {
						$grade = 'D';
					}
					$id_kelas = $this->m_detail_kelas->get_by(['id_peserta' => $rows->id_user]);
					$nama_kelas = $this->m_kelas->get_by(['kls.id' => $id_kelas->id_kelas]);
					$nama_kelas = !empty($nama_kelas) ? $nama_kelas->nama : '';
					?>
						<tr>
							<td align="center" class="frist"><?=$i;?></td>
							<td><?=$siswa->nama;?></td>
							<td><?= $nama_kelas; ?></td>
							<td><?=$rows->nilai;?></td>
							<td><?=$grade;?></td>
							<td><?=$rows->jml_benar;?></td>
							<td><?=$keterangan;?></td>
							<td><?=$ujian->min_nilai;?></td>
							<td><?= date('d-m-Y H:i:s', strtotime($rows->tgl_mulai));?></td>
							<td><?= date('d-m-Y H:i:s', strtotime($rows->tgl_selesai));?></td>
						</tr>
					<?php $i++; endforeach; ?>
				<?php } else { ?>
					<tr>
						<td colspan="10" style="text-align: center;">Data Kosong</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</section>
</div>