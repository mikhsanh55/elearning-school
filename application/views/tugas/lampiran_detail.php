<<<<<<< HEAD

<div class="col-md-9 page-content">
	<div class="inner-box">
		<button type="button" class="btn btn-danger btn-sm" onclick="back_page('tugas/siswa_list/<?=$tugas_id;?>')">Kembali</button>
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-12"><h1><strong>Tugas</strong><?=$detail->nama_mapel;?></h1></div>
			</div>
			<div class="row">
				<div class="col-md-12"><p><pre><?=$detail->keterangan;?></pre></p></div>
			</div>

			<div class="row">
			  <p>
					<?php foreach ($attach as $key => $val):?>
				
						<?php

							if($val->create_at > $detail->end_date){
								$style = 'style="color:red"';
							}else{
								$style = NULL;
							}
							
						?>
						<i class="mr-2 <?=$type[$val->format];?>" style="color: <?=$color[$val->format];?>; font-size: 20px;"></i>
						<a <?=$style;?> href="<?=base_url('tugas/get_file/?file='.encrypt_url('assets/tugas/attach_siswa/'.$val->file));?>">
						<?=$val->file;?>
						</a>
                        <br />
					<?php endforeach;?>
			   </p>
			</div>
		</div>
	</div>
</div>


=======

<div class="col-md-9 page-content">
	<div class="inner-box">
		<button type="button" class="btn btn-danger btn-sm" onclick="back_page('tugas/siswa_list/<?=$tugas_id;?>')">Kembali</button>
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-12"><h1><strong>Tugas</strong><?=$detail->nama_mapel;?></h1></div>
			</div>
			<div class="row">
				<div class="col-md-12"><p><pre><?=$detail->keterangan;?></pre></p></div>
			</div>

			<div class="row">
			  <p>
					<?php foreach ($attach as $key => $val):?>
				
						<?php

							if($val->create_at > $detail->end_date){
								$style = 'style="color:red"';
							}else{
								$style = NULL;
							}
							
						?>
						<i class="mr-2 <?=$type[$val->format];?>" style="color: <?=$color[$val->format];?>; font-size: 20px;"></i>
						<a <?=$style;?> href="<?=base_url('tugas/get_file/?file='.encrypt_url('assets/tugas/attach_siswa/'.$val->file));?>">
						<?=$val->file;?>
						</a>
                        <br />
					<?php endforeach;?>
			   </p>
			</div>
		</div>
	</div>
</div>


>>>>>>> first push
