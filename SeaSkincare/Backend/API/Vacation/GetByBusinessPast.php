<?php
namespace SeaSkincare\Backend\API\Vacation;

include_once '../../Data/DataRepository.php';
include_once '../../Services/MailService.php';
include_once '../../Communication/Response.php';

include_once '../../DTOs/VacationDTO.php';
include_once '../../Services/VacationService.php';
include_once '../../Controllers/VacationController.php';

include_once '../../DTOs/BusinessDTO.php';
include_once '../../Services/BusinessService.php';
include_once '../../Controllers/BusinessController.php';

use SeaSkincare\Backend\Controllers\VacationController;
use SeaSkincare\Backend\Controllers\BusinessController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$req_dump = print_r($_GET, true);
$fp = file_put_contents('../../log.txt', date('d.m.Y H:i:s ').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].' GET:'.$req_dump.PHP_EOL, FILE_APPEND);

$vacationController = new VacationController;
$businessController = new BusinessController;

if ($response = $businessController->login($_GET['email'], $_GET['password'])) {
	if ($response->status != $businessController->SUCCESS->status) {
	
		echo json_encode($response);
		exit;
	
	}
}

echo json_encode($vacationController->getVacationsByBusinessIDDate($_GET['businessID'], -1, $_GET['date']));
exit;

?>