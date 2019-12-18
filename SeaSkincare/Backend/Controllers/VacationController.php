<?php

namespace SeaSkincare\Backend\Controllers;

use SeaSkincare\Backend\Data\DataRepository;
use SeaSkincare\Backend\DTOs\VacationDTO;
use SeaSkincare\Backend\Services\VacationService;
use SeaSkincare\Backend\Communication\Response;

class VacationController
{
	
	private $dataRep;
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
		
		$this->dataRep = new DataRepository;

		$this->vacationService = new VacationService(

			$this->dataRep->getHost(),
			$this->dataRep->getUser(),
			$this->dataRep->getPassword(),
			$this->dataRep->getDatabase()

		);
	
	}
	
	public function createVacation($userID, $businessID, $startDate, $finishDate) {
		
		if (!isset($userID))
			return $this->NO_USERID;
		
		if (!isset($businessID))
			return $this->NO_BUSINESSID;
		
		if (!isset($startDate))
			return $this->NO_STARTDATE;
		
		if (!isset($finishDate))
			return $this->NO_FINISHDATE;
		
		if (!((bool)(strtotime($startDate))))
			return $this->INCORRECT_STARTDATE;
		
		if (!((bool)(strtotime($finishDate))))
			return $this->INCORRECT_FINISHDATE;
		
		$dto = new VacationDTO;
		$dto->userID = $userID;
		$dto->businessID = $businessID;
		$dto->startDate = $startDate;
		$dto->finishDate = $finishDate;
		
		return $this->vacationService->createVacation($dto);
		
	}
	
	public function getVacation($vacationID) {
		
		if (!isset($vacationID))
			return $this->NO_VACATIONID;
		
		return $this->vacationService->getVacation($vacationID);
		
	}
	
	public function getVacationsByIDs($userID, $businessID) {
		
		if (!isset($userID))
			return $this->NO_USERID;
		
		if (!isset($businessID))
			return $this->NO_BUSINESSID;
		
		return $this->vacationService->getVacationsByIDs($userID, $businessID);
		
	}
	
	// dateFlag - ended before someDate (<0), active at someDate (0), starting after someDate (>0)
	// someDate - some date
	public function getVacationsByIDsDate($userID, $businessID, $dateFlag, $someDate) {
		
		if (!isset($userID))
			return $this->NO_USERID;
		
		if (!isset($businessID))
			return $this->NO_BUSINESSID;
		
		if (!isset($dateFlag))
			return $this->NO_DATEFLAG;
		
		if (!isset($someDate))
			return $this->NO_DATE;
		
		if (!((bool)(strtotime($someDate))))
			return $this->INCORRECT_DATE;
		
		return $this->vacationService->getVacationsByIDsDate($userID, $businessID, $dateFlag, $someDate);
		
	}
	
	public function getVacationsByUserID($userID) {
		
		if (!isset($userID))
			return $this->NO_USERID;
		
		return $this->vacationService->getVacationsByUserID($userID);
		
	}
	
	// dateFlag - ended before someDate (<0), active at someDate (0), starting after someDate (>0)
	// someDate - some date
	public function getVacationsByUserIDDate($userID, $dateFlag, $someDate) {
		
		if (!isset($userID))
			return $this->NO_USERID;
		
		if (!isset($dateFlag))
			return $this->NO_DATEFLAG;
		
		if (!isset($someDate))
			return $this->NO_DATE;
		
		if (!((bool)(strtotime($someDate))))
			return $this->INCORRECT_DATE;
		
		return $this->vacationService->getVacationsByUserIDDate($userID, $dateFlag, $someDate);
		
	}
	
	public function getVacationsByBusinessID($businessID) {
		
		if (!isset($businessID))
			return $this->NO_BUSINESSID;
		
		return $this->vacationService->getVacationsByBusinessID($businessID);
		
	}
	
	// dateFlag - ended before someDate (<0), active at someDate (0), starting after someDate (>0)
	// someDate - some date
	public function getVacationsByBusinessIDDate($businessID, $dateFlag, $someDate) {
		
		if (!isset($businessID))
			return $this->NO_BUSINESSID;
		
		if (!isset($dateFlag))
			return $this->NO_DATEFLAG;
		
		if (!isset($someDate))
			return $this->NO_DATE;
		
		if (!((bool)(strtotime($someDate))))
			return $this->INCORRECT_DATE;
		
		return $this->vacationService->getVacationsByBusinessIDDate($businessID, $dateFlag, $someDate);
		
	}
	
	public function editVacation($vacationID, $startDate, $finishDate) {
		
		if (!isset($userID))
			return $this->NO_USERID;
		
		if (!isset($businessID))
			return $this->NO_BUSINESSID;
		
		if (!isset($startDate))
			return $this->NO_STARTDATE;
		
		if (!isset($finishDate))
			return $this->NO_FINISHDATE;
		
		if (!((bool)(strtotime($startDate))))
			return $this->INCORRECT_STARTDATE;
		
		if (!((bool)(strtotime($finishDate))))
			return $this->INCORRECT_FINISHDATE;
		
		$dto = new VacationDTO;
		$dto->id = $vacationID;
		$dto->startDate = $startDate;
		$dto->finishDate = $finishDate;
		
		return $this->vacationService->updateVacation($dto);
	
	}
	
	public function deleteVacation($vacationID) {
	
		if (!isset($vacationID))
			return $this->NO_VACATIONID;
		
		return $this->vacationService->deleteVacation($vacationID);
	
	}
	
}

?>