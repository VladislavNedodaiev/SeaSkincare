<?php

namespace SeaSkincare\Backend\Controllers;

use SeaSkincare\Backend\Data\DataRepository;
use SeaSkincare\Backend\Services\MailService;
use SeaSkincare\Backend\DTOs\UserDTO;
use SeaSkincare\Backend\Services\UserService;
use SeaSkincare\Backend\Communication\Response;

use SeaSkincare\Backend\DTOs\VacationDTO;
use SeaSkincare\Backend\Controllers\VacationController;

use SeaSkincare\Backend\DTOs\UserProblemDTO;
use SeaSkincare\Backend\Controllers\UserProblemController;

use SeaSkincare\Backend\DTOs\SkinProblemDTO;
use SeaSkincare\Backend\Controllers\SkinProblemController;

class UserController {
	
	private $dataRep;
	private $mailService;
	private $userService;
	
	private $vacationController;
	private $userProblemController;
	private $skinProblemController;
	
	public $NO_EMAIL = new Response("NO_EMAIL", null);
	public $INCORRECT_EMAIL = new Response("INCORRECT_EMAIL", null);
	public $NO_PASSWORD = new Response("NO_PASSWORD", null);
	public $NO_REPEAT_PASSWORD = new Response("NO_REPEAT_PASSWORD", null);
	public $DIFFERENT_PASSWORDS = new Response("DIFFERENT_PASSWORDS", null);
	public $NO_NICKNAME = new Response("NO_NICKNAME", null);
	public $NO_USERID = new Response("NO_USERID", null);
	public $NO_VERIFICATION = new Response("NO_VERIFICATION", null);
	public $NO_LOGIN = new Response("NO_LOGIN", null);
	public $SUCCESS = new Response("SUCCESS", null);
	public $NO_OLD_PASSWORD = new Response("NO_OLD_PASSWORD", null);
	public $NO_NEW_PASSWORD = new Response("NO_NEW_PASSWORD", null);
	
	
	public function __construct() {
	
		$this->dataRep = new DataRepository;

		$this->mailService = new MailService($_SERVER['HTTP_HOST']);

		$this->userService = new UserService(

			$this->dataRep->getHost(),
			$this->dataRep->getUser(),
			$this->dataRep->getPassword(),
			$this->dataRep->getDatabase(),
			$this->mailService

		);
		
		$this->vacationController = new VacationController;
		$this->userProblemController = new UserProblemController;
		$this->skinProblemController = new SkinProblemController;
	
	}
	
	public function login($email, $password) {
		
		if (!isset($email))
			return$this->NO_EMAIL;
		
		if (!isset($password))
			return$this->NO_PASSWORD;
		
		return $this->userService->login($email, $password);
		
	}
	
	// registering user
	public function register($email, $password, $repeat_password, $nickname) {
		
		if (!isset($email))
			return$this->NO_EMAIL;
		
		if (!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $email))
			return$this->INCORRECT_EMAIL;
		
		if (!isset($password))
			return$this->NO_PASSWORD;
		
		if (!isset($repeat_password))
			return$this->NO_REPEAT_PASSWORD;
		
		if ($password != $repeat_password)
			return$this->DIFFERENT_PASSWORDS;
		
		if (!isset($nickname))
			return$this->NO_NICKNAME;
		
		return $this->userService->register($email, $password, $nickname);
		
	}
	
	// verifying user
	public function verify($userID, $verification) {
	
		if (!isset($userID))
			return$this->NO_USERID;
		
		if (!isset($verification))
			return$this->NO_VERIFICATION;
		
		return $this->userService->verify($userID, $verification);
	
	}
	
	public function logout(&user) {
	
		if (!isset($user))
			return$this->NO_LOGIN;
		
		unset($user);
		return$this->SUCCESS;
	
	}
	
	// getting public data of user by id from database
	public function getUser($userID) {
		
		if (!isset($userID))
			return$this->NO_USERID;
		
		return $this->userService->getUser($userID);
		
	}
	
	public function getAverageSkinProblem($userID) {
		
		$userProblems = $this->userProblemController->getUserProblemsByUserID($userID);
		
		if ($userProblems->status != UserProblemController::SUCCESS)
			return $userProblems;
		
		$userProblems = $userProblems->content;
		foreach ($userProblems as $key => &$value) {
		
			$userProblems[$key] = $this->skinProblemController->getSkinProblem($value->id)->content;
		
		}
		
		return $this->skinProblemController->getAverageSkinProblem($userProblems);
		
	}
	
	public function editUser($userID, $nickname, $email) {
	
		if (!isset($userID))
			return$this->NO_USERID;
		
		if (!isset($nickname))
			return$this->NO_NICKNAME;
		
		if (!isset($email))
			return$this->NO_EMAIL;
		
		$dto = new UserDTO;
		$dto->id = $userID;
		$dto->nickname = $nickname;
		$dto->email = $email;
		
		return $this->userService->updateUser($dto);
	
	}
	
	public function editPassword($userID, $oldPassword, $newPassword) {
	
		if (!isset($userID))
			return$this->NO_USERID;
		
		if (!isset($oldPassword))
			return$this->NO_OLD_PASSWORD;
		
		if (!isset($newPassword))
			return$this->NO_NEW_PASSWORD;
		
		return $this->userService->updatePassword($userID, $oldPassword, $newPassword);
	
	}
	
}

?>