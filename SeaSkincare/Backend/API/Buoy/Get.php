<?php
namespace SeaSkincare\Backend\API\Buoy;

include_once '../../Data/DataRepository.php';
include_once '../../Communication/Response.php';

include_once '../../DTOs/BuoyDTO.php';
include_once '../../Services/BuoyService.php';
include_once '../../Controllers/BuoyController.php';

use SeaSkincare\Backend\Controllers\BuoyController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$req_dump = print_r($_GET, true);
$fp = file_put_contents('../../log.txt', date('d.m.Y H:i:s ').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].' GET:'.$req_dump.PHP_EOL, FILE_APPEND);

$buoyController = new BuoyController;

echo json_encode($buoyController->getBuoy($_GET['buoyID']));
exit;

?>