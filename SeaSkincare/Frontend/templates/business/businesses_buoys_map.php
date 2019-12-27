<?php if (isset($connections) && !empty($connections)) { ?>
<div id="map" style="width:100%; height:20rem"></div>
<script>

// Initialize and add the map
function initMap() {
	
	// The location of Uluru
	var map = new google.maps.Map(
	document.getElementById('map'), {zoom: 8, center: {lat:<?php echo 30; ?>, lng:<?php echo 30; ?>}});
	// The map, centered at Uluru

	// The marker, positioned at Uluru
	<?php foreach ($connections as $key => &$value) { ?> 
	var marker = new google.maps.Marker({position: {lat:<?php echo $value->latitude; ?>, lng:<?php echo $value->longitude; ?>}, map: map, url: "buoy.php?buoyID=" + <?php echo $value->buoyID; ?>});
	<?php } ?>
	

}

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBbasOSQ5BTWpi9m27uwi-eacxKchXHSBM&callback=initMap" async defer></script>
<?php } ?>