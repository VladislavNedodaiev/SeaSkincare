<?php
namespace SeaSkincare\Backend\API\UserProblem;

include_once '../../Includes/CommonInclude.php';
include_once '../../Includes/UserProblemInclude.php';
include_once '../../Includes/UserInclude.php';

use SeaSkincare\Backend\Controllers\UserProblemController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$fp = file_put_contents('../../log.txt', date('d.m.Y H:i:s ').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].PHP_EOL, FILE_APPEND);

$userProblemController = new UserProblemController;

echo json_encode($userProblemController->getLastUserProblem());
exit;

?>