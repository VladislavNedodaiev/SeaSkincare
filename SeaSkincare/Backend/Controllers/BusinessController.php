<?php

namespace SeaSkincare\Backend\Controllers;

use SeaSkincare\Backend\Controllers\Controller;
use SeaSkincare\Backend\Services\LogService;
use SeaSkincare\Backend\Data\DataRepository;
use SeaSkincare\Backend\Services\MailService;
use SeaSkincare\Backend\DTOs\BusinessDTO;
use SeaSkincare\Backend\Services\BusinessService;
use SeaSkincare\Backend\Communication\Response;

use SeaSkincare\Backend\DTOs\SubscriptionDTO;
use SeaSkincare\Backend\Controllers\SubscriptionController;

class BusinessController extends Controller
{
	
	private $mailService;
	private $businessService;
	
	private $subscriptionController;
	
	public $NO_EMAIL;
	public $NO_PASSWORD;
	public $NO_REPEAT_PASSWORD;
	public $DIFFERENT_PASSWORDS;
	public $NO_NICKNAME;
	public $NO_DESCRIPTION;
	public $NO_PHOTO;
	public $NO_PHONENUMBER;
	public $NO_BUSINESSID;
	public $NO_VERIFICATION;
	public $NO_LOGIN;
	public $NO_OFFSET;
	public $NO_LIMIT;
	public $SUCCESS;
	public $NO_OLD_PASSWORD;
	public $NO_NEW_PASSWORD;
	
	public function __construct() {
		
		parent::__construct();
		
		$this->NO_EMAIL = new Response("NO_EMAIL", null);
		$this->NO_PASSWORD = new Response("NO_PASSWORD", null);
		$this->NO_REPEAT_PASSWORD = new Response("NO_REPEAT_PASSWORD", null);
		$this->DIFFERENT_PASSWORDS = new Response("DIFFERENT_PASSWORDS", null);
		$this->NO_NICKNAME = new Response("NO_NICKNAME", null);
		$this->NO_DESCRIPTION = new Response("NO_DESCRIPTION", null);
		$this->NO_PHOTO = new Response("NO_PHOTO", null);
		$this->NO_PHONENUMBER = new Response("NO_PHONENUMBER", null);
		$this->NO_BUSINESSID = new Response("NO_BUSINESSID", null);
		$this->NO_VERIFICATION = new Response("NO_VERIFICATION", null);
		$this->NO_LOGIN = new Response("NO_LOGIN", null);
		$this->NO_OFFSET = new Response("NO_OFFSET", null);
		$this->NO_LIMIT = new Response("NO_LIMIT", null);
		$this->SUCCESS = new Response("SUCCESS", null);
		$this->NO_OLD_PASSWORD = new Response("NO_OLD_PASSWORD", null);
		$this->NO_NEW_PASSWORD = new Response("NO_NEW_PASSWORD", null);

		$this->mailService = new MailService($_SERVER['HTTP_HOST']);

		$this->businessService = new BusinessService(

			$this->dataRep->getHost(),
			$this->dataRep->getUser(),
			$this->dataRep->getPassword(),
			$this->dataRep->getDatabase(),
			$this->mailService,
			$this->logService

		);
		
		$this->subscriptionController = new SubscriptionController;
	
	}
	
	public function login($email, $password) {
		
		$this->logService->logMessage("BusinessController Login");
		
		if (!isset($email))
			return $this->logResponse($this->NO_EMAIL);
		
		if (!isset($password))
			return $this->logResponse($this->NO_PASSWORD);
		
		return $this->logResponse($this->businessService->login($email, $password));
		
	}
	
	// registering user
	public function register($email, $password, $repeat_password, $nickname) {
		
		$this->logService->logMessage("BusinessController Register");
		
		if (!isset($email))
			return $this->logResponse($this->NO_EMAIL);
		
		if (!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $email))
			return $this->logResponse($this->NO_PASSWORD);
		
		if (!isset($password))
			return $this->logResponse($this->NO_PASSWORD);
		
		if (!isset($repeat_password))
			return $this->logResponse($this->NO_REPEAT_PASSWORD);
		
		if ($password != $repeat_password)
			return $this->logResponse($this->DIFFERENT_PASSWORDS);
		
		if (!isset($nickname))
			return $this->logResponse($this->NO_NICKNAME);
		
		return $this->logResponse($this->businessService->register($email, $password, $nickname));
		
	}
	
	// verifying user
	public function verify($businessID, $verification) {
	
		$this->logService->logMessage("BusinessController Verify");
	
		if (!isset($businessID))
			return $this->logResponse($this->NO_BUSINESSID);
		
		if (!isset($verification))
			return $this->logResponse($this->NO_VERIFICATION);
		
		return $this->logResponse($this->businessService->verify($businessID, $verification));
	
	}
	
	// getting public data of user by id from database
	public function getBusiness($businessID) {
		
		$this->logService->logMessage("BusinessController GetBusiness");
		
		if (!isset($businessID))
			return $this->logResponse($this->NO_BUSINESSID);
		
		return $this->logResponse($this->businessService->getBusiness($businessID));
		
	}
	
	// getting businesses from database
	// limit - how many
	// offset - from which entry
	public function getBusinesses($offset, $limit, $search = null) {
		
		$this->logService->logMessage("BusinessController GetBusinesses");
		
		if (!isset($offset))
			return $this->logResponse($this->NO_OFFSET);
		
		if (!isset($limit))
			return $this->logResponse($this->NO_LIMIT);
		
		if ($offset < 0)
			$offset = 0;
		
		if ($limit < 0)
			$limit = 0;
		
		return $this->logResponse($this->businessService->getBusinesses($offset, $limit, $search));
		
	}
	
	public function getCount($search = null) {
		
		$this->logService->logMessage("BusinessController GetCount");
		
		return $this->logResponse($this->businessService->getCount($search));
		
	}
	
	public function getBusinessesActiveSubscriptions($someDate, $offset, $limit) {
		
		$this->logService->logMessage("BusinessController GetBusinessesActiveSubscriptions");
		
		$subscriptions = $this->subscriptionController->getSubscriptionsActive($someDate, $offset, $limit);
		
		if ($subscriptions->status != $this->subscriptionController->SUCCESS->status)
			return $this->logResponse($subscriptions);
		
		$subscriptions = $subscriptions->content;
		
		$businesses = array();
		
		if ($subscriptions) {
			foreach ($subscriptions as &$value) {
			
				if (!isset($businesses[$value->businessID])) {
					$business = $this->getBusiness($value->businessID);
					if ($business->status == $this->SUCCESS->status)
						$businesses[$value->businessID]=$business->content;
				}
			
			}
		}
		
		return $this->logResponse(new Response($this->SUCCESS->status, $businesses));
		
	}
	
	public function editBusiness($businessID, $nickname, $description, $photo, $phoneNumber) {
	
		$this->logService->logMessage("BusinessController EditBusiness");
	
		if (!isset($businessID))
			return $this->logResponse($this->NO_BUSINESSID);
		
		if (!isset($nickname))
			return $this->logResponse($this->NO_NICKNAME);
		
		if (!isset($description))
			return $this->logResponse($this->NO_DESCRIPTION);
		
		if (!isset($photo))
			return $this->logResponse($this->NO_PHOTO);
		
		if (!isset($phoneNumber))
			return $this->logResponse($this->NO_PHONENUMBER);
		
		$dto = new BusinessDTO;
		$dto->id = $businessID;
		$dto->nickname = $nickname;
		$dto->description = $description;
		$dto->photo = $photo;
		$dto->phoneNumber = $phoneNumber;
		
		return $this->logResponse($this->businessService->updateBusiness($dto));
	
	}
	
	public function editPassword($businessID, $oldPassword, $newPassword) {
	
		$this->logService->logMessage("BusinessController EditPassword");
	
		if (!isset($businessID))
			return $this->logResponse($this->NO_BUSINESSID);
		
		if (!isset($oldPassword))
			return $this->logResponse($this->NO_OLD_PASSWORD);
		
		if (!isset($newPassword))
			return $this->logResponse($this->NO_NEW_PASSWORD);
		
		return $this->logResponse($this->businessService->updatePassword($businessID, $oldPassword, $newPassword));
	
	}
	
}

?>