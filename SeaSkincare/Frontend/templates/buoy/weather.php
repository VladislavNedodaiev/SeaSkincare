<?php if (isset($buoy['weather'])) { ?>
	<h2 class = "text-center m-4"><?php echo getLocalString('buoy', 'weather_title'); ?></h2>
	<div class="row m-2 border-bottom">
		<div class="col-5 my-auto"><h3><i class="fas fa-cubes"></i> <?php echo getLocalString('buoy', 'temperature'); ?>: </h3></div>
		<div class="col-2 my-auto"><h3><?php echo $buoy['weather']->sunPower; ?></h3></div>
		<div class="col-5 my-auto">
			<div class="row text-muted">
				<div class="col-6 my-auto text-left"><small><?php echo getLocalString('buoy', 'good'); ?></small></div>
				<div class="col-6 my-auto text-right"><small><?php echo getLocalString('buoy', 'bad'); ?></small></div>
			</div>
			<div class="progress">
				<div class="progress-bar <?php if ($buoy['weather']->sunPower < 200) echo 'bg-primary'; else if ($buoy['weather']->sunPower < 400) echo 'bg-success'; else if ($buoy['weather']->sunPower < 600) echo 'bg-warning'; else echo 'bg-danger' ?>" role="progressbar" style="width: <?php echo $buoy['weather']->sunPower / 10; ?>%" aria-valuenow="<?php echo $buoy['weather']->sunPower; ?>" aria-valuemin="0" aria-valuemax="1000"></div>
			</div>
		</div>
	</div>
	<div class="row m-2 border-bottom">
		<div class="col-5 my-auto"><h3><i class="fas fa-cubes"></i> <?php echo getLocalString('buoy', 'weather_wind_speed'); ?>: </h3></div>
		<div class="col-2 my-auto"><h3><?php echo $buoy['weather']->windSpeed; ?></h3></div>
		<div class="col-5 my-auto">
			<div class="row text-muted">
				<div class="col-6 my-auto text-left"><small><?php echo getLocalString('buoy', 'good'); ?></small></div>
				<div class="col-6 my-auto text-right"><small><?php echo getLocalString('buoy', 'bad'); ?></small></div>
			</div>
			<div class="progress">
				<div class="progress-bar <?php if ($buoy['weather']->windSpeed < 5) echo 'bg-primary'; else if ($buoy['weather']->windSpeed < 10) echo 'bg-success'; else if ($buoy['weather']->windSpeed < 20) echo 'bg-warning'; else echo 'bg-danger' ?>" role="progressbar" style="width: <?php echo $buoy['weather']->windSpeed / 30 * 100; ?>%" aria-valuenow="<?php echo $buoy['weather']->windSpeed; ?>" aria-valuemin="0" aria-valuemax="30"></div>
			</div>
		</div>
	</div>
<?php } ?>