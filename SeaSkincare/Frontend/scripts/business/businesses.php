<?php

// Initialize session and set URL.
$channel = curl_init();

$api_url = '127.0.0.1/SeaSkincare/Backend/API/';
$business_url;
if (isset($_GET['activeCheck']))
	$business_url = 'Business/GetBusinessesActiveSubscriptions.php?limit=9&date='.urlencode(date('Y-m-d'));
else
	$business_url = 'Business/GetBusinesses.php?limit=9';

$add_url = '';
if (isset($_GET['page'])) {
	
	$add_url .= '&offset='.$_GET['page']*9;
	
}
else {
	$add_url .= '&offset=0';
}

if (isset($_GET['search']) && $_GET['search']) {
	
	$add_url .= '&'.http_build_query($_GET['search']);
	
}

// Set so curl_exec returns the result instead of outputting it.
curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);

$url = $api_url.$business_url.$add_url;
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