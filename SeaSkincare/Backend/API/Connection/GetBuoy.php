<?php
namespace SeaSkincare\Backend\API\User;

include_once '../../Data/DataRepository.php';
include_once '../../Communication/Response.php';

include_once '../../DTOs/BuoyDTO.php';
include_once '../../Services/BuoyService.php';
include_once '../../Controllers/BuoyController.php';

use SeaSkincare\Backend\Controllers\BuoyController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$buoyController = new BuoyController;

echo json_encode($buoyController->getBuoy($_GET['buoyID']));
exit;

?>