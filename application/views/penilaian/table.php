<table class="table table-bordered table-striped table-hovered">
	<thead>
		<tr>
			<?php if($this->log_lvl != 'siswa') : ?>
				<th class="frist"><input type="checkbox" name="checkall" id="checkall"></th>
			<?php endif; ?>
			<th class="frist">No</th>
			<th>Nama Penilaian</th>
			<th>Kelas</th>
			<th>Guru</th>
			<th>Waktu Mulai</th>
			<th class="frist">Opsi</th>
		</tr>
	</thead>
	<tbody>
		<?php if(count($paginate['data']) > 0) { ?>
		<?php $i= $page_start; foreach ($paginate['data'] as $rows):
			$paket = $this->m_paket_soal->count_by(['id'=>$rows->id_paket_soal]);
			$penilaian = $this->m_ikut_penilaian->count_by(['id_penilaian' => $rows->id]);
			if (!empty($rows->tgl_mulai) && $rows->tgl_mulai != '0000-00-00 00:00:00') {
				$datetime1 = explode(' ', $rows->tgl_mulai);
				$date = longdate_indo($datetime1[0]).' Pukul '.$time = time_short($datetime1[1]);
				
			}else{
				$date = NULL;
			}
			$guru = $this->m_guru->get_by(['id' => $rows->id_guru]);
			$now = date('Y-m-d H:i:s');
		?>
			<tr>
				<?php if($this->log_lvl != 'siswa') : ?>
					<td><input type="checkbox" name="checklist[]" class="checklist" data-id= "<?=encrypt_url($rows->id);?>" value="<?=$rows->id;?>"></td>
				<?php endif; ?>
				<td align="center" class="frist"><?=$i;?></td>
				<td><?=strtoupper($rows->nama_ujian);?></td>
				<td><?=$rows->kelas;?></td>
				<td><?= !empty($guru) ? $guru->nama : 'Kosong';?></td>
				<td><?=$date;?></td>
				<td class="frist">
					<?php if ($this->log_lvl != 'siswa'): ?>

						<?php if(!empty($penilaian)):?>
						<a href="<?=base_url('penilaian/hasil-penilaian/'.encrypt_url($rows->id));?>" class="btn btn-success btn-sm text-center d-block">
							Hasil
						</a>
						<?php endif;?>

						
						<?php if ($this->log_lvl == 'instansi' || $this->log_lvl == 'admin'): ?>
						<?php if ($paket > 0): ?>
							<?php if ($rows->izin == 0): ?>
									<a href="javascript:void(0);" class="btn btn-primary btn-sm text-center d-block izinkan" data-id="<?=$rows->id;?>" data-izin="<?=$rows->izin;?>" data-soal="<?=$paket;?>">Izinkan Penilaian</a>
							<?php else: ?>
									<a href="javascript:void(0);" class="btn btn-danger btn-sm batalkan-penilaian text-center d-block" data-id="<?=$rows->id;?>" data-izin="<?=$rows->izin;?>" data-soal="<?=$paket;?>">Batalkan Penilaian</a>
							<?php endif ?>
							
						<?php else: ?>
							<button type="button" class="btn btn-warning btn-sm text-center d-block" disabled data-toggle="tooltip" title="Soal Belum Tersedia">Izinkan Penilaian</button>
						<?php endif ?>
						<?php endif ?>
					 <?php else:
					 	$ujian = $this->m_ikut_penilaian->count_by(['id_penilaian'=>$rows->id,'id_user'=>$this->akun->id,'status'=>'N']);
					 ?>
					 	<?php if ($ujian > 0): ?>
					 		<button type="button" class="btn text-center d-block btn-success btn-sm mr-2" onclick="window.location = '<?=base_url('penilaian/ikuti_ujian/'.encrypt_url($rows->id));?>'"  data-toggle="tooltip" title="" disabled>Sudah Penilaian</button>
					 	<?php else: 
					 		if($rows->izin == 0) {
					 	?>
					 		<button class="btn btn-sm text-center d-block btn-info" disabled>Belum ada Izin</button>

						 <?php } else if($now > $rows->terlambat || $now < $rows->tgl_mulai){ ?>
						 	<button class="btn btn-danger btn-sm" disabled>
						 		Belum ada jadwal
						 	</button>
						 <?php } else { ?>
						 	<button type="button" class="btn btn-primary text-center d-block btn-sm mr-2" onclick="window.location = '<?=base_url('penilaian/ikuti_ujian/'.encrypt_url($rows->id));?>'"  data-toggle="tooltip" title="">Mulai Penilaian</button>
						 <?php } ?>
					 	<?php endif ?>
					<?php endif ?>
					</div>				
				</td>	
			</tr>
		<?php $i++;endforeach ?>
		<?php } ?>
	</tbody>
</table>
<script src="<?=base_url();?>assets/js/jquery/jquery-3.3.1.min.js"></script>
<script src="<?= base_url('assets/plugin/datatables/jquery.dataTables.min.js') ?>"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
<script type="text/javascript">
	$(document).ready(function(){
		let conf;
		$('[data-toggle="tooltip"]').tooltip(); 
		$('table').DataTable({
            paging: false,
            info: false
        });  

        $('.izinkan').on('click', function(e){
			e.preventDefault();

			conf = confirm('Apakah anda yakin akan mengizinkan ujian ?');

			if (conf) {

				$.ajax({
					type:'post',
					url : '<?=base_url('penilaian/izinkan');?>',
					dataType : 'json',
					data : {
						id   : $(this).data('id'),
						izin : $(this).data('izin'),
						soal : $(this).data('soal'),
					},
					success:function(response){
						// alert(response.message);
						pageLoad(1,'penilaian/page_load');
					}
				});
			}
		});

		$('.batalkan-penilaian').on('click', function(e) {
			e.preventDefault();
			conf = confirm('Semua hasil penilaian ini akan terhapus, anda yakin?');
			if(conf) {
				$.ajax({
					type: 'post',
					url: "<?= base_url('penilaian/batalkan-penilaian'); ?>",
					data: {
						id: $(this).data('id')
					},
					dataType: 'json',
					success: function(res) {
						pageLoad(1,'penilaian/page_load');
					}
				});
			}
		});
	});
</script>