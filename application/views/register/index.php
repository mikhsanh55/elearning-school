
    <div class="main-container">
    	<div class="container">
    		<div class="row">
    			<div class="col-md-8 page-content">
    				<div class="inner-box category-content">
    					<h2 class="title-2"><i class="icon-user-add"></i> Data Diri </h2>
    						<?php
								$pesan = $this->session->flashdata('pesan');
								if (isset($pesan)) { ?>
									<h4><?php echo $this->session->flashdata('pesan'); ?></h4>
								<?php }
								?>
    					<div class="row">
    						<div class="col-sm-12">
    							<form class="form-horizontal" method="post" action="<?= base_url('register/tambah'); ?>">
    									<div class="form-group  row required">
    										<label class="col-md-4 control-label">Nama Lengkap <sup>*</sup></label>
    										<div class="col-md-6">
    											<input name="nama" id="nama" placeholder="Masukan Nama" class="form-control input-md" required="" type="text">
    											<?= form_error('nama', '<small class="text-danger pl-3">', '</small>'); ?>
    										</div>
    									</div>


    									<div class="form-group  row required">
    										<label class="col-md-4 control-label">Jenis Kelamin<sup>*</sup></label>
    										<div class="col-md-6">
    											<select name="kelamin" id="kelamin" class="form-control" required="">
    												<option value="">Select Menu</option>
    												<?php foreach ($jenis as $jk) : ?>
    													<option value="<?= $jk['id']; ?>"><?= $jk['kelamin']; ?> </option>
    												<?php endforeach; ?>
    											</select>
    										</div>
    									</div>
    									<div class="form-group  row required">
    										<label class="col-md-4 control-label">Tanggal Lahir <sup>*</sup></label>

    										<div class="col-md-6">
    											<input name="tanggal" id="tanggal" class="form-control input-md" type="date" required="">
    											<!--<?= form_error('tanggal', '<small class="text-danger pl-3">', '</small>'); ?>-->
    										</div>
    									</div>
    									<!-- PROVINSI -->
    									<div class="form-group row required">
    									    <label class="col-md-4 control-label">Provinsi <sup>*</sup></label>
    									    <div class="col-md-6">
    									        <select name="provinsi" id="provinsi" class="form-control" required>
    									            <?php foreach($provinsi as $p) : ?>
    									                <option value="<?= $p->lokasi_propinsi; ?>"><?= $p->lokasi_nama; ?></option>
    									            <?php endforeach; ?>
    									        </select>
    									    </div>
    									</div>
    									
    									<!-- KOTA/KAB -->
    									<div class="form-group row required">
    									    <label class="col-md-4 control-label">Kota/Kab. <sup>*</sup></label>
    									    <div class="col-md-6">
    									        <select name="kota_kab" id="kota_kab" class="form-control" required>
    									            <option>---</option>
    									        </select>
    									    </div>
    									</div>
    									
    									<!-- KECAMATAN -->
    									<div class="form-group row required">
    									    <label class="col-md-4 control-label">Kecamatan <sup>*</sup></label>
    									    <div class="col-md-6">
    									        <select name="kecamatan" id="kecamatan" class="form-control" required>
    									            <option>---</option>
    									        </select>
    									    </div>
    									</div>
    									
    									<!-- ALAMAT DETAIL -->
    									<div class="form-group  row required">
    										<label class="col-md-4 control-label">Alamat <sup>*</sup></label>
    										<div class="col-md-6">
    											<textarea class="form-textarea" name="alamat" id="alamat" placeholder="Masukan Alamat" required=""></textarea>
    											<!--<?= form_error('alamat', '<small class="text-danger pl-3">', '</small>'); ?>-->
    										</div>
    									</div>
    								
    									<div class="form-group  row required">
    										<label for="inputEmail3" class="col-md-4 control-label">Email
    											<sup>*</sup></label>
    										<div class="col-md-6">
    											<input type="email" name="email" id="email" class="form-control" placeholder="Masukan Email" required="">
    											<!--<?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>-->
    										</div>
    									</div>
    									
    									
    									<div class="form-group  row required">
    										<label for="inputPassword3" class="col-md-4 control-label">No. Telp/Hp </label>
    										<div class="col-md-6">
    											<input type="numeric" name="telp" id="telp" class="form-control" placeholder="Masukan No. Telp/Hp" required="">
    											<!--<?= form_error('telp', '<small class="text-danger pl-3">', '</small>'); ?>-->
    										</div>
    									</div>
    									
    									<br>
    									<h2 class="title-2 mt-4"><i class="icon-user-add"></i> Data Usaha </h2>

    									<div class="form-group  row required">
    										<label class="col-md-4 control-label">Nama Usaha <sup>*</sup></label>
    										<div class="col-md-6">
    											<input name="ukm" id="ukm" placeholder="Masukan nama usaha anda" class="form-control input-md" required="" type="text">
    											<!--<?= form_error('ukm', '<small class="text-danger pl-3">', '</small>'); ?>-->
    										</div>
    									</div>
                                        <!-- PROVINSI USAHA -->
    									<div class="form-group row required">
    									    <label class="col-md-4 control-label">Provinsi <sup>*</sup></label>
    									    <div class="col-md-6">
    									        <select name="provinsi_usaha" id="provinsi_usaha" class="form-control" required>
    									            <?php foreach($provinsi as $p) : ?>
    									                <option value="<?= $p->lokasi_propinsi; ?>"><?= $p->lokasi_nama; ?></option>
    									            <?php endforeach; ?>
    									        </select>
    									    </div>
    									</div>
    									
    									<!-- KOTA/KAB USAHA -->
    									<div class="form-group row required">
    									    <label class="col-md-4 control-label">Kota/Kab. <sup>*</sup></label>
    									    <div class="col-md-6">
    									        <select name="kota_kab_usaha" id="kota_kab_usaha" class="form-control" required>
    									            <option>---</option>
    									        </select>
    									    </div>
    									</div>
    									
    									<!-- KECAMATAN USAHA -->
    									<div class="form-group row required">
    									    <label class="col-md-4 control-label">Kecamatan <sup>*</sup></label>
    									    <div class="col-md-6">
    									        <select name="kecamatan_usaha" id="kecamatan_usaha" class="form-control" required>
    									            <option>---</option>
    									        </select>
    									    </div>
    									</div>
    									
    									<div class="form-group  row required">
    										<label class="col-md-4 control-label">Alamat <sup>*</sup></label>

    										<div class="col-md-6">
    											<textarea class="form-textarea" name="alamat_usaha" id="aukm" placeholder="Masukan Alamat" required=""></textarea>
    											<!--<?= form_error('aukm', '<small class="text-danger pl-3">', '</small>'); ?>-->
    										</div>
    									</div>

    									
    									<div class="form-group  row required">
    										<label class="col-md-4 control-label">Jenis Usaha <sup>*</sup></label>

    										<div class="col-md-6">
    											<!--<input name="jenis" id="jenis" placeholder="Masukan Jenis Usaha" class="form-control input-md" required="" type="text">-->
    											<!--<?= form_error('jenis', '<small class="text-danger pl-3">', '</small>'); ?>-->
    											<select name="jenis_usaha" class="form-control">
    											    <?php foreach($jenis_usaha->result() as $ju) : ?>
    											        <option value="<?= $ju->value; ?>"><?= $ju->nama; ?></option>
    											    <?php endforeach;?>
    											</select>
    											<!--<table>-->
                                                    
    											<!--    <tr>-->
    											<!--        <td><label class="checkbox-inline ml-2"><input class="mr-2" type="checkbox" name="jenis_usaha[]" value="<?= $ju->value; ?>"><?= $ju->nama; ?></label></td>-->
    											        <!-- <td><label class="checkbox-inline ml-2"><input class="mr-2" type="checkbox" name="jenis_usaha[]" value="fashion">Fashion</label></td> -->
    											<!--    </tr>-->
                                                    
    											    
    											<!--</table>-->
    											<div class="row d-flex justify-content-around">
    											
                                                
                                                
                                                
                                                </div>
                                                <div class="row d-flex">
    											
                                                
                                                
                                                </div>
                                                <div class="row d-flex justify-content-start align-items-center">
                                                    
                                                    
                                                </div>
    										</div>
    									</div>
    									

    									<div class="form-group  row required">
    										<label for="inputEmail3" class="col-md-4 control-label">Omset Penjualan per tahun
    											<sup>*</sup></label>
    										<div class="col-md-6">
    										    
									            <div class="radio">
                                                  <label class="ml-2 mr-2 radio-inline"><input type="radio" name="omset" value="< 10 Juta" checked>&nbsp;&nbsp; < 10 Juta</label>
                                                  <label class="ml-2 mr-2 radio-inline"><input type="radio" name="omset" value="< 20 Juta" checked>&nbsp;&nbsp; < 20 Juta</label>
                                                  <label class="ml-2 mr-2 radio-inline"><input type="radio" name="omset" value="< 50 Juta" checked>&nbsp;&nbsp; < 50 Juta</label>
                                                </div>
    											
    											<!--<?= form_error('omset', '<small class="text-danger pl-3">', '</small>'); ?>-->
    										</div>
    									</div>
    									

    									<div class="form-group  row required">
    										<label class="col-md-4 control-label">Tahun Berdiri <sup>*</sup></label>
    										<div class="col-md-6">
    											<input name="berdiri" id="berdiri" class="form-control input-md" required="" type="number" min="1000" max="2099" value="2019">
    											<!--<?= form_error('berdiri', '<small class="text-danger pl-3">', '</small>'); ?>-->
    										</div>
    									</div>
    									
    									<br>
    									<div class=" form-group col-md-12 text-center">
    										<div style="clear:both"></div>
    										<button class="btn btn-primary" type="submit">Tambahkan</button>
    									</div>

    									<!--<div class="form-group row">-->
    									<!--	<label class="col-md-4 control-label"></label>-->
    									<!--	<div class="col-md-8">-->
    									<!--		<div class="termbox mb10">-->
    									<!--			<div class="col-auto my-1 no-padding">-->
    									<!--				<div class="custom-control custom-checkbox mr-sm-2" style="margin-top: 30px;">-->
    									<!--				</div>-->
    									<!--			</div>-->
    									<!--		</div>-->
    									<!--	</div>-->
    									<!--</div>-->
    									
    									
    							</form>
    						</div>
    					</div>



    					<div class="row">
    						<div class="col-sm-12">

    						</div>
    					</div>
    				</div>
    			</div>


    			<div class="col-md-4 reg-sidebar">
    				<div class="reg-sidebar-inner text-center">
    					<div class="promo-text-box"><i class=" icon-picture fa fa-4x icon-color-1"></i>
    						<h3><strong>Berkarya</strong></h3>
    						<p> Membuat sesuatu yang berguna untuk orang lain </p>
    					</div>
    					<div class="promo-text-box"><i class=" icon-pencil-circled fa fa-4x icon-color-2"></i>
    						<h3><strong> Mempelajari </strong></h3>
    						<p> Peka melihat ilmu baru dan sangat mau mempelajarinya </p>
    					</div>
    					<div class="promo-text-box"><i class="  icon-heart-2 fa fa-4x icon-color-3"></i>
    						<h3><strong> Berbisnis </strong></h3>
    						<p> Memanfaatkan segala peluang hingga yang ada hanya keuntungan </p>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
