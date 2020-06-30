<style type="text/css">
	h1{
		font-family: sans-serif;
	}


</style>

<div class="col-md-9 page-content">
	<div class="inner-box">
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-6">
                <h2>Grafik</h2>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6 text-right">
                <?= $this->backButton; ?>
            </div>
        </div>
        
        <div id="accordion" class="panel-group">
			<canvas id="radar" width="1000" height="600"></canvas>
		</div>
		<div id="accordion" class="panel-group">
			<canvas id="myChart" width="1000" height="600"></canvas>
		</div>

      
	</div>

</div>
</div>

<script type="text/javascript" src="<?php echo base_url().'assets/plugins/chartjs/chart-2.js'?>"></script>

<script type="text/javascript">
    var setBg = () =>  '#' + Math.floor(Math.random()*16777215).toString(16);
    var ctx = document.getElementById('myChart').getContext('2d');
    
    var backgroundColors = [], labels = <?=json_encode($label);?>;

    for(let i = 0;i < labels.length;i++) {
        backgroundColors.push(setBg());
    }

    var chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?=json_encode($label);?>,
        datasets: [{
            label: 'Nilai',
            backgroundColor: backgroundColors,
            borderColor: '#93C3D2',
            data: <?=json_encode($skor);?>
        }]
    },
    options: {
        title: {
            display: true,
            text: 'Grafik Penilaian Pengajar'
        },
        scales: {
            yAxes: [{
            scaleLabel: {
                display: true,
                labelString: 'Skor'
            }
            }]
        }     
    }
});


var marksCanvas = document.getElementById("radar");

var marksData = {
  labels: <?=json_encode($label2);?>,
  datasets: [{
    label: "Nilai",
    backgroundColor: backgroundColors,
    data: <?=json_encode($bobot);?>
  }]
};

var radarChart = new Chart(marksCanvas, {
  type: 'radar',
  data: marksData
});
 
  </script>





