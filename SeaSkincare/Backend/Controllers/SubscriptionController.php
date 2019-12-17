<?php

namespace SeaSkincare\Backend\Controllers;

use SeaSkincare\Backend\Data\DataRepository;
use SeaSkincare\Backend\Entities\Subscription;
use SeaSkincare\Backend\DTOs\SubscriptionDTO;
use SeaSkincare\Backend\Mappers\SubscriptionMapper;
use SeaSkincare\Backend\Services\SubscriptionService;
use SeaSkincare\Backend\Communication\Response;

class SubscriptionController
{
	
	private $dataRep;
	private $subscriptionService;
	
	public $SUCCESS = new Response("SUCCESS", null);
	public $NO_SUBSCRIPTIONID = new Response("NO_SUBSCRIPTIONID", null);
	public $NO_BUOYID = new Response("NO_BUOYID", null);
	public $NO_BUSINESSID = new Response("NO_BUSINESSID", null);
	public $NO_STARTDATE = new Response("NO_STARTDATE", null);
	public $INCORRECT_STARTDATE = new Response("NO_STARTDATE", null);
	public $NO_FINISHDATE = new Response("NO_FINISHDATE", null);
	public $INCORRECT_FINISHDATE = new Response("NO_STARTDATE", null);
	
	public function __construct() {
	
		$this->dataRep = new DataRepository;

		$this->subscriptionService = new SubscriptionService(

			$this->dataRep->getHost(),
			$this->dataRep->getUser(),
			$this->dataRep->getPassword(),
			$this->dataRep->getDatabase()

		);
	
	}
	
	public function createSubscription($buoyID, $businessID, $startDate, $finishDate) {
		
		if (!isset($buoyID))
			return$this->NO_BUOYID;
		
		if (!isset($businessID))
			return$this->NO_BUSINESSID;
		
		if (!isset($startDate))
			return$this->NO_STARTDATE;
		
		if (!isset($finishDate))
			return$this->NO_FINISHDATE;
		
		if (!((bool)(strtotime($startDate))))
			return$this->INCORRECT_STARTDATE;
		
		if (!((bool)(strtotime($finishDate))))
			return$this->INCORRECT_FINISHDATE;
		
		$dto = new SubscriptionDTO;
		$dto->buoyID = $buoyID;
		$dto->businessID = $businessID;
		$dto->startDate = $startDate;
		$dto->finishDate = $finishDate;
		
		return $this->subscriptionService->createSubscription($dto);
		
	}
	
	public function getSubscription($subscriptionID) {
		
		if (!isset($subscriptionID))
			return$this->NO_SUBSCRIPTIONID;
		
		return $this->subscriptionService->getSubscription($subscriptionID);
		
	}
	
	public function getSubscriptionsByIDs($buoyID, $businessID) {
		
		if (!isset($buoyID))
			return$this->NO_BUOYID;
		
		if (!isset($businessID))
			return$this->NO_BUSINESSID;
		
		return $this->subscriptionService->getSubscriptionsByIDs($buoyID, $businessID);
		
	}
	
	public function getSubscriptionsByBuoyID($buoyID) {
		
		if (!isset($buoyID))
			return$this->NO_BUOYID;
		
		return $this->subscriptionService->getSubscriptionsByBuoyID($buoyID);
		
	}
	
	public function getSubscriptionsByBusinessID($businessID) {
		
		if (!isset($businessID))
			return$this->NO_BUSINESSID;
		
		return $this->subscriptionService->getSubscriptionsByBusinessID($businessID);
		
	}
	
	public function getLastSubscription() {
		
		$subscriptionID = $this->subscriptionService->getLastID();
		if ($subscriptionID->status != SubscriptionService::SUCCESS->status)
			return $subscriptionID;
		
		return $this->subscriptionService->getSubscription($subscriptionID->content);
		
	}
	
	public function getLastSubscriptionByBuoyID($buoyID) {
		
		if (!isset($buoyID))
			return$this->NO_BUOYID;
		
		return $this->subscriptionService->getLastSubscriptionByBuoyID($buoyID);
		
	}
	
	public function editSubscription($subscriptionID, $startDate, $finishDate) {
		
		if (!isset($subscriptionID))
			return$this->NO_SUBSCRIPTIONID;
		
		if (!isset($startDate))
			return$this->NO_STARTDATE;
		
		if (!isset($finishDate))
			return$this->NO_FINISHDATE;
		
		if (!((bool)(strtotime($startDate))))
			return$this->INCORRECT_STARTDATE;
		
		if (!((bool)(strtotime($finishDate))))
			return$this->INCORRECT_FINISHDATE;
		
		$dto = new SubscriptionDTO;
		$dto->id = $subscriptionID;
		$dto->startDate = $startDate;
		$dto->finishDate = $finishDate;
		
		return $this->subscriptionService->updateSubscription($dto);
	
	}
	
	public function deleteSubscription($subscriptionID) {
	
		if (!isset($subscriptionID))
			return$this->NO_SUBSCRIPTIONID;
		
		return $this->subscriptionService->deleteSubscription($subscriptionID);
	
	}
	
}

?>