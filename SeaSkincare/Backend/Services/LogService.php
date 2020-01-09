<?php

namespace SeaSkincare\Backend\Services;
use SeaSkincare\Backend\Communication\Response;

class LogService
{
	
	public $loggerPath;
	
	public $SUCCESS;
	public $LOG_ERROR;
	
	public function __construct() {
		
		$this->SUCCESS = new Response("SUCCESS", null);
		$this->LOG_ERROR = new Response("LOG_ERROR", null);
		
		$this->loggerPath = "log.txt";
	
	}
	
	// print message
	public function logMessage($message) {
		
		if (file_put_contents($loggerPath, date('d.m.Y H:i:s ').$message.PHP_EOL, FILE_APPEND))
			return $SUCCESS;
		
		return $LOG_ERROR;
		
	}
	
	// print response
	public function logResponse($response) {
	
		if (file_put_contents($loggerPath, date('d.m.Y H:i:s ').json_encode($response).PHP_EOL, FILE_APPEND))
			return $SUCCESS;
		
		return $LOG_ERROR;
	
	}
	
}

?>