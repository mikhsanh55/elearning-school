<table id="custumtb">
	<thead>
		<tr>
			<th class="frist"><input type="checkbox" name="checkall" id="checkall"></th>
			<th class="frist">No</th>
			<th><?= $this->name; ?></th>
			<th>Mata Pelajaran</th>
			<th>Keterangan</th>
			<th class="frist">Opsi</th>
		</tr>
		<?php $i= $page_start; foreach ($paginate['data'] as $rows):
			
		?>
			<tr>
				<td><input type="checkbox" name="checklist[]" class="checklist" data-id= "<?=encrypt_url($rows->id);?>" value="<?=$rows->id;?>"></td>
				<td align="center" class="frist"><?=$i;?></td>
				<td><?=$rows->nama;?></td>
				<td><?=$rows->nama_mapel;?></td>
				<td><?=$rows->keterangan;?></td>
				<td class="frist">
				<div class="btn-group d-flex justify-content-center">
					<a class="btn btn-success btn-sm hit-btn mr-2" href="<?=base_url('materi/lists/').md5($rows->id_mapel);?>">Mulai Belajar</a>
					<!-- Tombol Materi untuk peserta sebelumnya -->
					<!-- <a class="btn btn-success btn-sm hit-btn mr-2" href="<?=base_url('materi/materi_kelas/').encrypt_url($rows->id);?>"><i class="glyphicon glyphicon-eye" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Materi</a> -->
					<!--<a class="btn btn-danger btn-sm  mr-2"  href="<?=base_url('ujian/ikuti_ujian').'/'.md5($rows->id_mapel);?>" data-mapel="'<?=$rows->id_mapel;?>'"><i class="glyphicon glyphicon-eye" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Kuis</a>-->
				</td>	
			</tr>
		<?php $i++;endforeach ?>
	</thead>
<tbody>
</tbody>
</table>


