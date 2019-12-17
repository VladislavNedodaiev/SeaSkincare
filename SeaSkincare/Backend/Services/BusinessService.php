<?php

namespace SeaSkincare\Backend\Services;

use SeaSkincare\Backend\DTOs\BusinessDTO;
use SeaSkincare\Backend\Services\MailService;
use SeaSkincare\Backend\Communication\Response;

class BusinessService
{
	
	private $database;
	private $mailService;
	
	private const DB_TABLE = "Business";
	
	public $UNVERIFIED = new Response("UNVERIFIED_BUSINESS", null);
	public $EMAIL_REGISTERED = new Response("EMAIL_REGISTERED", null);
	public $NICKNAME_REGISTERED = new Response("NICKNAME_REGISTERED", null);
	public $WRONG_PASSWORD = new Response("WRONG_PASSWORD", null);
	public $EMAIL_UNSENT = new Response("EMAIL_UNSENT", null);
	public $SAME_PASSWORDS = new Response("SAME_PASSWORDS", null);
	
	public $NOT_FOUND = new Response("NOT_FOUND", null);
	public $SUCCESS = new Response("SUCCESS", null);
	public $DB_ERROR = new Response("DB_ERROR", null);
	
	public function __construct($host, $user, $pswd, $db, $mailService) {

		$this->connectToDB($host, $user, $pswd, $db);
		$this->mailService = $mailService;

	}
	
	private function connectToDB($host, $user, $pswd, $db) {

		$this->database = new \mysqli($host, $user, $pswd, $db);

		if ($this->database->connect_errno) {
			return$this->DB_ERROR;
		}

		$this->database->set_charset('utf8');

		return new Response($this->SUCCESS->status, $this->database);
		
	}
	
	// logging in (getting private data, such as email)
	public function login($email, $password) {
		
		if (!$this->database || $this->database->connect_errno)
			return$this->DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`email`='".$email."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				if ($res['verification'])
					return$this->UNVERIFIED;
				if (password_verify($password, $res['hash'])) {

					$dto = new BusinessDTO;
					
					$dto->id = $res['business_id'];
					$dto->password = $res['hash'];
					$dto->nickname = $res['nickname'];
					$dto->description = $res['description'];
					$dto->photo = $res['photo'];
					$dto->email = $res['email'];
					$dto->verification = $res['verification'];
					
					return new Response($this->SUCCESS->status, $dto);
					
				}
				
				return$this->WRONG_PASSWORD;
			}
		}
		
		return$this->NOT_FOUND;
		
	}
	
	// registering user
	public function register($email, $password, $nickname) {
		
		if (!$this->database || $this->database->connect_errno)
			return$this->DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`email`='".$email."' OR `".self::DB_TABLE."`.`nickname`='".$nickname."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				if ($email == $res['email'])
					return$this->EMAIL_REGISTERED;
				else
					return$this->NICKNAME_REGISTERED;
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
			
			if ($this->mailService->sendVerificationEmail($email, $verification) == MailService::SUCCESS->status) {
				
				$this->database->query("COMMIT;");
				return$this->SUCCESS;
				
			} else {
				$this->database->query("ROLLBACK TO reg_".$nickname.";");
				$this->database->query("COMMIT;");
				
				return$this->EMAIL_UNSENT;
			}
			
		}
		
		return$this->DB_ERROR;
		
	}
	
	// verifying user
	public function verify($businessID, $verification) {
	
		if (!$this->database || $this->database->connect_errno)
			return$this->DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* From `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`business_id`='".$businessID."' AND `verification`='".$verification."';")) {
			
			if ($this->database->query("UPDATE `".self::DB_TABLE."` SET `verification`=NULL WHERE `business_id`='".$businessID."';"))
				return$this->SUCCESS;
			
			return$this->DB_ERROR;
			
		}
		
		return$this->NOT_FOUND;
	
	}
	
	// getting public data of user by id from database
	public function getBusiness($businessID) {
		
		if (!$this->database || $this->database->connect_errno)
			return$this->DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* From `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`business_id`='".$businessID."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				
				$dto = new BusinessDTO;
					
				$dto->ID = $res['business_id'];
				$dto->nickname = $res['nickname'];
				$dto->description = $res['description'];
				$dto->photo = $res['photo'];
				
				return new Response($this->SUCCESS->status, $dto);
				
			}
		}
		
		return$this->NOT_FOUND;
		
	}
	
	public function updateBusiness($dto) {
		
		
		if (!$this->database || $this->database->connect_errno)
			return$this->DB_ERROR;
		
		if ($this->database->query("UPDATE `".self::DB_TABLE."` SET `nickname`='".$dto->nickname."', `description`='".$dto->description."', `photo`='".$dto->photo."', `email`='".$dto->email."' WHERE `business_id`='".$dto->id."';"))
			return$this->SUCCESS;
			
		return$this->DB_ERROR;
		
	}
	
	// update password
	public function updatePassword($businessID, $oldPassword, $newPassword) {
	
		if ($oldPassword == $newPassword)
			return$this->SAME_PASSWORDS;
		
		if (!$this->database || $this->database->connect_errno)
			return$this->DB_ERROR;
		
		$businessResponse = $this->getBusiness($businessID);
		if ($businessResponse->status !=$this->SUCCESS->status)
			return $businessResponse;
		
		$result = $this->login($businessResponse->content->email, $oldPassword);
		
		if ($result->status ==$this->SUCCESS->status) {
			
			$temp = password_hash($newPassword, PASSWORD_BCRYPT);
			if ($mysqli->query("UPDATE `".self::DB_TABLE."` SET `hash`=".$temp." WHERE `business_id`='".$businessID."';"))
				return$this->SUCCESS;
			
			return$this->NOT_FOUND;
			
		}
		
		return $result;
	
	}
	
	public function deleteBusiness($businessID) {
		
		if (!$this->database || $this->database->connect_errno)
			return$this->DB_ERROR;
		
		if ($this->database->query("DELETE FROM `".self::DB_TABLE."` WHERE `busines_id`='".$businessID."';"))
			return$this->SUCCESS;
			
		return$this->NOT_FOUND;
		
	}
	
}

?>