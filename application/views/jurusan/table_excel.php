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
<br><br>
<br><br>

<table id="custumtb" border="1">
	<thead>
		<tr>
			<th class="frist">No</th>
			<th class="frist">Kode</th>
			<th>Kelas</th>
			<?php if($this->log_lvl == 'admin'):?>
				<th><?=$this->transTheme->instansi;?></th>
			<?php endif;?>
		</tr>
	</thead>
	<tbody>
		
		<?php $i= 1; foreach ($datas as $row): ?>
			<tr>
				<td><?= $i; ?></td>
				<td><?= $row->id; ?></td>
				<td><?= $row->jurusan; ?></td>
				<?php if($this->log_lvl == 'admin'):?>
					<td><?=$row->nama_instansi;?></td>
				<?php endif;?>
			</tr>
		<?php $i++;endforeach; ?>
	</tbody>
</table>