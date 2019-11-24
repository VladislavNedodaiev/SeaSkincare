<?php
namespace SeaSkincare\Backend\API\SkinProblem;

include_once '../../Data/DataRepository.php';
include_once '../../Entities/SkinProblem.php';
include_once '../../DTOs/SkinProblemDTO.php';
include_once '../../Mappers/SkinProblemMapper.php';
include_once '../../Services/SkinProblemService.php';
include_once '../../Communication/Response.php';

use SeaSkincare\Backend\Data\DataRepository;
use SeaSkincare\Backend\Entities\SkinProblem;
use SeaSkincare\Backend\DTOs\SkinProblemDTO;
use SeaSkincare\Backend\Mappers\SkinProblemMapper;
use SeaSkincare\Backend\Services\SkinProblemService;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

if (!isset($_POST['title'])) {
	
	http_response_code(400);
	echo json_encode(new Response("NO_TITLE", null));
	exit;
	
}

$dataRep = new DataRepository;

$skinProblemService = new SkinProblemService(

	$dataRep->getHost(),
	$dataRep->getUser(),
	$dataRep->getPassword(),
	$dataRep->getDatabase()

);

$dto = new SkinProblemDTO;
$dto->title = $_POST['title'];
$dto->normalPH = $_POST['normalPH'];
$dto->normalSalt = $_POST['normalSalt'];
$dto->normalAirPollution = $_POST['normalAirPollution'];
$dto->normalSunPower = $_POST['normalSunPower'];
$response = $skinProblemService->createSkinProblem($dto);

if ($response->status == SkinProblemService::SUCCESS) {
	
	http_response_code(200);
	echo json_encode(new Response($response->status, SkinProblemMapper::EntityToDTO($response->content)));
	exit;
	
} else if ($response->status == SkinProblemService::DB_ERROR) {
	
	http_response_code(500);
	
} else {
	
	http_response_code(400);
	
}

echo json_encode($response);
exit;

?>