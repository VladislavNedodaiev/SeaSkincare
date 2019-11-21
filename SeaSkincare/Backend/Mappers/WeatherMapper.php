<?php

namespace SeaSkincare\Backend\Mappers;

use SeaSkincare\Backend\Entities;
use SeaSkincare\Backend\DTOs;

class WeatherMapper implements iMapper
{
	private function __construct() {}
	
	public static function EntityToDTO($entity) {
	
		$dto = new WeatherDTO;
		
		$dto->id = $entity->getID();
		$dto->sunPower = $entity->getSunPower();
		$dto->windSpeed = $entity->getWindSpeed();
		
		return $dto;
	
	}
	
	public static function DTOToEntity($dto) {
		
		$entity = new Weather;
		
		self::UpdateFromDTO(&$entity, &$dto);
		
		return $entity;	
		
	}
	
	public static function UpdateFromDTO($entity, $dto) {
		
		$entity->setID($dto->id);
		$entity->setSunPower($dto->sunPower);
		$entity->setWindSpeed($dto->windSpeed);
		
	}	
	
}
?>