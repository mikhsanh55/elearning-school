<<<<<<< HEAD

<table id="custumtb" class="data-table">
	<thead>
		<tr>
			<th>Indikator</th>
			<th>MIN</th>
			<th>MAX</th>
			<th>SIMPANGAN BAKU</th>
		</tr>
	</thead>
<tbody>
<?php  $i=0; foreach ($labels as $label) {?>
		<tr>
			<td><?=$label;?></td>
			<td><?= $datas[$i]['min'];?></td>
			<td><?= $datas[$i]['max'];?></td>
			<td><?= $deviasi[$i];?></td>
		</tr>
	<?php $i++; } ?>	
</tbody>
</table>

<script type="text/javascript">
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();   
	});

	$(document).on('click','.izinkan',function(){

		var y = confirm('Apakah anda yakin akan mengizinkan ujian ?');

		if (y == true) {

			$.ajax({
				type:'post',
				url : '<?=base_url('penilaian/izinkan');?>',
				dataType : 'json',
				data : {
					id   : $(this).data('id'),
					izin : $(this).data('izin'),
					soal : $(this).data('soal'),
				},
				success:function(response){
					alert(response.message);
					pageLoad(1,'penilaian/page_load');
				}
			})


		}else{
			return false;
		}

		
	})

</script>


=======

<table id="custumtb">
	<thead>
		<tr>
			<th>Indikator</th>
			<th>MIN</th>
			<th>MAX</th>
			<th>SIMPANGAN BAKU</th>
		</tr>
	</thead>
<tbody>
<?php  $i=0; foreach ($labels as $label) {?>
		<tr>
			<td><?=$label;?></td>
			<td><?= $datas[$i]['min'];?></td>
			<td><?= $datas[$i]['max'];?></td>
			<td><?= $deviasi[$i];?></td>
		</tr>
	<?php $i++; } ?>	
</tbody>
</table>

<script type="text/javascript">
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();   
	});

	$(document).on('click','.izinkan',function(){

		var y = confirm('Apakah anda yakin akan mengizinkan ujian ?');

		if (y == true) {

			$.ajax({
				type:'post',
				url : '<?=base_url('penilaian/izinkan');?>',
				dataType : 'json',
				data : {
					id   : $(this).data('id'),
					izin : $(this).data('izin'),
					soal : $(this).data('soal'),
				},
				success:function(response){
					alert(response.message);
					pageLoad(1,'penilaian/page_load');
				}
			})


		}else{
			return false;
		}

		
	})

</script>


>>>>>>> first push
