<?php

namespace SeaSkincare\Backend\Services;

use SeaSkincare\Backend\Entities;
use SeaSkincare\Backend\DTOs;
use SeaSkincare\Backend\Mappers;

class VacationService
{
	
	private $database;
	
	private const DB_TABLE = "Vacation";
	
	public const NOT_FOUND = "NOT_FOUND";
	
	public const SUCCESS = "SUCCESS";
	public const DB_ERROR = "DB_ERROR";
	
	public function __construct($host, $user, $pswd, $db) {
	
		$this->connectToDB();
	
	}
	
	private function connectToDB($host, $user, $pswd, $db) {

		$this->database = new mysqli($host, $user, $pswd, $db);

		if ($this->database->connect_errno) {
			return null;
		}

		$this->database->set_charset('utf8');

		return $this->database;
		
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
			if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`vacation_id`=".$this->getLastID().";")) {
				if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
					
					$dto->id = $res['vacation_id'];
					
					return VacationMapper::DTOToEntity($dto);
					
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
				
				return VacationMapper::DTOToEntity($dto);
				
			}
		}
		
		return self::NOT_FOUND;
		
	}
	
	public function getLastID() {
		
		if (!$this->database || $this->database->connect_errno)
			return 0;
		
		if ($result = $this->database->query("SELECT MAX(`".self::DB_TABLE."`.`vacation_id`) AS `id` FROM `".self::DB_TABLE."`;")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				return $res['id'];
				
			}
		}
		
		return 0;
		
	}
	
	public function updateVacation($dto) {
		
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($this->database->query("UPDATE `".self::DB_TABLE."` SET `user_id`='".$dto->userID."', `business_id`='".$dto->businessID."', `start_date`='".$dto->startDate."', `finish_date`='".$dto->finishDate."' WHERE `vacation_id`='".$dto->id."';"))
			return self::SUCCESS;
			
		return self::DB_ERROR;
		
	}
	
	public function deleteVacation($vacationID)
	{
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($this->database->query("DELETE FROM `".self::DB_TABLE."` WHERE `vacation_id`='".$vacationID."';"))
			return self::SUCCESS;
			
		return self::DB_ERROR;
		
	}
	
}

?>