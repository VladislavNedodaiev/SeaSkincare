<?php

namespace SeaSkincare\Backend\Mappers;

use SeaSkincare\Backend\Entities;
use SeaSkincare\Backend\DTOs;

class BusinessMapper
{
	
	private function __construct() {}
	
	public static function EntityToDTO($entity) {
	
		$dto = new BusinessDTO;
		
		$dto->id = $entity->getID();
		$dto->nickname = $entity->getNickname();
		$dto->description = $entity->getDescription();
		$dto->photo = $entity->getPhoto();
		$dto->email = $entity->getEmail();
		
		return $dto;
	
	}
	
	public static function DTOToEntity($dto) {
		
		$entity = new Business;
		
		self::UpdateFromDTO(&$entity, &$dto);
		
		return $entity;	
		
	}
	
	public static function UpdateFromDTO($entity, $dto) {
		
		$entity->setID($dto->id);
		$entity->setNickname($dto->nickname);
		$entity->setDescription($dto->description);
		$entity->setPhoto($dto->photo);
		$entity->setEmail($dto->email);
		
	}	
	
}
?>