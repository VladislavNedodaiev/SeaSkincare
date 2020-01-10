<?php

if (!isset($_SESSION['profile']) || $_SESSION['profile_type'])
	return null;

// Initialize session and set URL.
$channel = curl_init();

// Set so curl_exec returns the result instead of outputting it.
curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);

$api_url = include_once 'scripts/backend_host.php';
$api_url .= '/Backend/API/';
$business_url = 'Business/GetBusiness.php?businessID=';

$businesses = array();

if ($my_past_vacations && !empty($my_past_vacations)) {
	foreach($my_past_vacations as $key => &$value) {
		if (!isset($businesses[$value->businessID])) {
			
			$url = $api_url.$business_url.urlencode($value->businessID);
			curl_setopt($channel, CURLOPT_URL, $url);
			$response = curl_exec($channel);
			
			$response = json_decode($response);
			if (isset($response->status) && $response->status == 'SUCCESS')
				$businesses[$value->businessID] = $response->content;
			
		}
	}
}

if ($my_current_vacations && !empty($my_current_vacations)) {
	foreach($my_current_vacations as $key => &$value) {
		if (!isset($businesses[$value->businessID])) {
			
			$url = $api_url.$business_url.urlencode($value->businessID);
			curl_setopt($channel, CURLOPT_URL, $url);
			$response = curl_exec($channel);
			
			$response = json_decode($response);
			if (isset($response->status) && $response->status == 'SUCCESS')
				$businesses[$value->businessID] = $response->content;
			
		}
	}
}

if ($my_future_vacations && !empty($my_future_vacations)) {
	foreach($my_future_vacations as $key => &$value) {
		if (!isset($businesses[$value->businessID])) {
			
			$url = $api_url.$business_url.urlencode($value->businessID);
			curl_setopt($channel, CURLOPT_URL, $url);
			$response = curl_exec($channel);
			
			$response = json_decode($response);
			if (isset($response->status) && $response->status == 'SUCCESS')
				$businesses[$value->businessID] = $response->content;
			
		}
	}
}

if ($my_denied_vacationRequests && !empty($my_denied_vacationRequests)) {
	foreach($my_denied_vacationRequests as $key => &$value) {
		if (!isset($businesses[$value->businessID])) {
			
			$url = $api_url.$business_url.urlencode($value->businessID);
			curl_setopt($channel, CURLOPT_URL, $url);
			$response = curl_exec($channel);
			
			$response = json_decode($response);
			if (isset($response->status) && $response->status == 'SUCCESS')
				$businesses[$value->businessID] = $response->content;
			
		}
	}
}

if ($my_pending_vacationRequests && !empty($my_pending_vacationRequests)) {
	foreach($my_pending_vacationRequests as $key => &$value) {
		if (!isset($businesses[$value->businessID])) {
			
			$url = $api_url.$business_url.urlencode($value->businessID);
			curl_setopt($channel, CURLOPT_URL, $url);
			$response = curl_exec($channel);
			
			$response = json_decode($response);
			if (isset($response->status) && $response->status == 'SUCCESS')
				$businesses[$value->businessID] = $response->content;
			
		}
	}
}

curl_close($channel);

return $businesses;

?>