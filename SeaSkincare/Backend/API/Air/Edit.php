<?php
namespace SeaSkincare\Backend\API\Air;

include_once '../../Data/DataRepository.php';
include_once '../../Communication/Response.php';

include_once '../../DTOs/AirDTO.php';
include_once '../../Services/AirService.php';
include_once '../../Controllers/AirController.php';

use SeaSkincare\Backend\Controllers\AirController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$req_dump = print_r($_POST, true);
$fp = file_put_contents('../../log.txt', date('d.m.Y H:i:s ').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].' POST:'.$req_dump.PHP_EOL, FILE_APPEND);

$airController = new AirController;

echo json_encode($airController->editAir($_POST['connectionID'], $_POST['temperature'], $_POST['pollution']));
exit;

?>