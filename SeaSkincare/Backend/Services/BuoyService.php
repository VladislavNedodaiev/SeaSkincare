<?php

namespace SeaSkincare\Backend\Services;

use SeaSkincare\Backend\Entities\Buoy;
use SeaSkincare\Backend\DTOs\BuoyEntity;
use SeaSkincare\Backend\Mappers\BuoyMapper;
use SeaSkincare\Backend\Communication\Response;

class BuoyService
{
	
	private $database;
	
	private const DB_TABLE = "Buoy";
	
	public const NOT_FOUND = "NOT_FOUND";
	
	public const SUCCESS = "SUCCESS";
	public const DB_ERROR = "DB_ERROR";
	
	public function __construct($host, $user, $pswd, $db) {
	
		$this->connectToDB($host, $user, $pswd, $db);
	
	}
	
	private function connectToDB($host, $user, $pswd, $db) {

		$this->database = new \mysqli($host, $user, $pswd, $db);

		if ($this->database->connect_errno) {
			return null;
		}

		$this->database->set_charset('utf8');

		return $this->database;
		
	}
	
	public function createBuoy() {
		
		if (!$this->database || $this->database->connect_errno)
			return new Response(self::DB_ERROR, null);
		
		if ($this->database->query("INSERT INTO `".self::DB_TABLE."`()".
						   "VALUES ();")) {
			if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`buoy_id`=".$this->getLastID().";")) {
				if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
					
					$dto = new BuoyDTO;
					
					$dto->id = $res['buoy_id'];
					$dto->fabricationDate = $res['fabrication_date'];
					
					return new Response(self::SUCCESS, BuoyMapper::DTOToEntity($dto));
					
				}
			}
		}
			
		return new Response(self::DB_ERROR, null);
		
	}
	
	// getting public data of user by id from database
	public function getBuoy($buoyID) {
		
		if (!$this->database || $this->database->connect_errno)
			return new Response(self::DB_ERROR, null);
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`buoy_id`='".$buoyID."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				
				$dto = new BuoyDTO;
					
				$dto->id = $res['buoy_id'];
				$dto->fabricationDate = $res['fabrication_date'];
				
				return new Response(self::SUCCESS, BuoyMapper::DTOToEntity($dto));
				
			}
		}
		
		return new Response(self::NOT_FOUND, null);
		
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
			return new Response(self::DB_ERROR, null);
		
		if ($this->database->query("DELETE FROM `".self::DB_TABLE."` WHERE `buoy_id`='".$buoyID."';"))
			return new Response(self::SUCCESS, null);
			
		return new Response(self::DB_ERROR, null);
		
	}
	
}

?>