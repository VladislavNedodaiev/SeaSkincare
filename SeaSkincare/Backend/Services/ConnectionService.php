<?php

namespace SeaSkincare\Backend\Services;

use SeaSkincare\Backend\Entities\Connection;
use SeaSkincare\Backend\DTOs\ConnectionDTO;
use SeaSkincare\Backend\Mappers\ConnectionMapper;
use SeaSkincare\Backend\Communication\Response;

class ConnectionService
{
	
	private $database;
	
	private const DB_TABLE = "Connection";
	
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
	
	public function createConnection($dto) {
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($this->database->query("INSERT INTO `".self::DB_TABLE."`(`buoy_id`, `latitude`, `longitude`, `battery`)".
						   "VALUES ('".$dto->buoyID."',
						   '".$dto->latitude."',
						   '".$dto->longitude."',
						   '".$dto->battery."');")) {
			$lastID = $this->getLastIDByBuoy();
			if ($lastID->status == self::SUCCESS->status
				&& $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`connection_id`=".$lastID->content.";")) {
				if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
					
					$dto->id = $res['connection_id'];
					$dto->connectionDate = $res['connection_date'];
					
					return new Response(self::SUCCESS->status, $dto);
					
				}
			}
		}
			
		return self::DB_ERROR;
		
	}
	
	// getting public data of user by id from database
	public function getConnection($connectionID) {
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`connection_id`='".$connectionID."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				
				$dto = new ConnectionDTO;
					
				$dto->id = $res['connection_id'];
				$dto->buoyID = $res['buoyID'];
				$dto->connectionDate = $res['connectionDate'];
				$dto->latitude = $res['latitude'];
				$dto->longitude = $res['longitude'];
				$dto->battery = $res['battery'];
				
				return new Response(self::SUCCESS->status, $dto);
				
			}
		}
		
		return self::NOT_FOUND;
		
	}
	
	public function getBuoyConnections($buoyID) {
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`buoy_id`='".$buoyID."';")) {
			
			$connections = new Array();
			
			while ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$dto = new ConnectionDTO;
					
				$dto->id = $res['connection_id'];
				$dto->buoyID = $res['buoyID'];
				$dto->connectionDate = $res['connectionDate'];
				$dto->latitude = $res['latitude'];
				$dto->longitude = $res['longitude'];
				$dto->battery = $res['battery'];
				
				array_push($connections, $dto);
				
			}
			
			return new Response(self::SUCCESS->status, $connections);
		}
		
		return self::NOT_FOUND;
		
	}
	
	public function getLastID() {
		
		if (!$this->database || $this->database->connect_errno)
			return new Response(self::DB_ERROR->status, 0);
		
		if ($result = $this->database->query("SELECT MAX(`".self::DB_TABLE."`.`connection_id`) AS `id` FROM `".self::DB_TABLE."`;")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				return new Response(self::SUCCESS->status, $res['id']);
				
			}
		}
		
		return new Response(self::NOT_FOUND->status, 0);
		
	}
	
	public function getLastIDByBuoy($buoyID) {
		
		if (!$this->database || $this->database->connect_errno)
			return new Response(self::DB_ERROR->status, 0);
		
		if ($result = $this->database->query("SELECT MAX(`".self::DB_TABLE."`.`connection_id`) AS `id` FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`buoy_id`=".$buoyID.";")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				return new Response(self::SUCCESS->status, $res['id']);
				
			}
		}
		
		return new Response(self::NOT_FOUND->status, 0);
		
	}
	
	public function updateConnection($dto) {
		
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($this->database->query("UPDATE `".self::DB_TABLE."` SET `latitude`='".$dto->latitude."', `longitude`='".$dto->longitude."', `battery`='".$dto->battery."' WHERE `connection_id`='".$dto->id."';"))
			return self::SUCCESS;
			
		return self::NOT_FOUND;
		
	}
	
	public function deleteConnection($connectionID) {
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($this->database->query("DELETE FROM `".self::DB_TABLE."` WHERE `connection_id`='".$connectionID."';"))
			return self::SUCCESS;
			
		return self::NOT_FOUND;
		
	}
	
}

?>