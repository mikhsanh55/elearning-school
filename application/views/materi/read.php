<?php
$parts = array(); 
$replace_div = str_replace(['<div>', '</div>'], [' ',' '], $materi->content);
$new = explode(' ', $replace_div);

function a($new) {
	$header = ['<section>'];
	$current = 0;
	// 1. Determine each slice
	$slice = round( count($new) / 100 );
	$slices = [];
	for($i = 1;$i <= $slice;$i++) 
	{
		$slices[] = $i * 100;
	}
	
	// 2. Loop
	$j = 0;
	for($i = 0, $counter = 0;$i < count($new);$i++)
	{
		if(isset($slices[$j])) {
			if($i <= $slices[$j])
			{
				$header[] = $new[$i];
				
				if($i == $slices[$j]) {
					$header[] = '</section><section>';
					if($j < count($slices)) {
						$j++;	
					}
				}
			}
			else {
				$header[] = $new[$i];
				
				if($i == $slices[$j]) {
					$header[] = '</section><section>';
					if($j < count($slices)) {
						$j++;	
					}
				}	
			}
		}
	}
	$header[] = '</section>';
	return $header;
}
$sd = a($new);
?>
<!DOCTYPE html>
<html>
<head>
	<!-- Reveal JS -->
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/plugins/revealjs/css/reveal.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/plugins/revealjs/css/theme/white.css') ?>">
	<style type="text/css">
@keyframes ins {
			0% {
				transition: .2s;
				opacity: 0;
			}
			50% {
				transition: .2s;
				opacity: 1;
			}
			100% {
				opacity: 0;
				display: none;
			}
		}		
		.reveal {
			margin-top:20px;
			box-shadow:0 0 1px #ccc;
		}
		.reveal .slides section:not(:first-child) {
			font-size: 90%;
			text-align: justify;
		}
		#rules {
			position:absolute;
		}
		.rule {
			opacity: 0;
			transition: .5s;
			padding:5px;
			background: #ecf0f1;
			color: #555;
			font-family: 'Source Sans Pro', serif;
			font-weight: 500;
		}
	</style>	
</head>
<body>
	<div id="rules">
		<div class="rule rule1">
			<h4>Selamat Membaca!</h4>
			<p>Di mohon mengikuti intruksi membaca.</p>
			<h4>Pada Desktop / PC!</h4>
			<p>Tekan <b>F</b> untuk fullscreen.</p>
			<p>Tekan <b>Esc</b> untuk membatalkan fullscreen</p>
			<p>Tekan <b>Alt+panah kiri</b> untuk kembali</p>
		</div>
	</div>
	<div class="reveal">
		<div class="slides">
			<section>
				<h2><?= $materi->title; ?></h2>
			</section>
			<?= implode(' ', $sd); ?>
		</div>
	</div>
	<script type="text/javascript" src="<?= base_url('assets/plugins/revealjs/js/reveal.js'); ?>"></script>
	<script type="text/javascript">
		Reveal.initialize({
			transitionSpeed:'slow',
			width:940,
			height:940,
			margin:0.1,
			minScale:0.2,
			maxScale:1.5
		});
		document.querySelector('.rule').style.animation = 'ins 10s linear';
	</script>

</body>
</html>