<?php

if ($_SESSION['profile_type']) {
	
	if (!isset($_GET['userID']))
		return null;
	
	// Initialize session and set URL.
	$channel = curl_init();
	
	$api_url = include_once 'scripts/backend_host.php';
	$api_url .= '/Backend/API/';
	$vacation_url = 'Vacation/GetByIDs.php?';
	$vacationRequest_url = 'VacationRequest/GetByIDs.php?';
	$user_url = 'User/GetUser.php?';
	
	$email_url = 'email='.urlencode($_SESSION['profile']->email);
	$password_url = 'password='.urlencode($_SESSION['profile']->password);
	$userID_url = 'userID='.urlencode($_GET['userID']);
	$businessID_url = 'businessID='.urlencode($_SESSION['profile']->id);
	
	// Set so curl_exec returns the result instead of outputting it.
	curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
	
	// vacation
	$url = $api_url.$vacation_url.$email_url."&".$password_url."&".$userID_url."&".$businessID_url;
	curl_setopt($channel, CURLOPT_URL, $url);
	$response_vacation = curl_exec($channel);
	
	// vacation request
	$url = $api_url.$vacationRequest_url.$email_url."&".$password_url."&".$userID_url."&".$businessID_url;
	curl_setopt($channel, CURLOPT_URL, $url);
	$response_vacationRequest = curl_exec($channel);
	
	if (json_decode($response_vacation)->status == 'SUCCESS'
		|| json_decode($response_vacationRequest)->status == 'SUCCESS') {
			
		$url = $api_url.$user_url.$email_url."&".$password_url."&".$userID_url;
		curl_setopt($channel, CURLOPT_URL, $url);
		$response_user = curl_exec($channel);
		
		curl_close($channel);
		return json_decode($response_user)->content;
			
	}
	
	curl_close($channel);
	
	return null;
	
}

return $_SESSION['profile'];

?>