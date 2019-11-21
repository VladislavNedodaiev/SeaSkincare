<?php

namespace SeaSkincare\Backend\Services;

use SeaSkincare\Backend\Entities;
use SeaSkincare\Backend\DTOs;
use SeaSkincare\Backend\Mappers;

class BuoyService
{
	
	private $database;
	
	private const DB_TABLE = "Buoy";
	
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
	
	public function createBuoy() {
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($this->database->query("INSERT INTO `".self::DB_TABLE."`()".
						   "VALUES ();")) {
			if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`buoy_id`=".$this->getLastID().";")) {
				if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
					
					$dto = new BuoyDTO;
					
					$dto->id = $res['buoy_id'];
					$dto->fabricationDate = $res['fabrication_date'];
					
					return BuoyMapper::DTOToEntity($dto);
					
				}
			}
		}
			
		return self::DB_ERROR;
		
	}
	
	// getting public data of user by id from database
	public function getBuoy($buoyID) {
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`buoy_id`='".$buoyID."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				
				$dto = new BuoyDTO;
					
				$dto->id = $res['buoy_id'];
				$dto->fabricationDate = $res['fabrication_date'];
				
				return BuoyMapper::DTOToEntity($dto);
				
			}
		}
		
		return self::NOT_FOUND;
		
	}
	
	public function getLastID() {
		
		if (!$this->database || $this->database->connect_errno)
			return 0;
		
		if ($result = $this->database->query("SELECT MAX(`".self::DB_TABLE."`.`buoy_id`) AS `id` FROM `".self::DB_TABLE."`;")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				return $res['id'];
				
			}
		}
		
		return 0;
		
	}
	
	public function deleteBuoy($buoyID)
	{
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($this->database->query("DELETE FROM `".self::DB_TABLE."` WHERE `buoy_id`='".$buoyID."';"))
			return self::SUCCESS;
			
		return self::DB_ERROR;
		
	}
	
}

?>