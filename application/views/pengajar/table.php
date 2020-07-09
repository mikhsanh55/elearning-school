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

			<th>Nama Guru</th>

			<th>Username</th>

			<th>Password</th>

			<th>NIS</th>

			<!-- <th>Mata Pelajaran</th> -->

			<th>Opsi</th>

		</tr>

		<?php $x = $paginate['counts']['from_num']; foreach ($paginate['data'] as $rows):
	
			$get = $this->m_admin->get_by(array('level'=>'guru','kon_id'=>$rows->id));
			$instansi = $this->m_instansi->get_by(['id'=>$rows->instansi]);
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
				<td>
						<div class="password-input">
						<input type="password" value="<?= $rows->password; ?>" data-id="<?= $this->encryption->encrypt($rows->user_id); ?>" class="form-control password-reset">
						<i class="fas fa-eye mata-kau" data-id="<?= $this->encryption->encrypt($rows->user_id); ?>"></i>
						</div>
					
					
				</td>

				<td><?= ($rows->nidn != '' || !empty($rows->nidn) ) ? $rows->nidn : $rows->nrp ;?></td>
				<!-- <td class="text-center">
					<?= $rows->nama_mapel == '' ? 'Belum Ada' : $rows->nama_mapel; ?>
				</td> -->
				<td class="frist">

					<?php

					if($this->session->userdata('admin_level') == "admin" || $this->session->userdata('admin_level') == "instansi" || $this->session->userdata('admin_level') == "admin_instansi"){
						// <a href="#" onclick="return m_guru_matkul('.$rows->id.');" class="btn btn-primary btn-sm mr-2"><i class="glyphicon glyphicon-th-list" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Materi</a>
						echo '<div class="btn-group">

						<button class="btn btn-sm btn-primary" data-id="'.$rows->id.'" onclick="displayMapel(this)">Mata Pelajaran</button>
						</div>

						';



						// if (empty($get)) {

						// 	 echo '<a href="#" onclick="return m_guru_u('.$rows->id.');" class="btn btn-success btn-sm mr-2"><i class="glyphicon glyphicon-user" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Buatkan Password</a>';

						// } else {

						// 	echo '<a href="#" onclick="return m_guru_ur('.$rows->id.');" class="btn btn-warning btn-sm mr-2"><i class="glyphicon glyphicon-random" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Reset Password</a>';

						// }

					}else{

						echo '<a href="#" onclick="return m_guru_detail('.$rows->id.');" class="btn btn-primary btn-sm mr-2"><i class="glyphicon glyphicon-th-list" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Lihat Profil</a>';

					}



				

					;?>

				</td>	

			</tr>

		<?php $x++;endforeach ?>

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
		if(e.which == 13) {
			if($(this).val() < 6) {
				alert('Password minimal 6 karakter!')
				return false
			}
			password = $(this).val()
			$.ajax({
				type: 'post',
				url: "<?= base_url('trainer/reset_password') ?>",
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


