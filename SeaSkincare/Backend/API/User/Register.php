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
	echo "NO_EMAIL";
	exit;
	
}

if(!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $_POST['email'])) {
	
	http_response_code(400);
	echo "INCORRECT_EMAIL";
	exit;
	
}

if (!isset($_POST['password'])) {
	
	http_response_code(400);
	echo "NO_PASSWORD";
	exit;
	
}

if (!isset($_POST['password_repeat'])) {
	
	http_response_code(400);
	echo "NO_REPEAT_PASSWORD";
	exit;
	
}

if ($_POST['password'] != $_POST['password_repeat']) {
	
	http_response_code(400);
	echo "DIFFERENT_PASSWORDS";
	exit;
	
}

if (!isset($_POST['nickname'])) {
	
	http_response_code(400);
	echo "NO_NICKNAME";
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
	
	http_response_code(400);
	
}

echo $response->status;
exit;

?>