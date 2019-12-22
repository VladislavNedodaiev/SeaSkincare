<?php
namespace SeaSkincare\Backend\API\Subscription;

include_once '../../Includes/CommonInclude.php';
include_once '../../Includes/SubscriptionInclude.php';

use SeaSkincare\Backend\Controllers\SubscriptionController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$fp = file_put_contents('../../log.txt', date('d.m.Y H:i:s ').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].PHP_EOL, FILE_APPEND);

$subscriptionController = new SubscriptionController;

echo json_encode($subscriptionController->getLastSubscription());
exit;

?>