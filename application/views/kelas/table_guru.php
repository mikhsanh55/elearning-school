<table id="custumtb">

	<thead>

		<tr>

			<th class="frist">No</th>

			<th class="text-left">Daftar Kelas</th>

			<th class="text-left">Wali Kelas</th>

			<th class="frist">Opsi</th>

		</tr>
	</thead>

	<tbody>
		<?php $i = 1;foreach($paginate['data'] as $rows) : 
			$mapel = $this->m_mapel->get_by(['id' => $rows->id_mapel]);
		?>
			<tr>
				<td><?= $i++; ?></td>
				<td><?= $rows->nama; ?></td>
				<td><?= $rows->nama_guru; ?></td>
				<td>
					<button class="btn btn-primary btn-sm rekrut mb-2" data-id="<?= $rows->id; ?>" onclick="displaySiswa(this)">Lihat Siswa</button>

				  	<?php 
				  		$mapels = $this->m_detail_kelas_mapel->get_all(['dklsmapel.id_kelas' => $rows->id]);
				  		if(count($mapels) > 0) {
				  	?>
						<div class="dropdown show">
						  <a class="btn btn-primary btn-block  btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width:80%;text-align: left;">
						    Mulai Kelas
						  </a>
						  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="width: 80%;">
						  <?php foreach($mapels as $m) : ?>
						  	<a href="<?= base_url('Materi/lists/') . md5($m->id_mapel); ?>" class="dropdown-item"><?= $m->nama_mapel ?></a>
						  <?php endforeach; ?>	  	
						  </div>
						</div>
					<?php } else { ?>
						<button class="btn btn-sm btn-primary" disabled>Mulai Kelas</button>
					<?php } ?>
				</td>
			</tr>
		<?php endforeach;?>
		
	</tbody>

</table>





