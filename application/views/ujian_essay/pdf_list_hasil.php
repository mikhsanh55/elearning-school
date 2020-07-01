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
			<th>Nilai</th>
			<th style="width: 30%;">Keterangan</th>
			<th>Nilai Minimum</th>
			<th>Tanggal Mulai</th>
			<th>Tanggal Selesai</th>
		</tr>
		<?php $i= 1; foreach ($datas as $rows):
			$ujian = $this->m_ujian->get_by(['uji.id'=>$rows->id_ujian]);
			$siswa = $this->m_siswa->get_by(['id'=>$rows->id_user]);
			$nilai = $this->db->select('sum(nilai) as total')->where('id_ikut_essay',$rows->id)->get('tb_jawaban_essay')->row();
			$keterangan = ($nilai->total >= $ujian->min_nilai) ? 'LULUS' : 'BELUM LULUS';
		?>
			<tr>
				<td align="center" class="frist"><?=$i;?></td>
				<td><?=$siswa->nama;?></td>
				<td><?=$nilai->total;?></td>
				<td><?=$keterangan;?></td>
				<td><?=$ujian->min_nilai;?></td>
				<td><?=$rows->tgl_mulai;?></td>
				<td><?=$rows->tgl_selesai;?></td>
			</tr>
		<?php $i++;endforeach ?>
	</thead>
	<tbody>
	</tbody>
</table>
</div>