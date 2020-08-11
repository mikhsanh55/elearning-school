<style>

	.label-isi{

		color: #000;

		line-height: 28px;

		padding-left:10px;

		border:1px solid #e8e8e8;

		border-radius:10px;

	}

</style>

<div class="col-md-12 page-content">

	<div class="inner-box">

		<div class="row align-items-center">

            <div class="col-sm-12 col-md-6 col-lg-6">

                <h2><?=(empty($edit->id)) ? 'Tambah' : 'Update' ;?> Mata Pelajaran</h2>
            </div>

            <div class="col-sm-12 col-md-6 col-lg-6 text-right">

                <button class="btn btn-light" onclick="back_page('kelas')">Kembali</button>

            </div>

        </div>

		<div id="accordion" class="panel-group">

			<div class="row">

				<div class="col-md-12">

					<div class="panel panel-info">

						<div class="panel-heading">

							<div class="row">

							<div class="col-md-6 form-group">

								<label>Wali Kelas</label>

								<div class="label-isi" >

									<?=$kelas->nama_guru;?>

									<div class="select-dropdown"></div>

								</div>

							</div>

							<div class="col-md-6 form-group">

								<label><?= $this->name; ?></label>

								<div class="label-isi" >

									<?=$kelas->nama;?>

									<div class="select-dropdown"></div>

								</div>

							</div>

							



							</div>

				

						</div>

					</div>

					<from class="form-inline" style="display: block;">
						<input type="hidden" id="kelas-id" value="<?= $kelas->id; ?>">
						<div class="form-group">

							<label for="search">Search&nbsp;&nbsp;</label>
								<select id="filter-murid" class="form-control input-sm">
									<?php foreach ($searchFilter as $key => $val): ?>
										<option value="<?=$key;?>"><?=$val;?></option>
									<?php endforeach ?>
								</select>

							<input type="text" style="width: 50%;" class="form-control input-sm" id="search-murid" placeholder="ketikan nama yang anda cari" name="search">

						</div>

					</from>

					<br>

				</div>

			</div>

		</div>

		<div class="row">

			<div class="col-md-12">
				Limit 
				<select id="limit-murid">
					<option value="10">10</option>
					<option value="50">50</option>
					<option value="100">100</option>
				</select>
				<div id="table-setting-modal"></div>
			</div>

		</div>

	</div>



</div>

</div>

<!--/.row-box End-->
<script>

    $(document).ready(function(){

        // pageLoad(1,'kelas/page_load_mapel');
        pageLoadModal(1, `${base_url}/kelas/page_load_mapel`, {
            pg: 1,
            limit: $('#limit-murid').val(),
            search: $('#search-murid').val(),
            filter: $('#filter-murid').val(),
            id_kelas: $('#kelas-id').val(),
        }, '#table-setting-modal');



        $('#limit-murid').change(function(){

            pageLoadModal(1, `${base_url}/kelas/page_load_mapel`, {
	            pg: 1,
	            limit: $('#limit-murid').val(),
	            search: $('#search-murid').val(),
	            filter: $('#filter-murid').val(),
	            id_kelas: $('#kelas-id').val(),
	        }, '#table-setting-modal');

        });



        $('#search-murid').keyup(delay(function (e) {
            pageLoadModal(1, `${base_url}/kelas/page_load_modal`, {
	            pg: 1,
	            limit: $('#limit-murid').val(),
	            search: $('#search-murid').val(),
	            filter: $('#filter-murid').val(),
	            id_kelas: $('#kelas-id').val(),
	        }, '#table-setting-modal');

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





    $('#aktifkan_semua').click(function(){

        set_all(1);

    })



    $('#nonaktifkan_semua').click(function(){

        set_all(2);

    })



    function set_all(aksi){
        $.ajax({

            type : 'post',

            url  : "<?= base_url('kelas/update_kelas_all'); ?>",

            data :{

                id_kelas : $('#kelas-id').val(),

                aksi : aksi

            },
            success:function(response){

                pageLoadModal(1, `${base_url}/kelas/page_load_modal`, {
		            pg: 1,
		            limit: $('#limit-murid').val(),
		            search: $('#search-murid').val(),
		            filter: $('#filter-murid').val(),
		            id_kelas: $('#kelas-id').val(),
		        }, '#table-setting-modal');
                window.location.reload()
            }

        })

    }
</script>

