<?php

namespace SeaSkincare\Backend\Services;

use SeaSkincare\Backend\Services\LogService;
use SeaSkincare\Backend\DTOs\UserDTO;
use SeaSkincare\Backend\Services\MailService;
use SeaSkincare\Backend\Communication\Response;

class UserService
{
	
	private $mailService;
	
	private const DB_TABLE = "User";
	
	public $UNVERIFIED;
	public $EMAIL_REGISTERED;
	public $WRONG_PASSWORD;
	public $EMAIL_UNSENT;
	public $SAME_PASSWORDS;
	
	public function __construct($host, $user, $pswd, $db, $mailService, $logService) {
		
		parent::__construct($host, $user, $pswd, $db, $logService);
		
		$this->UNVERIFIED = new Response("UNVERIFIED_USER", null);
		$this->EMAIL_REGISTERED = new Response("EMAIL_REGISTERED", null);
		$this->WRONG_PASSWORD = new Response("WRONG_PASSWORD", null);
		$this->EMAIL_UNSENT = new Response("EMAIL_UNSENT", null);
		$this->SAME_PASSWORDS = new Response("SAME_PASSWORDS", null);
		
		$this->mailService = $mailService;
	
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
					$dto->registerDate = $res['register_date'];
					$dto->password = $res['hash'];
					$dto->nickname = $res['nickname'];
					$dto->email = $res['email'];
					$dto->verification = $res['verification'];
					$dto->name = $res['name'];
					$dto->gender = $res['gender'];
					$dto->phoneNumber = $res['phone_number'];
					
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
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`email`='".$email."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				return $this->EMAIL_REGISTERED;
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
			
			if ($this->mailService->sendVerificationEmail($email, $verification) == $this->mailService->SUCCESS->status) {
				
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
	
	// getting data for business of user by id from database
	public function getUser($userID) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* From `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`user_id`='".$userID."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				
				$dto = new UserDTO;
					
				$dto->id = $res['user_id'];
				$dto->registerDate = $res['register_date'];
				$dto->nickname = $res['nickname'];
				$dto->email = $res['email'];
				$dto->verification = $res['verification'];
				$dto->name = $res['name'];
				$dto->gender = $res['gender'];
				$dto->phoneNumber = $res['phone_number'];
				
				return new Response($this->SUCCESS->status, $dto);
				
			}
		}
		
		return $this->NOT_FOUND;
		
	}
	
	public function updateUser($dto) {
		
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($this->database->query("UPDATE `".self::DB_TABLE."` SET `nickname`='".$dto->nickname."', `name`='".$dto->name."', `gender`='".$dto->gender."', `phone_number`='".$dto->phoneNumber."' WHERE `user_id`='".$dto->id."';"))
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
		if ($userResponse->status != $this->SUCCESS)
			return $userResponse;
		
		$result = $this->login($userResponse->content->email, $oldPassword);
		
		if ($result->status ==$this->SUCCESS->status) {
			
			$temp = password_hash($newPassword, PASSWORD_BCRYPT);
			if ($mysqli->query("UPDATE `".self::DB_TABLE."` SET `hash`='".$temp."' WHERE `user_id`='".$userID."';"))
				return $this->SUCCESS;
			
			return $this->NOT_FOUND;
			
		}
		
		return $result;
	
	}
	
	public function deleteUser($userID) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($this->database->query("DELETE FROM `".self::DB_TABLE."` WHERE `user_id`='".$userID."';"))
			return $this->SUCCESS;
			
		return $this->NOT_FOUND;
		
	}
	
}

?>