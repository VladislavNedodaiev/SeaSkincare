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

$waterController = new WaterController;

echo json_encode($waterController->createWater($_POST['connectionID'], $_POST['temperature'], $_POST['pH'], $_POST['NaCl'], $_POST['MgCl2'], $_POST['MgSO4'], $_POST['CaSO4'], $_POST['NaBr']));
exit;

?>