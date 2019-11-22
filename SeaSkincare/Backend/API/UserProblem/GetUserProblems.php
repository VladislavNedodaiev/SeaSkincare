<?php
namespace SeaSkincare\Backend\API\UserProblem;

include_once '../../Data/DataRepository.php';
include_once '../../Entities/UserProblem.php';
include_once '../../DTOs/UserProblemDTO.php';
include_once '../../Mappers/UserProblemMapper.php';
include_once '../../Services/MailService.php';
include_once '../../Services/UserProblemService.php';
include_once '../../Communication/Response.php';

use SeaSkincare\Backend\Data\DataRepository;
use SeaSkincare\Backend\Entities\UserProblem;
use SeaSkincare\Backend\DTOs\UserProblemDTO;
use SeaSkincare\Backend\Mappers\UserProblemMapper;
use SeaSkincare\Backend\Services\MailService;
use SeaSkincare\Backend\Services\UserProblemService;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

if (!isset($_GET['userID'])) {
	
	http_response_code(400);
	echo "NO_USERID";
	exit;
	
}

$dataRep = new DataRepository;

$userProblemService = new UserProblemService(

	$dataRep->getHost(),
	$dataRep->getUser(),
	$dataRep->getPassword(),
	$dataRep->getDatabase()

);

$response = $userProblemService->getUserProblems($_GET['userID']);

if ($response->status == UserProblemService::SUCCESS) {
	
	http_response_code(200);
	
	$arr = new Array();
	foreach($response as $val) {
	
		array_push($arr, UserProblemMapper::EntityToDTO($val));
	
	}
	
	echo json_encode($arr);
	
	exit;
	
} else if ($response->status == UserProblemService::DB_ERROR) {
	
	http_response_code(500);
	
} else {
	
	http_response_code(404);
	
}

echo $response->status;
exit;

?>