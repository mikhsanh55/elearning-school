<div class="row col-md-12 ini_bodi">
	<div class="panel">
		<div class="panel-heading">
			<div class="tombol-kanan">
				<h2><strong>DATA PENGAJAR</strong></h2>
				 <?php if( $this->session->userdata('admin_level') == "admin"){ ?>
				<a class="btn btn-success btn-sm tombol-kanan" href="#" onclick="return m_guru_t();"><i class="glyphicon glyphicon-plus"></i> &nbsp;&nbsp;Tambah</a>
				<a class="btn btn-warning btn-sm tombol-kanan" href="<?php echo base_url(); ?>upload/format_import_guru.xlsx"><i class="glyphicon glyphicon-download"></i> &nbsp;&nbsp;Download Format Import</a>
				<a class="btn btn-info btn-sm tombol-kanan" href="<?php echo base_url(); ?>trainer/m_guru/import"><i class="glyphicon glyphicon-upload"></i> &nbsp;&nbsp;Import</a>
				 <?php } ?>
				
			</div>
		</div>
		<div class="panel-body">

			<table class="table table-bordered table-striped w-100 mx-auto" style="width: 300% !important;" id="datatabel">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama Pengajar</th>
						<th>NIDN</th>
						<th>Opsi</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>

		</div>
	</div>
</div>
</div>

<div class="modal fade" id="m_guru" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">

				<h4 id="myModalLabel">Data Pengajar</h4>
			</div>
			<div class="modal-body">
				<form name="f_guru" id="f_guru" onsubmit="return m_guru_s();" enctype="multipart/form-data">
					
					<table class="table table-form w-100">
					<input type="hidden" name="id" id="id" value="0">
					<tr>
							<td style="width: 25%">Tahun Akademik</td>
							<td style="width: 75%"><input type="text" class="form-control" name="ta" id="ta" required></td>
						</tr>
						<tr>
							<td style="width: 25%">NIDN</td>
							<td style="width: 75%"><input type="text" class="form-control" name="nidn" id="nidn" required></td>
						</tr>
						<tr>
							<td style="width: 25%">NRP</td>
							<td style="width: 75%"><input type="text" class="form-control" name="nrp" id="nrp" required></td>
						</tr>
						<tr>
							<td style="width: 25%">Nama Lengkap</td>
							<td style="width: 75%"><input type="text" class="form-control" name="nama" id="nama" required></td>
						</tr>
						<tr>
							<td style="width: 25%">Pangkat</td>
							<td style="width: 75%"><input type="text" class="form-control" name="pangkat" id="pangkat" required></td>
						</tr>
						<tr>
							<td style="width: 25%">Jabatan Akademik</td>
							<td style="width: 75%"><input type="text" class="form-control" name="ja" id="ja" required></td>
						</tr>
						<tr>
							<td style="width: 25%">Tempat_lahir</td>
							<td style="width: 75%"><input type="text" class="form-control" name="tempat" id="tempat" required></td>
						</tr>
						<tr>
							<td style="width: 25%">Tanggal Lahir</td>
							<td style="width: 75%"><input type="date" class="form-control" name="tanggal" id="tanggal" required></td>
						</tr>
						<tr>
							<td style="width: 25%">Alamat</td>
							<td style="width: 75%"><input type="text" class="form-control" name="alamat" id="alamat" required></td>
						</tr>
						<tr>
							<td style="width: 25%">Email</td>
							<td style="width: 75%"><input type="text" class="form-control" name="email" id="email" required></td>
						</tr>
						<tr>
							<td style="width: 25%">No. Telpon</td>
							<td style="width: 75%"><input type="text" class="form-control" name="telp" id="telp" required></td>
						</tr>
						<tr>
							<td style="width: 25%">Status</td>
							<td style="width: 75%"><input type="text" class="form-control" name="status" id="status" required></td>
						</tr>
						<tr>
							<td style="width: 25%">Pendidikan Umum Terakhir</td>
							<td style="width: 75%"><input type="text" class="form-control" name="put" id="put" required></td>
						</tr>
						<tr>
							<td style="width: 25%">Pendidikan Militer Terakhir</td>
							<td style="width: 75%"><input type="text" class="form-control" name="pmt" id="pmt" required></td>
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


<!-- 
<div class="modal fade" id="guru_profil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
		<h4 class="modal-title" id="exampleModalLabel">Profil Pengajar</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
			</div>
			<div class="modal-body">
			    <center>
			     <img src="" id="profile-photo" class="rounded-circle" width="300" height="300" > 
			     </center>
			     </br>
			     </br>
			     	<table class="table table-form">
						
						<tr>
						    
							<td style="width: 20%">Nama : </td>
							<td style="width: 80%"><span id="profile-nama"></span></td>
							
							
						</tr>
						<tr>
							<td style="width: 20%">Email : </td>
							<td style="width: 80%"><span id="profile-nip"></span></td>
							
						</tr>
						<tr>
						    <td style="width: 20%">No Telepon : </td>
							<td style="width: 80%"><span id="profile-telp"></span></td>
						</tr>
						<tr>
						    <td style="width: 20%">Jenis Kelamin : </td>
							<td style="width: 80%"><span id="profile-jk"></span></td>
						</tr>
						<tr>
						    <td style="width: 20%">Pengalaman </td>
							<td style="width: 80%"><pre><span id="profile-cv"></span></pre></td>
							
						</tr>
						
					</table>

		</div>
	</div>
</div>
 -->
