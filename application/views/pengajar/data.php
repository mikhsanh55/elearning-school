<div class="row">
	<?php $i= $page_start; foreach ($paginate['data'] as $rows):
	?>
	<div class="col-lg-4 col-sm-6">
		<div class="open-position">
			<div class="card" style="width: 18rem;">
				<!-- <img src="<?=base_url('assets/front/');?>images/example.jpg" class="card-img-top rounded img-thumbnail" alt="thumb-5"> -->
				<div class="card-body">
					<p class="card-text"><strong><?=$rows->nama_guru;?></strong></p>
					<h5 class="card-title"><?=$rows->nama_mapel;?></h5>



				</div>
			</div>
		</div>
	</div>
<?php endforeach;?>
</div>
<?= $paging;?>