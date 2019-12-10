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
	
	public const SUCCESS = new Response("SUCCESS", null);
	public const NO_VACATIONID = new Response("NO_VACATIONID", null);
	public const NO_USERID = new Response("NO_USERID", null);
	public const NO_BUSINESSID = new Response("NO_BUSINESSID", null);
	public const NO_STARTDATE = new Response("NO_STARTDATE", null);
	public const NO_FINISHDATE = new Response("NO_FINISHDATE", null);	
	
	public function __construct() {
	
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
			return self::NO_USERID;
		
		if (!isset($businessID))
			return self::NO_BUSINESSID;
		
		if (!isset($startDate))
			return self::NO_STARTDATE;
		
		if (!isset($finishDate))
			return self::NO_FINISHDATE;
		
		if (!((bool)(strtotime($startDate))))
			return self::INCORRECT_STARTDATE;
		
		if (!((bool)(strtotime($finishDate))))
			return self::INCORRECT_FINISHDATE;
		
		$dto = new VacationDTO;
		$dto->userID = $userID;
		$dto->businessID = $businessID;
		$dto->startDate = $startDate;
		$dto->finishDate = $finishDate;
		
		return $this->vacationService->createVacation($dto);
		
	}
	
	public function getVacation($vacationID) {
		
		if (!isset($vacationID))
			return self::NO_VACATIONID;
		
		return $this->vacationService->getVacation($vacationID);
		
	}
	
	public function getVacationsByIDs($userID, $businessID) {
		
		if (!isset($userID))
			return self::NO_USERID;
		
		if (!isset($businessID))
			return self::NO_BUSINESSID;
		
		return $this->vacationService->getVacationsByIDs($userID, $businessID);
		
	}
	
	public function getVacationsByUserID($userID) {
		
		if (!isset($userID))
			return self::NO_USERID;
		
		return $this->vacationService->getVacationsByUserID($userID);
		
	}
	
	public function getVacationsByBusinessID($businessID) {
		
		if (!isset($businessID))
			return self::NO_BUSINESSID;
		
		return $this->vacationService->getVacationsByBusinessID($businessID);
		
	}
	
	public function getLastVacation() {
		
		$vacationID = $this->vacationService->getLastID();
		if ($vacationID->status != VacationService::SUCCESS->status)
			return $vacationID;
		
		return $this->vacationService->getVacation($vacationID->content);
		
	}
	
	public function getLastVacationByUserID($userID) {
		
		if (!isset($userID))
			return self::NO_USERID;
		
		return $this->vacationService->getLastVacationByUserID($userID);
		
	}
	
	public function editVacation($vacationID, $startDate, $finishDate) {
		
		if (!isset($userID))
			return self::NO_USERID;
		
		if (!isset($businessID))
			return self::NO_BUSINESSID;
		
		if (!isset($startDate))
			return self::NO_STARTDATE;
		
		if (!isset($finishDate))
			return self::NO_FINISHDATE;
		
		if (!((bool)(strtotime($startDate))))
			return self::INCORRECT_STARTDATE;
		
		if (!((bool)(strtotime($finishDate))))
			return self::INCORRECT_FINISHDATE;
		
		$dto = new VacationDTO;
		$dto->id = $vacationID;
		$dto->startDate = $startDate;
		$dto->finishDate = $finishDate;
		
		return $this->vacationService->updateVacation($dto);
	
	}
	
	public function deleteVacation($vacationID) {
	
		if (!isset($vacationID))
			return self::NO_VACATIONID;
		
		return $this->vacationService->deleteVacation($vacationID);
	
	}
	
}

?>