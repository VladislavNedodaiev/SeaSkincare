<?php
namespace SeaSkincare\Backend\API\Vacation;

include_once '../../Includes/CommonInclude.php';
include_once '../../Includes/VacationInclude.php';

use SeaSkincare\Backend\Controllers\VacationController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$logService = new LogService;
$logService->logMessage($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

$vacationController = new VacationController;

echo json_encode($vacationController->editVacation($_POST['vacationID'], $_POST['startDate'], $_POST['finishDate']));
exit;

?>