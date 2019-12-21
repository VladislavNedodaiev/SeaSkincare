<?php
header('Content-Type: text/html; charset=utf-8');
session_start();

include_once '../localization/localization.php';

// Initialize session and set URL.
$channel = curl_init();

$url = '127.0.0.1/SeaSkincare/Backend/API';
if (isset($_GET['login_option'])) {
	
	if ($_GET['login_option'] == 'as_user')
		$url .= '/User/Login.php';
	else
		$url .= '/Business/Login.php';

}
else
	$url .= '/User/Login.php';

$url .= '?email='.urlencode($_GET['email']);
$url .= '&password='.urlencode($_GET['password']);

curl_setopt($channel, CURLOPT_URL, $url);

// Set so curl_exec returns the result instead of outputting it.
curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
    
// Get the response and close the channel.
$response = curl_exec($channel);
curl_close($channel);

$response = json_decode($response);

if ($response->status == "SUCCESS") {
	
	$_SESSION['msg']['type'] = 'alert-success';
	$_SESSION['msg']['text'] = getLocalString('authorize', 'SUCCESS');
	
	$_SESSION['profile'] = $response->content;
	$_SESSION['profile']->password = $_GET['password'];
	
	if ($_GET['login_option'] == 'as_user')
		header("Location: ../user_profile.php");
	else
		header("Location: ../business_profile.php");
	exit;
	
} else if ($response->status == "UNVERIFIED") {
	
	$_SESSION['msg']['type'] = 'alert-primary';
	$_SESSION['msg']['text'] = getLocalString('authorize', 'UNVERIFIED');
	
} else if ($response->status == "WRONG_PASSWORD") {
	
	$_SESSION['msg']['type'] = 'alert-danger';
	$_SESSION['msg']['text'] = getLocalString('authorize', 'WRONG_PASSWORD');
	
} else if ($response->status == "NOT_FOUND") {
	
	$_SESSION['msg']['type'] = 'alert-danger';
	$_SESSION['msg']['text'] = getLocalString('authorize', 'NOT_FOUND');
	
} else if ($response->status == "DB_ERROR") {
	
	$_SESSION['msg']['type'] = 'alert-danger';
	$_SESSION['msg']['text'] = getLocalString('authorize', 'DB_ERROR');
	
} else {
	
	$_SESSION['msg']['type'] = 'alert-danger';
	$_SESSION['msg']['text'] = getLocalString('authorize', 'UNKNOWN');
	
} 

header("Location: ../login.php");
exit;

?>