<?php
namespace SeaSkincare\Backend\API\Business;

include_once '../../Data/DataRepository.php';
include_once '../../Services/MailService.php';
include_once '../../Communication/Response.php';

include_once '../../DTOs/BusinessDTO.php';
include_once '../../Services/BusinessService.php';
include_once '../../Controllers/BusinessController.php';

use SeaSkincare\Backend\Controllers\BusinessController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

if (isset($_SESSION['profile']))
	echo json_encode(new Response("SUCCESS", $_SESSION['profile']));
else {
	
	$businessController = new BusinessController;
	$result = $businessController->login($_GET['email'], $_GET['password']);
	if ($result->status == "SUCCESS")
		$_SESSION['profile'] = $result->content;

	echo json_encode($result);
	
}

exit;

?>