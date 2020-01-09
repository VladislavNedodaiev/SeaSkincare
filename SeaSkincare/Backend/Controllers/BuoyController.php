<?php

namespace SeaSkincare\Backend\Controllers;

use SeaSkincare\Backend\Controllers\Controller;
use SeaSkincare\Backend\Services\LogService;
use SeaSkincare\Backend\Data\DataRepository;
use SeaSkincare\Backend\DTOs\BuoyDTO;
use SeaSkincare\Backend\Services\BuoyService;
use SeaSkincare\Backend\Communication\Response;

class BuoyController extends Controller
{
	
	private $buoyService;
	
	public $NO_BUOYID;
	public $SUCCESS;
	public $NO_FABRICATIONDATE;
	public $INCORRECT_FABRICATIONDATE;
	public $NO_SERIALNUMBER;
	public $NO_PASSWORD;
	public $NO_DATE;
	public $INCORRECT_DATE;
	public $NO_OFFSET;
	public $NO_LIMIT;
	
	public function __construct() {
	
		parent::__construct();
	
		$this->NO_BUOYID = new Response("NO_BUOYID", null);
		$this->SUCCESS = new Response("SUCCESS", null);
		$this->NO_FABRICATIONDATE = new Response("NO_FABRICATIONDATE", null);
		$this->INCORRECT_FABRICATIONDATE = new Response("INCORRECT_FABRICATIONDATE", null);
		$this->NO_SERIALNUMBER = new Response("NO_SERIALNUMBER", null);
		$this->NO_PASSWORD = new Response("NO_PASSWORD", null);
		$this->NO_DATE = new Response("NO_DATE", null);
		$this->INCORRECT_DATE = new Response("INCORRECT_DATE", null);
		$this->NO_OFFSET = new Response("NO_OFFSET", null);
		$this->NO_LIMIT = new Response("NO_LIMIT", null);

		$this->buoyService = new BuoyService(

			$this->dataRep->getHost(),
			$this->dataRep->getUser(),
			$this->dataRep->getPassword(),
			$this->dataRep->getDatabase(),
			$this->logService

		);
	
	}
	
	public function createBuoy() {
		
		$this->logService->logMessage("BuoyController CreateBuoy");
		
		return $this->logResponse($this->buoyService->createBuoy());
		
	}
	
	public function login($serialNumber, $password) {
	
		$this->logService->logMessage("BuoyController LoginBuoy");
	
		if (!isset($serialNumber))
			return $this->logResponse($this->NO_SERIALNUMBER);
		
		if (!isset($password))
			return $this->logResponse($this->NO_PASSWORD);
		
		return $this->logResponse($this->buoyService->login($serialNumber, $password));
	
	}
	
	public function register($serialNumber, $password) {
	
		$this->logService->logMessage("BuoyController RegisterBuoy");
	
		if (!isset($serialNumber))
			return $this->logResponse($this->NO_SERIALNUMBER);
		
		if (!isset($password))
			return $this->logResponse($this->NO_PASSWORD);
	
		return $this->logResponse($this->buoyService->register($serialNumber, $password));
	
	}
	
	public function getBuoy($buoyID) {
		
		$this->logService->logMessage("BuoyController GetBuoy");
		
		if (!isset($buoyID))
			return $this->logResponse($this->NO_BUOYID);
		
		return $this->logResponse($this->buoyService->getBuoy($buoyID));
		
	}
	
	public function getFreeBuoys($someDate, $offset, $limit) {
		
		$this->logService->logMessage("BuoyController GetFreeBuoys");
		
		if (!isset($someDate))
			return $this->logResponse($this->NO_DATE);
		
		if (!isset($offset))
			return $this->logResponse($this->NO_OFFSET);
		
		if (!isset($limit))
			return $this->logResponse($this->NO_LIMIT);
		
		if (!((bool)(strtotime($someDate))))
			return $this->logResponse($this->INCORRECT_DATE);
		
		return $this->logResponse($this->buoyService->getFreeBuoys($someDate, $offset, $limit));
		
	}
	
	public function getCount() {
		
		$this->logService->logMessage("BuoyController GetCount");
		
		return $this->logResponse($this->buoyService->getCount());
		
	}
	
	public function getCountFree($someDate) {
		
		$this->logService->logMessage("BuoyController GetCountFree");
		
		if (!isset($someDate))
			return $this->logResponse($this->NO_DATE);
		
		if (!((bool)(strtotime($someDate))))
			return $this->logResponse($this->INCORRECT_DATE);
		
		return $this->logResponse($this->buoyService->getCountFree($someDate));
		
	}
	
	public function editBuoy($buoyID, $fabricationDate) {
		
		$this->logService->logMessage("BuoyController EditBuoy");
	
		if (!isset($buoyID))
			return $this->logResponse($this->NO_BUOYID);
		
		if (!isset($fabricationDate))
			return $this->logResponse($this->NO_FABRICATIONDATE);
		
		$fabDate = strtotime($fabricationDate);
		if (!((bool)$fabDate))
			return $this->logResponse($this->INCORRECT_FABRICATIONDATE);
		
		$dto = new BuoyDTO;
		$dto->id = $buoyID;
		$dto->fabricationDate = $fabricationDate;
		
		return $this->logResponse($this->buoyService->updateBuoy($dto));
	
	}
	
	public function deleteBuoy($buoyID) {
	
		$this->logService->logMessage("BuoyController DeleteBuoy");
	
		if (!isset($buoyID))
			return $this->logResponse($this->NO_BUOYID);
		
		return $this->logResponse($this->buoyService->deleteBuoy($buoyID));
	
	}
	
}

?>