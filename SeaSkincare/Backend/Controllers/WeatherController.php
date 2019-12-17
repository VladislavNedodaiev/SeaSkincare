<?php

namespace SeaSkincare\Backend\Controllers;

use SeaSkincare\Backend\Data\DataRepository;
use SeaSkincare\Backend\Entities\Weather;
use SeaSkincare\Backend\DTOs\WeatherDTO;
use SeaSkincare\Backend\Mappers\WeatherMapper;
use SeaSkincare\Backend\Services\WeatherService;
use SeaSkincare\Backend\Communication\Response;

class WeatherController
{
	
	private $dataRep;
	private $weatherService;
	
	public $SUCCESS;
	public $NO_CONNECTIONID;
	public $NO_SUNPOWER;
	public $NO_WINDSPEED;
	
	
	public function __construct() {
	
		$SUCCESS = new Response("SUCCESS", null);
		$NO_CONNECTIONID = new Response("NO_CONNECTIONID", null);
		$NO_SUNPOWER = new Response("NO_SUNPOWER", null);
		$NO_WINDSPEED = new Response("NO_WINDSPEED", null);
		
		$this->dataRep = new DataRepository;

		$this->weatherService = new WeatherService(

			$this->dataRep->getHost(),
			$this->dataRep->getUser(),
			$this->dataRep->getPassword(),
			$this->dataRep->getDatabase()

		);
	
	}
	
	public function createWeather($connectionID, $sunPower, $windSpeed) {
		
		if (!isset($connectionID))
			return $this->NO_CONNECTIONID;
		
		if (!isset($sunPower))
			return $this->NO_TEMPERATURE;
		
		if (!isset($windSpeed))
			return $this->NO_POLLUTION;
		
		$dto = new WeatherDTO;
		$dto->id = $connectionID;
		$dto->sunPower = $sunPower;
		$dto->windSpeed = $windSpeed;
		
		return $this->weatherService->createWeather($dto);
		
	}
	
	public function getWeather($weatherID) {
		
		if (!isset($weatherID))
			return $this->NO_CONNECTIONID;
		
		return $this->weatherService->getWeather($weatherID);
		
	}
	
	public function editWeather($connectionID, $temperature, $pollution) {
	
		if (!isset($connectionID))
			return $this->NO_CONNECTIONID;
		
		if (!isset($sunPower))
			return $this->NO_TEMPERATURE;
		
		if (!isset($windSpeed))
			return $this->NO_POLLUTION;
		
		$dto = new WeatherDTO;
		$dto->id = $connectionID;
		$dto->sunPower = $sunPower;
		$dto->windSpeed = $windSpeed;
		
		return $this->weatherService->updateWeather($dto);
	
	}
	
	public function deleteWeather($weatherID) {
	
		if (!isset($weatherID))
			return $this->NO_CONNECTIONID;
		
		return $this->weatherService->deleteWeather($weatherID);
	
	}
	
}

?>