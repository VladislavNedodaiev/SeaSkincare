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

$subscriptionController = new SubscriptionController;

echo json_encode($subscriptionController->editSubscription($_POST['subscriptionID'], $_POST['startDate'], $_POST['finishDate']));
exit;

?>