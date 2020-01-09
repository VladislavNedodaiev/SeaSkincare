<?php
namespace SeaSkincare\Backend\API\Weather;

include_once '../../Includes/CommonInclude.php';
include_once '../../Includes/WeatherInclude.php';

use SeaSkincare\Backend\Controllers\WeatherController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$weatherController = new WeatherController;

echo json_encode($weatherController->deleteWeather($_POST['connectionID']));
exit;

?>