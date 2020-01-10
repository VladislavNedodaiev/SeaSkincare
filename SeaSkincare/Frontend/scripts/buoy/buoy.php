<?php

if (!isset($_GET['buoyID']))
	return null;

$buoy = null;

// Initialize session and set URL.
$channel_buoy = curl_init();

$api_url = include_once 'scripts/backend_host.php';
$api_url .= '/Backend/API/';
$buoy_url = 'Buoy/Get.php?';
$buoyID_url = 'buoyID='.$_GET['buoyID'];

// Set so curl_exec returns the result instead of outputting it.
curl_setopt($channel_buoy, CURLOPT_RETURNTRANSFER, true);

// getting buoy data
$url = $api_url.$buoy_url.$buoyID_url;
curl_setopt($channel_buoy, CURLOPT_URL, $url);
$response = curl_exec($channel_buoy);

$response = json_decode($response);
if (isset($response->status) && $response->status == 'SUCCESS') {
	
	$buoy['buoy'] = $response->content;
	
	// getting subscription data
	$lastSubscription_url = "Subscription/GetLastByBuoy.php?";
	$url = $api_url.$lastSubscription_url.$buoyID_url;
	curl_setopt($channel_buoy, CURLOPT_URL, $url);
	$response = curl_exec($channel_buoy);

	$response = json_decode($response);
	if (isset($response->status) && $response->status == 'SUCCESS') {
		
		$response = $response->content;
		if (date('Y-m-d') >= $response->startDate && date('Y-m-d') <= $response->finishDate) {
		
			$buoy['subscription'] = $response;
			
			if (!isset($_SESSION['profile'])
				|| !$_SESSION['profile_type']
				|| $_SESSION['profile']->id != $buoy['subscription']->businessID) {
				
				// getting business info
				$business_url = "Business/GetBusiness.php?";
				$businessID_url = "businessID=".$buoy['subscription']->businessID;
				$url = $api_url.$business_url.$businessID_url;
				curl_setopt($channel_buoy, CURLOPT_URL, $url);
				$response = curl_exec($channel_buoy);

				$response = json_decode($response);
				if (isset($response->status) && $response->status == 'SUCCESS') {
					$buoy['business'] = $response->content;
				}
				
			}
			
			// getting connection info
			$connection_url = "Connection/GetLastByBuoy.php?";
			$url = $api_url.$connection_url.$buoyID_url;
			curl_setopt($channel_buoy, CURLOPT_URL, $url);
			$response = curl_exec($channel_buoy);

			$response = json_decode($response);
			if (isset($response->status) && $response->status == 'SUCCESS') {
				$buoy['connection'] = $response->content;
			}
			
			if (isset($_SESSION['profile'])) {
				
				// check for access
				$hasAccess = false;
				// if business 
				if ($_SESSION['profile_type']
					&& $_SESSION['profile']->id == $buoy['subscription']->businessID) {
					$buoy['business'] = $_SESSION['profile'];
					$hasAccess = true;
				} else {
					
					// if user - check for vacation
					$_GET['businessID'] = $buoy['subscription']->businessID;
					$vacations = include "scripts/my/my_current_vacations.php";
					if ($vacations && !empty($vacations))
						$hasAccess = true;
					
				}
				
				// get connection, air, water and weather data if has access
				if ($hasAccess && isset($buoy['connection'])) {
					
					// getting air info
					$air_url = "Air/Get.php?";
					$connectionID_url = "connectionID=".$buoy['connection']->id;
					$url = $api_url.$air_url.$connectionID_url;
					curl_setopt($channel_buoy, CURLOPT_URL, $url);
					$response = curl_exec($channel_buoy);
					
					$response = json_decode($response);
					if (isset($response->status) && $response->status == 'SUCCESS')
						$buoy['air'] = $response->content;
					
					// getting Water info
					$water_url = "Water/Get.php?";
					$connectionID_url = "connectionID=".$buoy['connection']->id;
					$url = $api_url.$water_url.$connectionID_url;
					curl_setopt($channel_buoy, CURLOPT_URL, $url);
					$response = curl_exec($channel_buoy);
					
					$response = json_decode($response);
					if (isset($response->status) && $response->status == 'SUCCESS')
						$buoy['water'] = $response->content;
					
					// getting Weather info
					$weather_url = "Weather/Get.php?";
					$connectionID_url = "connectionID=".$buoy['connection']->id;
					$url = $api_url.$weather_url.$connectionID_url;
					curl_setopt($channel_buoy, CURLOPT_URL, $url);
					$response = curl_exec($channel_buoy);
					
					$response = json_decode($response);
					if (isset($response->status) && $response->status == 'SUCCESS')
						$buoy['weather'] = $response->content;
					
				}
				
			}
		
		}
		
	}
		
}


curl_close($channel_buoy);
return $buoy;

?>