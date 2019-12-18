<?php

namespace SeaSkincare\Backend\Controllers;

use SeaSkincare\Backend\Data\DataRepository;
use SeaSkincare\Backend\Services\MailService;
use SeaSkincare\Backend\Entities\Business;
use SeaSkincare\Backend\DTOs\BusinessDTO;
use SeaSkincare\Backend\Mappers\BusinessMapper;
use SeaSkincare\Backend\Services\BusinessService;
use SeaSkincare\Backend\Communication\Response;

class BusinessController
{
	
	private $dataRep;
	private $mailService;
	private $businessService;
	
	public $NO_EMAIL;
	public $NO_PASSWORD;
	public $NO_REPEAT_PASSWORD;
	public $DIFFERENT_PASSWORDS;
	public $NO_NICKNAME;
	public $NO_BUSINESSID;
	public $NO_VERIFICATION;
	public $NO_LOGIN;
	public $SUCCESS;
	public $NO_OLD_PASSWORD;
	public $NO_NEW_PASSWORD;
	
	
	public function __construct() {
		
		$this->NO_EMAIL = new Response("NO_EMAIL", null);
		$this->NO_PASSWORD = new Response("NO_PASSWORD", null);
		$this->NO_REPEAT_PASSWORD = new Response("NO_REPEAT_PASSWORD", null);
		$this->DIFFERENT_PASSWORDS = new Response("DIFFERENT_PASSWORDS", null);
		$this->NO_NICKNAME = new Response("NO_NICKNAME", null);
		$this->NO_BUSINESSID = new Response("NO_BUSINESSID", null);
		$this->NO_VERIFICATION = new Response("NO_VERIFICATION", null);
		$this->NO_LOGIN = new Response("NO_LOGIN", null);
		$this->SUCCESS = new Response("SUCCESS", null);
		$this->NO_OLD_PASSWORD = new Response("NO_OLD_PASSWORD", null);
		$this->NO_NEW_PASSWORD = new Response("NO_NEW_PASSWORD", null);
		
		$this->dataRep = new DataRepository;

		$this->mailService = new MailService($_SERVER['HTTP_HOST']);

		$this->businessService = new BusinessService(

			$this->dataRep->getHost(),
			$this->dataRep->getUser(),
			$this->dataRep->getPassword(),
			$this->dataRep->getDatabase(),
			$this->mailService

		);
	
	}
	
	public function login($email, $password) {
		
		if (!isset($email))
			return $this->NO_EMAIL;
		
		if (!isset($password))
			return $this->NO_PASSWORD;
		
		return $this->businessService->login($email, $password);
		
	}
	
	// registering user
	public function register($email, $password, $repeat_password, $nickname) {
		
		if (!isset($email))
			return $this->NO_EMAIL;
		
		if (!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $email))
			return $this->NO_PASSWORD;
		
		if (!isset($password))
			return $this->NO_PASSWORD;
		
		if (!isset($repeat_password))
			return $this->NO_REPEAT_PASSWORD;
		
		if ($password != $repeat_password)
			return $this->DIFFERENT_PASSWORDS;
		
		if (!isset($nickname))
			return $this->NO_NICKNAME;
		
		return $this->businessService->register($email, $password, $nickname);
		
	}
	
	// verifying user
	public function verify($businessID, $verification) {
	
		if (!isset($businessID))
			return $this->NO_BUSINESSID;
		
		if (!isset($verification))
			return $this->NO_VERIFICATION;
		
		return $this->businessService->verify($businessID, $verification);
	
	}
	
	// getting public data of user by id from database
	public function getBusiness($businessID) {
		
		if (!isset($businessID))
			return $this->NO_BUSINESSID;
		
		return $this->$businessService->getBusiness($businessID);
		
	}
	
	public function editBusiness($businessID, $nickname, $email) {
	
		if (!isset($businessID))
			return $this->NO_BUSINESSID;
		
		if (!isset($nickname))
			return $this->NO_NICKNAME;
		
		if (!isset($email))
			return $this->NO_EMAIL;
		
		$dto = new BusinessDTO;
		$dto->id = $businessID;
		$dto->nickname = $nickname;
		$dto->email = $email;
		
		return $this->businessService->updateBusiness($dto);
	
	}
	
	public function editPassword($businessID, $oldPassword, $newPassword) {
	
		if (!isset($businessID))
			return $this->NO_BUSINESSID;
		
		if (!isset($oldPassword))
			return $this->NO_OLD_PASSWORD;
		
		if (!isset($newPassword))
			return $this->NO_NEW_PASSWORD;
		
		return $this->businessService->updatePassword($businessID, $oldPassword, $newPassword);
	
	}
	
}

?>