<?php

class user {
	
	var $account_id;
	var $login;
	var $email;
	var $avatar;
	var $first_name;
	var $second_name;
	var $patronymic;
	var $gender;
	var $biography;
	var $phone;
	var $birthday;
	var $register_date;
	
	
	// constructor
	function __construct($res) {
		$this->set_from_qresult($res);
	}
	
	// set from query result
	function set_from_qresult($res) {
		
		$this->account_id = $res['account_id'];
		$this->login = $res['login'];
		$this->email = $res['email'];
		$this->avatar = $res['avatar'];
		$this->first_name = $res['first_name'];
		$this->second_name = $res['second_name'];
		$this->patronymic = $res['patronymic'];
		$this->gender = $res['gender'];
		$this->biography = $res['biography'];
		$this->phone = $res['phone'];
		$this->birthday = $res['birthday'];
		$this->register_date = $res['register_date'];
		
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