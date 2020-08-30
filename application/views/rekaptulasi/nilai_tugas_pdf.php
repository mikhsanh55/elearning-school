<h3>
	Data Hasil Ujian Kelas : <?= $nama_kelas; ?>
</h3>
	<h3>Guru : <?= $nama_guru; ?></h3>
	<h3>Mata Pelajaran : <?= $nama_mapel; ?></h3>
<style>
    table {
        border-collapse:collapse;
        width: 100%;
    }
    th,td {
        padding:10px;
    }
    .text-center {
    	text-align: center;
    }
    .text-left {
    	text-align: left;
    }
</style>
<table border="1">
    <thead>
        <tr>
            <th>No</th>
            <th class="text-left">Nama Siswa</th>
            <th>NIS</th>
            <th>Nilai</th>
        </tr>
    </thead>
    <tbody>
        <?php if(count($datas) > 0) { ?>
            <?php $i = 1;foreach($datas as $data): 
            $siswa = $this->m_siswa->get_by(['id' => $data->id_siswa]);
            ?>
                <tr>
                    <td class="text-center"><?= $i++; ?></td>
                    <td><?= $siswa->nama; ?></td>
                    <td class="text-center"><?= $siswa->nrp; ?></td>
                    <td class="text-center"><?= $data->nilai; ?></td>
                </tr>
            <?php endforeach; ?>
        <?php } else { ?>
            <tr>
                <td rowspan="4" class="text-center">Data Kosong</td>
            </tr>
        <?php } ?>
    </tbody>
</table>