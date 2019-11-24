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

if (!isset($_POST['vacationID'])) {
	
	http_response_code(400);
	echo "NO_VACATIONID";
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
	$dataRep->getDatabase(),

);

$dto = VacationDTO;
$dto->id = $_POST['vacationID'];
$dto->startDate = $_POST['startDate'];
$dto->finishDate = $_POST['finishDate'];
$response = $vacationService->updateVacation($dto);

if ($response->status == VacationService::SUCCESS) {
	
	http_response_code(200);
	
} else if ($response->status == VacationService::DB_ERROR) {
	
	http_response_code(500);
	
} else {
	
	http_response_code(404);
	
}

echo $response->status;
exit;

?>