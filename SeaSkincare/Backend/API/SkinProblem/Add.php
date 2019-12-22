<?php
namespace SeaSkincare\Backend\API\SkinProblem;

include_once '../../Includes/CommonInclude.php';
include_once '../../Includes/SkinProblemInclude.php';

use SeaSkincare\Backend\Controllers\SkinProblemController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$req_dump = print_r($_POST, true);
$fp = file_put_contents('../../log.txt', date('d.m.Y H:i:s ').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].' POST:'.$req_dump.PHP_EOL, FILE_APPEND);

$skinProblemController = new SkinProblemController;

echo json_encode($skinProblemController->createSkinProblem($_POST['title'], $_POST['normalPH'], $_POST['normalSalt'], $_POST['normalAirPollution'], $_POST['normalSunPower']));
exit;

?>