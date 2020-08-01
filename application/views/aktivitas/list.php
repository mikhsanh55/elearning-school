

					</aside>

				</div>

				<!--/.page-sidebar-->



				<div class="col-md-9 page-content">





					<div class="inner-box">



						<div id="accordion" class="panel-group">

							<div class="row col-md-12 ini_bodi">

   <div class="panel panel-info">



      <div class="panel-heading">



         <div class="tombol-kanan">
            <h2><strong><?=$this->page_title;?></strong></h2>

   

            <!--<a class="btn btn-warning btn-sm tombol-kanan" href="<?php echo base_url(); ?>upload/format_import_siswa.xlsx"><i class="glyphicon glyphicon-download"></i> &nbsp;&nbsp;Download Format Import</a>-->

            <!--<a class="btn btn-info btn-sm tombol-kanan" href="<?php echo base_url(); ?>Peserta/m_siswa/import"><i class="glyphicon glyphicon-upload"></i> &nbsp;&nbsp;Import</a>-->

         </div>

      </div>

      <div class="panel-body">
	  <form action="">
			<div class="row">
				<div class="col-md-6 col-sm-12 form-group">
					<label for="">Filter Kelas</label>
					<select name="kelas" id="kelas" class="form-control">
						<option value="0">Pilih Kelas</option>	
					<?php if(count($kelas) > 0) : ?>
						
						<?php foreach($kelas as $kls) : ?>
							<option value="<?= $kls->id; ?>"><?= $kls->nama; ?></option>
						<?php endforeach; ?>
					<?php endif; ?>
					</select>
				</div>
			</div>
		</form>
         <table class="table table-bordered table-striped w-100 mx-auto" style="width: 300% !important;" id="datatabel">

            <thead>

               <tr>

                  <th class="text-center align-middle">No</th>

                  <th class="text-center align-middle">Nama <?= $this->transTheme->siswa;?></th>

                  <th class="text-center align-middle">NIS</th>

                  <th class="text-center align-middle">Kelas</th>

                  <th class="text-center align-middle">Aktif Login</th>

                  <th class="text-center align-middle">Aktif Belajar</th>

                  <th class="text-center align-middle">Aktif Diskusi</th>

                  <th class="text-center align-middle">Aktif Tugas</th>

                  <th class="text-center align-middle">Total Nilai</th>

                  <!-- <th class="text-center align-middle">Detail</th> -->

               </tr>

            </thead>



            <tbody></tbody>

         </table>



      </div>

   </div>

</div>

</div>
						</div>

					</div>

					<!--/.row-box End-->



				</div>

			</div>

			<!--/.page-content-->

		</div>

		<!--/.row-->

	</div>

	<!--/.container-->

</div>

<!-- /.main-container -->

<div id="tampilkan_modal"></div>

<footer class="main-footer">

	<div class="footer-content">

		<div class="container">

			<div class="row">





				<div style="clear: both"></div>



				<div class="col-xl-12">



					<div class="copy-info text-center">

						<?=$this->footer;?>

					</div>



				</div>



			</div>

		</div>

	</div>

</footer>

<!--/.footer-->



</div>

<script type="text/javascript">

	$(document).ready(function(){
		var data
		pagination("datatabel", base_url+"aktivitas/data", []);

		$('#kelas').change(function(e) {
			e.preventDefault()
			$("#datatabel").DataTable().destroy()
			data = {
				kelas: $(this).val()
			}
			pagination("datatabel", base_url + "aktivitas/data", [], data)
		})
	})

</script>

