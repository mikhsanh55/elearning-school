
<table id="custumtb">
	<thead>
		<tr>
			<th>Dosen</th>
			<th>Mata Kuliah</th>
			<th class="frist">Responden</th>
			<?php foreach ($labels as $key => $col) { ?>
				<th><?=$col;?></th>
			<?php } ;?>
			<th>Total</th>
			
		</tr>
	</thead>
<tbody>
<?php $sub_total = []; for ($i=1; $i <= $responden; $i++){ 

?>
	<tr>
		<td><?=$nama_guru[$i];?></td>
		<td><?=$nama_mapel[$i];?></td>
		<td align="center" class="frist"><?=$i;?></td>	
		<?php $total=0; $x=1; foreach ($jawaban[$i] as $index => $rows) { 
			$total += $rows['nilai'];
			$sub_total[$i][$index] = $rows['nilai'];
				
		?>
	
			<td><?=$rows['nilai'];?></td>
		<?php $x++;} ;?>
		<td><?=$total;?></td>
	</tr>
<?php }   ?>
	
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
					// alert(response.message);
					pageLoad(1,'penilaian/page_load');
				}
			})


		}else{
			return false;
		}

		
	})

</script>


