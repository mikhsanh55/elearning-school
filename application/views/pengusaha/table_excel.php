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
			<th>Nama</th>
			<th>Username</th>
			<th>
<<<<<<< HEAD
				<?= $this->nrp; ?>
=======
				NIS
>>>>>>> first push
			</th>
			<th><?=$this->transTheme->instansi;?></th>
		</tr>
		<?php $i= 1; foreach ($datas as $rows):
			$get = $this->m_admin->get_by(array('level'=>'siswa','kon_id'=>$rows->id));
		?>
			<tr>
				<td><?= $i; ?></td>
				<td><?=$rows->nama;?></td>
				<td><?=$rows->username;?></td>
				<td><?=$rows->nrp;?></td>
				<td><?=$rows->nama_instansi;?></td>
				
			</tr>
		<?php $i++;endforeach ?>
	</thead>
<tbody>
</tbody>
</table>


