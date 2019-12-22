<?php
namespace SeaSkincare\Backend\API\Vacation;

include_once '../../Includes/CommonInclude.php';
include_once '../../Includes/VacationInclude.php';

use SeaSkincare\Backend\Controllers\VacationController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$req_dump = print_r($_GET, true);
$fp = file_put_contents('../../log.txt', date('d.m.Y H:i:s ').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].' GET:'.$req_dump.PHP_EOL, FILE_APPEND);

$vacationController = new VacationController;

echo json_encode($vacationController->getVacationsByIDs($_GET['userID'], $_GET['businessID']));
exit;

?>