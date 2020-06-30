
<table id="custumtb">
	<thead>
		<tr>
			<th class="frist"><input type="checkbox" name="checkall" id="checkall"></th>
			<th class="frist">No</th>
			<th>Nama Penilaian</th>
			<th>Kelas</th>
			<th><?=$this->transTheme->guru;?></th>
			<th>Modul Pelatihan</th>
			<th>NRP</th>
			<th>Pangkat</th>
			<th>Waktu Mulai</th>
			<th class="frist">Opsi</th>
		</tr>
		<?php $i= $page_start; foreach ($paginate['data'] as $rows):
			$paket = $this->m_paket_soal->count_by(['id'=>$rows->id_paket_soal]);
			$penilaian = $this->db->where('id_penilaian',$rows->id)->get('tb_ikut_penilaian')->result();
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
				<td><?=strtoupper($rows->nama_ujian);?></td>
				<td><?=$rows->kelas;?></td>
				<td><?=$rows->nama_guru;?></td>
				<td><?=$rows->nama_mapel;?></td>
				<td><?=$rows->pangkat;?></td>
				<td><?=$rows->nrp;?></td>
				<td><?=$date;?></td>
				<td class="frist">
					<?php if ($this->log_lvl != 'siswa'): ?>

						<?php if(!empty($penilaian)):?>
						<a href="<?=base_url('penilaian/result_chart/'.encrypt_url($rows->id));?>" class="btn btn-primary btn-sm ml-2 mr-2">
							Hasil
						</a>
						<?php endif;?>

						
						<?php if ($this->log_lvl == 'instansi' || $this->log_lvl == 'admin'): ?>
						<?php if ($paket > 0): ?>
							<?php if ($rows->izin == 0): ?>
									<a href="javascript:void(0);" class="btn btn-success btn-sm mr-2 izinkan" data-id="<?=$rows->id;?>" data-izin="<?=$rows->izin;?>" data-soal="<?=$paket;?>">Izinkan Penilaian</a>
							<?php else: ?>
									<a href="javascript:void(0);" class="btn btn-danger btn-sm mr-2 izinkan" data-id="<?=$rows->id;?>" data-izin="<?=$rows->izin;?>" data-soal="<?=$paket;?>">Batalkan Penilaian</a>
							<?php endif ?>
							
						<?php else: ?>
							<button type="button" class="btn btn-danger btn-sm mr-2" disabled data-toggle="tooltip" title="Soal Belum Tersedia">Izinkan Penilaian</button>
						<?php endif ?>
						<?php endif ?>
					 <?php else:
					 	$ujian = $this->m_ikut_penilaian->count_by(['id_penilaian'=>$rows->id,'id_user'=>$this->akun->id,'status'=>'N']);
					 ?>
					 	<?php if ($ujian > 0): ?>
					 		<button type="button" class="btn btn-warning btn-sm mr-2" onclick="window.location = '<?=base_url('penilaian/ikuti_ujian/'.encrypt_url($rows->id));?>'"  data-toggle="tooltip" title="" disabled>Sudah Penilaian</button>
					 	<?php else: ?>
					 		<button type="button" class="btn btn-success btn-sm mr-2" onclick="window.location = '<?=base_url('penilaian/ikuti_ujian/'.encrypt_url($rows->id));?>'"  data-toggle="tooltip" title="">Mulai Penilaian</button>
					 	<?php endif ?>
					 	
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
				url : '<?=base_url('penilaian/izinkan');?>',
				dataType : 'json',
				data : {
					id   : $(this).data('id'),
					izin : $(this).data('izin'),
					soal : $(this).data('soal'),
				},
				success:function(response){
					alert(response.message);
					pageLoad(1,'penilaian/page_load');
				}
			})


		}else{
			return false;
		}

		
	})

</script>


