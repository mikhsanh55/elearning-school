<style type="text/css">
	#formKomentar{
		border: 5px solid #d1d1d1;
		width:500px;
		padding:10px;
	}

	input, textarea{
		padding: 10px;
		border:3px solid #e6e6e6;
		border-radius: 5px;
		margin-bottom: 15px; 
	}

	input:focus, textarea:focus{
		border:3px solid #5E4F4F;
	}

	textarea{
		width:100%;
	}

	input[type="submit"]{
		cursor: pointer;
		background: -webkit-linear-gradient(top, #efefef, #ddd);
		background: -moz-linear-gradient(top, #efefef, #ddd);
		background: -ms-linear-gradient(top, #efefef, #ddd);
		background: -o-linear-gradient(top, #efefef, #ddd);
		background: linear-gradient(top, #efefef, #ddd);
		color: #333;
		text-shadow: 0px 1px 1px rgba(255,255,255,1);
		border: 1px solid #ccc;
	}

	input[type="submit"]:hover {
		background: -webkit-linear-gradient(top, #eee, #ccc);
		background: -moz-linear-gradient(top, #eee, #ccc);
		background: -ms-linear-gradient(top, #eee, #ccc);
		background: -o-linear-gradient(top, #eee, #ccc);
		background: linear-gradient(top, #eee, #ccc);
		border: 1px solid #bbb;
	}
	fieldset{width: 100%; padding: 0px,10px;}
	.kotak{
		border: 2px solid #d1d1d1;
		padding: 5px;
		margin:5px 0;
		overflow: hidden;
	}
	.isi-kontent{
		background: #f6faff;
	}

	.suka,.balas{
		background: #d6dbf0;
		padding: 2px;
	}

	.hapus{
		background: #f9d9d9;
		padding: 2px;
	}
	.errors{
		color: #f94d4d;;
		padding: 2px;
	}

</style>
<div class="col-md-9 page-content">


	<div class="inner-box">

		<div id="accordion" class="panel-group">
			<div class="row col-md-12  " >
				<div class="panel panel-info" style="border: 0px solid #000; width: 100%;">
					<div class="panel-heading">
						<div class="tombol-kanan">
							<div class="row align-items-center mb-4">
								<div class="col-sm-12 col-md-6 col-lg-6">
									<h2><strong>Diskusi</strong></h2>		
								</div>
								<div class="col-sm-12 col-md-6 col-lg-6 text-right">
									<button class="btn btn-light" onclick="back_page('materi', true)">Kembali</button>
								</div>
							</div>
							<h3><?=$materi->title;?></h3>
							<h5>Tulis Pertanyaan atau Diskusi !</h5>
							<?php
								if (!empty($jadwal_by->start_date)) {
									$datetime1 = explode(' ', $jadwal_by->start_date);
									$date = shortdate_indo($datetime1[0]);
									$time = time_short($datetime1[1]);
								}else{
									$date = NULL;
									$time = NULL;
								}

								if (!empty($jadwal_by->end_date)) {
									$datetime2 = explode(' ', $jadwal_by->end_date);
									$date2 = shortdate_indo($datetime2[0]);
									$time2 = time_short($datetime2[1]);
								}else{
									$date2 = NULL;
									$time2 = NULL;
								} 
							;?>
							<p><?='Mulai dari Tanggal <b>'.$date.'</b> Waktu <b>'.$time.'</b> Sampai <b>'.$date2.'</b> Waktu <b>'.$time2.'</b>';?></p>
							<?php if (empty($jadwal)): ?>
								<strong style="color:red;">Diskusi di luar jadwal yang di tentukan tidak bisa ikut serta</strong>
							<?php endif;?>
						</div>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12">
								<div id="kontent-komentar"></div>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
<!--/.row-box End-->
<script type="text/javascript">
	$(document).ready(function(){
		var auto_refresh = setInterval(
              function () {
				load_page();
            }, 5000);
	})

	$('#formKomentar').submit(function(e){
		e.preventDefault();

		$.ajax({
			type : 'post',
			url  : '<?=base_url('Materi/insert_koment');?>',
			data : $(this).serialize(),
			success:function(){
				load_page();
			}
		})

		$('#komentartext').val('');
	})

	

	function load_page(){
		$.ajax({
			type : 'post',
			url  : '<?=base_url('Materi/page_komen');?>' + '/<?=$materi->id;?>' +  '/<?=$id_koment;?>',
			success:function(html){
				$('#kontent-komentar').html(html);
			}
		})
	}
</script>



