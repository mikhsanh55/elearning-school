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
		<div class="row">
			<div class="col-sm-12 col-md-6 col-lg-6">
                <h2><strong>Rekapitulasi Penilaian</strong></h2>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6 text-right">
			<button class="btn btn-light text-right" onclick="history.back()">Kembali</button>
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

		

							&nbsp;&nbsp;

							<label for="search">Search&nbsp;&nbsp;</label>

							<div class="rs-select2 js-select-simple select--no-search">

								<select id="filter" class="form-control input-sm">

									<?php foreach ($searchFilter as $key => $val): ?>

										<option value="<?=$key;?>"><?=$val;?></option>

									<?php endforeach ?>

								</select>

								<div class="select-dropdown"></div>

							</div>

							&nbsp;&nbsp;

							<input type="text" style="width: 30%;height:30px;" class="form-control input-sm" id="search" placeholder="ketikan yang anda cari" name="search">

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
				<a href="<?= base_url('penilaian/laporan') ?>" title="export" id="export" class="btn btn-primary btn-sm  ml-2">&nbsp;Export</a>
				<div id="content-view"></div>

			</div>

		</div>

	</div>



</div>

</div>





<!--/.row-box End-->

<script src="<?= base_url(); ?>assets/js/jquery/jquery-3.3.1.min.js"></script>

<script type="text/javascript">

	$(document).ready(function(){

		pageLoad(1,'penilaian/page_load_out1');



		$('#limit,#tipe_penilaian').change(function(){

			pageLoad(1,'penilaian/page_load_out1');

		});



		$('#search').keyup(delay(function (e) {

			pageLoad(1,'penilaian/page_load_out1');

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

				search : $('#search').val(),

				tipe_penilaian : $('#tipe_penilaian').val()

			},

			success:function(response){

				$('#content-view').html(response);

			}

		})

	}



	$(document).on('submit','#form-siswa',function(e){



		e.preventDefault()

		var f_asal	= $(this);

		var form	= getFormData((f_asal));

		$.ajax({		

			type: "POST",

			url: base_url+"pengusaha/m_siswa/simpan",

			data: JSON.stringify(form),

			dataType: 'json',

			contentType: 'application/json; charset=utf-8'

		}).done(function(response) {

			if (response.status == "ok") {

				pageLoad(1,'penilaian/page_load_out1');

			} else {

				alert(response.caption);

			}

		});

		$("#m_siswa_modif").modal('hide');

	})





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

				url : '<?=base_url('penilaian/multi_delete');?>',

				dataType : 'json',

				data : {

					id : opsi,

				},

				success:function(response){

					if (response.result == true) {

						alert('Hapus Berhasil');

					}else{

						alert('Hapus Gagal');

					}



					pageLoad(1,'penilaian/page_load_out1');

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

			window.location = base_url + 'penilaian/edit/' + $('.checklist:checked').data('id');			

		}



		

	})



	$(document).on('click','.buat-pass',function(){

	

		var y = confirm('Apakah anda yakin untuk membuat password untuk nama ' + $(this).data('nama') +' ?');



		if (y == true) {



			$.ajax({

				type:'post',

				url : '<?=base_url('penilaian/buatkan_password');?>',

				dataType : 'json',

				data : {

					id : $(this).data('id'),

				},

				success:function(response){

					if (response.status == 1) {

						alert(response.message);

					}else{

						alert(response.message);

					}



					pageLoad(1,'penilaian/page_load_out1');

				}

			})





		}else{

			return false;

		}

	})



	$(document).on('click','.reset-pass',function(){

	

		var y = confirm('Apakah anda yakin untuk membuat password untuk nama ' + $(this).data('nama') +' ?');



		if (y == true) {



			$.ajax({

				type:'post',

				url : '<?=base_url('penilaian/reset_password');?>',

				dataType : 'json',

				data : {

					id : $(this).data('id'),

				},

				success:function(response){

					if (response.status == 1) {

						alert(response.message);

					}else{

						alert(response.message);

					}



					pageLoad(1,'penilaian/page_load_out1');

				}

			})





		}else{

			return false;

		}

	})



	$(document).on('click','.aktif-non-akun',function(){

	

		var y = confirm('Apakah anda yakin untuk membuat password untuk nama ' + $(this).data('nama') +' ?');



		if (y == true) {



			$.ajax({

				type:'post',

				url : '<?=base_url('penilaian/aktif_non_akun');?>',

				dataType : 'json',

				data : {

					id : $(this).data('id'),

					status : $(this).data('status')

				},

				success:function(response){

					if (response.status == 1) {

						alert(response.message);

					}else{

						alert(response.message);

					}



					pageLoad(1,'penilaian/page_load_out1');

				}

			})





		}else{

			return false;

		}

	})



</script>









