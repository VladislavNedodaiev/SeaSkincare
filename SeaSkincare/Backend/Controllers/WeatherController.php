<?php

namespace SeaSkincare\Backend\Controllers;

use SeaSkincare\Backend\Controllers\Controller;
use SeaSkincare\Backend\Services\LogService;
use SeaSkincare\Backend\Data\DataRepository;
use SeaSkincare\Backend\DTOs\WeatherDTO;
use SeaSkincare\Backend\Services\WeatherService;
use SeaSkincare\Backend\Communication\Response;

class WeatherController extends Controller
{
	
	private $weatherService;
	
	public $SUCCESS;
	public $NO_CONNECTIONID;
	public $NO_SUNPOWER;
	public $NO_WINDSPEED;
	
	
	public function __construct() {
	
		parent::__construct();
	
		$this->SUCCESS = new Response("SUCCESS", null);
		$this->NO_CONNECTIONID = new Response("NO_CONNECTIONID", null);
		$this->NO_SUNPOWER = new Response("NO_SUNPOWER", null);
		$this->NO_WINDSPEED = new Response("NO_WINDSPEED", null);

		$this->weatherService = new WeatherService(

			$this->dataRep->getHost(),
			$this->dataRep->getUser(),
			$this->dataRep->getPassword(),
			$this->dataRep->getDatabase(),
			$this->logService

		);
	
	}
	
	public function createWeather($connectionID, $sunPower, $windSpeed) {
		
		$this->logService->logMessage("WeatherController CreateWeather");
		
		if (!isset($connectionID))
			return $this->logResponse($this->NO_CONNECTIONID);
		
		if (!isset($sunPower))
			return $this->logResponse($this->NO_SUNPOWER);
		
		if (!isset($windSpeed))
			return $this->logResponse($this->NO_WINDSPEED);
		
		$dto = new WeatherDTO;
		$dto->id = $connectionID;
		$dto->sunPower = $sunPower;
		$dto->windSpeed = $windSpeed;
		
		return $this->logResponse($this->weatherService->createWeather($dto));
		
	}
	
	public function getWeather($weatherID) {
		
		$this->logService->logMessage("WeatherController GetWeather");
		
		if (!isset($weatherID))
			return $this->logResponse($this->NO_CONNECTIONID);
		
		return $this->logResponse($this->weatherService->getWeather($weatherID));
		
	}
	
	public function editWeather($connectionID, $temperature, $pollution) {
	
		$this->logService->logMessage("WeatherController EditWeather");
		
		if (!isset($connectionID))
			return $this->logResponse($this->NO_CONNECTIONID);
		
		if (!isset($sunPower))
			return $this->logResponse($this->NO_SUNPOWER);
		
		if (!isset($windSpeed))
			return $this->logResponse($this->NO_WINDSPEED);
		
		$dto = new WeatherDTO;
		$dto->id = $connectionID;
		$dto->sunPower = $sunPower;
		$dto->windSpeed = $windSpeed;
		
		return $this->logResponse($this->weatherService->updateWeather($dto));
	
	}
	
	public function deleteWeather($weatherID) {
	
		$this->logService->logMessage("WeatherController DeleteWeather");
	
		if (!isset($weatherID))
			return $this->logResponse($this->NO_CONNECTIONID);
		
		return $this->logResponse($this->weatherService->deleteWeather($weatherID));
	
	}
	
}

?>