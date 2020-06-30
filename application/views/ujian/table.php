<<<<<<< HEAD

=======
<style>
	.opsi {
		max-width: 200px;
		overflow: auto;
	}
</style>
>>>>>>> first push
<table id="custumtb">
	<thead>
		<tr>
			<th class="frist"><input type="checkbox" name="checkall" id="checkall"></th>
			<th class="frist">No</th>
			<th>Tipe Ujian</th>
			<th>Kelas</th>
			<th>Nama Ujian</th>
			<th>Waktu Mulai</th>
			<th class="frist">Opsi</th>
		</tr>
		<?php $i= $page_start; foreach ($paginate['data'] as $rows):
			$soal = $this->m_soal_ujian->count_by(['id_ujian'=>$rows->id]);
			if (!empty($rows->tgl_mulai) && $rows->tgl_mulai != '0000-00-00 00:00:00') {
				$datetime1 = explode(' ', $rows->tgl_mulai);
				$date = longdate_indo($datetime1[0]).' Pukul '.$time = time_short($datetime1[1]);
				
			}else{
				$date = NULL;
			}
		?>
			<tr>
				<td><input type="checkbox" name="checklist[]" class="checklist" data-id= "<?=encrypt_url($rows->id);?>" value="<?=$rows->id;?>"></td>
				<td align="center" class="frist"><?=$i;?></td>
<<<<<<< HEAD
				<td><?=strtoupper($rows->type_ujian);?></td>
				<td><?=$rows->kelas;?></td>
				<td><?=$rows->nama_ujian;?></td>
				<td><?=$date;?></td>
				<td class="frist">
					<?php if ($this->log_lvl != 'siswa'): ?>
						<a href="<?=base_url('ujian_real/data_soal/'.encrypt_url($rows->id));?>" class="btn btn-primary btn-sm ml-2 mr-2">
							Soal PG
						</a>
						<a href="<?=base_url('ujian_essay/data_soal/'.encrypt_url($rows->id));?>" class="btn btn-primary btn-sm ml-2 mr-2">
=======
				<td>
					<?= $rows->type_ujian == 'uas' ? 'UAS' : ($rows->type_ujian == 'uts' ? 'UTS' : 'Ujian Harian') ?>		
				</td>
				<td><?=$rows->kelas;?></td>
				<td><?=$rows->nama_ujian;?></td>
				<td><?=$date;?></td>
				<td class="opsi text-center" >
					<?php if ($this->log_lvl != 'siswa'): ?>
						<a href="<?=base_url('ujian_real/data_soal/'.encrypt_url($rows->id));?>" class="btn btn-primary btn-sm ml-2 mr-2 mb-2">
							Soal PG
						</a>
						<a href="<?=base_url('ujian_essay/data_soal/'.encrypt_url($rows->id));?>" class="btn btn-primary btn-sm ml-2 mr-2  mb-2">
>>>>>>> first push
							Soal Essay
						</a>
					<?php $cek = $this->m_ikut_ujian->count_by(['id_ujian'=>$rows->id,'status'=>'N']);?>
		
						<?php if ($cek > 0): ?>
<<<<<<< HEAD
							<button type="button" class="btn btn-info btn-sm mr-2" onclick="window.location = '<?=base_url('ujian_real/result/'.encrypt_url($rows->id));?>'"  data-toggle="tooltip" title="">Hasil PG</button>
=======
							<button type="button" class="btn btn-info btn-sm mr-2  mb-2" onclick="window.location = '<?=base_url('ujian_real/result/'.encrypt_url($rows->id));?>'"  data-toggle="tooltip" title="">Hasil PG</button>
>>>>>>> first push
	
					 	<?php endif ?>

						 <?php $cek = $this->m_ikut_ujian_essay->count_by(['id_ujian'=>$rows->id,'status'=>'N']);?>
		
						<?php if ($cek > 0): ?>
<<<<<<< HEAD
							<button type="button" class="btn btn-info btn-sm mr-2" onclick="window.location = '<?=base_url('ujian_essay/result/'.encrypt_url($rows->id));?>'"  data-toggle="tooltip" title="">Hasil Essay</button>
=======
							<button type="button" class="btn btn-info btn-sm mr-2  mb-2" onclick="window.location = '<?=base_url('ujian_essay/result/'.encrypt_url($rows->id));?>'"  data-toggle="tooltip" title="">Hasil Essay</button>
>>>>>>> first push
	
					 	<?php endif ?>

						
						<?php if ($this->log_lvl == 'instansi' || $this->log_lvl == 'admin'): ?>
						<?php if ($soal > 0): ?>
							<?php if ($rows->izin == 0): ?>
<<<<<<< HEAD
									<a href="javascript:void(0);" class="btn btn-success btn-sm mr-2 izinkan" data-id="<?=$rows->id;?>" data-izin="<?=$rows->izin;?>" data-soal="<?=$soal;?>">Izinkan Ujian</a>
							<?php else: ?>
									<a href="javascript:void(0);" class="btn btn-danger btn-sm mr-2 izinkan" data-id="<?=$rows->id;?>" data-izin="<?=$rows->izin;?>" data-soal="<?=$soal;?>">Batalkan Ujian</a>
							<?php endif ?>
							
						<?php else: ?>
							<button type="button" class="btn btn-danger btn-sm mr-2" disabled data-toggle="tooltip" title="Soal Belum Tersedia">Izinkan Ujian</button>
=======
									<a href="javascript:void(0);" class="btn btn-success btn-sm mr-2  mb-2 izinkan" data-id="<?=$rows->id;?>" data-izin="<?=$rows->izin;?>" data-soal="<?=$soal;?>">Izinkan Ujian</a>
							<?php else: ?>
									<a href="javascript:void(0);" class="btn btn-danger btn-sm mr-2  mb-2 izinkan" data-id="<?=$rows->id;?>" data-izin="<?=$rows->izin;?>" data-soal="<?=$soal;?>">Batalkan Ujian</a>
							<?php endif ?>
							
						<?php else: ?>
							<button type="button" class="btn btn-danger btn-sm mr-2  mb-2" disabled data-toggle="tooltip" title="Soal Belum Tersedia">Soal Belum Ada</button>
>>>>>>> first push
						<?php endif ?>
						<?php endif ?>
					 <?php else:
						 $pg = $this->m_ikut_ujian->count_by(['id_ujian'=>$rows->id,'id_user'=>$this->akun->id,'status'=>'N']);
						 $essay = $this->m_ikut_ujian_essay->count_by(['id_ujian'=>$rows->id,'id_user'=>$this->akun->id,'status'=>'N']);
<<<<<<< HEAD
					 ?>
					 	<?php if ($pg > 0): ?>
					 		<button type="button" class="btn btn-warning btn-sm mr-2" onclick="window.location = '<?=base_url('ujian_real/ikuti_ujian/'.encrypt_url($rows->id));?>'"  data-toggle="tooltip" title="" disabled>Sudah PG</button>
					 	<?php else: ?>
					 		<button type="button" class="btn btn-success btn-sm mr-2" onclick="window.location = '<?=base_url('ujian_real/ikuti_ujian/'.encrypt_url($rows->id));?>'"  data-toggle="tooltip" title="">Mulai PG</button>
					 	<?php endif ?>

						<?php if ($essay > 0): ?>
					 		<button type="button" class="btn btn-warning btn-sm mr-2" onclick="window.location = '<?=base_url('ujian_essay/ikuti_ujian/'.encrypt_url($rows->id));?>'"  data-toggle="tooltip" title="" disabled>Sudah Essay</button>
					 	<?php else: ?>
					 		<button type="button" class="btn btn-success btn-sm mr-2" onclick="window.location = '<?=base_url('ujian_essay/ikuti_ujian/'.encrypt_url($rows->id));?>'"  data-toggle="tooltip" title="">Mulai Essay</button>
					 	<?php endif ?>
=======
						 $jumlah_soal_pg = $this->m_soal_ujian->count_by(['id_ujian' => $rows->id]);
						 $jumlah_soal_essay = $this->m_soal_ujian_essay->count_by(['id_ujian' => $rows->id]);

					 ?>
					 	<?php if ($pg > 0): ?>
					 		<button type="button" class="btn btn-warning btn-sm mr-2  mb-2" onclick="window.location = '<?=base_url('ujian_real/ikuti_ujian/'.encrypt_url($rows->id));?>'"  data-toggle="tooltip" title="" disabled>Sudah PG</button>
					 	<?php else: ?>
					 		<?php if($jumlah_soal_pg > 0) : ?>
					 		<button type="button" class="btn btn-success btn-sm mr-2  mb-2" onclick="window.location = '<?=base_url('ujian_real/ikuti_ujian/'.encrypt_url($rows->id));?>'"  data-toggle="tooltip" title="">Mulai PG</button>
					 		<?php endif; ?>
					 	<?php endif ?>

						<?php if ($essay > 0): ?>
					 		<button type="button" class="btn btn-warning btn-sm mr-2  mb-2" onclick="window.location = '<?=base_url('ujian_essay/ikuti_ujian/'.encrypt_url($rows->id));?>'"  data-toggle="tooltip" title="" disabled>Belum Dinilai</button>
					 	<?php else: ?>
					 		<?php if($jumlah_soal_essay > 0) : ?>
					 		<button type="button" class="btn btn-success btn-sm mr-2  mb-2" onclick="window.location = '<?=base_url('ujian_essay/ikuti_ujian/'.encrypt_url($rows->id));?>'"  data-toggle="tooltip" title="">Mulai Essay</button>
					 		<?php endif; ?>
					 	<?php endif ?>
					 	<?php if($jumlah_soal_essay < 1 && $jumlah_soal_pg < 1) : ?>
					 		<button class="btn btn-warning btn-sm d-block text-center" disabled>Belum ada soal</button>
					 	<?php endif; ?>
>>>>>>> first push
					 	
					<?php endif ?>

					</div>				
				</td>	
			</tr>
		<?php $i++;endforeach ?>
	</thead>
<tbody>
</tbody>
</table>

<script type="text/javascript">
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();   
	});

	$(document).on('click','.izinkan',function(){

		var y = confirm('Apakah anda yakin akan mengizinkan ujian ?');

		if (y == true) {

			$.ajax({
				type:'post',
				url : '<?=base_url('ujian_real/izinkan');?>',
				dataType : 'json',
				data : {
					id   : $(this).data('id'),
					izin : $(this).data('izin'),
					soal : $(this).data('soal'),
				},
				success:function(response){
					alert(response.message);
					pageLoad(1,'ujian_real/page_load');
				}
			})


		}else{
			return false;
		}

		
	})

</script>


