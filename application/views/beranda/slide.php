<?php foreach ($slide as $key => $val):?>
	<i class=""></i> 
	<img src="<?=base_url('upload/slide/'.$val->file);?>" height="100" width="auto">
	<a href="javascript:void(0);" class="delete-file" data-id = "<?=$val->id;?>" data-location='upload/slide/<?=$val->file;?>'><i class="fa fa-times" style="color: red;"></i> </a>
<?php endforeach ?>
<br><br><br>