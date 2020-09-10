<style>
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
<table class="table table-bordered table-striped table-hovered" id="table-kalender">
	<thead>
		<tr>
			<th class="frist"><input type="checkbox" name="checkall" id="checkall"></th>
			<th class="frist">No</th>
			<th>Kelas</th>
			<th>Guru</th>
			<th>Mata Pelajaran</th>
			<th>Materi</th>
			<th>Keterangan</th>
			<th>Mulai</th>
			<th>Selesai</th>
			<!-- <th>Opsi</th> -->
		</tr>
		<?php if(count($paginate['data']) > 0) { ?>
		<?php $i= $page_start; foreach ($paginate['data'] as $rows): 
			$kelas = $this->m_kelas->get_by(['kls.id' => $rows->id_kelas]);
			$nama_kelas = !empty($kelas) ? $kelas->nama : 'Kosong';
			if (!empty($rows->start_date)) {

				$datetime1 = explode(' ', $rows->start_date);

				$date = shortdate_indo($datetime1[0]);

				$time = time_short($datetime1[1]);

			}else{

				$date = NULL;

				$time = NULL;

			}



			if (!empty($rows->end_date)) {

				$datetime2 = explode(' ', $rows->end_date);

				$date2 = shortdate_indo($datetime2[0]);

				$time2 = time_short($datetime2[1]);

			}else{

				$date2 = NULL;

				$time2 = NULL;

			}
			$nama_guru = $this->m_guru->get_by(['id' => $rows->id_guru]);
			$nama_guru = !empty($nama_guru) ? $nama_guru->nama : '';

			$nama_mapel = $this->m_mapel->get_by(['id' => $rows->mt_id_mapel]);
			$nama_mapel = !empty($nama_mapel) ? $nama_mapel->nama : '';
		?>
			<tr>
				<td><input type="checkbox" name="checklist[]" class="checklist" value="<?=$rows->id;?>" data-id="<?=md5($rows->id);?>"></td>
				<td align="center" class="frist"><?=$i;?></td>
				<td><?= $nama_kelas; ?></td>
				<td><?=$nama_guru;?></td>
				<td><?=$nama_mapel;?></td>
				<td><?=$rows->nama_materi;?></td>
				<td><?=$rows->keterangan;?></td>
				<td><?=$date.' '.$time;?></td>
				<td><?=$date2.' '.$time2;?></td>
				<!-- <td class="d-flex justify-content-around">
					<a href="<?=base_url('jadwal/edit/'.md5($rows->id));?>" data-toggle="tooltip" data-id="<?=$rows->id;?>" title="Edit" class="btn btn-default btn-sm aktif_non"><i class="fas fa-edit"></i></a>

					<a href="javascript:void(0);" data-toggle="tooltip" data-id="<?=$rows->id;?>" title="Edit" class="btn btn-default btn-sm aktif_non deleted"><i class="fas fa-trash-alt"></i></a>
				</td>	 -->
			</tr>

		<?php $i++;endforeach ?>
	<?php } else { ?>
		<tr>
		<td class="text-center" colspan="8">Data Kosong</td>
		</tr>
	<?php } ?>
	</thead>
</table>

<script type="text/javascript">
	$(document).on('ready',function(){
		$('#table-kalender').DataTable();
		$('[data-toggle="tooltip"]').tooltip();   

		$('.deleted').click(function(){
			var y = confirm('Apakah anda yakin ingin mengapus data ini ?');

			if (y == true) {
				$.ajax({
					type : 'post',
					url  : '<?=base_url('jadwal/hapus/');?>',
					dataType : 'json',
					data : {
						id : $(this).data('id')
					},
					success:function(response){
					    $('.notif-number').empty()
					    $('#notif-list').empty()
						pageLoad(1,'jadwal/page_load');
					}
				});
			}else{
				return false;
			}
		});
	});
</script>

