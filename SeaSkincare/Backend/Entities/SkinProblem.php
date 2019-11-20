<?php

namespace SeaSkincare\Backend\Entities;

class SkinProblem
{
	
	private $id;
	private $title;
	private $normalPH;
	private $normalSalt;
	private $normalAirPollution;
	private $normalSunPower;
	
	public $userProblems;
	
	// GET
	
	public function getID() {
		
		return $this->id;
		
	}
	
	public function getTitle() {
	
		return $this->title;
	
	}
	
	public function getNormalPH() {
		
		return $this->nickname;
		
	}
	
	public function getNormalSalt() {
		
		return $this->normalSalt;
		
	}
	
	public function getNormalAirPollution() {
		
		return $this->normalAirPollution;
		
	}
	
	public function getNormalSunPower() {
		
		return $this->normalSunPower;
		
	}
	
	// SET
	
	public function setID($id) {
		
		return $this->id = $id;
		
	}
	
	public function setTitle($title) {
	
		return $this->title = $title;
	
	}
	
	public function setNormalPH($normalPH) {
		
		return $this->normalPH = $normalPH;
		
	}
	
	public function setNormalSalt($normalSalt) {
		
		return $this->normalSalt = $normalSalt;
		
	}
	
	public function setNormalAirPollution($normalAirPollution) {
		
		return $this->normalAirPollution = $normalAirPollution;
		
	}
	
	public function setNormalSunPower($normalSunPower) {
		
		return $this->normalSunPower = $normalSunPower;
		
	}
	
}

?>