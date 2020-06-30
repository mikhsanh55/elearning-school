
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

<!-- menampilkan provinsi, kota, kab -->
<script>
    $(document).ready(function() {
         async function sendRequest(url, param) {
   	        let result;
   	        try {
       	        result = await $.ajax({
       	            type:"POST",
       	            url:url,
       	            data:param,
       	            dataType:"JSON"
       	        });
   	        }
   	        catch(err) {
   	            alert('There is an error!, Please contact your developers');
   	            console.error(err);
   	            return false;
   	        }
   	        
   	        return result;
   	    }
   	    
   	    //   Get Kota
   	   $('#provinsi').change(function(e) {
   	       let id_provinsi = this.value, id_kota = '';
   	       sendRequest("<?= base_url('register/get_kota'); ?>", {id_provinsi:id_provinsi})
   	       .then((data) => {
   	         let html = '';
   	         if(data.status === true)
   	            data.res.forEach(function(d) {
   	                html += `<option value="${d.lokasi_kabupatenkota}"> ${d.lokasi_nama} </option>`;
   	            });
   	            $('#kota_kab').html(html);
   	            
   	            // Get Kecmatan
   	            $('#kota_kab').change(function(e) {
   	                id_kota = this.value;
   	                sendRequest("<?= base_url('register/get_kecamatan'); ?>", {id_kota:id_kota, id_provinsi:id_provinsi})
   	                .then((data2) => {
   	                    if(data2.status === true)
   	                        html = '';
   	                        data2.res.forEach(function(d2) {
   	                            html += `<option value="${d2.lokasi_kecamatan}">${d2.lokasi_nama}</option>`;
   	                        });
   	                        $('#kecamatan').html(html);
   	                });
   	            });
   	       })
   	       .catch(function(e) {
   	           alert('There is an error!, Please contact your developers');
   	            console.error(err);
   	            return false;
   	       });
   	   });
   	   
   	//   Get kota usaha
   	   $('#provinsi_usaha').change(function(e) {
   	       let id_provinsi = this.value, id_kota = '';
   	       sendRequest("<?= base_url('register/get_kota'); ?>", {id_provinsi:id_provinsi})
   	       .then((data) => {
   	         let html = '';
   	         if(data.status === true)
   	            data.res.forEach(function(d) {
   	                html += `<option value="${d.lokasi_kabupatenkota}"> ${d.lokasi_nama} </option>`;
   	            });
   	            $('#kota_kab_usaha').html(html);
   	            
   	            // Get Kecmatan
   	            $('#kota_kab_usaha').change(function(e) {
   	                id_kota = this.value;
   	                sendRequest("<?= base_url('register/get_kecamatan'); ?>", {id_kota:id_kota, id_provinsi:id_provinsi})
   	                .then((data2) => {
   	                    if(data2.status === true)
   	                        html = '';
   	                        data2.res.forEach(function(d2) {
   	                            html += `<option value="${d2.lokasi_kecamatan}">${d2.lokasi_nama}</option>`;
   	                        });
   	                        $('#kecamatan_usaha').html(html);
   	                });
   	            });
   	       })
   	       .catch(function(e) {
   	           alert('There is an error!, Please contact your developers');
   	            console.error(err);
   	            return false;
   	       });
   	   });

    })
</script>