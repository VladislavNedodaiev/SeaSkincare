<?php
namespace SeaSkincare\Backend\API\Buoy;

include_once '../../Includes/CommonInclude.php';
include_once '../../Includes/BuoyInclude.php';

use SeaSkincare\Backend\Controllers\BuoyController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$buoyController = new BuoyController;

echo json_encode($buoyController->getBuoy($_GET['buoyID']));
exit;

?>