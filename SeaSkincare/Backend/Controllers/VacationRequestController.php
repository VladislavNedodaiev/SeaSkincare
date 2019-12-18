<?php

namespace SeaSkincare\Backend\Controllers;

use SeaSkincare\Backend\Data\DataRepository;
use SeaSkincare\Backend\DTOs\VacationRequestDTO;
use SeaSkincare\Backend\Services\VacationRequestService;
use SeaSkincare\Backend\Communication\Response;

class VacationRequestController
{
	
	private $dataRep;
	private $vacationRequestService;
	
	public $SUCCESS;
	public $NO_VACATIONREQUESTID;
	public $NO_USERID;
	public $NO_BUSINESSID;
	public $NO_STATUS;
	
	public function __construct() {
		
		$this->SUCCESS = new Response("SUCCESS", null);
		$this->NO_VACATIONREQUESTID = new Response("NO_VACATIONREQUESTID", null);
		$this->NO_USERID = new Response("NO_USERID", null);
		$this->NO_BUSINESSID = new Response("NO_BUSINESSID", null);
		$this->NO_STATUS = new Response("NO_STATUS", null);
		
		$this->dataRep = new DataRepository;

		$this->vacationRequestService = new VacationRequestService(

			$this->dataRep->getHost(),
			$this->dataRep->getUser(),
			$this->dataRep->getPassword(),
			$this->dataRep->getDatabase()

		);
	
	}
	
	public function createVacationRequest($userID, $businessID) {
		
		if (!isset($userID))
			return $this->NO_USERID;
		
		if (!isset($businessID))
			return $this->NO_BUSINESSID;
		
		$dto = new VacationRequestDTO;
		$dto->userID = $userID;
		$dto->businessID = $businessID;
		
		return $this->vacationRequestService->createVacationRequest($dto);
		
	}
	
	public function getVacationRequest($vacationRequestID) {
		
		if (!isset($vacationRequestID))
			return $this->NO_VACATIONREQUESTID;
		
		return $this->vacationRequestService->getVacationRequest($vacationRequestID);
		
	}
	
	public function getVacationRequestsByIDs($userID, $businessID) {
		
		if (!isset($userID))
			return $this->NO_USERID;
		
		if (!isset($businessID))
			return $this->NO_BUSINESSID;
		
		return $this->vacationRequestService->getVacationRequestsByIDs($userID, $businessID);
		
	}
	
	public function getVacationRequestsByIDsStatus($userID, $businessID, $status) {
		
		if (!isset($userID))
			return $this->NO_USERID;
		
		if (!isset($businessID))
			return $this->NO_BUSINESSID;
		
		if (!isset($status))
			return $this->NO_STATUS;
		
		return $this->vacationRequestService->getVacationRequestsByIDsStatus($userID, $businessID, $status);
		
	}
	
	public function getVacationRequestsByUserID($userID) {
		
		if (!isset($userID))
			return $this->NO_USERID;
		
		return $this->vacationService->getVacationsByUserID($userID);
		
	}
	
	public function getVacationRequestsByUserIDStatus($userID, $status) {
		
		if (!isset($userID))
			return $this->NO_USERID;
		
		if (!isset($status))
			return $this->NO_STATUS;
		
		return $this->vacationService->getVacationsByUserIDStatus($userID, $status);
		
	}
	
	public function getVacationRequestsByBusinessID($businessID) {
		
		if (!isset($businessID))
			return $this->NO_BUSINESSID;
		
		return $this->vacationService->getVacationsByBusinessID($businessID);
		
	}
	
	public function getVacationRequestsByBusinessIDStatus($businessID, $status) {
		
		if (!isset($businessID))
			return $this->NO_BUSINESSID;
		
		if (!isset($status))
			return $this->NO_STATUS;
		
		return $this->vacationService->getVacationsByBusinessIDStatus($businessID, $status);
		
	}
	
	public function editVacationRequest($vacationRequestID, $status) {
		
		if (!isset($vacationRequestID))
			return $this->NO_VACATIONREQUESTID;
		
		if (!isset($status))
			return $this->NO_STATUS;
		
		$dto = new VacationRequestDTO;
		$dto->id = $vacationRequestID;
		$dto->status = $status;
		
		return $this->vacationRequestService->updateVacationRequest($dto);
	
	}
	
	public function deleteVacationRequest($vacationRequestID) {
	
		if (!isset($vacationRequestID))
			return $this->NO_VACATIONREQUESTIDID;
		
		return $this->vacationRequestService->deleteVacationRequest($vacationRequestID);
	
	}
	
}

?>