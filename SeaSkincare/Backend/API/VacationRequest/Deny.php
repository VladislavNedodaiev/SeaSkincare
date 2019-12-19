<?php
namespace SeaSkincare\Backend\API\VacationRequest;

include_once '../../Data/DataRepository.php';
include_once '../../Services/MailService.php';
include_once '../../Communication/Response.php';

include_once '../../DTOs/VacationRequestDTO.php';
include_once '../../Services/VacationRequestService.php';
include_once '../../Controllers/VacationRequestController.php';

include_once '../../DTOs/BusinessDTO.php';
include_once '../../Services/BusinessService.php';
include_once '../../Controllers/BusinessController.php';

include_once '../../DTOs/VacationDTO.php';
include_once '../../Services/VacationService.php';
include_once '../../Controllers/VacationController.php';

use SeaSkincare\Backend\Controllers\VacationRequestController;
use SeaSkincare\Backend\Controllers\BusinessController;
use SeaSkincare\Backend\Controllers\VacationController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$req_dump = print_r($_POST, true);
$fp = file_put_contents('../../log.txt', date('d.m.Y H:i:s ').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].' GET:'.$req_dump.PHP_EOL, FILE_APPEND);

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