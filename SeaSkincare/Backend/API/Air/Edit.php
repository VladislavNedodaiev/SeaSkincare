<?php
namespace SeaSkincare\Backend\API\Air;

include_once '../../Includes/CommonInclude.php';
include_once '../../Includes/AirInclude.php';

use SeaSkincare\Backend\Controllers\AirController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$airController = new AirController;

echo json_encode($airController->editAir($_POST['connectionID'], $_POST['temperature'], $_POST['pollution']));
exit;

?>