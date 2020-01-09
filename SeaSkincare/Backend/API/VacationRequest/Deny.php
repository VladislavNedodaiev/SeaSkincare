<?php
namespace SeaSkincare\Backend\API\VacationRequest;

include_once '../../Includes/CommonInclude.php';
include_once '../../Includes/SubscriptionInclude.php';
include_once '../../Includes/BusinessInclude.php';
include_once '../../Includes/VacationInclude.php';
include_once '../../Includes/VacationRequestInclude.php';

use SeaSkincare\Backend\Services\LogService;
use SeaSkincare\Backend\Controllers\VacationRequestController;
use SeaSkincare\Backend\Controllers\BusinessController;
use SeaSkincare\Backend\Controllers\VacationController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$logService = new LogService;
$logService->logMessage($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

$vacationRequestController = new VacationRequestController;
$businessController = new BusinessController;

$response = $businessController->login($_POST['email'], $_POST['password']);
if ($response->status != $businessController->SUCCESS->status) {
	
	echo json_encode($response);
	exit;

}

$response = $vacationRequestController->editVacationRequest($_POST['vacationRequestID'], -1);

echo json_encode($response);
exit;

?>