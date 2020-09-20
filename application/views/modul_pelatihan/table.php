
<table class="table table-bordered table-striped table-hovered">
	<thead>
		<tr>
			<th class="frist">No</th>
			<th>Kode Mata Pelajaran</th>
			<th>Mata Pelajaran</th>
			<th>Opsi</th>
		</tr>
		<?php if(count($paginate['data']) > 0) { ?>
		<?php $i= $page_start; foreach ($paginate['data'] as $rows):
			$instansi = $this->m_instansi->get_by(['id'=>$rows->id_instansi]);
		?>
			<tr>
				<td align="center" class="frist"><?=$i;?></td>
				<td><?=$rows->kd_mp;?></td>
				<td><?=$rows->nama;?></td>
		
				<td class="frist">


					<?php
	
						echo '<div class="btn-group mx-auto d-flex justify-content-center">
						<a class="btn btn-primary btn-sm mr-2 lihat-trainer" data-id="'.$rows->id.'" href="javascript:void(0);"><i class="glyphicon glyphicon-eye" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;'.$this->transTheme->guru.'</a>
						<div class="btn-group mx-auto d-flex justify-content-center">
						<a class="btn btn-primary btn-sm mr-2" data-mapel="'.$rows->id.'" href="#" data-href="'.base_url('Materi/lists').'/'.md5($rows->id).'" onclick="saveSess(this)" ><i class="glyphicon glyphicon-eye" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Materi</a>
						<a href="#" data-id="'.encrypt_url($rows->id).'" class="btn btn-info btn-sm mr-2 edit-btn"><i class="glyphicon glyphicon-pencil" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Edit</a>
						<a href="#" class="btn btn-danger btn-sm mr-2 delete-mapel" data-id="'. encrypt_url($rows->id) .'"><i class="glyphicon glyphicon-remove" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Hapus</a>
						';
					?>
				</td>	
			</tr>
		<?php $i++;endforeach ?>
		<?php } else { ?>
			<tr>
				<td class="text-center" colspan="3">Data Kosong</td>
			</tr>
		<?php } ?>
	</thead>
<tbody>
</tbody>
</table>
<script>
	// When click edit button
	$('.edit-btn').on('click', function(e) {
		e.preventDefault();
		$('#gambar-sampul-wrapper').empty(); // empty the existing image
		$('#mode').val('edit'); // Set mode to Update mode
		$('#id').val($(this).data('id'));
		$.ajax({
			type: 'post',
			url: "<?= base_url('mapel/getDetail') ?>",
			data: {
				id: $(this).data('id')
			},
			dataType: 'json',
			success: res => {
				$('#kd_mp').val(res.data.kd_mp);
				$('#nama').val(res.data.nama);
				if(res.data.file != null) {
					var html = `
						<img class="img-thumbnail" width="100" height="100" src="${res.data.file}" />
					`;
					$('#gambar-sampul-wrapper').html(html);
				}
			},
			error: e => {
				console.error(e.responseText);
				alert(e.responseText.msg);
				return false;
			}
		});

		$('#m_mapel').modal('show');
	});

	$('.delete-mapel').on('click', function(e) {
		e.preventDefault();
		conf = confirm('Anda yakin akan menghapus Mata Pelajaran ini? Data materi didalam mapel ini akan diarsipkan ( TIDAK DIHAPUS )');

		if(conf) {
			$.ajax({
				type: 'post',
				url: "<?= base_url('mapel/delete') ?>",
				data: {
					id: $(this).data('id')
				},
				dataType: 'json',
				success: res => {
					if(res.status) {
						pageLoad(1,'dtest/page_load');
					}
				},
				error: e => {
					alert(e.responseJSON.msg);
					console.error(e.responseJSON);
					return false;
				}
			});
		}
	});
</script>


