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
<table border="1">
	<thead>
		<tr>
			<th>No</th>
			<th>Nama</th>
			<th>Username</th>
			<th>Email</th>
			<th>Lembaga</th>
		</tr>
	</thead>
	<tbody>
		<?php $i = 1;foreach($datas as $row) : ?>
			<tr>
				<td><?= $i; ?></td>
				<td><?= $row->nama; ?></td>
				<td><?= $row->username; ?></td>
				<td><?= $row->email; ?></td>
				<td><?= $row->nama_instansi; ?></td>
			</tr>
		<?php $i++;endforeach; ?>
	</tbody>
</table>