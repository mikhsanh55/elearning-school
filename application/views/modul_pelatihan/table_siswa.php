
<table class="table table-bordered table-striped table-hovered">
	<thead>
		<tr>
			<th class="frist">No</th>
			<th>Nama Mata Pelajaran</th>
			<th><?=$this->transTheme->guru;?></th>
			<th>Opsi</th>
		</tr>
		<?php if(count($paginate['data']) > 0) { ?>
		<?php $i= $page_start; foreach ($paginate['data'] as $rows):
			$get = $this->m_admin->get_by(array('level'=>'guru','kon_id'=>$rows->id));
		?>
			<tr>
				<td align="center" class="frist"><?=$i;?></td>
				<td><?=$rows->nama;?></td>
				<td><?=$rows->nama_guru;?></td>
				<td class="frist">


					<?php
						echo '<div class="btn-group d-flex justify-content-center">
						<a class="btn btn-success btn-sm hit-btn mr-2" href="#" onclick="hit(this)" href="#" data-href="'.base_url('Materi/lists').'/'.md5($rows->id).'" data-mapel="'.$rows->id.'"><i class="glyphicon glyphicon-eye" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Materi</a>
						<a class="btn btn-danger btn-sm  mr-2" href="#" onclick="hit(this)" href="#" data-href="'.base_url('ujian/ikuti_ujian').'/'.md5($rows->id).'" data-mapel="'.$rows->id.'"><i class="glyphicon glyphicon-eye" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Tes</a>

						';
						
					?>
				</td>	
			</tr>
		<?php $i++;endforeach ?>
		<?php } else { ?>
			<tr>
				<td class="text-center" colspan="3">Data Kosong</td>
			</tr>
		<?php } ?>
	</thead>
<tbody>
</tbody>
</table>


