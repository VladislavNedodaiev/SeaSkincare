<?php

namespace SeaSkincare\Backend\Services;

use SeaSkincare\Backend\Entities\Air;
use SeaSkincare\Backend\DTOs\AirDTO;
use SeaSkincare\Backend\Mappers\AirMapper;
use SeaSkincare\Backend\Communication\Response;

class AirService
{
	
	private $database;
	
	private const DB_TABLE = "Air";
	
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
	
	public function createAir($dto) {
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($this->database->query("INSERT INTO `".self::DB_TABLE."`(`connection_id`, `temperature`, `pollution`)".
						   "VALUES (".
						   "'".$dto->id."',".
						   "'".$dto->temperature."', ".
						   "'".$dto->pollution."');")) {
			
			return new Response(self::SUCCESS->status, $dto);
			
		}
			
		return self::DB_ERROR;
		
	}
	
	// getting public data of user by id from database
	public function getAir($connectionID) {
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`connection_id`='".$connectionID."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				
				$dto = new AirDTO;
					
				$dto->id = $res['connection_id'];
				$dto->temperature = $res['temperature'];
				$dto->pollution = $res['pollution'];
				
				return new Response(self::SUCCESS->status, $dto);
				
			}
		}
		
		return self::NOT_FOUND;
		
	}
	
	public function updateAir($dto) {
		
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($this->database->query("UPDATE `".self::DB_TABLE."` SET `temperature`='".$dto->temperature."', `pollution`='".$dto->pollution."' WHERE `connection_id`='".$dto->id."';"))
			return self::SUCCESS;
			
		return new self::NOT_FOUND;
		
	}
	
	public function deleteAir($connectionID) {
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($this->database->query("DELETE FROM `".self::DB_TABLE."` WHERE `connection_id`='".$connectionID."';"))
			return self::SUCCESS;
			
		return self::NOT_FOUND;
		
	}
	
}

?>