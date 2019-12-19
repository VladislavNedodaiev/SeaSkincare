<?php
namespace SeaSkincare\Backend\API\UserProblem;

include_once '../../Data/DataRepository.php';
include_once '../../Services/MailService.php';
include_once '../../Communication/Response.php';

include_once '../../DTOs/UserProblemDTO.php';
include_once '../../Services/UserProblemService.php';
include_once '../../Controllers/UserProblemController.php';

include_once '../../DTOs/UserDTO.php';
include_once '../../Services/UserService.php';
include_once '../../Controllers/UserController.php';

use SeaSkincare\Backend\Controllers\UserProblemController;
use SeaSkincare\Backend\Controllers\UserController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$req_dump = print_r($_POST, true);
$fp = file_put_contents('../../log.txt', date('d.m.Y H:i:s ').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].' POST:'.$req_dump.PHP_EOL, FILE_APPEND);

$userProblemController = new UserProblemController;
$userController = new UserController;

if ($response = $userController->login($_POST['email'], $_POST['password'])) {
	if ($response->status != $userController->SUCCESS->status) {
	
		echo json_encode($response);
		exit;
	
	}
}

echo json_encode($userProblemController->deleteUserProblem($_POST['userProblemID']));
exit;

?>