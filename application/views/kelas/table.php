<table id="custumtb">
	<thead>
		<tr>
			<th class="frist"><input type="checkbox" name="checkall" id="checkall"></th>
			<th class="frist">No</th>
<<<<<<< HEAD
			<th>Kelas</th>
			<th>Mata Kuliah</th>
=======
			<th>Room</th>
			<th>Mata Pelajaran</th>
>>>>>>> first push
			<th>Keterangan</th>
			<th  class="frist">Total Siswa</th>
			<th class="frist">Opsi</th>
		</tr>
		<?php $i= $page_start; foreach ($paginate['data'] as $rows):
			$jml_siswa = $this->m_detail_kelas->count_by(['id_kelas'=>$rows->id]);
		?>
			<tr>
				<td><input type="checkbox" name="checklist[]" class="checklist" data-id= "<?=encrypt_url($rows->id);?>" value="<?=$rows->id;?>"></td>
				<td align="center" class="frist"><?=$i;?></td>
				<td><?=$rows->nama;?></td>
				<td><?=$rows->nama_mapel;?></td>
				<td><?=$rows->keterangan;?></td>
				<td><?=$jml_siswa;?></td>
				<td class="frist">
					<button class="btn btn-primary btn-sm rekrut" data-id="<?=$rows->id;?>" data-jurusan="<?=$rows->id_jurusan;?>">Pilih siswa</button>
				</td>	
			</tr>
		<?php $i++;endforeach ?>
	</thead>
<tbody>
</tbody>
</table>


