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
	
	public const SUCCESS = new Response("SUCCESS", null);
	public const NO_CONNECTIONID = new Response("NO_CONNECTIONID", null);
	public const NO_TEMPERATURE = new Response("NO_TEMPERATURE", null);
	public const NO_POLLUTION = new Response("NO_POLLUTION", null);
	
	
	public function __construct() {
	
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
			return self::NO_CONNECTIONID;
		
		if (!isset($temperature))
			return self::NO_TEMPERATURE;
		
		if (!isset($pollution))
			return self::NO_POLLUTION;
		
		$dto = AirDTO;
		$dto->id = $connectionID;
		$dto->temperature = $temperature;
		$dto->pollution = $pollution;
		
		return $this->airService->createAir($dto);
		
	}
	
	public function getAir($airID) {
		
		if (!isset($airID))
			return self::NO_CONNECTIONID;
		
		return $this->airService->getAir($airID);
		
	}
	
	public function editAir($connectionID, $temperature, $pollution) {
	
		if (!isset($connectionID))
			return self::NO_CONNECTIONID;
		
		if (!isset($temperature))
			return self::NO_TEMPERATURE;
		
		if (!isset($pollution))
			return self::NO_POLLUTION;
		
		$dto = AirDTO;
		$dto->id = $connectionID;
		$dto->temperature = $temperature;
		$dto->pollution = $pollution;
		
		return $this->airService->updateAir($dto);
	
	}
	
	public function deleteAir($airID) {
	
		if (!isset($airID))
			return self::NO_CONNECTIONID;
		
		return $this->airService->deleteAir($airID);
	
	}
	
}

?>