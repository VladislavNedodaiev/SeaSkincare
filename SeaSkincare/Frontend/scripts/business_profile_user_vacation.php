<?php

if (isset($_SESSION['profile']) && !$_SESSION['profile_type']) {
	
	// Initialize session and set URL.
	$channel = curl_init();
	
	$api_url = 'https://sea-skincare-1577376592545.appspot.com/Backend/API/';
	$vacation_url = 'Vacation/GetByIDs.php?';
	$user_url = 'Business/GetBusiness.php?';
	
	$email_url = 'email='.urlencode($_SESSION['profile']->email);
	$password_url = 'password='.urlencode($_SESSION['profile']->password);
	$userID_url = 'userID='.urlencode($_SESSION['profile']->id);
	$businessID_url = 'businessID='.urlencode($_GET['businessID']);
	
	// Set so curl_exec returns the result instead of outputting it.
	curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
	
	// vacation
	$url = $api_url.$vacation_url.$email_url."&".$password_url."&".$userID_url."&".$businessID_url;
	curl_setopt($channel, CURLOPT_URL, $url);
	$response = curl_exec($channel);
	
	if (json_decode($response)->status == 'SUCCESS')
		$response = true;
	else
		$response = false;
	
	curl_close($channel);
	
	return $response;

}

return false;

?>