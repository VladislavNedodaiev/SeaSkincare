<?php
namespace SeaSkincare\Backend\API\UserProblem;

include_once '../../Data/DataRepository.php';
include_once '../../Services/MailService.php';
include_once '../../Entities/User.php';
include_once '../../DTOs/UserDTO.php';
include_once '../../Mappers/UserMapper.php';
include_once '../../Services/UserService.php';
include_once '../../Entities/UserProblem.php';
include_once '../../DTOs/UserProblemDTO.php';
include_once '../../Mappers/UserProblemMapper.php';
include_once '../../Services/UserProblemService.php';
include_once '../../Entities/SkinProblem.php';
include_once '../../DTOs/SkinProblemDTO.php';
include_once '../../Mappers/SkinProblemMapper.php';
include_once '../../Services/SkinProblemService.php';
include_once '../../Communication/Response.php';

use SeaSkincare\Backend\Data\DataRepository;
use SeaSkincare\Backend\Services\MailService;
use SeaSkincare\Backend\Entities\User;
use SeaSkincare\Backend\DTOs\UserDTO;
use SeaSkincare\Backend\Mappers\UserMapper;
use SeaSkincare\Backend\Services\UserService;
use SeaSkincare\Backend\Entities\UserProblem;
use SeaSkincare\Backend\DTOs\UserProblemDTO;
use SeaSkincare\Backend\Mappers\UserProblemMapper;
use SeaSkincare\Backend\Services\UserProblemService;
use SeaSkincare\Backend\Entities\SkinProblem;
use SeaSkincare\Backend\DTOs\SkinProblemDTO;
use SeaSkincare\Backend\Mappers\SkinProblemMapper;
use SeaSkincare\Backend\Services\SkinProblemService;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

if (!isset($_POST['userID'])) {
	
	http_response_code(400);
	echo "NO_USERID";
	exit;
	
}

if (!isset($_POST['skinProblemID'])) {
	
	http_response_code(400);
	echo "NO_SKINPROBLEMID";
	exit;
	
}

$dataRep = new DataRepository;

$userService = new UserService(

	$dataRep->getHost(),
	$dataRep->getUser(),
	$dataRep->getPassword(),
	$dataRep->getDatabase(),
	new MailService(
		$_SERVER['HTTP_HOST']
	)

);

$response = $userService->getUser($_POST['userID']);
if ($response->status == UserService::DB_ERROR) {

	http_response_code(500);
	echo $response->status;
	exit;

} else if ($response->status == UserService::NOT_FOUND) {

	http_response_code(400);
	echo $response->status;
	exit;

}

$skinProblemService = new SkinProblemService(

	$dataRep->getHost(),
	$dataRep->getUser(),
	$dataRep->getPassword(),
	$dataRep->getDatabase()

);

$response = $skinProblemService->getSkinProblem($_POST['skinProblemID']);
if ($response->status == SkinProblemService::DB_ERROR) {

	http_response_code(500);
	echo $response->status;
	exit;

} else if ($response->status == SkinProblemService::NOT_FOUND) {

	http_response_code(400);
	echo $response->status;
	exit;

}

$userProblemService = new UserProblemService(

	$dataRep->getHost(),
	$dataRep->getUser(),
	$dataRep->getPassword(),
	$dataRep->getDatabase()

);

$dto = new UserProblemDTO;
$dto->userID = $_POST['userID'];
$dto->skinProblemID = $_POST['skinProblemID'];
$response = $userProblemService->createUserProblem($dto);

if ($response->status == UserProblemService::SUCCESS) {
	
	http_response_code(200);
	echo json_encode($response->content);
	exit;
	
} else if ($response->status == UserProblemService::DB_ERROR) {
	
	http_response_code(500);
	
} else {
	
	http_response_code(400);
	
}

echo $response->status;
exit;

?>