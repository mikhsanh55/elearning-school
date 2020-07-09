<style>
    table {
        border-collapse:collapse;
    }
    th,td {
        padding:10px;
    }
</style>
<table border="1" style="width:100%">
    <thead>
    <tr>

        <th rowspan="2">No</th>
        <th rowspan="2"><?= $this->transTheme->siswa;?></th>
        <th rowspan="2">Kelas</th>

        <th rowspan="2">Semester</th>

        <th rowspan="2">Mata Pelajaran</th>

        <th colspan="4">Nilai</th>
    </tr>
    <tr>
			<th>UTS</th>

			<th>UAS</th>

			<th>Tugas</th>

			<th>Keaktifan</th>

		</tr>
    </thead>
    <tbody>
<?php
   $this->load->model('m_ujian');
   $this->load->model('m_tugas');
   
   $i = 1; foreach($datas as $rows) :
    $uts = $this->m_ujian->get_nilai(['uji.type_ujian'=>'uts','uji.id_kelas'=>$rows->id_kelas,'id_user'=>$rows->id_peserta]);
$uas = $this->m_ujian->get_nilai(['uji.type_ujian'=>'uas','uji.id_kelas'=>$rows->id_kelas,'id_user'=>$rows->id_peserta]);

$tugas = $this->m_tugas->get_nilai(['tgs.id_kelas'=>$rows->id_kelas,'id_siswa'=>$rows->id_peserta]);

    ?>
        <tr>

            <td align="center" class="frist"><?=$i;?></td>

            <td><?=$rows->siswa;?></td>

            <td><?=$rows->jurusan;?></td>

            <td><?=$rows->semester;?></td>

            <td><?=$rows->mapel;?></td>

            <td><?=(isset($uts->nilai)) ? (int)$uts->nilai:0;?></td>

            <td><?=(isset($uas->nilai)) ? (int)$uas->nilai:0;?></td>

            <td><?=(isset($tugas->nilai)) ? (int)$tugas->nilai:0;?></td>

            <td><?=(isset($uas->nilai)) ? $uas->nilai:0;?></td>

        </tr>

    <?php $i++;endforeach ?>
    </tbody>
</table>