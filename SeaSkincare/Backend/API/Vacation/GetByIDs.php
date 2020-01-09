<?php
namespace SeaSkincare\Backend\API\Vacation;

include_once '../../Includes/CommonInclude.php';
include_once '../../Includes/VacationInclude.php';

use SeaSkincare\Backend\Controllers\VacationController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$vacationController = new VacationController;

echo json_encode($vacationController->getVacationsByIDs($_GET['userID'], $_GET['businessID']));
exit;

?>