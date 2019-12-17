<?php

namespace SeaSkincare\Backend\Controllers;

use SeaSkincare\Backend\Data\DataRepository;
use SeaSkincare\Backend\Entities\Connection;
use SeaSkincare\Backend\DTOs\ConnectionDTO;
use SeaSkincare\Backend\Mappers\ConnectionMapper;
use SeaSkincare\Backend\Services\ConnectionService;
use SeaSkincare\Backend\Communication\Response;

class ConnectionController
{
	
	private $dataRep;
	private $connectionService;
	
	public $SUCCESS = new Response("SUCCESS", null);
	public $NO_CONNECTIONID = new Response("NO_CONNECTIONID", null);
	public $NO_BUOYID = new Response("NO_BUOYID", null);
	public $NO_LATITUDE = new Response("NO_LATITUDE", null);
	public $NO_LONGITUDE = new Response("NO_LONGITUDE", null);
	public $NO_BATTERY = new Response("NO_BATTERY", null);
	
	
	public function __construct() {
	
		$this->dataRep = new DataRepository;

		$this->connectionService = new ConnectionService(

			$this->dataRep->getHost(),
			$this->dataRep->getUser(),
			$this->dataRep->getPassword(),
			$this->dataRep->getDatabase()

		);
	
	}
	
	public function createConnection($buoyID, $latitude, $longitude, $battery) {
		
		if (!isset($buoyID))
			return this->NO_BUOYID;
		
		if (!isset($latitude))
			return this->NO_LATITUDE;
		
		if (!isset($longitude))
			return this->NO_LONGITUDE;
		
		if (!isset($battery))
			return this->NO_BATTERY;
		
		$dto = new ConnectionDTO;
		$dto->buoyID = $buoyID;
		$dto->latitude = $latitude;
		$dto->longitude = $longitude;
		$dto->battery = $battery;
		
		return $this->connectionService->createConnection($dto);
		
	}
	
	public function getConnection($connectionID) {
		
		if (!isset($connectionID))
			return this->NO_CONNECTIONID;
		
		return $this->connectionService->getConnection($connectionID);
		
	}
	
	public function getBuoyConnections($buoyID) {
		
		if (!isset($buoyID))
			return this->NO_BUOYID;
		
		return $this->connectionService->getBuoyConnections($buoyID);
		
	}
	
	public function getLastConnection() {
		
		$connectionID = $this->connectionService->getLastID();
		if ($connectionID->status != ConnectionService::SUCCESS->status)
			return $connectionID;
		
		return $this->connectionService->getConnection($connectionID->content);
		
	}
	
	public function getLastConnectionByBuoy($buoyID) {
		
		$connectionID = $this->connectionService->getLastIDByBuoy($buoyID);
		if ($connectionID->status != ConnectionService::SUCCESS->status)
			return $connectionID;
		
		return $this->connectionService->getConnection($connectionID->content);
		
	}
	
	public function editConnection($connectionID, $latitude, $longitude, $battery) {
	
		if (!isset($connectionID))
			return this->NO_CONNECTIONID;
		
		if (!isset($latitude))
			return this->NO_LATITUDE;
		
		if (!isset($longitude))
			return this->NO_LONGITUDE;
		
		if (!isset($battery))
			return this->NO_BATTERY;
		
		$dto = new ConnectionDTO;
		$dto->id = $connectionID;
		$dto->latitude = $latitude;
		$dto->longitude = $longitude;
		$dto->battery = $battery;
		
		return $this->connectionService->updateConnection($dto);
	
	}
	
	public function deleteConnection($connectionID) {
	
		if (!isset($connectionID))
			return this->NO_CONNECTIONID;
		
		return $this->connectionService->deleteConnection($connectionID);
	
	}
	
}

?>