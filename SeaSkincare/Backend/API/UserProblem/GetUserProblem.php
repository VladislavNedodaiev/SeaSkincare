<?php
namespace SeaSkincare\Backend\API\UserProblem;

include_once '../../Data/DataRepository.php';
include_once '../../Entities/UserProblem.php';
include_once '../../DTOs/UserProblemDTO.php';
include_once '../../Mappers/UserProblemMapper.php';
include_once '../../Services/UserProblemService.php';
include_once '../../Communication/Response.php';

use SeaSkincare\Backend\Data\DataRepository;
use SeaSkincare\Backend\Entities\UserProblem;
use SeaSkincare\Backend\DTOs\UserProblemDTO;
use SeaSkincare\Backend\Mappers\UserProblemMapper;
use SeaSkincare\Backend\Services\UserProblemService;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

if (!isset($_GET['userProblemID'])) {
	
	http_response_code(400);
	echo json_encode(new Response("NO_USERPROBLEMID", null));
	exit;
	
}

$dataRep = new DataRepository;

$userProblemService = new UserProblemService(

	$dataRep->getHost(),
	$dataRep->getUser(),
	$dataRep->getPassword(),
	$dataRep->getDatabase()

);

$response = $userProblemService->getUserProblem($_GET['userProblemID']);

if ($response->status == UserProblemService::SUCCESS) {
	
	http_response_code(200);
	echo json_encode(new Response($response->status, UserProblemMapper::EntityToDTO($response->content)));
	exit;
	
} else if ($response->status == UserProblemService::DB_ERROR) {
	
	http_response_code(500);
	
} else {
	
	http_response_code(404);
	
}

echo json_encode($response);
exit;

?>