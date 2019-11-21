<?php

namespace SeaSkincare\Backend\Entities;

class User
{
	
	// Data
	private $id;
	private $password;
	private $nickname;
	private $email;
	private $verification;
	
	// Relations
	private $userProblems;
	private $vacations;
	
	// GET
	
	public function getID() {
		
		return $this->id;
		
	}
	
	public function getPassword() {
	
		return $this->password;
	
	}
	
	public function getNickname() {
		
		return $this->nickname;
		
	}
	
	public function getEmail() {
		
		return $this->email;
		
	}
	
	public function getVerification() {
		
		return $this->verification;
		
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
	
	public function setPassword($password) {
	
		return $this->password = $password;
	
	}
	
	public function setNickname($nickname) {
		
		return $this->nickname = $nickname;
		
	}
	
	public function setEmail($email) {
		
		return $this->email = $email;
		
	}
	
	public function setVerification($verification) {
		
		return $this->verification = $verification;
		
	}
	
	public function &setUserProblems(&$userProblems) {
		
		return $this->userProblems = $this->userProblems;
		
	}
	
	public function &setVacations(&$vacations) {
		
		return $this->vacations = $this->vacations;
		
	}
	
}

?>