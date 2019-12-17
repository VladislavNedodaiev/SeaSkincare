<?php
namespace SeaSkincare\Backend\API\Subscription;

include_once '../../Data/DataRepository.php';
include_once '../../Communication/Response.php';

include_once '../../DTOs/SubscriptionDTO.php';
include_once '../../Services/SubscriptionService.php';
include_once '../../Controllers/SubscriptionController.php';

use SeaSkincare\Backend\Controllers\SubscriptionController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$req_dump = print_r($_GET, true);
$fp = file_put_contents('../../log.txt', date('d.m.Y H:i:s ').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].' GET:'.$req_dump.PHP_EOL, FILE_APPEND);

$subscriptionController = new SubscriptionController;

echo json_encode($subscriptionController->getSubscriptionsByIDs($_GET['buoyID'], $_GET['businessID']));
exit;

?>