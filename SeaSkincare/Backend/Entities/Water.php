<?php

namespace SeaSkincare\Backend\Entities;

class Water
{
	
	// Data
	private $id;
	private $temperature;
	private $pH;
	private $NaCl;
	private $MgCl2;
	private $MgSO4;
	private $CaSO4;
	private $NaBr;
	
	// GET
	
	public function getID() {
		
		return $this->id;
		
	}
	
	public function getTemperature() {
		
		return $this->temperature;
		
	}
	
	public function getPH() {
		
		return $this->pH;
		
	}
	
	public function getNaCl() {
		
		return $this->NaCl;
		
	}
	
	public function getMgCl2() {
		
		return $this->MgCl2;
		
	}
	
	public function getMgSO4() {
		
		return $this->MgSO4;
		
	}
	
	public function getCaSO4() {
		
		return $this->CaSO4;
		
	}
	
	public function getNaBr() {
		
		return $this->NaBr;
		
	}
	
	// SET
	
	public function setID($id) {
		
		return $this->id = $id;
		
	}
	
	public function setTemperature($temperature) {
		
		return $this->temperature = $temperature;
		
	}
	
	public function setPH() {
		
		return $this->pH;
		
	}
	
	public function setNaCl($NaCl) {
		
		return $this->NaCl = $NaCl;
		
	}
	
	public function setMgCl2($MgCl2) {
		
		return $this->MgCl2 = $MgCl2;
		
	}
	
	public function setMgSO4($MgSO4) {
		
		return $this->MgSO4 = $MgSO4;
		
	}
	
	public function setCaSO4($CaSO4) {
		
		return $this->CaSO4 = $CaSO4;
		
	}
	
	public function setNaBr($NaBr) {
		
		return $this->NaBr = $NaBr;
		
	}
	
}

?>