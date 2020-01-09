<?php
namespace SeaSkincare\Backend\API\Buoy;

include_once '../../Includes/CommonInclude.php';
include_once '../../Includes/BuoyInclude.php';

use SeaSkincare\Backend\Services\LogService;
use SeaSkincare\Backend\Controllers\BuoyController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$logService = new LogService;
$logService->logMessage($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

$buoyController = new BuoyController;

echo json_encode($buoyController->getCount());
exit;

?>