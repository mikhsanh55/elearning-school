
<table class="table table-bordered table-striped table-hovered" id="siswa-table">
	<thead>
		<tr>
			<th class="frist">No</th>
			<th>Nama</th>
			<th>NIS</th>
			<th class="frist">Terkumpul</th>
			<th class="frist">Nilai (0/100)</th>
		</tr>
	</thead>
	<tbody>
		<?php if(count($paginate['data']) > 0) { ?>
		<?php $i= $page_start; foreach ($paginate['data'] as $rows):

			$count = $this->m_tugas_attach_siswa->count_by(array('id_tugas'=>$id_tugas,'id_siswa'=>$rows->id_peserta));
			if ($count > 0) {
				$status = '<button class="btn btn-success btn-sm detail-tugas " data-id_tugas ="'.encrypt_url($id_tugas).'" data-id_siswa="'.encrypt_url($rows->id_peserta).'"><i class="fa fa-check mr-2"></i>Sudah</button>';
				$getNilai = $this->m_tugas_nilai->get_by(array('id_tugas'=>$id_tugas,'id_siswa'=>$rows->id_peserta));
				if(!empty($getNilai)) {
					$textNilai = '<input type="text" value="'.$getNilai->nilai.'" maxlength="300" style="height:30px;" class="beri-nilai input-sm only-number" data-siswa="'.$rows->id_peserta.'" data-tugas="'.$id_tugas.'">';	
				}
				else {
					$textNilai = '<input type="text" value="'. 0 .'" maxlength="300" style="height:30px;" class="beri-nilai input-sm only-number" data-siswa="'.$rows->id_peserta.'" data-tugas="'.$id_tugas.'">';
				}
				// print_r($getNilai);exit;
				
			}else{
				$status = '<button class="btn btn-danger btn-sm  mb-1" data-id_tugas ="'.encrypt_url($id_tugas).'" data-id_siswa="'.encrypt_url($rows->id_peserta).'"><i class="fa fa-close mr-2"></i>Belum</button>';
				$status .= '<button class="btn-ingatkan mt-2 btn btn-warning btn-sm" data-tugas="'.encrypt_url($id_tugas).'" data-siswa="'.encrypt_url($rows->id_peserta).'"><i class="fas fa-bell mr-2"></i>Ingatkan</button>';
				$textNilai = NULL;
			}
		?>
			<tr>
				<td align="center" class="frist"><?=$i;?></td>
				<td><?=$rows->nama_siswa;?></td>
				<td><?=$rows->nrp;?></td>
				<td>
					<?=$status;?>
				</td>
				<td>
					<?=$textNilai;?>
				</td>
			</tr>
		<?php $i++;endforeach ?>
		<?php } else { ?>
    	    <tr>
    	        <td colspan="5" class="text-center">Data Kosong</td>
    	    </tr>
    	<?php } ?>
	</tbody>
</table>
<script src="<?=base_url();?>assets/js/jquery/jquery-3.3.1.min.js"></script>
<script src="<?= base_url('assets/plugin/datatables/jquery.dataTables.min.js') ?>"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
<script>
    $(document).ready(function() {

        $('#siswa-table').DataTable({
            responsive: true,
            paging: false,
            info: false
        });

        $('.btn-ingatkan').on('click', function(e) {
			e.preventDefault();
			$('input[type=hidden][name=siswa]').val($(this).data('siswa'));
			$('input[type=hidden][name=tugas]').val($(this).data('tugas'));
			getListAlert({
				idSiswa: $(this).data('siswa'),
				idTugas: $(this).data('tugas')
			});
		});
    });
    function getListAlert(data = {}) {
		$('#chat-place').empty();
		$.ajax({
			type: 'post',
			url: "<?= base_url('tugas/get-list-alert'); ?>",
			data,
			dataType: 'json',
			success: function(res) {
				$('#chat-place').html(res.html);
				$('.nama-siswa').html(res.siswa.nama_siswa);
				$('.kelas-siswa').html(res.siswa.nama_kelas);
				$('#ingatkan-modal').modal('show');
				if(!$('#ingatkan-modal').hasClass('show')) {
					$('#ingatkan-modal').addClass('show')
				}
				if(!$('.modal-backdrop').hasClass('show')) {
					$('.modal-backdrop').addClass('show')
				}
			},
			error: function(e) {
				alert('Tidak bisa mengambil data');
				console.error(e.responseText);
				return false;
			}
		});
	}

	function deleteAlertMessage(self, e) {
		e.preventDefault();
		conf = confirm('Anda yakin akan menghapus pesan ini?');
		if(conf) {
			$.ajax({
				type: 'post',
				url: "<?= base_url('tugas/delete-alert-message'); ?>",
				data: {
					id: $(self).data('id')
				},
				dataType: 'json',
				success: () => getListAlert({
					idSiswa: $(self).data('siswa'),
					idTugas: $(self).data('tugas')
				}),
				error: function(e) {
					alert(e.responseText.msg);
					console.error(e.responseText);
					return false;
				}
			});
		}
	}
</script>