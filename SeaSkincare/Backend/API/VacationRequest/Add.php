<?php
namespace SeaSkincare\Backend\API\VacationRequest;

include_once '../../Includes/CommonInclude.php';
include_once '../../Includes/UserProblemInclude.php';
include_once '../../Includes/SkinProblemInclude.php';
include_once '../../Includes/UserInclude.php';
include_once '../../Includes/VacationRequestInclude.php';

use SeaSkincare\Backend\Controllers\VacationRequestController;
use SeaSkincare\Backend\Controllers\UserController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$req_dump = print_r($_POST, true);
$fp = file_put_contents('../../log.txt', date('d.m.Y H:i:s ').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].' POST:'.$req_dump.PHP_EOL, FILE_APPEND);

$vacationRequestController = new VacationRequestController;
$userController = new UserController;

if ($response = $userController->login($_POST['email'], $_POST['password'])) {
	if ($response->status != $userController->SUCCESS->status) {
	
		echo json_encode($response);
		exit;
	
	}
}

echo json_encode($vacationRequestController->createVacationRequest($_POST['userID'], $_POST['businessID']));
exit;

?>