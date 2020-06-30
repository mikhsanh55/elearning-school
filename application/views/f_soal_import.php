<?php 
$uri4 = $this->uri->segment(4);
?>
<div class="row col-md-12 ini_bodi">
    <div class="panel panel-info">
        <div class="panel-heading">Import Data Soal
            <?php echo $this->session->flashdata('notif') ?>
        </div>
        <div class="panel-body">
            <form name="f_siswa" action="<?php echo base_url('import/soal/'.$uri4); ?>" id="f_siswa" enctype="multipart/form-data" method="post">
                <input type="hidden" name="id" id="id" value="0">
                <table class="table table-form">
                    <?php echo form_dropdown('id_guru', $p_guru, $this->session->userdata('admin_konid'), 'class="form-control" id="id_guru" hidden required'); ?>
                    <?php echo form_dropdown('id_mapel', $p_mapel, $uri4, 'class="form-control" id="id_mapel" hidden required'); ?>

                    <tr><td>File</td><td><input type="file" class="form-control col-md-12" name="userfile" required></td></tr>
                    <tr><td></td><td>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>
                        <a href="javascript:void(0);" onclick="window.history.back();" class="btn btn-default"><i class="fa fa-minus-circle"></i> Kembali</a>
                    </td></tr>
                </table>
            </form>
        </div>
    </div>
</div>