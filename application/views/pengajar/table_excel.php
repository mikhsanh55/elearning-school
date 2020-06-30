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

			<th>NIDN</th>

			<th>NRP/NIP</th>
			<th><?=$this->transTheme->instansi;?></th>
			<th>Semester</th>
		</tr>

		<?php $i= 1; foreach ($datas as $rows):
	
			$get = $this->m_admin->get_by(array('level'=>'guru','kon_id'=>$rows->id));
			$instansi = $this->m_instansi->get_by(['id'=>$rows->instansi]);

		?>

			<tr>


				<td align="center" class="frist"><?=$i;?></td>

				<td><?=$rows->nama;?></td>

				<td><?=$rows->username;?></td>

				<td><?=$rows->nidn;?></td>

				<td><?=$rows->nrp;?></td>
				<td><?=(empty($instansi->instansi)) ? NULL : $instansi->instansi;?></td>
				<td><?= $rows->semester; ?></td>
			</tr>

		<?php $i++;endforeach ?>

	</thead>

<tbody>

</tbody>

</table>





