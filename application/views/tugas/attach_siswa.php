<<<<<<< HEAD
<?php foreach ($attach as $key => $val):?>
	<i class="<?=$type[$val->format];?>" style="color: <?=$color[$val->format];?>"></i> 
	<?=$val->file;?>
	<a href="javascript:void(0);" class="delete-file" data-id = "<?=$val->id;?>" data-location='assets/tugas/attach_siswa/<?=$val->file;?>'><i class="fa fa-times" style="color: red;"></i> </a>
	<br>
=======
<?php foreach ($attach as $key => $val):?>
	<i class="<?=$type[$val->format];?>" style="color: <?=$color[$val->format];?>"></i> 
	<?=$val->file;?>
	<a href="javascript:void(0);" class="delete-file" data-id = "<?=$val->id;?>" data-location='assets/tugas/attach_siswa/<?=$val->file;?>'><i class="fa fa-times" style="color: red;"></i> </a>
	<br>
>>>>>>> first push
<?php endforeach ?>