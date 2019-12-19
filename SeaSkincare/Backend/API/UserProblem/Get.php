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

$req_dump = print_r($_GET, true);
$fp = file_put_contents('../../log.txt', date('d.m.Y H:i:s ').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].' GET:'.$req_dump.PHP_EOL, FILE_APPEND);

$userProblemController = new UserProblemController;

echo json_encode($userProblemController->getUserProblem($_GET['userProblemID']));
exit;

?>