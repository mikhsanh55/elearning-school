<table id="custumtb">
	<thead>
		<tr>
			<th class="frist"><input type="checkbox" name="checkall" id="checkall"></th>
			<th class="frist">No</th>
			<th>Kelas</th>
			<th>Wali Kelas</th>
			<th class="frist">Opsi</th>
		</tr>
		

		<!-- <?php $i= $page_start; foreach ($paginate['data'] as $rows):
			$jml_siswa = $this->m_detail_kelas->count_by(['id_kelas'=>$rows->id]);
			$nama_kelas = $this->m_jurusan->get_by(['id' => $rows->id_jurusan]);
		?>
			<tr>
				<td><input type="checkbox" name="checklist[]" class="checklist" data-id= "<?=encrypt_url($rows->id);?>" value="<?=$rows->id;?>"></td>
				<td align="center" class="frist"><?=$i;?></td>
				<td><?= $nama_kelas->jurusan; ?></td>
				<td><?=$rows->nama;?></td>
				<td><?=$rows->nama_mapel;?></td>
				<td><?=$rows->keterangan;?></td>
				<td><?=$jml_siswa;?></td>
				<td class="frist">
					<button class="btn btn-primary btn-sm rekrut" data-id="<?=$rows->id;?>" data-jurusan="<?=$rows->id_jurusan;?>">Pilih Siswa</button>
					<?php if($jml_siswa > 0) : ?>
						<a href="<?= base_url('jadwal/add'); ?>" class="btn btn-primary btn-sm buat-jadwal">Buat Jadwal</a>
						<a class="btn btn-success btn-sm mr-2" href="<?=base_url('Materi/lists').'/'.md5($rows->id_mapel);?>">Mulai Mengajar</a>
					<?php endif; ?>
				</td>	
			</tr>
		<?php $i++;endforeach ?> -->
	</thead>
	<tbody>
		<?php $i = 1;foreach($paginate['data'] as $rows) : ?>
			<tr>
				<td>
					<input type="checkbox" name="checklist[]" class="checklist" data-id= "<?=encrypt_url($rows->id);?>" value="<?=$rows->id;?>">
				</td>
				<td><?= $i; ?></td>
				<td>
					<?= $rows->nama; ?>
				</td>
				<td>
					<?= $rows->nama_guru; ?>
				</td>
				<td>
					<button class="btn btn-primary btn-sm mb-2" data-id="<?= $rows->id; ?>" onclick="displaySiswa(this)">Lihat Siswa</button>
					<button class="btn btn-primary btn-sm  mb-2" data-id="<?= $rows->id; ?>" onclick="displayMapel(this)">Lihat Mapel</button>
				</td>
			</tr>
		<?php $i++;endforeach; ?>
	</tbody>
</table>


