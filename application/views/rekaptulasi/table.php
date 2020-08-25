<table class="table table-bordered table-striped table-hovered">
	<thead>
		<tr>
			<th class="frist" rowspan="2">No</th>
			<th rowspan="2">Nama Siswa</th>
			<th rowspan="2">Kelas</th>
			<th rowspan="2">Mata Pelajaran</th>
			<th colspan="5">Nilai</th>
		</tr>
		<tr>
			<th>Ujian Harian</th>
			<th>UTS</th>
			<th>UAS</th>
			<th>Tugas</th>
			<th>Keaktifan</th>
		</tr>
	</thead>
	<tbody>
	    <?php if(count($paginate['data']) > 0) { ?>
	<?php $i= $page_start; foreach ($paginate['data'] as $rows): 
			?>
				<tr>
					<td align="center" class="frist"><?=$i;?></td>
					<td><?=$rows->siswa;?></td>
					<td><?=$rows->nama_kelas;?></td>
					<td><?= $rows->nama_mapel; ?></td>
					<td class="text-center">
						<a href="<?= base_url('rekaptulasi/detail-ujian/1/') . encrypt_url($rows->id_mapel) . '/' . encrypt_url($rows->id_siswa) . '/' . encrypt_url($rows->id_kelas); ?>" class="btn btn-sm btn-primary">Detail</a>
					</td>
					<td class="text-center">
						<a href="<?= base_url('rekaptulasi/detail-ujian/2/') . encrypt_url($rows->id_mapel) . '/' . encrypt_url($rows->id_siswa) . '/' . encrypt_url($rows->id_kelas); ?>" class="btn btn-sm btn-primary">Detail</a>
					</td>
					<td class="text-center">
						<a href="<?= base_url('rekaptulasi/detail-ujian/3/') . encrypt_url($rows->id_mapel) . '/' . encrypt_url($rows->id_siswa) . '/' . encrypt_url($rows->id_kelas); ?>" class="btn btn-sm btn-primary">Detail</a>
					</td>
					<td class="text-center">
					<a href="<?= base_url('tugas/detail-nilai-siswa/') . encrypt_url($rows->id_mapel) . '/' .encrypt_url($rows->id_siswa); ; ?>" class="btn btn-sm btn-primary">Detail</a>
				</td>
					<td>
						<button data-siswa="<?= ($rows->id_siswa); ?>" data-mapel="<?= $rows->id_mapel; ?>" class="btn btn-sm btn-primary detail-keaktifan">Lihat</button>
					</td>
				</tr>
			<?php $i++;endforeach ?>
	<?php } else { ?>		
	    <tr>
	        <td colspan="10" rowspan="2" class="text-center">Data Kosong</td>
	    </tr>
	    
	<?php } ?>
	</tbody>
</table>
<script>
	$('.detail-keaktifan').click(function(e) {
			e.preventDefault();
			self = this;
			$.ajax({
				type: 'post',
				url: "<?= base_url('aktivitas/detail-keaktifan-siswa'); ?>",
				data: {
					siswa: $(self).data('siswa'),
					mapel: $(self).data('mapel')
				},
				dataType: 'json',
				success: function(res) {
					$('#keaktifanModal .modal-body').html(res.data);
					$('#keaktifanModal').modal('show');
				},
				error: function(e) {
					alert('Terjadi kesalahan saat mengambil data!');
					console.error(e.responseText);
					return false;
				}
			});
		});
</script>
