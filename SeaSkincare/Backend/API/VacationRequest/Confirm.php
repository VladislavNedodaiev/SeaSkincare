<?php
namespace SeaSkincare\Backend\API\VacationRequest;

include_once '../../Includes/CommonInclude.php';
include_once '../../Includes/SubscriptionInclude.php';
include_once '../../Includes/BusinessInclude.php';
include_once '../../Includes/VacationInclude.php';
include_once '../../Includes/VacationRequestInclude.php';

use SeaSkincare\Backend\Controllers\VacationRequestController;
use SeaSkincare\Backend\Controllers\BusinessController;
use SeaSkincare\Backend\Controllers\VacationController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$vacationRequestController = new VacationRequestController;
$businessController = new BusinessController;

$response = $businessController->login($_POST['email'], $_POST['password']);
if ($response->status != $businessController->SUCCESS->status) {
	
	echo json_encode($response);
	exit;

}

$response = $vacationRequestController->editVacationRequest($_POST['vacationRequestID'], 1);

if ($response->status == $vacationRequestController->SUCCESS->status) {
	
	$response = $vacationRequestController->getVacationRequest($_POST['vacationRequestID']);
	
	$response = $response->content;
	$vacationController = new VacationController;
	$response = $vacationController->createVacation($response->userID, $response->businessID, $_POST['startDate'], $_POST['finishDate']);
	
}

echo json_encode($response);
exit;

?>