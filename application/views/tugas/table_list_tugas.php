
<table class="table table-bordered table-striped table-hovered">
	<thead>
		<tr>
			<th class="frist">No</th>
			<th>Kelas</th>
			<th>Mata Pelajaran</th>
			<th>Keterangan</th>
			<th>Waktu Pengumpulan</th>
			<th class="frist">Status Tugas</th>

		</tr>
		<?php if(count($paginate['data']) > 0) { ?>
		<?php $i= $page_start; foreach ($paginate['data'] as $rows):

			$count = $this->m_tugas_attach_siswa->count_by(array('id_tugas'=>$rows->id,'id_siswa'=>$this->akun->id));
			if ($rows->in_jadwal == FALSE && $count < 1) { // Jika melebihi tanggal deadline
				$status = '<button class="btn btn-dark btn-sm" disabled>Waktu Habis</button>';
			}
			else if ($count > 0) { // Jika sudah mengerjakan
				$status = '<button class="btn btn-success btn-sm kirim-tugas" data-id_tugas="'.encrypt_url($rows->id).'"><i class="fa fa-check"></i> Sudah</button>';
			}else if($count < 1 && $rows->in_jadwal == TRUE) { // Jika belum
				$status = '<button class="btn btn-danger btn-sm kirim-tugas" data-id_tugas="'.encrypt_url($rows->id).'"> Kerjakan</button>';
			}

			if (!empty($rows->end_date) && $rows->end_date != '0000-00-00 00:00:00') {
				$datetime1 = explode(' ', $rows->end_date);
				$date = longdate_indo($datetime1[0]).' Pukul '.$time = time_short($datetime1[1]);
				
			}else{
				$date = NULL;
			}
			$mapel = $this->m_mapel->get_by(['id' => $rows->id_mapel]);
			$nama_mapel = !empty($mapel->nama) ? $mapel->nama : '';	
		?>
			<tr>
				<td align="center" class="frist"><?=$i;?></td>
				<td><?=$rows->kelas;?></td>
				<td><?= $nama_mapel; ?></td>
				<td><?=$rows->keterangan;?></td>
				<td class="text-center"><?=$date;?></td>
				<td>
					<?=$status;?>
				</td>
			</tr>
		<?php $i++;endforeach ?>
		<?php } else { ?>
    	    <tr>
    	        <td colspan="6" class="text-center">Data Kosong</td>
    	    </tr>
    	<?php } ?>
	</thead>
<tbody>
</tbody>
</table>


