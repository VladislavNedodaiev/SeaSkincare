<?php

namespace SeaSkincare\Backend\Entities;

class Buoy
{
	
	// Data
	private $id;
	private $fabricationDate;
	
	// Relations
	private $subscriptions;
	private $connections;
	
	// GET
	
	public function getID() {
		
		return $this->id;
		
	}
	
	public function getFabricationDate() {
	
		return $this->fabricationDate;
	
	}
	
	public function &getSubscriptions() {
		
		return $this->subscriptions;
		
	}
	
	public function &getConnections() {
	
		return $this->connections;
	
	}
	
	// SET
	
	public function setID($id) {
		
		return $this->id = $id;
		
	}
	
	public function setFabricationDate($fabricationDate) {
	
		return $this->fabricationDate = $fabricationDate;
	
	}
	
	public function &setSubscriptions(&$subscriptions) {
		
		return $this->subscriptions = $subscriptions;
		
	}
	
	public function &setConnections(&$connections) {
	
		return $this->connections = $connections;
	
	}
	
}

?>