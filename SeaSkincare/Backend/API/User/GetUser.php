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

if (!isset($_GET['userID'])) {
	
	http_response_code(400);
	echo "NO_USERID";
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

$response = $userService->getUser($_GET['userID']);

if ($response->status == UserService::SUCCESS) {
	
	http_response_code(200);
	echo json_encode(UserMapper::EntityToDTO($response->content));
	exit;
	
} else if ($response->status == UserService::DB_ERROR) {
	
	http_response_code(500);
	
} else {
	
	http_response_code(404);
	
}

echo $response->status;
exit;

?>