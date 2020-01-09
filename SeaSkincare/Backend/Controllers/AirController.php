<?php

namespace SeaSkincare\Backend\Controllers;

use SeaSkincare\Backend\Controllers\Controller;
use SeaSkincare\Backend\Services\LogService;
use SeaSkincare\Backend\Data\DataRepository;
use SeaSkincare\Backend\DTOs\AirDTO;
use SeaSkincare\Backend\Services\AirService;
use SeaSkincare\Backend\Communication\Response;

class AirController extends Controller
{
	
	private $airService;
	
	public $SUCCESS;
	public $NO_CONNECTIONID;
	public $NO_TEMPERATURE;
	public $NO_POLLUTION;
	
	
	public function __construct() {
	
		parent::__construct();
	
		$this->SUCCESS = new Response("SUCCESS", null);
		$this->NO_CONNECTIONID = new Response("NO_CONNECTIONID", null);
		$this->NO_TEMPERATURE = new Response("NO_TEMPERATURE", null);
		$this->NO_POLLUTION = new Response("NO_POLLUTION", null);

		$this->airService = new AirService(

			$this->dataRep->getHost(),
			$this->dataRep->getUser(),
			$this->dataRep->getPassword(),
			$this->dataRep->getDatabase(),
			$this->logService

		);
	
	}
	
	public function createAir($connectionID, $temperature, $pollution) {
		
		$this->logService->logMessage("AirController CreateAir");
		
		if (!isset($connectionID))
			return $this->logResponse($this->NO_CONNECTIONID);
		
		if (!isset($temperature))
			return $this->logResponse($this->NO_TEMPERATURE);
		
		if (!isset($pollution))
			return $this->logResponse($this->NO_POLLUTION);
		
		$dto = new AirDTO;
		$dto->id = $connectionID;
		$dto->temperature = $temperature;
		$dto->pollution = $pollution;
		
		return $this->logResponse($this->airService->createAir($dto));
		
	}
	
	public function getAir($airID) {
		
		$this->logService->logMessage("AirController GetAir");
		
		if (!isset($airID))
			return $this->logResponse($this->NO_CONNECTIONID);
		
		return $this->logResponse($this->airService->getAir($airID));
		
	}
	
	public function editAir($connectionID, $temperature, $pollution) {
	
		$this->logService->logMessage("AirController EditAir");
	
		if (!isset($connectionID))
			return $this->logResponse($this->NO_CONNECTIONID);
		
		if (!isset($temperature))
			return $this->logResponse($this->NO_TEMPERATURE);
		
		if (!isset($pollution))
			return $this->logResponse($this->NO_POLLUTION);
		
		$dto = new AirDTO;
		$dto->id = $connectionID;
		$dto->temperature = $temperature;
		$dto->pollution = $pollution;
		
		return $this->logResponse($this->airService->updateAir($dto));
	
	}
	
	public function deleteAir($airID) {
	
		$this->logService->logMessage("AirController DeleteAir");
	
		if (!isset($airID))
			return $this->logResponse($this->NO_CONNECTIONID);
		
		return $this->logResponse($this->airService->deleteAir($airID));
	
	}
	
}

?>