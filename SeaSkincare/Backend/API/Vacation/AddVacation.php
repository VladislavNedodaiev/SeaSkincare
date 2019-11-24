<?php
namespace SeaSkincare\Backend\API\Vacation;

include_once '../../Data/DataRepository.php';
include_once '../../Entities/Vacation.php';
include_once '../../DTOs/VacationDTO.php';
include_once '../../Mappers/VacationMapper.php';
include_once '../../Services/VacationService.php';
include_once '../../Communication/Response.php';

use SeaSkincare\Backend\Data\DataRepository;
use SeaSkincare\Backend\Entities\Vacation;
use SeaSkincare\Backend\DTOs\VacationDTO;
use SeaSkincare\Backend\Mappers\VacationMapper;
use SeaSkincare\Backend\Services\VacationService;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

if (!isset($_POST['userID'])) {
	
	http_response_code(400);
	echo "NO_USERID";
	exit;
	
}

if (!isset($_POST['businessID'])) {
	
	http_response_code(400);
	echo "NO_BUSINESSID";
	exit;
	
}

if (!isset($_POST['startDate'])) {
	
	http_response_code(400);
	echo "NO_STARTDATE";
	exit;
	
}

if (!isset($_POST['finishDate'])) {
	
	http_response_code(400);
	echo "NO_FINISHDATE";
	exit;
	
}

$dataRep = new DataRepository;

$vacationService = new VacationService(

	$dataRep->getHost(),
	$dataRep->getUser(),
	$dataRep->getPassword(),
	$dataRep->getDatabase()

);

$dto = new VacationDTO;
$dto->userID = $_POST['userID'];
$dto->businessID = $_POST['businessID'];
$dto->startDate = $_POST['startDate'];
$dto->finishDate = $_POST['finishDate'];
$response = $vacationService->createVacation($dto);

if ($response->status == vacationService::SUCCESS) {
	
	http_response_code(200);
	echo json_encode($response->content);
	exit;
	
} else if ($response->status == vacationService::DB_ERROR) {
	
	http_response_code(500);
	
} else {
	
	http_response_code(400);
	
}

echo $response->status;
exit;

?>