<?php

namespace SeaSkincare\Backend\Controllers;

use SeaSkincare\Backend\Services\LogService;
use SeaSkincare\Backend\Data\DataRepository;
use SeaSkincare\Backend\Communication\Response;

class Controller
{
	
	protected $dataRep;
	protected $logService;
	
	public function __construct() {
		
		$this->dataRep = new DataRepository;
		$this->logService = new LogService;
		
	}
	
	protected function logResponse($response) {
	
		$this->logService->logResponse($response);
	
		return $response;
	
	}
	
}

?>