
<table class="table table-bordered table-striped table-hovered">
	<thead>
		<tr>
			<th class="frist"><input type="checkbox" name="checkall" id="checkall"></th>
			<th class="frist">No</th>
			<th>Soal</th>
			<!-- <th>Analisa</th> -->
		
		</tr>
		<?php 
			if (count($paginate['data']) > 0) {
			$i= $page_start; foreach ($paginate['data'] as $rows):
			/*$jml_benar = empty($d['jml_benar']) ? 0 : intval($d['jml_benar']);
			$jml_salah = empty($d['jml_salah']) ? 0 : intval($d['jml_salah']);
			$total = ($jml_benar + $jml_salah);
			$persen_benar = $total > 0 ? (($jml_benar / $total) * 100) : 0; 
			$analisa = NULL;
			$analisa .= '<button type="button">Jml dipakai : '.($total).'</button>';
			$analisa .= '<button type="button">Bener : '.($jml_benar).'</button>';
			$analisa .= '<button type="button">Salah : '.($jml_salah).'</button>';
			$analisa .= '<button type="button">Presentase : '.number_format($persen_benar).'%</button>';
			$analisa .= '<button type="button">Jml dipakai : '.($total).'</button>';
			$adnalisa = "Jml dipakai : ".($total)."<br>Benar: ".$jml_salah.", Salah: ".$jml_salah."<br>Persentase benar : ".number_format($persen_benar)." %";*/
		?>
			<tr>
				<td><input type="checkbox" name="checklist[]" class="checklist" data-id= "<?=$rows->id;?>" value="<?=$rows->id;?>"></td>
				<td align="center" class="frist"><?=$i;?></td>
				<td><?=$rows->soal;?></td>
				<!-- <td><?=$analisa;?></td> -->
			</tr>
		<?php $i++; endforeach; } else { echo '<tr><td colspan="3" align="center">DATA KOSONG</td></tr>';} ?>
	</thead>
<tbody>
</tbody>
</table>


