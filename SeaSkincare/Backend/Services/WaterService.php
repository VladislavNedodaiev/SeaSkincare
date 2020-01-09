<?php

namespace SeaSkincare\Backend\Services;

use SeaSkincare\Backend\Services\Service;
use SeaSkincare\Backend\Services\LogService;
use SeaSkincare\Backend\DTOs\WaterDTO;
use SeaSkincare\Backend\Communication\Response;

class WaterService extends Service
{
	
	private const DB_TABLE = "Water";
	
	public function __construct($host, $user, $pswd, $db, $logService) {
		
		parent::__construct($host, $user, $pswd, $db, $logService);
	
	}
	
	public function createWater($dto) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;

		if ($this->database->query("INSERT INTO `".self::DB_TABLE."`(`connection_id`, `temperature`, `pH`, `NaCl`, `MgCl2`, `MgSO4`, `CaSO4`, `NaBr`)".
						   "VALUES (".
						   "'".$dto->id."',".
						   "'".$dto->temperature."', ".
						   "'".$dto->pH."', ".
						   "'".$dto->NaCl."', ".
						   "'".$dto->MgCl2."', ".
						   "'".$dto->MgSO4."', ".
						   "'".$dto->CaSO4."', ".
						   "'".$dto->NaBr."');")) {
			
			return new Response($this->SUCCESS->status, $dto);
			
		}
			
		return $this->DB_ERROR;
		
	}
	
	// getting public data of user by id from database
	public function getWater($connectionID) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
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
				
				return new Response($this->SUCCESS->status, $dto);
				
			}
		}
		
		return $this->NOT_FOUND;
		
	}
	
	public function updateWater($dto) {
		
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($this->database->query("UPDATE `".self::DB_TABLE."` SET `temperature`='".$dto->temperature."', `pH`='".$dto->pH."', `NaCl`='".$dto->NaCl."', `MgCl2`='".$dto->MgCl2."', `MgSO4`='".$dto->MgSO4."', `CaSO4`='".$dto->CaSO4."', `NaBr`='".$dto->NaBr."' WHERE `connection_id`='".$dto->id."';"))
			return $this->SUCCESS;
			
		return $this->NOT_FOUND;
		
	}
	
	public function deleteWater($connectionID)
	{
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($this->database->query("DELETE FROM `".self::DB_TABLE."` WHERE `connection_id`='".$connectionID."';"))
			return $this->SUCCESS;
			
		return $this->NOT_FOUND;
		
	}
	
}

?>