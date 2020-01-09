<?php

namespace SeaSkincare\Backend\Services;

use SeaSkincare\Backend\Services\LogService;
use SeaSkincare\Backend\DTOs\WeatherDTO;
use SeaSkincare\Backend\Communication\Response;

class WeatherService
{
	
	private const DB_TABLE = "Weather";
	
	public function __construct($host, $user, $pswd, $db, $logService) {
		
		parent::__construct($host, $user, $pswd, $db, $logService);
	
	}
	
	public function createWeather($dto) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
	
		if ($this->database->query("INSERT INTO `".self::DB_TABLE."`(`connection_id`, `sun_power`, `wind_speed`)".
						   "VALUES (".
						   "'".$dto->id."',".
						   "'".$dto->sunPower."', ".
						   "'".$dto->windSpeed."');")) {
			
			return new Response($this->SUCCESS->status, $dto);
			
		}
			
		return $this->DB_ERROR;
		
	}
	
	// getting public data of user by id from database
	public function getWeather($connectionID) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`connection_id`='".$connectionID."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				
				$dto = new WeatherDTO;
					
				$dto->id = $res['connection_id'];
				$dto->sunPower = $res['sun_power'];
				$dto->windSpeed = $res['wind_speed'];
				
				return new Response($this->SUCCESS->status, $dto);
				
			}
		}
		
		return $this->NOT_FOUND;
		
	}
	
	public function updateWeather($dto) {
		
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($this->database->query("UPDATE `".self::DB_TABLE."` SET `sun_power`='".$dto->sunPower."', `wind_speed`='".$dto->windSpeed."' WHERE `connection_id`='".$dto->id."';"))
			return $this->SUCCESS;
			
		return $this->NOT_FOUND;
		
	}
	
	public function deleteWeather($connectionID)
	{
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($this->database->query("DELETE FROM `".self::DB_TABLE."` WHERE `connection_id`='".$connectionID."';"))
			return $this->SUCCESS;
			
		return $this->NOT_FOUND;
		
	}
	
}

?>