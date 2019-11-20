<?php

namespace SeaSkincare\Backend\Entities;

class User
{
	
	// Data
	private $id;
	private $passwordHash;
	private $nickname;
	private $email;
	private $verificationHash;
	
	// Relations
	private $userProblems;
	private $vacations;
	
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
	
	public function &getUserProblems() {
		
		return $this->userProblems;
		
	}
	
	public function &getVacations() {
		
		return $this->vacations;
		
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
	
	public function &setUserProblems(&$userProblems) {
		
		return $this->userProblems = $this->userProblems;
		
	}
	
	public function &setVacations(&$vacations) {
		
		return $this->vacations = $this->vacations;
		
	}
	
}

?>