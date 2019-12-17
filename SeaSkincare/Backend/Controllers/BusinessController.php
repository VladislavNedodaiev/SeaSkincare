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
	
	public $NO_EMAIL = new Response("NO_EMAIL", null);
	public $NO_PASSWORD = new Response("NO_PASSWORD", null);
	public $NO_REPEAT_PASSWORD = new Response("NO_REPEAT_PASSWORD", null);
	public $DIFFERENT_PASSWORDS = new Response("DIFFERENT_PASSWORDS", null);
	public $NO_NICKNAME = new Response("NO_NICKNAME", null);
	public $NO_BUSINESSID = new Response("NO_BUSINESSID", null);
	public $NO_VERIFICATION = new Response("NO_VERIFICATION", null);
	public $NO_LOGIN = new Response("NO_LOGIN", null);
	public $SUCCESS = new Response("SUCCESS", null);
	public $NO_OLD_PASSWORD = new Response("NO_OLD_PASSWORD", null);
	public $NO_NEW_PASSWORD = new Response("NO_NEW_PASSWORD", null);
	
	
	public function __construct() {
	
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
			return this->NO_EMAIL;
		
		if (!isset($password))
			return this->NO_PASSWORD;
		
		return $this->businessService->login($email, $password);
		
	}
	
	// registering user
	public function register($email, $password, $repeat_password, $nickname) {
		
		if (!isset($email))
			return this->NO_EMAIL;
		
		if (!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $email))
			return this->NO_PASSWORD;
		
		if (!isset($password))
			return this->NO_PASSWORD;
		
		if (!isset($repeat_password))
			return this->NO_REPEAT_PASSWORD;
		
		if ($password != $repeat_password)
			return this->DIFFERENT_PASSWORDS;
		
		if (!isset($nickname))
			return this->NO_NICKNAME;
		
		return $this->businessService->register($email, $password, $nickname);
		
	}
	
	// verifying user
	public function verify($businessID, $verification) {
	
		if (!isset($businessID))
			return this->NO_BUSINESSID;
		
		if (!isset($verification))
			return this->NO_VERIFICATION;
		
		return $this->businessService->verify($businessID, $verification);
	
	}
	
	public function logout(&business) {
	
		if (!isset($business))
			return this->NO_LOGIN;
		
		unset($business);
		return this->SUCCESS;
	
	}
	
	// getting public data of user by id from database
	public function getBusiness($businessID) {
		
		if (!isset($businessID))
			return this->NO_BUSINESSID;
		
		return $this->$businessService->getBusiness($businessID);
		
	}
	
	public function editBusiness($businessID, $nickname, $email) {
	
		if (!isset($businessID))
			return this->NO_BUSINESSID;
		
		if (!isset($nickname))
			return this->NO_NICKNAME;
		
		if (!isset($email))
			return this->NO_EMAIL;
		
		$dto = new BusinessDTO;
		$dto->id = $businessID;
		$dto->nickname = $nickname;
		$dto->email = $email;
		
		return $this->businessService->updateBusiness($dto);
	
	}
	
	public function editPassword($businessID, $oldPassword, $newPassword) {
	
		if (!isset($businessID))
			return this->NO_BUSINESSID;
		
		if (!isset($oldPassword))
			return this->NO_OLD_PASSWORD;
		
		if (!isset($newPassword))
			return this->NO_NEW_PASSWORD;
		
		return $this->businessService->updatePassword($businessID, $oldPassword, $newPassword);
	
	}
	
}

?>