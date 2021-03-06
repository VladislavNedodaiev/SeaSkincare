<?php

if (!isset($_SESSION['profile']))
	return null;

// Initialize session and set URL.
$channel = curl_init();

$api_url = 'https://sea-skincare-1577376592545.appspot.com/Backend/API/';
$user_problem_url = 'UserProblem/GetByUser.php?';

$email_url = 'email='.urlencode($_SESSION['profile']->email);
$password_url = 'password='.urlencode($_SESSION['profile']->password);
$userID_url = 'userID='.urlencode($_SESSION['profile']->id);

// Set so curl_exec returns the result instead of outputting it.
curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);

// user problem
$url = $api_url.$user_problem_url.$email_url."&".$password_url."&".$userID_url;
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