
<table id="custumtb">
	<thead>
		<tr>
			<th class="frist"><input type="checkbox" name="checkall" id="checkall"></th>
			<th class="frist">No</th>
			<th>Nama</th>
			<th>Username</th>
			<th>Email</th>
			<th><?=$this->transTheme->instansi;?></th>
			<th class="frist">Opsi</th>
		</tr>
		<?php if(count($paginate['data']) > 0) { ?>
		<?php $i= $page_start; foreach ($paginate['data'] as $rows):
			$admin = $this->m_admin->count_by(array('level'=>'instansi','kon_id'=>$rows->id));
		?>
			<tr>
				<td><input type="checkbox" name="checklist[]" class="checklist" data-id= "<?=sha1($rows->id);?>" value="<?=$rows->id;?>"></td>
				<td align="center" class="frist"><?=$i;?></td>
				<td><?=$rows->nama;?></td>
				<td><?=$rows->username;?></td>
				<td><?=$rows->email;?></td>
				<td><?=$rows->nama_instansi;?></td>
				<td class="frist">
					<?php

					if ($admin == 0) {
						echo '<a href="javascript:void(0);" class="btn btn-success buat-pass btn-sm mr-2" data-nama="'.$rows->nama.'" data-id="'.$rows->id.'"><i class="glyphicon glyphicon-user" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Buatkan Password</a>';
					} else {
						echo '<a href="javascript:void(0);" class="btn btn-warning reset-pass btn-sm mr-2" data-nama="'.$rows->nama.'" data-id="'.$rows->id.'"><i class="glyphicon glyphicon-random" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Reset Password</a>';
					}

					if ($rows->deleted == 1) {
						 echo $data_link ='<a href="javascript:void(0);" class="btn btn-success aktif-non-akun btn-sm mr-2" data-nama="'.$rows->nama.'" data-id="'.$rows->id.'" data-status="'.$rows->deleted.'"><i class="glyphicon glyphicon-user" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Aktifkan</a>';
					} else {
						 echo $data_link = '<a href="javascript:void(0);" class="btn btn-danger aktif-non-akun btn-sm mr-2" data-nama="'.$rows->nama.'" data-id="'.$rows->id.'" data-status="'.$rows->deleted.'"><i class="glyphicon glyphicon-random" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;NonAktifkan</a>';
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


