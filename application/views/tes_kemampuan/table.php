
<table id="custumtb">
	<thead>
		<tr>
			<th class="frist">No</th>
			<th>Nama Modul</th>
			<th><?= $this->transTheme->guru;?></th>
			<th>Opsi</th>
		</tr>
		<?php $i= $page_start; foreach ($paginate['data'] as $rows):
			$get = $this->m_admin->get_by(array('level'=>'guru','kon_id'=>$rows->id));
		?>
			<tr>
				<td align="center" class="frist"><?=$i;?></td>
				<td><?=$rows->nama;?></td>
				<td><?=$rows->nama_guru;?></td>
				<td class="frist">


					<?php
						echo '
						<div class="btn-group mt-2 mb-2">
							<a href="'.base_url('soal/m_soal/edit/0/').md5($rows->id) . '/' . $rows->id . '/' . md5($rows->id) . '/' . $this->session->userdata('admin_konid') . '?id=' . $rows->id . '&sess=' . $this->session->userdata('admin_konid') . '" class="btn btn-primary btn-sm ml-2 mr-2">
								Lihat Soal
							</a>
							<a href="' . base_url('soal/m_ujian/') . md5($rows->id).'/'.$rows->id .  '" class="btn btn-danger btn-sm mr-2">
								Lihat Kuis
							</a>
						</div>';
					?>
				</td>	
			</tr>
		<?php $i++;endforeach ?>
	</thead>
<tbody>
</tbody>
</table>


