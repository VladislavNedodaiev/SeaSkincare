<?php
namespace SeaSkincare\Backend\API\Subscription;

include_once '../../Includes/CommonInclude.php';
include_once '../../Includes/SubscriptionInclude.php';

use SeaSkincare\Backend\Services\LogService;
use SeaSkincare\Backend\Controllers\SubscriptionController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$logService = new LogService;
$logService->logMessage($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

$subscriptionController = new SubscriptionController;

echo json_encode($subscriptionController->getLastSubscriptionByBuoyID($_GET['buoyID']));
exit;

?>