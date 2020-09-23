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
<table class="table table-bordered table-striped table-hovered" >
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
	</thead>
	<tbody>
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
				<td>
					<?= $rows->nik; ?>
				</td>
				<td>
					<div class="password-input">
						<input type="password" data-id="<?= $this->encryption->encrypt($rows->user_id); ?>" class=" password-reset">
						<i class="fas fa-eye mata-kau" data-id="<?= $this->encryption->encrypt($rows->user_id); ?>"></i>
						</div>
				</td>
				<td class="frist">
					<?php

					if ($rows->deleted == 1) {
						 echo $data_link ='<a href="#" onclick="return m_siswa_ak('.$rows->id.',1);" class="btn btn-success btn-sm mr-2"><i class="glyphicon glyphicon-user" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Aktifkan</a>';
					} else {
						 echo $data_link = '<a href="#" onclick="return m_siswa_ak('.$rows->id.',0);" class="btn btn-danger btn-sm mr-2"><i class="glyphicon glyphicon-random" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;NonAktifkan</a>';
					}
					;?>
				</td>	
			</tr>
		<?php $x++;endforeach ?>
	<?php } ?>
	</tbody>
</table>
<script src="<?=base_url();?>assets/js/jquery/jquery-3.3.1.min.js"></script>
<script src="<?= base_url('assets/plugin/datatables/jquery.dataTables.min.js') ?>"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
<script>
	$(document).ready(function() {
		$('table').DataTable({
			responsive: true,
			paging: false,
			info: false
		});
	});

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



