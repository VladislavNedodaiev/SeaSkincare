<?php
namespace SeaSkincare\Backend\API\VacationRequest;

include_once '../../Data/DataRepository.php';
include_once '../../Communication/Response.php';

include_once '../../DTOs/VacationRequestDTO.php';
include_once '../../Services/VacationRequestService.php';
include_once '../../Controllers/VacationRequestController.php';

use SeaSkincare\Backend\Controllers\VacationRequestController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$req_dump = print_r($_GET, true);
$fp = file_put_contents('../../log.txt', date('d.m.Y H:i:s ').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].' GET:'.$req_dump.PHP_EOL, FILE_APPEND);

$vacationRequestController = new VacationController;

echo json_encode($vacationRequestController->getVacationRequestsByIDs($_GET['userID'], $_GET['businessID']));
exit;

?>