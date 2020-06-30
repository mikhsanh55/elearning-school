<style>
    html {
        font-family: Source Sans Pro, sans-serif;
    }
    table, h1 {
        width:100%;
        margin:10px;
        border-collapse:collapse;
    }
    th,td {
        padding:8px;
    }
    th:first-child, th:last-child {
        width:10%;
    }
    .text-center {
        text-align:center;
    }
</style>
<div id="pdf-wrapper">
    <header>
        
        <h2 class="text-center">Laporan Ranking Pengajar Hasil Evaluasi Dosen Oleh Perwira Mahasiswa</h2>
    </header>
    <table id="pdf-table" class="table" border="1">
        <thead>
            <tr>
                <th class="text-center">Ranking</th>
                <th>Pengajar</th>
                <th>Modul Materi</th>
                <th class="text-center">Nilai</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data as $rows) : ?>
            <tr>
                <td class="text-center"><?=$rank[$rows->id_trainer.$rows->id_mapel];?></td>

				<td><?=$rows->nama_trainer;?></td>

				<td><?=$rows->nama_mapel;?></td>

				<td class="text-center"><?=$rows->skor;?></td>				
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>