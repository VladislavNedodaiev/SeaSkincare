<?php

if (!isset($_SESSION['profile']))
	return null;

// Initialize session and set URL.
$channel = curl_init();

$api_url = '127.0.0.1/SeaSkincare/Backend/API/';
$vacation_url = 'Vacation/';
if ($_SESSION['profile_type'])
	$vacation_url .= 'GetByBusiness';
else
	$vacation_url .= 'GetByUser';
$vacation_url .= 'Current';
$vacation_url .= '.php?';

$email_url = 'email='.urlencode($_SESSION['profile']->email);
$password_url = 'password='.urlencode($_SESSION['profile']->password);
$profileID_url = "";
if ($_SESSION['profile_type'])
	$profileID_url = 'businessID='.urlencode($_SESSION['profile']->id);
else
	$profileID_url = 'userID='.urlencode($_SESSION['profile']->id);
$date_url = 'date='.urlencode(date('Y-m-d'));

// Set so curl_exec returns the result instead of outputting it.
curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);

// user problem
$url = $api_url.$vacation_url.$email_url."&".$password_url."&".$profileID_url."&".$date_url;
curl_setopt($channel, CURLOPT_URL, $url);
$response = curl_exec($channel);
curl_close($channel);

$response = json_decode($response);

if (isset($response->status) && $response->status == 'SUCCESS') {
	
	$result = array();
	
	$response = $response->content;
	if (!$_SESSION['profile_type']) {
		if (!isset($_GET['businessID'])) {
			foreach ($response as &$value) {
				$result[$value->id] = $value;
			}
		} else {
			
			foreach ($response as &$value) {
				if ($value->businessID == $_GET['businessID'])
					$result[$value->id] = $value;
			}
			
		}
	} else {
		if (!isset($_GET['userID'])) {
			foreach ($response as &$value) {
				$result[$value->id] = $value;
			}
		} else {
			
			foreach ($response as &$value) {
				if ($value->userID == $_GET['userID'])
					$result[$value->id] = $value;
			}
			
		}
	}
	
	return $result;
		
}

return null;

?>