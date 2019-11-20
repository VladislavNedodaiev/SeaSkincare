<?php

namespace SeaSkincare\Backend\Mappers;

use SeaSkincare\Backend\Entities;
use SeaSkincare\Backend\DTOs;

class AirMapper
{
	
	private function __construct() {}
	
	public static EntityToDTO($entity) {
	
		$dto = new BusinessDTO;
		
		$dto->id = $entity->getID();
		$dto->temperature = $entity->getTemperature();
		$dto->pollution = $entity->getPollution();
		
		return $dto;
	
	}
	
	public static DTOToEntity($dto) {
		
		$entity = new Business;
		
		self::UpdateFromDTO(&$entity, &$dto);
		
		return $entity;	
		
	}
	
	public static UpdateFromDTO($entity, $dto) {
		
		$entity->setID($dto->id);
		$entity->setTemperature($dto->temperature);
		$entity->setPollution($dto->pollution);
		
	}	
	
}
?>