<?php

namespace SeaSkincare\Backend\Mappers;

use SeaSkincare\Backend\Entities;
use SeaSkincare\Backend\DTOs;

class SubscriptionMapper
{
	private function __construct() {}
	
	public static function EntityToDTO($entity) {
	
		$dto = new SubscriptionDTO;
		
		$dto->id = $entity->getID();
		$dto->buoyID = $entity->getBuoyID();
		$dto->businessID = $entity->getBusinessID();
		$dto->startDate = $entity->getStartDate();
		$dto->finishDate = $entity->getFinishDate();
		
		return $dto;
	
	}
	
	public static function DTOToEntity($dto) {
		
		$entity = new Subscription;
		
		self::UpdateFromDTO(&$entity, &$dto);
		
		return $entity;	
		
	}
	
	public static function UpdateFromDTO($entity, $dto) {
		
		$entity->setID($dto->id);
		$entity->setBuoyID($dto->buoyID);
		$entity->setBusinessID($dto->businessID);
		$entity->setStartDate($dto->startDate);
		$entity->setFinishDate($dto->finishDate);
		
	}	
	
}
?>