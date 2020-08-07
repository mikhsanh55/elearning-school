<table class="table table-bordered table-striped table-hovered">
	<thead>
		<tr>
			<th class="frist" rowspan="2">No</th>
			<th rowspan="2"><?= $this->transTheme->siswa;?></th>
			<th rowspan="2">Kelas</th>
			<?php if($this->log_lvl == 'siswa') : ?>
				<th rowspan="2">Guru</th>
			<?php endif; ?>
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

		$uts = $this->m_ujian->get_nilai([
			'uji.type_ujian' => 'uts',
			'ujikls.id_kelas' => $rows->id_kelas,
			'id_user'=>$rows->id_peserta,
			'uji.id_guru'  => $rows->id_guru
		]);

		$uts_essay = $this->m_ujian->get_essay([
			'uji.type_ujian' => 'uts',
			'uji.id_kelas' => $rows->id_kelas,
			'ikut.id_user' => $rows->id_peserta,
			'uji.id_guru'  => $rows->id_guru
		]);

		$ujian_harian = $this->m_ujian->get_nilai([
			'uji.type_ujian' => 'harian',
			'ujikls.id_kelas' => $rows->id_kelas,
			'ikut.id_user' => $rows->id_peserta,
			'uji.id_guru'  => $rows->id_guru
		]);

		$ujian_harian_essay = $this->m_ujian->get_essay([
			'uji.type_ujian' => 'harian',
			'uji.id_kelas' => $rows->id_kelas,
			'ikut.id_user' => $rows->id_peserta,
			'uji.id_guru'  => $rows->id_guru
		]);

		$utsNilai = (isset($uts->nilai)) ? (int)$uts->nilai:0;
		$utsNilaiEssay = (isset($uts_essay->nilai)) ? (int)$uts_essay->nilai:0;

		$harianNilai = (isset($ujian_harian->nilai)) ? (int)$ujian_harian->nilai:0;
		$harianNilaiEssay = (isset($ujian_harian_essay->nilai)) ? (int)$ujian_harian_essay->nilai:0;

		// Check UTS
		$check = $this->m_ujian->get_check([
			'uji.type_ujian' => 'uts',
			'ujikls.id_kelas' => $rows->id_kelas,
			'uji.id_guru'  => $rows->id_guru
		]);
		
		if($check > 0){
			$total_uts = $utsNilai;
		}else{
			$total_uts = ($utsNilai + $utsNilaiEssay) / 2;
		}
		$total_uts = ($utsNilai + $utsNilaiEssay) / 2;

		// Check Ulangan Harian
		$check = $this->m_ujian->get_check([
			'uji.type_ujian' => 'harian',
			'ujikls.id_kelas' => $rows->id_kelas,
			'uji.id_guru'  => $rows->id_guru
		]);
		
		if($check > 0){
			$total_harian = $harianNilai;
		}else{
			$total_harian = ($harianNilai + $harianNilaiEssay) / 2;
		}
		$total_harian = ($harianNilai + $harianNilaiEssay) / 2;

		// Check UAS
		$uas = $this->m_ujian->get_nilai([
			'uji.type_ujian' => 'uas',
			'ujikls.id_kelas' => $rows->id_kelas,
			'id_user' => $rows->id_peserta,
			'uji.id_guru'  => $rows->id_guru
		]);
		$uas = $this->m_ujian->get_essay([
			'uji.type_ujian' => 'uas',
			'uji.id_kelas' => $rows->id_kelas,
			'ikut.id_user' => $rows->id_peserta,
			'uji.id_guru'  => $rows->id_guru
		]);

		$uasNilai = (isset($uas->nilai)) ? (int)$uas->nilai:0;
		$uasNilaiEssay = (isset($uas_essay->nilai)) ? (int)$uas_essay->nilai:0;
		$check = $this->m_ujian->get_check([
			'uji.type_ujian' => 'uas',
			'ujikls.id_kelas' => $rows->id_kelas,
			'uji.id_guru'  => $rows->id_guru
		]);
		
		if($check > 0){
			$total_uas = $uasNilai;
		}else{
			$total_uas = ($uasNilai + $uasNilaiEssay) / 2;
		}

		$tugas = $this->m_tugas->get_nilai([
			'tgs.id_guru' => $rows->id_guru,
			'id_mapel' => $rows->id_mapel,
			'tgs.id_kelas'=>$rows->id_kelas,
			'id_siswa'=>$rows->id_peserta
		]);
		
		$nama_guru = $this->m_guru->get_by(['id' => $rows->id_guru]);

		// Nilai Keaktifan
		$sumKeaktifan = 4;
		$nilaiKeaktifan = ($rows->active_login + $rows->active_video + $rows->active_materi + $rows->active_diskusi + $rows->active_tugas) / $sumKeaktifan;
			?>
				<tr>
					<td align="center" class="frist"><?=$i;?></td>
					<td><?=$rows->siswa;?></td>
					<td><?=$rows->nama_kelas;?></td>
					<?php if($this->log_lvl === 'siswa') : ?>
						<td><?= $nama_guru->nama; ?></td>
					<?php endif; ?>
					<td><?=$rows->mapel;?></td>
					<td><?=(isset($total_harian)) ? (int)$total_harian:0;?></td>
					<td><?=(isset($total_uts)) ? (int)$total_uts:0;?></td>
					<td><?=(isset($uas->nilai)) ? (int)$uas->nilai:0;?></td>
					<td><?=(isset($tugas->nilai)) ? (int)$tugas->nilai:0;?></td>
					<td><?=$nilaiKeaktifan <= 0 ? 0 : (int)$nilaiKeaktifan;?></td>
				</tr>
			<?php $i++;endforeach ?>
	<?php } else { ?>		
	    <tr>
	        <td colspan="10" rowspan="2" class="text-center">Data Not Found</td>
	    </tr>
	    
	<?php } ?>
	</tbody>
</table>
