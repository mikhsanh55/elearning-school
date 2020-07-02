<style>
	.password-input {
		position: relative;
	}
	.password-input .fas:hover {
		color:blue;
	}
	.password-input .fas {
		transition: .3s;
		cursor: pointer;
		position: absolute;
		right: 0;
		top:37%;
		margin-right: 10px;
	}
</style>
<table id="custumtb">
	<thead>
		<tr>
			<th class="frist"><input type="checkbox" name="checkall" id="checkall"></th>
			<th class="frist">No</th>
			<th>Nama</th>
			<th>Username</th>
			<th>No Telpon</th>
			<th>Password</th>
			<th class="frist">Opsi</th>
		</tr>
		<?php $i= $page_start; foreach ($paginate['data'] as $rows):
			$admin = $this->m_admin->count_by(array('level'=>'admin_instansi','kon_id'=>$rows->id));
		?>
			<tr>
				<td><input type="checkbox" name="checklist[]" class="checklist" data-id= "<?=sha1($rows->id);?>" value="<?=$rows->id;?>"></td>
				<td align="center" class="frist"><?=$i;?></td>
				<td><?=$rows->nama;?></td>
				<td><?=$rows->username;?></td>
				<td><?= $rows->user_id; ?></td>
				<td>
					<div class="password-input">
						<input type="password" value="<?= $rows->password; ?>" data-id="<?= $this->encryption->encrypt($rows->user_id); ?>" class="form-control password-reset">
						<i class="fas fa-eye mata-kau" data-id="<?= $this->encryption->encrypt($rows->user_id); ?>"></i>
						</div>
				</td>
				<td class="frist text-center">
					<?php

					// if ($admin == 0) {
					// 	echo '<a href="javascript:void(0);" class="btn btn-success buat-pass btn-sm mr-2" data-nama="'.$rows->nama.'" data-id="'.$rows->id.'"><i class="glyphicon glyphicon-user" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Buatkan Password</a>';
					// } else {
					// 	echo '<a href="javascript:void(0);" class="btn btn-warning reset-pass btn-sm mr-2" data-nama="'.$rows->nama.'" data-id="'.$rows->id.'"><i class="glyphicon glyphicon-random" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Reset Password</a>';
					// }

					if ($rows->deleted == 1) {
						 echo $data_link ='<a href="javascript:void(0);" class="btn btn-success aktif-non-akun btn-sm mr-2" data-nama="'.$rows->nama.'" data-id="'.$rows->id.'" data-status="'.$rows->deleted.'"><i class="glyphicon glyphicon-user" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Aktifkan</a>';
					} else {
						 echo $data_link = '<a href="javascript:void(0);" class="btn btn-danger aktif-non-akun btn-sm mr-2" data-nama="'.$rows->nama.'" data-id="'.$rows->id.'" data-status="'.$rows->deleted.'"><i class="glyphicon glyphicon-random" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;NonAktifkan</a>';
					}
					;?>
				</td>	
			</tr>
		<?php $i++;endforeach ?>
	</thead>
<tbody>
</tbody>
</table>
<script>
	var encrypt_id, password
	$('.mata-kau').on('click', function() {
		encrypt_id = $(this).data('id')
		console.log(encrypt_id)
		if($(this).prev().prop('type') == 'text') {
			$(this).prev().prop('type', 'password')	
			$(this).removeClass('fa-eye-slash')
			$(this).addClass('fa-eye')
		}
		else {
			$(this).prev().prop('type', 'text')
			$(this).addClass('fa-eye-slash')
			$(this).removeClass('fa-eye')
		}
		
	})

	$('.password-reset').on('keypress', function(e) {
		encrypt_id = $(this).data('id')
		console.log(encrypt_id)
		if(e.which == 13) {
			if($(this).val() < 6) {
				alert('Password minimal 6 karakter!')
				return false
			}
			password = $(this).val()
			$.ajax({
				type: 'post',
				url: "<?= base_url('pengusaha/reset_password') ?>",
				data: {
					encrypt_id,
					password
				},
				dataType: 'json',
				success:function(res) {
					if(res.status) {
						window.location.reload()
					}
					else {
						console.error(res)
						return false
					}
				},
				error: function(e) {
					console.error(e.responseText)
					return false
				}
			})
		}
	})
</script>

