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

if (!isset($_GET['businessID'])) {
	
	http_response_code(400);
	echo json_encode(new Response("NO_BUSINESSID", null));
	exit;
	
}

$dataRep = new DataRepository;

$vacationService = new VacationService(

	$dataRep->getHost(),
	$dataRep->getUser(),
	$dataRep->getPassword(),
	$dataRep->getDatabase()

);

$response = $vacationService->getVacationsByUserID($_GET['businessID']);

if ($response->status == VacationService::SUCCESS) {
	
	http_response_code(200);
	
	$arr = new Array();
	foreach($response as $val) {
	
		array_push($arr, VacationMapper::EntityToDTO($val));
	
	}
	
	echo json_encode(new Response($response->status, $arr));
	
	exit;
	
} else if ($response->status == VacationService::DB_ERROR) {
	
	http_response_code(500);
	
} else {
	
	http_response_code(404);
	
}

echo json_encode($response);
exit;

?>