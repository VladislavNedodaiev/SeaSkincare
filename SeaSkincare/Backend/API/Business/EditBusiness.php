<?php
namespace SeaSkincare\Backend\API\Business;

include_once '../../Data/DataRepository.php';
include_once '../../Entities/Business.php';
include_once '../../DTOs/BusinessDTO.php';
include_once '../../Mappers/BusinessMapper.php';
include_once '../../Services/BusinessService.php';
include_once '../../Services/MailService.php';
include_once '../../Communication/Response.php';

use SeaSkincare\Backend\Data\DataRepository;
use SeaSkincare\Backend\Entities\Business;
use SeaSkincare\Backend\DTOs\BusinessDTO;
use SeaSkincare\Backend\Mappers\BusinessMapper;
use SeaSkincare\Backend\Services\BusinessService;
use SeaSkincare\Backend\Services\MailService;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

if (!isset($_POST['userID'])) {
	
	http_response_code(400);
	echo json_encode(new Response("NO_USERID", null));
	exit;
	
}

if (!isset($_POST['nickname'])) {
	
	http_response_code(400);
	echo json_encode(new Response("NO_NICKNAME", null));
	exit;
	
}

if (!isset($_POST['description'])) {
	
	$_POST['description'] = null;
	
}

if (!isset($_POST['photo'])) {
	
	$_POST['photo'] = null;
	
}

if (!isset($_POST['email'])) {
	
	http_response_code(400);
	echo json_encode(new Response("NO_EMAIL", null));
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

$dto = BusinessDTO;
$dto->id = $_POST['userID'];
$dto->nickname = $_POST['nickname'];
$dto->description = $_POST['description'];
$dto->photo = $_POST['photo'];
$dto->email = $_POST['email'];
$response = $businessService->updateBusiness($dto);

if ($response->status == BusinessService::SUCCESS) {
	
	http_response_code(200);
	
} else if ($response->status == BusinessService::DB_ERROR) {
	
	http_response_code(500);
	
} else {
	
	http_response_code(404);
	
}

echo json_encode($response);
exit;

?>