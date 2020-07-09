
<table id="custumtb">
	<thead>
		<tr>
			<th class="frist">No</th>
			<th>Kode Mata Pelajaran</th>
			<th>Mata Pelajaran</th>
			<!-- <th><?=$this->transTheme->instansi;?></th> -->
			<th>Opsi</th>
		</tr>
		<?php if(count($paginate['data']) > 0) { ?>
		<?php $i= $page_start; foreach ($paginate['data'] as $rows):
			$instansi = $this->m_instansi->get_by(['id'=>$rows->id_instansi]);
		?>
			<tr>
				<td align="center" class="frist"><?=$i;?></td>
				<td><?=$rows->kd_mp;?></td>
				<td><?=$rows->nama;?></td>
		
				<td class="frist">


					<?php
	
						echo '<div class="btn-group mx-auto d-flex justify-content-center">
						<a class="btn btn-primary btn-sm mr-2 lihat-trainer" data-id="'.$rows->id.'" href="javascript:void(0);"><i class="glyphicon glyphicon-eye" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;'.$this->transTheme->guru.'</a>
						<div class="btn-group mx-auto d-flex justify-content-center">
						<a class="btn btn-primary btn-sm mr-2" data-mapel="'.$rows->id.'" href="#" data-href="'.base_url('Materi/lists').'/'.md5($rows->id).'" onclick="saveSess(this)" ><i class="glyphicon glyphicon-eye" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Materi</a>
						<a href="#" onclick="return m_mapel_e('.$rows->id.');" class="btn btn-info btn-sm mr-2"><i class="glyphicon glyphicon-pencil" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Edit</a>
						<a href="#" onclick="return m_mapel_h('.$rows->id.');" class="btn btn-danger btn-sm mr-2"><i class="glyphicon glyphicon-remove" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Hapus</a>
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


