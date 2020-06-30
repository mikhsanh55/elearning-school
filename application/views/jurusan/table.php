
<table id="custumtb">
	<thead>
		<tr>
			<th class="frist"><input type="checkbox" name="checkall" id="checkall"></th>
			<th class="frist">No</th>
			<th class="frist">Kode</th>
			<th>Jurusan</th>
			<?php if($this->log_lvl == 'admin'):?>
				<th><?=$this->transTheme->instansi;?></th>
			<?php endif;?>
		</tr>
		<?php $i= $page_start; foreach ($paginate['data'] as $rows):

		?>
			<tr>
				<td><input type="checkbox" name="checklist[]" class="checklist" data-id= "<?=encrypt_url($rows->id);?>" value="<?=$rows->id;?>"></td>
				<td align="center" class="frist"><?=$i;?></td>
				<td><?=$rows->id;?></td>
				<td><?=$rows->jurusan;?></td>
				<?php if($this->log_lvl == 'admin'):?>
					<td><?=$rows->nama_instansi;?></td>
				<?php endif;?>
				
			</tr>
		<?php $i++;endforeach ?>
	</thead>
<tbody>
</tbody>
</table>


