
<table class="table table-bordered table-striped table-hovered">
	<thead>
		<tr>
			<th class="frist"><input type="checkbox" name="checkall" id="checkall"></th>
			<th class="frist">No</th>
			<th>Nama</th>
			<th>Kelas</th>
			<th>Nilai</th>
			<th>Nilai Minimum</th>
			<th>Tanggal Mulai</th>
			<th>Tanggal Selesai</th>
			<th class="frist">Opsi</th>
		</tr>
		<?php $i= $page_start; foreach ($paginate['data'] as $rows):
			$ujian = $this->m_ujian->get_by(['uji.id'=>$rows->id_ujian]);
			
			$nilai = $this->db->select('sum(nilai) as total')->where('id_ikut_essay',$rows->id)->get('tb_jawaban_essay')->row();
			$keterangan = ($nilai->total >= $ujian->min_nilai) ? 'LULUS' : 'BELUM LULUS';
			$class_status_siswa = '';
			switch($rows->status_siswa) {
				case 'lulus' :
					$class_status_siswa = 'btn-success';
				break;
				case 'tidak lulus' :
					$class_status_siswa = 'btn-danger';
				break;
				case 'mengulang' :
					$class_status_siswa = 'btn-primary';
				break;
				case 'remedial' :
					$class_status_siswa = 'btn-warning';
				break;
				default :
					$class_status_siswa = 'btn-primary';
				break;
			}	
		?>
			<tr>
				<td><input type="checkbox" name="checklist[]" class="checklist" data-id= "<?=encrypt_url($rows->id);?>" value="<?=$rows->id;?>"></td>
				<td align="center" class="frist"><?=$i;?></td>
				<td><?=$rows->nama_siswa;?></td>
				<td><?= $rows->nama_kelas; ?></td>
				<td><?=$nilai->total;?></td>
				<td><?=$ujian->min_nilai;?></td>
				<td><?=$rows->tgl_mulai;?></td>
				<td><?=$rows->tgl_selesai;?></td>
				<td class="frist">
						<a href="<?=base_url('ujian_essay/ikut_ujian_hasil/'.encrypt_url($rows->id_ujian).'/'.encrypt_url($rows->id_user));?>" class="btn btn-primary btn-sm btn-block">
							Lihat Jawaban
						</a>
						<button class="btn btn-danger btn-sm btn-block ulang-essay-siswa" data-id="<?= encrypt_url($rows->id); ?>" data-nama="<?= $rows->nama_siswa; ?>">
							Ulang Ujian
						</button>
					</div>				
				</td>	
				<!-- <td class="text-center mx-auto">
					<div class="dropdown">
					  <button class="btn <?= $class_status_siswa; ?> btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    <?= $rows->status_siswa == NULL ? 'Mengulang' : ucwords($rows->status_siswa) ?>
					  </button>
					  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					    <a class="dropdown-item" href="#" onclick="updateStatusSiswa('lulus', <?= $rows->id; ?>)">Lulus</a>
					    <a class="dropdown-item" href="#" onclick="updateStatusSiswa('tidak lulus', <?= $rows->id; ?>)">Tidak Lulus</a>
					    <a class="dropdown-item" href="#" onclick="updateStatusSiswa('mengulang', <?= $rows->id; ?>)">Mengulang</a>
					    <a class="dropdown-item" href="#" onclick="updateStatusSiswa('remedial', <?= $rows->id; ?>)">Remedial</a>
					  </div>
					</div>
				</td>  -->
			</tr>
		<?php $i++;endforeach ?>
	</thead>
<tbody>
</tbody>
</table>

<script type="text/javascript">
	$(document).ready(function(){
		let conf, namaSiswa = '';
		$('[data-toggle="tooltip"]').tooltip();   

		$('.ulang-essay-siswa').on('click', function(e) {
			e.preventDefault();
			namaSiswa = $(this).data('nama');
			conf = confirm(`Hasil ujian essay siswa ${namaSiswa} akan terhapus, anda yakin?`);

			if(conf) {
				$.ajax({
					type: 'post',
					url: "<?= base_url('ujian_essay/ulang-ujian-siswa'); ?>",
					data: {
						id: $(this).data('id')
					},
					dataType: 'json',
					success: () => window.location.reload(),
					error: (e) => {
						console.error(e.responseText);
						alert(`Tidak dapat menghapus hasil essay siswa ${namaSiswa}, terjadi kesalahan`);
						return false;
					}
				});
			}
			else {
				return false;
			}
		})
	});
	function updateStatusSiswa(status, id) {
		conf = confirm('Anda yakin?')

		if(conf) {
			$.ajax({
				type:'post',
				url: "<?= base_url('ujian_essay/update_status_siswa'); ?>",
				dataType: 'json',
				data: {
					status,
					id
				},
				success:function (res) {
					if(res.status) {
						pageLoad(1,'ujian_essay/page_load_result')	
					}
					else {
						alert(res.msg)
						console.error(res)
						return false
					}
				}
			})
		}
	}

</script>


