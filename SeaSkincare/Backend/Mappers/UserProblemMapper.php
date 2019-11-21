<?php

namespace SeaSkincare\Backend\Mappers;

use SeaSkincare\Backend\Entities;
use SeaSkincare\Backend\DTOs;

class UserProblemMapper
{
	private function __construct() {}
	
	public static EntityToDTO($entity) {
	
		$dto = new UserProblemDTO;
		
		$dto->id = $entity->getID();
		$dto->userID = $entity->getUserID();
		$dto->skinProblemID = $entity->getSkinProblemID();
		
		return $dto;
	
	}
	
	public static DTOToEntity($dto) {
		
		$entity = new UserProblem;
		
		self::UpdateFromDTO(&$entity, &$dto);
		
		return $entity;	
		
	}
	
	public static UpdateFromDTO($entity, $dto) {
		
		$entity->setID($dto->id);
		$entity->setUserID($dto->userID);
		$entity->setSkinProblemID($dto->skinProblemID);
		
	}	
	
}
?>