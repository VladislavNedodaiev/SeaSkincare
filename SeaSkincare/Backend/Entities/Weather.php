<?php

namespace SeaSkincare\Backend\Entities;

class Weather
{
	
	// Data
	private $id;
	private $sunPower;
	private $windSpeed;
	
	// GET
	
	public function getID() {
		
		return $this->id;
		
	}
	
	public function getSunPower() {
		
		return $this->sunPower;
		
	}
	
	public function getWindSpeed() {
		
		return $this->windSpeed;
		
	}
	
	// SET
	
	public function setID($id) {
		
		return $this->id = $id;
		
	}
	
	public function setSunPower($sunPower) {
		
		return $this->sunPower = $sunPower;
		
	}
	
	public function setWindSpeed($windSpeed) {
		
		return $this->windSpeed = $windSpeed;
		
	}
	
}

?>