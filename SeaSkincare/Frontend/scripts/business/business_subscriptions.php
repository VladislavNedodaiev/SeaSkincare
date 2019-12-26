<?php

if (!isset($_GET['businessID']) && (!isset($_SESSION['profile']) || !$_SESSION['profile_type']))
	return null;

// Initialize session and set URL.
$channel = curl_init();

$api_url = '127.0.0.1/SeaSkincare/Backend/API/';
$subscription_url = 'Subscription/GetByBusiness.php?';

$businessID_url = "businessID=";
if (isset($_GET['businessID']))
	$businessID_url = $_GET['businessID'];
else
	$businessID_url = $_SESSION['profile']->id;

// Set so curl_exec returns the result instead of outputting it.
curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);

// user problem
$url = $api_url.$subscription_url.$businessID_url;
curl_setopt($channel, CURLOPT_URL, $url);
$response = curl_exec($channel);
curl_close($channel);

$response = json_decode($response);

if (isset($response->status) && $response->status == 'SUCCESS') {
	
	$result = array();
	
	$response = $response->content;
	foreach ($response as &$value) {
		$result[$value->id] = $value;
	}
	
	return $result;
		
}

return null;

?>