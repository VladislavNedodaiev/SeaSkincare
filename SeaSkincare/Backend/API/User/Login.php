<?php
namespace SeaSkincare\Backend\API\User;

use SeaSkincare\Backend\Data;
use SeaSkincare\Backend\Entities;
use SeaSkincare\Backend\DTOs;
use SeaSkincare\Backend\Mappers;
use SeaSkincare\Backend\Services;

header('Content-Type: text/html; charset=utf-8');
session_start();

if (isset($_SESSION['profile'])) {
	
	http_response_code(200);
	echo json_encode($_SESSION['profile']);
	exit;
	
}

if (!isset($_POST['email'])) {
	
	http_response_code(400);
	echo "NO_EMAIL";
	exit;
	
}

if (!isset($_POST['password'])) {
	
	http_response_code(400);
	echo "NO_PASSWORD";
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

$response = $userService->login($email, $password);

if ($response->status == UserService::SUCCESS) {
	
	$_SESSION['profile'] = $response->content;
	
	http_response_code(200);
	echo json_encode(UserMapper::EntityToDTO($response->content));
	exit;
	
} else if ($response->status == UserService::UNVERIFIED){
	
	http_response_code(401);
	
} else if ($response->status == UserService::DB_ERROR) {
	
	http_response_code(500);
	
} else {
	
	http_response_code(400);
	
}

echo $response->status;

//http_response_code(200);
//echo json_encode($products_arr);*/
exit;

?>