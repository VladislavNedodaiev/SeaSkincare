<?php
namespace SeaSkincare\Backend\API\Connection;

include_once '../../Includes/CommonInclude.php';
include_once '../../Includes/ConnectionInclude.php';

use SeaSkincare\Backend\Controllers\ConnectionController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$connectionController = new ConnectionController;

echo json_encode($connectionController->getLastConnection());
exit;

?>