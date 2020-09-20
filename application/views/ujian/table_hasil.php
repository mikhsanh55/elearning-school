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
			<th>Opsi</th>
		</tr>
	</thead>
	<tbody>
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
					<a href="<?= base_url('ujian/hasil-pg/') . encrypt_url($rows->id_ujian) . '/' . encrypt_url($rows->id_user); ?>" class="btn btn-sm btn-primary d-block mb-2">Lihat Jawaban</a>
					<button class="btn btn-danger btn-sm ulang-ujian-siswa" data-siswa="<?= encrypt_url($rows->id_user); ?>" data-ujian="<?= encrypt_url($rows->id_ujian) ?>" data-nama="<?= $siswa->nama; ?>">
						Ulang ujian
					</button>
				</td>
			</tr>
		<?php $i++;endforeach; } else { ?>
			<tr>
				<td colspan="11" class="text-center">Data Kosong</td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<script src="<?=base_url();?>assets/js/jquery/jquery-3.3.1.min.js"></script>
<script src="<?= base_url('assets/plugin/datatables/jquery.dataTables.min.js') ?>"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
<script type="text/javascript">
	$(document).ready(function(){
		let conf, namaSiswa = '';
		$('table').DataTable({
			responsive: true,
			paging: false,
			info: false
		});

		$('[data-toggle="tooltip"]').tooltip();   
		$('.ulang-ujian-siswa').on('click', function(e) {
			e.preventDefault();
			namaSiswa = $(this).data('nama');
			conf = confirm(`Data siswa ${namaSiswa} di ujian ini akan terhapus, anda yakin?`);

			if(conf) {
				$.ajax({
					type: 'post',
					url: "<?= base_url('ujian/ulang-ujian-siswa') ?>",
					data: {
						siswa: $(this).data('siswa'),
						ujian: $(this).data('ujian')
					},
					dataType: 'json',
					success: () => window.location.reload(),
					error: (e) => {
						console.error(e.responseText);
						alert(`Tidak dapat menghapus data ujian ${namaSiswa}, terjadi kesalahan`);
						return false;
					}
				});
			}
			else {
				return false;
			}
		});
	});
</script>