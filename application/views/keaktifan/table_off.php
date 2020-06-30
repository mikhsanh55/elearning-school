
<table id="custumtb">
	<thead>
		<tr>
			<th class="frist">No</th>
			<th>Nama</th>
			<th>NRP</th>
			<th>Login</th>
			<th>Belajar</th>
			<th>Diskusi</th>
			<th class="frist">Offline (0/100)</th>
			<th class="frist">Nilai (0/100)</th>
		</tr>
		<?php $i= $page_start; foreach ($paginate['data'] as $rows):
				$siswa = $this->m_siswa->get_by(['id'=>$rows->id_peserta]);
				$total = $this->m_keaktifan_total->get_by(['id_kelas'=>$rows->id_kelas,'id_siswa'=>$rows->id_peserta]);
				if(empty($total->nilai)){
					$textNilaiTotal = '<input type="text" value="" maxlength="300" style="height:30px;" class="beri-nilai-aktif form-control input-sm only-number" data-siswa="'.$rows->id_peserta.'" data-kelas="'.$rows->id_kelas.'">';
				}else{
					$textNilaiTotal = '<input type="text" value="'.$total->nilai.'" maxlength="300" style="height:30px;" class="beri-nilai-aktif form-control input-sm only-number" data-siswa="'.$rows->id_peserta.'" data-kelas="'.$rows->id_kelas.'">';
				}
				
				$textNilai = '<input type="text" value="'.$rows->nilai.'" maxlength="300" style="height:30px;" class="beri-nilai form-control input-sm only-number" data-siswa="'.$rows->id_peserta.'" data-kelas="'.$rows->id_kelas.'">';
		?>
			<tr>
				<td align="center" class="frist"><?=$i;?></td>
				<td><?=$rows->nama;?></td>
				<td><?=$rows->nrp;?></td>
				<td><?=$siswa->active_num;?></td>
				<td><?=$siswa->active_video + $siswa->active_read;?></td>
				<td>0</td>
				<td>
					<?=$textNilai;?>
				</td>
				<td>
					<?=$textNilaiTotal;?>
				</td>
			</tr>
		<?php $i++;endforeach ?>
	</thead>
<tbody>
</tbody>
</table>


