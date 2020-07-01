<?php if($tipe_output === 1) { ?>
    <table id="custumtb" border="1">
        <thead>
            <tr>
                <th>Dosen</th>
                <th>Mata Kuliah</th>
                <th class="frist">Responden</th>
                <?php foreach ($datas->labels as $key => $col) { ?>
                    <th><?=$col;?></th>
                <?php } ;?>
                <th>Total</th>
                
            </tr>
        </thead>
        <tbody>
        <?php $sub_total = []; for ($i=1; $i <= $datas->responden; $i++){ 

        ?>
            <tr>
                <td><?=$datas->nama_guru[$i];?></td>
                <td><?=$datas->nama_mapel[$i];?></td>
                <td align="center" class="frist"><?=$i;?></td>  
                <?php $total=0; $x=1; foreach ($datas->jawaban[$i] as $index => $rows) { 
                    $total += $rows['nilai'];
                    $sub_total[$i][$index] = $rows['nilai'];
                        
                ?>
            
                    <td><?=$rows['nilai'];?></td>
                <?php $x++;} ;?>
                <td><?=$total;?></td>
            </tr>
        <?php }   ?>
            
        </tbody>
    </table>
<?php } else if($tipe_output === 2) { ?>
    
<table id="custumtb" border="1">
    <thead>
        <tr>
            <th>Indikator</th>
            <th>5</th>
            <th>4</th>
            <th>3</th>
            <th>2</th>
            <th>1</th>
        </tr>
    </thead>
    <tbody>
    <?php  $i=0; foreach ($datas['labels'] as $label) {?>
            <tr>
                <td><?=$label;?></td>
                    <td><?= $datas['presentase'][$i]['A'].'%';?></td>
                    <td><?= $datas['presentase'][$i]['B'].'%';?></td>
                    <td><?= $datas['presentase'][$i]['C'].'%';?></td>
                    <td><?= $datas['presentase'][$i]['D'].'%';?></td>
                    <td><?= $datas['presentase'][$i]['E'].'%';?></td>
            </tr>
        <?php $i++; } ?>    
    </tbody>
</table>
<?php } else if($tipe_output === 3) { ?>
<table id="custumtb" border="1">
    <thead>
        <tr>
            <th>Indikator</th>
            <th>MIN</th>
            <th>MAX</th>
            <th>SIMPANGAN BAKU</th>
        </tr>
    </thead>
    <tbody>
    <?php  $i=0; foreach ($datas['labels'] as $label) {?>
            <tr>
                <td><?=$label;?></td>
                <td><?= $datas['datas'][$i]['min'];?></td>
                <td><?= $datas['datas'][$i]['max'];?></td>
                <td><?= $datas['deviasi'][$i];?></td>
            </tr>
        <?php $i++; } ?>    
    </tbody>
</table>
<?php } ?>