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
			<th><input type="checkbox" name="checkall" id="checkall"></th>
			<th class="frist">No</th>
			<th>Nama</th>
			<th>Username</th>
			<th>
				NIS
			</th>
			<!-- <th>Kelas</th> -->
			<th>Jenis Kelamin</th>
			<th>Password</th>
			<th>Opsi</th>
		</tr>
		<?php if(count($paginate['data']) > 0) { ?>
		<?php $x= 1; foreach ($paginate['data'] as $rows):
			$get = $this->m_admin->get_by(array('level'=>'siswa','kon_id'=>$rows->id));
			$length_pass = strlen($rows->password);
			$pass = '';
			for($i = 0;$i < $length_pass;$i++) {
				$pass .= '*';
			}
		?>
			<tr>
				<td><input type="checkbox" name="checklist[]" class="checklist" value="<?=$rows->id;?>"></td>
				<td align="center" class="frist"><?=$x;?></td>
				<td><?=$rows->nama;?></td>
				<td><?=$rows->username;?></td>
				<td><?=$rows->nrp;?></td>
				<!-- <td><?=$rows->nama_kelas;?></td> -->
				<td>
					<?= $rows->nik; ?>
				</td>
				<td>
					<div class="password-input">
						<input type="password" value="<?= $rows->password; ?>" data-id="<?= $this->encryption->encrypt($rows->user_id); ?>" class="form-control password-reset">
						<i class="fas fa-eye mata-kau" data-id="<?= $this->encryption->encrypt($rows->user_id); ?>"></i>
						</div>
				</td>
				<td class="frist">
					<?php

					// if (empty($get)) {
					// 	echo '<a href="#" onclick="return m_siswa_u('.$rows->id.');" class="btn btn-success btn-sm mr-2"><i class="glyphicon glyphicon-user" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Buatkan Password</a>';
					// } else {
					// 	echo '<a href="#" onclick="return m_siswa_ur('.$rows->id.');" class="btn btn-warning btn-sm mr-2"><i class="glyphicon glyphicon-random" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Reset Password</a>';
					// }

					if ($rows->deleted == 1) {
						 echo $data_link ='<a href="#" onclick="return m_siswa_ak('.$rows->id.',1);" class="btn btn-success btn-sm mr-2"><i class="glyphicon glyphicon-user" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Aktifkan</a>';
					} else {
						 echo $data_link = '<a href="#" onclick="return m_siswa_ak('.$rows->id.',0);" class="btn btn-danger btn-sm mr-2"><i class="glyphicon glyphicon-random" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;NonAktifkan</a>';
					}
					;?>
				</td>	
			</tr>
		<?php $x++;endforeach ?>
		<?php } else { ?>
			<tr>
				<td colspan="9" class="text-center">Data Kosong</td>
			</tr>
		<?php } ?>
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

