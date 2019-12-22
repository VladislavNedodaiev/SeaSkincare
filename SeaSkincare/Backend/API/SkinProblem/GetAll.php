<?php
namespace SeaSkincare\Backend\API\SkinProblem;

include_once '../../Includes/CommonInclude.php';
include_once '../../Includes/SkinProblemInclude.php';

use SeaSkincare\Backend\Controllers\SkinProblemController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$fp = file_put_contents('../../log.txt', date('d.m.Y H:i:s ').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].PHP_EOL, FILE_APPEND);

$skinProblemController = new SkinProblemController;

echo json_encode($skinProblemController->getSkinProblems());
exit;

?>