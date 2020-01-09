<?php
namespace SeaSkincare\Backend\API\SkinProblem;

include_once '../../Includes/CommonInclude.php';
include_once '../../Includes/SkinProblemInclude.php';

use SeaSkincare\Backend\Controllers\SkinProblemController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$skinProblemController = new SkinProblemController;

echo json_encode($skinProblemController->getLastSkinProblem());
exit;

?>