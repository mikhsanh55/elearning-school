
<table id="custumtb">
	<thead>
		<tr>
			<th class="frist"><input type="checkbox" name="checkall" id="checkall"></th>
			<th class="frist">No</th>
			<th class="frist">Kode</th>
			<th class="text-left">Jurusan</th>
			<?php if($this->log_lvl == 'admin'):?>
				<th><?=$this->transTheme->instansi;?></th>
			<?php endif;?>
			<th style="width: 10%">Opsi</th>
		</tr>
		<?php if(count($paginate['data']) > 0) { ?>
		<?php $i= $page_start; foreach ($paginate['data'] as $rows):

		?>
			<tr>
				<td><input type="checkbox" name="checklist[]" class="checklist" data-id= "<?=encrypt_url($rows->id);?>" value="<?=$rows->id;?>"></td>
				<td align="center" class="frist"><?=$i;?></td>
				<td><?=$rows->kode;?></td>
				<td><?=$rows->jurusan;?></td>
				<?php if($this->log_lvl == 'admin'):?>
					<td><?=$rows->nama_instansi;?></td>
				<?php endif;?>
				<td class="text-center">
					
					<a href="<?= base_url('kelas/riwayat-mengajar/') . urlencode($rows->id); ?>" class="btn btn-primary btn-sm">Riwayat Mengajar</a>
				</td>
			</tr>
		<?php $i++;endforeach ?>
		<?php } else { ?>
			<tr>
			<?php if($this->log_lvl == 'admin') { ?>
				<td class="text-center" colspan="6">Data Kosong</td>
			<?php } else { ?>
				<td class="text-center" colspan="5">Data Kosong</td>
			<?php } ?>
			</tr>
		<?php } ?>
	</thead>
<tbody>
</tbody>
</table>


