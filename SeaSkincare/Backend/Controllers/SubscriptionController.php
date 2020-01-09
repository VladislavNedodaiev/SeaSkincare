<?php

namespace SeaSkincare\Backend\Controllers;

use SeaSkincare\Backend\Controllers\Controller;
use SeaSkincare\Backend\Services\LogService;
use SeaSkincare\Backend\Data\DataRepository;
use SeaSkincare\Backend\DTOs\SubscriptionDTO;
use SeaSkincare\Backend\Services\SubscriptionService;
use SeaSkincare\Backend\Communication\Response;

class SubscriptionController extends Controller
{
	
	private $subscriptionService;
	
	public $SUCCESS;
	public $NO_SUBSCRIPTIONID;
	public $NO_BUOYID;
	public $NO_BUSINESSID;
	public $NO_STARTDATE;
	public $INCORRECT_STARTDATE;
	public $NO_FINISHDATE;
	public $INCORRECT_FINISHDATE;
	public $NO_DATE;
	public $INCORRECT_DATE;
	
	public function __construct() {
		
		parent::__construct();
		
		$this->SUCCESS = new Response("SUCCESS", null);
		$this->NO_SUBSCRIPTIONID = new Response("NO_SUBSCRIPTIONID", null);
		$this->NO_BUOYID = new Response("NO_BUOYID", null);
		$this->NO_BUSINESSID = new Response("NO_BUSINESSID", null);
		$this->NO_STARTDATE = new Response("NO_STARTDATE", null);
		$this->INCORRECT_STARTDATE = new Response("NO_STARTDATE", null);
		$this->NO_FINISHDATE = new Response("NO_FINISHDATE", null);
		$this->INCORRECT_FINISHDATE = new Response("NO_STARTDATE", null);
		$this->NO_DATE = new Response("NO_DATE", null);
		$this->INCORRECT_DATE = new Response("INCORRECT_DATE", null);

		$this->subscriptionService = new SubscriptionService(

			$this->dataRep->getHost(),
			$this->dataRep->getUser(),
			$this->dataRep->getPassword(),
			$this->dataRep->getDatabase(),
			$this->logService

		);
	
	}
	
	public function createSubscription($buoyID, $businessID, $startDate, $finishDate) {
		
		$this->logService->logMessage("SubscriptionController CreateSubscription");
		
		if (!isset($buoyID))
			return $this->logResponse($this->NO_BUOYID);
		
		if (!isset($businessID))
			return $this->logResponse($this->NO_BUSINESSID);
		
		if (!isset($startDate))
			return $this->logResponse($this->NO_STARTDATE);
		
		if (!isset($finishDate))
			return $this->logResponse($this->NO_FINISHDATE);
		
		if (!((bool)(strtotime($startDate))))
			return $this->logResponse($this->INCORRECT_STARTDATE);
		
		if (!((bool)(strtotime($finishDate))))
			return $this->logResponse($this->INCORRECT_FINISHDATE);
		
		$dto = new SubscriptionDTO;
		$dto->buoyID = $buoyID;
		$dto->businessID = $businessID;
		$dto->startDate = $startDate;
		$dto->finishDate = $finishDate;
		
		return $this->logResponse($this->subscriptionService->createSubscription($dto));
		
	}
	
	public function getSubscription($subscriptionID) {
		
		$this->logService->logMessage("SubscriptionController GetSubscription");
		
		if (!isset($subscriptionID))
			return $this->logResponse($this->NO_SUBSCRIPTIONID);
		
		return $this->logResponse($this->subscriptionService->getSubscription($subscriptionID));
		
	}
	
	public function getSubscriptionsByIDs($buoyID, $businessID) {
		
		$this->logService->logMessage("SubscriptionController GetSubscriptionByIDs");
		
		if (!isset($buoyID))
			return $this->logResponse($this->NO_BUOYID);
		
		if (!isset($businessID))
			return $this->logResponse($this->NO_BUSINESSID);
		
		return $this->logResponse($this->subscriptionService->getSubscriptionsByIDs($buoyID, $businessID));
		
	}
	
	public function getSubscriptionsByBuoyID($buoyID) {
		
		$this->logService->logMessage("SubscriptionController GetSubscriptionByBuoyID");
		
		if (!isset($buoyID))
			return $this->logResponse($this->NO_BUOYID);
		
		return $this->logResponse($this->subscriptionService->getSubscriptionsByBuoyID($buoyID));
		
	}
	
	public function getSubscriptionsByBusinessID($businessID) {
		
		$this->logService->logMessage("SubscriptionController GetSubscriptionByBusinessID");
		
		if (!isset($businessID))
			return $this->logResponse($this->NO_BUSINESSID);
		
		return $this->logResponse($this->subscriptionService->getSubscriptionsByBusinessID($businessID));
		
	}
	
	public function getLastSubscription() {
		
		$this->logService->logMessage("SubscriptionController GetLastSubscription");
		
		$subscriptionID = $this->subscriptionService->getLastID();
		if ($subscriptionID->status != $this->subscriptionService->SUCCESS->status)
			return $this->logResponse($subscriptionID);
		
		return $this->logResponse($this->subscriptionService->getSubscription($subscriptionID->content));
		
	}
	
	public function getLastSubscriptionByBuoyID($buoyID) {
		
		$this->logService->logMessage("SubscriptionController GetLastSubscriptionByBuoyID");
		
		if (!isset($buoyID))
			return $this->logResponse($this->NO_BUOYID);
		
		return $this->logResponse($this->subscriptionService->getLastSubscriptionByBuoyID($buoyID));
		
	}
	
	public function getLastSubscriptionByBusinessID($businessID) {
		
		$this->logService->logMessage("SubscriptionController GetLastSubscriptionByBusinessID");
		
		if (!isset($businessID))
			return $this->logResponse($this->NO_BUSINESSID);
		
		return $this->logResponse($this->subscriptionService->getLastSubscriptionByBusinessID($buoyID));
		
	}
	
	public function getSubscriptionsActive($someDate, $offset, $limit) {
		
		$this->logService->logMessage("SubscriptionController GetSubscriptionsActive");
		
		if (!isset($someDate))
			return $this->logResponse($this->NO_DATE);
		
		if (!isset($offset))
			return $this->logResponse($this->NO_OFFSET);
		
		if (!isset($limit))
			return $this->logResponse($this->NO_LIMIT);
		
		if (!((bool)(strtotime($someDate))))
			return $this->logResponse($this->INCORRECT_DATE);
		
		if ($offset < 0)
			$offset = 0;
		
		if ($limit < 0)
			$limit = 0;
		
		return $this->logResponse($this->subscriptionService->getSubscriptionsActive($someDate, $offset, $limit));
		
	}
	
	public function getCountActiveDate($someDate) {
		
		$this->logService->logMessage("SubscriptionController GetCountActiveDate");
		
		if (!isset($someDate))
			return $this->logResponse($this->NO_DATE);
		
		if (!((bool)(strtotime($someDate))))
			return $this->logResponse($this->INCORRECT_DATE);
		
		return $this->logResponse($this->subscriptionService->getCountActiveDate($someDate));
		
	}
	
	public function editSubscription($subscriptionID, $startDate, $finishDate) {
		
		$this->logService->logMessage("SubscriptionController EditSubscription");
		
		if (!isset($subscriptionID))
			return $this->logResponse($this->NO_SUBSCRIPTIONID);
		
		if (!isset($startDate))
			return $this->logResponse($this->NO_STARTDATE);
		
		if (!isset($finishDate))
			return $this->logResponse($this->NO_FINISHDATE);
		
		if (!((bool)(strtotime($startDate))))
			return $this->logResponse($this->INCORRECT_STARTDATE);
		
		if (!((bool)(strtotime($finishDate))))
			return $this->logResponse($this->INCORRECT_FINISHDATE);
		
		$dto = new SubscriptionDTO;
		$dto->id = $subscriptionID;
		$dto->startDate = $startDate;
		$dto->finishDate = $finishDate;
		
		return $this->logResponse($this->subscriptionService->updateSubscription($dto));
	
	}
	
	public function deleteSubscription($subscriptionID) {
	
		$this->logService->logMessage("SubscriptionController DeleteSubscription");
	
		if (!isset($subscriptionID))
			return $this->logResponse($this->NO_SUBSCRIPTIONID);
		
		return $this->logResponse($this->subscriptionService->deleteSubscription($subscriptionID));
	
	}
	
}

?>