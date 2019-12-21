<?php
header('Content-Type: text/html; charset=utf-8');
session_start();

include_once '../localization/localization.php';

if (isset($_SESSION['profile'])) {
	
	$_SESSION['msg']['type'] = 'alert-success';
	$_SESSION['msg']['text'] = getLocalString('logout', 'SUCCESS');
	
	unset($_SESSION['profile']);
	
} else {
	
	$_SESSION['msg']['type'] = 'alert-primary';
	$_SESSION['msg']['text'] = getLocalString('logout', 'NO_LOGIN');
	
}

header("Location: ../login.php");
exit;

?>