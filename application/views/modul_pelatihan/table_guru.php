
<table id="custumtb">
	<thead>
		<tr>
			<th class="frist">No</th>
<<<<<<< HEAD
			<th>Nama Modul</th>
=======
			<th>Nama Mata Pelajaran</th>
>>>>>>> first push
			<th>Opsi</th>
		</tr>
		<?php $i= $page_start; foreach ($paginate['data'] as $rows):
		?>
			<tr>
				<td align="center" class="frist"><?=$i;?></td>
				<td><?=$rows->nama;?></td>
				<td class="frist">


					<?php

						echo '<div class="btn-group d-flex justify-content-center">
						<a class="btn btn-success btn-sm mr-2" href="#" data-href="'.base_url('Materi/lists').'/'.md5($rows->id).'" onclick="saveSess(this)" href="#" data-href="'.base_url('Materi/lists').'/'.md5($rows->id).'" data-mapel="'.$rows->id.'"><i class="glyphicon glyphicon-eye" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Materi</a>';
					

						
					?>
				</td>	
			</tr>
		<?php $i++;endforeach ?>
	</thead>
<tbody>
</tbody>
</table>


