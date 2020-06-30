<div class="row">
	<?php 
		$i= $page_start; foreach ($paginate['data'] as $rows):
	?>
	<div class="col-lg-4 col-sm-6">
		<div class="open-position">
			<div class="card" style="width: 18rem;">
				<?php 
				if (!empty($rows->video)) {
				if($rows->upload_manual == 1) { ?>
					<div class="embed-responsive embed-responsive-16by9" style="position:relative;">';
					<!-- <iframe  src="<?=$rows->video;?>" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe> -->
					<video controls Seeking>
						<source src="<?=$rows->video;?>" type="video/mp4">
						</video>

					<div style="width: 80px; height: 80px; position: absolute; opacity: 0; right: 0px; top: 0px; background:#000;">&nbsp;</div>
					</div>
				<?php } else { ?>
					<div class="embed-responsive embed-responsive-16by9" style="position:relative;">
					<iframe  src="https://drive.google.com/file/d/<?=$rows->video;?>/preview" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe>
					<div style="width: 80px; height: 80px; position: absolute; opacity: 0; right: 0px; top: 0px; background:#000;">&nbsp;</div>
					</div>
			<?php } } else {?>
					<img src="<?=base_url('assets/front/');?>images/example.jpg" class="card-img-top rounded img-thumbnail" alt="thumb-5">
			<?php } ?>
				<div class="card-body">
					<h5 class="card-title"><?=$rows->title;?></h5>
					<button type="button" class="btn btn-primary btn-sm">Diskusi</button>
					<?php if (isset($rows->file_pdf)): ?>
						<a href="<?= base_url('Materi/read_pdf') . '/' . md5($rows->id); ?>" target="_blank" class="m-2 btn btn-sm btn-danger">
							<i class="fa fa-fw fa-file-pdf-o"></i>PDF
						</a>  
						<?php else:?>
							<button type="button" class="btn btn-warning btn-sm"><i class="fa fa-fw fa-ban"></i>PDF </button>
						<?php endif ?>
					
					<button type="button" class="btn btn-primary btn-sm">Deskripsi </button>

				</div>
			</div>
		</div>
	</div>

<?php endforeach;?>
</div>
<?= $paging;?>