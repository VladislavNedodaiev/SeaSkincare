<?php if (isset($buoy['air'])) { ?>
	<h2 class = "text-center m-4"><?php echo getLocalString('buoy', 'air_title'); ?></h2>
	<div class="row m-2 border-bottom">
		<div class="col-5 my-auto"><h3><i class="fas fa-cubes"></i> <?php echo getLocalString('buoy', 'temperature'); ?>: </h3></div>
		<div class="col-2 my-auto"><h3><?php if ($buoy['air']->temperature >= 0) echo "+"; else echo "-"; echo $buoy['air']->temperature."°C"; ?></h3></div>
		<div class="col-5 my-auto">
			<div class="row text-muted">
				<div class="col-4 my-auto text-left"><small><?php echo getLocalString('buoy', 'bad'); ?></small></div>
				<div class="col-4 my-auto text-center"><small><?php echo getLocalString('buoy', 'good'); ?></small></div>
				<div class="col-4 my-auto text-right"><small><?php echo getLocalString('buoy', 'bad'); ?></small></div>
			</div>
			<div class="progress">
				<div class="progress-bar <?php if ($buoy['air']->temperature < 10) echo 'bg-primary'; else if ($buoy['air']->temperature < 30) echo 'bg-success'; else if ($buoy['air']->temperature < 35) echo 'bg-warning'; else echo 'bg-danger' ?>" role="progressbar" style="width: <?php echo $buoy['air']->temperature + 50; ?>%" aria-valuenow="<?php echo $buoy['air']->temperature; ?>" aria-valuemin="-50" aria-valuemax="50"></div>
			</div>
		</div>
	</div>
	<div class="row m-2 border-bottom">
		<div class="col-5 my-auto"><h3><i class="fas fa-cubes"></i> <?php echo getLocalString('buoy', 'air_pollution'); ?>: </h3></div>
		<div class="col-2 my-auto"><h3><?php echo $buoy['air']->pollution; ?></h3></div>
		<div class="col-5 my-auto">
			<div class="row text-muted">
				<div class="col-6 my-auto text-left"><small><?php echo getLocalString('buoy', 'good'); ?></small></div>
				<div class="col-6 my-auto text-right"><small><?php echo getLocalString('buoy', 'bad'); ?></small></div>
			</div>
			<div class="progress">
				<div class="progress-bar <?php if ($buoy['air']->pollution < 50) echo 'bg-primary'; else if ($buoy['air']->pollution < 150) echo 'bg-success'; else if ($buoy['air']->pollution < 300) echo 'bg-warning'; else echo 'bg-danger' ?>" role="progressbar" style="width: <?php echo $buoy['air']->pollution / 4; ?>%" aria-valuenow="<?php echo $buoy['air']->pollution; ?>" aria-valuemin="0" aria-valuemax="400"></div>
			</div>
		</div>
	</div>
<?php } ?>