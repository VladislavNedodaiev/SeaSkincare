<?php
namespace SeaSkincare\Backend\API\Business;

include_once '../../Data/DataRepository.php';
include_once '../../Entities/Business.php';
include_once '../../DTOs/BusinessDTO.php';
include_once '../../Mappers/BusinessMapper.php';
include_once '../../Services/MailService.php';
include_once '../../Services/BusinessService.php';
include_once '../../Communication/Response.php';

use SeaSkincare\Backend\Data\DataRepository;
use SeaSkincare\Backend\Entities\Business;
use SeaSkincare\Backend\DTOs\BusinessDTO;
use SeaSkincare\Backend\Mappers\BusinessMapper;
use SeaSkincare\Backend\Services\MailService;
use SeaSkincare\Backend\Services\BusinessService;
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

$businessService = new BusinessService(

	$dataRep->getHost(),
	$dataRep->getUser(),
	$dataRep->getPassword(),
	$dataRep->getDatabase(),
	new MailService(
		$_SERVER['HTTP_HOST']
	)

);

$response = $businessService->register($_POST['email'], $_POST['password'], $_POST['nickname']);

if ($response->status == BusinessService::SUCCESS) {
	
	http_response_code(200);
	
} else if ($response->status == BusinessService::DB_ERROR || $response->status == BusinessService::EMAIL_UNSENT) {
	
	http_response_code(500);
	
} else {
	
	http_response_code(400);
	
}

echo json_encode($response);
exit;

?>