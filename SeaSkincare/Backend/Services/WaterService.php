<?php

namespace SeaSkincare\Backend\Services;

use SeaSkincare\Backend\Entities;
use SeaSkincare\Backend\DTOs;
use SeaSkincare\Backend\Mappers;

class WaterService
{
	
	private $database;
	
	private const DB_TABLE = "Water";
	
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
	
	public function createWater($connectionID, $dto) {
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;

		if ($this->database->query("INSERT INTO `".self::DB_TABLE."`(`connection_id`, `temperature`, `pH`, `NaCl`, `MgCl2`, `MgSO4`, `CaSO4`, `NaBr`)".
						   "VALUES (".
						   "'".$connectionID."',".
						   "'".$dto->temperature."', ".
						   "'".$dto->pH."', ".
						   "'".$dto->NaCl."', ".
						   "'".$dto->MgCl2."', ".
						   "'".$dto->MgSO4."', ".
						   "'".$dto->CaSO4."', ".
						   "'".$dto->NaBr."');")) {
			
			return WaterMapper::DTOToEntity($dto);
			
		}
			
		return self::DB_ERROR;
		
	}
	
	// getting public data of user by id from database
	public function getWater($connectionID) {
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`connection_id`='".$connectionID."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				
				$dto = new WaterDTO;
					
				$dto->id = $res['connection_id'];
				$dto->temperature = $res['temperature'];
				$dto->pH = $res['pH'];
				$dto->NaCl = $res['NaCl'];
				$dto->MgCl2 = $res['MgCl2'];
				$dto->MgSO4 = $res['MgSO4'];
				$dto->CaSO4 = $res['CaSO4'];
				$dto->NaBr = $res['NaBr'];
				
				return WaterMapper::DTOToEntity($dto);
				
			}
		}
		
		return self::NOT_FOUND;
		
	}
	
	public function updateWater($dto) {
		
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($this->database->query("UPDATE `".self::DB_TABLE."` SET `temperature`='".$dto->temperature."', `pH`='".$dto->pH."', `NaCl`='".$dto->NaCl."', `MgCl2`='".$dto->MgCl2."', `MgSO4`='".$dto->MgSO4."', `CaSO4`='".$dto->CaSO4."', `NaBr`='".$dto->NaBr."' WHERE `connection_id`='".$dto->id."';"))
			return self::SUCCESS;
			
		return self::DB_ERROR;
		
	}
	
	public function deleteWater($connectionID)
	{
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($this->database->query("DELETE FROM `".self::DB_TABLE."` WHERE `connection_id`='".$connectionID."';"))
			return self::SUCCESS;
			
		return self::DB_ERROR;
		
	}
	
}

?>