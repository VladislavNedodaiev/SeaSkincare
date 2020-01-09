<?php

namespace SeaSkincare\Backend\Controllers;

use SeaSkincare\Backend\Controllers\Controller;
use SeaSkincare\Backend\Services\LogService;
use SeaSkincare\Backend\Data\DataRepository;
use SeaSkincare\Backend\DTOs\WaterDTO;
use SeaSkincare\Backend\Services\WaterService;
use SeaSkincare\Backend\Communication\Response;

class WaterController extends Controller
{
	
	private $waterService;
	
	public $SUCCESS;
	public $NO_CONNECTIONID;
	public $NO_TEMPERATURE;
	public $NO_PH;
	public $NO_NACL;
	public $NO_MGCL2;
	public $NO_MGSO4;
	public $NO_CASO4;
	public $NO_NABR;
	
	
	public function __construct() {
		
		parent::__construct();
		
		$this->SUCCESS = new Response("SUCCESS", null);
		$this->NO_CONNECTIONID = new Response("NO_CONNECTIONID", null);
		$this->NO_TEMPERATURE = new Response("NO_TEMPERATURE", null);
		$this->NO_PH = new Response("NO_PH", null);
		$this->NO_NACL = new Response("NO_NACL", null);
		$this->NO_MGCL2 = new Response("NO_MGCL2", null);
		$this->NO_MGSO4 = new Response("NO_MGSO4", null);
		$this->NO_CASO4 = new Response("NO_CASO4", null);
		$this->NO_NABR = new Response("NO_NABR", null);

		$this->waterService = new WaterService(

			$this->dataRep->getHost(),
			$this->dataRep->getUser(),
			$this->dataRep->getPassword(),
			$this->dataRep->getDatabase(),
			$this->logService

		);
	
	}
	
	public function createWater($connectionID, $temperature, $pH, $NaCl, $MgCl2, $MgSO4, $CaSO4, $NaBr) {
		
		$this->logService->logMessage("WaterController CreateWater");
		
		if (!isset($connectionID))
			return $this->logResponse($this->NO_CONNECTIONID);
		
		if (!isset($temperature))
			return $this->logResponse($this->NO_TEMPERATURE);
		
		if (!isset($pH))
			return $this->logResponse($this->NO_PH);
		
		if (!isset($NaCl))
			return $this->logResponse($this->NO_NACL);
		
		if (!isset($MgCl2))
			return $this->logResponse($this->NO_MGCL2);
		
		if (!isset($MgSO4))
			return $this->logResponse($this->NO_MGSO4);
		
		if (!isset($CaSO4))
			return $this->logResponse($this->NO_CASO4);
		
		if (!isset($NaBr))
			return $this->logResponse($this->NO_NABR);
		
		$dto = new WaterDTO;
		$dto->id = $connectionID;
		$dto->temperature = $temperature;
		$dto->pH = $pH;
		$dto->NaCl = $NaCl;
		$dto->MgCl2 = $MgCl2;
		$dto->MgSO4 = $MgSO4;
		$dto->CaSO4 = $CaSO4;
		$dto->NaBr = $NaBr;
		
		return $this->logResponse($this->waterService->createWater($dto));
		
	}
	
	public function getWater($waterID) {
		
		$this->logService->logMessage("WaterController GetWater");
		
		if (!isset($waterID))
			return $this->logResponse($this->NO_CONNECTIONID);
		
		return $this->logResponse($this->waterService->getWater($waterID));
		
	}
	
	public function editWater($connectionID, $temperature, $pH, $NaCl, $MgCl2, $MgSO4, $CaSO4, $NaBr) {
		
		$this->logService->logMessage("WaterController EditWater");
		
		if (!isset($connectionID))
			return $this->logResponse($this->NO_CONNECTIONID);
		
		if (!isset($temperature))
			return $this->logResponse($this->NO_TEMPERATURE);
		
		if (!isset($pH))
			return $this->logResponse($this->NO_PH);
		
		if (!isset($NaCl))
			return $this->logResponse($this->NO_NACL);
		
		if (!isset($MgCl2))
			return $this->logResponse($this->NO_MGCL2);
		
		if (!isset($MgSO4))
			return $this->logResponse($this->NO_MGSO4);
		
		if (!isset($CaSO4))
			return $this->logResponse($this->NO_CASO4);
		
		if (!isset($NaBr))
			return $this->logResponse($this->NO_NABR);
		
		$dto = new WaterDTO;
		$dto->id = $connectionID;
		$dto->temperature = $temperature;
		$dto->pH = $pH;
		$dto->NaCl = $NaCl;
		$dto->MgCl2 = $MgCl2;
		$dto->MgSO4 = $MgSO4;
		$dto->CaSO4 = $CaSO4;
		$dto->NaBr = $NaBr;
		
		return $this->logResponse($this->waterService->updateWater($dto));
	
	}
	
	public function deleteWater($waterID) {
	
		$this->logService->logMessage("WaterController DeleteWater");
	
		if (!isset($waterID))
			return $this->logResponse($this->NO_CONNECTIONID);
		
		return $this->logResponse($this->waterService->deleteWater($waterID));
	
	}
	
}

?>