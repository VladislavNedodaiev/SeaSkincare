<?php
namespace SeaSkincare\Backend\API\SkinProblem;

include_once '../../Data/DataRepository.php';
include_once '../../Communication/Response.php';

include_once '../../DTOs/SkinProblemDTO.php';
include_once '../../Services/SkinProblemService.php';
include_once '../../Controllers/SkinProblemController.php';

use SeaSkincare\Backend\Controllers\SkinProblemController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$skinProblemController = new SkinProblemController;

echo json_encode($skinProblemController->editSkinProblem($_POST['skinProblemID'], $_POST['title'], $_POST['normalPH'], $_POST['normalSalt'], $_POST['normalAirPollution'], $_POST['normalSunPower']));
exit;

?>