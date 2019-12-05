<?php

namespace SeaSkincare\Backend\Services;

use SeaSkincare\Backend\DTOs\VacationDTO;
use SeaSkincare\Backend\Communication\Response;

class VacationService
{
	
	private $database;
	
	private const DB_TABLE = "Vacation";
	
	public const NOT_FOUND = new Response("NOT_FOUND", null);
	public const SUCCESS = new Response("SUCCESS", null);
	public const DB_ERROR = new Response("DB_ERROR", null);
	
	public function __construct($host, $user, $pswd, $db) {
	
		$this->connectToDB($host, $user, $pswd, $db);
	
	}
	
	private function connectToDB($host, $user, $pswd, $db) {

		$this->database = new \mysqli($host, $user, $pswd, $db);

		if ($this->database->connect_errno) {
			return self::DB_ERROR;
		}

		$this->database->set_charset('utf8');

		return new Response(self::SUCCESS->status, $this->database);
		
	}
	
	public function createVacation($dto) {
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($this->database->query("INSERT INTO `".self::DB_TABLE."`(`user_id`, `business_id`, `startDate`, `finishDate`)".
						   "VALUES (".
						   "'".$dto->userID."',".
						   "'".$dto->businessID."', ".
						   "'".$dto->startDate."', ".
						   "'".$dto->finishDate."');")) {
			$lastID = $this->getLastID();
			if ($lastID->status == self::SUCCESS->status
				&& $result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`vacation_id`=".$lastID->content.";")) {
				if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
					
					$dto->id = $res['vacation_id'];
					
					return new Response(self::SUCCESS->status, $dto);
					
				}
			}
		}
			
		return self::DB_ERROR;
		
	}
	
	public function getVacation($vacationID) {
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`vacation_id`='".$vacationID."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$dto = new VacationDTO;
					
				$dto->id = $res['vacation_id'];
				$dto->userID = $res['user_id'];
				$dto->businessID = $res['business_id'];
				$dto->startDate = $res['startDate'];
				$dto->finishDate = $res['finishDate'];
				
				return new Response(self::SUCCESS->status, $dto);
				
			}
		}
		
		return self::NOT_FOUND;
		
	}
	
	public function getLastID() {
		
		if (!$this->database || $this->database->connect_errno)
			return new Response(self::DB_ERROR->status, 0);
		
		if ($result = $this->database->query("SELECT MAX(`".self::DB_TABLE."`.`vacation_id`) AS `id` FROM `".self::DB_TABLE."`;")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				return new Response(self::SUCCESS->status, $res['id']);
				
			}
		}
		
		return new Response(self:NOT_FOUND->status, 0);
		
	}
	
	public function getLastIDByUserID($userID) {
		
		if (!$this->database || $this->database->connect_errno)
			return new Response(self::DB_ERROR->status, 0);
		
		if ($result = $this->database->query("SELECT MAX(`".self::DB_TABLE."`.`vacation_id`) AS `id` FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`user_id`='".$userID."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				return new Response(self::SUCCESS->status, $res['id']);
				
			}
		}
		
		return new Response(self:NOT_FOUND->status, 0);
		
	}
	
	public function getVacationsByIDs($userID, $businessID) {
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`user_id`='".$userID."' AND `".self::DB_TABLE."`.`business_id`='".$businessID."';")) {
			
			$vacations = new Array();
			
			while ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$dto = new VacationDTO;
					
				$dto->id = $res['vacation_id'];
				$dto->userID = $res['user_id'];
				$dto->businessID = $res['business_id'];
				$dto->startDate = $res['start_date'];
				$dto->finishDate = $res['finish_date'];
				
				array_push($vacations, $dto);
				
			}
			
			return new Response(self::SUCCESS->status, $vacations);
			
		}
		
		return self::NOT_FOUND;
		
	}
	
	public function getVacationsByUserID($userID) {
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`user_id`='".$userID."';")) {
			
			$vacations = new Array();
			
			while ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$dto = new VacationDTO;
					
				$dto->id = $res['vacation_id'];
				$dto->userID = $res['user_id'];
				$dto->businessID = $res['business_id'];
				$dto->startDate = $res['start_date'];
				$dto->finishDate = $res['finish_date'];
				
				array_push($vacations, $dto);
				
			}
			
			return new Response(self::SUCCESS->status, $vacations);
			
		}
		
		return self::NOT_FOUND;
		
	}
	
	public function getVacationByBusinessID($businessID) {
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`business_id`='".$businessID."';")) {
			
			$vacations = new Array();
			
			while ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$dto = new VacationDTO;
					
				$dto->id = $res['vacation_id'];
				$dto->userID = $res['user_id'];
				$dto->businessID = $res['business_id'];
				$dto->startDate = $res['start_date'];
				$dto->finishDate = $res['finish_date'];
				
				array_push($vacations, $dto);
				
			}
			
			return new Response(self::SUCCESS->status, $vacations);
			
		}
		
		return self::NOT_FOUND;
		
	}
	
	public function updateVacation($dto) {
		
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($this->database->query("UPDATE `".self::DB_TABLE."` SET `start_date`='".$dto->startDate."', `finish_date`='".$dto->finishDate."' WHERE `vacation_id`='".$dto->id."';"))
			return self::SUCCESS;
			
		return self::NOT_FOUND;
		
	}
	
	public function deleteVacation($vacationID)
	{
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($this->database->query("DELETE FROM `".self::DB_TABLE."` WHERE `vacation_id`='".$vacationID."';"))
			return self::SUCCESS;
			
		return self::NOT_FOUND;
		
	}
	
}

?>