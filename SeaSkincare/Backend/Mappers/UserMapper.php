<?php

namespace SeaSkincare\Backend\Mappers;

use SeaSkincare\Backend\Entities;
use SeaSkincare\Backend\DTOs;

class UserMapper
{
	
	private function __construct() {}
	
	public static function EntityToDTO($entity) {
	
		$dto = new UserDTO;
		
		$dto->id = $entity->getID();
		$dto->nickname = $entity->getNickname();
		$dto->email = $entity->getEmail();
		
		return $dto;
	
	}
	
	public static function DTOToEntity($dto) {
		
		$entity = new User;
		
		self::UpdateFromDTO(&$entity, &$dto);
		
		return $entity;	
		
	}
	
	public static function UpdateFromDTO($entity, $dto) {
		
		$entity->setID($dto->id);
		$entity->setNickname($dto->nickname);
		$entity->setEmail($dto->email);
		
	}	
	
}

?>