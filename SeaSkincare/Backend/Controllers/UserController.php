<?php

namespace SeaSkincare\Backend\Controllers;

use SeaSkincare\Backend\Data\DataRepository;
use SeaSkincare\Backend\Services\MailService;
use SeaSkincare\Backend\Entities\User;
use SeaSkincare\Backend\DTOs\UserDTO;
use SeaSkincare\Backend\Mappers\UserMapper;
use SeaSkincare\Backend\Services\UserService;
use SeaSkincare\Backend\Communication\Response;

class UserController
{
	
	private $dataRep;
	private $mailService;
	private $userService;
	
	public const NO_EMAIL = new Response("NO_EMAIL", null);
	public const NO_PASSWORD = new Response("NO_PASSWORD", null);
	public const NO_REPEAT_PASSWORD = new Response("NO_REPEAT_PASSWORD", null);
	public const DIFFERENT_PASSWORDS = new Response("DIFFERENT_PASSWORDS", null);
	public const NO_NICKNAME = new Response("NO_NICKNAME", null);
	public const NO_USERID = new Response("NO_USERID", null);
	public const NO_VERIFICATION = new Response("NO_VERIFICATION", null);
	public const NO_LOGIN = new Response("NO_LOGIN", null);
	public const SUCCESS = new Response("SUCCESS", null);
	public const NO_OLD_PASSWORD = new Response("NO_OLD_PASSWORD", null);
	public const NO_NEW_PASSWORD = new Response("NO_NEW_PASSWORD", null);
	
	
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
	
	}
	
	public function login($email, $password) {
		
		if (!isset($email))
			return self::NO_EMAIL;
		
		if (!isset($password))
			return self::NO_PASSWORD;
		
		return $this->userService->login($email, $password);
		
	}
	
	// registering user
	public function register($email, $password, $repeat_password, $nickname) {
		
		if (!isset($email))
			return self::NO_EMAIL;
		
		if (!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $email))
			return self::NO_PASSWORD;
		
		if (!isset($password))
			return self::NO_PASSWORD;
		
		if (!isset($repeat_password))
			return self::NO_REPEAT_PASSWORD;
		
		if ($password != $repeat_password)
			return self::DIFFERENT_PASSWORDS;
		
		if (!isset($nickname))
			return self::NO_NICKNAME;
		
		return $this->userService->register($email, $password, $nickname);
		
	}
	
	// verifying user
	public function verify($userID, $verification) {
	
		if (!isset($userID))
			return self::NO_USERID;
		
		if (!isset($verification))
			return self::NO_VERIFICATION;
		
		return $this->userService->verify($userID, $verification);
	
	}
	
	public function logout(&user) {
	
		if (!isset($user))
			return self::NO_LOGIN;
		
		unset($user);
		return self::SUCCESS;
	
	}
	
	// getting public data of user by id from database
	public function getUser($userID) {
		
		if (!isset($userID))
			return self::NO_USERID;
		
		return $this->userService->getUser($userID);
		
	}
	
	public function editUser($userID, $nickname, $email) {
	
		if (!isset($userID))
			return self::NO_USERID;
		
		if (!isset($nickname))
			return self::NO_NICKNAME;
		
		if (!isset($email))
			return self::NO_EMAIL;
		
		$dto = new UserDTO;
		$dto->id = $userID;
		$dto->nickname = $nickname;
		$dto->email = $email;
		
		return $this->userService->updateUser($dto);
	
	}
	
	public function editPassword($userID, $oldPassword, $newPassword) {
	
		if (!isset($userID))
			return self::NO_USERID;
		
		if (!isset($oldPassword))
			return self::NO_OLD_PASSWORD;
		
		if (!isset($newPassword))
			return self::NO_NEW_PASSWORD;
		
		return $this->userService->updatePassword($userID, $oldPassword, $newPassword);
	
	}
	
}

?>