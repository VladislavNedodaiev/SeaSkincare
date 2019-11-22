<?php
namespace SeaSkincare\Backend\API\User;

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

if (!isset($_POST['userID'])) {
	
	http_response_code(400);
	echo "NO_USERID";
	exit;
	
}

if (!isset($_POST['oldPassword'])) {
	
	http_response_code(400);
	echo "NO_OLD_PASSWORD";
	exit;
	
}

if (!isset($_POST['newPassword'])) {
	
	http_response_code(400);
	echo "NO_NEW_PASSWORD";
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

$response = $userService->updatePassword($_POST['userID'], $_POST['oldPassword'], $_POST['newPassword']);

if ($response->status == UserService::SUCCESS) {
	
	http_response_code(200);
	
} else if ($response->status == UserService::DB_ERROR) {
	
	http_response_code(500);
	
} else {
	
	http_response_code(404);
	
}

echo $response->status;
exit;

?>