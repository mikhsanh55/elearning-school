
<table class="table table-bordered table-striped table-hovered">
	<thead>
		<tr>
			<th class="text-left frist"><input type="checkbox" name="checkall" id="checkall"></th>
			<th class="frist">No</th>
			<th class="text-left">Nama</th>
			<th class="text-left">Bobot</th>
		</tr>
		<?php if(count($paginate['data']) > 0) { ?>
		<?php $i= $page_start; foreach ($paginate['data'] as $rows):
		?>
			<tr>
				<td class="text-left"><input type="checkbox" name="checklist[]" class="checklist" value="<?=$rows->id;?>"></td>
				<td align="center" class="frist"><?=$i;?></td>
				<td class="text-left"><?=$rows->nama;?></td>
				<td class="text-left"><?=$rows->bobot;?></td>
			</tr>
		<?php $i++;endforeach ?>
	<?php } else { ?>
		<tr>
		<td colspan="4" class="text-center">Data Kosong</td>
		</tr>
	<?php } ?>
	</thead>
<tbody>
</tbody>
</table>


