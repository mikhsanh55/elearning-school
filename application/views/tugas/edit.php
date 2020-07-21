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
		<h2>Edit Tugas</h2>
		<form id="form-akun-lembaga" method="post" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?=$edit->id;?>">
			<div class="form-group">
				<label for="lembaga">Kelas</label>
				<div class="rs-select2 js-select-simple select--no-search">
					<select name="kelas" id="kelas" style="width: 30%;">
						<option disabled="disabled" selected="">Pilih</option>
						<?php foreach ($kelas as $rows): ?>
							<?php if ($edit->id_kelas == $rows->id): ?>
								<option value="<?=$rows->id;?>" selected><?=$rows->nama;?></option>
							<?php else: ?>
								<option value="<?=$rows->id;?>"><?=$rows->nama;?></option>
							<?php endif ?>
						<?php endforeach ?>
					</select>
					<div class="select-dropdown"></div>
				</div>
			</div>
			<div class="form-group">
				<label for="">Mata Pelajaran</label>
				<div class="rs-select2 js-select-simple select--no-search">
					<select name="mapel" id="mapel" style="width: 30%;" required>
						<?php 
						$data_mapel = $this->m_mapel->get_by(['id' => $edit->id_mapel]);
						?>
						<option value="<?= $edit->id_mapel; ?>"><?= !empty($data_mapel) ? $data_mapel->nama : ''; ?></option>
						<!-- <option disabled="disabled" value="null" selected="selected">Pilih</option> -->
							<!-- <?php foreach ($mapel as $rows): ?>
								<option value="<?=$rows->id_mapel;?>"><?=$rows->nama_mapel;?></option>
							<?php endforeach ?> -->
					</select>
					<div class="select-dropdown"></div>
			</div>
			<div class="form-group">
				<label for="nama">Keterangan:</label>
				<textarea  class="form-control" id="keterangan" placeholder="Masukan Keterangan" name="keterangan" required=""><?=$edit->keterangan;?></textarea>
			</div>
			<div class="form-group">
				<label for="username">Lampiran Tugas:</label>
				<div class="custom-file mb-3">
					<input type="file" class="custom-file-input" id="attach" name="file">
					<label class="custom-file-label" for="customFile">Choose file</label>
				</div>
				<span id="errors-username" class="errors"></span>
				<div id="attach-file">
					
				</div>
			</div>

			<?php
					if (!empty($edit->end_date) && $edit->end_date != '0000-00-00 00:00:00') {
						$datetime1 = explode(' ', $edit->end_date);
						$date = shortdate_indo($datetime1[0]);
						$time = time_short($datetime1[1]);
					}else{
						$date = NULL;
						$time = NULL;
					}
				
			 ;?>

			<div class="form-group">
				<label for="end_date">Tanggal Pengumpulan:</label>
				<input class="form-control js-datepicker" type="text" id="end_date" name="end_date" value="<?=$date;?>" required="" readonly="">
			</div>
			<div class="form-group">
				<label for="end_time">Waktu Pengumpulan:</label>
				<input class="form-control" type="time" id="end_time" name="end_time" value="<?=$time;?>" required="">
			</div>

			
			<button type="submit" class="btn btn-primary" id="save">Simpan</button>
			<button type="button" class="btn btn-danger" onclick="back_page('tugas')">Kembali</button>
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
		listAttach();

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
	})

	$(document).on('submit','#form-akun-lembaga',function(event){
		event.preventDefault();
		var valid = false;
		var error = 0;

		$("#save").prop('disabled', true).html('<i class="fas fa-spinner ml-2 spin-icon"></i>');

		if (error == 0) {

		// Create an FormData object 
		var data = new FormData();
		data.append('id', $('#id').val())
		data.append('kelas', $('#kelas').val())
		data.append('mapel', $('#mapel').val())
		data.append('keterangan', $('#keterangan').val())
		if($('#attach').val() != '') {
			data.append('file', $('#attach').val())	
		}
		data.append('end_date', $('#end_date').val())
		data.append('end_time', $('#end_time').val())

		// If you want to add an extra field for the FormData
		//data.append("CustomField", "This is some extra data, testing");

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
				url  : '<?=base_url('tugas/update');?>',
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
					}else{
						window.location = '<?=base_url('tugas');?>'
					}
				}
			})
		}

	})

	$(document).on('click','.delete-file',function(){
		
		var y = confirm('Apakah anda yakin menghapus file?');
	
		if (y == true) {

			$.ajax({
				type :'post',
				url  : base_url + 'tugas/attach_file_delete',
				data : {
					id : $(this).data('id'),
					location : $(this).data('location')
				},
				success:function(response){
					listAttach();
				}
			})


		}else{
			return false;
		}

		
	})

	function listAttach(){
			$.ajax({
				type : 'post',
				url  : base_url + 'tugas/get_attach_list',
				data :{
					id_tugas : '<?=$edit->id;?>',
				},
				success:function(response){
					$('#attach-file').html(response);
				}
			})
		}

</script>





