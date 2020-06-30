<<<<<<< HEAD
<?php if(!isset($paginate['template_view']))
$paginate['template_view'] = 'contain_view';
?>

<nav aria-label="Page navigation" style="font-size: 12px;float: right;">
	<ul class="pagination">
		<?php if ($paginate['counts']['curr_page'] == 1): ?>
			<li class = "active">
				<a href="javascript:void(0)" aria-label="First">
					<span aria-hidden="true"><i class="fa fa-angle-double-left"></i> First</span>
				</a>
			</li>
			<?php else: ?>
				<li>
					<a href="javascript:void(0)" aria-label="First"  onclick="pageLoad(1,'<?=$paginate['url'];?>','<?=$paginate['template_view'];?>')">
						<span aria-hidden="true"><i class="fa fa-angle-double-left"></i>First</span>
					</a>
				</li>
			<?php endif ?>
			<?php
			$count = 1;
			if($paginate['counts']['total_num'] > 0)
				$count = ceil($paginate['counts']['total_num']/$paginate['counts']['limit']);

			$page_show = 2;
			$page_start = $paginate['counts']['curr_page'] - $page_show;
			$page_start = $page_start < 1 ? 1 : $page_start;

			$page_end = $paginate['counts']['curr_page'] + $page_show;
			$page_end = $count > $page_end ? $page_end : $count;
			$page_end = $count > 1 ? $page_end : 1;

			?>

			<?php if($page_start > 1): ?>
				<li><a href="javascript:void(0)" onclick="pageLoad('<?=$paginate['counts']['curr_page'] - 1;?>','<?=$paginate['url'];?>','<?=$paginate['template_view'];?>')"> <i class="fa fa-angle-left"></i> Prev </a></li>
				<li><a href="javascript:void(0)"> ... </a></li>
			<?php endif;?>

			<?php for($i = $page_start; $i <= $page_end; $i++):	?>			


				<?php if ($paginate['counts']['curr_page'] == $i): ?>
					<li class = "active">
						<a href="javascript:void(0)"><?=$i;?></a>
					</li>
					<?php else: ?>
						<li>
							<a href="javascript:void(0)" onclick="pageLoad('<?=$i;?>','<?=$paginate['url'];?>','<?=$paginate['template_view'];?>')"><?=$i;?></a>
						</li>
					<?php endif ?>

				<?php endfor;?>

				<?php if($page_end < $count):?>
					<li><a href="javascript:void(0)"> ... </a></li>
					<li><a href="javascript:void(0)" onclick="pageLoad('<?=$paginate['counts']['curr_page'] + 1;?>','<?=$paginate['url'];?>','<?=$paginate['template_view'];?>')"> Next <i class="fa fa-angle-right"></i> </a></li>
				<?php 
					endif;
				?>


				<?php if ($paginate['counts']['curr_page'] == $count): ?>
					<li class = "active">
						<a href="javascript:void(0)" aria-label="Last" onclick="pageLoad('<?=$count;?>','<?=$paginate['url'];?>','<?=$paginate['template_view'];?>')">
							<span aria-hidden="true">Last <i class="fa fa-angle-double-right"></i></span>
						</a>
					</li>
					<?php else: ?>
						<li>
							<a href="javascript:void(0)" aria-label="Last" onclick="pageLoad('<?=$count;?>','<?=$paginate['url'];?>','<?=$paginate['template_view'];?>')">
								<span aria-hidden="true">Last <i class="fa fa-angle-double-right"></i></span>
							</a>
						</li>
					<?php endif ?>
					<li>
						<a href="javascript:void(0)" aria-label="Last" onclick="pageLoad('<?=$count;?>','<?=$paginate['url'];?>','<?=$paginate['template_view'];?>')">
							<span aria-hidden="true">Show <?=$paginate['counts']['from_num']?> To <?=$paginate['counts']['to_num']?> From <?=$paginate['counts']['total_num'];?></span>
						</a>
					</li>
				</ul>
			</nav>
		</div>

=======
<?php if(!isset($paginate['template_view']))
$paginate['template_view'] = 'contain_view';
?>

<nav aria-label="Page navigation" style="font-size: 12px;float: right;">
	<ul class="pagination">
		<?php if ($paginate['counts']['curr_page'] == 1): ?>
			<li class = "active">
				<a href="javascript:void(0)" aria-label="First">
					<span aria-hidden="true"><i class="fa fa-angle-double-left"></i> First</span>
				</a>
			</li>
			<?php else: ?>
				<li>
					<a href="javascript:void(0)" aria-label="First"  onclick="pageLoad(1,'<?=$paginate['url'];?>','<?=$paginate['template_view'];?>')">
						<span aria-hidden="true"><i class="fa fa-angle-double-left"></i>First</span>
					</a>
				</li>
			<?php endif ?>
			<?php
			$count = 1;
			if($paginate['counts']['total_num'] > 0)
				$count = ceil($paginate['counts']['total_num']/$paginate['counts']['limit']);

			$page_show = 2;
			$page_start = $paginate['counts']['curr_page'] - $page_show;
			$page_start = $page_start < 1 ? 1 : $page_start;

			$page_end = $paginate['counts']['curr_page'] + $page_show;
			$page_end = $count > $page_end ? $page_end : $count;
			$page_end = $count > 1 ? $page_end : 1;

			?>

			<?php if($page_start > 1): ?>
				<li><a href="javascript:void(0)" onclick="pageLoad('<?=$paginate['counts']['curr_page'] - 1;?>','<?=$paginate['url'];?>','<?=$paginate['template_view'];?>')"> <i class="fa fa-angle-left"></i> Prev </a></li>
				<li><a href="javascript:void(0)"> ... </a></li>
			<?php endif;?>

			<?php for($i = $page_start; $i <= $page_end; $i++):	?>			


				<?php if ($paginate['counts']['curr_page'] == $i): ?>
					<li class = "active">
						<a href="javascript:void(0)"><?=$i;?></a>
					</li>
					<?php else: ?>
						<li>
							<a href="javascript:void(0)" onclick="pageLoad('<?=$i;?>','<?=$paginate['url'];?>','<?=$paginate['template_view'];?>')"><?=$i;?></a>
						</li>
					<?php endif ?>

				<?php endfor;?>

				<?php if($page_end < $count):?>
					<li><a href="javascript:void(0)"> ... </a></li>
					<li><a href="javascript:void(0)" onclick="pageLoad('<?=$paginate['counts']['curr_page'] + 1;?>','<?=$paginate['url'];?>','<?=$paginate['template_view'];?>')"> Next <i class="fa fa-angle-right"></i> </a></li>
				<?php 
					endif;
				?>


				<?php if ($paginate['counts']['curr_page'] == $count): ?>
					<li class = "active">
						<a href="javascript:void(0)" aria-label="Last" onclick="pageLoad('<?=$count;?>','<?=$paginate['url'];?>','<?=$paginate['template_view'];?>')">
							<span aria-hidden="true">Last <i class="fa fa-angle-double-right"></i></span>
						</a>
					</li>
					<?php else: ?>
						<li>
							<a href="javascript:void(0)" aria-label="Last" onclick="pageLoad('<?=$count;?>','<?=$paginate['url'];?>','<?=$paginate['template_view'];?>')">
								<span aria-hidden="true">Last <i class="fa fa-angle-double-right"></i></span>
							</a>
						</li>
					<?php endif ?>
					<li>
						<a href="javascript:void(0)" aria-label="Last" onclick="pageLoad('<?=$count;?>','<?=$paginate['url'];?>','<?=$paginate['template_view'];?>')">
							<span aria-hidden="true">Show <?=$paginate['counts']['from_num']?> To <?=$paginate['counts']['to_num']?> From <?=$paginate['counts']['total_num'];?></span>
						</a>
					</li>
				</ul>
			</nav>
		</div>

>>>>>>> first push
		