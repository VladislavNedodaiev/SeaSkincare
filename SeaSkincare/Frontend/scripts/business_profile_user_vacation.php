<?php

if (isset($_SESSION['profile']) && !$_SESSION['profile_type']) {
	
	// Initialize session and set URL.
	$channel = curl_init();
	
	$api_url = '127.0.0.1/SeaSkincare/Backend/API/';
	$vacation_url = 'Vacation/GetByIDs.php?';
	$user_url = 'Business/GetBusiness.php?';
	
	$email_url = 'email='.urlencode($_SESSION['profile']->email);
	$password_url = 'password='.urlencode($_SESSION['profile']->password);
	$userID_url = 'userID='.urlencode($_SESSION['profile']->id);
	$businessID_url = 'businessID='.urlencode($_GET['businessID']);
	
	// Set so curl_exec returns the result instead of outputting it.
	curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
	
	// vacation
	$url = $api_url.$vacation_url.$email."&".$password_url."&".$userID_url."&".$businessID_url;
	curl_setopt($channel, CURLOPT_URL, $url);
	$response = curl_exec($channel);
	
	if ($response->status == 'SUCCESS')
		$response = true;
	else
		$response = false;
	
	curl_close($channel);
	
	return $response;

}

return false;

?>