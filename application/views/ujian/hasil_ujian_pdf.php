<style>
	table {
		border-collapse: collapse;
	}
</style>
<div class="container">
	<header>
		<h4>Hasil Ujian</h4>
	</header>	
	<section>
		<table>
			<thead>
				<tr>
					<th class="frist">No</th>
					<th>Nama</th>
					<th>Nilai</th>
					<th>Jumlah Benar</th>
					<th>Keterangan</th>
					<th>Nilai Minimum</th>
					<th>Tanggal Mulai</th>
					<th>Tanggal Selesai</th>
				</tr>
			</thead>
			<tbody>
				<?php if(count($datas) > 0) { ?>
					<?php $i = 1;foreach($datas as $rows) : 
						$ujian = $this->m_ujian->get_by(['uji.id'=>$rows->id_ujian]);
						$siswa = $this->m_siswa->get_by(['id'=>$rows->id_user]);
						$keterangan = ($rows->nilai >= $ujian->min_nilai) ? 'LULUS' : 'BELUM LULUS';
					?>
						<tr>
							<td><?= $i; ?></td>
							<td><?=$siswa->nama;?></td>
							<td><?=$rows->nilai;?></td>
							<td><?=$rows->jml_benar;?></td>
							<td><?=$keterangan;?></td>
							<td><?=$ujian->min_nilai;?></td>
							<td><?=$rows->tgl_mulai;?></td>
							<td><?=$rows->tgl_selesai;?></td>
						</tr>
					<?php $i++; endforeach; ?>
				<?php } else { ?>
					<tr>
						<td colspan="8" style="text-align: center;">Data Kosong</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</section>
</div>