<?php

namespace SeaSkincare\Backend\Services;

use SeaSkincare\Backend\DTOs\BuoyDTO;
use SeaSkincare\Backend\Communication\Response;

class BuoyService
{
	
	private $database;
	
	private const DB_TABLE = "Buoy";
	
	public $NOT_FOUND;
	public $SUCCESS;
	public $DB_ERROR;
	public $SERIALNUMBER_REGISTERED;
	public $WRONG_PASSWORD;
	
	public function __construct($host, $user, $pswd, $db) {
		
		$this->NOT_FOUND = new Response("NOT_FOUND", null);
		$this->SUCCESS = new Response("SUCCESS", null);
		$this->DB_ERROR = new Response("DB_ERROR", null);
		$this->SERIALNUMBER_REGISTERED = new Response("SERIALNUMBER_REGISTERED", null);
		$this->WRONG_PASSWORD = new Response("WRONG_PASSWORD", null);
		
		$this->connectToDB($host, $user, $pswd, $db);
	
	}
	
	private function connectToDB($host, $user, $pswd, $db) {

		$this->database = new \mysqli($host, $user, $pswd, $db);

		if ($this->database->connect_errno) {
			return $this->DB_ERROR;
		}

		$this->database->set_charset('utf8');

		return new Response($this->SUCCESS->status, $this->database);
		
	}
	
	// logging in (getting private data, such as email)
	public function login($serialNumber, $password) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`serial_number`='".$serialNumber."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				if (password_verify($password, $res['hash'])) {

					$dto = new BuoyDTO;
					
					$dto->id = $res['buoy_id'];
					$dto->fabricationDate = $res['fabrication_date'];
					$dto->serialNumber = $res['serial_number'];
					$dto->password = $res['hash'];
					
					return new Response($this->SUCCESS->status, $dto);
					
				}
				else
					return $this->WRONG_PASSWORD;
			}
		}
		
		return $this->NOT_FOUND;
		
	}
	
	// registering user
	public function register($serialNumber, $password) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`serial_number`='".$serialNumber."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				return $this->SERIALNUMBER_REGISTERED;
			}
		}
		
		if ($this->database->query("INSERT INTO `".self::DB_TABLE."`(`serial_number`, `password`)".
						   "VALUES (".
						   "'".$serialNumber."',".
						   "'".password_hash($password, PASSWORD_BCRYPT)."');")) {
			
			return $this->SUCCESS;
			
		}
		
		return $this->DB_ERROR;
		
	}
	
	// getting public data of user by id from database
	public function getBuoy($buoyID) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`buoy_id`='".$buoyID."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				
				$dto = new BuoyDTO;
					
				$dto->id = $res['buoy_id'];
				$dto->fabricationDate = $res['fabrication_date'];
				
				return new Response($this->SUCCESS->status, $dto);
				
			}
		}
		
		return $this->NOT_FOUND;
		
	}
	
	public function getLastID() {
		
		if (!$this->database || $this->database->connect_errno)
			return new Response($this->DB_ERROR->status, 0);
		
		if ($result = $this->database->query("SELECT MAX(`".self::DB_TABLE."`.`buoy_id`) AS `id` FROM `".self::DB_TABLE."`;")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				return new Response($this->SUCCESS->status, $res['id']);
				
			}
		}
		
		return new Response($this->NOT_FOUND->status, 0);
		
	}
	
	public function getFreeBuoys($someDate, $offset, $limit) {
		
		if (!$this->database || $this->database->connect_errno)
			return new Response($this->DB_ERROR->status, 0);
		
		$selectQuery = "SELECT `B1`.*";
		$fromQuery = " FROM `".self::DB_TABLE."` AS `B1`";
		$whereQuery = " WHERE `B1`.`buoy_id` NOT IN (SELECT `S1`.`buoy_id` FROM `Subscription` AS `S1` WHERE `S1`.`start_date`<='".$someDate."' AND `S1`.`finish_date`>='".$someDate."')";
		$limitQuery = " LIMIT ".$limit;
		$offsetQuery = " OFFSET ".$offset;
		
		
		$query = $selectQuery.$fromQuery.$whereQuery.$limitQuery.$offsetQuery.";";
		
		if ($result = $this->database->query($query)) {
			
			$buoys = array();
			
			while ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$dto = new BuoyDTO;
					
				$dto->id = $res['buoy_id'];
				$dto->fabricationDate = $res['fabrication_date'];
				
				array_push($buoys, $dto);
				
			}
			
			if (!empty($buoys))
				return new Response($this->SUCCESS->status, $buoys);
			
		}
		
		return new Response($this->NOT_FOUND->status, 0);
		
	}
	
	public function getCount() {
		
		if (!$this->database || $this->database->connect_errno)
			return new Response($this->DB_ERROR->status, 0);
		
		$selectQuery = "SELECT COUNT(`B1`.`buoy_id`) AS `count`";
		$fromQuery = " FROM `".self::DB_TABLE."` AS `B1`";
		
		$query = $selectQuery.$fromQuery.";";
		
		if ($result = $this->database->query($query)) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				return new Response($this->SUCCESS->status, $res['count']);
				
			}
		}
		
		return new Response($this->NOT_FOUND->status, 0);
		
	}
	
	public function getCountFree($someDate) {
		
		if (!$this->database || $this->database->connect_errno)
			return new Response($this->DB_ERROR->status, 0);
		
		$selectQuery = "SELECT COUNT(`B1`.`buoy_id`) AS `count`";
		$fromQuery = " FROM `".self::DB_TABLE."` AS `B1`";
		$whereQuery = " WHERE `B1`.`buoy_id` NOT IN (SELECT `S1`.`buoy_id` FROM `Subscription` AS `S1` WHERE `S1`.`start_date`<='".$someDate."' AND `S1`.`finish_date`>='".$someDate."')";
		
		$query = $selectQuery.$fromQuery.$whereQuery.";";
		
		if ($result = $this->database->query($query)) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				return new Response($this->SUCCESS->status, $res['count']);
				
			}
		}
		
		return new Response($this->NOT_FOUND->status, 0);
		
	}
	
	public function updateBuoy($dto) {
		
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($this->database->query("UPDATE `".self::DB_TABLE."` SET `fabrication_date`='".$dto->fabricationDate."' WHERE `buoy_id`='".$dto->id."';"))
			return $this->SUCCESS;
			
		return $this->NOT_FOUND;
		
	}
	
	public function deleteBuoy($buoyID) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($this->database->query("DELETE FROM `".self::DB_TABLE."` WHERE `buoy_id`='".$buoyID."';"))
			return $this->SUCCESS;
			
		return $this->NOT_FOUND;
		
	}
	
}

?>