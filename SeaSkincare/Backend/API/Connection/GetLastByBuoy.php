<?php
namespace SeaSkincare\Backend\API\Connection;

include_once '../../Data/DataRepository.php';
include_once '../../Communication/Response.php';

include_once '../../DTOs/ConnectionDTO.php';
include_once '../../Services/ConnectionService.php';
include_once '../../Controllers/ConnectionController.php';

use SeaSkincare\Backend\Controllers\ConnectionController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$req_dump = print_r($_GET, true);
$fp = file_put_contents('../../log.txt', date('d.m.Y H:i:s '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].' GET:').$req_dump.PHP_EOL, FILE_APPEND);

$connectionController = new ConnectionController;

echo json_encode($connectionController->getLastConnectionByBuoy($_GET['buoyID']));
exit;

?>