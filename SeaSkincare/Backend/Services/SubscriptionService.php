<?php

namespace SeaSkincare\Backend\Services;

use SeaSkincare\Backend\Services\Service;
use SeaSkincare\Backend\Services\LogService;
use SeaSkincare\Backend\DTOs\SubscriptionDTO;
use SeaSkincare\Backend\Communication\Response;

class SubscriptionService extends Service
{
	
	private const DB_TABLE = "Subscription";
	
	public function __construct($host, $user, $pswd, $db, $logService) {
	
		parent::__construct($host, $user, $pswd, $db, $logService);
	
	}
	
	public function createSubscription($dto) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;

		if ($this->database->query("INSERT INTO `".self::DB_TABLE."`(`buoy_id`, `business_id`, `start_date`, `finish_date`)".
						   "VALUES (".
						   "'".$dto->buoyID."',".
						   "'".$dto->businessID."', ".
						   "'".$dto->startDate."', ".
						   "'".$dto->finishDate."');")) {
			$lastID = $this->getLastID();
			if ($lastID->status ==$this->SUCCESS->status
				&& $result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`subscription_id`=".$lastID->content.";")) {
				if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
					
					$dto->id = $res['subscription_id'];
					
					return new Response($this->SUCCESS->status, $dto);
					
				}
			}
		}
			
		return $this->DB_ERROR;
		
	}
	
	public function getSubscription($subscriptionID) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`subscription_id`='".$subscriptionID."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$dto = new SubscriptionDTO;
					
				$dto->id = $res['subscription_id'];
				$dto->buoyID = $res['buoy_id'];
				$dto->businessID = $res['business_id'];
				$dto->startDate = $res['start_date'];
				$dto->finishDate = $res['finish_date'];
				
				return new Response($this->SUCCESS->status, $dto);
				
			}
		}
		
		return $this->NOT_FOUND;
		
	}
	
	public function getSubscriptionsByIDs($buoyID, $businessID) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`buoy_id`='".$buoyID."' AND `".self::DB_TABLE."`.`business_id`='".$businessID."';")) {
			
			$subscriptions = array();
			
			while ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$dto = new SubscriptionDTO;
					
				$dto->id = $res['subscription_id'];
				$dto->buoyID = $res['buoy_id'];
				$dto->businessID = $res['business_id'];
				$dto->startDate = $res['start_date'];
				$dto->finishDate = $res['finish_date'];
				
				array_push($subscriptions, $dto);
				
			}
			
			if (!empty($subscriptions))
				return new Response($this->SUCCESS->status, $subscriptions);
		}
		
		return $this->NOT_FOUND;
		
	}
	
	public function getSubscriptionsByBuoyID($buoyID) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`buoy_id`='".$buoyID."';")) {
			
			$subscriptions = array();
			
			while ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$dto = new SubscriptionDTO;
					
				$dto->id = $res['subscription_id'];
				$dto->buoyID = $res['buoy_id'];
				$dto->businessID = $res['business_id'];
				$dto->startDate = $res['start_date'];
				$dto->finishDate = $res['finish_date'];
				
				array_push($subscriptions, $dto);
				
			}
			
			if (!empty($subscriptions))
				return new Response($this->SUCCESS->status, $subscriptions);
			
		}
		
		return $this->NOT_FOUND;
		
	}
	
	public function getSubscriptionsByBusinessID($businessID) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`business_id`='".$businessID."';")) {
			
			$subscriptions = array();
			
			while ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$dto = new SubscriptionDTO;
					
				$dto->id = $res['subscription_id'];
				$dto->buoyID = $res['buoy_id'];
				$dto->businessID = $res['business_id'];
				$dto->startDate = $res['start_date'];
				$dto->finishDate = $res['finish_date'];
				
				array_push($subscriptions, $dto);
				
			}
			
			if (!empty($subscriptions))
				return new Response($this->SUCCESS->status, $subscriptions);
			
		}
		
		return $this->NOT_FOUND;
		
	}
	
	public function getLastID() {
		
		if (!$this->database || $this->database->connect_errno)
			return new Response($this->DB_ERROR->status, 0);
		
		if ($result = $this->database->query("SELECT MAX(`".self::DB_TABLE."`.`subscription_id`) AS `id` FROM `".self::DB_TABLE."`;")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				return new Response($this->SUCCESS->status, $res['id']);
				
			}
		}
		
		return new Response($this->NOT_FOUND->status, 0);
		
	}
	
	public function getLastSubscriptionByBuoyID($buoyID) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($result = $this->database->query("SELECT `S1`.* FROM `".self::DB_TABLE."` AS `S1` WHERE `S1`.`buoy_id`='".$buoyID."' AND `S1`.`subscription_id`=(SELECT MAX(`S2`.`subscription_id`) FROM `".self::DB_TABLE."` AS `S2` WHERE `S2`.`buoy_id`='".$buoyID."');")) {
			
			$vacations = array();
			
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$dto = new SubscriptionDTO;
					
				$dto->id = $res['subscription_id'];
				$dto->buoyID = $res['buoy_id'];
				$dto->businessID = $res['business_id'];
				$dto->startDate = $res['start_date'];
				$dto->finishDate = $res['finish_date'];
				
				return new Response($this->SUCCESS->status, $dto);
				
			}
		}
		
		return $this->NOT_FOUND;
		
	}
	
	public function getLastSubscriptionByBusinessID($businessID) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($result = $this->database->query("SELECT `S1`.* FROM `".self::DB_TABLE."` AS `S1` WHERE `S1`.`business_id`='".$businessID."' AND `S1`.`subscription_id`=(SELECT MAX(`S2`.`subscription_id`) FROM `".self::DB_TABLE."` AS `S2` WHERE `S2`.`business_id`='".$businessID."');")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$dto = new SubscriptionDTO;
					
				$dto->id = $res['subscription_id'];
				$dto->buoyID = $res['buoy_id'];
				$dto->businessID = $res['business_id'];
				$dto->startDate = $res['start_date'];
				$dto->finishDate = $res['finish_date'];
				
				return new Response($this->SUCCESS->status, $dto);
				
			}
		}
		
		return $this->NOT_FOUND;
		
	}
	
	public function getSubscriptionsActive($someDate, $offset, $limit) {
		
		if (!$this->database || $this->database->connect_errno)
			return new Response($this->DB_ERROR->status, 0);
		
		if ($result = $this->database->query("SELECT `S1`.* FROM `".self::DB_TABLE."` AS `S1` WHERE `S1`.`start_date`<='".$someDate."' AND `S1`.`finish_date`>='".$someDate."' LIMIT ".$limit." OFFSET ".$offset.";")) {
			
			$subscriptions = array();
			
			while ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$dto = new SubscriptionDTO;
					
				$dto->id = $res['subscription_id'];
				$dto->buoyID = $res['buoy_id'];
				$dto->businessID = $res['business_id'];
				$dto->startDate = $res['start_date'];
				$dto->finishDate = $res['finish_date'];
				
				array_push($subscriptions, $dto);
				
			}
			
			if (!empty($subscriptions))
				return new Response($this->SUCCESS->status, $subscriptions);
			
		}
		
		return new Response($this->NOT_FOUND->status, 0);
		
	}
	
	public function getCountActiveDate($someDate) {
		
		if (!$this->database || $this->database->connect_errno)
			return new Response($this->DB_ERROR->status, 0);
		
		if ($result = $this->database->query("SELECT COUNT(`S1`.`subscription_id`) AS `count` FROM `".self::DB_TABLE."` AS `S1` WHERE `S1`.`start_date`<='".$someDate."' AND `S1`.`finish_date`>='".$someDate."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				return new Response($this->SUCCESS->status, $res['count']);
				
			}
		}
		
		return new Response($this->NOT_FOUND->status, 0);
		
	}
	
	public function updateSubscription($dto) {
		
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($this->database->query("UPDATE `".self::DB_TABLE."` SET `start_date`='".$dto->startDate."', `finish_date`='".$dto->finishDate."' WHERE `subscription_id`='".$dto->id."';"))
			return $this->SUCCESS;
			
		return $this->NOT_FOUND;
		
	}
	
	public function deleteSubscription($subscriptionID) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($this->database->query("DELETE FROM `".self::DB_TABLE."` WHERE `subscription_id`='".$subscriptionID."';"))
			return $this->SUCCESS;
			
		return $this->NOT_FOUND;
		
	}
	
}

?>