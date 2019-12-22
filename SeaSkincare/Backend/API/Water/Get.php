<?php
namespace SeaSkincare\Backend\API\Water;

include_once '../../Data/DataRepository.php';
include_once '../../Communication/Response.php';

include_once '../../DTOs/WaterDTO.php';
include_once '../../Services/WaterService.php';
include_once '../../Controllers/WaterController.php';

use SeaSkincare\Backend\Controllers\WaterController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$req_dump = print_r($_GET, true);
$fp = file_put_contents('../../log.txt', date('d.m.Y H:i:s ').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].' GET:'.$req_dump.PHP_EOL, FILE_APPEND);

$waterController = new WaterController;

echo json_encode($waterController->getWater($_GET['connectionID']));
exit;

?>