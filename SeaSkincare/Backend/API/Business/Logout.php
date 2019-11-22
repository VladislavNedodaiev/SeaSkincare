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
	
	unset($_SESSION['profile'])
	unset($_SESSION);
	
	http_response_code(200);
	echo "SUCCESS";
	exit;
	
}

?>