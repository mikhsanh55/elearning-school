
<table id="custumtb">
	<thead>
		<tr>
			<th class="frist"><input type="checkbox" name="checkall" id="checkall"></th>
			<th class="frist">No</th>
			<th>Nama Paket Soal EDOPM</th>
			<?php if($this->log_lvl == 'admin'):?>
				<th><?=$this->transTheme->instansi;?></th>
			<?php endif;?>
			<th class="frist">Opsi</th>
		</tr>
		<?php $i= $page_start; foreach ($paginate['data'] as $rows):

		?>
			<tr>
				<td><input type="checkbox" name="checklist[]" class="checklist" data-id= "<?=encrypt_url($rows->id);?>" value="<?=$rows->id;?>"></td>
				<td align="center" class="frist"><?=$i;?></td>
				<td><?=$rows->nama;?></td>
					<?php if($this->log_lvl == 'admin'):?>
						<td><?=$rows->nama_instansi;?></td>
					<?php endif;?>
				<td><a href="<?=base_url('penilaian/data_soal/'.encrypt_url($rows->id));?>" title="tambah soal" id="tambah-soal" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> &nbsp;Detail Soal</a></td>
				
			</tr>
		<?php $i++;endforeach ?>
	</thead>
<tbody>
</tbody>
</table>


