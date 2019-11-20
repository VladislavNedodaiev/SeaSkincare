<?php

namespace SeaSkincare\Backend\Entities;

class Buoy
{
	
	private $id;
	private $fabricationDate;
	
	public $subscriptions;
	public $connections;
	
	// GET
	
	public function getID() {
		
		return $this->id;
		
	}
	
	public function getFabricationDate() {
	
		return $this->fabricationDate;
	
	}
	
	// SET
	
	public function setID($id) {
		
		return $this->id = $id;
		
	}
	
	public function setFabricationDate($fabricationDate) {
	
		return $this->fabricationDate = $fabricationDate;
	
	}
	
}

?>