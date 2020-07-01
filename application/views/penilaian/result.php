<style type="text/css">
	h1{
		font-family: sans-serif;
	}


</style>

<div class="col-md-9 page-content">
	<div class="inner-box">
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-6">
                <h1>Grafik Penilaian</h1>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6 text-right">
                <?= $this->backButton; ?>
            </div>
        </div>
        

        <table>
            <tr>
                <th>Kelas</th>
                <td>:</td>
                <td><?=$detail->kelas;?></td>
            </tr>
            <tr>
                <th><?=$this->transTheme->guru;?></th>
                <td>:</td>
                <td><?=$detail->nama_guru;?></td>
            </tr>
            <tr>
                <th>Modul Pelatihan </th>
                <td>:</td>
                <td><?=$detail->nama_mapel;?></td>
            </tr>
            <tr>
                <th>Nilai </th>
                <td>:</td>
                <td><?=$skor;?></td>
            </tr>
        </table>
        
		<div id="accordion" class="panel-group">
			<canvas id="canvas" width="1000" height="280"></canvas>
		</div>

      
	</div>

</div>
</div>

<script type="text/javascript" src="<?php echo base_url().'assets/plugins/chartjs/Chart.min.js'?>"></script>
    
	<script>

    var ctx = document.getElementById("canvas").getContext("2d");

var data = {
    labels: <?= json_encode($labels);?>,
    datasets: [
        <?php for ($i=0; $i < 5;$i++) { ?>
        {
            label: "<?=$opsi[$i];?>",
            fillColor: "<?=$warna[$i];?>",
            
            data: <?= json_encode($jwb_set[$i]);?>
        },
       <?php } ?>
    ]
};

var myBarChart = new Chart(ctx).Bar(data, { barValueSpacing: 20 });
        
   	</script>





