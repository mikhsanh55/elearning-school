<div class="col-md-9 page-content">
	<div class="inner-box">
		<div class="row">
			<div class="col-sm-12 col-md-6 col-lg-6">
				<h2><strong> Daftar <?= $this->name; ?></strong></h2>	
			</div>
			<div class="col-sm-12 col-md-6 col-lg-6 text-right">
				<a class="btn btn-light" href="<?= base_url('jurusan'); ?>">Kembali</a>
			</div>
		</div>
		<div id="accordion" class="panel-group">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-info">
						<div class="panel-heading">
							<div class="tombol-kanan">
								
							</div>
						</div>
					</div>
					<from class="form-inline" style="display: block;">
					<div class="form-group">
							<label for="search">Search&nbsp;&nbsp;</label>
							<div class="rs-select2 js-select-simple select--no-search">
								<select id="filter" class="form-control input-sm">
									<?php foreach ($searchFilter as $key => $val): ?>
										<option value="<?=$key;?>"><?=$val;?></option>
									<?php endforeach ?>
								</select>
								<div class="select-dropdown"></div>
							</div>
							<input type="text" style="width: 50%;height:30px;" class="form-control input-sm" id="search" placeholder="ketikan yang anda cari" name="search">
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
				<div id="content-view"></div>
			</div>
		</div>
	</div>

</div>
</div>
<!-- Modal -->
<div class="modal fade" id="listSiswaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-target=".bd-example-modal-sm">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Daftar Siswa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="daftar-siswa"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- <div class="modal fade" id="rekrut_murid" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" style="max-width:80%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 id="myModalLabel"></h4>
				<a href="javascripti:void(0);" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></a>
			</div>
			<div class="modal-body">
				<div id="daftar-murid"></div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-sm" data-dismiss="modal" aria-hidden="true"><i class="fa fa-minus-circle"></i> Tutup</button>
			</div>
	
		</div>
	</div>
</div> -->
<!--/.row-box End-->
<script src="<?= base_url(); ?>assets/js/jquery/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
	let html;
	function displaySiswa(self) {
		html = ''
		$('#listSiswaModal .modal-title').text('Daftar Siswa')
		$(self).prop('disabled', true).text('Loading...')
		$.ajax({
			type: 'POST',
			url  : '<?php echo base_url() ?>' + 'kelas/daftar_murid' + '/' + 1,
			data : {
				id : $(self).data('id'),
				id_kelas : $(self).data('id'),
			},
			success: function(res) {
				$(self).prop('disabled', false).text('Lihat Siswa')
				$('#daftar-siswa').html(res)		
			}			
		}).done(() => {
			$('#listSiswaModal').modal('show')
			if(!$('#listSiswaModal').hasClass('show')) {
				$('#listSiswaModal').addClass('show')
			}
			if(!$('.modal-backdrop').hasClass('show')) {
				$('.modal-backdrop').addClass('show')
			}
		})
	}

	$(document).ready(function(){
		pageLoad(1,'kelas/page_load_guru');

		$('#limit').change(function(){
			pageLoad(1,'kelas/page_load_guru');
		});

		$('#search').keyup(delay(function (e) {
			pageLoad(1,'kelas/page_load_guru');
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

	$(document).on('click','#checkall',function(){
		if ($(this).is(':checked')) {
			$('.checklist').prop('checked',true);
		}else{
			$('.checklist').prop('checked',false);
		}
		
	})


	$(document).on('click','#deleted',function(){
		var totalChecked = $('.checklist:checked').length;
		var opsi = [];

		if (totalChecked > 0) {
			var y = confirm('Apakah anda yakin untuk menghapus data ?');
			$(".checklist:checked").each(function(){
				opsi.push($(this).val());
			});
		}else{
			alert('Tidak ada yang dipilih!');
		}

		

		if (y == true) {

			$.ajax({
				type:'post',
				url : '<?=base_url('kelas/multi_delete');?>',
				dataType : 'json',
				data : {
					id : opsi,
				},
				success:function(response){
					if (response.result == true) {
						pageLoad(1,'kelas/page_load_guru');
					}else{
						alert('Hapus Gagal');
					}

					
				}
			})


		}else{
			return false;
		}

		
	})

	$(document).on('click','#edited',function(){
		var totalChecked = $('.checklist:checked').length;
		var opsi = [];

		if (totalChecked > 1) {
			alert('Pilih satu untuk edit  !');
			return false;
		}else if(totalChecked < 1){
			alert('Tidak ada yang dipilih!');
			return false;
		}else{
			window.location = base_url + 'kelas/edit/' + $('.checklist:checked').data('id');			
		}
	})

	$(document).on('click','.rekrut',function(){
		
		$.ajax({
			type : 'post',
			url  : '<?php echo base_url() ?>' + 'kelas/daftar_murid' + '/' + 1,
			data : {
				id : $(this).data('id'),
				id_jurusan : $(this).data('jurusan')
			},
			success:function(response){
				$('#daftar-murid').html(response);
			}
		})

		$('#rekrut_murid').modal('show');
		if(!$('#rekrut_murid').hasClass('show')) {
			$('#rekrut_murid').addClass('show')
		}
		if(!$('.modal-backdrop').hasClass('show')) {
			$('.modal-backdrop').addClass('show')
		}		
	})


</script>




