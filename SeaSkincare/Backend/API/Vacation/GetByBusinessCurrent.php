<?php
namespace SeaSkincare\Backend\API\Vacation;

include_once '../../Includes/CommonInclude.php';
include_once '../../Includes/SubscriptionInclude.php';
include_once '../../Includes/BusinessInclude.php';
include_once '../../Includes/VacationInclude.php';

include_once '../../DTOs/BusinessDTO.php';
include_once '../../Services/BusinessService.php';
include_once '../../Controllers/BusinessController.php';

use SeaSkincare\Backend\Services\LogService;
use SeaSkincare\Backend\Controllers\VacationController;
use SeaSkincare\Backend\Controllers\BusinessController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$logService = new LogService;
$logService->logMessage($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

$vacationController = new VacationController;
$businessController = new BusinessController;

if ($response = $businessController->login($_GET['email'], $_GET['password'])) {
	if ($response->status != $businessController->SUCCESS->status) {
	
		echo json_encode($response);
		exit;
	
	}
}

echo json_encode($vacationController->getVacationsByBusinessIDDate($_GET['businessID'], 0, $_GET['date']));
exit;

?>