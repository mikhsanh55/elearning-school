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

<table class="table table-bordered table-striped table-hovered" id="table-guru" >

	<thead>

		<tr>
			<th class="frist"><input type="checkbox" name="checkall" id="checkall"></th>
			<th class="frist">No</th>
			<th>Nama Guru</th>
			<th>Username</th>
			<th>Password</th>
			<th>NUPTK / NIP</th>
			<th>Opsi</th>

		</tr>
	</thead>
	<tbody>

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
						<input type="password" data-id="<?= $this->encryption->encrypt($rows->user_id); ?>" class="password-reset">
						<i class="fas fa-eye mata-kau" data-id="<?= $this->encryption->encrypt($rows->user_id); ?>"></i>
						</div>
					
					
				</td>

				<td><?= ($rows->nidn != '' || !empty($rows->nidn) ) ? $rows->nidn : $rows->nrp ;?></td>
				<td class="frist">
					<?php
					if($this->session->userdata('admin_level') == "admin" || $this->session->userdata('admin_level') == "instansi" || $this->session->userdata('admin_level') == "admin_instansi") {
						echo '<div class="btn-group">

						<button class="btn btn-sm btn-primary" data-id="'.$rows->id.'" onclick="displayMapel(this)">Mata Pelajaran</button>
						</div>

						';
					} else {
						echo '<a href="#" onclick="return m_guru_detail('.$rows->id.');" class="btn btn-primary btn-sm mr-2"><i class="glyphicon glyphicon-th-list" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Lihat Profil</a>';
					}?>
				</td>	

			</tr>

		<?php $x++;endforeach ?>

	</tbody>
</table>
<script src="<?=base_url();?>assets/js/jquery/jquery-3.3.1.min.js"></script>
<script src="<?= base_url('assets/plugin/datatables/jquery.dataTables.min.js') ?>"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
<script>
	$(document).ready(function() {
		$('#table-guru').DataTable({
			responsive: true,
			paging: false,
			info: false
		});
	});

	var encrypt_id, password;

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
	});

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
			});
		}
	});
</script>


