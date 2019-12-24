<?php
namespace SeaSkincare\Backend\API\Connection;

include_once '../../Includes/CommonInclude.php';
include_once '../../Includes/ConnectionInclude.php';

use SeaSkincare\Backend\Controllers\ConnectionController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$req_dump = print_r($_POST, true);
$fp = file_put_contents('../../log.txt', date('d.m.Y H:i:s ').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].' POST:'.$req_dump.PHP_EOL, FILE_APPEND);

$connectionController = new ConnectionController;

echo json_encode($connectionController->editConnection($_POST['connectionID'], $_POST['latitude'], $_POST['longitude'], $_POST['battery']));
exit;

?>