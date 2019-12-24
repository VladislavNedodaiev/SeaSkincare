<?php

namespace SeaSkincare\Backend\Controllers;

use SeaSkincare\Backend\Data\DataRepository;
use SeaSkincare\Backend\DTOs\BuoyDTO;
use SeaSkincare\Backend\Services\BuoyService;
use SeaSkincare\Backend\Communication\Response;

class BuoyController
{
	
	private $dataRep;
	private $buoyService;
	
	public $NO_BUOYID;
	public $SUCCESS;
	public $NO_FABRICATIONDATE;
	public $INCORRECT_FABRICATIONDATE;
	public $NO_SERIALNUMBER;
	public $NO_PASSWORD;
	
	
	public function __construct() {
	
		$this->NO_BUOYID = new Response("NO_BUOYID", null);
		$this->SUCCESS = new Response("SUCCESS", null);
		$this->NO_FABRICATIONDATE = new Response("NO_FABRICATIONDATE", null);
		$this->INCORRECT_FABRICATIONDATE = new Response("INCORRECT_FABRICATIONDATE", null);
		$this->NO_SERIALNUMBER = new Response("NO_SERIALNUMBER", null);
		$this->NO_PASSWORD = new Response("NO_PASSWORD", null);
	
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
	
	public function login($serialNumber, $password) {
	
		if (!isset($serialNumber))
			return $this->NO_SERIALNUMBER;
		
		if (!isset($password))
			return $this->NO_PASSWORD;
	
		return $this->buoyService->login($serialNumber, $password);
	
	}
	
	public function register($serialNumber, $password) {
	
		if (!isset($serialNumber))
			return $this->NO_SERIALNUMBER;
		
		if (!isset($password))
			return $this->NO_PASSWORD;
	
		return $this->buoyService->register($serialNumber, $password);
	
	}
	
	public function getBuoy($buoyID) {
		
		if (!isset($buoyID))
			return $this->NO_BUOYID;
		
		return $this->buoyService->getBuoy($buoyID);
		
	}
	
	public function editBuoy($buoyID, $fabricationDate) {
	
		if (!isset($buoyID))
			return $this->NO_BUOYID;
		
		if (!isset($fabricationDate))
			return $this->NO_FABRICATIONDATE;
		
		$fabDate = strtotime($fabricationDate);
		if (!((bool)$fabDate))
			return $this->INCORRECT_FABRICATIONDATE;
		
		$dto = new BuoyDTO;
		$dto->id = $buoyID;
		$dto->fabricationDate = $fabricationDate;
		
		return $this->buoyService->updateBuoy($dto);
	
	}
	
	public function deleteBuoy($buoyID) {
	
		if (!isset($buoyID))
			return $this->NO_BUOYID;
		
		return $this->buoyService->deleteBuoy($buoyID);
	
	}
	
}

?>