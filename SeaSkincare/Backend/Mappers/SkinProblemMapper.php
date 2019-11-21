<?php

namespace SeaSkincare\Backend\Mappers;

use SeaSkincare\Backend\Entities;
use SeaSkincare\Backend\DTOs;

class SkinProblemMapper
{
	private function __construct() {}
	
	public static EntityToDTO($entity) {
	
		$dto = new SkinProblemDTO;
		
		$dto->id = $entity->getID();
		$dto->title = $entity->getTitle();
		
		return $dto;
	
	}
	
	public static DTOToEntity($dto) {
		
		$entity = new SkinProblem;
		
		self::UpdateFromDTO(&$entity, &$dto);
		
		return $entity;	
		
	}
	
	public static UpdateFromDTO($entity, $dto) {
		
		$entity->setID($dto->id);
		$entity->setTitle($dto->title);
		
	}	
	
}
?>