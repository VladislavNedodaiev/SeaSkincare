<?php
header('Content-Type: text/html; charset=utf-8');

if (!isset($_SESSION))
	session_start();

include_once '../localization/localization.php';

if (!isset($_SESSION['profile']) || !$_SESSION['profile_type']) {

	header("Location: ../index.php");
	exit;

}

$newpath = "";
$moveResult = false;
//var_dump ($_POST['description']);
if (isset($_FILES['photo']['name']) && $_FILES['photo']['tmp_name'] != "") {
	
	$imageFileType = strtolower(pathinfo(basename($_FILES['photo']['name']),PATHINFO_EXTENSION));
	$newpath = 'images/businesses/'.$_SESSION['profile']->id.'/';
	
	if(!is_dir('../'.$newpath)) {
		mkdir('../'.$newpath);
	}
	
	$newpath .= 'photo.'.$imageFileType;
	
	$moveResult = move_uploaded_file($_FILES['photo']['tmp_name'], '../'.$newpath);
	if (!$moveResult) {
	
		$_SESSION['msg']['type'] = 'alert-danger';
		$_SESSION['msg']['text'] = getLocalString('save_business_profile', 'PHOTO_ERROR');
		
	} 	
	
}

// Initialize session and set URL.
$channel = curl_init();

$url = include_once 'backend_host.php';
$url .= '/Backend/API/Business/EditBusiness.php';

curl_setopt($channel, CURLOPT_URL, $url);
curl_setopt($channel, CURLOPT_POST, 1);

$_POST['businessID'] = $_SESSION['profile']->id;
$_POST['email'] = $_SESSION['profile']->email;
$_POST['password'] = $_SESSION['profile']->password;
if ($moveResult)
	$_POST['photo'] = $newpath;
else
	$_POST['photo'] = $_SESSION['profile']->photo;

curl_setopt($channel, CURLOPT_POSTFIELDS, http_build_query($_POST));

// Set so curl_exec returns the result instead of outputting it.
curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
    
// Get the response and close the channel.
$response = curl_exec($channel);
curl_close($channel);

$response = json_decode($response);

if ($response->status == "SUCCESS") {
	
	if ($moveResult) {
		$_SESSION['msg']['type'] = 'alert-success';
		$_SESSION['msg']['text'] = getLocalString('save_business_profile', 'SUCCESS');
	}
	
	$_SESSION['profile']->nickname = $_POST['nickname'];
	$_SESSION['profile']->description = $_POST['description'];
	$_SESSION['profile']->photo = $_POST['photo'];
	$_SESSION['profile']->phoneNumber = $_POST['phoneNumber'];
	
} else if ($response->status == "DB_ERROR") {
	
	$_SESSION['msg']['type'] = 'alert-danger';
	$_SESSION['msg']['text'] = getLocalString('save_business_profile', 'DB_ERROR');
	if ($moveResult)
		unlink($newpath);
	
} else {
	
	$_SESSION['msg']['type'] = 'alert-danger';
	$_SESSION['msg']['text'] = getLocalString('save_business_profile', 'UNKNOWN');
	if ($moveResult)
		unlink($newpath);
	
} 

header("Location: ../business_profile.php");
exit;

?>