<style>
    td, th {
        padding:10px;
    }
    .text-right {
        text-align:right;
    }
    table {
        border-collapse:collapse;
    }
</style>
<table border="1">
	<thead>
		<tr>
			<th class="first">No</th>
			<th><?= $this->transTheme->guru;?></th>
			<th>Module Pelatihan</th>
			<th>Materi</th>
			<th>Keterangan/Materi</th>
			<th>Mulai</th>
			<th>Selesai</th>
		</tr>
	</thead>
	<tbody>
		<?php $i = 1;foreach($datas as $rows) : 
			if (!empty($rows->start_date)) {
				$datetime1 = explode(' ', $rows->start_date);
				$date = shortdate_indo($datetime1[0]);
				$time = time_short($datetime1[1]);
			}else{
				$date = NULL;
				$time = NULL;
			}

			if (!empty($rows->end_date)) {
				$datetime2 = explode(' ', $rows->end_date);
				$date2 = shortdate_indo($datetime2[0]);
				$time2 = time_short($datetime2[1]);
			}else{
				$date2 = NULL;
				$time2 = NULL;
			}
		?>
			<tr>
				<td align="center" class="first"><?=$i;?></td>
				<td><?=$rows->nama_guru;?></td>
				<td><?=$rows->nama_mp;?></td>
				<td><?=$rows->nama_materi;?></td>
				<td><?=$rows->keterangan;?></td>
				<td><?=$date.' '.$time;?></td>
				<td><?=$date2.' '.$time2;?></td>	
			</tr>
		<?php $i++; endforeach; ?>
	</tbody>
</table>