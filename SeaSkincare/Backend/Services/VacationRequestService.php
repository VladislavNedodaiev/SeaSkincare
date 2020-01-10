<?php

namespace SeaSkincare\Backend\Services;

use SeaSkincare\Backend\Services\Service;
use SeaSkincare\Backend\Services\LogService;
use SeaSkincare\Backend\DTOs\VacationRequestDTO;
use SeaSkincare\Backend\Communication\Response;

class VacationRequestService extends Service
{
	
	private $DB_TABLE;
	
	public function __construct($host, $user, $pswd, $db, $logService) {
	
		parent::__construct($host, $user, $pswd, $db, $logService);
		
		$this->DB_TABLE = "Vacation_Request";
	
	}
	
	public function createVacationRequest($dto) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($this->database->query("INSERT INTO `".$this->DB_TABLE."`(`user_id`, `business_id`)".
						   "VALUES (".
						   "'".$dto->userID."',".
						   "'".$dto->businessID."');")) {
			$lastID = $this->getLastID();
			if ($lastID->status ==$this->SUCCESS->status
				&& $result = $this->database->query("SELECT `".$this->DB_TABLE."`.* FROM `".$this->DB_TABLE."` WHERE `".$this->DB_TABLE."`.`vacation_request_id`=".$lastID->content.";")) {
				if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
					
					$dto->id = $res['vacation_request_id'];
					$dto->requestDate = $res['request_date'];
					$dto->status = $res['status'];
					
					return new Response($this->SUCCESS->status, $dto);
					
				}
			}
		}
			
		return $this->DB_ERROR;
		
	}
	
	public function getVacationRequest($vacationRequestID) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".$this->DB_TABLE."`.* FROM `".$this->DB_TABLE."` WHERE `".$this->DB_TABLE."`.`vacation_request_id`='".$vacationRequestID."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$dto = new VacationRequestDTO;
					
				$dto->id = $res['vacation_request_id'];
				$dto->userID = $res['user_id'];
				$dto->businessID = $res['business_id'];
				$dto->requestDate = $res['request_date'];
				$dto->status = $res['status'];
				
				return new Response($this->SUCCESS->status, $dto);
				
			}
		}
		
		return $this->NOT_FOUND;
		
	}
	
	public function getLastID() {
		
		if (!$this->database || $this->database->connect_errno)
			return new Response($this->DB_ERROR->status, 0);
		
		if ($result = $this->database->query("SELECT MAX(`".$this->DB_TABLE."`.`vacation_request_id`) AS `id` FROM `".$this->DB_TABLE."`;")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				return new Response($this->SUCCESS->status, $res['id']);
				
			}
		}
		
		return new Response($this->NOT_FOUND->status, 0);
		
	}
	
	// all vacationRequests
	public function getVacationRequestsByIDs($userID, $businessID) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".$this->DB_TABLE."`.* FROM `".$this->DB_TABLE."` WHERE `".$this->DB_TABLE."`.`user_id`='".$userID."' AND `".$this->DB_TABLE."`.`business_id`='".$businessID."';")) {
			
			$vacationRequests = array();
			
			while ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$dto = new VacationRequestDTO;
					
				$dto->id = $res['vacation_request_id'];
				$dto->userID = $res['user_id'];
				$dto->businessID = $res['business_id'];
				$dto->requestDate = $res['request_date'];
				$dto->status = $res['status'];
				
				array_push($vacationRequests, $dto);
				
			}
			
			if (!empty($vacationRequests))
				return new Response($this->SUCCESS->status, $vacationRequests);
			
		}
		
		return $this->NOT_FOUND;
		
	}
	
	// get all vacation requests with exact status
	public function getVacationRequestsByIDsStatus($userID, $businessID, $status) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".$this->DB_TABLE."`.* FROM `".$this->DB_TABLE."` WHERE `".$this->DB_TABLE."`.`user_id`='".$userID."' AND `".$this->DB_TABLE."`.`business_id`='".$businessID."' AND `".$this->DB_TABLE."`.`status`='".$status."';")) {
			
			$vacationRequests = array();
			
			while ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$dto = new VacationRequestDTO;
					
				$dto->id = $res['vacation_request_id'];
				$dto->userID = $res['user_id'];
				$dto->businessID = $res['business_id'];
				$dto->requestDate = $res['request_date'];
				$dto->status = $res['status'];
				
				array_push($vacationRequests, $dto);
				
			}
			
			if (!empty($vacationRequests))
				return new Response($this->SUCCESS->status, $vacationRequests);
			
		}
		
		return $this->NOT_FOUND;
		
	}
	
	public function getVacationRequestsByUserID($userID) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".$this->DB_TABLE."`.* FROM `".$this->DB_TABLE."` WHERE `".$this->DB_TABLE."`.`user_id`='".$userID."';")) {
			
			$vacationRequests = array();
			
			while ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$dto = new VacationRequestDTO;
					
				$dto->id = $res['vacation_request_id'];
				$dto->userID = $res['user_id'];
				$dto->businessID = $res['business_id'];
				$dto->requestDate = $res['request_date'];
				$dto->status = $res['status'];
				
				array_push($vacationRequests, $dto);
				
			}
			
			if (!empty($vacationRequests))
				return new Response($this->SUCCESS->status, $vacationRequests);
			
		}
		
		return $this->NOT_FOUND;
		
	}
	
	// get all vacation requests with exact status
	public function getVacationRequestsByUserIDStatus($userID, $status) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".$this->DB_TABLE."`.* FROM `".$this->DB_TABLE."` WHERE `".$this->DB_TABLE."`.`user_id`='".$userID."' AND `".$this->DB_TABLE."`.`status`='".$status."';")) {
			
			$vacationRequests = array();
			
			while ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$dto = new VacationRequestDTO;
					
				$dto->id = $res['vacation_request_id'];
				$dto->userID = $res['user_id'];
				$dto->businessID = $res['business_id'];
				$dto->requestDate = $res['request_date'];
				$dto->status = $res['status'];
				
				array_push($vacationRequests, $dto);
				
			}
			
			if (!empty($vacationRequests))
				return new Response($this->SUCCESS->status, $vacationRequests);
			
		}
		
		return $this->NOT_FOUND;
		
	}
	
	public function getVacationRequestsByBusinessID($businessID) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".$this->DB_TABLE."`.* FROM `".$this->DB_TABLE."` WHERE `".$this->DB_TABLE."`.`business_id`='".$businessID."';")) {
			
			$vacationRequests = array();
			
			while ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$dto = new VacationRequestDTO;
					
				$dto->id = $res['vacation_request_id'];
				$dto->userID = $res['user_id'];
				$dto->businessID = $res['business_id'];
				$dto->requestDate = $res['request_date'];
				$dto->status = $res['status'];
				
				array_push($vacationRequests, $dto);
				
			}
			
			if (!empty($vacationRequests))
				return new Response($this->SUCCESS->status, $vacationRequests);
			
		}
		
		return $this->NOT_FOUND;
		
	}
	
	// get all vacation requests with exact status
	public function getVacationRequestsByBusinessIDStatus($businessID, $status) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".$this->DB_TABLE."`.* FROM `".$this->DB_TABLE."` WHERE `".$this->DB_TABLE."`.`business_id`='".$businessID."' AND `".$this->DB_TABLE."`.`status`='".$status."';")) {
			
			$vacationRequests = array();
			
			while ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$dto = new VacationRequestDTO;
					
				$dto->id = $res['vacation_request_id'];
				$dto->userID = $res['user_id'];
				$dto->businessID = $res['business_id'];
				$dto->requestDate = $res['request_date'];
				$dto->status = $res['status'];
				
				array_push($vacationRequests, $dto);
				
			}
			
			if (!empty($vacationRequests))
				return new Response($this->SUCCESS->status, $vacationRequests);
			
		}
		
		return $this->NOT_FOUND;
		
	}
	
	public function updateVacationRequest($dto) {
		
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($this->database->query("UPDATE `".$this->DB_TABLE."` SET `status`='".$dto->status."' WHERE `vacation_request_id`='".$dto->id."';"))
			return $this->SUCCESS;
			
		return $this->NOT_FOUND;
		
	}
	
	public function deleteVacationRequest($vacationRequestID)
	{
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($this->database->query("DELETE FROM `".$this->DB_TABLE."` WHERE `vacation_request_id`='".$vacationRequestID."';"))
			return $this->SUCCESS;
			
		return $this->NOT_FOUND;
		
	}
	
}

?>