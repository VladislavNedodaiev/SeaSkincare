<?php
namespace SeaSkincare\Backend\API\User;

include_once 'Data/DataRepository.php';
include_once 'Services/MailService.php';

include_once 'DTOs/UserDTO.php';




include_once 'Services/UserService.php';
include_once 'Controller/UserController.php';
include_once 'Communication/Response.php';

use SeaSkincare\Backend\Data\DataRepository;
use SeaSkincare\Backend\DTOs\UserDTO;
use SeaSkincare\Backend\Mappers\UserMapper;
use SeaSkincare\Backend\Services\MailService;
use SeaSkincare\Backend\Services\UserService;
use SeaSkincare\Backend\Controller\UserController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$userController = new UserController;


echo json_encode($response);
exit;

?>