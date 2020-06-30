

<table id="custumtb">

	<thead>

		<tr>

			<th class="frist"><input type="checkbox" name="checkall" id="checkall"></th>

			<th class="frist">No</th>

			<th>Nama Guru</th>

			<th>Username</th>

			<th>NUPTK</th>

			<th>NIP</th>
			<th><?=$this->transTheme->instansi;?></th>
			<th>Semester</th>
			

			<th>Opsi</th>

		</tr>

		<?php $i= $page_start; foreach ($paginate['data'] as $rows):
	
			$get = $this->m_admin->get_by(array('level'=>'guru','kon_id'=>$rows->id));
			$instansi = $this->m_instansi->get_by(['id'=>$rows->instansi]);

		?>

			<tr>

				<td><input type="checkbox" name="checklist[]" class="checklist" value="<?=$rows->id;?>"></td>

				<td align="center" class="frist"><?=$i;?></td>

				<td><?=$rows->nama;?></td>

				<td><?=$rows->username;?></td>

				<td><?=$rows->nidn;?></td>

				<td><?=$rows->nrp;?></td>
				<td><?=(empty($instansi->instansi)) ? NULL : $instansi->instansi;?></td>
				<td><?= $rows->semester; ?></td>
				<td class="frist">





					<?php

					if($this->session->userdata('admin_level') == "admin" || $this->session->userdata('admin_level') == "instansi" || $this->session->userdata('admin_level') == "admin_instansi"){

						echo '<div class="btn-group">

						<a href="#" onclick="return m_guru_matkul('.$rows->id.');" class="btn btn-primary btn-sm mr-2"><i class="glyphicon glyphicon-th-list" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Modul Dikuasai</a>



						';



						if (empty($get)) {

							 echo '<a href="#" onclick="return m_guru_u('.$rows->id.');" class="btn btn-success btn-sm mr-2"><i class="glyphicon glyphicon-user" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Buatkan Password</a>';

						} else {

							echo '<a href="#" onclick="return m_guru_ur('.$rows->id.');" class="btn btn-warning btn-sm mr-2"><i class="glyphicon glyphicon-random" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Reset Password</a>';

						}

					}else{

						echo '<a href="#" onclick="return m_guru_detail('.$rows->id.');" class="btn btn-primary btn-sm mr-2"><i class="glyphicon glyphicon-th-list" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Lihat Profil</a>';

					}



				

					;?>

				</td>	

			</tr>

		<?php $i++;endforeach ?>

	</thead>

<tbody>

</tbody>

</table>





