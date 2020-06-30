
<table id="custumtb">
	<thead>
		<tr>
			<th><input type="checkbox" name="checkall" id="checkall"></th>
			<th class="frist">No</th>
			<th>Nama</th>
			<th>Username</th>
			<th>
<<<<<<< HEAD
				<?= $this->nrp; ?>
=======
				NIS
>>>>>>> first push
			</th>
			<th><?=$this->transTheme->instansi;?></th>
			<th>Opsi</th>
		</tr>
		<?php if(count($paginate['data']) > 0) { ?>
		<?php $i= $page_start; foreach ($paginate['data'] as $rows):
			$get = $this->m_admin->get_by(array('level'=>'siswa','kon_id'=>$rows->id));
		?>
			<tr>
				<td><input type="checkbox" name="checklist[]" class="checklist" value="<?=$rows->id;?>"></td>
				<td align="center" class="frist"><?=$i;?></td>
				<td><?=$rows->nama;?></td>
				<td><?=$rows->username;?></td>
				<td><?=$rows->nrp;?></td>
				<td><?=$rows->nama_instansi;?></td>
				<td class="frist">
					<button class="btn btn-primary btn-sm btn-restore" data-id="<?= $rows->id ?>" data-graduated="1">
						<i class="fas fa-undo"> </i> &nbsp;Restore
					</button>
				</td>	
			</tr>
		<?php $i++;endforeach ?>
	<?php } else { ?>
		<tr>
			<td colspan="7" class="text-center">Data Kosong</td>
		</tr>
	<?php } ?>
	</thead>
<tbody>
</tbody>
</table>


