<?php
namespace SeaSkincare\Backend\API\VacationRequest;

include_once '../../Includes/CommonInclude.php';
include_once '../../Includes/VacationRequestInclude.php';

use SeaSkincare\Backend\Controllers\VacationRequestController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$vacationRequestController = new VacationRequestController;

echo json_encode($vacationRequestController->getVacationRequestsByIDs($_GET['userID'], $_GET['businessID']));
exit;

?>