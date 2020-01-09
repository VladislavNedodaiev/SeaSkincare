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

$logService = new LogService;
$logService->logMessage($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

$vacationRequestController = new VacationRequestController;
$userController = new UserController;

if ($response = $userController->login($_POST['email'], $_POST['password'])) {
	if ($response->status != $userController->SUCCESS->status) {
	
		echo json_encode($response);
		exit;
	
	}
}

echo json_encode($vacationRequestController->deleteVacationRequest($_POST['vacationRequestID']));
exit;

?>