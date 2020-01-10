<?php
header('Content-Type: text/html; charset=utf-8');

if (!isset($_SESSION))
	session_start();

include_once '../../localization/localization.php';

if (!isset($_SESSION['profile']) || $_SESSION['profile_type']) {

	header("Location: ../../index.php");
	exit;

}

// Initialize session and set URL.
$channel = curl_init();

$url = 'https://sea-skincare-1577376592545.appspot.com/Backend/API/User/EditUser.php';

curl_setopt($channel, CURLOPT_URL, $url);

curl_setopt($channel, CURLOPT_POST, 1);

$_POST['userID'] = $_SESSION['profile']->id;
$_POST['email'] = $_SESSION['profile']->email;
$_POST['password'] = $_SESSION['profile']->password;
curl_setopt($channel, CURLOPT_POSTFIELDS, http_build_query($_POST));

// Set so curl_exec returns the result instead of outputting it.
curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
    
// Get the response and close the channel.
$response = curl_exec($channel);
curl_close($channel);

$response = json_decode($response);

if ($response->status == "SUCCESS") {
	
	$_SESSION['msg']['type'] = 'alert-success';
	$_SESSION['msg']['text'] = getLocalString('save_user_profile', 'SUCCESS');
	
	$_SESSION['profile']->nickname = $_POST['nickname'];
	$_SESSION['profile']->name = $_POST['name'];
	$_SESSION['profile']->gender = $_POST['gender'];
	$_SESSION['profile']->phoneNumber = $_POST['phoneNumber'];
	
} else if ($response->status == "DB_ERROR") {
	
	$_SESSION['msg']['type'] = 'alert-danger';
	$_SESSION['msg']['text'] = getLocalString('save_user_profile', 'DB_ERROR');
	
} else {
	
	$_SESSION['msg']['type'] = 'alert-danger';
	$_SESSION['msg']['text'] = getLocalString('save_user_profile', 'UNKNOWN');
	
} 

header("Location: ../../user_profile.php");
exit;

?>