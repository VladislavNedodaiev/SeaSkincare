<?php if (isset($buoy['water'])) { ?>
	<h2 class = "text-center m-4"><?php echo getLocalString('buoy', 'water_title'); ?></h2>
	<div class="row m-2 border-bottom">
		<div class="col-5 my-auto"><h3><i class="fas fa-cubes"></i> <?php echo getLocalString('buoy', 'temperature'); ?>: </h3></div>
		<div class="col-2 my-auto"><h3><?php if ($buoy['water']->temperature >= 0) echo "+"; else echo "-"; echo $buoy['water']->temperature."°C"; ?></h3></div>
		<div class="col-5 my-auto">
			<div class="row text-muted">
				<div class="col-4 my-auto text-left"><small><?php echo getLocalString('buoy', 'bad'); ?></small></div>
				<div class="col-4 my-auto text-center"><small><?php echo getLocalString('buoy', 'good'); ?></small></div>
				<div class="col-4 my-auto text-right"><small><?php echo getLocalString('buoy', 'bad'); ?></small></div>
			</div>
			<div class="progress">
				<div class="progress-bar <?php if ($buoy['water']->temperature < 13) echo 'bg-primary'; else if ($buoy['water']->temperature < 24) echo 'bg-success'; else if ($buoy['water']->temperature < 30) echo 'bg-warning'; else echo 'bg-danger' ?>" role="progressbar" style="width: <?php echo $buoy['water']->temperature; ?>%" aria-valuenow="<?php echo $buoy['water']->temperature; ?>" aria-valuemin="0" aria-valuemax="50"></div>
			</div>
		</div>
	</div>
	<div class="row m-2 border-bottom">
		<div class="col-5 my-auto"><h3><i class="fas fa-cubes"></i> <?php echo getLocalString('buoy', 'water_pH'); ?>: </h3></div>
		<div class="col-2 my-auto"><h3><?php echo $buoy['water']->pH; ?></h3></div>
		<div class="col-5 my-auto">
			<div class="row text-muted">
				<div class="col-6 my-auto text-left"><small><?php echo getLocalString('buoy', 'good'); ?></small></div>
				<div class="col-6 my-auto text-right"><small><?php echo getLocalString('buoy', 'bad'); ?></small></div>
			</div>
			<div class="progress">
				<div class="progress-bar <?php if ($buoy['water']->pH < 4) echo 'bg-primary'; else if ($buoy['water']->pH < 8) echo 'bg-success'; else if ($buoy['water']->pH < 9) echo 'bg-warning'; else echo 'bg-danger' ?>" role="progressbar" style="width: <?php echo $buoy['water']->pH / 12 * 100; ?>%" aria-valuenow="<?php echo $buoy['water']->pH; ?>" aria-valuemin="0" aria-valuemax="12"></div>
			</div>
		</div>		
	</div>
	
	<div id="waterChart" class="border-bottom" style="height:500px;"></div>
	
	<script type="text/javascript">
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawChart);

	function drawChart() {

		var data = google.visualization.arrayToDataTable([
			['Component', '<?php echo getLocalString('buoy', 'water_component'); ?>'],
			['NaCl', <?php echo $buoy['water']->NaCl; ?>],
			['MgCl2', <?php echo $buoy['water']->MgCl2; ?>],
			['MgSO4', <?php echo $buoy['water']->MgSO4; ?>],
			['CaSO4', <?php echo $buoy['water']->CaSO4; ?>],
			['NaBr', <?php echo $buoy['water']->NaBr; ?>]
		]);

		var options = {
			title: '<?php echo getLocalString('buoy', 'water_content'); ?>'
		};

		var chart = new google.visualization.PieChart(document.getElementById('waterChart'));

		chart.draw(data, options);
	}
	</script>	

<?php } ?>