<?php

namespace SeaSkincare\Backend\Services;

use SeaSkincare\Backend\Entities;
use SeaSkincare\Backend\DTOs;
use SeaSkincare\Backend\Mappers;

class UserService
{
	
	private $database;
	private $mailService;
	
	private const DB_TABLE = "User";
	
	public const UNVERIFIED = "UNVERIFIED_USER";
	public const NO_USER = "NO_USER";
	public const EMAIL_REGISTERED = "EMAIL_REGISTERED";
	public const NICKNAME_REGISTERED = "NICKNAME_REGISTERED";
	public const WRONG_PASSWORD = "WRONG_PASSWORD";
	
	public const SUCCESS = "SUCCESS";
	public const DB_ERROR = "DB_ERROR";
	public const EMAIL_UNSENT = "EMAIL_UNSENT";
	
	public function __construct($host, $user, $pswd, $db, $mailService) {
	
		$this->connectToDB();
		$this->mailService = $mailService;
	
	}
	
	private function connectToDB($host, $user, $pswd, $db) {

		$this->database = new mysqli($host, $user, $pswd, $db);

		if ($this->database->connect_errno) {
			return null;
		}

		$this->database->set_charset('utf8');

		return $this->database;
		
	}
	
	// logging in (getting private data, such as email)
	public function login($email, $password) {
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`email`='".$email."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				if ($res['verification'])
					return self::UNVERIFIED;
				if (password_verify($password, $res['hash'])) {

					$userDto = new UserDTO;
					
					$userDto->ID = $res['user_id'];
					$userDto->password = $res['hash'];
					$userDto->nickname = $res['nickname'];
					$userDto->email = $res['email'];
					$userDto->verification = $res['verification'];
					
					return UserMapper::DTOToEntity($userDto);
					
				}
				else
					return self::WRONG_PASSWORD;
			}
		}
		
		return self::NO_USER;
		
	}
	
	// registering user
	public function register($email, $password, $nickname) {
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`email`='".$email."' OR `".self::DB_TABLE."`.`nickname`='".$nickname."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				if ($email == $res['email'])
					return self::EMAIL_REGISTERED;
				else
					return self::NICKNAME_REGISTERED;
			}
		}
		
		// generating verification hash
		$verification = md5(rand(0, 10000));
		
		$this->database->query("START TRANSACTION;");
		$this->database->query("SAVEPOINT reg_".$nickname.";");
		
		if ($this->database->query("INSERT INTO `".self::DB_TABLE."`(`hash`, `nickname`, `email`, `verification`)".
						   "VALUES (".
						   "'".password_hash($password, PASSWORD_BCRYPT)."',".
						   "'".$nickname."', ".
						   "'".$email."', ".
						   "'".$verification."');")) {
			
			if ($this->mailService->sendVerificationEmail($email, $verification)) {
				
				$this->database->query("COMMIT;");
				return self::SUCCESS;
				
			} else {
				$this->database->query("ROLLBACK TO reg_".$nickname.";");
				$this->database->query("COMMIT;");
				
				return self::EMAIL_UNSENT;
			}
			
		}
		
		return self::DB_ERROR;
		
	}
	
	// verifying user
	public function verify($email, $verification) {
	
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* From `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`email`='".$email."' AND `verification`='".$verification."';")) {
			
			if ($this->database->query("UPDATE `".self::DB_TABLE."` SET `verification`=NULL WHERE `email`='".$email."';"))
				return self::SUCCESS;
			
			return self::DB_ERROR;
			
		}
		
		return self::NO_USER;
	
	}
	
	// getting public data of user by id from database
	public function getUser($userID) {
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* From `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`user_id`='".$userID."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				
				$userDto = new UserDTO;
					
				$userDto->ID = $res['user_id'];
				$userDto->nickname = $res['nickname'];
				
				return UserMapper::DTOToEntity($userDto);
				
			}
		}
		
		return self::NO_USER;
		
	}
	
	public function updateUser($dto) {
		
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($this->database->query("UPDATE `".self::DB_TABLE."` SET `hash`=".$dto->hashPassword.", `nickname`=".$dto->nickname.", `email`=".$dto->email." WHERE `user_id`='".$dto->id."';")) {
			
			$this->nickname=$nickname;
			
			return self::SUCCESS;
		
		}
			
		return self::DB_ERROR;
		
	}
	
	public function deleteUser($userID)
	{
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($this->database->query("DELETE FROM `".self::DB_TABLE."` WHERE `userID`='".$userID."';"))
			return self::SUCCESS;
			
		return self::DB_ERROR;
		
	}
	
}

?>