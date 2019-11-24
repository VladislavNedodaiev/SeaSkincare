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

if (!isset($_POST['email'])) {
	
	http_response_code(400);
	echo json_encode(new Response("NO_EMAIL", null));
	exit;
	
}

if(!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $_POST['email'])) {
	
	http_response_code(400);
	echo json_encode(new Response("INCORRECT_EMAIL", null));
	exit;
	
}

if (!isset($_POST['password'])) {
	
	http_response_code(400);
	echo json_encode(new Response("NO_PASSWORD", null));
	exit;
	
}

if (!isset($_POST['password_repeat'])) {
	
	http_response_code(400);
	echo json_encode(new Response("NO_REPEAT_PASSWORD", null));
	exit;
	
}

if ($_POST['password'] != $_POST['password_repeat']) {
	
	http_response_code(400);
	echo json_encode(new Response("DIFFERENT_PASSWORDS", null));
	exit;
	
}

if (!isset($_POST['nickname'])) {
	
	http_response_code(400);
	echo json_encode(new Response("NO_NICKNAME", null));
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

$response = $userService->register($_POST['email'], $_POST['password'], $_POST['nickname']);

if ($response->status == UserService::SUCCESS) {
	
	http_response_code(200);
	
} else if ($response->status == UserService::DB_ERROR || $response->status == UserService::EMAIL_UNSENT) {
	
	http_response_code(500);
	
} else {
	
	http_response_code(404);
	
}

echo json_encode($response);
exit;

?>