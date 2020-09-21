<table class="table table-bordered table-striped" id="table-materi">
    <thead>
        <tr class="">
            <td class="text-center" width="30"><i class="fas fa-book"></i></td>
            <th class="materi-link text-secondary">Judul</th>
            <?php if($this->log_lvl != 'siswa') : ?>
                <th class="materi-link text-secondary">Kelas</th>
            <?php endif; ?>

            <?php if($this->log_lvl != 'guru') : ?>
                <th class="materi-link text-secondary">
                    Nama Guru
                </th>
            <?php endif; ?>
            <th class="materi-link text-secondary">Tanggal Aktif</th>
            <th class="materi-link text-secondary text-center" colspan="1">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if(count($paginate['data']) > 0) { 
            $i= $page_start; foreach ($paginate['data'] as $materi) :
    		if (!empty($materi->start_date)) {
    			$datetime1 = explode(' ', $materi->start_date);
    			$date = shortdate_indo($datetime1[0]);
                $time = time_short($datetime1[1]);
    		} else {
    			$date = NULL;
    			$time = NULL;
    		}

    		if (!empty($materi->end_date)) {

    			$datetime2 = explode(' ', $materi->end_date);
    			$date2 = shortdate_indo($datetime2[0]);
    			$time2 = time_short($datetime2[1]);

    		} else {

    			$date2 = NULL;
    			$time2 = NULL;

            }

            $tgl_aktif = (empty($materi->start_date)) ? 'Belum Terjadwal' : $date.' '.$time.' - '.$date2.' '.$time2;
            // Declare Button
            $videoBtn = '<a href="#" class="m-2 btn btn-sm btn-success view-video" data-title="'. $materi->title .'" data-id="'.$materi->id.'"> <i class="fas fa-check"></i> Video</a>';

            $pdfBtn = '<a href="javascript:void(0);"  data-id="'.$materi->id.'" class="m-2 btn btn-sm btn-danger read-pdf"><i class="fas fa-file-pdf-o mr-2" title="Mulai Baca"></i> PDF</a>';

            $pptBtn = '<a href="javascript:void(0);" data-id="'.$materi->id.'" class="m-2 btn btn-sm btn-danger read-ppt"><i class="fas fa-file-pdf-o mr-2" title="Mulai Baca"></i> PPT</a>';

            $uploadPdf = '<a href="#" onclick="setSess(event, this)" data-href="'. base_url('Materi/edit_pdf') . '/' .md5($materi->id).'" class="m-2 btn btn-primary btn-sm"><i class="fas fa-pen mr-2" title="Edit materi"></i> Upload PDF</a>';

            $uploadPpt = '<a href="#" onclick="setSess(event, this)" data-href="'. base_url('Materi/edit_ppt') . '/' .md5($materi->id).'" class="m-2 btn btn-primary btn-sm"><i class="fas fa-pen mr-2" title="Edit materi"></i> Upload PPT</a>';
            $deskripsiBtn = '<a href="'. base_url('Materi/read') . '/' . md5($materi->id).'" class="m-2 btn btn-primary btn-sm"><i class="fas fa-eye mr-2" title="Mulai Baca"></i>Deskripsi</a>';
            $hapusBtn = '<a href="#" class="m-2 btn btn-sm btn-danger hapus-materi" data-materi="'. encrypt_url($materi->id).'"><i class="fas fa-trash mr-2" title="Hapus materi"></i>Hapus</a>';
            $editBtn = '<a href="#" onclick="setSess(event, this)" data-href="'. base_url('Materi/edit') . '/' .md5($materi->id).'" class="m-2 btn btn-primary btn-sm"><i class="fas fa-pen mr-2" title="Edit materi"></i> Edit</a>';
            if($materi->id_kelas == '' || is_null($materi->id_kelas)) {
                $diskusiBtn = '<button class="m-2 btn btn-primary btn-sm" disabled><i class="fas fa-comments" title="Diskusi materi"></i> Diskusi</button>';
            }
            else {
                $diskusiBtn = '<a href="'. base_url('Materi/diskusi') . '/'.$materi->id . '/' . $materi->id_kelas .'"  data-href="" class="m-2 btn btn-primary btn-sm"><i class="fas fa-comments" title="Diskusi materi"></i> Diskusi</a>';    
            }
    	;?>
            <tr >
                <td class="text-center  " width="30"><i class="fas fa-book"></i></td>
                <td class="materi-link text-secondary"><?= $materi->title; ?></a></td>

                <?php if($this->log_lvl != 'siswa'): 
                    $kelas = $this->m_kelas->get_by(['kls.id' => $materi->id_kelas]);
                    $nama_kelas = !empty($kelas->nama) ? $kelas->nama : '';
                ?>
                    <td class="materi-link text-secondary">
                        <?= $nama_kelas; ?>
                    </td>
                <?php endif; ?>
                
                <?php if($this->log_lvl != 'guru'):
                 ?>
                    <td class="materi-link text-secondary">
                        <?= $materi->nama_guru; ?>
                    </td>
                <?php endif; ?>
                <td class="materi-link text-secondary"><?=$tgl_aktif; ?></a></td>
                <!-- New Refactored -->
                <td class="text-right">
                    <!-- cek hak akses -->
                    <?php if($this->log_lvl === 'admin' || $this->log_lvl === 'guru' || $this->log_lvl === 'instansi') { ?>

                        <?= $diskusiBtn; ?>
                        <?= $editBtn; ?>
                        <?= $uploadPdf; ?>
                        <?= $uploadPpt; ?>
                        <?= $videoBtn; ?>
                        <?= $pdfBtn; ?>
                        <?= $pptBtn; ?>
                        <?= $deskripsiBtn; ?>
                        <?= $hapusBtn; ?>

                    <?php } else if($this->log_lvl === 'siswa' && $materi->in_jadwal === TRUE) { ?> 

                        <!-- Siswa -->
                        <?= $diskusiBtn; ?>
                        <?= $videoBtn; ?>
                        <?= $pdfBtn; ?>
                        <?= $pptBtn; ?>
                        <?= $deskripsiBtn; ?>

                    <?php } else if($this->log_lvl === 'siswa' && $materi->in_jadwal === FALSE) { ?>
                        <div class="btn-outline-secondary text-center">Belum masuk jadwal</div>
                    <?php } ?>
                </td>
        </tr>

    <?php $i++;endforeach;?>
    <?php } ?>
    </tbody>
</table>
<script src="<?=base_url();?>assets/js/jquery/jquery-3.3.1.min.js"></script>
<script src="<?= base_url('assets/plugin/datatables/jquery.dataTables.min.js') ?>"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
<script>
    $(document).ready(function() {

        $('#table-materi').DataTable({
            responsive: true,
            paging: false,
            info: false
        });
    });
</script>