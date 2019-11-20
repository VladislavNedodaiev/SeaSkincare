<?php

class user {
	
	private $user_id;
	private $password;
	private $nickname;
	private $email;
	
	private const DB_TABLE = "User";
	
	public const UNVERIFIED = "UNVERIFIED_USER";
	public const NO_USER = "NO_USER";
	public const EMAIL_REGISTERED = "EMAIL_REGISTERED";
	public const NICKNAME_REGISTERED = "NICKNAME_REGISTERED";
	public const WRONG_PASSWORD = "WRONG_PASSWORD";
	
	public const SUCCESS = "SUCCESS";
	public const DB_ERROR = "DB_ERROR";
	public const EMAIL_UNSENT = "EMAIL_UNSENT";
	
	// logging in (getting private data, such as email)
	public function login($email, $password) {
		
		require "env.php";
		$mysqli = include DB_CONNECT;
		
		if (!$mysqli)
			return self::DB_ERROR;
		
		if ($result = $mysqli->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`email`='".$email."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				if (!$res['verification'])
					return self::UNVERIFIED;
				if (password_verify($password, $res['hash'])) {

					$this->logout();
					
					$this->user_id = $res['user_id'];
					$this->password = $res['hash']; 
					$this->nickname = $res['nickname'];
					$this->email = $res['email'];
					
					return self::SUCCESS;
					
				}
				else
					return self::WRONG_PASSWORD;
			}
		}
		
		return self::NO_USER;
		
	}
	
	// logging out / making object empty
	public function logout() {
	
		$user_id = $password = $nickname = $email = null;
	
	}
	
	// registering user
	public function register($email, $password, $nickname) {
		
		require "env.php";
		$mysqli = include DB_CONNECT;
		
		if (!$mysqli)
			return self::DB_ERROR;
		
		if ($result = $mysqli->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`email`='".$email."' OR `".self::DB_TABLE."`.`nickname`='".$nickname."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				if ($email == $res['email'])
					return self::EMAIL_REGISTERED;
				else
					return self::NICKNAME_REGISTERED;
			}
		}
		
		// generating verification hash
		$verification = md5(rand(0, 10000));
		
		$mysqli->query("START TRANSACTION;");
		$mysqli->query("SAVEPOINT reg_".$nickname.";");
		
		if ($mysqli->query("INSERT INTO `".self::DB_TABLE."`(`hash`, `nickname`, `email`, `verification`)".
						   "VALUES (".
						   "'".password_hash($password, PASSWORD_BCRYPT)."',".
						   "'".$nickname."', ".
						   "'".$email."', ".
						   "'".$verification."');")) {
			
			if ($this->sendVerificationEmail(HOST.'/verify_user.php', $email, $verification)) {
				
				$mysqli->query("COMMIT;");
				return self::SUCCESS;
				
			} else {
				$mysqli->query("ROLLBACK TO reg_".$nickname.";");
				$mysqli->query("COMMIT;");
				
				return self::EMAIL_UNSENT;
			}
			
		}
		
		return self::DB_ERROR;
		
	}
	
	// sending email with verification address
	private function sendVerificationEmail($verify_http, $email, $verification) {
		
		$subject = 'Registration | Verification';
		$message = '
		 
			Дякуємо за реєстрацію!
			Ваш акаунт було створено, після активації Ви зможете увійти використовуючи наступні дані:
			
			 
			Активація акаунту:
			'.$verify_http.'?email='.$email.'&verification='.$verification.'
		 
		';
		
		mail($email, $subject, $message);
		
	}
	
	// verifying user
	public static function verify($email, $verification) {
	
		require "env.php";
		$mysqli = include DB_CONNECT;
		
		if (!$mysqli)
			return self::DB_ERROR;
		
		if ($result = $mysqli->query("SELECT `".self::DB_TABLE."`.* From `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`email`='".$email."' AND `verification`='".$verification."';")) {
			
			if ($mysqli->query("UPDATE `".self::DB_TABLE."` SET `verification`=NULL WHERE `email`='".$email."';"))
				return self::SUCCESS;
			
			return self::DB_ERROR;
			
		}
		
		return self::NO_USER;
	
	}
	
	// getting public data of user by id from database
	public function getUser($user_id) {
		
		require "env.php";
		$mysqli = include DB_CONNECT;
		
		if (!$mysqli)
			return self::DB_ERROR;
		
		if ($result = $mysqli->query("SELECT `".self::DB_TABLE."`.* From `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`user_id`='".$user_id."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$this->logout();
				
				$this->user_id = $res['user_id'];
				$this->nickname = $res['nickname'];
				
				return self::SUCCESS;
				
			}
		}
		
		return self::NO_USER;
		
	}
	
	public function setPassword($old_password, $new_password) {
		
		if ($old_password == $new_password)
			return self::SUCCESS;
		
		require "env.php";
		$mysqli = include DB_CONNECT;
		
		if (!$mysqli)
			return self::DB_ERROR;
		
		$result = $this->login($this->email, $old_password);
		
		if ($result == self::SUCCESS) {
			
			$temp = password_hash($new_password, PASSWORD_BCRYPT);
			if ($mysqli->query("UPDATE `".self::DB_TABLE."` SET `hash`=".$temp." WHERE `email`='".$this->email."';")) {
				
				$this->password=$temp;
				
				return self::SUCCESS;
			
			}
			
			return self::DB_ERROR;
			
		}
		
		return $result;
		
	}
	
	public function setNickname($nickname) {
		
		if ($nickname == $this->nickname)
			return self::SUCCESS;
		
		require "env.php";
		$mysqli = include DB_CONNECT;
		
		if (!$mysqli)
			return self::DB_ERROR;
		
		$result = $this->login($this->email, $this->password);
		
		if ($result == self::SUCCESS) {
			
			if ($mysqli->query("UPDATE `".self::DB_TABLE."` SET `hash`=".$nickname." WHERE `email`='".$this->email."';")) {
				
				$this->nickname=$nickname;
				
				return self::SUCCESS;
			
			}
			
			return self::DB_ERROR;
			
		}
		
		return $result;
		
	}
	
	public function setEmail($email) {
		
		if ($nickname == $this->nickname)
			return self::SUCCESS;
		
		require "env.php";
		$mysqli = include DB_CONNECT;
		
		if (!$mysqli)
			return self::DB_ERROR;
		
		$result = $this->login($this->email, $this->password);
		
		if ($result == self::SUCCESS) {
			
			// generating verification hash
			$verification = md5(rand(0, 10000));
			
			$mysqli->query("START TRANSACTION;");
			$mysqli->query("SAVEPOINT editEmail_".$nickname.";");
			
			if ($mysqli->query("UPDATE `".self::DB_TABLE."` SET `email`=".$email." WHERE `email`='".$this->email."';")) {
				
				if ($this->sendVerificationEmail(HOST, $email, $verification)) {
				
					$mysqli->query("COMMIT;");
					
					$this->email = $email;
					
					return self::SUCCESS;
					
				} else {
					
					$mysqli->query("ROLLBACK TO editEmail_".$nickname.";");
					$mysqli->query("COMMIT;");
					
					return self::EMAIL_UNSENT;
				}
			
			}
			
			return self::DB_ERROR;
			
		}
		
		return $result;
		
	}
	
	public function getUserID() {
		
		return $this->user_id;
		
	}
	
	public function getNickname() {
		
		return $this->nickname;
		
	}
	
	public function getEmail() {
		
		return $this->email;
		
	}
	
}

?>