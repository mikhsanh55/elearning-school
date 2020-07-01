
<table id="custumtb">
	<thead>
		<tr>
			<th class="frist">No</th>
			<th>Kelas</th>
			<th>Keterangan</th>
			<th>Tanggal Selesai</th>
			<th class="frist">Terkumpul</th>

		</tr>
		<?php $i= $page_start; foreach ($paginate['data'] as $rows):
			$count = $this->m_tugas_attach_siswa->count_by(array('id_tugas'=>$rows->id,'id_siswa'=>$this->akun->id));
			if ($count > 0) {
				$status = '<button class="btn btn-success btn-sm kirim-tugas" data-id_tugas="'.encrypt_url($rows->id).'"><i class="fa fa-check"></i>Sudah</button>';
			}else{
				$status = '<button class="btn btn-danger btn-sm kirim-tugas" data-id_tugas="'.encrypt_url($rows->id).'">Tugas</button>';
			}

			if (!empty($rows->end_date) && $rows->end_date != '0000-00-00 00:00:00') {
				$datetime1 = explode(' ', $rows->end_date);
				$date = longdate_indo($datetime1[0]).' Pukul '.$time = time_short($datetime1[1]);
				
			}else{
				$date = NULL;
			}
		?>
			<tr>
				<td align="center" class="frist"><?=$i;?></td>
				<td><?=$rows->kelas;?></td>
				<td><?=$rows->keterangan;?></td>
				<td><?=$date;?></td>
				<td>
					<?=$status;?>
				</td>
			</tr>
		<?php $i++;endforeach ?>
	</thead>
<tbody>
</tbody>
</table>


