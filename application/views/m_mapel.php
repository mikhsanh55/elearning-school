
<div class="row col-md-12 ini_bodi">
	<div class="panel panel-info">
		<div class="panel-heading">
			<div class="tombol-kanan">
				<h2><strong>Modul Pelatihan</strong></h2>
				<?php if( $this->session->userdata('admin_level') == 'admin') : ?>
				<a class="btn btn-success btn-sm tombol-kanan" href="#" onclick="return m_mapel_e(0);"><i class="glyphicon glyphicon-plus"></i> &nbsp;&nbsp;Tambah</a>
				<?php endif; ?>
			</div>
		</div>
		<div class=" panel-body w-100">


			<table class="table table-bordered table-striped w-100 mx-auto" style="width: 300% !important;" id="datatabel">
				<thead>
					<tr>
						<th >No</th>
						<th >Judul Modul</th>
						<th>Pengajar</th>
						<!-- <th class="text-center">Tanya Jawab</th> -->
						<th class="text-center">Opsi</th>
					</tr>
				</thead>

				<tbody>
				</tbody>
			</table>

		</div>
	</div>
</div>
</div>
<div class="modal fade" id="m_mapel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 id="myModalLabel">Data Modul</h4>
			</div>
			<div class="modal-body">
				<form name="f_mapel" id="f_mapel" onsubmit="return m_mapel_s();">
					<input type="hidden" name="id" id="id" value="0">
					<table class="table table-form">
						<tr>
							<td style="width: 25%">Nama Modul</td>
							<td style="width: 75%"><input type="text" class="form-control" name="nama" id="nama" required></td>
						</tr>
					</table>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>
				<button class="btn" data-dismiss="modal" aria-hidden="true"><i class="fa fa-minus-circle"></i> Tutup</button>
			</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="hapus_mapel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 id="myModalLabel">Data Modul</h4>
			</div>
			<div class="modal-body">
				<form name="f_mapel" id="f_mapel" onsubmit="return m_mapel_s();">
					<input type="hidden" name="id" id="id" value="0">
					<table class="table table-form">
						<tr>
							<td><input type="radio" name="aksi_hapus_modul" value="1"> </td>
							<td>Hapus semua sub modul</td>
						</tr>
						<tr>
						    <td><input type="radio" value="0" name="aksi_hapus_modul"> </td>
							<td>Pindahkan semua sub modul ke modul lain</td>
						</tr>
					</table>
					<p class="mt-2 mb-2 d-none" id="label-pindah-modul">Pindahkan sub modul ke :</p>
					<select name="id_pindah_modul" class="d-none" id="select-ganti-modul">
					    
					</select>
			</div>
			<div class="modal-footer">
				<button class="btn btn-danger btn-sm" id="hapus-modul">Hapus Modul</button>
				<button class="btn btn-sm btn-primary" data-dismiss="modal" aria-hidden="true">Batal</button>
			</div>
			</form>
		</div>
	</div>
</div>


