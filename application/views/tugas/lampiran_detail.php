<div class="col-md-9 page-content">
	<div class="inner-box">

		<div id="accordion" class="panel-group">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-info">
						<div class="panel-heading">
							<div class="tombol-kanan d-flex justify-content-between">
								<h2><strong>Data Tugas <?=$detail->nama_mapel;?></strong></h2>
								<div>
									<button type="button" class="btn btn-light " onclick="back_page('tugas/siswa_list/<?=$tugas_id;?>')">Kembali</button>
								</div>						
							</div>
						</div>

						<form action="" class="mt-4" id="form-tugas-nilai">
							<input type="hidden" name="id_tugas" value="<?= $id_tugas; ?>">
							<input type="hidden" name="id_siswa" value="<?= $id_siswa; ?>">
							<div class="form-group mb-4">
								<label for="">Keterangan Tugas</label>
								<p><?= $detail->keterangan; ?></p>
							</div>
							<div class="form-group mb-4">
								<p><strong>Lampiran Siswa</strong></p>
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
							</div>
							<div class="form-group">
								<p id="error-msg"></p>
								<label for="">Nilai Siswa</label>
								<input type="text" class="form-control mb-4" value="<?= $nilai_siswa; ?>" id="input-nilai" name="nilai" required>
								<button class="btn btn-primary btn-block" type="submit" id="simpan-nilai">Simpan</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('#form-tugas-nilai').on('submit', function(e) {
			e.preventDefault()
			$('#simpan-nilai').prop('disabled', true).html('Loading...')
			$.ajax({
				type: 'post',
				url: "<?= base_url('tugas/beri_nilai') ?>",
				data: $(this).serialize(),
				dataType: 'json',
				success: function(res) {
					$('#input-nilai').val(res.nilai)
					$('#simpan-nilai').prop('disabled', false).html('Nilai Siswa sudah masuk!').removeClass('btn-primary').addClass('btn-success')
					setTimeout(() => {
						$('#simpan-nilai').removeClass('btn-success').addClass('btn-primary').text('Simpan')
					}, 3000)
				},
				error: function(e) {
					console.error(e.responseText)
					$('#simpan-nilai').prop('disabled', false).html('Simpan')
					$('error-msg').html(`
						<p class="label label-danger"><small>Error, terdapat kesalahan teknis silahkan hubungi tim pengembang</small></p>
					`)
				}
			})
		})
	})
</script>

