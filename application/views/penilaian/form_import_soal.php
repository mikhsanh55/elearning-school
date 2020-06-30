<div class="col-md-9 page-content">
    <div class="inner-box">

        <div id="accordion" class="panel-group">
            <div class="row">
                <div class="col-md-12 panel panel-info">
                    <div class="panel-heading">Import Data Soal Penilaian
                    <?php echo $this->session->flashdata('notif') ?>
                    </div>
                    <div class=" panel-body">
                        <form name="f_siswa" action="<?php echo base_url(); ?>import/soal_penilaian" id="f_siswa" enctype="multipart/form-data" method="post">
                            <input type="hidden" name="id_paket" id="id_paket" value="<?= $id_paket; ?>">
                            <table class="table table-form">
                                <tr><td style="width: 25%">File</td><td style="width: 75%"><input type="file" class="form-control col-md-12" name="userfile" required></td></tr>
                                <tr><td></td><td>
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>
                                    <a href="<?php echo base_url('penilaian/data_soal/') . $id_paket; ?>" class="btn btn-default"><i class="fa fa-minus-circle"></i> Kembali</a>
                                </td></tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>
            