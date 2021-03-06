<?php
header('Content-Type: text/html; charset=utf-8');
session_start();

include_once '../../localization/localization.php';

if (!isset($_SESSION['profile']) || $_SESSION['profile_type']) {
	
	header("Location: ../../index.php");
	exit;
	
}

// Initialize session and set URL.
$channel = curl_init();

$url = 'https://sea-skincare-1577376592545.appspot.com/Backend/API/UserProblem/Delete.php';

$_POST['email'] = $_SESSION['profile']->email;
$_POST['password'] = $_SESSION['profile']->password;
$_POST['userID'] = $_SESSION['profile']->id;
$_POST['userProblemID'] = $_POST['removeSkinProblemID'];
unset($_POST['removeSkinProblemID']);

curl_setopt($channel, CURLOPT_URL, $url);

curl_setopt($channel, CURLOPT_POST, 1);
curl_setopt($channel, CURLOPT_POSTFIELDS, http_build_query($_POST));

// Set so curl_exec returns the result instead of outputting it.
curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
    
// Get the response and close the channel.
$response = curl_exec($channel);
curl_close($channel);

$response = json_decode($response);

if ($response->status == "SUCCESS") {
	
	$_SESSION['msg']['type'] = 'alert-success';
	$_SESSION['msg']['text'] = getLocalString('remove_skin_problem', 'SUCCESS');
	
} else {
	
	$_SESSION['msg']['type'] = 'alert-danger';
	$_SESSION['msg']['text'] = getLocalString('remove_skin_problem', 'UNKNOWN');
	
} 

header("Location: ../../my_skin_problems.php");
exit;

?>