<?php if(count($attach) > 0) { ?>
	<p><strong>File yang sudah terupload :</strong></p>
<?php $i = 1; foreach ($attach as $key => $file):?>
	<!-- <i class="<?=$type[$val->format];?>" style="color: <?=$color[$val->format];?>"></i> 
	<?=$val->file;?>
	<a href="javascript:void(0);" class="delete-file" data-id = "<?=$val->id;?>" data-location='assets/tugas/attach/<?=$val->file;?>'><i class="fa fa-times" style="color: red;"></i> </a> -->
	<span class="alert alert-success">
		<a href="<?= base_url('assets/tugas/attach/') . $file->file; ?>" download class="text-primary"><?= $i++ . '. ' . $file->file; ?></a> <a href="javascript:void(0);" class="btn btn-sm btn-danger ml-2 delete-file-tugas" data-id="<?= $file->id; ?>"><i class="fas fa-trash"></i></a>
	</span>
	<br>
<?php endforeach ?>
<?php } else { ?>
	<p class="alert alert-warning text-left">
		Tidak ada file
	</p>
<?php } ?>