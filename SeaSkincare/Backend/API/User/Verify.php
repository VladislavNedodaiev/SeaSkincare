<?php
namespace SeaSkincare\Backend\API\User;

include_once '../../Includes/CommonInclude.php';
include_once '../../Includes/UserProblemInclude.php';
include_once '../../Includes/SkinProblemInclude.php';
include_once '../../Includes/UserInclude.php';

use SeaSkincare\Backend\Controllers\UserController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$userController = new UserController;

echo json_encode($userController->verify($_GET['userID'], $_GET['verification']));
exit;

?>