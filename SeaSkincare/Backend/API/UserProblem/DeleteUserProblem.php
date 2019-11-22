<?php
namespace SeaSkincare\Backend\API\UserProblem;

include_once '../../Data/DataRepository.php';
include_once '../../Entities/User.php';
include_once '../../DTOs/UserDTO.php';
include_once '../../Mappers/UserMapper.php';
include_once '../../Services/MailService.php';
include_once '../../Services/UserService.php';
include_once '../../Communication/Response.php';

use SeaSkincare\Backend\Data\DataRepository;
use SeaSkincare\Backend\Entities\User;
use SeaSkincare\Backend\DTOs\UserDTO;
use SeaSkincare\Backend\Mappers\UserMapper;
use SeaSkincare\Backend\Services\MailService;
use SeaSkincare\Backend\Services\UserService;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

if (!isset($_POST['userProblemID'])) {
	
	http_response_code(400);
	echo "NO_USERPROBLEMID";
	exit;
	
}

$dataRep = new DataRepository;

$userProblemService = new UserProblemService(

	$dataRep->getHost(),
	$dataRep->getUser(),
	$dataRep->getPassword(),
	$dataRep->getDatabase()

);

$response = $userProblemService->deleteUserProblem($_POST['userProblemID']);

if ($response->status == UserProblemService::SUCCESS) {
	
	http_response_code(200);
	
} else {
	
	http_response_code(500);
	
}

echo $response->status;
exit;

?>