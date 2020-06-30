
<div class="col-md-9 page-content">
	<div class="inner-box">

		<div id="accordion" class="panel-group">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-info">
						<div class="panel-heading">
							<div class="tombol-kanan">
								<div class="row">
						            <div class="col-sm-12 col-md-6 col-lg-6">
						                <h2><strong>Edit Instansi</strong></h2>
						            </div>
						            <div class="col-sm-12 col-md-6 col-lg-6 text-right">
						                <button class="btn btn-light" onclick="back_page('instansi')">Kembali</button>
						            </div>
						        </div>
								<?php if( $this->session->userdata('admin_level') == "admin"){ ?>
								
								<?php } ?>
								<!--<a class="btn btn-warning btn-sm tombol-kanan" href="<?php echo base_url(); ?>upload/format_import_guru.xlsx"><i class="glyphicon glyphicon-download"></i> &nbsp;&nbsp;Download Format Import</a>-->
								<!--<a class="btn btn-info btn-sm tombol-kanan" href="<?php echo base_url(); ?>trainer/m_guru/import"><i class="glyphicon glyphicon-upload"></i> &nbsp;&nbsp;Import</a>-->
							</div>
						</div>
					</div>
					<br>
				</div>
			</div>
			<form action="<?=base_url('instansi/update');?>" method="post">
				<div class="form-group">
					<label for="email">Instansi:</label>
					<input type="hidden" name="id" value="<?=$edit->id;?>">
					<input type="text" class="form-control" id="instansi" name="instansi" required="" value="<?=$edit->instansi;?>">
				</div>
				<div class="form-group">
					<label for="nama_pimpinan">Nama Pimpinan:</label>
					<input type="text" class="form-control" id="nama_pimpinan" name="nama_pimpinan" required="" value="<?=$edit->nama_pimpinan;?>">
				</div>
				<div class="form-group">
					<label for="no_telp">No Telp:</label>
					<input type="text" class="form-control" id="no_telp" name="no_telp" required="" value="<?=$edit->no_telp;?>">
				</div>
				<div class="form-group">
					<label for="alamat">Alamat:</label>
					<input type="text" class="form-control" id="alamat" name="alamat" required="" value="<?=$edit->alamat;?>">
				</div>
				<button type="submit" class="btn btn-default">Simpan</button>
				<button type="button" class="btn btn-default" onclick="window.location='<?=base_url('instansi');?>'">List</button>
			</form> 
		</div>
	</div>

</div>
</div>
<!--/.row-box End-->
<script src="<?= base_url(); ?>assets/js/jquery/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		pageLoad(1,'instansi/page_load');

		$('#limit').change(function(){
			pageLoad(1,'instansi/page_load');
		});

		$('#search').keyup(delay(function (e) {
			pageLoad(1,'instansi/page_load');
		}, 500));

		function delay(callback, ms) {
			var timer = 0;
			return function() {
				var context = this, args = arguments;
				clearTimeout(timer);
				timer = setTimeout(function () {
					callback.apply(context, args);
				}, ms || 0);
			};
		}


	})

	function pageLoad(pg, url, search){
		$.ajax({
			type : 'post',
			url  : '<?php echo base_url() ?>' + url + '/' + pg,
			data :{
				pg    : pg,
				limit : $('#limit').val(),
				filter : $('#filter').val(),
				search : $('#search').val()
			},
			success:function(response){
				$('#content-view').html(response);
			}
		})
	}
</script>




