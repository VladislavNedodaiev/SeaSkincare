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

$connectionController = new ConnectionController;

echo json_encode($connectionController->editConnection($_POST['connectionID'], $_POST['latitude'], $_POST['longitude'], $_POST['battery']));
exit;

?>