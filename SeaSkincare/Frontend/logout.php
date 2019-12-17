<?php
header('Content-Type: text/html; charset=utf-8');
session_start();

include_once 'localization/localization.php';

// Initialize session and set URL.
$channel = curl_init();

$url = '127.0.0.1/SeaSkincare/Backend/API';
if (isset($_SESSION['profile'])) {
	
	if (!isset($_SESSION['profile']->description))
		$url .= '/User/Logout.php';
	else
		$url .= '/Business/Logout.php';

}
else {
	
	header("Location: index.php");
	exit;
	
}


curl_setopt($channel, CURLOPT_URL, $url);

// Set so curl_exec returns the result instead of outputting it.
curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
    
// Get the response and close the channel.
$response = curl_exec($channel);
curl_close($channel);

$response = json_decode($response);

if ($response->status == "SUCCESS") {
	
	$_SESSION['msg']['type'] = 'alert-success';
	$_SESSION['msg']['text'] = getLocalString('logout', 'SUCCESS');
	
	unset($_SESSION['profile']);
	
} else if ($response->status == "NO_LOGIN") {
	
	$_SESSION['msg']['type'] = 'alert-primary';
	$_SESSION['msg']['text'] = getLocalString('logout', 'NO_LOGIN');
	
} else {
	
	$_SESSION['msg']['type'] = 'alert-danger';
	$_SESSION['msg']['text'] = getLocalString('logout', 'UNKNOWN');
	
} 

header("Location: login.php");
exit;

?>