<?php

namespace SeaSkincare\Backend\Services;

use SeaSkincare\Backend\Services\Service;
use SeaSkincare\Backend\Services\LogService;
use SeaSkincare\Backend\DTOs\VacationDTO;
use SeaSkincare\Backend\Communication\Response;

class VacationService extends Service
{
		
	private $DB_TABLE;
	
	public function __construct($host, $user, $pswd, $db, $logService) {
	
		parent::__construct($host, $user, $pswd, $db, $logService);
		
		$this->DB_TABLE = "Vacation";
	
	}
	
	public function createVacation($dto) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($this->database->query("INSERT INTO `".$this->DB_TABLE."`(`user_id`, `business_id`, `start_date`, `finish_date`)".
						   "VALUES (".
						   "'".$dto->userID."',".
						   "'".$dto->businessID."', ".
						   "'".$dto->startDate."', ".
						   "'".$dto->finishDate."');")) {
			$lastID = $this->getLastID();
			if ($lastID->status ==$this->SUCCESS->status
				&& $result = $this->database->query("SELECT `".$this->DB_TABLE."`.* FROM `".$this->DB_TABLE."` WHERE `".$this->DB_TABLE."`.`vacation_id`=".$lastID->content.";")) {
				if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
					
					$dto->id = $res['vacation_id'];
					
					return new Response($this->SUCCESS->status, $dto);
					
				}
			}
		}
			
		return $this->DB_ERROR;
		
	}
	
	public function getVacation($vacationID) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".$this->DB_TABLE."`.* FROM `".$this->DB_TABLE."` WHERE `".$this->DB_TABLE."`.`vacation_id`='".$vacationID."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$dto = new VacationDTO;
					
				$dto->id = $res['vacation_id'];
				$dto->userID = $res['user_id'];
				$dto->businessID = $res['business_id'];
				$dto->startDate = $res['start_date'];
				$dto->finishDate = $res['finish_date'];
				
				return new Response($this->SUCCESS->status, $dto);
				
			}
		}
		
		return $this->NOT_FOUND;
		
	}
	
	public function getLastID() {
		
		if (!$this->database || $this->database->connect_errno)
			return new Response($this->DB_ERROR->status, 0);
		
		if ($result = $this->database->query("SELECT MAX(`".$this->DB_TABLE."`.`vacation_id`) AS `id` FROM `".$this->DB_TABLE."`;")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				return new Response($this->SUCCESS->status, $res['id']);
				
			}
		}
		
		return new Response($this->NOT_FOUND->status, 0);
		
	}
	
	public function getVacationsByIDs($userID, $businessID) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".$this->DB_TABLE."`.* FROM `".$this->DB_TABLE."` WHERE `".$this->DB_TABLE."`.`user_id`='".$userID."' AND `".$this->DB_TABLE."`.`business_id`='".$businessID."';")) {
			
			$vacations = array();
			
			while ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$dto = new VacationDTO;
					
				$dto->id = $res['vacation_id'];
				$dto->userID = $res['user_id'];
				$dto->businessID = $res['business_id'];
				$dto->startDate = $res['start_date'];
				$dto->finishDate = $res['finish_date'];
				
				array_push($vacations, $dto);
				
			}
			
			if (!empty($vacations))
				return new Response($this->SUCCESS->status, $vacations);
			
		}
		
		return $this->NOT_FOUND;
		
	}

	// dateFlag - ended before someDate (<0), active at someDate (0), starting after someDate (>0)
	// someDate - some date
	public function getVacationsByIDsDate($userID, $businessID, $dateFlag, $someDate) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		$query = "SELECT `V1`.* FROM `".$this->DB_TABLE."` AS `V1` WHERE `V1`.`user_id`='".$userID."' AND `V1`.`business_id`='".$businessID."' AND ";
		if ($dateFlag < 0)
			$query .= "`V1`.`finish_date`<'".$someDate."'";
		else if ($dateFlag > 0)
			$query .= "`V1`.`start_date`>'".$someDate."'";
		else
			$query .= "`V1`.`start_date`<='".$someDate."' AND `V1`.`finish_date`>='".$someDate."'";
		
		$query .= ";";
	
		if ($result = $this->database->query($query)) {
			
			$vacations = array();
			
			while ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$dto = new VacationDTO;
					
				$dto->id = $res['vacation_id'];
				$dto->userID = $res['user_id'];
				$dto->businessID = $res['business_id'];
				$dto->startDate = $res['start_date'];
				$dto->finishDate = $res['finish_date'];
				
				array_push($vacations, $dto);
				
			}
			
			if (!empty($vacations))
				return new Response($this->SUCCESS->status, $vacations);
			
		}
		
		return $this->NOT_FOUND;
		
	}
	
	public function getVacationsByUserID($userID) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".$this->DB_TABLE."`.* FROM `".$this->DB_TABLE."` WHERE `".$this->DB_TABLE."`.`user_id`='".$userID."';")) {
			
			$vacations = array();
			
			while ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$dto = new VacationDTO;
					
				$dto->id = $res['vacation_id'];
				$dto->userID = $res['user_id'];
				$dto->businessID = $res['business_id'];
				$dto->startDate = $res['start_date'];
				$dto->finishDate = $res['finish_date'];
				
				array_push($vacations, $dto);
				
			}
			
			if (!empty($vacations))
				return new Response($this->SUCCESS->status, $vacations);
			
		}
		
		return $this->NOT_FOUND;
		
	}
	
	// dateFlag - ended before someDate (<0), active at someDate (0), starting after someDate (>0)
	// someDate - some date
	public function getVacationsByUserIDDate($userID, $dateFlag, $someDate) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		$query = "SELECT `V1`.* FROM `".$this->DB_TABLE."` AS `V1` WHERE `V1`.`user_id`='".$userID."' AND ";
		if ($dateFlag < 0)
			$query .= "`V1`.`finish_date`<'".$someDate."'";
		else if ($dateFlag > 0)
			$query .= "`V1`.`start_date`>'".$someDate."'";
		else
			$query .= "`V1`.`start_date`<='".$someDate."' AND `V1`.`finish_date`>='".$someDate."'";
		
		$query .= ";";
		
		if ($result = $this->database->query($query)) {
			
			$vacations = array();
			
			while ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$dto = new VacationDTO;
					
				$dto->id = $res['vacation_id'];
				$dto->userID = $res['user_id'];
				$dto->businessID = $res['business_id'];
				$dto->startDate = $res['start_date'];
				$dto->finishDate = $res['finish_date'];
				
				array_push($vacations, $dto);
				
			}
			
			if (!empty($vacations))
				return new Response($this->SUCCESS->status, $vacations);
			
		}
		
		return $this->NOT_FOUND;
		
	}
	
	public function getVacationsByBusinessID($businessID) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".$this->DB_TABLE."`.* FROM `".$this->DB_TABLE."` WHERE `".$this->DB_TABLE."`.`business_id`='".$businessID."';")) {
			
			$vacations = array();
			
			while ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$dto = new VacationDTO;
					
				$dto->id = $res['vacation_id'];
				$dto->userID = $res['user_id'];
				$dto->businessID = $res['business_id'];
				$dto->startDate = $res['start_date'];
				$dto->finishDate = $res['finish_date'];
				
				array_push($vacations, $dto);
				
			}
			
			if (!empty($vacations))
				return new Response($this->SUCCESS->status, $vacations);
			
		}
		
		return $this->NOT_FOUND;
		
	}
	
	// dateFlag - ended before someDate (<0), active at someDate (0), starting after someDate (>0)
	// someDate - some date
	public function getVacationsByBusinessIDDate($businessID, $dateFlag, $someDate) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		$query = "SELECT `V1`.* FROM `".$this->DB_TABLE."` AS `V1` WHERE `V1`.`business_id`='".$businessID."' AND ";
		if ($dateFlag < 0)
			$query .= "`V1`.`finish_date`<'".$someDate."'";
		else if ($dateFlag > 0)
			$query .= "`V1`.`start_date`>'".$someDate."'";
		else
			$query .= "`V1`.`start_date`<='".$someDate."' AND `V1`.`finish_date`>='".$someDate."'";
		
		$query .= ";";
		
		if ($result = $this->database->query($query)) {
			
			$vacations = array();
			
			while ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$dto = new VacationDTO;
					
				$dto->id = $res['vacation_id'];
				$dto->userID = $res['user_id'];
				$dto->businessID = $res['business_id'];
				$dto->startDate = $res['start_date'];
				$dto->finishDate = $res['finish_date'];
				
				array_push($vacations, $dto);
				
			}
			
			if (!empty($vacations))
				return new Response($this->SUCCESS->status, $vacations);
			
		}
		
		return $this->NOT_FOUND;
		
	}
	
	public function updateVacation($dto) {
		
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($this->database->query("UPDATE `".$this->DB_TABLE."` SET `start_date`='".$dto->startDate."', `finish_date`='".$dto->finishDate."' WHERE `vacation_id`='".$dto->id."';"))
			return $this->SUCCESS;
			
		return $this->NOT_FOUND;
		
	}
	
	public function deleteVacation($vacationID)
	{
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($this->database->query("DELETE FROM `".$this->DB_TABLE."` WHERE `vacation_id`='".$vacationID."';"))
			return $this->SUCCESS;
			
		return $this->NOT_FOUND;
		
	}
	
}

?>