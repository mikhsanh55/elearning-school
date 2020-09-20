<table class="table table-bordered table-striped table-hovered" id="detail-ujian-table">
	<thead>
		<tr>
			<th>No</th>
			<th>Nama Ujian</th>
			<th>Tanggal Mulai</th>
			<th>Tanggal Selesai</th>
			<th>KKM</th>
			<th>Nilai</th>
		</tr>
	</thead>
	<tbody>
		<?php if(count($paginate['data']) > 0) { ?>
		<?php $i = 1;foreach($paginate['data'] as $rows) : 
			$nama_mapel = $this->m_mapel->get_by(['id' => $rows->id_mapel]);
			$start_date = date('d-m-Y H:i:s', strtotime($rows->tgl_mulai));
			$end_date = date('d-m-Y H:i:s', strtotime($rows->terlambat));
			$pg = $this->m_ujian->get_nilai([
				'uji.id' => $rows->id,
				'uji.type_ujian' => $rows->type_ujian,
				'ujikls.id_kelas' => $rows->idkelas,
				'id_user'=> $rows->id_user,
				'uji.id_guru'  => $rows->id_guru,
				'uji.id_mapel' => $rows->id_mapel
			]);

			$essay = $this->m_ujian->get_essay([
				'uji.id' => $rows->id,
				'uji.type_ujian' => $rows->type_ujian,
				'ujikls.id_kelas' => $rows->idkelas,
				'ikut.id_user' => $rows->id_user,
				'uji.id_guru'  => $rows->id_guru,
				'uji.id_mapel' => $rows->id_mapel
			]);
			$nilaiPg = (isset($pg->nilai)) ? (int)$pg->nilai:0;
			$nilaiEssay = (isset($essay->nilai)) ? (int)$essay->nilai:0;

			// Check Ulangan Harian
			$check = $this->m_ujian->get_check([
				'uji.id' => $rows->id,
				'uji.type_ujian' => $rows->type_ujian,
				'ujikls.id_kelas' => $rows->idkelas,
				'uji.id_guru'  => $rows->id_guru,
				'uji.id_mapel' => $rows->id_mapel
			]);
			
			if($check < 1){
				$total_nilai = $nilaiPg;
			}else{
				$total_nilai = ($nilaiPg + $nilaiEssay) / 2;
			}
		?>
			<tr>
				<td><?= $i++; ?></td>
				<td><?= $rows->nama_ujian; ?></td>
				<td><?= $start_date; ?></td>
				<td><?= $end_date; ?></td>
				<td><?= $rows->min_nilai; ?></td>
				<td><?= $total_nilai; ?></td>
			</tr>
		<?php endforeach; ?>
		<?php } ?>
	</tbody>
</table>
<script src="<?=base_url();?>assets/js/jquery/jquery-3.3.1.min.js"></script>
<script src="<?= base_url('assets/plugin/datatables/jquery.dataTables.min.js') ?>"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
<script>
    $(document).ready(function() {
        $('#detail-ujian-table').DataTable({
            responsive: true,
            paging: false,
            info: false
        });
    });
</script>