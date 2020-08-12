
<table class="table table-bordered table-striped" id="table-materi">

<thead>

<tr class="">
<td class="text-center" width="30"><i class="fas fa-book"></i></td>
<th class="materi-link text-secondary">Judul</th>
<?php if($this->log_lvl != 'siswa') : ?>
    <th class="materi-link text-secondary">Kelas</th>
<?php endif; ?>

<?php if($this->log_lvl != 'siswa' && $this->log_lvl != 'guru') : ?>
    <th class="materi-link text-secondary">
        Nama Guru
    </th>
<?php endif; ?>

<th class="materi-link text-secondary">Tanggal Aktif</th>

<th class="materi-link text-secondary text-center" colspan="1">Aksi</th>

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
        $tgl_aktif = (empty($materi->start_date)) ? 'Belum Terjadwal' : $date.' '.$time.' - '.$date2.' '.$time2;

        // Declare Button
        $videoBtn = empty($materi->video) ? '<a href="#" onclick="return false" class="m-2 btn btn-sm btn-warning view-video"> <i class="fas fa-ban" disabled></i> Video</a>' : '<a href="#" class="m-2 btn btn-sm btn-success view-video" onclick="viewVideo(this, event)" data-type-video="'. $materi->id_type_video .'" data-url="'. $materi->path_video. '" data-title="'. $materi->title .'" data-video="'. $materi->video.'"> <i class="fas fa-check"></i> Video</a>';

        $pdfBtn = !isset($materi->file_pdf) ? '<a href="javascript:void(0);" class="m-2 btn btn-sm btn-warning"><i class="fas fa-ban" title="Mulai Baca"></i> PDF</a>' : '<a href="'. base_url('Materi/read_pdf') . '/' . md5($materi->id).'" target="_blank" class="m-2 btn btn-sm btn-danger"><i class="fas fa-file-pdf-o mr-2" title="Mulai Baca"></i> PDF</a>';

        $pptBtn = !isset($materi->file_ppt) ? '<a href="javascript:void(0);" class="m-2 btn btn-sm btn-warning"><i class="fas fa-ban" title="Mulai Baca"></i> PPT</a>  ' : '<a href="'. base_url('Materi/read_ppt') . '/' . md5($materi->id).'" target="_blank" class="m-2 btn btn-sm btn-danger"><i class="fas fa-file-pdf-o mr-2" title="Mulai Baca"></i> PPT</a>';

        $uploadPdf = '<a href="#" onclick="setSess(event, this)" data-href="'. base_url('Materi/edit_pdf') . '/' .md5($materi->id).'" class="m-2 btn btn-primary btn-sm"><i class="fas fa-pen mr-2" title="Edit materi"></i> Upload PDF</a>';

        $uploadPpt = '<a href="#" onclick="setSess(event, this)" data-href="'. base_url('Materi/edit_ppt') . '/' .md5($materi->id).'" class="m-2 btn btn-primary btn-sm"><i class="fas fa-pen mr-2" title="Edit materi"></i> Upload PPT</a>';
        $deskripsiBtn = '<a href="'. base_url('Materi/read') . '/' . md5($materi->id).'" class="m-2 btn btn-primary btn-sm"><i class="fas fa-eye mr-2" title="Mulai Baca"></i>Deskripsi</a>';
        $hapusBtn = '<a href="#" class="m-2 btn btn-sm btn-danger hapus-materi" data-materi="'. encrypt_url($materi->id).'"><i class="fas fa-trash mr-2" title="Hapus materi"></i>Hapus</a>';
        $editBtn = '<a href="#" onclick="setSess(event, this)" data-href="'. base_url('Materi/edit') . '/' .md5($materi->id).'" class="m-2 btn btn-primary btn-sm"><i class="fas fa-pen mr-2" title="Edit materi"></i> Edit</a>';
        $diskusiBtn = '<a href="'. base_url('Materi/diskusi') . '/'.$materi->id . '/' . $materi->id_kelas .'"  data-href="" class="m-2 btn btn-primary btn-sm"><i class="fas fa-comments" title="Edit materi"></i> Diskusi</a>';

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
            
            <?php if($this->log_lvl != 'siswa' && $this->log_lvl != 'guru'):
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

<?php } else { ?>

    <tr>

        <td colspan="4" class="text-center text-secondary">Data Kosong</td>

    </tr>

<?php } ?>

</tbody>

</table>



