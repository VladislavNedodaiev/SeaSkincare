<?php
namespace SeaSkincare\Backend\API\VacationRequest;

include_once '../../Includes/CommonInclude.php';
include_once '../../Includes/VacationRequestInclude.php';

use SeaSkincare\Backend\Services\LogService;
use SeaSkincare\Backend\Controllers\VacationRequestController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$logService = new LogService;
$logService->logMessage($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

$vacationRequestController = new VacationRequestController;

echo json_encode($vacationRequestController->getVacationRequestsByIDs($_GET['userID'], $_GET['businessID']));
exit;

?>