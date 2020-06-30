

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

         <table class="table table-bordered table-striped w-100 mx-auto" style="width: 300% !important;" id="datatabel">

            <thead>

               <tr>

                  <th class="text-center align-middle">No</th>
					<th class="text-center align-middle">Nama </th>
					<th class="text-center align-middle">Username</th>
<<<<<<< HEAD
					<th class="text-center align-middle">NIDN</th>
					<th class="text-center align-middle">NRP</th>
					<th class="text-center align-middle">Lembaga</th>
					<th class="text-center align-middle">Semester</th>
					<th class="text-center align-middle">Jumlah Diskusi</th>
					<th class="text-center align-middle">Aktif Login</th>
					<th class="text-center align-middle">Terakhir Login</th>

=======
					<th class="text-center align-middle">NUPTK</th>
					<th class="text-center align-middle">NISN</th>
					<th class="text-center align-middle">Lembaga</th>
					<th class="text-center align-middle">Semester</th>
					<th class="text-center align-middle">Jumlah Login</th>
					<th class="text-center align-middle">Jumlah Upload Materi</th>
					<th class="text-center align-middle">Jumlah Diskusi</th>
>>>>>>> first push
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

		pagination("datatabel", base_url+"aktivitas/data_guru", []);

	})

</script>

