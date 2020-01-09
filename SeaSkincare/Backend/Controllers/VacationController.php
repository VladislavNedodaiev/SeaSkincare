<?php

namespace SeaSkincare\Backend\Controllers;

use SeaSkincare\Backend\Controllers\Controller;
use SeaSkincare\Backend\Services\LogService;
use SeaSkincare\Backend\Data\DataRepository;
use SeaSkincare\Backend\DTOs\VacationDTO;
use SeaSkincare\Backend\Services\VacationService;
use SeaSkincare\Backend\Communication\Response;

class VacationController extends Controller
{
	
	private $vacationService;
	
	public $SUCCESS;
	public $NO_VACATIONID;
	public $NO_USERID;
	public $NO_BUSINESSID;
	public $NO_STARTDATE;
	public $NO_FINISHDATE;
	public $NO_DATEFLAG;	
	public $NO_DATE;
	public $INCORRECT_DATE;
	public $INCORRECT_STARTDATE;
	public $INCORRECT_FINISHDATE;
	
	public function __construct() {
		
		parent::__construct();
		
		$this->SUCCESS = new Response("SUCCESS", null);
		$this->NO_VACATIONID = new Response("NO_VACATIONID", null);
		$this->NO_USERID = new Response("NO_USERID", null);
		$this->NO_BUSINESSID = new Response("NO_BUSINESSID", null);
		$this->NO_STARTDATE = new Response("NO_STARTDATE", null);
		$this->NO_FINISHDATE = new Response("NO_FINISHDATE", null);
		$this->NO_DATEFLAG = new Response("NO_DATEFLAG", null);
		$this->NO_DATE = new Response("NO_DATE", null);
		$this->INCORRECT_DATE = new Response("INCORRECT_DATE", null);
		$this->INCORRECT_STARTDATE = new Response("INCORRECT_STARTDATE", null);
		$this->INCORRECT_FINISHDATE = new Response("INCORRECT_FINISHDATE", null);

		$this->vacationService = new VacationService(

			$this->dataRep->getHost(),
			$this->dataRep->getUser(),
			$this->dataRep->getPassword(),
			$this->dataRep->getDatabase(),
			$this->logService

		);
	
	}
	
	public function createVacation($userID, $businessID, $startDate, $finishDate) {
		
		$this->logService->logMessage("VacationController CreateVacation");
		
		if (!isset($userID))
			return $this->logResponse($this->NO_USERID);
		
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
		
		$dto = new VacationDTO;
		$dto->userID = $userID;
		$dto->businessID = $businessID;
		$dto->startDate = $startDate;
		$dto->finishDate = $finishDate;
		
		return $this->logResponse($this->vacationService->createVacation($dto));
		
	}
	
	public function getVacation($vacationID) {
		
		$this->logService->logMessage("VacationController GetVacation");
		
		if (!isset($vacationID))
			return $this->logResponse($this->NO_VACATIONID);
		
		return $this->logResponse($this->vacationService->getVacation($vacationID));
		
	}
	
	public function getVacationsByIDs($userID, $businessID) {
		
		$this->logService->logMessage("VacationController GetVacationsByIDs");
		
		if (!isset($userID))
			return $this->logResponse($this->NO_USERID);
		
		if (!isset($businessID))
			return $this->logResponse($this->NO_BUSINESSID);
		
		return $this->logResponse($this->vacationService->getVacationsByIDs($userID, $businessID));
		
	}
	
	// dateFlag - ended before someDate (<0), active at someDate (0), starting after someDate (>0)
	// someDate - some date
	public function getVacationsByIDsDate($userID, $businessID, $dateFlag, $someDate) {
		
		$this->logService->logMessage("VacationController GetVacationsByIDsDate");
		
		if (!isset($userID))
			return $this->logResponse($this->NO_USERID);
		
		if (!isset($businessID))
			return $this->logResponse($this->NO_BUSINESSID);
		
		if (!isset($dateFlag))
			return $this->logResponse($this->NO_DATEFLAG);
		
		if (!isset($someDate))
			return $this->logResponse($this->NO_DATE);
		
		if (!((bool)(strtotime($someDate))))
			return $this->logResponse($this->INCORRECT_DATE);
		
		return $this->logResponse($this->vacationService->getVacationsByIDsDate($userID, $businessID, $dateFlag, $someDate));
		
	}
	
	public function getVacationsByUserID($userID) {
		
		$this->logService->logMessage("VacationController GetVacationsByUserID");
		
		if (!isset($userID))
			return $this->logResponse($this->NO_USERID);
		
		return $this->logResponse($this->vacationService->getVacationsByUserID($userID));
		
	}
	
	// dateFlag - ended before someDate (<0), active at someDate (0), starting after someDate (>0)
	// someDate - some date
	public function getVacationsByUserIDDate($userID, $dateFlag, $someDate) {
		
		$this->logService->logMessage("VacationController GetVacationsByUserIDDate");
		
		if (!isset($userID))
			return $this->logResponse($this->NO_USERID);
		
		if (!isset($dateFlag))
			return $this->logResponse($this->NO_DATEFLAG);
		
		if (!isset($someDate))
			return $this->logResponse($this->NO_DATE);
		
		if (!((bool)(strtotime($someDate))))
			return $this->logResponse($this->INCORRECT_DATE);
		
		return $this->logResponse($this->vacationService->getVacationsByUserIDDate($userID, $dateFlag, $someDate));
		
	}
	
	public function getVacationsByBusinessID($businessID) {
		
		$this->logService->logMessage("VacationController GetVacationsByBusinessID");
		
		if (!isset($businessID))
			return $this->logResponse($this->NO_BUSINESSID);
		
		return $this->logResponse($this->vacationService->getVacationsByBusinessID($businessID));
		
	}
	
	// dateFlag - ended before someDate (<0), active at someDate (0), starting after someDate (>0)
	// someDate - some date
	public function getVacationsByBusinessIDDate($businessID, $dateFlag, $someDate) {
		
		$this->logService->logMessage("VacationController GetVacationsByBusinessIDDate");
		
		if (!isset($businessID))
			return $this->logResponse($this->NO_BUSINESSID);
		
		if (!isset($dateFlag))
			return $this->logResponse($this->NO_DATEFLAG);
		
		if (!isset($someDate))
			return $this->logResponse($this->NO_DATE);
		
		if (!((bool)(strtotime($someDate))))
			return $this->logResponse($this->INCORRECT_DATE);
		
		return $this->logResponse($this->vacationService->getVacationsByBusinessIDDate($businessID, $dateFlag, $someDate));
		
	}
	
	public function editVacation($vacationID, $startDate, $finishDate) {
		
		$this->logService->logMessage("VacationController EditVacation");
		
		if (!isset($userID))
			return $this->logResponse($this->NO_USERID);
		
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
		
		$dto = new VacationDTO;
		$dto->id = $vacationID;
		$dto->startDate = $startDate;
		$dto->finishDate = $finishDate;
		
		return $this->logResponse($this->vacationService->updateVacation($dto));
	
	}
	
	public function deleteVacation($vacationID) {
	
		$this->logService->logMessage("VacationController DeleteVacation");
	
		if (!isset($vacationID))
			return $this->logResponse($this->NO_VACATIONID);
		
		return $this->logResponse($this->vacationService->deleteVacation($vacationID));
	
	}
	
}

?>