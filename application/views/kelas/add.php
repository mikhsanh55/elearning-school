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

		<div class="row align-items-center">

            <div class="col-sm-12 col-md-6 col-lg-6">

                <h2><?=(empty($edit->id)) ? 'Tambah' : 'Update' ;?> <?= $this->name; ?></h2>



            </div>

            <div class="col-sm-12 col-md-6 col-lg-6 text-right">

                <button class="btn btn-light" onclick="back_page('kelas', true)">Kembali</button>

            </div>

        </div>

		

		<section id="display-error"></section>

		<form id="form-kelas" method="post">

		<div class="row">

			<div class="form-group col-md-6">

				<label for="mapel">Wali Kelas</label>

				

					<select name="id_trainer" id="id_trainer" style="width: 70%;" required class="form-control">

						<option disabled="disabled" value="null" selected="selected">Pilih</option>

						<?php 

						$id_trainer = (empty($edit->id_trainer)) ? NULL : $edit->id_trainer;

						foreach ($guru as $rows): ?>

							<option value="<?=$rows->id;?>" <?=($id_trainer == $rows->id) ? 'selected="selected"' : '';?> ><?=$rows->nama;?></option>

						<?php endforeach ?>


					</select>


			</div>

			<div class="form-group col-md-6">

				<!-- <label for="mapel">Mata Pelajaran</label>
				
				<div class="dropdown show">
				  <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width:80%;text-align: left;">
				    Pilih Mata Pelajaran
				  </a>

				  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="width: 80%;">
				  	<?php 
				  	if(!empty($edit)) {
				  	$id_mapel = explode(',', $edit->id_mapel);
				  	$count = 0;$i = 0;
				  	foreach($mapel as $x => $m) : 
				  		if($count < count($id_mapel)) {
				  	?>
						
					    <div style="cursor: pointer;">
					    	<?php if($m->id == $id_mapel[$i] ) { $count++;$i++;?>
					    	<input type="checkbox" name="mapel[]" value="<?= $m->id; ?>"
					    		checked
					    	><?= $m->nama; ?>
					    	<?php } else { ?>
					    		<input type="checkbox" name="mapel[]" value="<?= $m->id; ?>" ><?= $m->nama; ?>
					    	<?php } ?>
					    </div>
						<?php 
						} else { ?>
							<div style="cursor: pointer;">
						    	<input type="checkbox" name="mapel[]" value="<?= $m->id; ?>"><?= $m->nama; ?>
						    </div>
						<?php } 
					endforeach;
					} else { 
						foreach($mapel as $x => $m) :?>

						<div style="cursor: pointer;">
					    	<input type="checkbox" name="mapel[]" value="<?= $m->id; ?>"><?= $m->nama; ?>
					    </div>		
				    <?php endforeach;
				     } ?>
				  </div>
				</div> -->
				

			</div>

			</div>

			<div class="form-group">

				<label for="nama">Nama <?= $this->name; ?>:</label>

				<input type="text" value="<?=(empty($edit->nama)) ? NULL : $edit->nama ;?>" class="form-control" id="nama" placeholder="Masukan Nama Kelas" name="nama" required="" maxlength="150">

			</div>

			<div class="form-group">

				<label for="username">Keterangan:</label>

				<textarea id="keterangan" name="keterangan" class="form-control" placeholder="Keterangan kelas"><?=(empty($edit->keterangan)) ? NULL : $edit->keterangan ;?></textarea>

				<span id="errors-username" class="errors"></span>

			</div>

			

			<input type="hidden" id="id" name="id" value="<?=(empty($edit->id)) ? NULL : $edit->id ;?>">

			<button type="submit" class="btn btn-primary">Simpan</button>

			<button type="button" class="btn btn-danger" onclick="back_page('kelas')">Kembali</button>

		</form>

		

		

	</div>



</div>

</div>

<!--/.row-box End-->

<script src="<?= base_url(); ?>assets/js/jquery/jquery-3.3.1.min.js"></script>

<script type="text/javascript">

	$(document).ready(function(){



		function get_mapel(){

			$.ajax({

					type : 'post',

					url  : base_url + 'kelas/get_mapel',

					dataType : 'json',

					data : {

						id_trainer : $('#id_trainer')[0].value,

						id_mapel : '<?=(empty($edit->id_mapel)) ? NULL : $edit->id_mapel ;?>'

					},

					success:function(response) {

						$('#mapel').html(response.select);

					}

				})

		}

		get_mapel();



	})



	$(document).on('submit','#form-kelas',function(event){

		event.preventDefault();

		var valid = false;

		var error = [], errorMsg = '';

		var id = $('#id').val();

        //  Validation		

		if($('#id_trainer')[0].value == null) {

		    error.push('Harap pilih Pengajar!');

		}

		if (id == '') {

			var link = '<?=base_url('kelas/insert');?>';

		} else {

			var link = '<?=base_url('kelas/update');?>';

		}

		console.warn(error)

		if (error.length == 0) {

			$.ajax({

				type : 'post',

				url  : link,

				dataType : 'json',

				data : $(this).serialize(),

				success:function(response) {

					// alert(response.message);

					if(response.result == true){

						back_page('kelas');

					}else{

						window.reload();

					}

				}

			})

		}

		else {

		    console.log(errorMsg)

		    for(let i = 0;i < error.length;i++) {

		        errorMsg += `<div class="alert alert-danger"><small>${error[i]}</small></div>`

		    }

		    

		    $('#display-error').fadeIn().html(errorMsg)

		    

		    setTimeout(() => {

		        $('#display-error').fadeOut() 

		    }, 3000)

		    

		}



	})



	$(document).on('change','#id_trainer',function(){

		$.ajax({

				type : 'post',

				url  : base_url + 'kelas/get_mapel',

				dataType : 'json',

				data : {

					id_trainer : $(this).val(),

					id_mapel : '<?=(empty($edit->id_mapel)) ? NULL : $edit->id_mapel ;?>'

				},

				success:function(response) {

					$('#mapel').html(response.select);

				}

			})

	})



	



</script>











