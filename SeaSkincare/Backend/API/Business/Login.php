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

$businessService = new BusinessService(

	$dataRep->getHost(),
	$dataRep->getUser(),
	$dataRep->getPassword(),
	$dataRep->getDatabase(),
	new MailService(
		$_SERVER['HTTP_HOST']
	)

);

$response = $businessService->login($_POST['email'], $_POST['password']);

if ($response->status == BusinessService::SUCCESS) {
	
	$_SESSION['profile'] = $response->content;
	
	http_response_code(200);
	echo json_encode(UserMapper::EntityToDTO($response->content));
	exit;
	
} else if ($response->status == BusinessService::UNVERIFIED){
	
	http_response_code(401);
	
} else if ($response->status == BusinessService::DB_ERROR) {
	
	http_response_code(500);
	
} else {
	
	http_response_code(400);
	
}

echo $response->status;
exit;

?>