<?php
namespace SeaSkincare\Backend\API\UserProblem;

include_once '../../Includes/CommonInclude.php';
include_once '../../Includes/UserProblemInclude.php';
include_once '../../Includes/UserInclude.php';

use SeaSkincare\Backend\Controllers\UserProblemController;
use SeaSkincare\Backend\Controllers\UserController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$req_dump = print_r($_POST, true);
$fp = file_put_contents('../../log.txt', date('d.m.Y H:i:s ').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].' POST:'.$req_dump.PHP_EOL, FILE_APPEND);

$userProblemController = new UserProblemController;
$userController = new UserController;

if ($response = $userController->login($_POST['email'], $_POST['password'])) {
	if ($response->status != $userController->SUCCESS->status) {
	
		echo json_encode($response);
		exit;
	
	}
}

echo json_encode($userProblemController->createUserProblem($_POST['userID'], $_POST['skinProblemID']));
exit;

?>