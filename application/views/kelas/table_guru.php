<table id="custumtb">

	<thead>

		<tr>

			<th class="frist"><input type="checkbox" name="checkall" id="checkall"></th>

			<th class="frist">No</th>

			<th><?= $this->name; ?></th>

			<th>Mata Pelajaran</th>

			<th>Keterangan</th>

			<th  class="frist">Total Siswa</th>

			<th class="frist">Opsi</th>

		</tr>

		<?php $i= $page_start; foreach ($paginate['data'] as $rows):

			$jml_siswa = $this->m_detail_kelas->count_by(['id_kelas'=>$rows->id]);

		?>

			<tr>

				<td><input type="checkbox" name="checklist[]" class="checklist" data-id= "<?=encrypt_url($rows->id);?>" value="<?=$rows->id;?>"></td>

				<td align="center" class="frist"><?=$i;?></td>

				<td><?=$rows->nama;?></td>

				<td><?=$rows->nama_mapel;?></td>

				<td><?=$rows->keterangan;?></td>

				<td><?=$jml_siswa;?></td>

				<td class="frist">
					<?php if($jml_siswa > 0) : ?>
						<a href="<?= base_url('jadwal/add'); ?>" class="btn btn-primary btn-sm buat-jadwal">Buat Jadwal</a>
						<a class="btn btn-success btn-sm mr-2" href="<?=base_url('Materi/lists').'/'.md5($rows->id_mapel);?>">Mulai Mengajar</a>
					<?php endif; ?>
					

					<button class="btn btn-primary btn-sm rekrut" data-id="<?=$rows->id;?>" data-jurusan="<?=$rows->id_jurusan;?>">Lihat Siswa</button>

				</td>	

			</tr>

		<?php $i++;endforeach ?>

	</thead>

<tbody>

</tbody>

</table>





