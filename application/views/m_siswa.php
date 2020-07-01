<div class="row col-md-12 ini_bodi">
	<div class="panel panel-info">

		<div class="panel-heading">

			<div class="tombol-kanan">
				<h2><strong>DATA SISWA</strong></h2>
		
				<a class="btn btn-success btn-sm tombol-kanan" href="#" onclick="return m_siswa_e(0);"><i class="glyphicon glyphicon-plus"></i> &nbsp;&nbsp;Tambah</a>
				<a class="btn btn-warning btn-sm tombol-kanan" href="<?php echo base_url(); ?>upload/format_import_siswa.xlsx"><i class="glyphicon glyphicon-download"></i> &nbsp;&nbsp;Download Format Import</a>
				<a class="btn btn-info btn-sm tombol-kanan" href="<?php echo base_url(); ?>pengusaha/m_siswa/import"><i class="glyphicon glyphicon-upload"></i> &nbsp;&nbsp;Import</a>
				<button class="btn btn-primary btn-sm tombol-kanan" href="<?php echo base_url(); ?>pengusaha/m_siswa/import"><i class="glyphicon glyphicon-upload"></i> &nbsp;&nbsp;Aktifkan Semua User</button>
			</div>
		</div>
		<div class="panel-body">
			<table class="table table-responsive table-bordered" style="width:100%; padding:10px;" id="datatabel">
				<thead>
					<tr>
						<th class="text-center align-middle">No</th>
						<th class="text-center align-middle">Nama Siswa</th>
						<th class="text-center align-middle">Username</th>
						<th class="text-center align-middle">NRP</th>
						<th class="text-center align-middle">Kelompok</th>
						<th class="text-center align-middle">Opsi</th>
					</tr>
				</thead>

				<tbody></tbody>
			</table>

		</div>
	</div>
</div>
</div>

<div class="modal fade" id="m_siswa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 id="myModalLabel">Data Siswa</h4>
			</div>
			<div class="modal-body">
				<form name="f_siswa" id="f_siswa" onsubmit="return m_siswa_s();">
					<input type="hidden" name="id" id="id" value="0">
					<table class="table table-form">
						<tr>
							<td style="width: 25%">Kelompok</td>
							<td style="width: 75%"><input type="text" class="form-control" name="kelompok" id="kelompok" required></td>
						</tr>

						<tr>
							<td style="width: 25%">Nama Lengkap</td>
							<td style="width: 75%"><input type="text" class="form-control" name="nama" id="nama" required></td>
						</tr>
						<tr>
							<td style="width: 25%">Username</td>
							<td style="width: 75%"><input type="text" class="form-control" name="username" id="username" required></td>
						</tr>

						<tr>
							<td style="width: 25%">Pangkat</td>
							<td style="width: 75%"><input type="text" class="form-control" name="pangkat" id="pangkat" required></td>
						</tr>
						<tr>
							<td style="width: 25%">NRP</td>
							<td style="width: 75%"><input type="text" class="form-control" name="nrp" id="nrp" required></td>
						</tr>

						<tr>
							<td style="width: 25%">No.Telp/Hp</td>
							<td style="width: 75%"><input type="text" class="form-control only-number" name="telp" id="telp" required></td>
						</tr>
						<tr>
							<td style="width: 25%">Tempat Lahir</td>
							<td style="width: 75%"><input type="text" class="form-control" name="tempat" id="tempat" required></td>
						</tr>
						<tr>
							<td style="width: 25%">Tanggal Lahir</td>
							<td style="width: 75%"><input type="date" class="form-control" name="tanggal" id="tanggal" required></td>
						</tr>

						<tr>
							<td style="width: 25%">NIM</td>
							<td style="width: 75%"><input type="text" class="form-control" name="nim" id="nim" required></td>
						</tr>
						<tr>
							<td style="width: 25%">NIK</td>
							<td style="width: 75%"><input type="text" class="form-control" name="nik" id="nik" required></td>
						</tr>
						<tr>
							<td style="width: 25%">Email</td>
							<td style="width: 75%"><input type="text" class="form-control" name="email" id="email" required></td>
						</tr>
						<tr>
							<td style="width: 25%">Alamat</td>
							<td style="width: 75%"><textarea type="text" class="form-control" name="alamat" id="alamat" required></textarea></td>
						</tr>
						
						<tr>
							<td style="width: 25%">Lembaga</td>
							<td><select name="instansi" id="instansi" class="form-control">
								<option value="">Pilih</option>
							    <?php foreach($instansi as $rows) : ?>
							        <option value="<?= $rows->id; ?>"><?= $rows->instansi; ?></option>
							    <?php endforeach; ?>
							</select></td>
						</tr>

						</table>
					</div>
			<div class="modal-footer">
				<button class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Simpan</button>
				<button class="btn btn-sm" data-dismiss="modal" aria-hidden="true"><i class="fa fa-minus-circle"></i> Tutup</button>
			</div>
			</form>
		</div>
	</div>
</div>
