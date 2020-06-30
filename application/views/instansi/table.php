
<table id="custumtb">
	<thead>
		<tr>
			<th class="frist">No</th>
			<th>Instansi</th>
			<th>Kode</th>
			<th>Nama Pimpinan</th>
			<th>No Telp</th>
			<th>Alamat</>
			<th>Opsi</th>
		</tr>
		<?php $i= $page_start; foreach ($paginate['data'] as $rows): ?>
			<tr>
				<td align="center" class="frist"><?=$i;?></td>
				<td><?=$rows->instansi;?></td>
				<td align="center"><?=$rows->id;?></td>
				<td><?=$rows->nama_pimpinan;?></td>
				<td><?=$rows->no_telp;?></td>
				<td><?=$rows->alamat;?></td>
				<td class="frist">
					<a href="<?=base_url('instansi/aktivasi_materi/'.md5($rows->id));?>" data-toggle="tooltip" title="setting materi" class="btn btn-default btn-sm"><i class="fas fa-cog" style="color:green"></i></a>
					<?php if ($this->log_lvl == 'admin'): ?>
						
						<?php if ($rows->deleted == 0): ?>
							<span id="aktif_<?=$rows->id;?>"><a href="javascript:void(0);" data-toggle="tooltip" data-id="<?=$rows->id;?>" data-deleted="<?=$rows->deleted;?>" title="Non Aktifkan" class="btn btn-default btn-sm aktif_non"><i class="fas fa-eye-slash" style="color:red"></i></a></span>
							<?php else: ?>
								<span id="aktif_<?=$rows->id;?>"><a href="javascript:void(0);" data-toggle="tooltip" data-id="<?=$rows->id;?>" data-deleted="<?=$rows->deleted;?>" title="Aktifkan" class="btn btn-default btn-sm aktif_non"><i class="fas fa-eye" style="color:green"></i></a></span>
							<?php endif ?>

							<a href="<?=base_url('instansi/edit/'.md5($rows->id));?>" class="btn btn-default btn-sm" data-toggle="tooltip" title="edit instansi"><i class="fas fa-edit" style="color:blue"></i></a>
							<a href="<?=base_url('instansi/delete/'.md5($rows->id));?>" class="btn btn-default deleted btn-sm" data-toggle="tooltip" title="hapus instansi"><i class="fas fa-trash-alt" style="color:red"></i></a>

					<?php endif ?>
					
				</td>
			</tr>
		<?php $i++;endforeach ?>
	</thead>
<tbody>
</tbody>
</table>
<script type="text/javascript">
	$(document).on('ready',function(){
		$('[data-toggle="tooltip"]').tooltip();   
	});
	$('.deleted').click(function(){
		var y = confirm('Apakah anda yakin ingin mengapus data ini ?');
		if (y == true) {

		}else{
			return false
		}
	})

	$(document).on('click','.aktif_non',function(){
		var id = $(this).data('id');
		var deleted = $(this).data('deleted');

		if (deleted == 0) {
			var y = confirm('Apakah anda yakin ingin menonaktifkan data ini ?');
		}else{
			var y = confirm('Apakah anda yakin ingin mengaktifkan data ini ?');
		}

		
		if (y == true) {

			$.ajax({
				type : 'post',
				url  : '<?=base_url('instansi/aktif_non');?>',
				dataType : 'json',
				data : {
					id : id,
					deleted : deleted
				},
				success:function(response){
					
					if (response.deleted == 0) {
						var button = '<a href="javascript:void(0);" data-toggle="tooltip" data-id="'+id+'" data-deleted="'+response.deleted+'" title="Non Aktifkan" class="btn btn-default btn-sm aktif_non"><i class="fas fa-eye-slash" style="color:red"></i></a>';
					}else{
						var button = '<a href="javascript:void(0);" data-toggle="tooltip" data-id="'+id+'" data-deleted="'+response.deleted+'" title="Aktifkan" class="btn btn-default btn-sm aktif_non"><i class="fas fa-eye" style="color:green"></i></a>';
					}
					
					$('#aktif_' + response.id).html(button)
		
				}
			})

		}else{
			return false
		}


	})
</script>
