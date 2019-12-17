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
	
	public $SUCCESS = new Response("SUCCESS", null);
	public $NO_CONNECTIONID = new Response("NO_CONNECTIONID", null);
	public $NO_SUNPOWER = new Response("NO_SUNPOWER", null);
	public $NO_WINDSPEED = new Response("NO_WINDSPEED", null);
	
	
	public function __construct() {
	
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
			return$this->NO_CONNECTIONID;
		
		if (!isset($sunPower))
			return$this->NO_TEMPERATURE;
		
		if (!isset($windSpeed))
			return$this->NO_POLLUTION;
		
		$dto = new WeatherDTO;
		$dto->id = $connectionID;
		$dto->sunPower = $sunPower;
		$dto->windSpeed = $windSpeed;
		
		return $this->weatherService->createWeather($dto);
		
	}
	
	public function getWeather($weatherID) {
		
		if (!isset($weatherID))
			return$this->NO_CONNECTIONID;
		
		return $this->weatherService->getWeather($weatherID);
		
	}
	
	public function editWeather($connectionID, $temperature, $pollution) {
	
		if (!isset($connectionID))
			return$this->NO_CONNECTIONID;
		
		if (!isset($sunPower))
			return$this->NO_TEMPERATURE;
		
		if (!isset($windSpeed))
			return$this->NO_POLLUTION;
		
		$dto = new WeatherDTO;
		$dto->id = $connectionID;
		$dto->sunPower = $sunPower;
		$dto->windSpeed = $windSpeed;
		
		return $this->weatherService->updateWeather($dto);
	
	}
	
	public function deleteWeather($weatherID) {
	
		if (!isset($weatherID))
			return$this->NO_CONNECTIONID;
		
		return $this->weatherService->deleteWeather($weatherID);
	
	}
	
}

?>