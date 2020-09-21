<table class="table table-bordered table-striped table-hovered" id="kelas-table">
	<thead>
		<tr>
			<th class="frist"><input type="checkbox" name="checkall" id="checkall"></th>
			<th class="frist">No</th>
			<th>Kelas</th>
			<th>Wali Kelas</th>
			<th class="frist">Opsi</th>
		</tr>
	</thead>
	<tbody>
		<?php if(count($paginate['data']) > 0) { ?>
		<?php $i = $paginate['counts']['from_num']; foreach($paginate['data'] as $rows) : ?>
			<tr>
				<td>
					<input type="checkbox" name="checklist[]" class="checklist" data-id= "<?=encrypt_url($rows->id);?>" value="<?=$rows->id;?>">
				</td>
				<td><?= $i; ?></td>
				<td>
					<?= $rows->nama; ?>
				</td>
				<td>
					<?= $rows->nama_guru; ?>
				</td>
				<td>
					<button class="btn btn-primary btn-sm mb-2" data-id="<?= $rows->id; ?>" onclick="displaySiswa(this)">Pilih Siswa</button>
					<button class="btn btn-primary btn-sm  mb-2" data-id="<?= $rows->id; ?>" onclick="displayMapel(this)">Pilih Mapel</button>
				</td>
			</tr>
		<?php $i++;endforeach; ?>
	<?php } ?>
	</tbody>
</table>
<script src="<?=base_url();?>assets/js/jquery/jquery-3.3.1.min.js"></script>
<script src="<?= base_url('assets/plugin/datatables/jquery.dataTables.min.js') ?>"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
<script>
	$(document).ready(function(){
		$('#kelas-table').DataTable({
			responsive: true,
			paging: false,
			info: false
		});
	})
</script>