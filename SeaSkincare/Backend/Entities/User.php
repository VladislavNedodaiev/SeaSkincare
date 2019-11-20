<?php

namespace SeaSkincare\Backend\Entities;

class User
{
	
	private $id;
	private $passwordHash;
	private $nickname;
	private $email;
	private $verificationHash;
	
	public $userProblems;
	public $vacations;
	
	// GET
	
	public function getID() {
		
		return $this->id;
		
	}
	
	public function getPasswordHash() {
	
		return $this->passwordHash;
	
	}
	
	public function getNickname() {
		
		return $this->nickname;
		
	}
	
	public function getEmail() {
		
		return $this->email;
		
	}
	
	public function getVerificationHash() {
		
		return $this->verificationHash;
		
	}
	
	// SET
	
	public function setID($id) {
		
		return $this->id = $id;
		
	}
	
	public function setPasswordHash($passwordHash) {
	
		return $this->passwordHash = $passwordHash;
	
	}
	
	public function setNickname($nickname) {
		
		return $this->nickname = $nickname;
		
	}
	
	public function setEmail($email) {
		
		return $this->email = $email;
		
	}
	
	public function setVerificationHash($verificationHash) {
		
		return $this->verificationHash = $verificationHash;
		
	}
	
}

?>