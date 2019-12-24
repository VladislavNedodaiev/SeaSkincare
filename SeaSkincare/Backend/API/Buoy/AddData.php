<?php
namespace SeaSkincare\Backend\API\Buoy;

include_once '../../Includes/CommonInclude.php';
include_once '../../Includes/AirInclude.php';
include_once '../../Includes/WaterInclude.php';
include_once '../../Includes/WeatherInclude.php';
include_once '../../Includes/ConnectionInclude.php';
include_once '../../Includes/BuoyInclude.php';

use SeaSkincare\Backend\Controllers\BuoyController;
use SeaSkincare\Backend\Controllers\ConnectionController;
use SeaSkincare\Backend\Controllers\AirController;
use SeaSkincare\Backend\Controllers\WaterController;
use SeaSkincare\Backend\Controllers\WeatherController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$req_dump = print_r($_POST, true);
$fp = file_put_contents('../../log.txt', date('d.m.Y H:i:s ').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].' POST:'.$req_dump.PHP_EOL, FILE_APPEND);

$buoyController = new BuoyController;

$response = $buoyController->login($_POST['serialNumber'], $_POST['password']);
if ($response->status == "SUCCESS") {

	$response = $response->content;
	
	$connectionController = new ConnectionController;
	$response = $connectionController->createConnection($response->id, $_POST['latitude'], $_POST['longitude'], $_POST['battery']);
	
	if ($reponse->status == "SUCCESS") {
	
		$airController = new AirController;
		$airController->createAir($response->content->id, $_POST['temperature'], $_POST['pollution']);
		
		$waterController = new WaterController;
		$waterController->createWater($response->content->id, $_POST['temperature'], $_POST['pH'], $_POST['NaCl'], $_POST['MgCl2'], $_POST['MgSO4'], $_POST['CaSO4'], $_POST['NaBr']);
		
		$weatherController = new WeatherController;
		$weatherController->createWeather($response->content->id, $_POST['sunPower'], $_POST['windSpeed']);
	
	}
	

}

echo json_encode($response);
exit;

?>