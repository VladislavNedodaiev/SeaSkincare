<?php
namespace SeaSkincare\Backend\API\Subscription;

include_once '../../Includes/CommonInclude.php';
include_once '../../Includes/SubscriptionInclude.php';

use SeaSkincare\Backend\Controllers\SubscriptionController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$req_dump = print_r($_POST, true);
$fp = file_put_contents('../../log.txt', date('d.m.Y H:i:s ').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].' POST:'.$req_dump.PHP_EOL, FILE_APPEND);

$subscriptionController = new SubscriptionController;

echo json_encode($subscriptionController->editSubscription($_POST['subscriptionID'], $_POST['startDate'], $_POST['finishDate']));
exit;

?>