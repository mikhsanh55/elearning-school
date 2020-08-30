<h3>
	Data Hasil Ujian Kelas : <?= $nama_kelas; ?>
</h3>
	<h3>Guru : <?= $nama_guru; ?></h3>
	<h3>Mata Pelajaran : <?= $nama_mapel; ?></h3>

<br>
<style>
	.container {
		margin: 10px;
	}
	table {
		width: 100%;
		border-collapse: collapse;
	}
	td,th {
		padding:10px;		
	}
	.text-center {
		text-align: center;
	}
	.text-left {
		text-align: left;
	}
</style>

<div class="container">
	<table id="custumtb" border="1">
		<thead>
			<tr>
				<th class="frist">No</th>
				<th style="width: 30%;" class="text-left">Nama</th>
				<th class="text-center">Kelas</th>
				<th class="text-center">Nilai</th>
				<th class="text-center">Nilai Minimum</th>
				<th style="width: 30%;" class="text-left">Keterangan</th>
				
				<th class="text-center">Tanggal Mulai</th>
				<th class="text-center">Tanggal Selesai</th>
			</tr>
		</thead>
		<tbody>
			<?php if(count($datas) > 0) { $i= 1; foreach ($datas as $rows):
				$ujian = $this->m_ujian->get_by(['uji.id'=>$rows->id_ujian]);
				$nilai = $this->db->select('sum(nilai) as total')->where('id_ikut_essay',$rows->id)->get('tb_jawaban_essay')->row();
				$keterangan = ($nilai->total >= $ujian->min_nilai) ? 'LULUS' : 'BELUM LULUS';
			?>
				<tr>
					<td class="frist"><?=$i;?></td>
					<td><?=$rows->nama_siswa;?></td>
					<td class="text-center"><?=$rows->nama_kelas;?></td>
					<td class="text-center"><?=$nilai->total;?></td>
					<td class="text-center"><?=$ujian->min_nilai;?></td>
					<td><?=$keterangan;?></td>
					<td class="text-center"><?= date('d-m-Y H:i:s', strtotime($rows->tgl_mulai));?></td>
					<td class="text-center"><?= date('d-m-Y H:i:s', strtotime($rows->tgl_selesai));?></td>
				</tr>
			<?php $i++;endforeach; } else { ?>
				<tr>
					<td colspan="8" class="text-center">Data Kosong</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>