

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
         </div>

      </div>

      <div class="panel-body">
		<div class="row">
         		<div class="col-md-6 col-sm-12 form-group text-left">
					<label for="">Reset Aktivitas</label>
					<div>
						<button class="btn btn-primary" onclick="resetAktivitas(event, this, 'guru')">Reset</button>
					</div>
				</div>
			</div>
         <table class="table table-bordered table-striped w-100 mx-auto" style="width: 300% !important;" id="datatabel">

            <thead>

               <tr>

                  <th class="text-center align-middle">No</th>
					<th class="text-center align-middle">Nama </th>
					<th class="text-center align-middle">Username</th>
					<th class="text-center align-middle">NUPTK</th>
					
					<th class="text-center align-middle">Jumlah Login</th>
					<th class="text-center align-middle">Jumlah Upload Ujian</th>
					<th class="text-center align-middle">Jumlah Upload Materi</th>
					<th class="text-center align-middle">Jumlah Diskusi</th>
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
	function resetAktivitas(e, self, type) {
		e.preventDefault();
		conf = confirm('Anda yakin akan mereset semua data aktivitas?');
		if(conf) {
			$(self).prop('disabled', true);
			$(self).text('Loading...');
			$.ajax({
				type: 'post',
				url: '<?= base_url('aktivitas/reset') ?>',
				data: {
					type
				},
				dataType: 'json',
				success: function(res) {
					$(self).prop('disabled', false);
					$(self).text('Reset');
					pagination("datatabel", base_url+"aktivitas/data_guru", []);
				}
			});
		}	
		else {
			return false;
		}
	}
	
	$(document).ready(function(){

		pagination("datatabel", base_url+"aktivitas/data_guru", []);

	})

</script>

