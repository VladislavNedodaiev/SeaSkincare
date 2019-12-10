<?php

namespace SeaSkincare\Backend\Controllers;

use SeaSkincare\Backend\Data\DataRepository;
use SeaSkincare\Backend\Entities\Buoy;
use SeaSkincare\Backend\DTOs\BuoyDTO;
use SeaSkincare\Backend\Mappers\BuoyMapper;
use SeaSkincare\Backend\Services\BuoyService;
use SeaSkincare\Backend\Communication\Response;

class BuoyController
{
	
	private $dataRep;
	private $buoyService;
	
	public const NO_BUOYID = new Response("NO_BUOYID", null);
	public const SUCCESS = new Response("SUCCESS", null);
	public const NO_FABRICATIONDATE = new Response("NO_FABRICATIONDATE", null);
	public const INCORRECT_FABRICATIONDATE = new Response("INCORRECT_FABRICATIONDATE", null);
	
	
	public function __construct() {
	
		$this->dataRep = new DataRepository;

		$this->buoyService = new BuoyService(

			$this->dataRep->getHost(),
			$this->dataRep->getUser(),
			$this->dataRep->getPassword(),
			$this->dataRep->getDatabase()

		);
	
	}
	
	public function createBuoy() {
		
		return $this->buoyService->createBuoy();
		
	}
	
	public function getBuoy($buoyID) {
		
		if (!isset($buoyID))
			return self::NO_BUOYID;
		
		return $this->buoyService->getBuoy($buoyID);
		
	}
	
	public function editBuoy($buoyID, $fabricationDate) {
	
		if (!isset($buoyID))
			return self::NO_BUOYID;
		
		if (!isset($fabricationDate))
			return self::NO_FABRICATIONDATE;
		
		$fabDate = strtotime($fabricationDate);
		if (!((bool)$fabDate))
			return self::INCORRECT_FABRICATIONDATE;
		
		$dto = new BuoyDTO;
		$dto->id = $buoyID;
		$dto->fabricationDate = $fabricationDate;
		
		return $this->buoyService->updateBuoy($dto);
	
	}
	
	public function deleteBuoy($buoyID) {
	
		if (!isset($buoyID))
			return self::NO_BUOYID;
		
		return $this->buoyService->deleteBuoy($buoyID);
	
	}
	
}

?>