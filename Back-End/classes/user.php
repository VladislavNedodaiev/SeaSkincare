<?php

class user {
	
	public $user_id;
	public $nickname;
	public $email;
	
	public const UNVERIFIED = "UNVERIFIED_USER";
	public const NO_USER = "NO_USER";
	public const EMAIL_REGISTERED = "EMAIL_REGISTERED";
	public const NICKNAME_REGISTERED = "NICKNAME_REGISTERED";
	
	public const SUCCESS = "SUCCESS";
	public const DB_ERROR = "DB_ERROR";
	public const EMAIL_UNSENT = "EMAIL_UNSENT";
	
	// logging in (getting private data, such as email)
	public function login($email, $password) {
		
		require "env.php";
		$mysqli = include DB_CONNECT;
		
		if (!$mysqli)
			return self::DB_ERROR;
		
		if ($result = $mysqli->query("SELECT `user`.* FROM `user` WHERE `user`.`email`='".$email."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				if (!$res['verification'])
					return self::UNVERIFIED;
				if (password_verify($password, $res['hash'])) {

					$this->logout();
					
					$this->user_id = $res['user_id'];
					$this->nickname = $res['nickname'];
					$this->email = $res['email'];
					
					return self::SUCCESS;
					
				}
			}
		}
		
		return self::NO_USER;
		
	}
	
	// logging out / making object empty
	public function logout() {
	
		$user_id = $nickname = $email = null;
	
	}
	
	// registering user
	public function register($email, $password, $nickname) {
		
		require "env.php";
		$mysqli = include DB_CONNECT;
		
		if (!$mysqli)
			return self::DB_ERROR;
		
		if ($result = $mysqli->query("SELECT `user`.* FROM `user` WHERE `user`.`email`='".$email."' OR `user`.`nickname`='".$nickname."';")) {
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
		
		if ($mysqli->query("INSERT INTO `user`(`hash`, `nickname`, `email`, `verification`)".
						   "VALUES (".
						   "'".password_hash($password, PASSWORD_BCRYPT)."',".
						   "'".$nickname."', ".
						   "'".$email."', ".
						   "'".$verification."');")) {
			
			if ($this->sendVerificationEmail(HOST, $email, $verification)) {
				
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
	private function sendVerificationEmail($verify_host, $email, $verification) {
		
		$subject = 'Registration | Verification';
		$message = '
		 
			Дякуємо за реєстрацію!
			Ваш акаунт було створено, після активації Ви зможете увійти використовуючи наступні дані:
			
			 
			Активація акаунту:
			'.HOST.'/verify.php?email='.$email.'&verification='.$verification.'
		 
		';
		
		mail($email, $subject, $message);
		
	}
	
	// verifying user
	public function verify($verification) {
	
	}fgh
	
	// getting public data of user by id
	public function getUser($user_id) {
		
		require "env.php";
		$mysqli = include DB_CONNECT;
		
		if (!$mysqli)
			return self::DB_ERROR;
		
		if ($result = $mysqli->query("SELECT `user`.* FROM `user` WHERE `user`.`user_id`='".$user_id."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$this->logout();
				
				$this->user_id = $res['user_id'];
				$this->nickname = $res['nickname'];
				
				return self::SUCCESS;
				
			}
		}
		
		return self::NO_USER;
		
	}
	
	public function editPassword($password) {
	}
	
	public function editNickname($nickname) {
	}
	
	public function editEmail($email) {
	}
	
	// reloads the account from database
	function reload_db() {
		
		require "templates/connect_db.php";
		if ($mysqli->connect_errno) {
			return false;
		}
		
		if ($result = $mysqli->query("SELECT `account`.* FROM `account` WHERE `account`.`account_id`=".$this->account_id." AND `account`.`verified`=1;")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				$this->set_from_qresult($res);
				return true;
			}
		}
		
		return false;
	}
	
	// updates the database 
	function update_db() {
		
		require "templates/connect_db.php";
		if ($mysqli->connect_errno) {
			return false;
		}
		
		if ($this->birthday!="") {
			if ($mysqli->query("UPDATE `account` SET "
							   ."`avatar`='".$this->avatar."', "
							   ."`first_name`='".$this->first_name."', "
							   ."`second_name`='".$this->second_name."', "
							   ."`patronymic`='".$this->patronymic."', "
							   ."`gender`='".$this->gender."', "
							   ."`biography`='".$this->biography."', "
							   ."`phone`='".$this->phone."', "
							   ."`birthday`=STR_TO_DATE('".$this->birthday."', '%Y-%m-%d') "
							   ."WHERE `account_id`=".$this->account_id.";")) {
				return true;
			}
		}
		else if ($mysqli->query("UPDATE `account` SET "
							   ."`avatar`='".$this->avatar."', "
							   ."`first_name`='".$this->first_name."', "
							   ."`second_name`='".$this->second_name."', "
							   ."`patronymic`='".$this->patronymic."', "
							   ."`gender`='".$this->gender."', "
							   ."`biography`='".$this->biography."', "
							   ."`phone`='".$this->phone."' "
							   ."WHERE `account_id`=".$this->account_id.";")) {
			return true;
		}
		
		return false;
	}
	
	// returns the full name
	function get_name() {
		return 
			$this->first_name.
			" ".
			$this->second_name.
			" ".
			$this->patronymic;
	}
	
}

?>