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
                <?= $this->backButton; ?>
            </div>
        </div>
<div class="row col-md-12 ini_bodi">
    <div class="panel panel-info">
        
        <div class="panel-body">
            <p class="mb-3">
                <?php echo $this->session->flashdata('notif') ?>
            </p>
            <form name="f_siswa" action="<?php echo $url_import;?>" id="f_siswa" enctype="multipart/form-data" method="post">
                <input type="hidden" name="id" id="id" value="0">
                <table class="table table-form">
    
                    <tr><td>File</td><td><input type="file" class="form-control col-md-12" name="userfile" required></td></tr>
                    <tr><td></td><td>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>
                        <a href="<?=$back_url;?>"  class="btn btn-default"><i class="fa fa-minus-circle"></i> Kembali</a>
                    </td></tr>
                </table>
            </form>
        </div>
    </div>
</div>
</div>
</div>