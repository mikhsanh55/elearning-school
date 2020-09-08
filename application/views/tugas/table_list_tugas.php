
<table class="table table-bordered table-striped table-hovered">
	<thead>
		<tr>
			<th class="frist">No</th>
			<th>Kelas</th>
			<th>Mata Pelajaran</th>
			<th>Keterangan</th>
			<th>Waktu Pengumpulan</th>
			<th class="frist">Status Tugas</th>

		</tr>
		<?php if(count($paginate['data']) > 0) { ?>
		<?php $where = []; $i= $page_start; foreach ($paginate['data'] as $rows):

			$count = $this->m_tugas_attach_siswa->count_by(array('id_tugas'=>$rows->id,'id_siswa'=>$this->akun->id));

			// Cek apakah guru mengirim reminder
			$where['id_siswa'] = $this->akun->id;
			$where['id_tugas'] = $rows->id;
			
			// Set message selama seminggu
			$now = date('Y-m-d');
			$nowPlus7day = date('Y-m-d', strtotime($now . "+7 day"));
			$where["create_at BETWEEN '" . $now . "' AND '" . $nowPlus7day . "'"] = NULL;
			
			$checkPesan = $this->m_tugas_alert->count_by($where);

			if ($rows->in_jadwal == FALSE && $count < 1) { // Jika melebihi tanggal deadline Khusus sman21
				// $status = '<button class="btn btn-dark btn-sm" disabled>Waktu Habis</button>';
				$status = '<button class="btn btn-warning btn-sm kirim-tugas mb-1 btn-block" data-id_tugas="'.encrypt_url($rows->id).'"> Kerjakan</button>';

				if($checkPesan > 0) {
					$status .= '<button class="btn btn-primary btn-sm lihat-pesan-alert btn-block" data-id_tugas="'.encrypt_url($rows->id).'">Ada Pesan</button>';
				}
			}
			else if ($count > 0) { // Jika sudah mengerjakan
				$status = '<button class="btn btn-success btn-sm kirim-tugas btn-block" data-id_tugas="'.encrypt_url($rows->id).'"><i class="fa fa-check"></i> Sudah</button>';
			}
			// else if($count > 0 && $rows->in_jadwal == FALSE) {
			// 	$status = '<button class="btn btn-block btn-dark btn-sm" disabled>Sudah, terlambat</button>';
			// }
			else if($count < 1 && $rows->in_jadwal == TRUE) { // Jika belum
				$status = '<button class="btn btn-primary btn-sm kirim-tugas btn-block" data-id_tugas="'.encrypt_url($rows->id).'"> Kerjakan</button>';

				if($checkPesan > 0) {
					$status .= '<button class="btn btn-primary btn-sm lihat-pesan-alert btn-block" data-id_tugas="'.encrypt_url($rows->id).'">Ada Pesan</button>';
				}
			}
			
			if (!empty($rows->end_date) && $rows->end_date != '0000-00-00 00:00:00') {
				$datetime1 = explode(' ', $rows->end_date);
				$date = longdate_indo($datetime1[0]).' Pukul '.$time = time_short($datetime1[1]);
				
			}else{
				$date = NULL;
			}
			$mapel = $this->m_mapel->get_by(['id' => $rows->id_mapel]);
			$nama_mapel = !empty($mapel->nama) ? $mapel->nama : '';	
		?>
			<tr>
				<td align="center" class="frist"><?=$i;?></td>
				<td><?=$rows->kelas;?></td>
				<td><?= $nama_mapel; ?></td>
				<td><?=$rows->keterangan;?></td>
				<td class="text-center"><?=$date;?></td>
				<td>
					<?=$status;?>
				</td>
			</tr>
		<?php $i++;endforeach ?>
		<?php } else { ?>
    	    <tr>
    	        <td colspan="6" class="text-center">Data Kosong</td>
    	    </tr>
    	<?php } ?>
	</thead>
<tbody>
</tbody>
</table>
<script>
	function getListAlertSiswa(data = {}) {
		$('#chat-place').empty();
		$.ajax({
			type: 'post',
			url: "<?= base_url('tugas/get-list-alert'); ?>",
			data,
			dataType: 'json',
			success: function(res) {
				$('#chat-place').html(res.html);
				$('.nama-guru').html(res.mapel);
				$('.nama-mapel').html(res.guru);
				$('#ingatkan-modal').modal('show');
			},
			error: function(e) {
				alert('Tidak bisa mengambil data');
				console.error(e.responseText);
				return false;
			}
		});
	}

	$('.lihat-pesan-alert').on('click', function(e) {
		e.preventDefault();
		var idSiswa = "<?= encrypt_url($this->akun->id); ?>",
			idTugas = $(this).data('id_tugas');

		$.ajax({
			type: 'post',
			url: "<?= base_url('tugas/get-list-alert'); ?>",
			data: {
				idSiswa,
				idTugas
			},
			dataType: 'json',
			success: function(res) {
				$('#chat-place').html(res.html);
				$('.nama-guru').html(res.mapel);
				$('.nama-mapel').html(res.guru);
				$('#ingatkan-modal').modal('show');
			},
			error: function(e) {
				console.error(e.responseText);
				alert(e.responseText.msg);
				return false;
			}
		}).done(() => {
			// Update status pesan dari belum dilihat => sudah dilihat
			$.ajax({
				type: 'post',
				url: "<?= base_url('tugas/update-status-alert'); ?>",
				data: {
					idSiswa,
					idTugas
				},
				dataType: 'json',
				success: () => getListAlertSiswa({
					idSiswa,
					idTugas
				})
			});
		});
	});
</script>