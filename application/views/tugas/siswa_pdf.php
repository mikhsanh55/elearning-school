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

            <th class="frist">No</th>
            <th>Nama</th>
            <th>NISN</th>
            <th class="frist">Terkumpul</th>
            <th class="frist">Nilai (0/100)</th>
    </tr>
    </thead>
    <tbody>
        <?php $i = 1;
            foreach($datas as $data) :
                $id_tugas = $this->m_tugas->get_by(['id_kelas' => $id])->id;
                $count = $this->m_tugas_attach_siswa->count_by(array('id_tugas'=>$id_tugas,'id_siswa'=>$data->id_peserta));
                $countNilai = $this->m_tugas_nilai->count_by(array('id_tugas'=>$id_tugas,'id_siswa'=>$data->id_peserta));
                if($count > 0 && $countNilai > 0) {
                    $status = 'Sudah';
                    $nilai =  $this->m_tugas_nilai->get_by(array('id_tugas'=>$id_tugas,'id_siswa'=>$data->id_peserta))->nilai;
                }
                else {
                    $status = 'Belum';
                    $nilai = 0;
                }

        ?>
            <tr>
                <td><?= $i++; ?></td>
                <td><?= $data->nama_siswa; ?></td>
                <td><?= $data->nrp; ?></td>
                <td><?= $status; ?></td>
                <td><?= $nilai; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>