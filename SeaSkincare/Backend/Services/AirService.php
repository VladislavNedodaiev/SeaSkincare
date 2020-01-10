<?php

namespace SeaSkincare\Backend\Services;

use SeaSkincare\Backend\Services\Service;
use SeaSkincare\Backend\Services\LogService;
use SeaSkincare\Backend\DTOs\AirDTO;
use SeaSkincare\Backend\Communication\Response;

class AirService extends Service
{
	
	private $DB_TABLE;
	
	public function __construct($host, $user, $pswd, $db, $logService) {
		
		parent::__construct($host, $user, $pswd, $db, $logService);
		
		$this->DB_TABLE = "Air";
	
	}
	
	public function createAir($dto) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($this->database->query("INSERT INTO `".$this->DB_TABLE."`(`connection_id`, `temperature`, `pollution`)".
						   "VALUES (".
						   "'".$dto->id."',".
						   "'".$dto->temperature."', ".
						   "'".$dto->pollution."');")) {
			
			return new Response($this->SUCCESS->status, $dto);
			
		}
			
		return $this->DB_ERROR;
		
	}
	
	// getting public data of user by id from database
	public function getAir($connectionID) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".$this->DB_TABLE."`.* FROM `".$this->DB_TABLE."` WHERE `".$this->DB_TABLE."`.`connection_id`='".$connectionID."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				
				$dto = new AirDTO;
					
				$dto->id = $res['connection_id'];
				$dto->temperature = $res['temperature'];
				$dto->pollution = $res['pollution'];
				
				return new Response($this->SUCCESS->status, $dto);
				
			}
		}
		
		return $this->NOT_FOUND;
		
	}
	
	public function updateAir($dto) {
		
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($this->database->query("UPDATE `".$this->DB_TABLE."` SET `temperature`='".$dto->temperature."', `pollution`='".$dto->pollution."' WHERE `connection_id`='".$dto->id."';"))
			return $this->SUCCESS;
			
		return new$this->NOT_FOUND;
		
	}
	
	public function deleteAir($connectionID) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($this->database->query("DELETE FROM `".$this->DB_TABLE."` WHERE `connection_id`='".$connectionID."';"))
			return $this->SUCCESS;
			
		return $this->NOT_FOUND;
		
	}
	
}

?>