<?php

namespace SeaSkincare\Backend\Mappers;

use SeaSkincare\Backend\Entities;
use SeaSkincare\Backend\DTOs;

class BuoyMapper
{
	
	private function __construct() {}
	
	public static EntityToDTO($entity) {
	
		$dto = new BuoyDTO;
		
		$dto->id = $entity->getID();
		$dto->fabricationDate = $entity->getFabricationDate();
		
		return $dto;
	
	}
	
	public static DTOToEntity($dto) {
		
		$entity = new Buoy;
		
		self::UpdateFromDTO(&$entity, &$dto);
		
		return $entity;	
		
	}
	
	public static UpdateFromDTO($entity, $dto) {
		
		$entity->setID($dto->id);
		$entity->setFabricationDate($dto->fabricationDate);
		
	}	
	
}
?>