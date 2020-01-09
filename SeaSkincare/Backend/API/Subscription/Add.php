<?php
namespace SeaSkincare\Backend\API\Subscription;

include_once '../../Includes/CommonInclude.php';
include_once '../../Includes/SubscriptionInclude.php';

use SeaSkincare\Backend\Controllers\SubscriptionController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$subscriptionController = new SubscriptionController;

echo json_encode($subscriptionController->createSubscription($_POST['buoyID'], $_POST['businessID'], $_POST['startDate'], $_POST['finishDate']));
exit;

?>