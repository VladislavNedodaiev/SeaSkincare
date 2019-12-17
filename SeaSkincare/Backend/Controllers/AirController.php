<?php

namespace SeaSkincare\Backend\Controllers;

use SeaSkincare\Backend\Data\DataRepository;
use SeaSkincare\Backend\Entities\Air;
use SeaSkincare\Backend\DTOs\AirDTO;
use SeaSkincare\Backend\Mappers\AirMapper;
use SeaSkincare\Backend\Services\AirService;
use SeaSkincare\Backend\Communication\Response;

class AirController
{
	
	private $dataRep;
	private $airService;
	
	public $SUCCESS;
	public $NO_CONNECTIONID;
	public $NO_TEMPERATURE;
	public $NO_POLLUTION;
	
	
	public function __construct() {
	
		$SUCCESS = new Response("SUCCESS", null);
		$NO_CONNECTIONID = new Response("NO_CONNECTIONID", null);
		$NO_TEMPERATURE = new Response("NO_TEMPERATURE", null);
		$NO_POLLUTION = new Response("NO_POLLUTION", null);
	
		$this->dataRep = new DataRepository;

		$this->airService = new AirService(

			$this->dataRep->getHost(),
			$this->dataRep->getUser(),
			$this->dataRep->getPassword(),
			$this->dataRep->getDatabase()

		);
	
	}
	
	public function createAir($connectionID, $temperature, $pollution) {
		
		if (!isset($connectionID))
			return $this->NO_CONNECTIONID;
		
		if (!isset($temperature))
			return $this->NO_TEMPERATURE;
		
		if (!isset($pollution))
			return $this->NO_POLLUTION;
		
		$dto = new AirDTO;
		$dto->id = $connectionID;
		$dto->temperature = $temperature;
		$dto->pollution = $pollution;
		
		return $this->airService->createAir($dto);
		
	}
	
	public function getAir($airID) {
		
		if (!isset($airID))
			return $this->NO_CONNECTIONID;
		
		return $this->airService->getAir($airID);
		
	}
	
	public function editAir($connectionID, $temperature, $pollution) {
	
		if (!isset($connectionID))
			return $this->NO_CONNECTIONID;
		
		if (!isset($temperature))
			return $this->NO_TEMPERATURE;
		
		if (!isset($pollution))
			return $this->NO_POLLUTION;
		
		$dto = new AirDTO;
		$dto->id = $connectionID;
		$dto->temperature = $temperature;
		$dto->pollution = $pollution;
		
		return $this->airService->updateAir($dto);
	
	}
	
	public function deleteAir($airID) {
	
		if (!isset($airID))
			return $this->NO_CONNECTIONID;
		
		return $this->airService->deleteAir($airID);
	
	}
	
}

?>