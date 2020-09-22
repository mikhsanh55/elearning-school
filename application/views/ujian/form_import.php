<?php 
$uri4 = $this->uri->segment(4);
?>
<div class="col-md-9 page-content">
    <div class="inner-box">
        <div class="row align-items-center mb-4">
            <div class="col-sm-12 col-md-6 col-lg-6">
                <h2 class="panel-heading">Import Data Soal
                    
                </h2>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6 text-right">
                <a href="<?= base_url('ujian_real/data_soal/') . $this->uri->segment(3); ?>" class="btn btn-light">Kembali</a>
            </div>
        </div>
<div class="row col-md-12 ini_bodi">
    <div class="panel panel-info">
        
        <div class="panel-body">
            <p class="mb-3">
                <?php echo $this->session->flashdata('notif') ?>
            </p>
            <form action="<?= $url_import;?>" id="form-soal-ujian-essay" enctype="multipart/form-data" method="post">
                <input type="hidden" name="id_ujian" id="id" value="<?= $id_ujian; ?>">
                <table class="table table-form">
    
                    <tr><td>File</td><td><input type="file" class="form-control col-md-12" name="userfile" required></td></tr>
                    <tr><td></td><td>
                        <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-upload"></i> Upload</button>
                        <a href="<?=$back_url;?>"  class="btn btn-default btn-block"><i class="fa fa-minus-circle"></i> Kembali</a>
                    </td></tr>
                </table>
            </form>
        </div>
    </div>
</div>
</div>
</div>