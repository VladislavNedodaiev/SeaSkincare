<?php

// Initialize session and set URL.
$channel = curl_init();

$api_url = '127.0.0.1/SeaSkincare/Backend/API/';
$buoy_url = 'Buoy/GetFreeCount.php?';
$date_url = 'date='.urlencode(date('Y-m-d'));

// Set so curl_exec returns the result instead of outputting it.
curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);

// user problem
$url = $api_url.$buoy_url.$date_url;
curl_setopt($channel, CURLOPT_URL, $url);
$response = curl_exec($channel);
curl_close($channel);

$response = json_decode($response);

if (isset($response->status) && $response->status == 'SUCCESS') {
	
	$result = array();
	
	return $response->content;
		
}

return null;

?>