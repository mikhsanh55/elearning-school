
<table class="table table-bordered table-striped table-hovered">
	<thead>
		<tr>
			<th class="frist"><input type="checkbox" name="checkall" id="checkall"></th>
			<th class="frist">No</th>
			<th>Siswa</th>
			<th>Kelas</th>
			<th>Nilai</th>
			<th>Grade</th>
			<th>Jumlah Benar</th>
			<th>Keterangan</th>
			<th>KKM</th>
			<th>Waktu Mulai</th>
			<th>Waktu Selesai</th>
			<th>Hasil</th>
		</tr>
		<?php if(count($paginate['data']) > 0) { $i= $page_start; foreach ($paginate['data'] as $rows):
			$ujian = $this->m_ujian->get_by(['uji.id'=>$rows->id_ujian]);
			$siswa = $this->m_siswa->get_by(['id'=>$rows->id_user]);
			$keterangan = ($rows->nilai >= $ujian->min_nilai) ? 'LULUS' : 'BELUM LULUS';

			if($rows->nilai > 90 && $rows->nilai < 101){
				$grade = 'A';
			}else if($rows->nilai > 80 && $rows->nilai < 91){
				$grade = 'B';
			} else if($rows->nilai > 70 && $rows->nilai < 81){
				$grade = 'C';
			} else {
				$grade = 'D';
			}
			$id_kelas = $this->m_detail_kelas->get_by(['id_peserta' => $rows->id_user]);
			$nama_kelas = $this->m_kelas->get_by(['kls.id' => $id_kelas->id_kelas]);
			$nama_kelas = !empty($nama_kelas) ? $nama_kelas->nama : '';
		?>
			<tr>
				<td><input type="checkbox" name="checklist[]" class="checklist" data-id= "<?=encrypt_url($rows->id);?>" value="<?=$rows->id;?>"></td>
				<td align="center" class="frist"><?=$i;?></td>
				<td><?=$siswa->nama;?></td>
				<td><?= $nama_kelas; ?></td>
				<td><?=$rows->nilai;?></td>
				<td><?=$grade;?></td>
				<td><?=$rows->jml_benar;?></td>
				<td><?=$keterangan;?></td>
				<td><?=$ujian->min_nilai;?></td>
				<td><?=$rows->tgl_mulai;?></td>
				<td><?=$rows->tgl_selesai;?></td>
				<td>
					<a href="<?= base_url('ujian/hasil-pg/') . encrypt_url($rows->id_ujian) . '/' . encrypt_url($rows->id_user); ?>" class="btn btn-sm btn-primary">Lihat Jawaban</a>
				</td>
			</tr>
		<?php $i++;endforeach; } else { ?>
			<tr>
				<td colspan="11" class="text-center">Data Kosong</td>
			</tr>
		<?php } ?>
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


