<?php
namespace SeaSkincare\Backend\API\Weather;

include_once '../../Includes/CommonInclude.php';
include_once '../../Includes/WeatherInclude.php';

use SeaSkincare\Backend\Services\LogService;
use SeaSkincare\Backend\Controllers\WeatherController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$logService = new LogService;
$logService->logMessage($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

$weatherController = new WeatherController;

echo json_encode($weatherController->editWeather($_POST['connectionID'], $_POST['sunPower'], $_POST['windSpeed']));
exit;

?>