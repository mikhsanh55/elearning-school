<style>
	.password-input {
		position: relative;
	}
	.password-input .fas:hover {
		color:blue;
	}
	.password-input .fas {
		transition: .3s;
		cursor: pointer;
		position: absolute;
		right: 0;
		top:37%;
		margin-right: 10px;
	}
</style>
<table class="table table-bordered table-striped table-hovered" >
	<thead>
		<tr>
			<th><input type="checkbox" name="checkall" id="checkall"></th>
			<th class="frist">No</th>
			<th>Nama</th>
			<th>Username</th>
			<th>
				NIS
			</th>
			<th>Jenis Kelamin</th>
			<!-- <th>Password</th> -->
			<th>Opsi</th>
		</tr>
		<?php if(count($paginate['data']) > 0) { ?>
		<?php $x= 1; foreach ($paginate['data'] as $rows):
			$get = $this->m_admin->get_by(array('level'=>'siswa','kon_id'=>$rows->id));
			$length_pass = strlen($rows->password);
			$pass = '';
			for($i = 0;$i < $length_pass;$i++) {
				$pass .= '*';
			}
		?>
			<tr>
				<td><input type="checkbox" name="checklist[]" class="checklist" value="<?=$rows->id;?>"></td>
				<td align="center" class="frist"><?=$x;?></td>
				<td><?=$rows->nama;?></td>
				<td><?=$rows->username;?></td>
				<td><?=$rows->nrp;?></td>
				<td>
					<?= $rows->nik; ?>
				</td>
				<!-- <td>
					<div class="password-input">
						<input type="password" value="<?= $rows->password; ?>" data-id="<?= $this->encryption->encrypt($rows->user_id); ?>" class="form-control password-reset">
						<i class="fas fa-eye mata-kau" data-id="<?= $this->encryption->encrypt($rows->user_id); ?>"></i>
						</div>
				</td> -->
				<td class="frist">
					<?php

					if ($rows->deleted == 1) {
						 echo $data_link ='<a href="#" onclick="return m_siswa_ak('.$rows->id.',1);" class="btn btn-success btn-sm mr-2"><i class="glyphicon glyphicon-user" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Aktifkan</a>';
					} else {
						 echo $data_link = '<a href="#" onclick="return m_siswa_ak('.$rows->id.',0);" class="btn btn-danger btn-sm mr-2"><i class="glyphicon glyphicon-random" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;NonAktifkan</a>';
					}
					;?>
				</td>	
			</tr>
		<?php $x++;endforeach ?>
		<?php } else { ?>
			<tr>
				<td colspan="9" class="text-center">Data Kosong</td>
			</tr>
		<?php } ?>
	</thead>
<tbody>
</tbody>
</table>


