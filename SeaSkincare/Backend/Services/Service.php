<?php

namespace SeaSkincare\Backend\Services;

use SeaSkincare\Backend\Services\LogService;
use SeaSkincare\Backend\Communication\Response;

class Service
{
	
	protected $database;
	protected $logService;
	
	public $NOT_FOUND;
	public $SUCCESS;
	public $DB_ERROR;
	
	public function __construct($host, $user, $pswd, $db, $logService) {
		
		$this->NOT_FOUND = new Response("NOT_FOUND", null);
		$this->SUCCESS = new Response("SUCCESS", null);
		$this->DB_ERROR = new Response("DB_ERROR", null);
		
		$this->logService = $logService;
	
		$this->connectToDB($host, $user, $pswd, $db);
	
	}
	
	protected function connectToDB($host, $user, $pswd, $db) {

		$this->database = new \mysqli($host, $user, $pswd, $db);

		if ($this->database->connect_errno) {
			return $this->DB_ERROR;
		}

		$this->database->set_charset('utf8');

		return new Response($this->SUCCESS->status, $this->database);
		
	}
	
}

?>