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
	.chat-square {
		padding: 14px 10px;
		border-radius: 10px;
	}
	.chat-square::after {

	}
	.chat-modal-footer {	
	    display: -ms-flexbox;
	    display: flex;
	    -ms-flex-align: center;
	    align-items: center;
	    -ms-flex-pack: end;
	    justify-content: space-between;
	    padding: 1rem;
	    border-top: 1px solid #e9ecef;
	}
	@media screen and (min-width: 600px) {
		#chat-input {
			width: 150% !important;
		}
	}
	@media screen and (min-width: 768px) {
		#chat-input {
			width: 350% !important;
		}
	}
	@media screen  and (min-width: 1096	px) {
		#chat-input {
			width: 430% !important;
		}	
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
								<h2><strong>Data Tugas</strong></h2>
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
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="disclaimer-tugas">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
		<!-- Head -->
       	<div class="modal-header">
	      <h5 class="modal-title" id="exampleModalLabel">Saya Berjanji</h5>
	      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        <span aria-hidden="true">&times;</span>
	      </button>
	    </div>

    	<!-- Body -->
    	<div class="modal-body">
    		<p>
    			Saya mengerjakan tugas ini dengan penuh kejujuran dan tanggung jawab. 
Bila suatu saat diketahui tugas saya merupakan hasil plagiarisme atau menyontek, maka saya akan menerima segala konsekuensi/sanksi yang diberikan oleh bapak/ibu guru.
    		</p>
    	</div>
    	<!-- Footer -->
    	<div class="modal-footer">
	       <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
	       <a href="" id="link-tugas" class="btn btn-primary">Saya Berjanji</a>
	    </div>

    </div>
  </div>
</div>

<!-- Modal Chat dari guru -->
<div class="modal" tabindex="-1" role="dialog" id="ingatkan-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      	<div>
        <h4 class="modal-title nama-guru">Guru</h4>
        <p class="nama-mapel">Mapel</p>
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
        	<div class="col-md-6 col-sm-10 align-self-start" id="chat-place">
        		<!-- Content of Message Here -->
        	</div>
        </div>
      </div>
      <div class="chat-modal-footer">
      	<button class="btn btn-light btn-block" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!--/.row-box End-->
<script src="<?= base_url(); ?>assets/js/jquery/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		pageLoad(1,'tugas/page_load_list_tugas');

		$('#limit').change(function(){
			pageLoad(1,'tugas/page_load_list_tugas');
		});

		$('#filter').change(function(){
			pageLoad(1,'tugas/page_load_list_tugas');
		})

		$('#search').keyup(delay(function (e) {
			pageLoad(1,'tugas/page_load_list_tugas');
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
	});

	function pageLoad(pg, url, search){
		$.ajax({
			type : 'post',
			url  : '<?php echo base_url() ?>' + url + '/' + pg,
			data :{
				pg    : pg,
				limit : $('#limit').val(),
				filter : $('#filter').val(),
				search : $('#search').val(),
			},
			success:function(response){
				$('#content-view').html(response);
			}
		});
	}

	$(document).on('submit','#form-siswa',function(e){
		e.preventDefault()
		var f_asal	= $(this);
		var form	= getFormData((f_asal));
		$.ajax({		
			type: "POST",
			url: base_url+"tugas/m_siswa/simpan",
			data: JSON.stringify(form),
			dataType: 'json',
			contentType: 'application/json; charset=utf-8'
		}).done(function(response) {
			if (response.status == "ok") {
				pageLoad(1,'tugas/page_load_list_tugas');
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
				url : '<?=base_url('tugas/multi_delete');?>',
				dataType : 'json',
				data : {
					id : opsi,
				},
				success:function(response){
					if (response.result == true) {
						pageLoad(1,'tugas/page_load_list_tugas');
					}else{
						alert('Hapus Gagal');
					}					
				}
			});

		}else{
			return false;
		}

		
	})

	$(document).on('click','.kirim-tugas',function(self){
		var urlTugas = base_url + 'tugas/lampiran_siswa/' + $(this).data('id_tugas')
		$('#link-tugas').attr('href', urlTugas)
		$('#disclaimer-tugas').modal('show')
	})

</script>




