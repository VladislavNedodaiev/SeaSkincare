<?php

if (!isset($businesses) || empty($businesses))
	return null;

// Initialize session and set URL.
$channel = curl_init();

$api_url = '127.0.0.1/SeaSkincare/Backend/API/';
$subscription_url = 'Subscription/GetByBusiness.php?';
$connection_url = 'Connection/GetLastByBuoy.php?';

// Set so curl_exec returns the result instead of outputting it.
curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);

$subscriptions = array();
$connections = array();

$pre_url = $api_url.$subscription_url."businessID=";
foreach ($businesses as $key => &$value) {

	$url = $pre_url.$value->id;
	curl_setopt($channel, CURLOPT_URL, $url);
	$response = curl_exec($channel);

	$response = json_decode($response);
	if (isset($response->status) && $response->status == 'SUCCESS') {
		
		$response = $response->content;
		foreach ($response as &$value2) {
			if (!isset($subscriptions[$value2->id]))
				$subscriptions[$value2->id] = $value2;
		}
			
	}

}

$pre_url = $api_url.$connection_url."buoyID=";
foreach ($subscriptions as $key => &$value) {

	$url = $pre_url.$value->id;
	curl_setopt($channel, CURLOPT_URL, $url);
	$response = curl_exec($channel);

	$response = json_decode($response);
	if (isset($response->status) && $response->status == 'SUCCESS') {
		
		$response = $response->content;
		if (!isset($connections[$response->id]))
			$connections[$response->id] = $response;
			
	}

}

curl_close($channel);

return $connections;

?>