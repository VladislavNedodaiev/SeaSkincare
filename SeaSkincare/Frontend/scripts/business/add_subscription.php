<?php
header('Content-Type: text/html; charset=utf-8');
session_start();

include_once '../../localization/localization.php';

if (!isset($_SESSION['profile']) || !$_SESSION['profile_type'] || !isset($_POST['input'])) {
	
	header("Location: ../../index.php");
	exit;
	
}

// Initialize session and set URL.
$channel = curl_init();

$_POST['email'] = $_SESSION['profile']->email;
$_POST['password'] = $_SESSION['profile']->password;
$_POST['businessID'] = $_SESSION['profile']->id;

$freeurl = '127.0.0.1/SeaSkincare/Backend/API/Buoy/GetFree.php?date='.urlencode(date('Y-m-d')).'&offset=0&limit=1';

curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
curl_setopt($channel, CURLOPT_URL, $freeurl);

$response = curl_exec($channel);

$response = json_decode($response);
if ($response->status == "SUCCESS") {
	
	$_POST['buoyID'] = $response->content->id;
	
	$url = '127.0.0.1/SeaSkincare/Backend/API/Subscription/Add.php';
	curl_setopt($channel, CURLOPT_URL, $url);
	
	curl_setopt($channel, CURLOPT_POST, 1);
	curl_setopt($channel, CURLOPT_POSTFIELDS, http_build_query($_POST));
	
	$response = curl_exec($channel);
	curl_close($channel);

	$response = json_decode($response);
	if ($response->status == "SUCCESS") {
		
		$_SESSION['msg']['type'] = 'alert-success';
		$_SESSION['msg']['text'] = getLocalString('add_subscription', 'SUCCESS');
		
	} else {
		
		$_SESSION['msg']['type'] = 'alert-danger';
		$_SESSION['msg']['text'] = getLocalString('add_subscription', 'UNKNOWN');
		
	} 
	
	
} else {
	
	$_SESSION['msg']['type'] = 'alert-danger';
	$_SESSION['msg']['text'] = getLocalString('add_subscription', 'UNKNOWN');
	
} 

//header("Location: ../../business_subscriptions.php");
//exit;

?>