
<table id="custumtb">
	<thead>
		<tr>
			<th><input type="checkbox" name="checkall" id="checkall"></th>
			<th class="frist">No</th>
			<th>Nama</th>
			<th>Username</th>
			<th>
				NIS
			</th>
			<th><?=$this->transTheme->instansi;?></th>
			<th>Opsi</th>
		</tr>
		<?php if(count($paginate['data']) > 0) { ?>
		<?php $i= $page_start; foreach ($paginate['data'] as $rows):
			$get = $this->m_admin->get_by(array('level'=>'siswa','kon_id'=>$rows->id));
		?>
			<tr>
				<td><input type="checkbox" name="checklist[]" class="checklist" value="<?=$rows->id;?>"></td>
				<td align="center" class="frist"><?=$i;?></td>
				<td><?=$rows->nama;?></td>
				<td><?=$rows->username;?></td>
				<td><?=$rows->nrp;?></td>
				<td><?=$rows->nama_instansi;?></td>
				<td class="frist">
					<?php

					if (empty($get)) {
						echo '<a href="#" onclick="return m_siswa_u('.$rows->id.');" class="btn btn-success btn-sm mr-2"><i class="glyphicon glyphicon-user" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Buatkan Password</a>';
					} else {
						echo '<a href="#" onclick="return m_siswa_ur('.$rows->id.');" class="btn btn-warning btn-sm mr-2"><i class="glyphicon glyphicon-random" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Reset Password</a>';
					}

					if ($rows->deleted == 1) {
						 echo $data_link ='<a href="#" onclick="return m_siswa_ak('.$rows->id.',1);" class="btn btn-success btn-sm mr-2"><i class="glyphicon glyphicon-user" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Aktifkan</a>';
					} else {
						 echo $data_link = '<a href="#" onclick="return m_siswa_ak('.$rows->id.',0);" class="btn btn-danger btn-sm mr-2"><i class="glyphicon glyphicon-random" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;NonAktifkan</a>';
					}
					;?>
				</td>	
			</tr>
		<?php $i++;endforeach ?>
	<?php } else { ?>
		<tr>
			<td colspan="7" class="text-center">Data Kosong</td>
		</tr>
	<?php } ?>
	</thead>
<tbody>
</tbody>
</table>


