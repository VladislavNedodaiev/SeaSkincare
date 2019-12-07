<?php
namespace SeaSkincare\Backend\API\UserProblem;

include_once '../../Data/DataRepository.php';
include_once '../../Communication/Response.php';

include_once '../../DTOs/UserProblemDTO.php';
include_once '../../Services/UserProblemService.php';
include_once '../../Controllers/UserProblemController.php';

use SeaSkincare\Backend\Controllers\UserProblemController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$userProblemController = new UserProblemController;

echo json_encode($userProblemController->deleteUserProblem($_POST['userProblemID']));
exit;

?>