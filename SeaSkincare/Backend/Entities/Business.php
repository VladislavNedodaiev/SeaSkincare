<?php

namespace SeaSkincare\Backend\Entities;

class Business
{
	
	// Data
	private $id;
	private $passwordHash;
	private $nickname;
	private $description;
	private $photo;
	private $email;
	private $verificationHash;
	
	// Relations
	private $vacations;
	private $subscriptions;
	
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
	
	public function getDescription() {
		
		return $this->description;
		
	}
	
	public function getPhoto() {
		
		return $this->photo;
		
	}
	
	public function getEmail() {
		
		return $this->email;
		
	}
	
	public function getVerificationHash() {
		
		return $this->verificationHash;
		
	}
	
	public function &getSubscriptions() {
		
		return $this->subscriptions;
		
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
	
	public function setDescription($description) {
		
		return $this->description = $description;
		
	}
	
	public function setPhoto($photo) {
		
		return $this->photo = $photo;
		
	}
	
	public function setEmail($email) {
		
		return $this->email = $email;
		
	}
	
	public function setVerificationHash($verificationHash) {
		
		return $this->verificationHash = $verificationHash;
		
	}
	
	public function &setSubscriptions(&$subscriptions) {
		
		return $this->subscriptions = $this->subscriptions;
		
	}
	
	public function &setVacations(&$vacations) {
		
		return $this->vacations = $this->vacations;
		
	}
	
}

?>