<div class="col-md-9 page-content">
	<div class="inner-box">
		<div id="accordion" class="panel-group">
			<h2 class="p-title mt-2	">Profil Akun</h2>
			<div class="row" id="profile-wrapper">
				<div class="col-sm-12 col-md-6 col-lg-6 mt-2">
				<!-- 	<?php if(!is_null($data->photo) && file_exists($data->photo)) { ?>
						<img src="<?= $data->photo; ?>" alt="Foto" class="img-thumbnail">
					<?php } else { ?> -->
						<img src="<?= base_url('assets/img/avatar.jpeg') ?>" alt="Foto" class="img-thumbnail">
<!-- 					<?php } ?> -->
				</div>
				<div class="col-sm-12 col-md-6 col-lg-6 mt-4">
					<table class="table">
						
							<tr>
								<th class="text-secondary text-uppercase">Nama</th>
								<td class="text-uppercase font-weight-bold"><?= $data->nama; ?></td>
								<td class="text-right text-primary font-weight-bold">
									<i class="fas fa-check"></i>
								</td>
							</tr>
							<tr>
								<th class="text-secondary text-uppercase">NUPTK/NIP</th>
								<td class="text-uppercase font-weight-bold"><?= $data->nrp . ' / ' . $data->nidn; ?></td>
								<td class="text-right text-primary font-weight-bold">
									<i class="fas fa-check"></i>
								</td>
							</tr>
							<tr>
								<th class="text-secondary text-uppercase">Username</th>
								<td class="text-lowercase font-weight-bold"><?= $data->username; ?></td>
								<td class="text-right text-primary font-weight-bold">
									<i class="fas fa-check"></i>
								</td>
							</tr>
							<tr>
								<th class="text-secondary text-uppercase">Email</th>
								<td class="font-weight-bold"><?= $data->email; ?></td>
								<td class="text-right text-primary font-weight-bold">
									<i class="fas fa-check"></i>
								</td>
							</tr>
							<tr>
								<th class="text-secondary text-uppercase">Telpon</th>
								<td class="text-uppercase font-weight-bold"><?= $data->no_telpon; ?></td>
								<td class="text-right text-primary font-weight-bold">
									<i class="fas fa-check"></i>
								</td>
							</tr>
							<tr class="m-3">
								<th class="text-secondary text-uppercase">
									<span class="badge badge-pill badge-light d-block p-1"></span>
								</th>
								<td class="text-uppercase">
									<span class="badge badge-pill badge-light d-block p-1"></span>
								</td>
								<td class="text-right text-primary font-weight-bold">
									<span class="badge badge-pill badge-light d-block p-1"></span>
								</td>
							</tr>

							<tr>
								<th class="text-secondary text-uppercase">Mata Pelajaran</th>
								<td class="font-weight-bold">
									<?php $mapel = $this->m_detail_mapel->get_all(['dmapel.id_guru' => $id]);
									if(count($mapel) > 0) {
										foreach($mapel as $m) :
									 ?>
									<span class="badge badge-pill badge-primary text-capitalize"><?=$m->nama_mapel ?></span>
								<?php endforeach; } else { ?>
									<span class="badge badge-pill badge-primary w-100">-</span>
								<?php } ?>
								</td>
								<td class="text-right text-primary font-weight-bold align-items-center">
									<i class="fas fa-check"></i>
								</td>
							</tr>
					</table>
					
				</div>
			</div>
		</div>
	</div>
</div>
</div>