<style type="text/css">
	.errors{
		color: #ff2121;
		font-weight: bold;
	}
	.errors-input{
		border: 1px solid #ff2121;
	}
</style>
<div class="col-md-9 page-content">
	<div class="inner-box">
		<h2>Tambah Tugas</h2>
		<form id="form-akun-lembaga" method="post" enctype="multipart/form-data">
			<!-- <input type="hidden" name="mapel" value="" id="mapel" /> -->
			<input type="hidden" name="guru" value="<?= $this->akun->id; ?>">
			<div class="form-group">
				<label for="lembaga">Kelas<span class="text-danger">*</span></label>
				<div class="rs-select2 js-select-simple select--no-search">
					<select name="kelas" id="kelas" style="width: 30%;" required>
						<option disabled="disabled" value="null" selected="selected">Pilih</option>
							
							<?php foreach ($kelas as $rows): 
								// $mapel = $this->m_mapel->get_by(['id' => $rows->id_mapel]);
							?>
								<option value="<?=$rows->id;?>" data-mapel="<?= $rows->id_mapel; ?>"><?=$rows->nama ;?></option>
							<?php endforeach ?>
					</select>
					<div class="select-dropdown"></div>
				</div>
			</div>
			<div class="form-group">
				<label for="">Mata Pelajaran</label>
				<div class="rs-select2 js-select-simple select--no-search">
					<select name="mapel" id="mapel" style="width: 30%;" required>
						<option disabled="disabled" value="null" selected="selected">Pilih</option>
							<!-- <?php foreach ($mapel as $rows): ?>
								<option value="<?=$rows->id_mapel;?>"><?=$rows->nama_mapel;?></option>
							<?php endforeach ?> -->
					</select>
					<div class="select-dropdown"></div>
			</div>
			<div class="form-group">
				<label for="nama">Keterangan</label>
				<textarea  class="form-control" id="keterangan" placeholder="Masukan Keterangan" name="keterangan" ></textarea>
			</div>
			<div class="form-group">
				<label for="username">Tugas Lampiran<span class="text-danger">*</span></label>
				<div class="custom-file mb-3">
					<input type="file" class="custom-file-input" id="attach" name="attach[]" multiple>
					<label class="custom-file-label" for="customFile">Choose file</label>
				</div>
				<span id="errors-file" class="errors"></span>
			</div>
			<div class="form-group">
				<label for="end_date">Tanggal Pengumpulan<span class="text-danger">*</span></label>
				<input class="form-control js-datepicker" type="text" id="end_date" name="end_date"  required >
			</div>
			<div class="form-group">
				<label for="end_time">Waktu Pengumpulan<span class="text-danger">*</span></label>
				<input class="form-control" type="time" id="end_time" name="end_time"  required="">
			</div>
			
			<button type="submit" class="btn btn-primary" id="save">Simpan</button>
			<button type="button" class="btn btn-danger" onclick="back_page('tugas')">Kembali</button>
			<br>
			<!-- Progress Bar -->
             <div class="progress d-none mt-4" id="progress-container">
                 <div id="progressBar" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
					<span class="sr-only">0%</span>
				</div>
             </div>
             <div class="alert text-left d-none" id="progress-msg"></div>
		</form>
		
	</div>

</div>
</div>
<!--/.row-box End-->
<script src="<?= base_url(); ?>assets/js/jquery/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('input[type="file"]').change(function(e){
            var fileName = e.target.files[0].name;
  			var extensions = ['pdf', 'pdfx', 'doc', 'docx', 'jpeg', 'jpg', 'png', 'zip', 'rar', 'ppt', 'pptx', 'xlsx', 'xls'];
  			if ($.inArray($(this).val().split('.').pop().toLowerCase(), extensions) == -1) {
	            alert("Format yang diperbolehkan : "+extensions.join(', '));
	            $(this).val('')
	        }
            var files = e.target.files; 
            var name = '';

            for (var i = 0, file; file = files[i]; i++) {
            	console.log(file);
            	name += file.name + ',';
            }
            $('.custom-file-label').text(name)
   
        });

        $('#kelas').change(function() {
        	// $('#mapel').val($('#kelas option:selected').data('mapel'))
        	var id_kelas = $(this).val()
        	$.ajax({
        		type: 'post',
        		url: "<?= base_url('mapel/get_mapel') ?>",
        		data: {
        			id_kelas
        		},
        		success:function(res) {

        			// res.opsi.forEach(function(item, i) {
        			// 	html += `<option value="${item.id}">${item.nama}</option>`
        			// })

        			$('#mapel').html(res)
        		}
        	})

        })
	
		// Add Tugas Event
		$(document).on('submit','#form-akun-lembaga',function(event){
			event.preventDefault();
			if($('#kelas').val() == null) {
				alert('Harap pilih kelas');
				return false;
			}

			var valid = false;
			var error = 0;

			$("#save").prop('disabled', true).html('<i class="fas fa-spinner ml-2 spin-icon"></i>');

			if (error == 0) {

			var form = $('#form-akun-lembaga')[0];

			// Create an FormData object 
			var data = new FormData(form);

			// Set default length for progress bar
			$('#progress-container').removeClass('d-none');
			$('#progressBar').attr('aria-valuenow', 0).css('width', 0 + '%').text(0 + '%').removeClass('bg-danger');
				$.ajax({
					 xhr:function() {
				        let xhr = new window.XMLHttpRequest();
				        
				        xhr.upload.addEventListener("progress", function(e) {
				            if(e.lengthComputable) {
				                let percentComplete = e.loaded / e.total;
				                console.log(percentComplete);
				                // console.log('e.total : ' . e.total);
				                percentComplete = parseInt(percentComplete * 100);
				                $('#progress-container').removeClass('d-none');
				                $('#progressBar').attr('aria-valuenow', percentComplete).css('width', percentComplete + '%').text(percentComplete + '%');
				                if(percentComplete == 100) {
				                    $('#progressBar').text('Complete!').addClass('bg-success');
				                }
				            }
				        }, false);
				        
				        return xhr;
				    },
					type : 'post',
					url  : '<?=base_url('tugas/insert');?>',
					enctype: 'multipart/form-data',
					processData: false,
					contentType: false,
					cache: false,
					dataType : 'json',
					data : data,
					success:function(response) {
						$("#save").html('Simpan').prop("disabled", false);
						if(response.status == 0){
							$('#errors-file').html(response.info);
							$('#progressBar').text('Something wrong when create Tugas').addClass('bg-danger');
							$('input[type=file]').val('')
							
							return false
						}else{
							window.location = '<?=base_url('tugas');?>'
						}

						

					},
					error: function(res) {
						$('#progressBar').text('Something wrong when create Tugas').addClass('bg-danger');
					}
				})
			}

		})
	})
</script>





