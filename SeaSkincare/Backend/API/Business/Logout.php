<?php
namespace SeaSkincare\Backend\API\Business;

include_once '../../Data/DataRepository.php';
include_once '../../Services/MailService.php';
include_once '../../Communication/Response.php';

include_once '../../DTOs/BusinessDTO.php';
include_once '../../Services/BusinessService.php';
include_once '../../Controllers/BusinessController.php';

use SeaSkincare\Backend\Controllers\BusinessController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$fp = file_put_contents('../../log.txt', date('d.m.Y H:i:s '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']).PHP_EOL, FILE_APPEND);

$businessController = new BusinessController;

echo json_encode($businessController->logout($_SESSION['profile']));
exit;

?>