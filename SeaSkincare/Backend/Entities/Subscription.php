<?php

namespace SeaSkincare\Backend\Entities;

class Subscription
{
	
	private $id;
	private $buoyID;
	private $businessID;
	private $startDate;
	private $finishDate;
	
	// GET
	
	public function getID() {
		
		return $this->id;
		
	}
	
	public function getBuoyID() {
		
		return $this->buoyID;
		
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
	
	public function setBuoyID($buoyID) {
		
		return $this->buoyID = $buoyID;
		
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