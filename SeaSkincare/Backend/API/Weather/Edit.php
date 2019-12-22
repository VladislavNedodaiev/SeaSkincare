<?php
namespace SeaSkincare\Backend\API\Weather;

include_once '../../Includes/CommonInclude.php';
include_once '../../Includes/WeatherInclude.php';

use SeaSkincare\Backend\Controllers\WeatherController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$req_dump = print_r($_POST, true);
$fp = file_put_contents('../../log.txt', date('d.m.Y H:i:s ').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].' POST:'.$req_dump.PHP_EOL, FILE_APPEND);

$weatherController = new WeatherController;

echo json_encode($weatherController->editWeather($_POST['connectionID'], $_POST['sunPower'], $_POST['windSpeed']));
exit;

?>