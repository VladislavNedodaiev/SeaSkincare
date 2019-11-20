<?php

namespace SeaSkincare\Backend\Entities;

class Air
{
	
	// Data
	private $id;
	private $temperature;
	private $pollution;
	
	// GET
	
	public function getID() {
		
		return $this->id;
		
	}
	
	public function getTemperature() {
		
		return $this->temperature;
		
	}
	
	public function getPollution() {
		
		return $this->pollution;
		
	}
	
	// SET
	
	public function setID($id) {
		
		return $this->id = $id;
		
	}
	
	public function setTemperature($temperature) {
		
		return $this->temperature = $temperature;
		
	}
	
	public function setPollution($pollution) {
		
		return $this->pollution = $pollution;
		
	}
	
}

?>