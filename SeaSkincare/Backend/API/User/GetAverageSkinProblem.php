<?php
namespace SeaSkincare\Backend\API\User;

include_once '../../Includes/CommonInclude.php';
include_once '../../Includes/UserProblemInclude.php';
include_once '../../Includes/SkinProblemInclude.php';
include_once '../../Includes/UserInclude.php';

use SeaSkincare\Backend\Controllers\UserController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$req_dump = print_r($_GET, true);
$fp = file_put_contents('../../log.txt', date('d.m.Y H:i:s ').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].' GET:'.$req_dump.PHP_EOL, FILE_APPEND);

$userController = new UserController;

if ($response = $userController->login($_GET['email'], $_GET['password'])) {
	if ($response->status != $userController->SUCCESS->status) {
	
		echo json_encode($response);
		exit;
	
	}
}

echo json_encode($userController->getAverageSkinProblem($_GET['userID']));
exit;

?>