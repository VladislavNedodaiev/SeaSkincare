<?php
namespace SeaSkincare\Backend\API\Water;

include_once '../../Includes/CommonInclude.php';
include_once '../../Includes/WaterInclude.php';

use SeaSkincare\Backend\Controllers\WaterController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$logService = new LogService;
$logService->logMessage($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

$waterController = new WaterController;

echo json_encode($waterController->editWater($_POST['connectionID'], $_POST['temperature'], $_POST['pH'], $_POST['NaCl'], $_POST['MgCl2'], $_POST['MgSO4'], $_POST['CaSO4'], $_POST['NaBr']));
exit;

?>