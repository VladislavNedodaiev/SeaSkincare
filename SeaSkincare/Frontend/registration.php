<?php
header('Content-Type: text/html; charset=utf-8');
session_start();

include_once 'localization/localization.php';

// Initialize session and set URL.
$channel = curl_init();

$url = '127.0.0.1/SeaSkincare/Backend/API/User/Register.php';
if (isset($_POST['register_option'])) {
	
	if ($_POST['register_option'] == 'as_user')
		$url .= '';
	else
		$url .= '';

}
else
	$url .= '';

curl_setopt($channel, CURLOPT_URL, $url);

curl_setopt($channel, CURLOPT_POST, 1);
curl_setopt($channel, CURLOPT_POSTFIELDS, http_build_query($_POST));

// Set so curl_exec returns the result instead of outputting it.
curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
    
// Get the response and close the channel.
$response = curl_exec($channel);
curl_close($channel);

$response = json_decode($response);
if ($response['status'] == "SUCCESS") {
	
	$_SESSION['msg']['type'] = 'alert-success';
	$_SESSION['msg']['text'] = getLocalString('registration', 'SUCCESS');
	
	header("Location: login.php");
	exit;
	
} else if ($response['status'] == "EMAIL_REGISTERED") {
	
	$_SESSION['msg']['type'] = 'alert-primary';
	$_SESSION['msg']['text'] = getLocalString('registration', 'EMAIL_REGISTERED');
	
} else if ($response['status'] == "NICKNAME_REGISTERED") {
	
	$_SESSION['msg']['type'] = 'alert-primary';
	$_SESSION['msg']['text'] = getLocalString('registration', 'NICKNAME_REGISTERED');
	
} else if ($response['status'] == "EMAIL_UNSENT") {
	
	$_SESSION['msg']['type'] = 'alert-danger';
	$_SESSION['msg']['text'] = getLocalString('registration', 'EMAIL_UNSENT');
	
} else if ($response['status'] == "DB_ERROR") {
	
	$_SESSION['msg']['type'] = 'alert-danger';
	$_SESSION['msg']['text'] = getLocalString('registration', 'DB_ERROR');
	
} else {
	
	$_SESSION['msg']['type'] = 'alert-danger';
	$_SESSION['msg']['text'] = json_encode($response); //getLocalString('registration', 'UNKNOWN');
	
} 

header("Location: register.php");
exit;

?>