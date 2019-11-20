<?php

namespace SeaSkincare\Backend\Entities;

class UserProblem
{
	
	private $id;
	private $userID;
	private $skinProblemID;
	
	// GET
	
	public function getID() {
		
		return $this->id;
		
	}
	
	public function getUserID() {
		
		return $this->userID;
		
	}
	
	public function getSkinProblemID() {
		
		return $this->skinProblemID;
		
	}
	
	// SET
	
	public function setID($id) {
		
		return $this->id = $id;
		
	}
	
	public function setUserID($userID) {
		
		return $this->userID = $userID;
		
	}
	
	public function setSkinProblemID($skinProblemID) {
		
		return $this->skinProblemID = $skinProblemID;
		
	}
	
}

?>