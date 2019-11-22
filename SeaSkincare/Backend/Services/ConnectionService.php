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
	
	public function createConnection($dto) {
		
		if (!$this->database || $this->database->connect_errno)
			return new Response(self::DB_ERROR, null);
		
		if ($this->database->query("INSERT INTO `".self::DB_TABLE."`(`buoy_id`, `latitude`, `longitude`, `battery`)".
						   "VALUES ('".$dto->buoyID."',
						   '".$dto->latitude."',
						   '".$dto->longitude."',
						   '".$dto->battery."');")) {
			if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`connection_id`=".$this->getLastIDByBuoy($buoyID).";")) {
				if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
					
					$dto->id = $res['connection_id'];
					$dto->connectionDate = $res['connection_date'];
					
					return new Response(self::SUCCESS, ConnectionMapper::DTOToEntity($dto));
					
				}
			}
		}
			
		return new Response(self::DB_ERROR, null);
		
	}
	
	// getting public data of user by id from database
	public function getConnection($connectionID) {
		
		if (!$this->database || $this->database->connect_errno)
			return new Response(self::DB_ERROR, null);
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`connection_id`='".$connectionID."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				
				$dto = new ConnectionDTO;
					
				$dto->id = $res['connection_id'];
				$dto->buoyID = $res['buoyID'];
				$dto->connectionDate = $res['connectionDate'];
				$dto->latitude = $res['latitude'];
				$dto->longitude = $res['longitude'];
				$dto->battery = $res['battery'];
				
				return new Response(self::DB_ERROR, ConnectionMapper::DTOToEntity($dto));
				
			}
		}
		
		return new Response(self::NOT_FOUND, null);
		
	}
	
	public function getBuoyConnections($buoyID) {
		
		if (!$this->database || $this->database->connect_errno)
			return new Response(self::DB_ERROR, null);
		
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
				
				array_push($connections, ConnectionMapper::DTOToEntity($dto));
				
			}
			
			return new Response(self::SUCCESS, $connections);
		}
		
		return new Response(self::NOT_FOUND, null);
		
	}
	
	public function getLastID() {
		
		if (!$this->database || $this->database->connect_errno)
			return 0;
		
		if ($result = $this->database->query("SELECT MAX(`".self::DB_TABLE."`.`connection_id`) AS `id` FROM `".self::DB_TABLE."`;")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				return $res['id'];
				
			}
		}
		
		return 0;
		
	}
	
	public function getLastIDByBuoy($buoyID) {
		
		if (!$this->database || $this->database->connect_errno)
			return 0;
		
		if ($result = $this->database->query("SELECT MAX(`".self::DB_TABLE."`.`connection_id`) AS `id` FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`buoy_id`=".$buoyID.";")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				return $res['id'];
				
			}
		}
		
		return 0;
		
	}
	
	public function updateConnection($dto) {
		
		
		if (!$this->database || $this->database->connect_errno)
			return new Response(self::DB_ERROR, null);
		
		if ($this->database->query("UPDATE `".self::DB_TABLE."` SET `latitude`='".$dto->latitude."', `longitude`='".$dto->longitude."', `battery`='".$dto->battery."' WHERE `connection_id`='".$dto->id."';"))
			return new Response(self::SUCCESS, null);
			
		return new Response(self::DB_ERROR, null);
		
	}
	
	public function deleteConnection($connectionID)
	{
		
		if (!$this->database || $this->database->connect_errno)
			return new Response(self::DB_ERROR, null);
		
		if ($this->database->query("DELETE FROM `".self::DB_TABLE."` WHERE `connection_id`='".$connectionID."';"))
			return new Response(self::SUCCESS, null);
			
		return new Response(self::DB_ERROR, null);
		
	}
	
}

?>