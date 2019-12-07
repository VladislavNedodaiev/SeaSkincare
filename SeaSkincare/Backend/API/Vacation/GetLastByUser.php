<?php
namespace SeaSkincare\Backend\API\Vacation;

include_once '../../Data/DataRepository.php';
include_once '../../Communication/Response.php';

include_once '../../DTOs/VacationDTO.php';
include_once '../../Services/VacationService.php';
include_once '../../Controllers/VacationController.php';

use SeaSkincare\Backend\Controllers\VacationController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$vacationController = new VacationController;

echo json_encode($vacationController->getLastVacationByUserID($_GET['userID']));
exit;

?>