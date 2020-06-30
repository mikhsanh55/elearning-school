<main class="col-sm-12">
	<div class="panel panel-info">
		  <div class="panel-heading">Daftar UTS / UAS</div>
		  <div class="panel-body">
		  	
		  		<button class="btn btn-primary btn-sm mb-3" onclick="buat_ujian_uts();">Buat Ujian</button>
		  	

		  	<table class="table table-bordered table-striped">
		  		<thead>
		  			<tr>
		  				<th class="icon-table">No</th>
		  				<th>Nama Ujian</th>
		  				<th>Pengajar</th>
		  				<th class="text-center">Due Date</th>
		  				<th class="text-center">Opsi</th>
		  			</tr>
		  		</thead>
		  		<tbody>
		  			<?php if(count($data_ujian) < 1) { ?>
		  				<tr>
		  					<td class="text-center" colspan="5">Belum ada data</td>
		  				</tr>
		  			<?php } else { ?>
		  				<?php $i = 0; foreach($data_ujian as $data) : ?>
		  					<tr>
		  						<td><?= ++$i; ?></td>
		  						<td><?= $data->nama_ujian; ?></td>
		  						<td><?= $data->nama_guru; ?></td>
		  						<td><?= $data->tgl_selesai; ?></td>
		  						<td class="btn-group">
		  							<!-- <?php if($sess_level == 'guru'): ?> -->
			  							<button class="btn-primary btn btn-sm mr-1" id="btn-edit-ujian" data-id="<?= $data->id; ?>">Edit</button>
			  						<!-- <?php endif; ?> -->
			  						<button class="btn-primary btn btn-sm mr-1">Lihat Soal</button>
			  						<button class="btn-warning btn btn-sm mr-1">Ikuti Ujian</button>
		  						</td>
		  					</tr>
		  				<?php endforeach;?>
		  			<?php } ?>
		  		</tbody>
		  	</table>
		  </div>
	</div>
</main>
<!-- Modal For Add Ujian -->
<div class="modal fade bd-example-modal-lg" id="ujian_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
       <div class="modal-content">
      <div class="modal-header">
        <h4 id="myModalLabel">Buat Ujian</h4>
      </div>
      <div class="modal-body">
        <div class="alert alert-info">
        <a href="#" onclick="return view_petunjuk('petunjuk');">petunjuk ..?</a>
        <div id="petunjuk">
          <ul>
            <li><b>Jml Soal</b>, harap dimasukkan sesuai jumlah soal yang sudah ada di bank soal</li>
            <li><b>Tgl Mulai</b>, adalah waktu awal boleh mulai meng-klik tombol "mulai ujian"</li>
            <li><b>Tgl Selesai</b>, adalah waktu akhir boleh mulai meng-klik tombol "mulai ujian"</li>
            <li><b>Acak Soal</b>, jika dipilih acak, maka soal akan diacak, jika diurutkan, maka akan diurutkan berdasarkan urutan soal masuk</li>
          </ul>
        </div>
      </div>
          <form name="f_ujian" id="f_ujian" >
            <input type="hidden" name="id" id="id" value="0">
            <input type="hidden" name="jumlah_soal1" id="jumlah_soal1" value="0">
              <table class="table table-form">
                <tr>
                	<td class="w-25">Modul</td>
                	<td>
	                	<select class="form-control" name="mapel" id="mapel">
	                		<?php foreach($mapel->result() as $m) : ?>
	                			<option value="<?= $m->id; ?>"><?= $m->nama; ?></option>
	                		<?php endforeach; ?>
	                	</select>
                	</td>
                </tr>
		<tr><td style="width: 25%">Nama Ujian</td><td style="width: 75%"><input type="text" class="form-control" name="nama_ujian" id="nama_ujian" required></td></tr>
                <tr><td>Jumlah soal</td><td><?php echo form_input('jumlah_soal', '', 'class="form-control" number id="jumlah_soal" required'); ?></td></tr>
                <tr><td>Tanggal Mulai</td><td>
                  <input type="date" name='tgl_mulai' class="form-control" style="width: 100%; display: inline; float: left" id="tgl_mulai" placeholder="Tgl" data-tooltip="waktu awal boleh menge-klik tombol \"mulai\" ujian" required>
                  <input type="hidden" name='wkt_mulai' class="form-control" style="width: 130px; display: inline; float: left" id="wkt_mulai" placeholder="Waktu" required >
                </td></tr>
                <tr><td>Tanggal Selesai</td><td>
                  <input type="date" name='terlambat' class="form-control" style="width: 100%; display: inline; float: left" id="terlambat" placeholder="Tgl" required>
                  <input type="hidden" name='terlambat2' class="form-control" style="width: 130px; display: inline; float: left" id="terlambat2" placeholder="Waktu" required >
                </td></tr>
                <tr><td>Waktu Ujian</td><td><?php echo form_input('waktu', '', 'class="form-control" id="waktu" placeholder="menit" required style="width: 100px; display: inline; float: left"'); ?> <div style="float: left; margin: 4px 0 0 10px"> menit</div></td></tr>
              </table>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary btn-sm" data-action="add" id="btn_buat_ujian" type="submit"><i class="fa fa-check mr-3"></i>Buat</button>
        <button class="btn btn-sm" data-dismiss="modal" aria-hidden="true"><i class="fa fa-minus-circle"></i> Batal</button>
      </div>
        </form>
    </div>
  </div>
</div>
<script type="text/javascript">

	function buat_ujian_uts() {
		if(!$('#ujian_modal').hasClass('in')) {
			$('#ujian_modal').modal('show')	
		}
	}

	$('#btn-edit-ujian').click(function() {
		$('#myModalLabel').text('Edit Ujian')
		$('#btn_buat_ujian').html('<i class="fa fa-check mr-3"></i>Update')
		console.log($(this))
		$.ajax({
			type:'POST',
			url: "<?= base_url('ujian/uts/'); ?>" + $(this).data('id'),
			dataType:'JSON',
			success:function(res) {
				$('#nama_ujian').data('id', res.data.id)
				let options = ''
				res.mapel.forEach(function(item) {
					if(item.id == res.data.id) {
						options += `<option value="${item.id}" selected>${item.nama}</option>`	
					}
					else {
						options += `<option value="${item.id}">${item.nama}</option>`	
					}
				})

				$('#mapel').html(options)
				$('#nama_ujian').val(res.data.nama_ujian)
				$('#jumlah_soal').val(res.data.jumlah_soal)
				$('#tgl_mulai').val(res.data.tgl_mulai.split(' ')[0])
				$('#terlambat').val(res.data.tgl_selesai.split(' ')[0])
				$('#waktu').val(res.data.waktu)
			}
		})
		if(!$('#ujian_modal').hasClass('in')) {
			$('#ujian_modal').modal('show')	
		}

		$('#btn_buat_ujian').click(function(e) {
			e.preventDefault()
			
				var formData = new FormData()
				formData.append('id', $('#nama_ujian').data('id'))
				formData.append('mapel', $('#mapel').val())
				formData.append('nama_ujian', $('#nama_ujian').val())
				formData.append('jumlah_soal', $('#jumlah_soal').val())
				formData.append('tgl_mulai', $('#tgl_mulai').val())
				formData.append('terlambat', $('#terlambat').val())
				formData.append('waktu', $('#waktu').val())

				$.ajax({
					type:'POST',
					url:"<?= base_url('ujian/update_uts/'); ?>",
					data:formData,
					processData:false,
					contentType:false,
					dataType:'JSON',
					beforeSend: function() {
						$('#btn_buat_ujian').prop({disabled: true})
						$('#btn_buat_ujian').text('Memperbaharui...')
					},
					success:function(res) {
						$('#btn_buat_ujian').prop({disabled: false})
						$('#btn_buat_ujian').html('<i class="fa fa-check mr-3"></i>Buat')
						console.log(res)
						if(res.status === true) {
							alert(res.msg)
							window.location = "<?= base_url('ujian/uts'); ?>"
						}
					},
					error: function(e) {
						$('#btn_buat_ujian').prop({disabled: false})
						$('#btn_buat_ujian').html('<i class="fa fa-check mr-3"></i>Buat')
						let errors = JSON.parse(e.responseText)
						alert(errors.msg)
						return false
					}
				})
		})	
	})

	$('#btn-buat-ujian').click(function(e){
		e.preventDefault()
		var formData = new FormData()
		formData.append('mapel', $('#mapel').val())
		formData.append('nama_ujian', $('#nama_ujian').val())
		formData.append('jumlah_soal', $('#jumlah_soal').val())
		formData.append('tgl_mulai', $('#tgl_mulai').val())
		formData.append('terlambat', $('#terlambat').val())
		formData.append('waktu', $('#waktu').val())

		$.ajax({
			type:'POST',
			url:"<?= base_url('ujian/tambah_uts'); ?>",
			data:formData,
			processData:false,
			contentType:false,
			dataType:'JSON',
			beforeSend: function() {
				$('#btn_buat_ujian').prop({disabled: true})
				$('#btn_buat_ujian').text('Membuat...')
			},
			success:function(res) {
				$('#btn_buat_ujian').prop({disabled: false})
				$('#btn_buat_ujian').html('i class="fa fa-check mr-3"></i>Buat')
				console.log(res)
				if(res.status === true) {
					alert(res.msg)
					window.location = "<?= base_url('ujian/uts'); ?>"
				}
			},
			error: function(e) {
				$('#btn_buat_ujian').prop({disabled: false})
				$('#btn_buat_ujian').html('i class="fa fa-check mr-3"></i>Buat')
				let errors = JSON.parse(e.responseText)
				alert(errors.msg)
				return false
			}
		})
	})
</script>