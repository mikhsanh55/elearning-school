		<?php if (!empty($komentar)): ?>
		<div class="">
			<fieldset>
				
				<?php foreach ($komentar as $rows): ?>
					<div class="kotak" >
						<div style="background: #B4CBF0; padding: 10px 10px 0px 10px; border-radius: 10px;">
						<?php if (!empty($jadwal)): ?>
						<?php if ($this->log_lvl == 'siswa'): ?>
							<?php if ($this->log_id == $rows->id_siswa): ?>
								<a href="javascript:void(0);" data-id="<?=$rows->id;?>" title="hapus" class="hapus head-hapus"><i class="fa fa-remove"></i></a>
								<a href="javascript:void(0);" data-id="<?=$rows->id;?>" title="edit" class="hapus head-edit"><i class="fa fa-edit"></i></a>
							<?php endif ?>
							<?php else:?>
								<?php if ($this->log_id == $rows->id_trainer): ?>
									<a href="javascript:void(0);" data-id="<?=$rows->id;?>" title="hapus" class="hapus head-hapus"><i class="fa fa-remove"></i></a>
									<a href="javascript:void(0);" data-id="<?=$rows->id;?>" title="edit" class="hapus head-edit"><i class="fa fa-edit"></i></a>
								<?php endif ?>
								<?php endif ?>
							<?php endif ?>
						<span><?=$rows->nama_lengkap;?></span>:
						<?php 
							if (!empty($rows->update_time)) {
								echo '<span  style="float:right"><strong>'.date_indo($rows->update_date).'  '.time_short($rows->update_time).'</strong> (Updated)</span>';
							}else{
								echo '<span  style="float:right"><strong>'.date_indo($rows->create_date).'  '.time_short($rows->create_time).'</strong></span>';
							}
							;?>

						<br>
						
						<hr>
						</div>
						<p class="isi-kontent">
							<div id="head-<?=$rows->id;?>">
								<div><?=$rows->komentar;?></div>
								<?php if(file_exists($rows->file) && $rows->file !== NULL) : ?>
									<?php 
										$pathinfo = explode('/', $rows->file);
										$pathinfo = end($pathinfo);
										$pathinfo = pathinfo($pathinfo, PATHINFO_EXTENSION);
										$image_ext = ['jpg', 'png', 'jpeg'];
										if(in_array($pathinfo, $image_ext)) {
									 ?>
										<div><span class="img-upload-wrapper"><img class=" ml-2 mt-4 diskusi-img" src="<?= base_url($rows->file); ?>" alt="image uploaded"></span>
											</div>
									<?php } else { ?>
										<div>
											<a href="<?= base_url($rows->file); ?>" download >
												Download File
											</a>
										</div>
									<?php } ?>
								<?php endif; ?>		
							</div>
						</p>
						<!-- <span class="suka">Suka</span> -->
						
						<?php

						$balasan = $this->m_komen_materi->get_many_by(array('id_materi' => $rows->id_materi , 'id_head' => $rows->id));
						$hitung  = $this->m_komen_materi->count_by(array('id_materi' => $rows->id_materi , 'id_head' => $rows->id));

						$cek = 0;
						if (!empty($balasan)):
							$cek = 1;
							$ke = 1;
							foreach ($balasan as $row):
								?>
								
								<div class="kotak">
									<p class="isi-kontent" style="background: #B4F0B8; padding: 10px 10px 10px 10px; border-radius: 10px;">
										<strong><?=$row->nama_lengkap;?>
										<?php if (!empty($jadwal)): ?>
										<?php if ($this->log_lvl == 'siswa'): ?>
											<?php if ($this->log_id == $row->id_siswa): ?>
												<a href="javascript:void(0);" data-id="<?=$row->id;?>" title="hapus" class="hapus balasan-hapus"><i class="fa fa-remove"></i></a>
												<a href="javascript:void(0);" data-id="<?=$row->id;?>" title="hapus" class="hapus balasan-edit"><i class="fa fa-edit"></i></a>
											<?php endif ?>
											<?php else:?>
												<?php if ($this->log_id == $row->id_trainer): ?>
													<a href="javascript:void(0);" data-id="<?=$row->id;?>" title="hapus" class="hapus balasan-hapus"><i class="fa fa-remove"></i></a>
													<a href="javascript:void(0);" data-id="<?=$row->id;?>" title="hapus" class="hapus balasan-edit"><i class="fa fa-edit"></i></a>
												<?php endif ?>
											<?php endif ?>
										<?php endif;?>
										</strong> 
										<?php 
							if (!empty($row->update_time)) {
								echo '<span  style="float:right"><strong>'.date_indo($row->update_date).'  '.time_short($row->update_time).'</strong> (Updated)</span>';
							}else{
								echo '<span  style="float:right"><strong>'.date_indo($row->create_date).'  '.time_short($row->create_time).'</strong></span>';
							}
							;?>
									<div id="balasan-<?=$row->id;?>"><?=$row->komentar;?></div>
									<!-- Display Image or link to uploaded document -->
									<?php if(file_exists($row->file) && $row->file !== NULL) : ?>
										<?php 
											$pathinfo = explode('/', $row->file);
											$pathinfo = end($pathinfo);
											$pathinfo = pathinfo($pathinfo, PATHINFO_EXTENSION);
											$image_ext = ['jpg', 'png', 'jpeg'];
											if(in_array($pathinfo, $image_ext)) {
										 ?>
											<div class="m-3"><span class="img-upload-wrapper"><img class="diskusi-img" src="<?= base_url($row->file); ?>" alt="image uploaded"></span>
												</div>
										<?php } else { ?>
											<div class="m-3">
												<a href="<?= base_url($row->file); ?>" download >
													Download File
												</a>
											</div>
										<?php } ?>
									<?php endif; ?>		
									</p>
									<!-- <span class="suka">Suka</span> -->
									<?php if ($ke == $hitung): ?>
									
									
									<?php endif ?>
								</div>
							<?php $ke++; endforeach; endif;?>
							<!-- <?php if (!empty($jadwal)): ?>
							<span class="balas">Balas</span>
							<span class="errors errors-<?=$rows->id;?>"></span>
							
							<div class="balas">

								<form id="form-balas<?=$rows->id;?>" class="form-balas" method="post" action="">
									<input type="hidden" name="id_materi" value="<?=$materi->id;?>">
									<input type="hidden" name="id_head" value="<?=$rows->id;?>">
									<input type="hidden" name="id_trainer" value="<?=$id_trainer;?>">
									<input type="hidden" name="id_siswa" value="<?=$id_siswa;?>">
									<textarea name="komentar" rows="2" id="komentar-txt<?=$rows->id;?>" placeholder="Ketik sesuatu" required></textarea>
									<div class="row">
										<div class="col-sm-12 col-md-6 col-lg-6 ">
											<button type="submit" class="w-100 ml-1 btn btn-primary kirim-komen" data-id="<?=$rows->id;?>">Kirim</button>		
										</div>
										<div class="col-sm-12 col-md-6 col-lg-6">
											<input type="file" class="form-control mr-1 reply-file"  name="reply-file" />
										</div>
									</div>
								</form>
							</div>
						<?php endif;?> -->
							<?php if ($cek == 0): ?>
						<!-- 		<div class="balas">
									<form class="form-balas" method="post" action="">
										<input type="hidden" name="id_materi" value="<?=$materi->id;?>">
										<input type="hidden" name="id_head" value="<?=$rows->id;?>">
										<input type="hidden" name="id_trainer" value="<?=$id_trainer;?>">
										<input type="hidden" name="id_siswa" value="<?=$id_siswa;?>">
										<textarea name="komentar" rows="2" id="komentar-txt<?=$rows->id;?>" placeholder="Ketik sesuatu"></textarea>
										<button type="submit" class="btn btn-sm btn-default kirim-komen" data-id="<?=$rows->id;?>" style="width:100%;">Kirim</button>
									</form>
								</div> -->
							</div>
						<?php endif; endforeach ?>

					</fieldset>
			<?php else: ?>
			<div class="">
				<fieldset>

					<div class="kotak">
						<p class="isi-kontent">Tidak ada pertanyaan atau komentar</p>
					</div>
				</fieldset>
			</div>
		<?php endif ?>
<script type="text/javascript">
	
	// Popup image when user click
	$('.diskusi-img').on('click', function() {
    	var srcImg = $(this).attr('src')
    	$('#img-popup .modal-body ').html(`<img class="view-diskusi-img" src="${srcImg}" >`)
    	$('#img-popup').modal('show')
    })

    // Validation Reply Image
    $('.reply-file').change(function() {
		var fileExtension = ['jpeg', 'jpg', 'png', 'docx', 'xls', 'xlsx', 'pdf'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            alert("Format yang diperbolehkan : "+fileExtension.join(', '));
            $(this).val('')
        }
	})

    // Process Data setelah user klik tombol kirim
    $('.form-balas').submit(function(e) {
    	e.preventDefault()
    	$.ajax({
    		type: 'POST',
    		url  : '<?=base_url('Materi/insert_koment');?>',
			dataType : 'json',
			data : new FormData(this),
			processData: false,
        	contentType: false,
			success:function(response){
				if (response.result == false) {
					alert('simpan gagal Diskusi sudah expire');
					return false
				}

				load_page()

			}
    	})
    })

	// $('.kirim-komen').click(function(){
	// 	var errors = 0;
	// 	var komentar = $('#komentar-txt' + $(this).data('id'));
	// 	var errors_span = $('.errors-' + $(this).data('id') );
	// 	var form = $('#form-balas' + $(this).data('id') );
	
	// 	if (komentar.val() == '') {
	// 		errors_span.text('Ketikan sesuatu tidak boleh kosong !!')
	// 		errors++;
	// 	}

	// 	if (errors == 0) {
	// 		$.ajax({
	// 			type : 'post',
	// 			url  : '<?=base_url('Materi/insert_koment');?>',
	// 			dataType : 'json',
	// 			data : form.serialize(),
	// 			success:function(response){
	// 				if (response.result == false) {
	// 					alert('simpan gagal Diskusi sudah expire');
	// 				}else{

	// 				}
	// 				load_page();
	// 			}
	// 		})
	// 	}else{

	// 	}
	// })

	$('.head-hapus').click(function(){
		var tanya = confirm('Apa kamu yakin untuk menghapus pertanyaan atau komentar anda ?');
		if (tanya == true) {
			$.ajax({
				type : 'post',
				url  : '<?=base_url('Materi/delete_head_koment');?>',
				data : {
					id : $(this).data('id'),
				},
				success:function(response){
					load_page();
				}
			})
		}else{
			return false;			
		}
	})

	$('.balasan-hapus').click(function(){
		var tanya = confirm('Apa kamu yakin untuk menghapus balasan anda ?');
		if (tanya == true) {
			$.ajax({
				type : 'post',
				url  : '<?=base_url('Materi/delete_balasan_koment');?>',
				data : {
					id : $(this).data('id'),
				},
				success:function(response){
					load_page();
				}
			})
		}else{
			return false;			
		}
	})

	$('.head-edit').click(function(){
		var id = $(this).data('id');
		var kontent = $('#head-' + id);

		var text = kontent.text();

		var html = '<textarea name="komentar" rows="2" id="editing" data-id="' + id +'"  placeholder="Ketik sesuatu">'+ text +'</textarea>';
		kontent.html(html);
		$('#editing').focus();
	})

	$('.balasan-edit').click(function(){
		var id = $(this).data('id');
		var kontent = $('#balasan-' + id);

		var text = kontent.text();

		var html = '<textarea name="komentar" rows="2" id="editing2" data-id="' + id +'"  placeholder="Ketik sesuatu">'+ text +'</textarea>';
		kontent.html(html);
		$('#editing').focus();
	})

	$(document).on("click",function(e){
		
		if($("#editing").length != 0) {
			if ($(e.target).attr('class') == 'fa fa-edit') {

			}else if ( e.target.id != 'editing') {

				var id = $('#editing').data('id');
				var kontent = $('#head-' + id);
				var val = $('#editing').val();

				if (val == '') {
					alert('tidak boleh kosong!');
				}else{
					kontent.text(val);

					$.ajax({
						type : 'post',
						url  : '<?=base_url('Materi/update_koment');?>',
						data : {
							id:id,
							komentar : val
						},
						success:function(){

						}
					})
				}
			}
		}
	});

	$(document).on("click",function(e){
	
		if($("#editing2").length != 0) {
			if ($(e.target).attr('class') == 'fa fa-edit') {

			}else if ( e.target.id != 'editing2') {

				var id = $('#editing2').data('id');
				var kontent = $('#balasan-' + id);
				var val = $('#editing2').val();

				if (val == '') {
					alert('tidak boleh kosong!');
				}else{
					kontent.text(val);

					$.ajax({
						type : 'post',
						url  : '<?=base_url('Materi/update_koment');?>',
						data : {
							id:id,
							komentar : val
						},
						success:function(){

						}
					})
				}
			}
		}
	});


	
</script>