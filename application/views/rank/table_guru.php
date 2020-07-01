
<table id="custumtb">
	<thead>
		<tr>
			<th class="frist">No</th>
			<th><?=$this->transTheme->siswa;?></th>
			<th><?=$this->transTheme->guru;?></th>
			<th>Frekuensi</th>
			<th>Persentase</th>
		</tr>
		<?php $i= $page_start; foreach ($paginate['data'] as $rows): 
			$presentase = ($rows->jumlah/$rows->total) * 100;
			$pesent = number_format($presentase, 2);
		?>
			<tr>
				<td align="center" class="frist"><?=$i;?></td>
				<td><?=$rows->nama;?></td>
				<td><?=$rows->nama_guru;?></td>
				<td align="center" class="frist"><button class="btn btn-success"><strong><?=$rows->jumlah;?></strong></button></td>
				<td>
					<div class="progress">
						<div class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="<?=$presentase;?>" aria-valuemin="0" aria-valuemax="100" style="width:<?=$presentase;?>%">
							 <?=$pesent.'%';?>
						</div>
					</div>
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
