
					</aside>
				</div>
				<!--/.page-sidebar-->
			
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
                <script>
                    function verify(el) {
                        let conf = confirm('Apakah anda yakin ingin memverifikasi sub modul ini?');
                        if(conf)
                			$.ajax({
                				type:"POST",
                				url:"<?= base_url('Materi/verify') ?>",
                				data:{imateri:el.getAttribute('data-materi')},
                				dataType:"JSON",
                				success:function(res) {
                				    alert('Sub Modul Berhasil diverifikasi!');
                					window.location.reload();
                				},
                				error:function(er) {
                					window.location.reload();
                				}
                			});
                    }
                </script>
				<div class="col-md-9 page-content">


					<div class="inner-box">
						
						<div id="accordion" class="panel-group">

									<?php if($data['sum_request_add'] != 0 || $data['sum_request_edit'] != 0 || $data['sum_request_delete'] != 0) { ?>
									
									<?php if($data['sum_request_add'] > 0) : ?>
									    <label class="mt-4 mb-4">Tambah Sub Modul</label>
									    <table class="table table-bordered table-striped mb-4" id="table-materi">
            								<thead>
            									<tr>
            										<th></th>
            										<th  class="text-left">Nama</th>
            										<th class="text-left">Kategori</th>
            										<th></th>
            									</tr>
            								</thead>
            								<tbody>        
            								<?php $no = 0;foreach($data['request_add'] as $materi) : ?>
            								    <tr>
            								        <td class="text-center align-middle" width="30"><i class="fas fa-book"></i></td>
        											<td class="materi-link text-secondary align-middle"><?= $materi->title; ?></a></td>
        											<td class="materi-link text-secondary align-middle"><?= $materi->mapel; ?></a></td>
        											<td class="text-center">
            											<?php if($this->session->userdata('admin_level') == 'admin') : ?>
            											<?php if($materi->pdf == 0) { ?>
            											    <a href="<?= base_url('Materi/read') . '/' . md5($materi->id); ?>" class="m-2 btn btn-primary btn-sm">
            													<i class="fas fa-eye mr-2" title="Mulai Baca"></i>Lihat
            												</a>
            											<?php } else { ?>
                											<a href="<?= base_url('Materi/read_pdf') . '/' . md5($materi->id); ?>" class="m-2 btn btn-sm btn-primary">
            													<i class="fas fa-eye mr-2" title="Mulai Baca"></i>PDF
            												</a>
            											<?php } ?>
    													<?php if($materi->pdf == 0) { ?>
            												<a href="<?= base_url('Materi/edit') . '/' . md5($materi->id); ?>" class="m-2 btn btn-primary btn-sm edit-materi" data-materi="<?= md5($materi->id); ?>">
            												<i class="fas fa-pen mr-2" title="Edit materi"></i>Edit</a>
            												<a href="#" class="btn btn-success btn-sm m-2 verify-materi" data-materi="<?= md5($materi->id); ?>" onclick="verify(this)">
        												    <i class="fas fa-lock-open mr-2" title="Verifikasi materi"></i>Verifikasi</a>
            												<a onclick="return confirm('Anda akan menghapus sub modul ini secara permanen?')" href="#" data-href="<?= base_url('Materi/delete_using_php') . '/' . md5($materi->id); ?>" class="m-2 hapus-materi btn btn-danger btn-sm" data-materi="<?= md5($materi->id); ?>" data-pdf='0'>
            												<i class="fas fa-trash mr-2" title="Hapus materi"></i>Hapus</a>
        												<?php } else { ?>
        												<a href="<?= base_url('Materi/edit_pdf') . '/' . md5($materi->id); ?>" class="m-2 btn btn-primary btn-sm edit-materi" data-materi="<?= md5($materi->id); ?>">
            												<i class="fas fa-pen mr-2" title="Edit materi"></i>Edit</a>
            												<a href="#" class="btn btn-success btn-sm m-2 verify-materi" data-materi="<?= md5($materi->id); ?>" onclick="verify(this)">
        												    <i class="fas fa-lock-open mr-2" title="Verifikasi materi"></i>Verifikasi</a>
        													<a onclick="return confirm('Anda akan menghapus sub modul ini secara permanen?')" href="#" data-href="<?= base_url('Materi/delete_using_php') . '/' . md5($materi->id) . '/1'; ?>" class="m-2 hapus-materi btn btn-danger btn-sm" data-materi="<?= md5($materi->id); ?>" data-pdf='1'>
        													<i class="fas fa-trash mr-2" title="Hapus materi"></i>Hapus</a>
        												<?php } ?>
        												<?php endif; ?>
    												</td>
            								    </tr>
            								<?php endforeach; ?>
            								</tbody>
            							</table>
									<?php endif; ?>
									
									<!-- Edit Sub MOdul -->
									<?php if($data['sum_request_edit'] > 0) : ?>
									    <label class="mt-4 mb-4">Edit Sub Modul</label>
									    <table class="table table-bordered table-striped mb-4" id="table-materi">
            								<thead>
            									<tr>
            										<th></th>
            										<th  class="text-left">Nama</th>
            										<th class="text-left">Kategori</th>
            										<th></th>
            									</tr>
            								</thead>
            								<tbody>        
            								<?php $no = 0;foreach($data['request_edit'] as $materi) : ?>
            								    <tr>
            								        <td class="text-center align-middle" width="30"><i class="fas fa-book"></i></td>
        											<td class="materi-link text-secondary align-middle"><?= $materi->title; ?></a></td>
        											<td class="materi-link text-secondary align-middle"><?= $materi->mapel; ?></a></td>
        											<td class="text-center">
            											<?php if($this->session->userdata('admin_level') == 'admin') : ?>
            											<?php if($materi->pdf == 0) { ?>
            											    <a href="<?= base_url('Materi/read') . '/' . md5($materi->id); ?>" class="m-2 btn btn-primary btn-sm">
            													<i class="fas fa-eye mr-2" title="Mulai Baca"></i>Lihat
            												</a>
            											<?php } else { ?>
                											<a href="<?= base_url('Materi/read_pdf') . '/' . md5($materi->id); ?>" class="m-2 btn btn-sm btn-primary">
            													<i class="fas fa-eye mr-2" title="Mulai Baca"></i>PDF
            												</a>
            											<?php } ?>
    													<?php if($materi->pdf == 0) { ?>
            												<a href="<?= base_url('Materi/edit') . '/' . md5($materi->id); ?>" class="m-2 btn btn-primary btn-sm edit-materi" data-materi="<?= md5($materi->id); ?>">
            												<i class="fas fa-pen mr-2" title="Edit materi"></i>Edit</a>
            												<a href="#" class="btn btn-success btn-sm m-2 verify-materi" data-materi="<?= md5($materi->id); ?>" onclick="verify(this)">
        												    <i class="fas fa-lock-open mr-2" title="Verifikasi materi"></i>Verifikasi</a>
            												<a onclick="return confirm('Anda akan menghapus sub modul ini secara permanen?')" href="#" data-href="<?= base_url('Materi/delete_using_php') . '/' . md5($materi->id); ?>" class="m-2 hapus-materi btn btn-danger btn-sm" data-materi="<?= md5($materi->id); ?>" data-pdf='0'>
            												<i class="fas fa-trash mr-2" title="Hapus materi"></i>Hapus</a>
        												<?php } else { ?>
        												<a href="<?= base_url('Materi/edit_pdf') . '/' . md5($materi->id); ?>" class="m-2 btn btn-primary btn-sm edit-materi" data-materi="<?= md5($materi->id); ?>">
            												<i class="fas fa-pen mr-2" title="Edit materi"></i>Edit</a>
            												<a href="#" class="btn btn-success btn-sm m-2 verify-materi" data-materi="<?= md5($materi->id); ?>" onclick="verify(this)">
        												    <i class="fas fa-lock-open mr-2" title="Verifikasi materi"></i>Verifikasi</a>
        													<a onclick="return confirm('Anda akan menghapus sub modul ini secara permanen?')" href="#" data-href="<?= base_url('Materi/delete_using_php') . '/' . md5($materi->id) . '/1'; ?>" class="m-2 hapus-materi btn btn-danger btn-sm" data-materi="<?= md5($materi->id); ?>" data-pdf='1'>
        													<i class="fas fa-trash mr-2" title="Hapus materi"></i>Hapus</a>
        												<?php } ?>
        												<?php endif; ?>
    												</td>
            								    </tr>
            								<?php endforeach; ?>
            								</tbody>
            							</table>
									<?php endif; ?>
									
									<!-- Request Delete Sub Modul -->
									<?php if($data['sum_request_delete'] > 0) : ?>
									    <label class="mt-4 mb-4">Hapus Sub Modul</label>
									    <table class="table table-bordered table-striped mb-4" id="table-materi">
            								<thead>
            									<tr>
            										<th></th>
            										<th  class="text-left">Nama</th>
            										<th class="text-left">Kategori</th>
            										<th></th>
            									</tr>
            								</thead>
            								<tbody>        
            								<?php $no = 0;foreach($data['request_delete'] as $materi) : ?>
            								    <tr>
            								        <td class="text-center align-middle" width="30"><i class="fas fa-book"></i></td>
        											<td class="materi-link text-secondary align-middle"><?= $materi->title; ?></a></td>
        											<td class="materi-link text-secondary align-middle"><?= $materi->mapel; ?></a></td>
        											<td class="text-center">
            											<?php if($this->session->userdata('admin_level') == 'admin') : ?>
            											<?php if($materi->pdf == 0) { ?>
            											    <a href="<?= base_url('Materi/read') . '/' . md5($materi->id); ?>" class="m-2 btn btn-primary btn-sm">
            													<i class="fas fa-eye mr-2" title="Mulai Baca"></i>Lihat
            												</a>
            											<?php } else { ?>
                											<a href="<?= base_url('Materi/read_pdf') . '/' . md5($materi->id); ?>" class="m-2 btn btn-sm btn-primary">
            													<i class="fas fa-eye mr-2" title="Mulai Baca"></i>PDF
            												</a>
            											<?php } ?>
        												<?php if($materi->pdf == 0) { ?>
            												<a href="<?= base_url('Materi/edit') . '/' . md5($materi->id); ?>" class="m-2 btn btn-primary btn-sm edit-materi" data-materi="<?= md5($materi->id); ?>">
            												<i class="fas fa-pen mr-2" title="Edit materi"></i>Edit</a>
            												<a href="#" class="btn btn-success btn-sm m-2 verify-materi" data-materi="<?= md5($materi->id); ?>" onclick="verify(this)">
        												    <i class="fas fa-lock-open mr-2" title="Verifikasi materi"></i>Verifikasi</a>
            												<a onclick="return confirm('Anda akan menghapus sub modul ini secara permanen?')" href="#" data-href="<?= base_url('Materi/delete_using_php') . '/' . md5($materi->id); ?>" class="m-2 hapus-materi btn btn-danger btn-sm" data-materi="<?= md5($materi->id); ?>" data-pdf='0'>
            												<i class="fas fa-trash mr-2" title="Hapus materi"></i>Hapus</a>
        												<?php } else { ?>
        												<a href="<?= base_url('Materi/edit_pdf') . '/' . md5($materi->id); ?>" class="m-2 btn btn-primary btn-sm edit-materi" data-materi="<?= md5($materi->id); ?>">
            												<i class="fas fa-pen mr-2" title="Edit materi"></i>Edit</a>
            												<a href="#" class="btn btn-success btn-sm m-2 verify-materi" data-materi="<?= md5($materi->id); ?>" onclick="verify(this)">
        												    <i class="fas fa-lock-open mr-2" title="Verifikasi materi"></i>Verifikasi</a>
        													<a onclick="return confirm('Anda akan menghapus sub modul ini secara permanen?')" href="#" data-href="<?= base_url('Materi/delete_using_php') . '/' . md5($materi->id) . '/1'; ?>" class="m-2 hapus-materi btn btn-danger btn-sm" data-materi="<?= md5($materi->id); ?>" data-pdf='1'>
        													<i class="fas fa-trash mr-2" title="Hapus materi"></i>Hapus</a>
        												<?php } ?>
        												<?php endif; ?>
    												</td>
            								    </tr>
            								<?php endforeach; ?>
            								</tbody>
            							</table>
									<?php endif; ?>
									<?php } else { ?>
									    <table class="table table bordered table-striped">
									        <tr>
									            <td colspan="5" class="text-center">Semua Sub Sub Modul sudah terverifikasi :)</td>
									        </tr>
									    </table>
									<?php } ?>
						</div>
					</div>
					<!--/.row-box End-->

				</div>
			</div>
			<!--/.page-content-->
		</div>
		<!--/.row-->
	</div>
	<!--/.container-->
</div>
<!-- /.main-container -->
<div id="tampilkan_modal"></div>
<footer class="main-footer">
	<div class="footer-content">
		<div class="container">
			<div class="row">


				<div style="clear: both"></div>

				<div class="col-xl-12">

					<div class="copy-info text-center">
						<?=$this->footer;?>
					</div>

				</div>

			</div>
		</div>
	</div>
</footer>
<!--/.footer-->



<!-- Modal -->
<div class="modal fade" id="createMapel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <label>Nama Mata Pelajaran</label>
        <input type="text" name="mapel" class="form-control" placeholder="marketing, pemasaran..." required />
      </div>
      <div class="modal-footer">
      	<button type="submit" class="btn btn-aliman" id="buat-kategori">Buat <i class="fas fa-circle-notch loading m-2"></i></button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
        
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('.loading').hide();
		$('#buat-kategori').click(function(e) {
			e.preventDefault();
			$.ajax({
				type:"POST",
				beforeSend:function() {
					$('.loading').show();
				},
				url:"<?= base_url('Materi/insert_mapel'); ?>",
				data:{nama:$('input[name=mapel]').val()},
				dataType:"JSON",
				success:function(res) {
					console.log(res);
					window.location.reload();
				},
				complete:function() {
					$('.loading').hide();
				}
			});
		});		

		$('.hapus-materi').click(function(e) {
			e.preventDefault();
			var url = this.getAttribute('data-pdf') == 1 ? "<?= base_url('Materi/delete_using_php') ?>" + '/' + $(this).data('materi') + '/1' : "<?= base_url('Materi/delete_using_php') ?>" + '/' + $(this).data('materi'), materi = $(this).data('materi');
			let conf = confirm('Anda yakin?');
			
			if(conf)
				$.ajax({
					type:"POST",
					url:url,
					data:{imateri:materi},
					dataType:"JSON",
					success:function(res) {
					    alert('Sub Modul berhasil dihapus');
						window.location.reload();
					},
					error:function(er) {
				// 		window.location.reload();
				        alert('Something went wrong');
						console.log(er);
						return false;
					}
				});
		});
        
// 		$('.verify-materi').click(function(e) {
// 			e.preventDefault();
// 			let conf = confirm('Apakah anda yakin ingin memverifikasi sub modul ini?');
			

// 			if(conf) 
// 				$.ajax({
// 					type:"POST",
// 					url:"<?= base_url('Materi/verify') ?>",
// 					data:{imateri:$(this).data('materi')},
// 					dataType:"JSON",
// 					success:function(res) {
// 					    alert('Sub Modul Berhasil diverifikasi!');
// 						window.location.href = "<?= base_url('dtest/m_mapel'); ?>";
// 					},
// 					error:function(er) {
// 						window.location.href = "<?= base_url('dtest/m_mapel'); ?>";
// 					}
// 				})
// 		})
	});
</script>
