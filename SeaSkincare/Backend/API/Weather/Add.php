<?php
namespace SeaSkincare\Backend\API\Weather;

include_once '../../Data/DataRepository.php';
include_once '../../Communication/Response.php';

include_once '../../DTOs/WeatherDTO.php';
include_once '../../Services/WeatherService.php';
include_once '../../Controllers/WeatherController.php';

use SeaSkincare\Backend\Controllers\WeatherController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$weatherController = new WeatherController;

echo json_encode($weatherController->createWeather($_POST['connectionID'], $_POST['sunPower'], $_POST['windSpeed']));
exit;

?>