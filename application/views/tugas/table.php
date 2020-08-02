	
<table class="table table-bordered table-striped table-hovered">
	<thead>
		<tr>
			<th class="frist"><input type="checkbox" name="checkall" id="checkall"></th>
			<th class="frist">No</th>
			<th>Kelas</th>
			<th>Mata Pelajaran</th>
			<th>Waktu Pengumpulan</th>
			<th>Opsi</th>
		</tr>
		<?php if(count($paginate['data']) > 0) { ?>
		<?php  $i= $page_start; foreach ($paginate['data'] as $rows):
			$mapel = $this->m_mapel->get_by(['id' => $rows->id_mapel]);
			$nama_mapel = !empty($mapel->nama) ? $mapel->nama : '';	
			if (!empty($rows->end_date) && $rows->end_date != '0000-00-00 00:00:00') {
				$datetime1 = explode(' ', $rows->end_date);
				$date = longdate_indo($datetime1[0]).' Pukul '.$time = time_short($datetime1[1]);
				
			}else{
				$date = NULL;
			}
		?>
			<tr>
				<td><input type="checkbox" name="checklist[]" class="checklist" value="<?=$rows->id;?>" data-id="<?=md5($rows->id);?>"></td>
				<td align="center" class="frist"><?=$i;?></td>
				<td><?=$rows->kelas;?></td>
				<td><?=$rows->nama_mapel;?></td>
				<td class="text-center"><?=$date;?></td>
				<td>
					<a href="<?=base_url('tugas/lampiran/'.md5($rows->id));?>" class="" title="Lampiran"><i class="fa fa-paperclip" style="font-size: 25px;"></i></a>
					<a href="<?=base_url('tugas/siswa_list/'.encrypt_url($rows->id));?>" class="" title="Siswa"><i class="fa fa-users fa-6" style="font-size: 25px;"></i></a>
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


