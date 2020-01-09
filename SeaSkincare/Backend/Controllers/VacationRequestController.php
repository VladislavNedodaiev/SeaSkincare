<?php

namespace SeaSkincare\Backend\Controllers;

use SeaSkincare\Backend\Controllers\Controller;
use SeaSkincare\Backend\Services\LogService;
use SeaSkincare\Backend\Data\DataRepository;
use SeaSkincare\Backend\DTOs\VacationRequestDTO;
use SeaSkincare\Backend\Services\VacationRequestService;
use SeaSkincare\Backend\Communication\Response;

class VacationRequestController extends Controller
{
	
	private $vacationRequestService;
	
	public $SUCCESS;
	public $NO_VACATIONREQUESTID;
	public $NO_USERID;
	public $NO_BUSINESSID;
	public $NO_STATUS;
	public $INCORRECT_STATUS;
	
	public function __construct() {
		
		parent::__construct();
		
		$this->SUCCESS = new Response("SUCCESS", null);
		$this->NO_VACATIONREQUESTID = new Response("NO_VACATIONREQUESTID", null);
		$this->NO_USERID = new Response("NO_USERID", null);
		$this->NO_BUSINESSID = new Response("NO_BUSINESSID", null);
		$this->NO_STATUS = new Response("NO_STATUS", null);
		$this->INCORRECT_STATUS = new Response("INCORRECT_STATUS", null);

		$this->vacationRequestService = new VacationRequestService(

			$this->dataRep->getHost(),
			$this->dataRep->getUser(),
			$this->dataRep->getPassword(),
			$this->dataRep->getDatabase(),
			$this->logService

		);
	
	}
	
	public function createVacationRequest($userID, $businessID) {
		
		$this->logService->logMessage("VacationRequestController CreateVacationRequest");
		
		if (!isset($userID))
			return $this->logResponse($this->NO_USERID);
		
		if (!isset($businessID))
			return $this->logResponse($this->NO_BUSINESSID);
		
		$dto = new VacationRequestDTO;
		$dto->userID = $userID;
		$dto->businessID = $businessID;
		
		return $this->logResponse($this->vacationRequestService->createVacationRequest($dto));
		
	}
	
	public function getVacationRequest($vacationRequestID) {
		
		$this->logService->logMessage("VacationRequestController GetVacationRequest");
		
		if (!isset($vacationRequestID))
			return $this->logResponse($this->NO_VACATIONREQUESTID);
		
		return $this->logResponse($this->vacationRequestService->getVacationRequest($vacationRequestID));
		
	}
	
	public function getVacationRequestsByIDs($userID, $businessID) {
		
		$this->logService->logMessage("VacationRequestController GetVacationRequestsByIDs");
		
		if (!isset($userID))
			return $this->logResponse($this->NO_USERID);
		
		if (!isset($businessID))
			return $this->logResponse($this->NO_BUSINESSID);
		
		return $this->logResponse($this->vacationRequestService->getVacationRequestsByIDs($userID, $businessID));
		
	}
	
	public function getVacationRequestsByIDsStatus($userID, $businessID, $status) {
		
		$this->logService->logMessage("VacationRequestController GetVacationRequestsByIDsStatus");
		
		if (!isset($userID))
			return $this->logResponse($this->NO_USERID);
		
		if (!isset($businessID))
			return $this->logResponse($this->NO_BUSINESSID);
		
		if (!isset($status))
			return $this->logResponse($this->NO_STATUS);
		
		if ($status != -1 && $status != 0 && $status != 1)
			return $this->logResponse($this->INCORRECT_STATUS);
		
		return $this->logResponse($this->vacationRequestService->getVacationRequestsByIDsStatus($userID, $businessID, $status));
		
	}
	
	public function getVacationRequestsByUserID($userID) {
		
		$this->logService->logMessage("VacationRequestController GetVacationRequestsByUserID");
		
		if (!isset($userID))
			return $this->logResponse($this->NO_USERID);
		
		return $this->logResponse($this->vacationRequestService->getVacationRequestsByUserID($userID));
		
	}
	
	public function getVacationRequestsByUserIDStatus($userID, $status) {
		
		$this->logService->logMessage("VacationRequestController GetVacationRequestsByUserIDStatus");
		
		if (!isset($userID))
			return $this->logResponse($this->NO_USERID);
		
		if (!isset($status))
			return $this->logResponse($this->NO_STATUS);
		
		if ($status != -1 && $status != 0 && $status != 1)
			return $this->logResponse($this->INCORRECT_STATUS);
		
		return $this->logResponse($this->vacationRequestService->getVacationRequestsByUserIDStatus($userID, $status));
		
	}
	
	public function getVacationRequestsByBusinessID($businessID) {
		
		$this->logService->logMessage("VacationRequestController GetVacationRequestsByBusinessID");
		
		if (!isset($businessID))
			return $this->logResponse($this->NO_BUSINESSID);
		
		return $this->logResponse($this->vacationRequestService->getVacationRequestsByBusinessID($businessID));
		
	}
	
	public function getVacationRequestsByBusinessIDStatus($businessID, $status) {
		
		$this->logService->logMessage("VacationRequestController GetVacationRequestsByBusinessIDStatus");
		
		if (!isset($businessID))
			return $this->logResponse($this->NO_BUSINESSID);
		
		if (!isset($status))
			return $this->logResponse($this->NO_STATUS);
		
		if ($status != -1 && $status != 0 && $status != 1)
			return $this->logResponse($this->INCORRECT_STATUS);
		
		return $this->logResponse($this->vacationRequestService->getVacationRequestsByBusinessIDStatus($businessID, $status));
		
	}
	
	public function editVacationRequest($vacationRequestID, $status) {
		
		$this->logService->logMessage("VacationRequestController EditVacationRequest");
		
		if (!isset($vacationRequestID))
			return $this->logResponse($this->NO_VACATIONREQUESTID);
		
		if (!isset($status))
			return $this->logResponse($this->NO_STATUS);
		
		if ($status != -1 && $status != 0 && $status != 1)
			return $this->logResponse($this->INCORRECT_STATUS);
		
		$dto = new VacationRequestDTO;
		$dto->id = $vacationRequestID;
		$dto->status = $status;
		
		return $this->logResponse($this->vacationRequestService->updateVacationRequest($dto));
	
	}
	
	public function deleteVacationRequest($vacationRequestID) {
	
		$this->logService->logMessage("VacationRequestController DeleteVacationRequest");
	
		if (!isset($vacationRequestID))
			return $this->NO_VACATIONREQUESTIDID;
		
		return $this->logResponse($this->vacationRequestService->deleteVacationRequest($vacationRequestID));
	
	}
	
}

?>