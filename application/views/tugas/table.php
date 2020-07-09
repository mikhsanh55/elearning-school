	
<table id="custumtb">
	<thead>
		<tr>
			<th class="frist"><input type="checkbox" name="checkall" id="checkall"></th>
			<th class="frist">No</th>
			<th>Kelas</th>
			<th>Mata Pelajaran</th>
			<th>Keterangan</th>
			<th>Opsi</th>
		</tr>
		<?php  $i= $page_start; foreach ($paginate['data'] as $rows):
			$mapel = $this->m_mapel->get_by(['id' => $rows->id_mapel]);
			$nama_mapel = !empty($mapel->nama) ? $mapel->nama : '';	
		?>
			<tr>
				<td><input type="checkbox" name="checklist[]" class="checklist" value="<?=$rows->id;?>" data-id="<?=md5($rows->id);?>"></td>
				<td align="center" class="frist"><?=$i;?></td>
				<td><?=$rows->kelas;?></td>
				<td><?=$rows->nama_mapel;?></td>
				<td><?=$rows->keterangan;?></td>
				<td>
					<a href="<?=base_url('tugas/lampiran/'.md5($rows->id));?>" class="" title="Lampiran"><i class="fa fa-paperclip" style="font-size: 25px;"></i></a>
					<a href="<?=base_url('tugas/siswa_list/'.encrypt_url($rows->id));?>" class="" title="Siswa"><i class="fa fa-users fa-6" style="font-size: 25px;"></i></a>
				</td>
			</tr>
		<?php $i++;endforeach ?>
	</thead>
<tbody>
</tbody>
</table>


