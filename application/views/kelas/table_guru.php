<style type="text/css">
	h1{
		font-family: sans-serif;
	}

	table {
		margin-top: 10px;
		font-family: Arial, Helvetica, sans-serif;

		font-size: 12px;
		width: 100%;
		color: #666;
		background: #eaebec;
		border: #ccc 1px solid;
		border-radius: 25px;
	}

	table th {
		padding: 2px 5px;
		border:1px solid #337ab7;
		background: #337ab7;;
		text-align: center;
		color: #fff;
	}

	table th:first-child{  
		border-left:none;  
	}

	table tr {
		padding-left: 20px;
	}

	td.frist,th.frist {
    width: 1px;
    white-space: nowrap;
}

	table td {
		padding: 5px 5px;
		border-top: 1px solid #ffffff;
		border-bottom: 1px solid #e0e0e0;
		border-left: 1px solid #e0e0e0;
		background: #fff;
		background: -webkit-gradient(linear, left top, left bottom, from(#fbfbfb), to(#fafafa));
		background: -moz-linear-gradient(top, #fbfbfb, #fafafa);
	}

	table tr:last-child td {
		border-bottom: 0;
	}

	table tr:last-child td:first-child {
		-moz-border-radius-bottomleft: 3px;
		-webkit-border-bottom-left-radius: 3px;
		border-bottom-left-radius: 3px;
	}

	table tr:last-child td:last-child {
		-moz-border-radius-bottomright: 3px;
		-webkit-border-bottom-right-radius: 3px;
		border-bottom-right-radius: 3px;
	}

	table tr:hover td {
		background: #f2f2f2;
		background: -webkit-gradient(linear, left top, left bottom, from(#f2f2f2), to(#f0f0f0));
		background: -moz-linear-gradient(top, #f2f2f2, #f0f0f0);
	}

</style>
<table class="table table-bordered table-striped table-hovered mt-4 mb-4" id="table-kelas">

	<thead>
		<tr>
			<th class="frist">No</th>
			<th class="text-left">Kelas</th>
			<th class="text-left">Wali Kelas</th>
			<th class="text-center">Mata Pelajaran</th>
			<th class="frist">Opsi</th>
		</tr>
	</thead>

	<tbody>
		<?php if(count($paginate['data']) > 0) { ?>
		<?php $i = $paginate['counts']['from_num'];foreach($paginate['data'] as $rows) : 
			$mapel = $this->m_mapel->get_by(['id' => $rows->id_mapel]);
		?>
			<tr>
				<td><?= $i++; ?></td>
				<td><?= $rows->nama; ?></td>
				<td><?= $rows->nama_guru; ?></td>
				<td class="text-center"><?= $rows->nama_mapel == NULL ? 'Kosong' : $rows->nama_mapel; ?></td>
				<td>
					<button class="btn btn-primary btn-sm rekrut mb-2" data-id="<?= $rows->id; ?>" onclick="displaySiswa(this)">Daftar Siswa</button>

					<?php if(!is_null($rows->nama_mapel)) { ?>
						<a href="<?= base_url('Materi/lists/') . md5($rows->dmapel) . '/' . encrypt_url($rows->dguru) . '/' . encrypt_url($rows->id); ?>" class="btn btn-sm btn-primary">Materi</a>
					<?php } else { ?>
						<button class="btn btn-sm btn-dark" disabled>
							Mapel Kosong
						</button>
					<?php } ?>
				</td>
			</tr>
		<?php endforeach;?>
		<?php } else { ?>
			<tr>
				<td class="text-center" colspan="5">Data Kosong</td>
			</tr>
		<?php } ?>
		
	</tbody>
</table>
<script src="<?=base_url();?>assets/js/jquery/jquery-3.3.1.min.js"></script>
<script src="<?= base_url('assets/plugin/datatables/jquery.dataTables.min.js') ?>"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>

<script>
	$(document).ready(function() {
		$('#table-kelas').DataTable({
			responsive: true,
			paging: false,
			info: false
		});
	});
</script>