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
					<div class="card-img-top" id="map" style="width:100%; height:12rem"></div>
						
					<div class="card-header text-center">
						<i class="far fa-calendar-alt"></i><small class = "text-muted"> <?php echo getLocalString('buoy', 'connection_date'); ?>: <?php echo $buoy['connection']->connectionDate; ?> </small>
					</div>
				</div>
				<?php } ?>
				
				<div class="col">
					<div class="row m-2 border-bottom">
						<div class="col-5 my-auto"><h4 class = "text-muted"><i class="far fa-envelope"></i> <?php echo getLocalString('business_profile', 'email'); ?>: </h4></div>
						<div class="col my-auto"><h4><?php echo $account->email; ?></h4></div>
					</div>
					<div class="row m-2 border-bottom">
						<div class="col-5 my-auto"><h4 class = "text-muted"><i class="fas fa-phone"></i> <?php echo getLocalString('business_profile', 'phone'); ?>: </h4></div>
						<?php if ($account->phoneNumber) { ?>
						<div class="col my-auto"><h4><?php echo $account->phoneNumber; ?></h4></div>
						<?php } else { ?>
						<div class="col my-auto"><h4 class = "text-muted"><i><?php echo getLocalString('business_profile', 'no_information'); ?></i></h4></div>
						<?php } ?>
					</div>
				</div>
			</div>
			<h3 class = "text-center m-2"><?php echo getLocalString('business_profile', 'description'); ?></h3>
			<?php if (!$account->description) { ?>
				<h4 class = "text-center text-muted m-2"><i><?php echo getLocalString('business_profile', 'no_information'); ?></i></h4>
			<?php } else { ?>
				<h4 class = "m-2"><?php echo $account->description; ?></h4>
			<?php } ?>
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

	/*map.addListener('click', function(e) {
		placeMarkerAndPanTo(e.latLng, map);
	});

	function placeMarkerAndPanTo(latLng, map) {
		var marker = new google.maps.Marker({
			position: latLng,
			map: map
		});
		
		map.panTo(latLng);
	}*/

}

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBbasOSQ5BTWpi9m27uwi-eacxKchXHSBM&callback=initMap" async defer></script>
<?php } ?>

<?php require "templates/footer.php"; ?>