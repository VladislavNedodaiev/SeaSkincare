<?php

namespace SeaSkincare\Backend\Mappers;

use SeaSkincare\Backend\Entities;
use SeaSkincare\Backend\DTOs;

class VacationMapper implements iMapper
{
	private function __construct() {}
	
	public static function EntityToDTO($entity) {
	
		$dto = new VacationDTO;
		
		$dto->id = $entity->getID();
		$dto->userID = $entity->getUserID();
		$dto->businessID = $entity->getBusinessID();
		$dto->startDate = $entity->getStartDate();
		$dto->finishDate = $entity->getFinishDate();
		
		return $dto;
	
	}
	
	public static function DTOToEntity($dto) {
		
		$entity = new Vacation;
		
		self::UpdateFromDTO(&$entity, &$dto);
		
		return $entity;	
		
	}
	
	public static function UpdateFromDTO($entity, $dto) {
		
		$entity->setID($dto->id);
		$entity->setUserID($dto->userID);
		$entity->setBusinessID($dto->businessID);
		$entity->setStartDate($dto->startDate);
		$entity->setFinishDate($dto->finishDate);
		
	}	
	
}
?>