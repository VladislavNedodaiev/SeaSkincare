<?php
namespace SeaSkincare\Backend\API\Business;

include_once '../../Includes/CommonInclude.php';
include_once '../../Includes/SubscriptionInclude.php';
include_once '../../Includes/BusinessInclude.php';

use SeaSkincare\Backend\Controllers\BusinessController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$businessController = new BusinessController;
$result = $businessController->login($_GET['email'], $_GET['password']);

echo json_encode($result);

exit;

?>