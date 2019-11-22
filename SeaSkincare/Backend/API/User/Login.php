<?php
namespace SeaSkincare\Backend\API\User;

include_once '../../Data/DataRepository.php';
include_once '../../Entities/User.php';
include_once '../../DTOs/UserDTO.php';
include_once '../../Mappers/UserMapper.php';
include_once '../../Services/MailService.php';
include_once '../../Services/UserService.php';

use SeaSkincare\Backend\Data\DataRepository;
use SeaSkincare\Backend\Entities\User;
use SeaSkincare\Backend\DTOs\UserDTO;
use SeaSkincare\Backend\Mappers\UserMapper;
use SeaSkincare\Backend\Services\MailService;
use SeaSkincare\Backend\Services\UserService;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

if (isset($_SESSION['profile'])) {
	
	http_response_code(200);
	echo json_encode($_SESSION['profile']);
	exit;
	
}

/*if (!isset($_POST['email'])) {
	
	http_response_code(400);
	echo "NO_EMAIL";
	exit;
	
}

if (!isset($_POST['password'])) {
	
	http_response_code(400);
	echo "NO_PASSWORD";
	exit;
	
}*/

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

$response = $userService->login($_GET['email'], $_GET['password']);

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