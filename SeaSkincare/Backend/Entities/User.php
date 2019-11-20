<?php

namespace SeaSkincare\Backend\Entities;

class User {
	
	private $user_id;
	private $password;
	private $nickname;
	private $email;
	private $verification
	
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