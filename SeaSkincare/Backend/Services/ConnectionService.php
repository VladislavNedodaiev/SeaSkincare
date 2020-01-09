<?php

namespace SeaSkincare\Backend\Services;

use SeaSkincare\Backend\Services\Service;
use SeaSkincare\Backend\Services\LogService;
use SeaSkincare\Backend\DTOs\ConnectionDTO;
use SeaSkincare\Backend\Communication\Response;

class ConnectionService extends Service
{
	
	private const DB_TABLE = "Connection";
	
	public function __construct($host, $user, $pswd, $db, $logService) {
	
		parent::__construct($host, $user, $pswd, $db, $logService);
	
	}
	
	public function createConnection($dto) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($this->database->query("INSERT INTO `".self::DB_TABLE."`(`buoy_id`, `latitude`, `longitude`, `battery`)".
						   "VALUES ('".$dto->buoyID."',
						   '".$dto->latitude."',
						   '".$dto->longitude."',
						   '".$dto->battery."');")) {
			$lastID = $this->getLastIDByBuoy($dto->buoyID);
			if ($lastID->status ==$this->SUCCESS->status
				&& $result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`connection_id`=".$lastID->content.";")) {
				if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
					
					$dto->id = $res['connection_id'];
					$dto->connectionDate = $res['connection_date'];
					
					return new Response($this->SUCCESS->status, $dto);
					
				}
			}
		}
			
		return $this->DB_ERROR;
		
	}
	
	// getting public data of user by id from database
	public function getConnection($connectionID) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`connection_id`='".$connectionID."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				
				$dto = new ConnectionDTO;
					
				$dto->id = $res['connection_id'];
				$dto->buoyID = $res['buoy_id'];
				$dto->connectionDate = $res['connection_date'];
				$dto->latitude = $res['latitude'];
				$dto->longitude = $res['longitude'];
				$dto->battery = $res['battery'];
				
				return new Response($this->SUCCESS->status, $dto);
				
			}
		}
		
		return $this->NOT_FOUND;
		
	}
	
	public function getBuoyConnections($buoyID) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`buoy_id`='".$buoyID."';")) {
			
			$connections = array();
			
			while ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$dto = new ConnectionDTO;
					
				$dto->id = $res['connection_id'];
				$dto->buoyID = $res['buoy_id'];
				$dto->connectionDate = $res['connection_date'];
				$dto->latitude = $res['latitude'];
				$dto->longitude = $res['longitude'];
				$dto->battery = $res['battery'];
				
				array_push($connections, $dto);
				
			}
			
			if (!empty($connections))
				return new Response($this->SUCCESS->status, $connections);
		}
		
		return $this->NOT_FOUND;
		
	}
	
	public function getLastID() {
		
		if (!$this->database || $this->database->connect_errno)
			return new Response($this->DB_ERROR->status, 0);
		
		if ($result = $this->database->query("SELECT MAX(`".self::DB_TABLE."`.`connection_id`) AS `id` FROM `".self::DB_TABLE."`;")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				return new Response($this->SUCCESS->status, $res['id']);
				
			}
		}
		
		return new Response($this->NOT_FOUND->status, 0);
		
	}
	
	public function getLastIDByBuoy($buoyID) {
		
		if (!$this->database || $this->database->connect_errno)
			return new Response($this->DB_ERROR->status, 0);
		
		if ($result = $this->database->query("SELECT MAX(`".self::DB_TABLE."`.`connection_id`) AS `id` FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`buoy_id`=".$buoyID.";")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				return new Response($this->SUCCESS->status, $res['id']);
				
			}
		}
		
		return new Response($this->NOT_FOUND->status, 0);
		
	}
	
	public function updateConnection($dto) {
		
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($this->database->query("UPDATE `".self::DB_TABLE."` SET `latitude`='".$dto->latitude."', `longitude`='".$dto->longitude."', `battery`='".$dto->battery."' WHERE `connection_id`='".$dto->id."';"))
			return $this->SUCCESS;
			
		return $this->NOT_FOUND;
		
	}
	
	public function deleteConnection($connectionID) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($this->database->query("DELETE FROM `".self::DB_TABLE."` WHERE `connection_id`='".$connectionID."';"))
			return $this->SUCCESS;
			
		return $this->NOT_FOUND;
		
	}
	
}

?>