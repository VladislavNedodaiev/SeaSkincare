<?php

namespace SeaSkincare\Backend\Entities;

class Vacation
{
	
	// Data
	private $id;
	private $userID;
	private $businessID;
	private $startDate;
	private $finishDate;
	
	// GET
	
	public function getID() {
		
		return $this->id;
		
	}
	
	public function getUserID() {
		
		return $this->userID;
		
	}
	
	public function getBusinessID() {
		
		return $this->businessID;
		
	}
	
	public function getStartDate() {
		
		return $this->startDate;
		
	}
	
	public function getFinishDate() {
		
		return $this->finishDate;
		
	}
	
	// SET
	
	public function setID($id) {
		
		return $this->id = $id;
		
	}
	
	public function setUserID($userID) {
		
		return $this->userID = $userID;
		
	}
	
	public function setBusinessID($businessID) {
		
		return $this->businessID = $businessID;
		
	}
	
	public function setStartDate($startDate) {
		
		return $this->startDate = $startDate;
		
	}
	
	public function setFinishDate($finishDate) {
		
		return $this->finishDate = $finishDate;
		
	}
	
}

?>