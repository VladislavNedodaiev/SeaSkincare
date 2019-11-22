<?php

namespace SeaSkincare\Backend\Mappers;

use SeaSkincare\Backend\Entities;
use SeaSkincare\Backend\DTOs;

class UserMapper
{
	
	private function __construct() {}
	
	public static function EntityToDTO(&$entity) {
	
		$dto = new UserDTO;
		
		$dto->id = $entity->getID();
		$dto->password = $entity->getPassword();
		$dto->nickname = $entity->getNickname();
		$dto->email = $entity->getEmail();
		$dto->verification = $entity->getVerification();
		
		return $dto;
	
	}
	
	public static function DTOToEntity(&$dto) {
		
		$entity = new User;
		
		self::UpdateFromDTO($entity, $dto);
		
		return $entity;	
		
	}
	
	public static function UpdateFromDTO(&$entity, &$dto) {
		
		$entity->setID($dto->id);
		$entity->setPassword($dto->password);
		$entity->setNickname($dto->nickname);
		$entity->setEmail($dto->email);
		$entity->setVerification($dto->verification);
		
	}	
	
}

?>