<?php

namespace SeaSkincare\Backend\Controllers;

use SeaSkincare\Backend\Data\DataRepository;
use SeaSkincare\Backend\Services\MailService;
use SeaSkincare\Backend\Entities\User;
use SeaSkincare\Backend\DTOs\UserDTO;
use SeaSkincare\Backend\Mappers\UserMapper;
use SeaSkincare\Backend\Services\UserService;
use SeaSkincare\Backend\Communication\Response;

class UserController
{
	
	private $dataRep;
	private $mailService;
	private $userService;
	
	public const NO_EMAIL = new Response("NO_EMAIL", null);
	
	
	public function __construct() {
	
		$this->dataRep = new DataRepository;

		$this->mailService = new MailService($_SERVER['HTTP_HOST']);

		$this->userService = new UserService(

			$this->dataRep->getHost(),
			$this->dataRep->getUser(),
			$this->dataRep->getPassword(),
			$this->dataRep->getDatabase(),
			$this->mailService;

		);
	
	}
	
	public function login($email, $password) {
		
		if (!isset($email))
			return new self::NO_EMAIL;
	
	http_response_code(400);
	echo json_encode(new Response("NO_EMAIL", null));
	exit;
	
}

if (!isset($_POST['password'])) {
	
	http_response_code(400);
	echo json_encode(new Response("NO_PASSWORD", null));
	exit;
	
}
		
	}
	
	// registering user
	public function register($email, $password, $nickname) {
		
		if (!$this->database || $this->database->connect_errno)
			return new Response(self::DB_ERROR, null);
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`email`='".$email."' OR `".self::DB_TABLE."`.`nickname`='".$nickname."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				if ($email == $res['email'])
					return new Response(self::EMAIL_REGISTERED, null);
				else
					return new Response(self::NICKNAME_REGISTERED, null);
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
				return new Response(self::SUCCESS, null);
				
			} else {
				$this->database->query("ROLLBACK TO reg_".$nickname.";");
				$this->database->query("COMMIT;");
				
				return new Response(self::EMAIL_UNSENT, null);
			}
			
		}
		
		return new Response(self::DB_ERROR, null);
		
	}
	
	// verifying user
	public function verify($userID, $verification) {
	
		if (!$this->database || $this->database->connect_errno)
			return new Response(self::DB_ERROR, null);
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* From `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`user_id`='".$userID."' AND `verification`='".$verification."';")) {
			
			if ($this->database->query("UPDATE `".self::DB_TABLE."` SET `verification`=NULL WHERE `user_id`='".$userID."';"))
				return new Response(self::SUCCESS, null);
			
			return new Response(self::DB_ERROR, null);
			
		}
		
		return new Response(self::NOT_FOUND, null);
	
	}
	
	// getting public data of user by id from database
	public function getUser($userID) {
		
		if (!$this->database || $this->database->connect_errno)
			return new Response(self::DB_ERROR, null);
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* From `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`user_id`='".$userID."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				
				$dto = new UserDTO;
					
				$dto->ID = $res['user_id'];
				$dto->nickname = $res['nickname'];
				$dto->email = $res['email'];
				
				return new Response(self::SUCCESS, UserMapper::DTOToEntity($dto));
				
			}
		}
		
		return new Response(self::NOT_FOUND, null);
		
	}
	
	public function updateUser($dto) {
		
		
		if (!$this->database || $this->database->connect_errno)
			return new Response(self::DB_ERROR, null);
		
		if ($this->database->query("UPDATE `".self::DB_TABLE."` SET `nickname`=".$dto->nickname.", `email`=".$dto->email." WHERE `user_id`='".$dto->id."';"))
			return new Response(self::SUCCESS, null);
			
		return new Response(self::DB_ERROR, null);
		
	}
	
	// update password
	public function updatePassword($userID, $oldPassword, $newPassword) {
	
		if ($oldPassword == $newPassword)
			return new Response(self::SUCCESS, null);
		
		if (!$this->database || $this->database->connect_errno)
			return new Response(self::DB_ERROR, null);
		
		$userResponse = $this->getUser($userID);
		if ($userResponse->status != self::SUCCESS)
			return $userResponse;
		
		$result = $this->login($userResponse->content->email, $oldPassword);
		
		if ($result->status == self::SUCCESS) {
			
			$temp = password_hash($newPassword, PASSWORD_BCRYPT);
			if ($mysqli->query("UPDATE `".self::DB_TABLE."` SET `hash`=".$temp." WHERE `business_id`='".$userID."';")) {
				
				return new Response(self::SUCCESS, null);
			
			}
			
			return new Response(self::DB_ERROR, null);
			
		}
		
		return $result;
	
	}
	
	public function deleteUser($userID)
	{
		
		if (!$this->database || $this->database->connect_errno)
			return new Response(self::DB_ERROR, null);
		
		if ($this->database->query("DELETE FROM `".self::DB_TABLE."` WHERE `user_id`='".$userID."';"))
			return new Response(self::SUCCESS, null);
			
		return new Response(self::DB_ERROR, null);
		
	}
	
}

?>