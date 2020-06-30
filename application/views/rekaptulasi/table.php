
<table id="custumtb">
	<thead>
		<tr>
			<th class="frist" rowspan="2">No</th>
			<th rowspan="2"><?= $this->transTheme->siswa;?></th>
			<th rowspan="2">Jurusan</th>
			<th rowspan="2">Semester</th>
			<th rowspan="2">Mata Kuliah</th>
			<th colspan="4">Nilai</th>
		</tr>
		<tr>
			<th>UTS</th>
			<th>UAS</th>
			<th>Tugas</th>
			<th>Keaktifan</th>
		</tr>
	</thead>
	<tbody>
	    <?php if(count($paginate['data']) > 0) { ?>
	<?php $i= $page_start; foreach ($paginate['data'] as $rows): 
		$uts = $this->m_ujian->get_nilai(['uji.type_ujian'=>'uts','uji.id_kelas'=>$rows->id_kelas,'id_user'=>$rows->id_peserta]);
		$uts_essay = $this->m_ujian->get_essay(['uji.type_ujian'=>'uts','uji.id_kelas'=>$rows->id_kelas,'ikut.id_user'=>$rows->id_peserta]);
		$utsNilai = (isset($uts->nilai)) ? (int)$uts->nilai:0;
		$utsNilaiEssay = (isset($uts_essay->nilai)) ? (int)$uts_essay->nilai:0;
		$check = $this->m_ujian->get_check(['uji.type_ujian'=>'uts','uji.id_kelas'=>$rows->id_kelas]);
		
		if($check > 0){
			$total_uts = $utsNilai;
		}else{
			$total_uts = ($utsNilai + $utsNilaiEssay) / 2;
		}
		$total_uts = ($utsNilai + $utsNilaiEssay) / 2;
		$uas = $this->m_ujian->get_nilai(['uji.type_ujian'=>'uas','uji.id_kelas'=>$rows->id_kelas,'id_user'=>$rows->id_peserta]);
		$uas = $this->m_ujian->get_essay(['uji.type_ujian'=>'uas','uji.id_kelas'=>$rows->id_kelas,'ikut.id_user'=>$rows->id_peserta]);

		$uasNilai = (isset($uas->nilai)) ? (int)$uas->nilai:0;
		$uasNilaiEssay = (isset($uas_essay->nilai)) ? (int)$uas_essay->nilai:0;
		$check = $this->m_ujian->get_check(['uji.type_ujian'=>'uas','uji.id_kelas'=>$rows->id_kelas]);
		
		if($check > 0){
			$total_uas = $uasNilai;
		}else{
			$total_uas = ($uasNilai + $uasNilaiEssay) / 2;
		}

		$tugas = $this->m_tugas->get_nilai(['tgs.id_kelas'=>$rows->id_kelas,'id_siswa'=>$rows->id_peserta]);
			?>
				<tr>
					<td align="center" class="frist"><?=$i;?></td>
					<td><?=$rows->siswa;?></td>
					<td><?=$rows->jurusan;?></td>
					<td><?=$rows->semester;?></td>
					<td><?=$rows->mapel;?></td>
					<td><?=(isset($total_uts)) ? (int)$total_uts:0;?></td>
					<td><?=(isset($uas->nilai)) ? (int)$uas->nilai:0;?></td>
					<td><?=(isset($tugas->nilai)) ? (int)$tugas->nilai:0;?></td>
					<td><?=(isset($uas->nilai)) ? $uas->nilai:0;?></td>
				</tr>
			<?php $i++;endforeach ?>
	<?php } else { ?>		
	    <tr>
	        <td colspan="10" rowspan="2" class="text-center">Data Not Found</td>
	    </tr>
	    
	<?php } ?>
	</tbody>
</table>
