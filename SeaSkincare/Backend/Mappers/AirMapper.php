<?php

namespace SeaSkincare\Backend\Mappers;

use SeaSkincare\Backend\Entities;
use SeaSkincare\Backend\DTOs;

class AirMapper implements iMapper
{
	
	private function __construct() {}
	
	public static function EntityToDTO($entity) {
	
		$dto = new AirDTO;
		
		$dto->id = $entity->getID();
		$dto->temperature = $entity->getTemperature();
		$dto->pollution = $entity->getPollution();
		
		return $dto;
	
	}
	
	public static function DTOToEntity($dto) {
		
		$entity = new Air;
		
		self::UpdateFromDTO(&$entity, &$dto);
		
		return $entity;	
		
	}
	
	public static function UpdateFromDTO($entity, $dto) {
		
		$entity->setID($dto->id);
		$entity->setTemperature($dto->temperature);
		$entity->setPollution($dto->pollution);
		
	}	
	
}
?>