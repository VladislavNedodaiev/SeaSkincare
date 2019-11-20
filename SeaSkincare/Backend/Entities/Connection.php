<?php

namespace SeaSkincare\Backend\Entities;

class Connection
{
	
	// Data
	private $id;
	private $buoyID;
	private $connectionDate;
	private $latitude;
	private $longitude;
	private $battery;
	
	// Relations
	private $air;
	private $water;
	private $weather;
	
	// GET
	
	public function getID() {
		
		return $this->id;
		
	}
	
	public function getBuoyID() {
	
		return $this->buoyID;
	
	}
	
	public function getConnectionDate() {
		
		return $this->connectionDate;
		
	}
	
	public function getLatitude() {
		
		return $this->latitude;
		
	}
	
	public function getLongitude() {
		
		return $this->longitude;
		
	}
	
	public function getBattery() {
		
		return $this->battery;
		
	}
	
	public function &getAir() {
		
		return $this->air;
		
	}
	
	public function &getWater() {
		
		return $this->water;
		
	}
	
	public function &getWeather() {
		
		return $this->weather;
		
	}
	
	// SET
	
	public function setID($id) {
		
		return $this->id = $id;
		
	}
	
	public function setBuoyID($buoyID) {
	
		return $this->buoyID = $buoyID;
	
	}
	
	public function setConnectionDate($connectionDate) {
		
		return $this->connectionDate = $connectionDate;
		
	}
	
	public function setLatitude($latitude) {
		
		return $this->latitude = $latitude;
		
	}
	
	public function setLongitude($longitude) {
		
		return $this->longitude = $longitude;
		
	}
	
	public function setBattery($battery) {
		
		return $this->battery = $battery;
		
	}
	
	public function &setAir(&$air) {
		
		return $this->air = $air;
		
	}
	
	public function &setWater(&$water) {
		
		return $this->water = $water;
		
	}
	
	public function &setWeather(&$weather) {
		
		return $this->weather = $weather;
		
	}
	
}

?>