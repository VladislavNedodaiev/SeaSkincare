<?php

if (!isset($_SESSION['profile']) || !$_SESSION['profile_type'])
	return null;

// Initialize session and set URL.
$channel = curl_init();

// Set so curl_exec returns the result instead of outputting it.
curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);

$api_url = 'https://sea-skincare-1577376592545.appspot.com/Backend/API/';
$user_url = 'User/GetUser.php?';
$email_url = 'email='.urlencode($_SESSION['profile']->email);
$password_url = 'password='.urlencode($_SESSION['profile']->password);
$userID_url = 'userID=';

$users = array();

if ($my_past_vacations && !empty($my_past_vacations)) {
	foreach($my_past_vacations as $key => &$value) {
		if (!isset($users[$value->userID])) {
			
			$url = $api_url.$user_url.$email_url.'&'.$password_url.'&'.$userID_url.urlencode($value->userID);
			curl_setopt($channel, CURLOPT_URL, $url);
			$response = curl_exec($channel);
			
			$response = json_decode($response);
			if (isset($response->status) && $response->status == 'SUCCESS')
				$users[$value->userID] = $response->content;
			
		}
	}
}

if ($my_current_vacations && !empty($my_current_vacations)) {
	foreach($my_current_vacations as $key => &$value) {
		if (!isset($users[$value->userID])) {
			
			$url = $api_url.$user_url.$email_url.'&'.$password_url.'&'.$userID_url.urlencode($value->userID);
			curl_setopt($channel, CURLOPT_URL, $url);
			$response = curl_exec($channel);
			
			$response = json_decode($response);
			if (isset($response->status) && $response->status == 'SUCCESS')
				$users[$value->userID] = $response->content;
			
		}
	}
}

if ($my_future_vacations && !empty($my_future_vacations)) {
	foreach($my_future_vacations as $key => &$value) {
		if (!isset($users[$value->userID])) {
			
			$url = $api_url.$user_url.$email_url.'&'.$password_url.'&'.$userID_url.urlencode($value->userID);
			curl_setopt($channel, CURLOPT_URL, $url);
			$response = curl_exec($channel);
			
			$response = json_decode($response);
			if (isset($response->status) && $response->status == 'SUCCESS')
				$users[$value->userID] = $response->content;
			
		}
	}
}

if ($my_denied_vacationRequests && !empty($my_denied_vacationRequests)) {
	foreach($my_denied_vacationRequests as $key => &$value) {
		if (!isset($users[$value->userID])) {
			
			$url = $api_url.$user_url.$email_url.'&'.$password_url.'&'.$userID_url.urlencode($value->userID);
			curl_setopt($channel, CURLOPT_URL, $url);
			$response = curl_exec($channel);
			
			$response = json_decode($response);
			if (isset($response->status) && $response->status == 'SUCCESS')
				$users[$value->userID] = $response->content;
			
		}
	}
}

if ($my_pending_vacationRequests && !empty($my_pending_vacationRequests)) {
	foreach($my_pending_vacationRequests as $key => &$value) {
		if (!isset($users[$value->userID])) {
			
			$url = $api_url.$user_url.$email_url.'&'.$password_url.'&'.$userID_url.urlencode($value->userID);
			curl_setopt($channel, CURLOPT_URL, $url);
			$response = curl_exec($channel);
			
			$response = json_decode($response);
			if (isset($response->status) && $response->status == 'SUCCESS')
				$users[$value->userID] = $response->content;
			
		}
	}
}

curl_close($channel);

return $users;

?>