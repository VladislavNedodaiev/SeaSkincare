<?php

namespace SeaSkincare\Backend\Services;

use SeaSkincare\Backend\Services\LogService;
use SeaSkincare\Backend\DTOs\BusinessDTO;
use SeaSkincare\Backend\Services\MailService;
use SeaSkincare\Backend\Communication\Response;

class BusinessService
{

	private $mailService;
	
	private const DB_TABLE = "Business";
	
	public $UNVERIFIED;
	public $EMAIL_REGISTERED;
	public $WRONG_PASSWORD;
	public $EMAIL_UNSENT;
	public $SAME_PASSWORDS;
	
	public function __construct($host, $user, $pswd, $db, $mailService, $logService) {
		
		$this->UNVERIFIED = new Response("UNVERIFIED", null);
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

					$dto = new BusinessDTO;
					
					$dto->id = $res['business_id'];
					$dto->registerDate = $res['register_date'];
					$dto->password = $res['hash'];
					$dto->nickname = $res['nickname'];
					$dto->description = $res['description'];
					$dto->photo = $res['photo'];
					$dto->email = $res['email'];
					$dto->verification = $res['verification'];
					$dto->phoneNumber = $res['phone_number'];
					
					return new Response($this->SUCCESS->status, $dto);
					
				}
				
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
	public function verify($businessID, $verification) {
	
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* From `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`business_id`='".$businessID."' AND `verification`='".$verification."';")) {
			
			if ($this->database->query("UPDATE `".self::DB_TABLE."` SET `verification`=NULL WHERE `business_id`='".$businessID."';"))
				return $this->SUCCESS;
			
			return $this->DB_ERROR;
			
		}
		
		return $this->NOT_FOUND;
	
	}
	
	// getting public data of user by id from database
	public function getBusiness($businessID) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* From `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`business_id`='".$businessID."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$dto = new BusinessDTO;
					
				$dto->id = $res['business_id'];
				$dto->registerDate = $res['register_date'];
				$dto->nickname = $res['nickname'];
				$dto->description = $res['description'];
				$dto->photo = $res['photo'];
				$dto->email = $res['email'];
				$dto->phoneNumber = $res['phone_number'];
				
				return new Response($this->SUCCESS->status, $dto);
				
			}
		}
		
		return $this->NOT_FOUND;
		
	}
	
	// getting businesses from database
	// limit - how many
	// offset - from which entry
	// search must be associative array where key is parameter to apply search pattern and value is pattern string
	public function getBusinesses($offset, $limit, $search = null) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		$selectQuery = "SELECT `".self::DB_TABLE."`.*";
		$whereQuery = " FROM `".self::DB_TABLE."`";
		$likeQuery = "";
		
		if ($search && !empty($search)) {
		
			$likeQuery = " WHERE 1=1";
		
			foreach ($search as $key => &$value) {
			
				$likeQuery .= " AND `".self::DB_TABLE."`.`".$key."`";
				$likeQuery .= " LIKE ";
				$likeQuery .= "'".$value."'";
			
			}
		
		}
		
		$limitQuery = " LIMIT ".$limit;
		$offsetQuery = " OFFSET ".$offset;
		
		$query = $selectQuery.$whereQuery.$likeQuery.$limitQuery.$offsetQuery.";";
		
		if ($result = $this->database->query($query)) {
			
			$businesses = array();
			
			while ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$dto = new BusinessDTO;
					
				$dto->id = $res['business_id'];
				$dto->registerDate = $res['register_date'];
				$dto->nickname = $res['nickname'];
				$dto->description = $res['description'];
				$dto->photo = $res['photo'];
				$dto->email = $res['email'];
				$dto->phoneNumber = $res['phone_number'];
				
				array_push($businesses, $dto);
				
			}
			
			if (!empty($businesses))
				return new Response($this->SUCCESS->status, $businesses);
			
		}
		
		return $this->NOT_FOUND;
		
	}
	
	// search must be associative array where key is parametre to apply search pattern and value is pattern string
	public function getCount($search = null) {
		
		if (!$this->database || $this->database->connect_errno)
			return new Response($this->DB_ERROR->status, 0);
		
		$selectQuery = "SELECT COUNT(`".self::DB_TABLE."`.`business_id`) AS `count`";
		$whereQuery = " FROM `".self::DB_TABLE."`";
		$likeQuery = "";
		
		if ($search && !empty($search)) {
		
			$likeQuery = " WHERE 1=1";
		
			foreach ($search as $key => &$value) {
			
				$likeQuery .= " AND `".self::DB_TABLE."`.`".$key."`";
				$likeQuery .= " LIKE ";
				$likeQuery .= "'".$value."'";
			
			}
		
		}
		
		$query = $selectQuery.$whereQuery.$likeQuery.";";
		
		if ($result = $this->database->query($query)) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				return new Response($this->SUCCESS->status, $res['count']);
				
			}
		}
		
		return new Response($this->NOT_FOUND->status, 0);
		
	}
	
	public function updateBusiness($dto) {
		
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($this->database->query("UPDATE `".self::DB_TABLE."` SET `nickname`='".$dto->nickname."', `description`='".$dto->description."', `photo`='".$dto->photo."', `phone_number`='".$dto->phoneNumber."' WHERE `business_id`='".$dto->id."';"))
			return $this->SUCCESS;
			
		return $this->DB_ERROR;
		
	}
	
	// update password
	public function updatePassword($businessID, $oldPassword, $newPassword) {
	
		if ($oldPassword == $newPassword)
			return $this->SAME_PASSWORDS;
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		$businessResponse = $this->getBusiness($businessID);
		if ($businessResponse->status !=$this->SUCCESS->status)
			return $businessResponse;
		
		$result = $this->login($businessResponse->content->email, $oldPassword);
		
		if ($result->status ==$this->SUCCESS->status) {
			
			$temp = password_hash($newPassword, PASSWORD_BCRYPT);
			if ($mysqli->query("UPDATE `".self::DB_TABLE."` SET `hash`='".$temp."' WHERE `business_id`='".$businessID."';"))
				return $this->SUCCESS;
			
			return $this->NOT_FOUND;
			
		}
		
		return $result;
	
	}
	
	public function deleteBusiness($businessID) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($this->database->query("DELETE FROM `".self::DB_TABLE."` WHERE `busines_id`='".$businessID."';"))
			return $this->SUCCESS;
			
		return $this->NOT_FOUND;
		
	}
	
}

?>