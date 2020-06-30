<!-- <div class="row col-md-12 ini_bodi">
	<div class="panel panel-info">
		<div class="panel-heading">Selesai ujian   </div>
		<div class="panel-body">
		<?php echo $data; ?>

		<a href="<?php echo base_url(); ?>ujian/ikuti_ujian">Kembali</a>
		</div>
	</div>
</div>
</div> -->


<div class="row col-md-12 ini_bodi">
	<div class="panel panel-info">
		
		<div class="  panel-body">
			<table class="table table-bordered" style="width:100%; padding:10px;" id="datatabel">
				<thead>
					<tr>
						<th >No</th>
						<th >Nilai</th>
						<th >Jumlah Benar</th>
						<th>Hasil</th>
						<th >Tanggal Mulai</th>
						<th >Tanggal Selesai</th>
						<th >Opsi</th>
					
					</tr>
				</thead>
			
				<?php 
				  if (!empty($data)) { 

                $i=1;
                	foreach($data as $d) {
                    	$keterangan = ($d['nilai'] >= 66) ? 'LULUS' : 'BELUM LULUS';
                    ?>
					<tr> 
					<td><?= $i ?></td>
					<td><?= $d['nilai'];?> </td>
					<td> <?= $d['jml_benar'];?></td>
					<td><?=$keterangan;?></td>
					<td> <?= $d['tgl_mulai'];?></td>
					<td> <?= $d['tgl_selesai'];?></td>
					<td>
					<a href="<?= base_url('ujian/ikut_ujian_hasil/'.$d['id'].'/'.$d['id_tes']); ?>"  class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-remove" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Lihat Hasil</a>
					 </td>
					</tr>
					
				<?php $i++; }
				} else { ?>
					<tr>
					<td colspan="6">Belum ada data :(</td>
					</tr>
				<?php } ?>
				<tbody>
				</tbody>
			</table>

		</div>
		<!-- <a href="<?=base_url('ujian/ikuti_ujian/'.$id_.'');?>"  class="btn btn-default"> &#8592; Kembali</a> -->

</div>
</div>

<script type="text/javascript">
	function goback(){
		window.history.back();
		alert('test');
	}
</script>
