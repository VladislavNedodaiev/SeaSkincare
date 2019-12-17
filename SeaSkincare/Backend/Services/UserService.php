<?php

namespace SeaSkincare\Backend\Services;

use SeaSkincare\Backend\DTOs\UserDTO;
use SeaSkincare\Backend\Services\MailService;
use SeaSkincare\Backend\Communication\Response;

class UserService
{
	
	private $database;
	private $mailService;
	
	private const DB_TABLE = "User";
	
	public $UNVERIFIED;
	public $EMAIL_REGISTERED;
	public $NICKNAME_REGISTERED;
	public $WRONG_PASSWORD;
	public $EMAIL_UNSENT;
	public $SAME_PASSWORDS;
	
	public $NOT_FOUND;
	public $SUCCESS;
	public $DB_ERROR;
	
	public function __construct($host, $user, $pswd, $db, $mailService) {
		
		$UNVERIFIED = new Response("UNVERIFIED_USER", null);
		$EMAIL_REGISTERED = new Response("EMAIL_REGISTERED", null);
		$NICKNAME_REGISTERED = new Response("NICKNAME_REGISTERED", null);
		$WRONG_PASSWORD = new Response("WRONG_PASSWORD", null);
		$EMAIL_UNSENT = new Response("EMAIL_UNSENT", null);
		$SAME_PASSWORDS = new Response("SAME_PASSWORDS", null);
		
		$NOT_FOUND = new Response("NOT_FOUND", null);
		$SUCCESS = new Response("SUCCESS", null);
		$DB_ERROR = new Response("DB_ERROR", null);
		
		$this->connectToDB($host, $user, $pswd, $db);
		$this->mailService = $mailService;
	
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
	public function login($email, $password) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`email`='".$email."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				if ($res['verification'])
					return $this->UNVERIFIED;
				if (password_verify($password, $res['hash'])) {

					$dto = new UserDTO;
					
					$dto->id = $res['user_id'];
					$dto->password = $res['hash'];
					$dto->nickname = $res['nickname'];
					$dto->email = $res['email'];
					$dto->verification = $res['verification'];
					
					return new Response($this->SUCCESS->status, $dto);
					
				}
				else
					return $this->WRONG_PASSWORD;
			}
		}
		
		return $this->NOT_FOUND;
		
	}
	
	// registering user
	public function register($email, $password, $nickname) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`email`='".$email."' OR `".self::DB_TABLE."`.`nickname`='".$nickname."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				if ($email == $res['email'])
					return $this->EMAIL_REGISTERED;
				else
					return $this->NICKNAME_REGISTERED;
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
			
			if ($this->mailService->sendVerificationEmail($email, $verification) == $mailService->SUCCESS->status) {
				
				$this->database->query("COMMIT;");
				return $this->SUCCESS;
				
			} else {
				$this->database->query("ROLLBACK TO reg_".$nickname.";");
				$this->database->query("COMMIT;");
				
				return $this->EMAIL_UNSENT;
			}
			
		}
		
		return $this->DB_ERROR;
		
	}
	
	// verifying user
	public function verify($userID, $verification) {
	
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* From `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`user_id`='".$userID."' AND `verification`='".$verification."';")) {
			
			if ($this->database->query("UPDATE `".self::DB_TABLE."` SET `verification`=NULL WHERE `user_id`='".$userID."';"))
				return $this->SUCCESS;
			
			return $this->DB_ERROR;
			
		}
		
		return $this->NOT_FOUND;
	
	}
	
	// getting public data of user by id from database
	public function getUser($userID) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* From `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`user_id`='".$userID."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				
				$dto = new UserDTO;
					
				$dto->ID = $res['user_id'];
				$dto->nickname = $res['nickname'];
				$dto->email = $res['email'];
				
				return new Response($this->SUCCESS->status, $dto);
				
			}
		}
		
		return $this->NOT_FOUND;
		
	}
	
	public function updateUser($dto) {
		
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($this->database->query("UPDATE `".self::DB_TABLE."` SET `nickname`=".$dto->nickname.", `email`=".$dto->email." WHERE `user_id`='".$dto->id."';"))
			return $this->SUCCESS;
			
		return $this->DB_ERROR;
		
	}
	
	// update password
	public function updatePassword($userID, $oldPassword, $newPassword) {
	
		if ($oldPassword == $newPassword)
			return $this->SAME_PASSWORDS;
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		$userResponse = $this->getUser($userID);
		if ($userResponse->status !=$this->SUCCESS)
			return $userResponse;
		
		$result = $this->login($userResponse->content->email, $oldPassword);
		
		if ($result->status ==$this->SUCCESS->status) {
			
			$temp = password_hash($newPassword, PASSWORD_BCRYPT);
			if ($mysqli->query("UPDATE `".self::DB_TABLE."` SET `hash`=".$temp." WHERE `user_id`='".$userID."';"))
				return $this->SUCCESS;
			
			return $this->NOT_FOUND;
			
		}
		
		return $result;
	
	}
	
	public function deleteUser($userID)
	{
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($this->database->query("DELETE FROM `".self::DB_TABLE."` WHERE `user_id`='".$userID."';"))
			return $this->SUCCESS;
			
		return $this->NOT_FOUND;
		
	}
	
}

?>