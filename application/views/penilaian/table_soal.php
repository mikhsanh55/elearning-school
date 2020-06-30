
<table id="custumtb">
	<thead>
		<tr>
			<th class="frist"><input type="checkbox" name="checkall" id="checkall"></th>
			<th class="frist">No</th>
			<th>Soal</th>
			<th>Dimensi</th>
			<th>Indikator Bobot</th>
			<!-- <th>Analisa</th> -->
		
		</tr>
		<?php 
			if (count($paginate['data']) > 0) {
			$i= $page_start; foreach ($paginate['data'] as $rows):
			$dimensi = $this->m_dimensi->get_by(['id'=>$rows->id_dimensi]);
		?>
			<tr>
				<td><input type="checkbox" name="checklist[]" class="checklist" data-id= "<?=$rows->id;?>" value="<?=$rows->id;?>"></td>
				<td align="center" class="frist"><?=$i;?></td>
				<td><?=$rows->soal;?></td>
				<td><?=$dimensi->nama;?></td>
				<td><?=$rows->bobot;?></td>
				<!-- <td><?=$analisa;?></td> -->
			</tr>
		<?php $i++; endforeach; } else { echo '<tr><td colspan="3" align="center">DATA KOSONG</td></tr>';} ?>
	</thead>
<tbody>
</tbody>
</table>


