<?php

namespace SeaSkincare\Backend\Controllers;

use SeaSkincare\Backend\Controllers\Controller;
use SeaSkincare\Backend\Services\LogService;
use SeaSkincare\Backend\Data\DataRepository;
use SeaSkincare\Backend\Services\MailService;
use SeaSkincare\Backend\DTOs\UserDTO;
use SeaSkincare\Backend\Services\UserService;
use SeaSkincare\Backend\Communication\Response;

use SeaSkincare\Backend\DTOs\UserProblemDTO;
use SeaSkincare\Backend\Controllers\UserProblemController;

use SeaSkincare\Backend\DTOs\SkinProblemDTO;
use SeaSkincare\Backend\Controllers\SkinProblemController;

class UserController extends Controller
{
	
	private $mailService;
	private $userService;
	
	private $userProblemController;
	private $skinProblemController;
	
	public $NO_EMAIL;
	public $INCORRECT_EMAIL;
	public $NO_PASSWORD;
	public $NO_REPEAT_PASSWORD;
	public $DIFFERENT_PASSWORDS;
	public $NO_NICKNAME;
	public $NO_NAME;
	public $NO_GENDER;
	public $WRONG_GENDER;
	public $NO_PHONENUMBER;
	public $NO_USERID;
	public $NO_VERIFICATION;
	public $NO_LOGIN;
	public $SUCCESS;
	public $NO_OLD_PASSWORD;
	public $NO_NEW_PASSWORD;
	
	public function __construct() {
		
		parent::__construct();
		
		$this->NO_EMAIL = new Response("NO_EMAIL", null);
		$this->INCORRECT_EMAIL = new Response("INCORRECT_EMAIL", null);
		$this->NO_PASSWORD = new Response("NO_PASSWORD", null);
		$this->NO_REPEAT_PASSWORD = new Response("NO_REPEAT_PASSWORD", null);
		$this->DIFFERENT_PASSWORDS = new Response("DIFFERENT_PASSWORDS", null);
		$this->NO_NICKNAME = new Response("NO_NICKNAME", null);
		$this->NO_NAME = new Response("NO_NAME", null);
		$this->NO_GENDER = new Response("NO_GENDER", null);
		$this->WRONG_GENDER = new Response("WRONG_GENDER", null);
		$this->NO_PHONENUMBER = new Response("NO_PHONENUMBER", null);
		$this->NO_USERID = new Response("NO_USERID", null);
		$this->NO_VERIFICATION = new Response("NO_VERIFICATION", null);
		$this->NO_LOGIN = new Response("NO_LOGIN", null);
		$this->SUCCESS = new Response("SUCCESS", null);
		$this->NO_OLD_PASSWORD = new Response("NO_OLD_PASSWORD", null);
		$this->NO_NEW_PASSWORD = new Response("NO_NEW_PASSWORD", null);

		$this->mailService = new MailService($_SERVER['HTTP_HOST']);

		$this->userService = new UserService(

			$this->dataRep->getHost(),
			$this->dataRep->getUser(),
			$this->dataRep->getPassword(),
			$this->dataRep->getDatabase(),
			$this->mailService,
			$this->logService

		);
		
		$this->userProblemController = new UserProblemController;
		$this->skinProblemController = new SkinProblemController;
	
	}
	
	public function login($email, $password) {
		
		$this->logService->logMessage("UserController Login");
		
		if (!isset($email))
			return $this->logResponse($this->NO_EMAIL);
		
		if (!isset($password))
			return $this->logResponse($this->NO_PASSWORD);
		
		return $this->logResponse($this->userService->login($email, $password));
		
	}
	
	// registering user
	public function register($email, $password, $repeat_password, $nickname) {
		
		$this->logService->logMessage("UserController Register");
		
		if (!isset($email))
			return $this->logResponse($this->NO_EMAIL);
		
		if (!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $email))
			return $this->INCORRECT_EMAIL;
		
		if (!isset($password))
			return $this->logResponse($this->NO_PASSWORD);
		
		if (!isset($repeat_password))
			return $this->logResponse($this->NO_REPEAT_PASSWORD);
		
		if ($password != $repeat_password)
			return $this->logResponse($this->DIFFERENT_PASSWORDS);
		
		if (!isset($nickname))
			return $this->logResponse($this->NO_NICKNAME);
		
		return $this->logResponse($this->userService->register($email, $password, $nickname));
		
	}
	
	// verifying user
	public function verify($userID, $verification) {
	
		$this->logService->logMessage("UserController Verify");
	
		if (!isset($userID))
			return $this->logResponse($this->NO_USERID);
		
		if (!isset($verification))
			return $this->logResponse($this->NO_VERIFICATION);
		
		return $this->logResponse($this->userService->verify($userID, $verification));
	
	}
	
	// getting public data of user by id from database
	public function getUser($userID) {
		
		$this->logService->logMessage("UserController GetUser");
		
		if (!isset($userID))
			return $this->logResponse($this->NO_USERID);
		
		return $this->logResponse($this->userService->getUser($userID));
		
	}
	
	public function getAverageSkinProblem($userID) {
		
		$this->logService->logMessage("UserController GetAverageSkinProblem");
		
		$userProblems = $this->userProblemController->getUserProblemsByUserID($userID);
		
		if ($userProblems->status != UserProblemController::SUCCESS)
			return $this->logResponse($userProblems);
		
		$userProblems = $userProblems->content;
		foreach ($userProblems as $key => &$value) {
		
			$userProblems[$key] = $this->skinProblemController->getSkinProblem($value->id)->content;
		
		}
		
		return $this->logResponse($this->skinProblemController->getAverageSkinProblem($userProblems));
		
	}
	
	public function editUser($userID, $nickname, $name, $gender, $phoneNumber) {
	
		$this->logService->logMessage("UserController EditUser");
	
		if (!isset($userID))
			return $this->logResponse($this->NO_USERID);
		
		if (!isset($nickname))
			return $this->logResponse($this->NO_NICKNAME);
		
		if (!isset($name))
			return $this->logResponse($this->NO_NAME);
		
		if (!isset($gender))
			return $this->logResponse($this->NO_GENDER);
		
		if ($gender != -1 && $gender != 0 && $gender != 1)
			return $this->logResponse($this->WRONG_GENDER);
		
		if (!isset($phoneNumber))
			return $this->logResponse($this->NO_PHONENUMBER);
		
		$dto = new UserDTO;
		$dto->id = $userID;
		$dto->nickname = $nickname;
		$dto->name = $name;
		$dto->gender = $gender;
		$dto->phoneNumber = $phoneNumber;
		
		return $this->logResponse($this->userService->updateUser($dto));
	
	}
	
	public function editPassword($userID, $oldPassword, $newPassword) {
	
		$this->logService->logMessage("UserController EditPassword");
	
		if (!isset($userID))
			return $this->logResponse($this->NO_USERID);
		
		if (!isset($oldPassword))
			return $this->logResponse($this->NO_OLD_PASSWORD);
		
		if (!isset($newPassword))
			return $this->logResponse($this->NO_NEW_PASSWORD);
		
		return $this->logResponse($this->userService->updatePassword($userID, $oldPassword, $newPassword));
	
	}
	
}

?>