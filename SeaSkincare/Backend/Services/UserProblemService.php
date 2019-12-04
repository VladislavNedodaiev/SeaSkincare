<?php

namespace SeaSkincare\Backend\Services;

use SeaSkincare\Backend\Entities\UserProblem;
use SeaSkincare\Backend\DTOs\UserProblemDTO;
use SeaSkincare\Backend\Mappers\UserProblemMapper;
use SeaSkincare\Backend\Communication\Response;

class UserProblemService
{
	
	private $database;
	
	private const DB_TABLE = "User_Problem";
	
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
	
	public function createUserProblem($dto) {
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;

		$response = $this->getUserProblemByIDs($dto->userID, $dto->skinProblemID);
		if ($response->status == self::SUCCESS->status)
			return $response;

		if ($this->database->query("INSERT INTO `".self::DB_TABLE."`(`user_id`, `skin_problem_id`)".
						   "VALUES (".
						   "'".$dto->userID."',".
						   "'".$dto->skinProblemID."');")) {
							   
			$lastID = $this->getLastID();
			if ($lastID->status == self::SUCCESS->status
				&& $result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`user_problem_id`=".$lastID->content.";")) {
				if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
					
					$dto->id = $res['user_problem_id'];
					
					return new Response(self::SUCCESS->status, UserProblemMapper::DTOToEntity($dto));
					
				}
			}
		}
			
		return self::DB_ERROR;
		
	}
	
	public function getUserProblem($userProblemID) {
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`user_problem_id`='".$userProblemID."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$dto = new UserProblemDTO;
					
				$dto->id = $res['user_problem_id'];
				$dto->userID = $res['user_id'];
				$dto->skinProblemID = $res['skin_problem_id'];
				
				return new Response(self::SUCCESS->status, UserProblemMapper::DTOToEntity($dto));
				
			}
		}
		
		return self::NOT_FOUND;
		
	}
	
	public function getUserProblemsByIDs($userID, $skinProblemID) {
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`user_id`='".$userID."' AND `".self::DB_TABLE."`.`skin_problem_id`='".$skinProblemID."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$dto = new UserProblemDTO;
					
				$dto->id = $res['user_problem_id'];
				$dto->userID = $res['user_id'];
				$dto->skinProblemID = $res['skin_problem_id'];
				
				return new Response(self::SUCCESS->status, UserProblemMapper::DTOToEntity($dto));
				
			}
		}
		
		return self::NOT_FOUND;
		
	}
	
	public function getUserProblemsByUserID($userID) {
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`user_id`='".$userID."';")) {
			
			$userProblems = new Array();
			
			while ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$dto = new UserProblemDTO;
					
				$dto->id = $res['user_problem_id'];
				$dto->userID = $res['user_id'];
				$dto->skinProblemID = $res['skin_problem_id'];
				
				array_push($userProblems, UserProblemMapper::DTOToEntity($dto));
				
			}
			
			return new Response(self::SUCCESS->status, $userProblems);
		}
		
		return self::NOT_FOUND;
		
	}
	
	public function getUserProblemsBySkinProblemID($skinProblemID) {
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`skin_problem_id`='".$skinProblemID."';")) {
			
			$userProblems = new Array();
			
			while ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$dto = new UserProblemDTO;
					
				$dto->id = $res['user_problem_id'];
				$dto->userID = $res['user_id'];
				$dto->skinProblemID = $res['skin_problem_id'];
				
				array_push($userProblems, UserProblemMapper::DTOToEntity($dto));
				
			}
			
			return new Response(self::SUCCESS->status, $userProblems);
		}
		
		return self::NOT_FOUND;
		
	}
	
	public function getLastID() {
		
		if (!$this->database || $this->database->connect_errno)
			return new Response(self::DB_ERROR->status, 0);
		
		if ($result = $this->database->query("SELECT MAX(`".self::DB_TABLE."`.`user_problem_id`) AS `id` FROM `".self::DB_TABLE."`;")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				return new Response(self::SUCCESS->status, $res['id']);
				
			}
		}
		
		return new Response(self::NOT_FOUND->status, 0);
		
	}
	
	public function deleteUserProblem($userProblemID) {
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($this->database->query("DELETE FROM `".self::DB_TABLE."` WHERE `user_problem_id`='".$userProblemID."';"))
			return self::SUCCESS;
			
		return self::NOT_FOUND;
		
	}
	
}

?>