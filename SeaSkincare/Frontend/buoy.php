<?php

header('Content-Type: text/html; charset=utf-8');
session_start();

if (!isset($_GET['buoyID'])) {
	
	header("Location: index.php");
	exit;
	
}

$buoy = require_once "scripts/buoy/buoy.php";

if (!$buoy) {
	
	header("Location: index.php");
	exit;
	
}

?>

<?php require "templates/header.php"; ?>

<?php include "templates/alert.php" ?>

<article class="card-body mx-auto">
	<div class="card" style="width: 70rem;">
		<div class="card-header">
			<div class="my-auto"><?php echo getLocalString('buoy', 'device_title'); ?> #<?php echo $buoy['buoy']->id; ?></div>
		</div>
		
		<div class="card-body">
			<div class="row">
				<?php if (isset($buoy['connection'])) { ?>
				<div class="col-3 border-right">
				<div class="card" style="width:100%">
					<div class="card-header text-center">
						<small class="text-center"><?php echo getLocalString('buoy', 'battery'); ?></small>
						<div class="progress">
							<div class="progress-bar progress-bar-striped <?php if ($buoy['connection']->battery/10 < 50) echo 'bg-danger'; else echo 'bg-success'; ?>" role="progressbar" style="width: <?php echo $buoy['connection']->battery/10; ?>%" aria-valuenow="<?php echo $buoy['connection']->battery/10; ?>" aria-valuemin="0" aria-valuemax="1000"></div>
						</div>
					</div>
					<div class="card-img-top" id="map" style="width:100%; height:12rem"></div>
						
					<div class="card-header text-center">
						<div><i class="far fa-calendar-alt"></i><small> <?php echo getLocalString('buoy', 'connection_date'); ?></div><div><?php echo $buoy['connection']->connectionDate; ?></div></small>
					</div>
				</div>
				</div>
				<?php } ?>
				
				<div class="col">
					<div class="row m-2 border-bottom">
						<div class="col-5 my-auto"><h4 class = "text-muted"><i class="far fa-building"></i> <?php echo getLocalString('buoy', 'owner'); ?>: </h4></div>
						<?php if (isset($buoy['business'])) { ?>
						<div class="col-7 my-auto"><h4><a href="business_profile.php?businessID=<?php echo $buoy['business']->id; ?>"><?php echo $buoy['business']->nickname; ?></a></h4></div>
						<?php } else { ?>
						<div class="col-7 my-auto"><h4><?php echo getLocalString('buoy', 'no_information'); ?></h4></div>
						<?php } ?>
					</div>
					<div class="row m-2 border-bottom">
						<div class="col-5 my-auto"><h4 class = "text-muted"><i class="fas fa-cubes"></i> <?php echo getLocalString('buoy', 'fabrication_date'); ?>: </h4></div>
						<div class="col-7 my-auto"><h4><?php echo substr($buoy['buoy']->fabricationDate, 0, 10); ?></h4></div>
					</div>
					<?php if (isset($buoy['connection'])) { ?>
					
						<div class="row m-2 border-bottom">
							<div class="col-5 my-auto"><h4 class = "text-muted"><i class="fas fa-map-marker-alt"></i> <?php echo getLocalString('buoy', 'latitude'); ?>: </h4></div>
							<div class="col-7 my-auto"><h4><?php echo $buoy['connection']->latitude; ?></h4></div>
						</div>
						<div class="row m-2 border-bottom">
							<div class="col-5 my-auto"><h4 class = "text-muted"><i class="fas fa-map-marker-alt"></i> <?php echo getLocalString('buoy', 'longitude'); ?>: </h4></div>
							<div class="col-7 my-auto"><h4><?php echo $buoy['connection']->longitude; ?></h4></div>
						</div>					
					<?php } ?>
				</div>
			</div>
			
			<?php include 'templates/buoy/air.php'; ?>
			<?php include 'templates/buoy/water.php'; ?>
			<?php include 'templates/buoy/weather.php'; ?>
			
		</div>
	</div>
</article>

<?php if (isset($buoy['connection'])) { ?>
<script>

// Initialize and add the map
function initMap() {
	
	// The location of Uluru
	var map = new google.maps.Map(
	document.getElementById('map'), {zoom: 8, center: {lat:<?php echo $buoy['connection']->latitude; ?>, lng:<?php echo $buoy['connection']->longitude; ?>}});
	// The map, centered at Uluru

	// The marker, positioned at Uluru
	var marker = new google.maps.Marker({position: {lat:<?php echo $buoy['connection']->latitude; ?>, lng:<?php echo $buoy['connection']->longitude; ?>}, map: map});

}

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBbasOSQ5BTWpi9m27uwi-eacxKchXHSBM&callback=initMap" async defer></script>
<?php } ?>

<?php require "templates/footer.php"; ?>