
						</aside>
					</div>
					<!--/.page-sidebar-->

					<div class="col-md-9 page-content">


						<div class="inner-box">

							<div id="accordion" class="panel-group">
								<?php $this->load->view($p); ?>
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
	<div class="modal fade" id="up_silabus" tabindex="-1" role="dialog">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Upload Silabus</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <p class="text-danger"><small>Maksimal ukuran file 20 MB  </small></p>
	        <small class="text-danger">Format yang diizinkan ( .pdf ) </small>
	        <input type="file" id="silabus_file" name="silabus_file" />
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-primary" id="upload-silabus">Upload<i id="spin-icon" class="ml-2 hide fas fa-spinner"></i></button>
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
	      </div>
	    </div>
	  </div>
	</div>

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