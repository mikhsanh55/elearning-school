

<div class="col-md-9 page-content">
    <div class="inner-box">
        <div class="row align-items-center">
            <div class="col-sm-12 col-md-6 col-lg-6">
                <h2 class="panel-heading">Import Data Pengajar
                <?php echo $this->session->flashdata('notif') ?>
                </h2>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6 text-right">
                <?= $this->backButton; ?>
            </div>
        </div>
        <br><br>
        <div id="accordion" class="panel-group">
            <div class="row">

                <div class="row col-md-12 ini_bodi">
                    <div class="col-md-12 panel panel-info">

                        
                        <div class="panel-body">
                            <form name="f_siswa" action="<?php echo base_url(); ?>import/guru" id="f_siswa" enctype="multipart/form-data" method="post">
                                <table class="table table-form">
                                    <tr><td style="width: 25%">File</td><td style="width: 75%"><input type="file" class="col-md-12 form-control" name="userfile" required></td></tr>
                                    <tr><td></td><td>
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>
                                        <a href="<?php echo base_url(); ?>trainer/data" class="btn btn-default"><i class="fa fa-minus-circle"></i> Kembali</a>
                                    </td></tr>
                                </table>
                            </form>
                        </div>
                    </div>
                </div> 
            </div>
        </div>

    </div>

</div>
</div>
