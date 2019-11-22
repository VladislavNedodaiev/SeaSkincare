<?php

namespace SeaSkincare\Backend\Mappers;

use SeaSkincare\Backend\Entities;
use SeaSkincare\Backend\DTOs;

class BuoyMapper implements iMapper
{
	
	private function __construct() {}
	
	public static function EntityToDTO(&$entity) {
	
		$dto = new BuoyDTO;
		
		$dto->id = $entity->getID();
		$dto->fabricationDate = $entity->getFabricationDate();
		
		return $dto;
	
	}
	
	public static function DTOToEntity(&$dto) {
		
		$entity = new Buoy;
		
		self::UpdateFromDTO($entity, $dto);
		
		return $entity;	
		
	}
	
	public static function UpdateFromDTO(&$entity, &$dto) {
		
		$entity->setID($dto->id);
		$entity->setFabricationDate($dto->fabricationDate);
		
	}	
	
}
?>