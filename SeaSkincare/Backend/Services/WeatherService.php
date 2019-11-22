<?php

namespace SeaSkincare\Backend\Services;

use SeaSkincare\Backend\Entities;
use SeaSkincare\Backend\DTOs;
use SeaSkincare\Backend\Mappers;
use SeaSkincare\Backend\Communication;

class WeatherService
{
	
	private $database;
	
	private const DB_TABLE = "Weather";
	
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
	
	public function createWeather($connectionID, $dto) {
		
		if (!$this->database || $this->database->connect_errno)
			return new Response(self::DB_ERROR, null);
	
		if ($this->database->query("INSERT INTO `".self::DB_TABLE."`(`connection_id`, `sun_power`, `wind_speed`)".
						   "VALUES (".
						   "'".$connectionID."',".
						   "'".$dto->sunPower."', ".
						   "'".$dto->windSpeed."');")) {
			
			return new Response(self::SUCCESS, WeatherMapper::DTOToEntity($dto));
			
		}
			
		return new Response(self::DB_ERROR, null);
		
	}
	
	// getting public data of user by id from database
	public function getWeather($connectionID) {
		
		if (!$this->database || $this->database->connect_errno)
			return new Response(self::DB_ERROR, null);
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`connection_id`='".$connectionID."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				
				$dto = new WeatherDTO;
					
				$dto->id = $res['connection_id'];
				$dto->sunPower = $res['sun_power'];
				$dto->windSpeed = $res['wind_speed'];
				
				return new Response(self::SUCCESS, WeatherMapper::DTOToEntity($dto));
				
			}
		}
		
		return new Response(self::NOT_FOUND, null);
		
	}
	
	public function updateWeather($dto) {
		
		
		if (!$this->database || $this->database->connect_errno)
			return new Response(self::DB_ERROR, null);
		
		if ($this->database->query("UPDATE `".self::DB_TABLE."` SET `sun_power`='".$dto->sunPower."', `wind_speed`='".$dto->windSpeed."' WHERE `connection_id`='".$dto->id."';"))
			return new Response(self::SUCCESS, null);
			
		return new Response(self::DB_ERROR, null);
		
	}
	
	public function deleteWeather($connectionID)
	{
		
		if (!$this->database || $this->database->connect_errno)
			return new Response(self::DB_ERROR, null);
		
		if ($this->database->query("DELETE FROM `".self::DB_TABLE."` WHERE `connection_id`='".$connectionID."';"))
			return new Response(self::SUCCESS, null);
			
		return new Response(self::DB_ERROR, null);
		
	}
	
}

?>