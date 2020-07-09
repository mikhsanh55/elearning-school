<style>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
<table id="custumtb">
	<thead>
		<tr>
			<th class="frist">No</th>
			<th><?=$this->transTheme->siswa;?></th>
		</tr>
		<?php if(count($paginate['data']) > 0) { ?>
		<?php 
			$i= $page_start; foreach ($paginate['data'] as $rows):
			$check_kelas = $this->m_detail_kelas->count_by(['id_peserta'=>$rows->id,'id_kelas',$id_kelas]);
		?>
			<tr>
				<td align="center" class="frist"><?=$i;?></td>
				<td><?=$rows->nama_siswa;?></td>
			</tr>
		<?php $i++;endforeach ?>
		<?php } else { ?>
			<tr>
				<td class="text-center" colspan="2">Data Kosong</td>
			</tr>
		<?php } ?>
	</thead>
<tbody>
</tbody>
</table>
<!-- <script type="text/javascript">
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();   
	});
	$('.deleted').click(function(){
		var y = confirm('Apakah anda yakin ingin mengapus data ini ?');
		if (y == true) {

		}else{
			return false
		}
	})
	
</script> -->
<script>
$('.aktivasi').change(function(){
		var aktivasi = $(this);
		if($(this).is(":checked")){
			var aktif = 1;
		}
		else if($(this).is(":not(:checked)")){
			var aktif = 0;
		}
		
		$.ajax({
			type:'post',
			url : '<?=base_url('kelas/update_kelas');?>',
			data : {
				aktif : aktif,
				id_peserta  : $(this).data('peserta'),
				id_kelas : '<?=$id_kelas;?>'
			},
			success:function(response){

			}
		})
	})
</script>
