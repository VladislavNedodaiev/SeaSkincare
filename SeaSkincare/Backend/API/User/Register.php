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

echo json_encode($userController->register($_POST['email'], $_POST['password'], $_POST['repeat_password'], $_POST['nickname']));
exit;

?>