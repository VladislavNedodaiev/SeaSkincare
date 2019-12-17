<?php

namespace SeaSkincare\Backend\Controllers;

use SeaSkincare\Backend\Data\DataRepository;
use SeaSkincare\Backend\Entities\Vacation;
use SeaSkincare\Backend\DTOs\VacationDTO;
use SeaSkincare\Backend\Mappers\VacationMapper;
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
	
	public function __construct() {
		
		$SUCCESS = new Response("SUCCESS", null);
		$NO_VACATIONID = new Response("NO_VACATIONID", null);
		$NO_USERID = new Response("NO_USERID", null);
		$NO_BUSINESSID = new Response("NO_BUSINESSID", null);
		$NO_STARTDATE = new Response("NO_STARTDATE", null);
		$NO_FINISHDATE = new Response("NO_FINISHDATE", null);
		
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
	
	public function getVacationsByUserID($userID) {
		
		if (!isset($userID))
			return $this->NO_USERID;
		
		return $this->vacationService->getVacationsByUserID($userID);
		
	}
	
	public function getVacationsByBusinessID($businessID) {
		
		if (!isset($businessID))
			return $this->NO_BUSINESSID;
		
		return $this->vacationService->getVacationsByBusinessID($businessID);
		
	}
	
	public function getLastVacation() {
		
		$vacationID = $this->vacationService->getLastID();
		if ($vacationID->status != $this->vacationService->SUCCESS->status)
			return $vacationID;
		
		return $this->vacationService->getVacation($vacationID->content);
		
	}
	
	public function getLastVacationByUserID($userID) {
		
		if (!isset($userID))
			return $this->NO_USERID;
		
		return $this->vacationService->getLastVacationByUserID($userID);
		
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