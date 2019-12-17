<?php

namespace SeaSkincare\Backend\Services;

use SeaSkincare\Backend\DTOs\UserProblemDTO;
use SeaSkincare\Backend\Communication\Response;

class UserProblemService {
	
	private $database;
	
	private const DB_TABLE = "User_Problem";
	
	public $NOT_FOUND;
	public $SUCCESS;
	public $DB_ERROR;
	
	public function __construct($host, $user, $pswd, $db) {
		
		$this->NOT_FOUND = new Response("NOT_FOUND", null);
		$this->SUCCESS = new Response("SUCCESS", null);
		$this->DB_ERROR = new Response("DB_ERROR", null);
		
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
	
	public function createUserProblem($dto) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;

		$response = $this->getUserProblemByIDs($dto->userID, $dto->skinProblemID);
		if ($response->status ==$this->SUCCESS->status)
			return $response;

		if ($this->database->query("INSERT INTO `".self::DB_TABLE."`(`user_id`, `skin_problem_id`)".
						   "VALUES (".
						   "'".$dto->userID."',".
						   "'".$dto->skinProblemID."');")) {
							   
			$lastID = $this->getLastID();
			if ($lastID->status ==$this->SUCCESS->status
				&& $result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`user_problem_id`=".$lastID->content.";")) {
				if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
					
					$dto->id = $res['user_problem_id'];
					
					return new Response($this->SUCCESS->status, $dto);
					
				}
			}
		}
			
		return $this->DB_ERROR;
		
	}
	
	public function getUserProblem($userProblemID) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`user_problem_id`='".$userProblemID."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$dto = new UserProblemDTO;
					
				$dto->id = $res['user_problem_id'];
				$dto->userID = $res['user_id'];
				$dto->skinProblemID = $res['skin_problem_id'];
				
				return new Response($this->SUCCESS->status, $dto);
				
			}
		}
		
		return $this->NOT_FOUND;
		
	}
	
	public function getUserProblemsByIDs($userID, $skinProblemID) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`user_id`='".$userID."' AND `".self::DB_TABLE."`.`skin_problem_id`='".$skinProblemID."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$dto = new UserProblemDTO;
					
				$dto->id = $res['user_problem_id'];
				$dto->userID = $res['user_id'];
				$dto->skinProblemID = $res['skin_problem_id'];
				
				return new Response($this->SUCCESS->status, $dto);
				
			}
		}
		
		return $this->NOT_FOUND;
		
	}
	
	public function getUserProblemsByUserID($userID) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`user_id`='".$userID."';")) {
			
			$userProblems = array();
			
			while ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$dto = new UserProblemDTO;
					
				$dto->id = $res['user_problem_id'];
				$dto->userID = $res['user_id'];
				$dto->skinProblemID = $res['skin_problem_id'];
				
				array_push($userProblems, $dto);
				
			}
			
			return new Response($this->SUCCESS->status, $userProblems);
		}
		
		return $this->NOT_FOUND;
		
	}
	
	public function getUserProblemsBySkinProblemID($skinProblemID) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`skin_problem_id`='".$skinProblemID."';")) {
			
			$userProblems = array();
			
			while ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$dto = new UserProblemDTO;
					
				$dto->id = $res['user_problem_id'];
				$dto->userID = $res['user_id'];
				$dto->skinProblemID = $res['skin_problem_id'];
				
				array_push($userProblems, $dto);
				
			}
			
			return new Response($this->SUCCESS->status, $userProblems);
		}
		
		return $this->NOT_FOUND;
		
	}
	
	public function getLastID() {
		
		if (!$this->database || $this->database->connect_errno)
			return new Response($this->DB_ERROR->status, 0);
		
		if ($result = $this->database->query("SELECT MAX(`".self::DB_TABLE."`.`user_problem_id`) AS `id` FROM `".self::DB_TABLE."`;")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				return new Response($this->SUCCESS->status, $res['id']);
				
			}
		}
		
		return new Response($this->NOT_FOUND->status, 0);
		
	}
	
	public function deleteUserProblem($userProblemID) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($this->database->query("DELETE FROM `".self::DB_TABLE."` WHERE `user_problem_id`='".$userProblemID."';"))
			return $this->SUCCESS;
			
		return $this->NOT_FOUND;
		
	}
	
}

?>