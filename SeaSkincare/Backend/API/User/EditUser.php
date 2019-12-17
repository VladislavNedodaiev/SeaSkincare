<?php
namespace SeaSkincare\Backend\API\User;

include_once '../../Data/DataRepository.php';
include_once '../../Services/MailService.php';
include_once '../../Communication/Response.php';

include_once '../../DTOs/UserDTO.php';
include_once '../../Services/UserService.php';
include_once '../../Controllers/UserController.php';

include_once '../../DTOs/VacationDTO.php';
include_once '../../Services/VacationService.php';
include_once '../../Controllers/VacationController.php';

include_once '../../DTOs/UserProblemDTO.php';
include_once '../../Services/UserProblemService.php';
include_once '../../Controllers/UserProblemController.php';

include_once '../../DTOs/SkinProblemDTO.php';
include_once '../../Services/SkinProblemService.php';
include_once '../../Controllers/SkinProblemController.php';

use SeaSkincare\Backend\Controllers\UserController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

if (!isset($_SESSION['profile'])) {
	echo json_encode('NOT_LOGGED_IN', null);
}

$userController = new UserController;

echo json_encode($userController->editUser($_POST['userID'], $_POST['nickname'], $_POST['email']));
exit;

?>