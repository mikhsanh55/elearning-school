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
   </div>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
   	   
   	   //   Get Kota Usaha
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
   	   
   	   
   	   $('#other-field').change(function() {
   	      if(this.checked) {
       	      $('#other-text').removeClass('d-none');
       	      $('#other-text').addClass('d-inline');
       	      $('#other-text').attr('required', true);
   	      }
          else {
              $('#other-text').addClass('d-none');
              $('#other-text').removeClass('d-inline');
              $('#other-text').attr('required', false);
          }
   	   });
   	    
   	});
   </script>
   <script src="<?= base_url(); ?>assets/js/vendors.min.js"></script>
   <script src="<?= base_url(); ?>assets/js/main.min.js"></script>
