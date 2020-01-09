<?php
namespace SeaSkincare\Backend\API\Connection;

include_once '../../Includes/CommonInclude.php';
include_once '../../Includes/ConnectionInclude.php';

use SeaSkincare\Backend\Services\LogService;
use SeaSkincare\Backend\Controllers\ConnectionController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$logService = new LogService;
$logService->logMessage($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

$connectionController = new ConnectionController;

echo json_encode($connectionController->getConnection($_GET['connectionID']));
exit;

?>