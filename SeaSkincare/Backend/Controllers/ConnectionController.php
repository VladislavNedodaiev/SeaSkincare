<?php

namespace SeaSkincare\Backend\Controllers;

use SeaSkincare\Backend\Controllers\Controller;
use SeaSkincare\Backend\Services\LogService;
use SeaSkincare\Backend\Data\DataRepository;
use SeaSkincare\Backend\DTOs\ConnectionDTO;
use SeaSkincare\Backend\Services\ConnectionService;
use SeaSkincare\Backend\Communication\Response;

class ConnectionController extends Controller
{
	
	private $connectionService;
	
	public $SUCCESS;
	public $NO_CONNECTIONID;
	public $NO_BUOYID;
	public $NO_LATITUDE;
	public $NO_LONGITUDE;
	public $NO_BATTERY;
	
	public function __construct() {
	
		parent::__construct();
	
		$this->SUCCESS = new Response("SUCCESS", null);
		$this->NO_CONNECTIONID = new Response("NO_CONNECTIONID", null);
		$this->NO_BUOYID = new Response("NO_BUOYID", null);
		$this->NO_LATITUDE = new Response("NO_LATITUDE", null);
		$this->NO_LONGITUDE = new Response("NO_LONGITUDE", null);
		$this->NO_BATTERY = new Response("NO_BATTERY", null);

		$this->connectionService = new ConnectionService(

			$this->dataRep->getHost(),
			$this->dataRep->getUser(),
			$this->dataRep->getPassword(),
			$this->dataRep->getDatabase(),
			$this->logService

		);
	
	}
	
	public function createConnection($buoyID, $latitude, $longitude, $battery) {
		
		$this->logService->logMessage("ConnectionController CreateConnection");
		
		if (!isset($buoyID))
			return $this->logResponse($this->NO_BUOYID);
		
		if (!isset($latitude))
			return $this->logResponse($this->NO_LATITUDE);
		
		if (!isset($longitude))
			return $this->logResponse($this->NO_LONGITUDE);
		
		if (!isset($battery))
			return $this->logResponse($this->NO_BATTERY);
		
		$dto = new ConnectionDTO;
		$dto->buoyID = $buoyID;
		$dto->latitude = $latitude;
		$dto->longitude = $longitude;
		$dto->battery = $battery;
		
		return $this->logResponse($this->connectionService->createConnection($dto));
		
	}
	
	public function getConnection($connectionID) {
		
		$this->logService->logMessage("ConnectionController GetConnection");
		
		if (!isset($connectionID))
			return $this->logResponse($this->NO_CONNECTIONID);
		
		return $this->logResponse($this->connectionService->getConnection($connectionID));
		
	}
	
	public function getBuoyConnections($buoyID) {
		
		$this->logService->logMessage("ConnectionController GetBuoyConnections");
		
		if (!isset($buoyID))
			return $this->logResponse($this->NO_BUOYID);
		
		return $this->logResponse($this->connectionService->getBuoyConnections($buoyID));
		
	}
	
	public function getLastConnection() {
		
		$this->logService->logMessage("ConnectionController GetLastConnection");
		
		$connectionID = $this->connectionService->getLastID();
		if ($connectionID->status != $this->connectionService->SUCCESS->status)
			return $this->logResponse($connectionID);
		
		return $this->logResponse($this->connectionService->getConnection($connectionID->content));
		
	}
	
	public function getLastConnectionByBuoy($buoyID) {
		
		$this->logService->logMessage("ConnectionController GetLastConnectionByBuoy");
		
		$connectionID = $this->connectionService->getLastIDByBuoy($buoyID);
		if ($connectionID->status != $this->connectionService->SUCCESS->status)
			return $this->logResponse($connectionID);
		
		return $this->logResponse($this->connectionService->getConnection($connectionID->content));
		
	}
	
	public function editConnection($connectionID, $latitude, $longitude, $battery) {
	
		$this->logService->logMessage("ConnectionController EditConnection");
	
		if (!isset($connectionID))
			return $this->logResponse($this->NO_CONNECTIONID);
		
		if (!isset($latitude))
			return $this->logResponse($this->NO_LATITUDE);
		
		if (!isset($longitude))
			return $this->logResponse($this->NO_LONGITUDE);
		
		if (!isset($battery))
			return $this->logResponse($this->NO_BATTERY);
		
		$dto = new ConnectionDTO;
		$dto->id = $connectionID;
		$dto->latitude = $latitude;
		$dto->longitude = $longitude;
		$dto->battery = $battery;
		
		return $this->logResponse($this->connectionService->updateConnection($dto));
	
	}
	
	public function deleteConnection($connectionID) {
	
		$this->logService->logMessage("ConnectionController DeleteConnection");
	
		if (!isset($connectionID))
			return $this->logResponse($this->NO_CONNECTIONID);
		
		return $this->logResponse($this->connectionService->deleteConnection($connectionID));
	
	}
	
}

?>