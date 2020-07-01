<style type="text/css">
.errors {
    color: #ff2121;
    font-weight: bold;
}

.errors-input {
    border: 1px solid #ff2121;
}

.dropdown-menu {
    width: 290px !important;

}
</style>
<?php
		if (!empty($detail->end_date) && $detail->end_date != '0000-00-00 00:00:00') {
			$datetime1 = explode(' ', $detail->end_date);
			$date = longdate_indo($datetime1[0]);
			$time = time_short($datetime1[1]);
		}else{
			$date = NULL;
			$time = NULL;
		}
	
 ;?>
<div class="col-md-9 page-content">
    <div class="inner-box">
        <div class="row">
            <div class="col-md-8" style="border: 0px solid #bfc8c2; padding: 10px;">
                <h2>TUGAS</h2>
                <form id="form-tugas" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="username">Upload File Tugas:</label>
                        <div class="custom-file mb-3">
                            <input type="file" class="custom-file-input" id="attach" name="attach[]" multiple>
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                        <span id="errors-file" class="errors"></span>
                        <div id="attach-file">

                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm" id="save">Upload</button>
                    <button type="button" class="btn btn-danger btn-sm"
                        onclick="back_page('tugas/daftar_tugas')">Kembali</button>
                    <!-- Progress Bar -->
                     <div class="progress d-none mt-4" id="progress-container">
                         <div id="progressBar" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                            <span class="sr-only">0%</span>
                        </div>
                     </div>
                     <div class="alert text-left d-none" id="progress-msg"></div>
                </form>
            </div>
            <div class="col-md-4" style="border: 2px solid #f7f7f7; padding: 10px;">
                <table border="0" style="padding: 5px;">
                    <tr>
                        <th>Modul Pelatihan</th>
                    </tr>
                    <tr>
                        <td><?=$detail->nama_mapel;?></td>
                    </tr>
                    <tr>
                        <th><?=$this->transTheme->guru;?></th>
                    </tr>
                    <tr>
                        <td><?=$detail->nama_trainer;?></td>
                    </tr>
                    <tr>
                        <th>Waktu Selesai</th>
                    </tr>
                    <tr>
                        <td><?=$date;?> Jam <?=$time;?></td>
                    </tr>
                    <tr>
                        <th>Keterangan</th>
                    </tr>
                    <tr>
                        <td><?=$detail->keterangan;?></td>
                    </tr>
                </table>
                <br>


                <div class="btn-group dropright">
                    <button type="button" class="btn btn-default">Lampiran File</button>
                    <button type="button" class="btn btn-default dropdown-toggle dropdown-toggle-split"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
				
                    <div class="dropdown-menu" style="padding:10px 5px;">
                        <ul>
						<li>File</li>
                            <?php foreach ($attach as $key => $val):?>

                            <li><a href="<?=base_url('tugas/get_file/?file='.encrypt_url('assets/tugas/attach/'.$val->file));?>">
                                    <div class="dropdown-divider"></div>
                                    <p><i class="<?=$type[$val->format];?>"
                                            style="color: <?=$color[$val->format];?>; font-size: 20px;"></i>
                                        <?=$val->file;?></p>
                                </a></li>

                            <?php endforeach;?>

                        </ul>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

<<script src="<?= base_url(); ?>assets/js/jquery/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		listAttach();

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

	$(document).on('submit','#form-tugas',function(event){
		event.preventDefault();
        // Check file exist
        if($('#attach').get(0).files.length == 0) {
            alert('Harap pilih file yang hendak diupload!')
            return false
        }
		var valid = false;
		var error = 0;

		$("#save").prop('disabled', true).html('<i class="fas fa-spinner ml-2 spin-icon"></i>');
        $('#progressBar').removeClass('bg-danger').text('')
		if (error == 0) {

		var form = $('#form-tugas')[0];

		// Create an FormData object 
		var data = new FormData(form);
		data.append('id_tugas','<?=$detail->id;?>')

		// If you want to add an extra field for the FormData
		//data.append("CustomField", "This is some extra data, testing");
        // $('#progressBar').css('width', 0 + '%').addClass('bg-primary');
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
				url  : '<?=base_url('tugas/insert_attach_siswa');?>',
				enctype: 'multipart/form-data',
				processData: false,
				contentType: false,
				cache: false,
				dataType : 'json',
				data : data,
				success:function(response) {
                    $("#save").html('Upload').prop("disabled", false);
					if(response.status == 0){
						$('#errors-file').html(response.info);
                        $('#progressBar').text('Something wrong when create Tugas').addClass('bg-danger');
                        $('input[type=file]').val('')
                        
                        return false
					}else{
						$('#errors-file').html('');
						 listAttach();
					}
				},
                error: function() {
                    $("#save").html('Upload').prop("disabled", false);
                    $('#progressBar').text('Something wrong when upload file').addClass('bg-danger');
                    setTimeout(() => {
                        $('#progress-container').addClass('d-none');
                        $('#progressBar').removeClass('bg-success').attr('aria-valuenow', 0).css('width', 0 + '%').text('');
                    }, 3000)
                }
			}).done(() => {
                setTimeout(() => {
                    $('#progress-container').addClass('d-none');
                    $('#progressBar').removeClass('bg-success').attr('aria-valuenow', 0).css('width', 0 + '%').text('');
                }, 3000)
            })
		}

	})

	$(document).on('click','.delete-file',function(){
		
		var y = confirm('Apakah anda yakin menghapus file?');
	
		if (y == true) {

			$.ajax({
				type :'post',
				url  : base_url + 'tugas/attach_file_delete_siswa',
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
				url  : base_url + 'tugas/get_attach_list_siswa',
				data :{
					id_tugas : '<?=$detail->id;?>',
				},
				success:function(response){
					$('#attach-file').html(response);
				}
			})
		}

</script>