<?php
namespace SeaSkincare\Backend\API\Buoy;

include_once '../../Includes/CommonInclude.php';
include_once '../../Includes/BuoyInclude.php';

use SeaSkincare\Backend\Controllers\BuoyController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$req_dump = print_r($_GET, true);
$fp = file_put_contents('../../log.txt', date('d.m.Y H:i:s ').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].' GET:'.$req_dump.PHP_EOL, FILE_APPEND);

$buoyController = new BuoyController;

echo json_encode($buoyController->login($_GET['serialNumber'], $_GET['password']));
exit;

?>