
<table id="custumtb">
	<thead>
		<tr>
			<th>Indikator</th>
			<th>5</th>
			<th>4</th>
			<th>3</th>
			<th>2</th>
			<th>1</th>
		</tr>
	</thead>
<tbody>
<?php  $i=0; foreach ($labels as $label) {?>
		<tr>
			<td><?=$label;?></td>
				<td><?= $presentase[$i]['A'].'%';?></td>
				<td><?= $presentase[$i]['B'].'%';?></td>
				<td><?= $presentase[$i]['C'].'%';?></td>
				<td><?= $presentase[$i]['D'].'%';?></td>
				<td><?= $presentase[$i]['E'].'%';?></td>
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


