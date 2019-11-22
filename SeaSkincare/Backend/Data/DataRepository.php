<?php

namespace SeaSkincare\Backend\Data;

class DataRepository
{
	
	private $host;
	private $user;
	private $pswd;
	private $db;
	
	public function __construct() {
	
		$this->host = "remotemysql.com";
		$this->user = "R7JP0RE8Az";
		$this->pswd = "NGM3yBPkZR";
		$this->db = "R7JP0RE8Az";
	
	}
	
	// GET
	
	public function getHost() {
		
		return $this->host;
		
	}
	
	public function getUser() {
	
		return $this->user;
	
	}
	
	public function getPassword() {
		
		return $this->pswd;
		
	}
	
	public function getDatabase() {
		
		return $this->db;
		
	}
	
}

?>