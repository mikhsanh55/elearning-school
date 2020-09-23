<table class="table table-bordered table-striped table-hovered">
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
	</thead>
	<tbody>
		<?php if(count($paginate['data']) > 0) { ?>
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
		<?php }?>
			
	</tbody>
</table>
<script src="<?=base_url();?>assets/js/jquery/jquery-3.3.1.min.js"></script>
<script src="<?= base_url('assets/plugin/datatables/jquery.dataTables.min.js') ?>"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
<script>
	$(document).ready(function() {
		$('table').DataTable({
			responsive: true,
			paging: false,
			info: false
		});
	})
</script>