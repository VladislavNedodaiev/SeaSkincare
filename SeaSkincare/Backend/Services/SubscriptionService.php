<?php

namespace SeaSkincare\Backend\Services;

use SeaSkincare\Backend\Entities\Subscription;
use SeaSkincare\Backend\DTOs\SubscriptionDTO;
use SeaSkincare\Backend\Mappers\SubscriptionMapper;
use SeaSkincare\Backend\Communication\Response;

class SubscriptionService
{
	
	private $database;
	
	private const DB_TABLE = "Subscription";
	
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
	
	public function createSubscription($dto) {
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;

		if ($this->database->query("INSERT INTO `".self::DB_TABLE."`(`buoy_id`, `business_id`, `startDate`, `finishDate`)".
						   "VALUES (".
						   "'".$dto->buoyID."',".
						   "'".$dto->businessID."', ".
						   "'".$dto->startDate."', ".
						   "'".$dto->finishDate."');")) {
			$lastID = $this->getLastID();
			if ($lastID->status == self::SUCCESS->status
				&& $result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`subscription_id`=".$lastID->content.";")) {
				if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
					
					$dto->id = $res['subscription_id'];
					
					return new Response(self::SUCCESS->status, SubscriptionMapper::DTOToEntity($dto));
					
				}
			}
		}
			
		return self::DB_ERROR;
		
	}
	
	public function getSubscription($subscriptionID) {
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`subscription_id`='".$subscriptionID."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$dto = new SubscriptionDTO;
					
				$dto->id = $res['subscription_id'];
				$dto->buoyID = $res['buoy_id'];
				$dto->businessID = $res['business_id'];
				$dto->startDate = $res['startDate'];
				$dto->finishDate = $res['finishDate'];
				
				return new Response(self::SUCCESS->status, SubscriptionMapper::DTOToEntity($dto));
				
			}
		}
		
		return self::NOT_FOUND;
		
	}
	
	public function getLastID() {
		
		if (!$this->database || $this->database->connect_errno)
			return new Response(self::DB_ERROR->status, 0);
		
		if ($result = $this->database->query("SELECT MAX(`".self::DB_TABLE."`.`subscription_id`) AS `id` FROM `".self::DB_TABLE."`;")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				return new Response(self::SUCCESS->status, $res['id']);
				
			}
		}
		
		return new Response(self::NOT_FOUND->status, 0);
		
	}
	
	public function updateSubscription($dto) {
		
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($this->database->query("UPDATE `".self::DB_TABLE."` SET `buoy_id`='".$dto->buoyID."', `business_id`='".$dto->businessID."', `start_date`='".$dto->startDate."', `finish_date`='".$dto->finishDate."' WHERE `subscription_id`='".$dto->id."';"))
			return self::SUCCESS;
			
		return self::NOT_FOUND;
		
	}
	
	public function deleteSubscription($subscriptionID) {
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($this->database->query("DELETE FROM `".self::DB_TABLE."` WHERE `subscription_id`='".$subscriptionID."';"))
			return self::SUCCESS;
			
		return self::NOT_FOUND;
		
	}
	
}

?>