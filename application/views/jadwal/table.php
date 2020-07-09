

<table id="custumtb">

	<thead>

		<tr>

			<th class="frist">No</th>

			<th><?= $this->transTheme->guru;?></th>

			<th>Mata Pelajaran</th>

			<th>Materi</th>

			<th>Keterangan/Materi</th>

			<th>Mulai</th>

			<th>Selesai</th>
				<th>Opsi</th>

		</tr>

		<?php $i= $page_start; foreach ($paginate['data'] as $rows): 

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

		?>

			<tr>

				<td align="center" class="frist"><?=$i;?></td>

				<td><?=$rows->nama_guru;?></td>

				<td><?=$rows->nama_mp;?></td>

				<td><?=$rows->nama_materi;?></td>

				<td><?=$rows->keterangan;?></td>

				<td><?=$date.' '.$time;?></td>

				<td><?=$date2.' '.$time2;?></td>

				<td>
					<!-- <?php if($this->session->admin_konid == $rows->id_guru && $rows->id_guru != NULL) : ?> -->
					<span><a href="<?=base_url('jadwal/edit/'.md5($rows->id));?>" data-toggle="tooltip" data-id="<?=$rows->id;?>" title="Edit" class="btn btn-default btn-sm aktif_non"><i class="fas fa-edit"></i></a></span>

					<span><a href="javascript:void(0);" data-toggle="tooltip" data-id="<?=$rows->id;?>" title="Edit" class="btn btn-default btn-sm aktif_non deleted"><i class="fas fa-trash-alt"></i></a></span>
					<!-- <?php endif;?> -->
				</td>	
				

			</tr>

		<?php $i++;endforeach ?>

	</thead>

<tbody>

</tbody>

</table>

<script type="text/javascript">

	$(document).on('ready',function(){

		$('[data-toggle="tooltip"]').tooltip();   

	});

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

			})

		}else{

			return false

		}

	})



</script>

