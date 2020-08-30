<style type="text/css">
	h1{
		font-family: sans-serif;
	}

	table {
		margin-top: 10px;
		font-family: Arial, Helvetica, sans-serif;

		font-size: 12px;
		width: 100%;
		color: #666;
		background: #eaebec;
		border: #ccc 1px solid;
		border-radius: 25px;
	}

	table th {
		padding: 2px 5px;
		border:1px solid #337ab7;
		background: #337ab7;;
		text-align: center;
		color: #fff;
	}

	table th:first-child{  
		border-left:none;  
	}

	table tr {
		padding-left: 20px;
	}

	td.frist,th.frist {
    width: 1px;
    white-space: nowrap;
}

	table td {
		padding: 5px 5px;
		border-top: 1px solid #ffffff;
		border-bottom: 1px solid #e0e0e0;
		border-left: 1px solid #e0e0e0;
		background: #fff;
		background: -webkit-gradient(linear, left top, left bottom, from(#fbfbfb), to(#fafafa));
		background: -moz-linear-gradient(top, #fbfbfb, #fafafa);
	}

	table tr:last-child td {
		border-bottom: 0;
	}

	table tr:last-child td:first-child {
		-moz-border-radius-bottomleft: 3px;
		-webkit-border-bottom-left-radius: 3px;
		border-bottom-left-radius: 3px;
	}

	table tr:last-child td:last-child {
		-moz-border-radius-bottomright: 3px;
		-webkit-border-bottom-right-radius: 3px;
		border-bottom-right-radius: 3px;
	}

	table tr:hover td {
		background: #f2f2f2;
		background: -webkit-gradient(linear, left top, left bottom, from(#f2f2f2), to(#f0f0f0));
		background: -moz-linear-gradient(top, #f2f2f2, #f0f0f0);
	}

</style>

<div class="col-md-9 page-content">
	<div class="inner-box">

		<div id="accordion" class="panel-group">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-info">
						<div class="panel-heading">
							<div class="tombol-kanan">
								<h2><strong>Data <?=$this->page_title;?></strong></h2>
							</div>
						</div>
					</div>
					<from class="form-inline" style="display: block;">
						<div class="form-group">
							<label for="search">Search&nbsp;&nbsp;</label>
							<select id="filter" class="form-control input-sm">
								<?php foreach ($searchFilter as $key => $val): ?>
									<option value="<?=$key;?>"><?=$val;?></option>
								<?php endforeach ?>
							</select>
							<input type="text" style="width: 50%;" class="form-control input-sm" id="search" placeholder="ketikan yang anda cari" name="search">
						</div>
					</from>
					<br>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				Limit 
				<select id="limit">
					<option value="10">10</option>
					<option value="50">50</option>
					<option value="100">100</option>
				</select>
				<div id="error">
					<?= $this->session->flashdata('error'); ?>
				</div>
                <?php if($this->log_lvl != 'siswa') : ?>
				<!-- <a href="<?=base_url('export/rekapitulasi') ?>" class="btn btn-sm btn-success"><i class="fas fa-file-excel-o"></i>&nbsp;Export Excel</a>
				<a target="_blank" href="<?= base_url('export/pdf_rekapitulasi') ?>" class="btn btn-sm btn-danger">
					<i class="fas fa-file-pdf-o">&nbsp;Export PDF</i>
				</a> -->
				<button data-href="<?=base_url('export/rekapitulasi') ?>" class="btn btn-sm btn-success export-nilai" data-type="excel"><i class="fas fa-file-excel-o" ></i>&nbsp;Export Excel</button>
				<button data-target="_blank" data-href="<?= base_url('export/pdf_rekapitulasi') ?>" class="btn btn-sm btn-danger export-nilai" data-type="pdf">
					<i class="fas fa-file-pdf-o">&nbsp;Export PDF</i>
				</button>
				<?php endif; ?>
				<div id="content-view"></div>
			</div>
		</div>
	</div>

</div>
</div>
<!-- Modal -->
<div class="modal fade" id="nilaiModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  	<form action="" id="export-nilai">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Export Nilai</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <div class="form-group">
	        	<label for="">Kategori</label>
	        	<select name="kategori" class="form-control" id="kategori-nilai" required>
	        		<option value="0">Pilih Kategori</option>
	        		<option value="harian">Ujian Harian</option>
<!-- 	        		<option value="uts">UTS</option>
	        		<option value="uas">UAS</option> -->
	        		<option value="tugas">Tugas</option>
	        	</select>
	        </div>
	        <div class="form-group">
	        	<label for="">Data</label>
	        	<select name="data" id="data-nilai" class="form-control" required>
	        		<option value="0" disabled>Pilih Data</option>	
	        	</select>
	        </div>
	        <div class="form-group" id="kelas">
	        	<label for="">Kelas</label>
	        	<select name="kelas" id="kelas-nilai" class="form-control" required>
	        		<option value="0" disabled>Pilih Kelas</option>	
	        	</select>
	        </div>
	      </div>
	      <div class="modal-footer">
	        <button type="submit" class="btn btn-primary">Export</button>
	      </div>
	    </div>
    </form>
  </div>
</div>

<!-- Modal Keaktifan -->
<div class="modal fade" id="keaktifanModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  	
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Nilai Keaktifan Siswa</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        
	      </div>
	    </div>
    
  </div>
</div>

<!--/.row-box End-->
<script src="<?= base_url(); ?>assets/js/jquery/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		let self, typeExport = 'pdf', formData;
		pageLoad(1,'rekaptulasi/page_load');

		$('#limit').change(function(){
			pageLoad(1,'rekaptulasi/page_load');
		});

		$('#search').keyup(delay(function (e) {
			pageLoad(1,'rekaptulasi/page_load');
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

		$('.export-nilai').click(function(e) {
			e.preventDefault();
			if($(this).data('type') === 'pdf') {
				typeExport = 'pdf';
			}
			else {
				typeExport = 'excel';
			}
			$('#nilaiModal').modal('show');
		});

		

		// kategori event
		$('#kategori-nilai').change(function(e) {
			e.preventDefault();


			$('#data-nilai').html(`<option value="0" selected disabled>Pilih Data</option>`);
			$('#kelas-nilai').html(`<option value="0" selected disabled>Pilih Kelas</option>`);
			if($(this).val() != 'tugas') {
				$('#kelas').addClass('d-none');	
			}
			else {
				$('#kelas').removeClass('d-none');		
			}
			self = this;

			$.ajax({
				type: 'post',
				url: "<?= base_url('rekaptulasi/get-data-by-kategori'); ?>",
				data: {
					kategori: $(self).val()
				},
				dataType: 'json',
				success: function(res) {
					$('#data-nilai').html(res.data);
				}
			})
		});

		// data event
		$('#data-nilai').on('change', function(e) {
			e.preventDefault();
			$('#kelas-nilai').html(`<option value="0" selected disabled>Pilih Kelas</option>`);
			self = this;
			$.ajax({
				type: 'post',
				url: "<?= base_url('rekaptulasi/get-kelas-by-data'); ?>",
				data: {
					kategori: $('#kategori-nilai').val(),
					data: $(self).val()
				},
				dataType: 'json',
				success: function(res) {
					$('#kelas-nilai').html(res.data);
				}
			})
		});

		$('#export-nilai').on('submit', function(e) {
			e.preventDefault();
			self = this;
			if($('#kategori-nilai').val() == 0 || $('#data-nilai').val() == 0) {
				alert('Harap pilih semua opsi');
				return false;
			}
			var kategori = $('#kategori-nilai').val(),
				kelas = $('#kelas-nilai').val(),
				data = $('#data-nilai').val();
			formData = new FormData();
			formData.append('kategori', kategori);
			formData.append('kelas', kelas);
			formData.append('data', data);
			formData.append('type', typeExport);
			$.ajax({
				type: 'post',
				url: "<?= base_url('export/rekaptulasi'); ?>",
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				success: function(res) {
					$('#nilaiModal').modal('hide');
					window.location.href = res.url;
				}
			});

		});
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