<?php

namespace SeaSkincare\Backend\Services;

use SeaSkincare\Backend\DTOs\BuoyEntity;
use SeaSkincare\Backend\Communication\Response;

class BuoyService
{
	
	private $database;
	
	private const DB_TABLE = "Buoy";
	
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
	
	public function createBuoy() {
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($this->database->query("INSERT INTO `".self::DB_TABLE."`()".
						   "VALUES ();")) {
							   
			$lastID = $this->getLastID();
			if ($lastID->status == self::SUCCESS->status
				&& $result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`buoy_id`=".$lastID->content.";")) {
				if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
					
					$dto = new BuoyDTO;
					
					$dto->id = $res['buoy_id'];
					$dto->fabricationDate = $res['fabrication_date'];
					
					return new Response(self::SUCCESS->status, $dto);
					
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
				
				return new Response(self::SUCCESS->status, $dto);
				
			}
		}
		
		return self::NOT_FOUND;
		
	}
	
	public function getLastID() {
		
		if (!$this->database || $this->database->connect_errno)
			return new Response(self::DB_ERROR->status, 0);
		
		if ($result = $this->database->query("SELECT MAX(`".self::DB_TABLE."`.`buoy_id`) AS `id` FROM `".self::DB_TABLE."`;")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				return new Response(self::SUCCESS->status, $res['id']);
				
			}
		}
		
		return new Response(self::NOT_FOUND->status, 0);
		
	}
	
	public function updateBuoy($dto) {
		
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($this->database->query("UPDATE `".self::DB_TABLE."` SET `fabrication_date`='".$dto->fabricationDate."' WHERE `buoy_id`='".$dto->id."';"))
			return self::SUCCESS;
			
		return self::NOT_FOUND;
		
	}
	
	public function deleteBuoy($buoyID) {
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($this->database->query("DELETE FROM `".self::DB_TABLE."` WHERE `buoy_id`='".$buoyID."';"))
			return self::SUCCESS;
			
		return self::NOT_FOUND;
		
	}
	
}

?>