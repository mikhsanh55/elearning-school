<div class="row col-md-12 ini_bodi">
    <div class="col-md-12 panel panel-info">
        <div class="panel-heading">Import Data Siswa
        <?php echo $this->session->flashdata('notif') ?>
        </div>
        <div class=" panel-body">
            <form name="f_siswa" action="<?php echo base_url(); ?>import/siswa" id="f_siswa" enctype="multipart/form-data" method="post">
                <input type="hidden" name="id" id="id" value="0">
                <table class="table table-form">
                    <tr><td style="width: 25%">File</td><td style="width: 75%"><input type="file" class="form-control col-md-12" name="userfile" required></td></tr>
                    <tr><td></td><td>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>
                        <a href="<?php echo base_url(); ?>pengusaha/m_siswa" class="btn btn-default"><i class="fa fa-minus-circle"></i> Kembali</a>
                    </td></tr>
                </table>
            </form>
        </div>
    </div>
</div> 