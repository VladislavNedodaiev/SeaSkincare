<?php

if (isset($_SESSION['profile'])
	&& (!isset($_GET['businessID']) || $_GET['businessID'] == $_SESSION['profile']->id))
	return $_SESSION['profile'];

if (!isset($_GET['businessID']))
	return null;

// Initialize session and set URL.
$channel = curl_init();

$api_url = '127.0.0.1/SeaSkincare/Backend/API/';
$business_url = 'Business/GetBusiness.php?';
$businessID_url = 'businessID='.urlencode($_GET['businessID']);

// Set so curl_exec returns the result instead of outputting it.
curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);

$url = $api_url.$business_url.$businessID_url;
curl_setopt($channel, CURLOPT_URL, $url);
$response = curl_exec($channel);

curl_close($channel);

return json_decode($response)->content;

?>