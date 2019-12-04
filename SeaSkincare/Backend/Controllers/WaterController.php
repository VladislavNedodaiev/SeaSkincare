<?php

namespace SeaSkincare\Backend\Controllers;

use SeaSkincare\Backend\Data\DataRepository;
use SeaSkincare\Backend\Entities\Water;
use SeaSkincare\Backend\DTOs\WaterDTO;
use SeaSkincare\Backend\Mappers\WaterMapper;
use SeaSkincare\Backend\Services\WaterService;
use SeaSkincare\Backend\Communication\Response;

class WaterController
{
	
	private $dataRep;
	private $waterService;
	
	public const SUCCESS = new Response("SUCCESS", null);
	public const NO_CONNECTIONID = new Response("NO_CONNECTIONID", null);
	public const NO_TEMPERATURE = new Response("NO_TEMPERATURE", null);
	public const NO_PH = new Response("NO_PH", null);
	public const NO_NACL = new Response("NO_NACL", null);
	public const NO_MGCL2 = new Response("NO_MGCL2", null);
	public const NO_MGSO4 = new Response("NO_MGSO4", null);
	public const NO_CASO4 = new Response("NO_CASO4", null);
	public const NO_NABR = new Response("NO_NABR", null);
	
	
	public function __construct() {
	
		$this->dataRep = new DataRepository;

		$this->waterService = new WaterService(

			$this->dataRep->getHost(),
			$this->dataRep->getUser(),
			$this->dataRep->getPassword(),
			$this->dataRep->getDatabase()

		);
	
	}
	
	public function createWater($connectionID, $temperature, $pH, $NaCl, $MgCl2, $MgSO4, $CaSO4, $NaBr) {
		
		if (!isset($connectionID))
			return self::NO_CONNECTIONID;
		
		if (!isset($temperature))
			return self::NO_TEMPERATURE;
		
		if (!isset($pH))
			return self::pH;
		
		if (!isset($NaCl))
			return self::NaCl;
		
		if (!isset($MgCl2))
			return self::MgCl2;
		
		if (!isset($MgSO4))
			return self::MgSO4;
		
		if (!isset($CaSO4))
			return self::CaSO4;
		
		if (!isset($NaBr))
			return self::NaBr;
		
		$dto = new WaterDTO;
		$dto->id = $connectionID;
		$dto->temperature = $temperature;
		$dto->pH = $pH;
		$dto->NaCl = $NaCl;
		$dto->MgCl2 = $MgCl2;
		$dto->MgSO4 = $MgSO4;
		$dto->CaSO4 = $CaSO4;
		$dto->NaBr = $NaBr;
		
		return $this->waterService->createWater($dto);
		
	}
	
	public function getWater($waterID) {
		
		if (!isset($waterID))
			return self::NO_CONNECTIONID;
		
		return $this->waterService->getWater($waterID);
		
	}
	
	public function editWater($connectionID, $temperature, $pH, $NaCl, $MgCl2, $MgSO4, $CaSO4, $NaBr) {
		
		if (!isset($connectionID))
			return self::NO_CONNECTIONID;
		
		if (!isset($temperature))
			return self::NO_TEMPERATURE;
		
		if (!isset($pH))
			return self::pH;
		
		if (!isset($NaCl))
			return self::NaCl;
		
		if (!isset($MgCl2))
			return self::MgCl2;
		
		if (!isset($MgSO4))
			return self::MgSO4;
		
		if (!isset($CaSO4))
			return self::CaSO4;
		
		if (!isset($NaBr))
			return self::NaBr;
		
		$dto = new WaterDTO;
		$dto->id = $connectionID;
		$dto->temperature = $temperature;
		$dto->pH = $pH;
		$dto->NaCl = $NaCl;
		$dto->MgCl2 = $MgCl2;
		$dto->MgSO4 = $MgSO4;
		$dto->CaSO4 = $CaSO4;
		$dto->NaBr = $NaBr;
		
		return $this->waterService->updateWater($dto);
	
	}
	
	public function deleteWater($waterID) {
	
		if (!isset($waterID))
			return self::NO_CONNECTIONID;
		
		return $this->waterService->deleteWater($waterID);
	
	}
	
}

?>