<?php

if (!isset($_SESSION['profile']) || $_SESSION['profile_type'])
	return null;

// Initialize session and set URL.
$channel = curl_init();

$api_url = '127.0.0.1/SeaSkincare/Backend/API/';
$vacationRequest_url = 'VacationRequest/GetByUserDenied.php?';

$email_url = 'email='.urlencode($_SESSION['profile']->email);
$password_url = 'password='.urlencode($_SESSION['profile']->password);
$userID_url = 'userID='.urlencode($_SESSION['profile']->id);
$date_url = 'date='.urlencode(date('Y-m-d'));

// Set so curl_exec returns the result instead of outputting it.
curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);

// user problem
$url = $api_url.$vacationRequest_url.$email_url."&".$password_url."&".$userID_url."&".$date_url;
curl_setopt($channel, CURLOPT_URL, $url);
$response = curl_exec($channel);
curl_close($channel);

$response = json_decode($response);

if (isset($response->status) && $response->status == 'SUCCESS') {
	
	$result = array();
	
	$response = $response->content;
	foreach ($response as &$value)
		$result[$value->id] = $value;
	
	return $result;
		
}

return null;

?>