
<table class="table table-bordered table-striped table-hovered">
	<thead>
		<tr>
			<th class="frist">No</th>
			<th>Nama</th>
			<th>NIS</th>
			<th class="frist">Terkumpul</th>
			<th class="frist">Nilai (0/100)</th>
		</tr>
		<?php if(count($paginate['data']) > 0) { ?>
		<?php $i= $page_start; foreach ($paginate['data'] as $rows):

			$count = $this->m_tugas_attach_siswa->count_by(array('id_tugas'=>$id_tugas,'id_siswa'=>$rows->id_peserta));
			if ($count > 0) {
				$status = '<button class="btn btn-success btn-sm detail-tugas" data-id_tugas ="'.encrypt_url($id_tugas).'" data-id_siswa="'.encrypt_url($rows->id_peserta).'"><i class="fa fa-check"></i>Sudah</button>';
				$getNilai = $this->m_tugas_nilai->get_by(array('id_tugas'=>$id_tugas,'id_siswa'=>$rows->id_peserta));
				if(!empty($getNilai)) {
					$textNilai = '<input type="text" value="'.$getNilai->nilai.'" maxlength="300" style="height:30px;" class="beri-nilai form-control input-sm only-number" data-siswa="'.$rows->id_peserta.'" data-tugas="'.$id_tugas.'">';	
				}
				else {
					$textNilai = '<input type="text" value="'. 0 .'" maxlength="300" style="height:30px;" class="beri-nilai form-control input-sm only-number" data-siswa="'.$rows->id_peserta.'" data-tugas="'.$id_tugas.'">';
				}
				// print_r($getNilai);exit;
				
			}else{
				$status = '<button class="btn btn-danger btn-sm" data-id_tugas ="'.encrypt_url($id_tugas).'" data-id_siswa="'.encrypt_url($rows->id_peserta).'"><i class="fa fa-close"></i>Belum</button>';
				$status .= '<button class="btn-ingatkan mt-2 btn btn-warning btn-sm" data-id_tugas="'.encrypt_url($id_tugas).'" data-siswa="'.encrypt_url($rows->id_peserta).'"><i class="fas fa-bell mr-2"></i>Ingatkan</button>';
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
	</thead>
<tbody>
</tbody>
</table>