<table class="table table-bordered table-striped" id="table-materi">

<thead>

<tr class="d-flex">
<th class="text-left border-0">&nbsp;&nbsp;&nbsp;</th>
<th class="text-left materi-link border-0 align-self-center flex-fill text-secondary">Judul</th>

<th class="text-left materi-link border-0 align-self-center flex-fill text-secondary">Tanggal Aktif</th>
<?php if($lembaga->instansi === 'SESKOAL') : ?>
    <th class="text-secondary text-left materi-link border-0">Total Jam</th>
<?php endif; ?>

<th class="text-left materi-link border-0 align-self-center flex-fill text-secondary" colspan="1">Aksi</th>

</tr>

</thead>

<tbody>

<?php if(count($paginate['data']) > 0) { ?>

<?php $i= $page_start; foreach ($paginate['data'] as $materi):?>
    <?php

								if (!empty($materi->start_date)) {

									$datetime1 = explode(' ', $materi->start_date);

									$date = shortdate_indo($datetime1[0]);

									$time = time_short($datetime1[1]);

								}else{

									$date = NULL;

									$time = NULL;

								}



								if (!empty($materi->end_date)) {

									$datetime2 = explode(' ', $materi->end_date);

									$date2 = shortdate_indo($datetime2[0]);

									$time2 = time_short($datetime2[1]);

								}else{

									$date2 = NULL;

									$time2 = NULL;

								} 

							;?>

        <tr class="d-flex">
            <td class="text-center align-self-center border-0" width="30"><i class="fas fa-book"></i></td>

            <td class="materi-link border-0 align-self-center flex-fill text-secondary"><?= $materi->title; ?></a></td>

            <td class="materi-link text-center border-0 align-self-center flex-fill text-secondary"><?= $date.' '.$time.' - '.$date2.' '.$time2; ?></a></td>
            <?php if($lembaga->instansi === 'SESKOAL') : 
                $startd = strtotime($materi->start_date);
                $endd = strtotime($materi->end_date);
                $oneday = 24;
                $sum_hours = floor( ($endd - $startd) / 3600 );
                $sum_day = $sum_hours / $oneday;
            ?>
                <td class="materi-link text-center border-0 text-secondary"><?= $sum_day . ' Hari / ' . $sum_hours . ' jam'; ?></td>
            <?php endif; ?>
            <td class="text-right flex-fill d-flex" >
                <a href="<?= base_url('Materi/diskusi') . '/'.$materi->id?>"  data-href="" class="d-inline-block m-2 btn btn-primary btn-sm">

                            <i class="fas fa-comments" title="Edit materi"></i> Diskusi

                        </a>

                <?php if($this->session->userdata('admin_level') == 'guru' || $this->session->userdata('admin_level') == 'admin' ) : ?>

                <?php if($materi->is_verify == 1) : ?>

                    <?php if($materi->pdf == 1){ ?>

                        <a href="#" onclick="setSess(event, this)" data-href="<?= base_url('Materi/edit_pdf') . '/' .md5($materi->id)?>" class="d-inline-block m-2 btn btn-primary btn-sm">

                            <i class="fas fa-pen mr-2" title="Edit materi"></i> Edit

                        </a>

                    <?php } else { ?>

                        <a href="#" onclick="setSess(event, this)" data-href="<?= base_url('Materi/edit') . '/' .md5($materi->id)?>" class="d-inline-block m-2 btn btn-primary btn-sm">

                            <i class="fas fa-pen mr-2" title="Edit materi"></i> Edit

                        </a>

                    <?php } ?>	

                        <a href="#" onclick="setSess(event, this)" data-href="<?= base_url('Materi/edit_pdf') . '/' .md5($materi->id)?>" class="d-inline-block m-2 btn btn-primary btn-sm">

                            <i class="fas fa-pen mr-2" title="Edit materi"></i> Upload PDF

                        </a>

                <?php endif; ?>	

                <?php endif; ?>

                <?php if($materi->is_verify == 1){ ?>

                    

                    <?php if( $materi->video != null){?>



                    <a href="#" class="d-inline-block m-2 btn btn-sm btn-success view-video" onclick="viewVideo(this, event)" data-type-video="<?= $materi->upload_manual; ?>" data-url="<?= $materi->path_video; ?>" data-title="<?= $materi->title; ?>" data-video="<?= $materi->video; ?>"> <i class="fas fa-check"></i> Video</a>

                    <?php } else{ ?>

                        <a href="#" onclick="return false" class="m-2 btn btn-sm btn-warning view-video"> <i class="d-inline-block fas fa-ban" disabled></i> Video</a>

                    <?php }?>



                    

                    



                    <?php if (isset($materi->file_pdf)): ?>

                        <a href="<?= base_url('Materi/read_pdf') . '/' . md5($materi->id); ?>" target="_blank" class="d-inline-block m-2 btn btn-sm btn-danger">

                        <i class="fas fa-file-pdf-o mr-2" title="Mulai Baca"></i>PDF

                    </a>  

                    <?php else:?>

                        <a href="javascript:void(0);" class="d-inline-block m-2 btn btn-sm btn-warning">

                        <i class="fas fa-ban" title="Mulai Baca"></i>PDF

                    </a>  

                    <?php endif ?>

                    <?php if (isset($materi->file_ppt)): ?>

                    <a href="<?= base_url('Materi/read_ppt') . '/' . md5($materi->id); ?>" target="_blank" class="d-inline-block m-2 btn btn-sm btn-danger">

                    <i class="fas fa-file-pdf-o mr-2" title="Mulai Baca"></i>PPT

                    </a>  

                    <?php else:?>

                    <a href="javascript:void(0);" class="d-inline-block m-2 btn btn-sm btn-warning">

                    <i class="fas fa-ban" title="Mulai Baca"></i>PPT

                    </a>  



                    <?php endif ?>


                    <a href="<?= base_url('Materi/read') . '/' . md5($materi->id); ?>" class="d-inline-block m-2 btn btn-primary btn-sm">

                        <i class="fas fa-eye mr-2" title="Mulai Baca"></i>Deskripsi

                    </a>



                        

                



                <?php }else { ?>

                    <p class="text-danger align-middle">Materi belum diverifikasi</p>

                <?php } ?>

                <?php if($this->session->userdata('admin_level') == 'admin') : ?>

                    <?php if($materi->is_verify == 1): ?>

                        <?php if($materi->pdf == 1) { ?>

                        <a href="#" class="d-inline-block m-2 btn btn-sm btn-danger hapus-materi" data-materi="<?= md5($materi->id); ?>">

                        <i class="fas fa-trash mr-2" title="Hapus materi"></i>Hapus</a>

                        <?php } else { ?>

                        <a href="#" class="d-inline-block m-2 hapus-materi btn btn-sm btn-danger" data-materi="<?= md5($materi->id); ?>">

                        <i class="fas fa-trash mr-2" title="Hapus materi"></i> Hapus</a>

                        <?php } ?>

                    <?php endif; ?>

                <?php endif; ?>



            </td>



        

    </tr>

<?php $i++;endforeach;?>

<?php } else { ?>

    <tr>

        <td class="text-center text-secondary">Materi belum ada :(</td>

    </tr>

<?php } ?>

</tbody>

</table>



