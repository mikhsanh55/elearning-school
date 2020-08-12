<style>
	.container {
		margin: 10px;
	}
	table {
		display: block;
		width: 100%;
		border-collapse: collapse;
	}
	td,th {
		padding:10px;		
	}
</style>
<div class="container">
<table id="custumtb" border="1">
	<thead>
		<tr>
			<th class="frist">No</th>
			<th style="width: 30%;">Nama</th>
			<th>Kelas</th>
			<th>Nilai</th>
			<th>Nilai Minimum</th>
			<th style="width: 30%;">Keterangan</th>
			
			<th>Tanggal Mulai</th>
			<th>Tanggal Selesai</th>
		</tr>
		<?php if(count($datas) > 0) { $i= 1; foreach ($datas as $rows):
			$ujian = $this->m_ujian->get_by(['uji.id'=>$rows->id_ujian]);
			$nilai = $this->db->select('sum(nilai) as total')->where('id_ikut_essay',$rows->id)->get('tb_jawaban_essay')->row();
			$keterangan = ($nilai->total >= $ujian->min_nilai) ? 'LULUS' : 'BELUM LULUS';
		?>
			<tr>
				<td align="center" class="frist"><?=$i;?></td>
				<td><?=$rows->nama_siswa;?></td>
				<td><?=$rows->nama_kelas;?></td>
				<td><?=$nilai->total;?></td>
				<td><?=$ujian->min_nilai;?></td>
				<td><?=$keterangan;?></td>
				<td><?=$rows->tgl_mulai;?></td>
				<td><?=$rows->tgl_selesai;?></td>
			</tr>
		<?php $i++;endforeach; } else { ?>
			<tr>
				<td colspan="8" class="text-center">Data Kosong</td>
			</tr>
		<?php } ?>
	</thead>
	<tbody>
	</tbody>
</table>
</div>