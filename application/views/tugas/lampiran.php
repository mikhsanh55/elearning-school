<div class="col-md-9 page-content">
	<div class="inner-box">
		<button type="button" class="btn btn-danger btn-sm" onclick="back_page('tugas')">Kembali</button>
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-12"><h1><strong>Tugas</strong><?=$detail->nama_mapel;?></h1></div>
			</div>
			<div class="row">
				<div class="col-md-12"><p><?=$detail->keterangan;?></p></div>
			</div>
			<div class="row">
			<?php foreach ($attach as $key => $val):?>
				<div class="col-md-6">
					<a href="<?=base_url('tugas/get_file/?file='.encrypt_url('assets/tugas/attach/'.$val->file));?>">
					<p><i class="<?=$type[$val->format];?>" style="color: <?=$color[$val->format];?>; font-size: 20px;"></i>
					<?=$val->file;?></p>
				</a>
				</div>
			<?php endforeach;?>
			</div>
		</div>
	</div>
</div>


