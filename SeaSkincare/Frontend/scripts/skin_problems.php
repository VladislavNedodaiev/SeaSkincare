<?php

if (!isset($_SESSION['profile']))
	return null;

// Initialize session and set URL.
$channel = curl_init();

$api_url = '127.0.0.1/SeaSkincare/Backend/API/';
$skin_problem_url = 'SkinProblem/GetAll.php';

// Set so curl_exec returns the result instead of outputting it.
curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);

// user problem
$url = $api_url.$skin_problem_url;
curl_setopt($channel, CURLOPT_URL, $url);
$response = curl_exec($channel);
curl_close($channel);

$response = json_decode($response);

if ($response->status == 'SUCCESS') {
	
	$result = array();
	
	$response = $response->content;
	foreach ($response as &$value)
		$result[$value->id] = $value;
	
	return $result;
		
}

return null;

?>